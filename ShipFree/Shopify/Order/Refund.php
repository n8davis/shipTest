<?php

namespace ShipFree\Shopify\Order;

use ShipFree\Shopify\Order;
use ShipFree\Assist;
use ShipFree\HttpConnect;

class Refund extends Order
{

    CONST NAME_SINGULAR = 'refund';
    CONST NAME_PLURAL   = 'refunds';
    protected $order_id;
    protected $created_at;
    protected $processed_at;
    protected $id;
    protected $note;
    protected $refund_line_items;
    protected $restock;
    protected $transactions;
    protected $user_id;

    public function fetch(){
        if( is_null( $this->getOrderId() ) ) return false;
        if (is_null($this->getShop()) || is_null($this->getAccessToken())) return false;

        $uri = 'https://' . $this->getShop() . '/admin/orders' . DIRECTORY_SEPARATOR . $this->getOrderId() . DIRECTORY_SEPARATOR .  $this->getPluralName() . '.json';
        $httpConnect = new HttpConnect();
        $httpConnect->setShopifyKeys([
            'shopifyAC' => $this->getAccessToken(),
            'shop'      => $this->getShop()
        ]);
        $httpConnect->request( $uri ,[ $this->getSingularName()  => Assist::convertToArray($this) ], 'GET' );
        $response = is_string( $httpConnect->response  ) ? json_decode( $httpConnect->response ) : $httpConnect->response  ;
        $decodedResponse = json_decode( $response ) ;
        if( Assist::getProperty( $decodedResponse,'errors')) :
            return $decodedResponse->errors ;
        else :
            return ! is_null( Assist::getProperty($decodedResponse, $this->getPluralName()) ) ? $decodedResponse->{ $this->getPluralName() } : $decodedResponse;
        endif;
    }

    public function calculate()
    {
        //
    }

    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
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
     * @return Refund
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProcessedAt()
    {
        return $this->processed_at;
    }

    /**
     * @param mixed $processed_at
     * @return Refund
     */
    public function setProcessedAt($processed_at)
    {
        $this->processed_at = $processed_at;
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
     * @return Refund
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     * @return Refund
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefundLineItems()
    {
        return $this->refund_line_items;
    }

    /**
     * @param mixed $refund_line_items
     * @return Refund
     */
    public function setRefundLineItems($refund_line_items)
    {
        $this->refund_line_items = $refund_line_items;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRestock()
    {
        return $this->restock;
    }

    /**
     * @param mixed $restock
     * @return Refund
     */
    public function setRestock($restock)
    {
        $this->restock = $restock;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param mixed $transactions
     * @return Refund
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
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
     * @return Refund
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
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
     * @return Refund
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }


}