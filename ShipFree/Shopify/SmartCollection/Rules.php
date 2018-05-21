<?php

namespace ShipFree\Shopify\SmartCollection;


class Rules
{

    protected $column;
    protected $relation;
    protected $condition;

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     * @return Rules
     */
    public function setColumn($column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * @param mixed $relation
     * @return Rules
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param mixed $condition
     * @return Rules
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
        return $this;
    }


}