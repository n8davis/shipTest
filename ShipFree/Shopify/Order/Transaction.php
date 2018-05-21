<?php

namespace ShipFree\Shopify\Order;

use ShipFree\Shopify\Order;
use ShipFree\HttpConnect;
use ShipFree\Assist;
class Transaction extends Order
{
    CONST ERROR_INCORRECT_NUMBER = 'incorrect_number';
    CONST ERROR_INVALID_NUMBER = 'invalid_number';
    CONST ERROR_INVALID_EXPIRY_DATE = 'invalid_expiry_date';
    CONST ERROR_INVALID_CVC = 'invalid_cvc';
    CONST ERROR_EXPIRED_CARD = 'expired_card';
    CONST ERROR_INCORRECT_CVC = 'incorrect_cvc';
    CONST ERROR_INCORRECT_ZIP = 'incorrect_zip';
    CONST ERROR_INCORRECT_ADDRESS = 'incorrect_address';
    CONST ERROR_CARD_DECLINED = 'card_declined';
    CONST ERROR_PROCESSING_ERROR = 'processing_error';
    CONST ERROR_CALL_ISSUER = 'call_issuer';
    CONST ERROR_PICK_UP_CARD = 'pick_up_card';


    CONST NAME_SINGULAR = 'transaction';
    CONST NAME_PLURAL   = 'transactions';
    protected $amount;
    protected $authorization;
    protected $created_at;
    protected $device_id;
    protected $gateway;
    protected $source_name;
    protected $payment_details = [];
    protected $id;
    protected $kind;
    protected $order_id;
    protected $receipt;
    protected $error_code;
    protected $status;
    protected $test;
    protected $user_id;
    protected $currency;

    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }


    public function get(){
        if( is_null( $this->getOrderId() ) ) return false;
        if (is_null($this->getShop()) || is_null($this->getAccessToken())) return false;

        $uri = 'https://' . $this->getShop() . '/admin/orders' . DIRECTORY_SEPARATOR . $this->getOrderId() . DIRECTORY_SEPARATOR .  $this->getPluralName() . '.json';

        $client   = new Client();
        $request  = $client->request(Assist::GET_REQUEST, $uri, $this->getHeaders() );
        $response = $request->getBody()->getContents();
        $decodedResponse = json_decode( $response ) ;
        if( Assist::getProperty( $decodedResponse,'errors')) :
            return $decodedResponse->errors ;
        else :
            return Assist::getProperty($decodedResponse, $this->getPluralName()) ? $decodedResponse->{ $this->getPluralName() } : $decodedResponse;
        endif;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param mixed $authorization
     * @return Transaction
     */
    public function setAuthorization($authorization)
    {
        $this->authorization = $authorization;
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
     * @return Transaction
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeviceId()
    {
        return $this->device_id;
    }

    /**
     * @param mixed $device_id
     * @return Transaction
     */
    public function setDeviceId($device_id)
    {
        $this->device_id = $device_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @param mixed $gateway
     * @return Transaction
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSourceName()
    {
        return $this->source_name;
    }

    /**
     * @param mixed $source_name
     * @return Transaction
     */
    public function setSourceName($source_name)
    {
        $this->source_name = $source_name;
        return $this;
    }

    /**
     * @return array
     */
    public function getPaymentDetails()
    {
        return $this->payment_details;
    }

    /**
     * @param array $payment_details
     * @return Transaction
     */
    public function setPaymentDetails($payment_details)
    {
        $this->payment_details = $payment_details;
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
     * @return Transaction
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @param mixed $kind
     * @return Transaction
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     * @return Transaction
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param mixed $receipt
     * @return Transaction
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @param mixed $error_code
     * @return Transaction
     */
    public function setErrorCode($error_code)
    {
        $this->error_code = $error_code;
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
     * @return Transaction
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @return Transaction
     */
    public function setTest($test)
    {
        $this->test = $test;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     * @return Transaction
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
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
     * @return Transaction
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }


}