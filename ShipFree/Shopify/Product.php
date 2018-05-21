<?php

namespace ShipFree\Shopify;

use ShipFree\HttpConnect;
use ShipFree\Assist;

class Product extends Shopify
{
    CONST NAME_SINGULAR = 'product';
    CONST NAME_PLURAL   = 'products';
    protected  $body_html;
    protected  $created_at;
    protected  $handle;
    protected  $id;
    protected  $images = [];
    protected  $image;
    protected  $options;
    protected  $product_type;
    protected  $published_at;
    protected  $published_scope;
    protected  $tags;
    protected  $template_suffix;
    protected  $title;
    protected  $metafields_global_title_tag;
    protected  $metafields_global_description_tag;
    protected  $updated_at;
    protected  $variants = [];
    protected  $vendor;

    public function getProductTypes( $id = null , $limit = 250 , $page = 1 )
    {
        $uri = 'https://' . $this->getShop() . '/admin/' . $this->getPluralName() . '.json?fields=product_type&status=any&limit=' . $limit . '&page=' . $page ;

        if( ! is_null( $id ) ) $uri = 'https://' . $this->getShop() . '/admin/' . $this->getPluralName() . '/' . $id . '.json?fields=product_type&status=any&limit=' . $limit . '&page=' . $page ;
        $httpConnect    = new HttpConnect();
        $httpConnect->setShopifyKeys([
            'shopifyAC' => $this->getAccessToken(),
            'shop'      => $this->getShop()
        ]);

        $httpConnect->request( $uri ,'', Assist::GET_REQUEST ) ;
        $response = $httpConnect->response;
        $decodedResponse = json_decode( $response ) ;
        if( Assist::getProperty( $decodedResponse,'errors')) :
            $this->setErrors( $decodedResponse->errors );
            return $decodedResponse->errors ;
        else :
            $this->setResults( $decodedResponse ) ;
            return ! is_null( Assist::getProperty($decodedResponse,$this->getPluralName()) ) ? $decodedResponse->{ $this->getPluralName() } : $decodedResponse;
        endif;
    }


    public function getSingularName(){
        return self::NAME_SINGULAR;
    }

    public function getPluralName(){
        return self::NAME_PLURAL;
    }

    /**
     * @param array $tagArray
     * @return string
     */
    public function arrayToShopifyTag( array $tagArray ) {
        $shopifyTag = '';
        foreach( $tagArray as $tag ) :
            if( strlen( $tag ) > 0 ):
                $shopifyTag .= $tag . ',';
            endif;
        endforeach;
        return rtrim( $shopifyTag , ',') ;
    }

    /**
     * @param  \App\Shopify\Product\Variant
     * @return $this
     */
    public function addVariant( $variant ){
        $this->variants[] = $variant ;
        return $this;
    }

    /**
     * @param $option
     * @return $this
     */
    public function addOption( $option ){
        $this->options[] = $option ;
        return $this;
    }

    public function getHeaders(){
        return [
            'headers' => [
                'Accept'                 => 'application/json',
                'Content-type'           => 'application/json',
                'X-Shopify-Access-Token' =>  $this->getAccessToken()
            ]
        ];
    }

    /**
     * @param \App\Shopify\Product\Image
     * @return $this
     */
    public function addImage( $image ) {
        $this->images[] = $image ;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyHtml()
    {
        return $this->body_html;
    }

    /**
     * @param mixed $body_html
     * @return Product
     */
    public function setBodyHtml($body_html)
    {
        $this->body_html = $body_html;
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
     * @return Product
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $handle
     * @return Product
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
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
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     * @return Product
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     * @return Product
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductType()
    {
        return $this->product_type;
    }

    /**
     * @param mixed $product_type
     * @return Product
     */
    public function setProductType($product_type)
    {
        $this->product_type = $product_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublishedAt()
    {
        return $this->published_at;
    }

    /**
     * @param mixed $published_at
     * @return Product
     */
    public function setPublishedAt($published_at)
    {
        $this->published_at = $published_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublishedScope()
    {
        return $this->published_scope;
    }

    /**
     * @param mixed $published_scope
     * @return Product
     */
    public function setPublishedScope($published_scope)
    {
        $this->published_scope = $published_scope;
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
     * @return Product
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplateSuffix()
    {
        return $this->template_suffix;
    }

    /**
     * @param mixed $template_suffix
     * @return Product
     */
    public function setTemplateSuffix($template_suffix)
    {
        $this->template_suffix = $template_suffix;
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
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetafieldsGlobalTitleTag()
    {
        return $this->metafields_global_title_tag;
    }

    /**
     * @param mixed $metafields_global_title_tag
     * @return Product
     */
    public function setMetafieldsGlobalTitleTag($metafields_global_title_tag)
    {
        $this->metafields_global_title_tag = $metafields_global_title_tag;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetafieldsGlobalDescriptionTag()
    {
        return $this->metafields_global_description_tag;
    }

    /**
     * @param mixed $metafields_global_description_tag
     * @return Product
     */
    public function setMetafieldsGlobalDescriptionTag($metafields_global_description_tag)
    {
        $this->metafields_global_description_tag = $metafields_global_description_tag;
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
     * @return Product
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @param mixed $variants
     * @return Product
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param mixed $vendor
     * @return Product
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }



}