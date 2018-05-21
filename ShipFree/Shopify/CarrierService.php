<?php

namespace ShipFree\Shopify;


class CarrierService extends Shopify
{

    CONST NAME_SINGULAR = 'carrier_service';
    CONST NAME_PLURAL   = 'carrier_services';
    protected $active;
    protected $callback_url;
    protected $carrier_service_type;
    protected $name;
    protected $service_discovery;
    protected $format;

    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return CarrierService
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallbackUrl()
    {
        return $this->callback_url;
    }

    /**
     * @param mixed $callback_url
     * @return CarrierService
     */
    public function setCallbackUrl($callback_url)
    {
        $this->callback_url = $callback_url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCarrierServiceType()
    {
        return $this->carrier_service_type;
    }

    /**
     * @param mixed $carrier_service_type
     * @return CarrierService
     */
    public function setCarrierServiceType($carrier_service_type)
    {
        $this->carrier_service_type = $carrier_service_type;
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
     * @return CarrierService
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceDiscovery()
    {
        return $this->service_discovery;
    }

    /**
     * @param mixed $service_discovery
     * @return CarrierService
     */
    public function setServiceDiscovery($service_discovery)
    {
        $this->service_discovery = $service_discovery;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     * @return CarrierService
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }


}