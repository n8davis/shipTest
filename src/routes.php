<?php

/**
 * @class HomeController
 */
$app->get('/', \ShipFree\Controller\ShippingZoneController::class . ':show')->add($shopExists)->add($checkHmac);
$app->get('/empty', \ShipFree\Controller\HomeController::class . ':emptyView');

/**
 * @class ShippingZoneController
 */
$app->get('/shipping_zone/{id}', \ShipFree\Controller\ShippingZoneController::class . ':show')->add($shopExists)->add($isValidTeelaunchApp);
$app->put('/shipping_zone/{id}', \ShipFree\Controller\ShippingZoneController::class . ':update')->add($shopExists)->add($isValidTeelaunchApp);
$app->post('/shipping_zone', \ShipFree\Controller\ShippingZoneController::class . ':store')->add($shopExists)->add($isValidTeelaunchApp);
$app->delete('/shipping_zone', \ShipFree\Controller\ShippingZoneController::class . ':remove')->add($shopExists)->add($isValidTeelaunchApp);

/**
 * @class ShopifyController
 */
$app->get('/redirect', \ShipFree\Controller\ShopifyController::class . ':redirect');
$app->get('/webhooks', \ShipFree\Controller\ShopifyController::class . ':webhooks');
$app->post('/webhooks', \ShipFree\Controller\ShopifyController::class . ':webhooks');
$app->post('/rates', \ShipFree\Controller\ShopifyController::class . ':shipping_rates');


/**
 * @class RulesController
 */
$app->put('/rules/{id}', \ShipFree\Controller\RulesController::class . ':update')->add($shopExists)->add($isValidTeelaunchApp);
$app->post('/rules', \ShipFree\Controller\RulesController::class . ':store')->add($shopExists)->add($isValidTeelaunchApp);
$app->delete('/rules', \ShipFree\Controller\RulesController::class . ':remove')->add($shopExists)->add($isValidTeelaunchApp);

