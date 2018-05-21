<?php

namespace ShipFree\Model;


use Illuminate\Database\Eloquent\Model;
use ShipFree\Assist;
use ShipFree\ShipFree;

class ShippingZone extends Model
{

    protected $table = 'shipping_zones';

    public static function rates( $rate , $shop )
    {
        $rule = new Rule();
        $rule->type = $rate[ 'product_type' ];
        $rule->name = $rate[ 'name' ];
        $rule->zone_id = $rate[ 'zone_id' ];
        $rule->first_item = $rate[ 'first_item' ];
        $rule->additional_item = $rate[ 'additional_item' ];
        $rule->shop = $shop;
        $rule->save();
    }

    public static function insertInstallZones( $shop , $memberKey )
    {

        $installZones = [
            [ 'country_name' => 'United States', 'country_code' => 'US' , 'selectedCountries' => [[ 'abbr' => 'US' , 'name' => 'United States' ]] ] ,
            [ 'country_name' => 'United Kingdom' , 'country_code' => 'GB' , 'selectedCountries' => [[ 'abbr' => 'GB' , 'name' => 'United Kingdom' ]] ] ,
            [ 'country_name' => 'Europe' , 'country_code' => 'EU' ,'selectedCountries' => ShipFree::europeanCountries()] ,
            [ 'country_name' => 'Australia', 'country_code' => 'AU' , 'selectedCountries' => [[ 'abbr' => 'AU' , 'name' => 'Australia' ]] ] ,
            [ 'country_name' => 'Canada' , 'country_code' => 'CA' , 'selectedCountries' => [[ 'abbr' => 'CA' , 'name' => 'Canada' ]] ] ,
            [ 'country_name' => 'Default' , 'country_code' => '' , 'selectedCountries' => [] ]
        ];
        $errors = [];
        foreach( $installZones as $installZone )
        {
            // save zone
            $zone = new self;
            $zone->name = $installZone[ 'country_name'];
            $zone->member_key = $memberKey ;
            $zone->shop = $shop ;
            $zone->is_default = $installZone[ 'country_name' ] === 'Default' ? 1 : 0 ;
            $zone->rate_type = 'price';
            $save = $zone->save();

            // save countries
            $entity = new self;
            if( ! empty( $installZone[ 'selectedCountries' ] ) ) {
                $entity->saveCountries($installZone['selectedCountries'], $zone->id);
            }

            if( $installZone[ 'country_name' ] === 'Default' ) {
                // save rates
                $rates = self::fetchRates($zone->id, $shop, $installZone['country_code']);
                foreach ($rates as $rate) {
                    $rate['zone_id'] = $zone->id;
                    self::rates($rate, $shop);
                }
            }

            if( $save != true ) $errors[] = $installZone;
        }

        return empty( $errors ) ? true : $errors;
    }

    public static function fetchRates( $id , $shop , $zoneCode )
    {
        $types = [ 'T-Shirt' , 'Tote Bags' , 'Posters' , 'Drinkware' ];
        $data  = [];
        foreach( $types as $type )
        {
            $rate =  [
                'product_type' => $type,
                'name' => $type,
                'zone_id' => $id ,
                'first_item' => ShipFree::DEFAULT_FIRST_ITEM,
                'additional_item' => ShipFree::DEFAULT_ADDITIONAL_ITEM ,
                'shop' => $shop
            ];

            if( strlen( $zoneCode ) === 0 ) {
                $rate[ 'product_type' ] = 'Default' ;
                $rate[ 'name' ] = 'Default' ;
                return [ $rate ] ;
            }

            switch( $type ){
                case 'T-Shirt':
                    $prices = self::fetchShirtPrice( $zoneCode );
                    $rate[ 'first_item' ]      = $prices[ 'first_item' ];
                    $rate[ 'additional_item' ] = $prices[ 'additional_item' ];
                    break;
                case 'Tote Bags':
                    $prices = self::fetchBagPrice( $zoneCode );
                    $rate[ 'first_item' ]      = $prices[ 'first_item' ];
                    $rate[ 'additional_item' ] = $prices[ 'additional_item' ];
                    break;
                case 'Posters':
                    $prices = self::fetchPosterPrice( $zoneCode );
                    $rate[ 'first_item' ]      = $prices[ 'first_item' ];
                    $rate[ 'additional_item' ] = $prices[ 'additional_item' ];
                    break;
                case 'Drinkware':
                    $prices = self::fetchDrinkPrice( $zoneCode );
                    $rate[ 'first_item' ]      = $prices[ 'first_item' ];
                    $rate[ 'additional_item' ] = $prices[ 'additional_item' ];
                    break;
                default:
                    $prices = self::fetchPrice( $zoneCode );
                    $rate[ 'first_item' ]      = $prices[ 'first_item' ];
                    $rate[ 'additional_item' ] = $prices[ 'additional_item' ];
                    break;
            }

            $data[] = $rate;
        }
        return $data ;
    }

    public static function  fetchShirtPrice( $zoneCode )
    {
        $rate = [];
        switch ( $zoneCode ) {
            case 'CA':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            case 'GB':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            case 'EU':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            case 'AU':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            case 'US':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            default:
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
        }
        return $rate;
    }
    public static function  fetchBagPrice( $zoneCode )
    {
        $rate = [];
        switch ( $zoneCode ) {
            case 'CA':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            case 'GB':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            case 'EU':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            case 'AU':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            case 'US':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            default:
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
        }
        return $rate;
    }
    public static function  fetchPosterPrice( $zoneCode )
    {
        $rate = [];
        switch ( $zoneCode ) {
            case 'CA':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '4.00';
                break;
            case 'GB':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '4.00';
                break;
            case 'EU':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '4.00';
                break;
            case 'AU':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '4.00';
                break;
            case 'US':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '4.00';
                break;
            default:
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '4.00';
                break;
        }
        return $rate;
    }
    public static function  fetchDrinkPrice( $zoneCode )
    {
        $rate = [];
        switch ( $zoneCode ) {
            case 'CA':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            case 'GB':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            case 'EU':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            case 'AU':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            case 'US':
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
            default:
                $rate['first_item'] = '4.50';
                $rate['additional_item'] = '2.00';
                break;
        }
        return $rate;
    }
    public static function  fetchPrice( $zoneCode )
    {
        $rate = [];
        switch ( $zoneCode ) {
            case 'CA':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            case 'GB':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            case 'EU':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            case 'AU':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            case 'US':
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
            default:
                $rate['first_item'] = '4.00';
                $rate['additional_item'] = '1.00';
                break;
        }
        return $rate;
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

}