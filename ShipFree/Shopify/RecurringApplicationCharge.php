<?php

namespace ShipFree\Shopify;

use ShipFree\HttpConnect;
use ShipFree\Assist;
class RecurringApplicationCharge extends Shopify
{
    CONST NAME_SINGULAR = 'recurring_application_charge';
    CONST NAME_PLURAL   = 'recurring_application_charges';
    CONST PENDING       = 'pending';
    CONST ACCEPTED      = 'accepted';
    CONST ACTIVE        = 'active';
    CONST EXPIRED       = 'expired';
    CONST DECLINED      = 'declined';
    CONST FROZEN        = 'frozen';
    CONST CANCELLED     = 'cancelled';

    protected $activated_on ;
    protected $billing_on;
    protected $cancelled_on;
    protected $capped_amount;
    protected $confirmation_url ;
    protected $created_at;
    protected $url ;
    protected $id ;
    protected $name ;
    protected $price;
    protected $return_url ;
    protected $status ;
    protected $terms;
    protected $test;
    protected $trial_days;
    protected $trial_ends_on;
    protected $updated_at;

    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }

    public function activate(){
        $uri = 'https://' . $this->getShop() . '/admin/' . $this->getPluralName() . DIRECTORY_SEPARATOR . $this->getId() . DIRECTORY_SEPARATOR . 'activate.json';
        $httpConnect = new HttpConnect();
        $httpConnect->setShopifyKeys([
            'shopifyAC' => $this->getAccessToken(),
            'shop'      => $this->getShop()
        ]);
        $httpConnect->request( $uri ,[ $this->getSingularName()  => Assist::convertToArray($this) ], 'POST' );
        $response = is_string( $httpConnect->response  ) ? json_decode( $httpConnect->response ) : $httpConnect->response  ;
        if( Helper::getProperty( $response , 'errors' ) ){
            $this->setErrors( $response->errors );
            return false;
        }
        else{
            if(Helper::getProperty( $response , $this->getSingularName()  ) ){
                if( Helper::getProperty( $response->{ $this->getSingularName() }  , 'id' ) ){
                    $this->setResults( $httpConnect->response ) ;
                    return $response->{ $this->getSingularName() }->id;
                }
            }
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getActivatedOn()
    {
        return $this->activated_on;
    }

    /**
     * @param mixed $activated_on
     * @return RecurringApplicationCharge
     */
    public function setActivatedOn($activated_on)
    {
        $this->activated_on = $activated_on;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingOn()
    {
        return $this->billing_on;
    }

    /**
     * @param mixed $billing_on
     * @return RecurringApplicationCharge
     */
    public function setBillingOn($billing_on)
    {
        $this->billing_on = $billing_on;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCancelledOn()
    {
        return $this->cancelled_on;
    }

    /**
     * @param mixed $cancelled_on
     * @return RecurringApplicationCharge
     */
    public function setCancelledOn($cancelled_on)
    {
        $this->cancelled_on = $cancelled_on;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCappedAmount()
    {
        return $this->capped_amount;
    }

    /**
     * @param mixed $capped_amount
     * @return RecurringApplicationCharge
     */
    public function setCappedAmount($capped_amount)
    {
        $this->capped_amount = $capped_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfirmationUrl()
    {
        return $this->confirmation_url;
    }

    /**
     * @param mixed $confirmation_url
     * @return RecurringApplicationCharge
     */
    public function setConfirmationUrl($confirmation_url)
    {
        $this->confirmation_url = $confirmation_url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     * @return RecurringApplicationCharge
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return RecurringApplicationCharge
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
     * @return RecurringApplicationCharge
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return RecurringApplicationCharge
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->return_url;
    }

    /**
     * @param mixed $return_url
     * @return RecurringApplicationCharge
     */
    public function setReturnUrl($return_url)
    {
        $this->return_url = $return_url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return RecurringApplicationCharge
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @param mixed $terms
     * @return RecurringApplicationCharge
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param mixed $test
     * @return RecurringApplicationCharge
     */
    public function setTest($test)
    {
        $this->test = $test;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrialDays()
    {
        return $this->trial_days;
    }

    /**
     * @param mixed $trial_days
     * @return RecurringApplicationCharge
     */
    public function setTrialDays($trial_days)
    {
        $this->trial_days = $trial_days;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrialEndsOn()
    {
        return $this->trial_ends_on;
    }

    /**
     * @param mixed $trial_ends_on
     * @return RecurringApplicationCharge
     */
    public function setTrialEndsOn($trial_ends_on)
    {
        $this->trial_ends_on = $trial_ends_on;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     * @return RecurringApplicationCharge
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
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
     * @return RecurringApplicationCharge
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}