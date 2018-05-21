<?php

namespace ShipFree\Controller;

use Monolog\Logger;
use ShipFree\Model\ShippingZone;
use ShipFree\Shopify\Country;
use ShipFree\ShipFree;
use ShipFree\Helper;
use Slim\Views\Twig;

class HomeController
{
    protected $view;
    protected $logger;

    public function __construct( Twig $view , Logger $logger ) {
        $this->view = $view;
        $this->logger = $logger ;
    }

    public function home($request, $response, $args) {
        $shopifyApp = new ShipFree( Helper::getParam('shop') );

//        $shippingZones = new ShippingZone();
//        $zones = $shippingZones->where( 'shop' , $shopifyApp->getShop() )->get();
//
//        $zonesToDisplay = [];
//        foreach( $zones as $zone ) {
////            $zone->created_at = $zone->created_at->format('F j, Y @ g:i A');//date( 'n/j/Y' , strtotime( $zone->created_at ) ) ;
//            $zonesToDisplay[] = $zone->toArray();
//        }


        return $this->view->render($response, 'home/index.php', [
            'zones'     => [],
            'countries' => ShipFree::countries(),
            'appUrl'    => ShipFree::BASE_URL ,
            'url'       => ShipFree::NAME,
            'currentShop' => $shopifyApp->getShop(),
            'key'       => $shopifyApp->getAppApiKey(),
            'shop'      => "https://" . $shopifyApp->getShop()
        ]);
    }

    public function emptyView($request, $response, $args) {
        return $this->view->render($response, 'empty.php', []);
    }


}

