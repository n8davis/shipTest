<?php
namespace ShipFree\Shopify;

use ShipFree\Assist;
use ShipFree\HttpConnect;

class Shopify
{
    protected $shop;
    protected $access_token ;
    protected $errors;
    protected $results;


    /**
     * @param null $id
     * @return bool
     */
    public function save( $id = NULL ){
        if( is_null( $this->getShop() ) || is_null( $this->getAccessToken() ) ) return false;
        if( $this->exists( $id ) > 0  && ! is_null( $id )) :
            // update
            return $this->update( $id );
        else :
            // insert
            return $this->insert();
        endif;

    }

    /**
     * @param null $id
     * @return bool|null
     */
    public function exists( $id ) {
        if( is_null( $this->getShop() ) || is_null( $this->getAccessToken() ) ) return false;
        if( is_null( $id ) ) return false;

        $uri         = 'https://' . $this->getShop() . '/admin/' . $this->getPluralName()  .'/' . $id . '.json';
        $entity_id   = null;
        $httpConnect = new HttpConnect();

        $httpConnect->setShopifyKeys([
            'shopifyAC' => $this->getAccessToken(),
            'shop'      => $this->getShop()
        ]);

        $httpConnect->request( $uri ,'', 'GET') ;

        $shopifyResponse = json_decode( $httpConnect->response );
        $this->setResults( $shopifyResponse ) ;
        if( Assist::getProperty( $shopifyResponse  , $this->getSingularName()) ) :
            if( Assist::getProperty( $shopifyResponse->{ $this->getSingularName() }  , 'id') ) :
                $this->setResults( $httpConnect->response ) ;
                $entity_id = $shopifyResponse->{ $this->getSingularName() }->id  ;
            endif;
        endif;
        return $entity_id ;
    }

    /**
     * @param $id
     * @return string
     */
    public function update( $id  ){
        $uri      = 'https://' . $this->getShop() . '/admin/'. $this->getPluralName()  . '/' . $id . '.json';
        $httpConnect = new HttpConnect();
        $httpConnect->setShopifyKeys([
            'shopifyAC' => $this->getAccessToken(),
            'shop'      => $this->getShop()
        ]);
        $httpConnect->request( $uri ,[ $this->getSingularName()  => Assist::convertToArray($this) ], Assist::PUT_REQUEST );
        $response = json_decode( $httpConnect->response ) ;
        if( Assist::getProperty( $response , 'errors' ) ){
            return false;
        }
        else{
            if(Assist::getProperty( $response , $this->getSingularName()  ) ){
                if( Assist::getProperty( $response->{ $this->getSingularName() }  , 'id' ) ){
                    $this->setResults( $httpConnect->response ) ;
                    return $response->{ $this->getSingularName() }->id;
                }
            }
            return false;
        }
    }

    /**
     * @return bool|integer
     */
    public function insert(){
        $uri      = 'https://' . $this->getShop() . '/admin/' . $this->getPluralName() . '.json';
        $httpConnect = new HttpConnect();
        $httpConnect->setShopifyKeys([
            'shopifyAC' => $this->getAccessToken(),
            'shop'      => $this->getShop()
        ]);
        $httpConnect->request( $uri ,[$this->getSingularName() => Assist::convertToArray($this) ], Assist::POST_REQUEST );
        $response = json_decode( $httpConnect->response );
        $this->setResults( $response );
        if( Assist::getProperty( $response , 'errors' ) ){
            $this->setErrors( $response->errors );
            return $response;
        }
        else{
            if(Assist::getProperty( $response , $this->getSingularName()  ) ){
                if( Assist::getProperty( $response->{ $this->getSingularName() }  , 'id' ) ){
                    $this->setResults( $httpConnect->response ) ;
                    return $response->{ $this->getSingularName() }->id;
                }
            }
            return $response;
        }
    }

    /**
     * @param $id
     * @param bool $exists
     * @return bool|mixed|null
     */
    public function get( $id , $exists = false ){
        if( is_null( $this->getShop() ) || is_null( $this->getAccessToken() ) ) return false;
        if( is_null( $id ) ) :
            return false;
        else:
            $uri = 'https://' . $this->getShop() . '/admin/' . $this->getPluralName()  .'/' . $id . '.json';
        endif;
        $entity_id = null;
        $httpConnect    = new HttpConnect();
        $httpConnect->setShopifyKeys([
            'shopifyAC' => $this->getAccessToken(),
            'shop'      => $this->getShop()
        ]);

        $httpConnect->request( $uri ,'', Assist::GET_REQUEST ) ;
        $shopifyResponse = is_string( $httpConnect->response ) ? json_decode( $httpConnect->response ) : $httpConnect->response;
        $this->setResults( $shopifyResponse ) ;
        if( Assist::getProperty( $shopifyResponse  , $this->getSingularName()) ) :
            if( Assist::getProperty( $shopifyResponse->{ $this->getSingularName() }  , 'id') ) :
                $this->setResults( $httpConnect->response ) ;
                $entity_id = $shopifyResponse->{ $this->getSingularName() }->id  ;
                return $exists === true ? $entity_id : $shopifyResponse->{ $this->getSingularName() } ;
            endif;
        endif;
        return $exists === true ? $entity_id : $this->getResults() ;
    }

    /**
     * @param int $limit
     * @param int $page
     * @param null $fields
     * @return bool|array|string
     */
    public function all($limit = 250 , $page = 1 , $fields = null ){
        if( is_null( $this->getShop() ) || is_null( $this->getAccessToken() ) ) return false;
        $uri      = 'https://' . $this->getShop() . '/admin/' . $this->getPluralName() . '.json?status=any&limit=' . $limit . '&page=' . $page . '&fields=' . $fields;
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

    /**
     * Get Count For Any Shopify Entity
     * @return bool|mixed
     */
    public function count()
    {
        if (is_null($this->getShop()) || is_null($this->getAccessToken())) return false;
        $uri = 'https://' . $this->getShop() . '/admin/' . $this->getPluralName() . DIRECTORY_SEPARATOR .  'count.json';

        $httpConnect    = new HttpConnect();
        $httpConnect->setShopifyKeys([
            'shopifyAC' => $this->getAccessToken(),
            'shop'      => $this->getShop()
        ]);

        $httpConnect->request( $uri ,'', Assist::GET_REQUEST ) ;

        $response = $httpConnect->response;
        $decodedResponse = json_decode( $response ) ;
        if( Assist::getProperty( $decodedResponse,'errors')) :
            return $decodedResponse->errors ;
        else :
            return Assist::getProperty($decodedResponse,'count') ? $decodedResponse->count : $decodedResponse;
        endif;
    }

    public function delete( $id ){
        if (is_null($this->getShop()) || is_null($this->getAccessToken())) return false;
        $uri = 'https://' . $this->getShop() . '/admin/' . $this->getPluralName() . DIRECTORY_SEPARATOR . $id . '.json';
        $client   = new Client();
        $request  = $client->request(Assist::DELETE_REQUEST, $uri, $this->getHeaders() );
        $response = $request->getBody()->getContents();
        $decodedResponse = json_decode( $response ) ;
        return $decodedResponse;

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
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     * @return Shopify
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param mixed $results
     * @return Shopify
     */
    public function setResults($results)
    {
        $this->results = $results;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param mixed $shop
     * @return Shopify
     */
    public function setShop($shop)
    {
        $this->shop = $shop;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param mixed $access_token
     * @return Shopify
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }


}