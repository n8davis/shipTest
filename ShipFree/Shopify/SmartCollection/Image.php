<?php

namespace ShipFree\Shopify\SmartCollection;


class Image
{

    protected $src;

    /**
     * @return mixed
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param mixed $src
     * @return Image
     */
    public function setSrc($src)
    {
        $this->src = $src;
        return $this;
    }

}