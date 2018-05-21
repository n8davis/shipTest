<?php

namespace ShipFree\Shopify;


class ScriptTag extends Shopify
{
    CONST NAME_SINGULAR = 'script_tag';
    CONST NAME_PLURAL   = 'script_tags';

    CONST EVENT_ONLOAD       = 'onload'; // Currently, "onload" is the only supported event.
    CONST SCOPE_ONLINE_STORE = 'online_store';
    CONST SCOPE_ORDER_STATUS = 'order_status';
    CONST SCOPE_ALL          = 'all';

    protected $created_at;
    protected $event;
    protected $id;
    protected $src;
    protected $display_scope;
    protected $updated_at;

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
     * @return ScriptTag
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     * @return ScriptTag
     */
    public function setEvent($event)
    {
        $this->event = $event;
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
     * @return ScriptTag
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param mixed $src
     * @return ScriptTag
     */
    public function setSrc($src)
    {
        $this->src = $src;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisplayScope()
    {
        return $this->display_scope;
    }

    /**
     * @param mixed $display_scope
     * @return ScriptTag
     */
    public function setDisplayScope($display_scope)
    {
        $this->display_scope = $display_scope;
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
     * @return ScriptTag
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }


}