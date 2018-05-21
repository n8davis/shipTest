<?php
/**
 * Created by PhpStorm.
 * User: nate
 * Date: 12/23/17
 * Time: 4:43 PM
 */

namespace ShipFree\Controller;

use ShipFree\Model\Markup;
use ShipFree\Model\TeelaunchMaster;
use ShipFree\Assist;
use ShipFree\Shopify\Auth;
use ShipFree\Shopify\CarrierService\Rate;
use ShipFree\Model\Country;
use ShipFree\Shopify\CarrierService;
use Monolog\Logger;
use ShipFree\Model\ShippingZone;
use ShipFree\Shopify\Product;
use ShipFree\Shopify\Shop;
use ShipFree\ShipFree;
use PHPShopify\ShopifySDK;
use ShipFree\Helper;
use PHPShopify\AuthHelper;
use ShipFree\Model\Rule;
use ShipFree\Model\ShopOwner;
use ShipFree\Shopify\Webhook;
use \Slim\Views\Twig;
use  \ShipFree\Security;
class ShopifyController
{
    protected $view;
    protected $logger;

    public function __construct( Twig $view , Logger $logger ) {
        $this->view = $view;
        $this->logger = $logger;
    }

    public function getHeaders()
    {
        $shop = null;
        $topic = null;
        $hmac_header = null;
        foreach (getallheaders() as $name => $value) {

            if ($name == 'X-Shopify-Shop-Domain') {
                $shop   =  trim($value);
            }
            if ($name == 'X-Shopify-Topic') {
                $topic = trim($value);
            }
            if ($name == 'X-Shopify-Hmac-Sha256') {
                $hmac_header = trim($value);
            }

        }
        return [
            'shop' => $shop,
            'topic' => $topic ,
            'hmac'=> $hmac_header
        ];
    }

    public function shipping_rates($request, $response, $args)
    {
        $shopifyRates = [];
        $data         = file_get_contents('php://input');
        $shopifyData  = json_decode( trim( $data ) );
        $header       = $this->getHeaders();
        $this->logger->addInfo( 'Rates coming from Shopify: ' ) ;
        $this->logger->addInfo( $data ) ;

        $shop = $header[ 'shop' ];//'teelaunchtesting.myshopify.com';
        if( is_null( $shop ) ) {
            header( 200 );
            exit;
        }
        $incomingRate = $shopifyData->rate;
        $items        = $incomingRate->items;

        // find which zone to use based on destination country
        $destinationCountry = $incomingRate->destination->country;

        $country = Country::where( 'code' , $destinationCountry )->first();

        if( $country !== null ){
            // find the shipping zone for country
            $shippingZone = ShippingZone::where('id', $country->zone_id)->first();

            // find the markup values for the shipping zone
            $markup = Markup::where('zone_id', $country->zone_id)->first();
            $markup = $markup === null ? [] : $markup->toArray();
        }
        else {
            // use the default zone
            $shippingZone = ShippingZone::where( 'shop' , $shop )->where( 'is_default' , 1 )->first();
            // find the markup values for the default shipping zone
            if( $shippingZone !== null ) {
                $markup = Markup::where('zone_id', $shippingZone->id)->first();
                $markup = $markup === null ? [] : $markup->toArray();
            }
        }

        $total = 0 ;

        foreach( $items as $item ){

            // get the teelaunch shipping rate for sku
            $masterData = TeelaunchMaster::findBy( 'productSKU' ,  $item->sku ); // Security::generateRandomKey(10)
            if( array_key_exists( 0, $masterData ) ) $masterData = $masterData[ 0 ];

            $first_item         = null;
            $additional_item    = null;
            $isTeelaunchProduct = is_a( $masterData , '\TeelaunchShipping\Model\TeelaunchMaster' ) ;

            if( $destinationCountry === 'US' && $isTeelaunchProduct ) {
                $first_item = $masterData->getDomesticShipping();
                $additional_item = $masterData->getAdditionalShipping();
            }
            else if( $destinationCountry === 'GB' && $isTeelaunchProduct ) {
                $first_item = $masterData->getUkShipping();
                $additional_item = $masterData->getAdditionalShipping();
            }
            else if( ShipFree::isEuropeanCountry( $destinationCountry ) && $isTeelaunchProduct ) {
                $first_item = $masterData->getInternationalShipping();
                $additional_item = $masterData->getAdditionalShipping();
            }
            else if( $destinationCountry === 'CA' && $isTeelaunchProduct ) {
                $first_item = $masterData->getCanadaShipping();
                $additional_item = $masterData->getAdditionalShipping();
            }
            else if( $destinationCountry === 'AU' && $isTeelaunchProduct ) {
                $first_item = $masterData->getAuShipping();
                $additional_item = $masterData->getAdditionalShipping();
            }
            else{
                // find default shipping zone
                $defaultZone     = ShippingZone::where( 'shop' , $shop )->where( 'is_default' , 1 )->first();
                // find the default rule
                $defaultRules    = Rule::where( 'zone_id' , $defaultZone->id )->first();

                $first_item      = $defaultRules->first_item;
                $additional_item = $defaultRules->additional_item;

            }

            // markup rate
            if( ! empty( $markup ) ) {
                switch ($markup['type']) {
                    case 'dollar':
                        $first_item += $markup['first_item_amount'];
                        $additional_item += $markup['additional_item_amount'];
                        break;
                    case 'percentage':
                        $firstItemPercentage = $first_item * ($markup['first_item_amount'] / 100);
                        $additionalItemPercentage = $additional_item * ($markup['additional_item_amount'] / 100);
                        $first_item += $firstItemPercentage;
                        $additional_item += $additionalItemPercentage;
                        break;
                    default:
                        break;
                }
            }

            $additionalQuantity = $item->quantity - 1;
            // take additional item price multiply by any *additional* quantity and add that to the first item rate and set to total
            $total += ( $first_item + ( $additional_item *  $additionalQuantity ) ) ;

        }

        $rate = new Rate();
        $rate->setCurrency( Rate::CURRENCY );
        $rate->setServiceCode( ShipFree::PRODUCT_NAME . ' ' . ucfirst( $shippingZone->name )  );
        $rate->setTotalPrice(  ( $total * 100 ) ); // convert to cents
        $rate->setServiceName( ShipFree::PRODUCT_NAME . ' ' . ucfirst( $shippingZone->name ) );

        $shopifyRates[] = Assist::convertToArray( $rate ) ;

        $this->logger->addInfo( 'Rates being sent: ' ) ;
        $this->logger->addInfo( json_encode( [ 'rates' => $shopifyRates ] ) ) ;

        return $response->withStatus( 200 )->withHeader('Content-Type', 'application/json')->withJson( [ 'rates' => $shopifyRates ] );
    }

