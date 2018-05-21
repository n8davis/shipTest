<?php

namespace ShipFree\Shopify;


class ShippingZone extends Shopify
{

    CONST NAME_SINGULAR = 'shipping_zone';
    CONST NAME_PLURAL   = 'shipping_zones';
    protected $id;
    protected $name;
    protected $countries;
    protected $provinces;
    protected $carrier_shipping_rate_providers;
    protected $price_based_shipping_rates;
    protected $weight_based_shipping_rates;

    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ShippingZone
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return ShippingZone
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @param mixed $countries
     * @return ShippingZone
     */
    public function setCountries($countries)
    {
        $this->countries = $countries;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvinces()
    {
        return $this->provinces;
    }

    /**
     * @param mixed $provinces
     * @return ShippingZone
     */
    public function setProvinces($provinces)
    {
        $this->provinces = $provinces;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCarrierShippingRateProviders()
    {
        return $this->carrier_shipping_rate_providers;
    }

    /**
     * @param mixed $carrier_shipping_rate_providers
     * @return ShippingZone
     */
    public function setCarrierShippingRateProviders($carrier_shipping_rate_providers)
    {
        $this->carrier_shipping_rate_providers = $carrier_shipping_rate_providers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriceBasedShippingRates()
    {
        return $this->price_based_shipping_rates;
    }

    /**
     * @param mixed $price_based_shipping_rates
     * @return ShippingZone
     */
    public function setPriceBasedShippingRates($price_based_shipping_rates)
    {
        $this->price_based_shipping_rates = $price_based_shipping_rates;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWeightBasedShippingRates()
    {
        return $this->weight_based_shipping_rates;
    }

    /**
     * @param mixed $weight_based_shipping_rates
     * @return ShippingZone
     */
    public function setWeightBasedShippingRates($weight_based_shipping_rates)
    {
        $this->weight_based_shipping_rates = $weight_based_shipping_rates;
        return $this;
    }

}