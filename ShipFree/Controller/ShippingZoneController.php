<?php

namespace ShipFree\Controller;

use Monolog\Logger;
//use ShipFree\Model\Markup;
use ShipFree\Model\Rule;
use ShipFree\Model\ShippingZone;
use ShipFree\Model\Country;
use ShipFree\Assist;
use ShipFree\Shopify\Product;
use ShipFree\Shopify\Shop;
use ShipFree\ShipFree;
use ShipFree\Helper;
use Slim\Views\Twig;

class ShippingZoneController
{
    protected $view;
    protected $logger;

    public function __construct( Twig $view , Logger $logger ) {
        $this->view = $view;
        $this->logger = $logger ;
    }

    public function saveCountries( $countries , $id )
    {
        foreach( $countries as $country ){

            $shippingCountry = Country::where( 'zone_id' , $id )
                ->where( 'country_name' , $country[ 'name' ] )
                ->first();
            if( $shippingCountry === null ) $shippingCountry = new Country();

            $shippingCountry->code = $country[ 'abbr' ];
            $shippingCountry->country_name = $country[ 'name' ] ;
            $shippingCountry->zone_id = $id;
            $shippingCountry->save();
        }
    }

    public function remove( $request , $response , $args )
    {
        $post   = $request->getParsedBody();
        $params = $request->getQueryParams();
        $shop   = array_key_exists( 'shop' , $params ) ? $params[ 'shop' ] : '';
        $shippingZone = ShippingZone::find( $post[ 'id' ] );

        $countries = Country::where( 'zone_id' , $post[ 'id' ] )->get();
        foreach( $countries as $country ) $country->delete();

        return $shippingZone->delete() ? json_encode( true ) : json_encode( false );
    }

    public function store($request, $response, $args)
    {
        $post   = $request->getParsedBody();
        $params = $request->getQueryParams();
        $shop = array_key_exists( 'shop' , $params ) ? $params[ 'shop' ] : '';
        $shippingZone = new ShippingZone();

        $shippingZone->name = $post[ 'name' ];
        $shippingZone->rate_type = array_key_exists( 'rate_type' , $post ) ? $post[ 'rate_type' ] : '';
        $shippingZone->is_global = array_key_exists( 'global' , $post ) ? $post[ 'global' ] : 'no';
        $shippingZone->base_type = array_key_exists( 'base_type' , $post ) ? $post[ 'base_type' ] : '';
        $shippingZone->shop = $shop;
        $save = $shippingZone->save();

        $this->saveCountries( $post[ 'countries' ] , $shippingZone->id  );

        return $save ? json_encode( true ) : json_encode( false );
    }

    public function update($request, $response, $args)
    {
        $post   = $request->getParsedBody();
        $params = $request->getQueryParams();
        $shop = array_key_exists( 'shop' , $params ) ? $params[ 'shop' ] : '';

        $shippingZone = ShippingZone::find( $post[ 'id' ] );
        if( $shippingZone === null ) return json_encode( false ) ;

        // remove zones countries
        $countries = Country::where( 'zone_id' , $post[ 'id' ] )->get();
        foreach( $countries as $country ) Country::find( $country->id )->delete();

        $shippingZone->name = $post[ 'name' ];
        $shippingZone->rate_type = $post[ 'rate_type' ];
        $shippingZone->is_global = $post[ 'global' ];
        $shippingZone->base_type = $post[ 'base_type' ];
        $shippingZone->shop = $shop;

        $countries = $post[ 'countries' ];
        $this->saveCountries( $countries , $post[ 'id' ] );

        
        return $shippingZone->save() ? json_encode( true ) : json_encode( false );
    }

    public function show($request, $response, $args)
    {
        $shopifyApp      = new ShipFree( Helper::getParam('shop') );
        $products        = [];
        $shippingZone    = ShippingZone::where( 'shop' , $shopifyApp->getShop() )->first();
        if( $shippingZone === null ) exit ;

        $shippingZoneId  = $shippingZone->id;
        $rules           = [];
        $selectedCountries = [];

        $shopifyStore = new Shop();
        $shopifyStore->setShop( $shopifyApp->getShop() )->setAccessToken( $shopifyApp->getShopifyToken() ) ;
        $storeInfo    = $shopifyStore->all();


        $shippingZoneRules = Rule::where( 'zone_id' , $shippingZoneId )->get();

        foreach( $shippingZoneRules as $rule ) $rules[] = $rule->toArray();


        $countries = Country::where( 'zone_id' , $shippingZoneId )->get();

        foreach( $countries as $country ) $selectedCountries[] = $country->code;

        return $this->view->render($response, 'shipping_zones/show.php', [
            'storeInfo' => $storeInfo,
            'id'        => $shippingZoneId,
            'selectedCountries' => $selectedCountries,
            'countries' => ShipFree::countries(),
            'zone'      => $shippingZone->toArray(),
            'appUrl'    => ShipFree::BASE_URL ,
            'url'       => ShipFree::NAME,
            'currentShop' => $shopifyApp->getShop(),
            'key'       => $shopifyApp->getAppApiKey(),
            'shop'      => "https://" . $shopifyApp->getShop(),
            'rules'     => $rules
        ]);
    }
}