    public function webhooks($request, $response, $args)
    {
        $data = file_get_contents('php://input');
        $this->logger->addInfo( $data ) ;
        $shopifyData = json_decode( trim( $data ) );
        $header      = $this->getHeaders();
        $this->logger->addInfo( json_encode( $header ) ) ;
        $hmac        = $header[ 'hmac' ];
        $shop        = $header[ 'shop' ];
        $topic       = $header[ 'topic' ];
        switch ( $topic ){
            case 'app/uninstalled':
                $appMember = ShopOwner::where( 'shop' , $shop )->first();
                $zones     = ShippingZone::where( 'shop' , $shop )->get();
                $rules     = Rule::where( 'shop' , $shop )->get();

                foreach( $zones as $zone ){

                    // remove countries
                    $countries = Country::where( 'zone_id' , $zone->id )->get();
                    if( $countries != null ) {
                        foreach ($countries as $country) $country->delete();

                    }

                    // remove markup
                    $markup = Markup::where( 'zone_id' , $zone->id )->first();
                    if( $markup != null ) $markup->delete();


                    // remove rules
                    if( $rules != null ) {
                        foreach ($rules as $rule) $rule->delete();

                    }

                    // remove zone
                    if( $zone != null ) $zone->delete();

                }

                // remove member
                if( $appMember != null ) {
                    $memberToDelete = ShopOwner::find($appMember->id);
                    $memberToDelete->delete();
                }
                break;
        }
        return $response->withStatus( 200 )->withHeader('Content-Type', 'application/json');
    }

    public function redirect($request, $response, $args)
    {

        $currentShop = Helper::getParam( 'shop');
        $shipFree  = new ShipFree( $currentShop );
        Auth::config($shipFree->getConfig());

        $shop_key = Security::generateRandomKey( 75 );
        $accessToken = Auth::getAccessToken();

        $shopifyStore = new Shop();
        $shopifyStore->setShop( $currentShop )->setAccessToken( $accessToken ) ;

        $storeInfo = $shopifyStore->find();

        ShopOwner::firstOrCreate([
            "shop_name"     => $currentShop,
            "timezone" => $storeInfo->getIanaTimezone() ,
            "shopify_access_token"    => $accessToken ,
            'shop_key' => $shop_key
        ]);

        $shopifyData = "Access token $accessToken -- Timezone " . $storeInfo->getIanaTimezone() ;
        $this->logger->addInfo( $shopifyData ) ;

        // webhooks
        foreach ( $shipFree->webhookTopics() as $topic ) {
            $webhook = new Webhook();
            $webhook->setShop( $currentShop )->setAccessToken( $accessToken );
            $webhook->setTopic( $topic )
                ->setAddress( ShipFree::BASE_URL . 'webhooks' )
                ->setFormat( 'json' )
                ->insert();
        }


        // create carrier service
        $carrierService = new CarrierService();
        $carrierService->setShop( $currentShop )->setAccessToken( $accessToken );
        $carrierService->setActive( true ) ;
        $carrierService->setCallbackUrl( ShipFree::BASE_URL . 'rates');
        $carrierService->setCarrierServiceType( 'api' );
        $carrierService->setFormat( 'json' );
        $carrierService->setName( ShipFree::NAME ) ;
        $carrierService->setServiceDiscovery( true ) ;
        $created = $carrierService->insert();

        $this->logger->addInfo('Carrier Service' ) ;
        $this->logger->addInfo(' URL To Post ' . ShipFree::BASE_URL . 'rates' ) ;
        $this->logger->addInfo(json_encode( $created ) ) ;

        $redirectTo = 'https://'.$currentShop.'/admin/apps/';
        return $response->withRedirect(  $redirectTo );

    }
}