<?php

namespace ShipFree\Shopify\CarrierService;


class Rate
{
    const CURRENCY = 'USD';

    protected $service_name;
    protected $service_code;
    protected $total_price;
    protected $currency;

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return $this->service_name;
    }

    /**
     * @param mixed $service_name
     * @return Rate
     */
    public function setServiceName($service_name)
    {
        $this->service_name = $service_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceCode()
    {
        return $this->service_code;
    }

    /**
     * @param mixed $service_code
     * @return Rate
     */
    public function setServiceCode($service_code)
    {
        $this->service_code = $service_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->total_price;
    }

    /**
     * @param mixed $total_price
     * @return Rate
     */
    public function setTotalPrice($total_price)
    {
        $this->total_price = $total_price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     * @return Rate
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }


}