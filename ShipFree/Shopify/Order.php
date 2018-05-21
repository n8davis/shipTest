<?php

namespace ShipFree\Shopify;


class Order extends Shopify
{

    CONST NAME_SINGULAR = 'order';
    CONST NAME_PLURAL   = 'orders';


    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }
}