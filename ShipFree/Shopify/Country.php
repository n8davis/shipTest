<?php

namespace ShipFree\Shopify;



class Country extends Shopify
{

    CONST NAME_SINGULAR = 'countries';
    CONST NAME_PLURAL   = 'countries';

    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }
}