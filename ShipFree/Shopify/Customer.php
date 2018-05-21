<?php

namespace ShipFree\Shopify;


class Customer extends Shopify
{
    CONST NAME_SINGULAR = 'customer';
    CONST NAME_PLURAL   = 'customers';

    protected $accepts_marketing;
    protected $addresses = [];
    protected $created_at;
    protected $default_address = [];
    protected $email;
    protected $phone;
    protected $first_name;
    protected $id;
    protected $metafield = [];
    protected $multipass_identifier;
    protected $last_name;
    protected $note;
    protected $orders_count;
    protected $tax_exempt;
    protected $last_order_id;
    protected $total_spent;
    protected $verified_email;
    protected $state;
    protected $last_order_name;
    protected $updated_at;
    protected $tags;

    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }

    /**
     * @return mixed
     */
    public function getAcceptsMarketing()
    {
        return $this->accepts_marketing;
    }

    /**
     * @param mixed $accepts_marketing
     * @return Customer
     */
    public function setAcceptsMarketing($accepts_marketing)
    {
        $this->accepts_marketing = $accepts_marketing;
        return $this;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param array $addresses
     * @return Customer
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
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
     * @return Customer
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultAddress()
    {
        return $this->default_address;
    }

    /**
     * @param array $default_address
     * @return Customer
     */
    public function setDefaultAddress($default_address)
    {
        $this->default_address = $default_address;
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
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Customer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return Customer
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
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
     * @return Customer
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetafield()
    {
        return $this->metafield;
    }

    /**
     * @param array $metafield
     * @return Customer
     */
    public function setMetafield($metafield)
    {
        $this->metafield = $metafield;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMultipassIdentifier()
    {
        return $this->multipass_identifier;
    }

    /**
     * @param mixed $multipass_identifier
     * @return Customer
     */
    public function setMultipassIdentifier($multipass_identifier)
    {
        $this->multipass_identifier = $multipass_identifier;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return Customer
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
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
     * @return Customer
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrdersCount()
    {
        return $this->orders_count;
    }

    /**
     * @param mixed $orders_count
     * @return Customer
     */
    public function setOrdersCount($orders_count)
    {
        $this->orders_count = $orders_count;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxExempt()
    {
        return $this->tax_exempt;
    }

    /**
     * @param mixed $tax_exempt
     * @return Customer
     */
    public function setTaxExempt($tax_exempt)
    {
        $this->tax_exempt = $tax_exempt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastOrderId()
    {
        return $this->last_order_id;
    }

    /**
     * @param mixed $last_order_id
     * @return Customer
     */
    public function setLastOrderId($last_order_id)
    {
        $this->last_order_id = $last_order_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalSpent()
    {
        return $this->total_spent;
    }

    /**
     * @param mixed $total_spent
     * @return Customer
     */
    public function setTotalSpent($total_spent)
    {
        $this->total_spent = $total_spent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVerifiedEmail()
    {
        return $this->verified_email;
    }

    /**
     * @param mixed $verified_email
     * @return Customer
     */
    public function setVerifiedEmail($verified_email)
    {
        $this->verified_email = $verified_email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return Customer
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastOrderName()
    {
        return $this->last_order_name;
    }

    /**
     * @param mixed $last_order_name
     * @return Customer
     */
    public function setLastOrderName($last_order_name)
    {
        $this->last_order_name = $last_order_name;
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
     * @return Customer
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     * @return Customer
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }


}