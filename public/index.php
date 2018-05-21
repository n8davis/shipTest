<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$basePath = dirname( __DIR__ ) . DIRECTORY_SEPARATOR  ;

require $basePath . 'vendor/autoload.php';
require $basePath . 'ShipFree/Exception.php';

$config     = include( $basePath. 'src/config.php');

$app        = new \Slim\App(['settings'=> $config]);

// Set up dependencies
require $basePath . 'src/dependencies.php';

// Register middleware
require $basePath . 'src/middleware.php';

// Register capsule
require $basePath . 'src/capsule.php';

// Register routes
require $basePath . 'src/routes.php';

// Register Shopify Credentials
$shopifyApp = new \ShipFree\ShipFree( \ShipFree\Helper::getParam( 'shop' ) );

// remove logs older than 30 days
$logFiles = scandir( $basePath . 'logs' ) ;
foreach( $logFiles as $file ){
    if( $file === '.' || $file === '..' ) continue;
    $getFileDate  = explode( '_' , $file );
    $fileDate     = array_key_exists( 1 , $getFileDate ) ? $getFileDate[ 1 ] : '';
    $fileDate     = rtrim( $fileDate , '.log' ) ;
    $now          = new DateTime( 'now' );
    $fileDateTime = new DateTime( $fileDate , new DateTimeZone( 'America/Los_Angeles' ) );

    if( $fileDateTime->diff( $now )->days > 30 === true ) unlink( $basePath . 'logs' . DIRECTORY_SEPARATOR . $file );
}
$app->run();
// install - https://jookbot.com/shipfree/public/?shop=n8davis.myshopify.com
/*
UK - 12 The Broadway, Old Amersham, Amersham HP7 0HP, UK
EUR - 617 Rue Fourny, 78530 Buc, France
CA  - 46 Pine St, Belleville, ON K8N 2M2, Canada
AU - 135 Stirling Hwy, Nedlands WA 6009, Australia
UNKNOWN - Av. Maranguape, 1-41 - Forquilha, São Luís - MA, 65110-000, Brazil
 */