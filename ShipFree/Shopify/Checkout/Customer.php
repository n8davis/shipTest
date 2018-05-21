<?php

namespace ShipFree\Shopify\Checkout;


class Customer
{
    protected $accepts_marketing;
    protected $created_at;
    protected $email;
    protected $first_name;
    protected $id;
    protected $last_name;
    protected $note;
    protected $orders_count;
    protected $state;
    protected $total_spent;
    protected $updated_at;
    protected $tags;

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