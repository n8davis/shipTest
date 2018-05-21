<?php

namespace ShipFree\Shopify\Order\Refund;


class LineItem
{
    protected $id;
    protected $line_item;
    protected $line_item_id;
    protected $quantity;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return LineItem
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLineItem()
    {
        return $this->line_item;
    }

    /**
     * @param mixed $line_item
     * @return LineItem
     */
    public function setLineItem($line_item)
    {
        $this->line_item = $line_item;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLineItemId()
    {
        return $this->line_item_id;
    }

    /**
     * @param mixed $line_item_id
     * @return LineItem
     */
    public function setLineItemId($line_item_id)
    {
        $this->line_item_id = $line_item_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     * @return LineItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }


}