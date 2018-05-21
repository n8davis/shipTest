<?php

namespace ShipFree\Shopify;


use ShipFree\Shopify\Checkout\BillingAddress;
use ShipFree\Shopify\Checkout\DiscountCode;
use ShipFree\Shopify\Checkout\LineItem;
use ShipFree\Shopify\Checkout\ShippingAddress;
use ShipFree\Shopify\Checkout\ShippingLine;
use ShipFree\Shopify\Checkout\TaxLine;

class Checkout extends Shopify
{

    CONST NAME_SINGULAR = 'checkout';
    CONST NAME_PLURAL   = 'checkouts';
    protected $abandoned_checkout_url;
    protected $billing_address = [];
    protected $buyer_accepts_marketing;
    protected $cancel_reason;
    protected $cart_token;
    protected $closed_at;
    protected $completed_at;
    protected $created_at;
    protected $currency;
    protected $customer = [];
    protected $discount_codes = [];
    protected $email;
    protected $gateway;
    protected $id;
    protected $landing_site;
    protected $line_items = [];
    protected $note;
    protected $referring_site;
    protected $shipping_address = [];
    protected $shipping_lines = [];
    protected $source_name;
    protected $subtotal_price;
    protected $tax_lines = [];
    protected $taxes_included;
    protected $token;
    protected $total_discounts;
    protected $total_line_items_price;
    protected $total_price;
    protected $total_tax;
    protected $total_weight;
    protected $updated_at;

    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }

    /**
     * @param $taxLine
     * @return $this| TaxLine
     */
    public function addTaxLines( $taxLine ) {
        $taxLines   = $this->getTaxLines() ;
        $taxLines[] = $taxLine;
        $this->setTaxLines( $taxLines );
        return $this;
    }

    /**
     * @param $shippingLine
     * @return $this| ShippingLine
     */
    public function addShippingLine( $shippingLine ){
        $shippingLines = $this->getShippingLines();
        $shippingLines[] = $shippingLine;
        $this->setShippingLines( $shippingLines );
        return $this;
    }

    /**
     * @param $address
     * @return $this| ShippingAddress
     */
    public function addShippingAddress( $address ){
        $addresses = $this->getShippingAddress();
        $addresses[] = $address;
        $this->setShippingAddress( $addresses ) ;
        return $this;
    }

    /**
     * @param $lineItem
     * @return $this| LineItem
     */
    public function addLineItem( $lineItem ){
        $lineItems = $this->getLineItems() ;
        $lineItems[] = $lineItem;
        $this->setLineItems( $lineItems );
        return $this;
    }

    /**
     * @param $discountCode
     * @return $this| DiscountCode
     */
    public function addDiscountCode( $discountCode ){
        $discountCodes = $this->getDiscountCodes();
        $discountCodes[] = $discountCode;
        $this->setDiscountCodes( $discountCodes );
        return $this;
    }

    /**
     * @param $billingAddress
     * @return $this| BillingAddress
     */
    public function addBillingAddress( $billingAddress ){
        $addresses = $this->getBillingAddress();
        $addresses[] = $billingAddress;
        $this->setBillingAddress( $addresses ) ;
        return $this;
    }

    /**
     * @param $customer
     * @return $this| Customer
     */
    public function addCustomer( $customer ) {
        $customers = $this->getCustomer();
        $customers[] = $customer;
        $this->setCustomer( $customers ) ;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAbandonedCheckoutUrl()
    {
        return $this->abandoned_checkout_url;
    }

    /**
     * @param mixed $abandoned_checkout_url
     * @return Checkout
     */
    public function setAbandonedCheckoutUrl($abandoned_checkout_url)
    {
        $this->abandoned_checkout_url = $abandoned_checkout_url;
        return $this;
    }

    /**
     * @return array
     */
    public function getBillingAddress()
    {
        return $this->billing_address;
    }

    /**
     * @param array $billing_address
     * @return Checkout
     */
    public function setBillingAddress($billing_address)
    {
        $this->billing_address = $billing_address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBuyerAcceptsMarketing()
    {
        return $this->buyer_accepts_marketing;
    }

    /**
     * @param mixed $buyer_accepts_marketing
     * @return Checkout
     */
    public function setBuyerAcceptsMarketing($buyer_accepts_marketing)
    {
        $this->buyer_accepts_marketing = $buyer_accepts_marketing;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCancelReason()
    {
        return $this->cancel_reason;
    }

    /**
     * @param mixed $cancel_reason
     * @return Checkout
     */
    public function setCancelReason($cancel_reason)
    {
        $this->cancel_reason = $cancel_reason;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCartToken()
    {
        return $this->cart_token;
    }

    /**
     * @param mixed $cart_token
     * @return Checkout
     */
    public function setCartToken($cart_token)
    {
        $this->cart_token = $cart_token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClosedAt()
    {
        return $this->closed_at;
    }

    /**
     * @param mixed $closed_at
     * @return Checkout
     */
    public function setClosedAt($closed_at)
    {
        $this->closed_at = $closed_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompletedAt()
    {
        return $this->completed_at;
    }

    /**
     * @param mixed $completed_at
     * @return Checkout
     */
    public function setCompletedAt($completed_at)
    {
        $this->completed_at = $completed_at;
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
     * @return Checkout
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
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
     * @return Checkout
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return array
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param array $customer
     * @return Checkout
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return array
     */
    public function getDiscountCodes()
    {
        return $this->discount_codes;
    }

    /**
     * @param array $discount_codes
     * @return Checkout
     */
    public function setDiscountCodes($discount_codes)
    {
        $this->discount_codes = $discount_codes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Checkout
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return Checkout
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
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
     * @return Checkout
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLandingSite()
    {
        return $this->landing_site;
    }

    /**
     * @param mixed $landing_site
     * @return Checkout
     */
    public function setLandingSite($landing_site)
    {
        $this->landing_site = $landing_site;
        return $this;
    }

    /**
     * @return array
     */
    public function getLineItems()
    {
        return $this->line_items;
    }

    /**
     * @param array $line_items
     * @return Checkout
     */
    public function setLineItems($line_items)
    {
        $this->line_items = $line_items;
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
     * @return Checkout
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferringSite()
    {
        return $this->referring_site;
    }

    /**
     * @param mixed $referring_site
     * @return Checkout
     */
    public function setReferringSite($referring_site)
    {
        $this->referring_site = $referring_site;
        return $this;
    }

    /**
     * @return array
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }

    /**
     * @param array $shipping_address
     * @return Checkout
     */
    public function setShippingAddress($shipping_address)
    {
        $this->shipping_address = $shipping_address;
        return $this;
    }

    /**
     * @return array
     */
    public function getShippingLines()
    {
        return $this->shipping_lines;
    }

    /**
     * @param array $shipping_lines
     * @return Checkout
     */
    public function setShippingLines($shipping_lines)
    {
        $this->shipping_lines = $shipping_lines;
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
     * @return Checkout
     */
    public function setSourceName($source_name)
    {
        $this->source_name = $source_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubtotalPrice()
    {
        return $this->subtotal_price;
    }

    /**
     * @param mixed $subtotal_price
     * @return Checkout
     */
    public function setSubtotalPrice($subtotal_price)
    {
        $this->subtotal_price = $subtotal_price;
        return $this;
    }

    /**
     * @return array
     */
    public function getTaxLines()
    {
        return $this->tax_lines;
    }

    /**
     * @param array $tax_lines
     * @return Checkout
     */
    public function setTaxLines($tax_lines)
    {
        $this->tax_lines = $tax_lines;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxesIncluded()
    {
        return $this->taxes_included;
    }

    /**
     * @param mixed $taxes_included
     * @return Checkout
     */
    public function setTaxesIncluded($taxes_included)
    {
        $this->taxes_included = $taxes_included;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     * @return Checkout
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalDiscounts()
    {
        return $this->total_discounts;
    }

    /**
     * @param mixed $total_discounts
     * @return Checkout
     */
    public function setTotalDiscounts($total_discounts)
    {
        $this->total_discounts = $total_discounts;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalLineItemsPrice()
    {
        return $this->total_line_items_price;
    }

    /**
     * @param mixed $total_line_items_price
     * @return Checkout
     */
    public function setTotalLineItemsPrice($total_line_items_price)
    {
        $this->total_line_items_price = $total_line_items_price;
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
     * @return Checkout
     */
    public function setTotalPrice($total_price)
    {
        $this->total_price = $total_price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalTax()
    {
        return $this->total_tax;
    }

    /**
     * @param mixed $total_tax
     * @return Checkout
     */
    public function setTotalTax($total_tax)
    {
        $this->total_tax = $total_tax;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalWeight()
    {
        return $this->total_weight;
    }

    /**
     * @param mixed $total_weight
     * @return Checkout
     */
    public function setTotalWeight($total_weight)
    {
        $this->total_weight = $total_weight;
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
     * @return Checkout
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }


}