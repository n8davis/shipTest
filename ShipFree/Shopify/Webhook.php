<?php

namespace ShipFree\Shopify;


class Webhook extends Shopify
{
    CONST NAME_SINGULAR = 'webhook';
    CONST NAME_PLURAL   = 'webhooks';

    protected $address;
    protected $created_at;
    protected $fields = [];
    protected $format;
    protected $id;
    protected $metafield_namespaces = [];
    protected $topic ;
    protected $updated_at;

    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }

    /**
     * @param $field
     * @return $this
     */
    public function addField( $field ) {
        $fields = $this->getFields() ;
        $fields[] = $field ;
        $this->setFields( $fields );
        return $this;
    }

    /**
     * @param $metaFieldNameSpace
     * @return $this
     */
    public function addMetaFieldNameSpace( $metaFieldNameSpace ) {
        $metaFieldNameSpaces = $this->getMetafieldNamespaces() ;
        $metaFieldNameSpaces[] = $metaFieldNameSpace ;
        $this->setMetafieldNamespaces( $metaFieldNameSpaces );
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return Webhook
     */
    public function setAddress($address)
    {
        $this->address = $address;
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
     * @return Webhook
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return Webhook
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
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
     * @return Webhook
     */
    public function setFormat($format)
    {
        $this->format = $format;
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
     * @return Webhook
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetafieldNamespaces()
    {
        return $this->metafield_namespaces;
    }

    /**
     * @param array $metafield_namespaces
     * @return Webhook
     */
    public function setMetafieldNamespaces($metafield_namespaces)
    {
        $this->metafield_namespaces = $metafield_namespaces;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param mixed $topic
     * @return Webhook
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
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
     * @return Webhook
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }


}