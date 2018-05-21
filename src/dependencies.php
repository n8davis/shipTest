<?php
/*
    DIC configuration
    Slim has a default DiC which is Pimple.
    It comes with all installations and is enabled by default.
    A DiC hold the configuration for every class your application has.
    The DiC's power comes from the ability to only initialize classes that get called [lazy loading].
    That means if your application only executes 1 controller,
    then only that controller and its dependencies get created.
    Proper utilization of the DiC makes Slim applications super fast and responsive.
 */

$container = $app->getContainer();

// Register Twig View helper
$container['view'] = function ($c) {
    $basePath = ShipFree\ShipFree::BASE_URL . DIRECTORY_SEPARATOR . 'views/';
    $view = new \Slim\Views\Twig(dirname(__DIR__). DIRECTORY_SEPARATOR . 'views/');

    // Instantiate and add Slim specific extension
     $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};
// monolog
$container['logger'] = function ($c) {
    $name         = \ShipFree\ShipFree::NAME;
    $logger       = new \Monolog\Logger( $name ) ;
    $file_handler = new \Monolog\Handler\StreamHandler(dirname( __DIR__ ) . "/logs/" . $name . '_' . date('Y-m-d' ) . '.log' );
    $logger->pushHandler($file_handler);

    return $logger;
};

$container['ShipFree\Controller\RulesController'] = function($c) {
    return new ShipFree\Controller\RulesController( $c->get("view") , $c->get( 'logger' ) );
};
$container['ShipFree\Controller\HomeController'] = function($c) {
    return new ShipFree\Controller\HomeController( $c->get("view") , $c->get( 'logger' ) );
};
$container['ShipFree\Controller\ShopifyController'] = function($c) {
    return new ShipFree\Controller\ShopifyController( $c->get("view") , $c->get( 'logger' ) );
};
$container['ShipFree\Controller\ShippingZoneController'] = function($c) {
    return new ShipFree\Controller\ShippingZoneController( $c->get("view") , $c->get( 'logger' ) );
};
//$container['ShipFree\Controller\MarkupController'] = function($c) {
//    return new ShipFree\Controller\MarkupController( $c->get("view") , $c->get( 'logger' ) );
//};