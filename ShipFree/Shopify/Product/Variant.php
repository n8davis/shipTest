<?php

namespace ShipFree\Shopify\Product;

use ShipFree\Shopify\Shopify;

class Variant extends Shopify
{

    protected  $barcode;
    protected  $compare_at_price;
    protected  $created_at;
    protected  $fulfillment_service;
    protected  $grams;
    protected  $id;
    protected  $image_id;
    protected  $inventory_management;
    protected  $inventory_policy;
    protected  $inventory_quantity;
    protected  $old_inventory_quantity;
    protected  $inventory_quantity_adjustment;
    protected  $metafield;
    protected  $option1;
    protected  $option2;
    protected  $option3;
    protected  $position;
    protected  $price;
    protected  $product_id;
    protected  $requires_shipping;
    protected  $sku;
    protected  $taxable;
    protected  $title;
    protected  $updated_at;
    protected  $weight;
    protected  $weight_unit;

    /**
     * @return mixed
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param mixed $barcode
     * @return Variant
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompareAtPrice()
    {
        return $this->compare_at_price;
    }

    /**
     * @param mixed $compare_at_price
     * @return Variant
     */
    public function setCompareAtPrice($compare_at_price)
    {
        $this->compare_at_price = $compare_at_price;
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
     * @return Variant
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFulfillmentService()
    {
        return $this->fulfillment_service;
    }

    /**
     * @param mixed $fulfillment_service
     * @return Variant
     */
    public function setFulfillmentService($fulfillment_service)
    {
        $this->fulfillment_service = $fulfillment_service;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrams()
    {
        return $this->grams;
    }

    /**
     * @param mixed $grams
     * @return Variant
     */
    public function setGrams($grams)
    {
        $this->grams = $grams;
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
     * @return Variant
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * @param mixed $image_id
     * @return Variant
     */
    public function setImageId($image_id)
    {
        $this->image_id = $image_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInventoryManagement()
    {
        return $this->inventory_management;
    }

    /**
     * @param mixed $inventory_management
     * @return Variant
     */
    public function setInventoryManagement($inventory_management)
    {
        $this->inventory_management = $inventory_management;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInventoryPolicy()
    {
        return $this->inventory_policy;
    }

    /**
     * @param mixed $inventory_policy
     * @return Variant
     */
    public function setInventoryPolicy($inventory_policy)
    {
        $this->inventory_policy = $inventory_policy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInventoryQuantity()
    {
        return $this->inventory_quantity;
    }

    /**
     * @param mixed $inventory_quantity
     * @return Variant
     */
    public function setInventoryQuantity($inventory_quantity)
    {
        $this->inventory_quantity = $inventory_quantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOldInventoryQuantity()
    {
        return $this->old_inventory_quantity;
    }

    /**
     * @param mixed $old_inventory_quantity
     * @return Variant
     */
    public function setOldInventoryQuantity($old_inventory_quantity)
    {
        $this->old_inventory_quantity = $old_inventory_quantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInventoryQuantityAdjustment()
    {
        return $this->inventory_quantity_adjustment;
    }

    /**
     * @param mixed $inventory_quantity_adjustment
     * @return Variant
     */
    public function setInventoryQuantityAdjustment($inventory_quantity_adjustment)
    {
        $this->inventory_quantity_adjustment = $inventory_quantity_adjustment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetafield()
    {
        return $this->metafield;
    }

    /**
     * @param mixed $metafield
     * @return Variant
     */
    public function setMetafield($metafield)
    {
        $this->metafield = $metafield;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOption1()
    {
        return $this->option1;
    }

    /**
     * @param $option1
     * @return $this
     */
    public function setOption1( $option1 ) {
        $this->option1 = $option1;
        return $this;
    }

    /**
     * @param mixed $option1
     * @return Variant
     */
    public function addOption($option1)
    {
        $this->option1 = $option1 ;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     * @return Variant
     */
    public function setPosition($position)
    {
        $this->position = $position;
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
     * @return Variant
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     * @return Variant
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequiresShipping()
    {
        return $this->requires_shipping;
    }

    /**
     * @param mixed $requires_shipping
     * @return Variant
     */
    public function setRequiresShipping($requires_shipping)
    {
        $this->requires_shipping = $requires_shipping;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     * @return Variant
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param mixed $taxable
     * @return Variant
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Variant
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * @return Variant
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     * @return Variant
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWeightUnit()
    {
        return $this->weight_unit;
    }

    /**
     * @param mixed $weight_unit
     * @return Variant
     */
    public function setWeightUnit($weight_unit)
    {
        $this->weight_unit = $weight_unit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOption2()
    {
        return $this->option2;
    }

    /**
     * @param mixed $option2
     * @return Variant
     */
    public function setOption2($option2)
    {
        $this->option2 = $option2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOption3()
    {
        return $this->option3;
    }

    /**
     * @param mixed $option3
     * @return Variant
     */
    public function setOption3($option3)
    {
        $this->option3 = $option3;
        return $this;
    }



}