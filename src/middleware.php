<?php
$checkHmac = function ($request, $response, $next) {
    $params = $request->getQueryParams();
    if( array_key_exists( 'hmac' , $params ) && ! \ShipFree\Shopify\Auth::verify() ){
        return $response->withRedirect(  \ShipFree\ShipFree::BASE_URL . 'empty' );
    }
    $response = $next( $request , $response );
    return $response;
};

$shopExists = function ($request, $response, $next) {

    $currentShop = \ShipFree\Helper::getParam( 'shop' );
    if( strlen( $currentShop ) === 0 ) exit;

    $shop = \ShipFree\Model\ShopOwner::where( 'shop_name', $currentShop )->first();

    if( is_null( $shop ) ){
        $scopes      = 'read_products,write_products,read_shipping,write_shipping';
        $redirectUrl =  rawurlencode( \ShipFree\ShipFree::BASE_URL . 'redirect'  );
        $authUrl = \ShipFree\Shopify\Auth::authRequest( $scopes , $redirectUrl );
        return $response->withRedirect(  $authUrl );
    }
    setcookie( 'shop' , $shop->shop );
    setcookie( 'shop_key' , $shop->member_key ) ;
    $response = $next( $request , $response );
    return $response;

};

$isValidTeelaunchApp = function($request, $response, $next) {
    if( ! array_key_exists( 'shop' , $_COOKIE ) || ! array_key_exists( 'shop_key' , $_COOKIE )){
        // TODO - adjust ajax calls to support cookies
        //exit;
    }
    $response = $next( $request , $response );
    return $response;
};