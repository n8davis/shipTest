<?php
/**
 * Created by PhpStorm.
 * User: nate
 * Date: 5/16/18
 * Time: 6:39 PM
 */

namespace ShipFree\Controller;

use Monolog\Logger;

class ProductControllers
{
    protected $view;
    protected $logger;

    public function __construct(\Slim\Views\Twig $view , Logger $logger ) {
        $this->view = $view;
        $this->logger = $logger ;
    }
}