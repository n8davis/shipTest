<?php

namespace ShipFree\Shopify;


use ShipFree\HttpConnect;

class Auth
{
    public static $config = [
        'ShopUrl' => null ,
        'SharedSecret' => null,
        'ApiKey' => null
    ];
    public static function config( $config ){
        self::$config = $config;
        return $config;
    }


    /**
     * @return bool
     * @throws \Exception
     */
    public static function verify()
    {
        if (  is_null( self::$config['SharedSecret'] ) && is_null( self::$config['AccessToken']) ){
            throw new \Exception('Shopify Config not set');
        }
        $data   = $_GET;
        $params = array();

        foreach($data as $param => $value) {
            if ($param != 'signature' && $param != 'hmac' ) {
                $params[$param] = "{$param}={$value}";
            }
        }

        asort($params);
        $params = implode('&', $params);

        $hmac           = $data['hmac'];
        $calculatedHmac = hash_hmac('sha256', $params,  self::$config['SharedSecret']);

        return ($hmac == $calculatedHmac);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public static function verifyShopifyRequest()
    {
        $data = $_GET;

        if( ! isset( self::$config['SharedSecret']) ) {
            throw new \Exception( "Please provide SharedSecret while configuring the SDK client." );
        }


        $sharedSecret = self::$config['SharedSecret'];

        //Get the hmac and remove it from array
        if (isset($data['hmac'])) {
            $hmac = $data['hmac'];
            unset($data['hmac']);
        } else {
            throw new \Exception("HMAC value not found in url parameters.");
        }
        //signature validation is deprecated
        if (isset($data['signature'])) {
            unset($data['signature']);
        }
        //Create data string for the remaining url parameters
        $dataString = http_build_query($data);

        $realHmac = hash_hmac('sha256', $dataString, $sharedSecret);

        //hash the values before comparing (to prevent time attack)
        if(md5($realHmac) === md5($hmac)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $scopes
     * @param null $url
     * @return null|string
     * @throws \Exception
     */
    public static function authRequest( $scopes , $url = null )
    {
        $config = self::$config;

        if(!isset($config['ShopUrl']) || !isset($config['ApiKey'])) {
            throw new \Exception("ShopUrl and ApiKey are required for authentication request. Please check SDK configuration!");
        }

        if (!$url) {
            if(!isset($config['SharedSecret'])) {
                throw new \Exception("SharedSecret is required for getting access token. Please check SDK configuration!");
            }

            //If redirect url is the same as this url, then need to check for access token when redirected back from shopify
            if(isset($_GET['code'])) {
                return self::getAccessToken($config);
            } else {
                $url = self::getCurrentUrl();
            }
        }

        if (is_array($scopes)) $scopes = join(',', $scopes);

        $authUrl = 'https://' . $config['ShopUrl'] . DIRECTORY_SEPARATOR .
            'admin/oauth/authorize?client_id=' . $config['ApiKey'] .
            '&redirect_uri=' . $url . "&scope=$scopes";

        return $authUrl;
    }

    /**
     * @param array $config
     * @return null
     * @throws \Exception
     */
    public static function getAccessToken( $config = [] )
    {
        $config = self::$config;

        if(!isset($config['SharedSecret']) || !isset($config['ApiKey'])) {
            throw new \Exception("SharedSecret and ApiKey are required for getting access token. Please check SDK configuration!");
        }

        if(self::verifyShopifyRequest()) {
            $data = array(
                'client_id'     => $config['ApiKey'],
                'client_secret' => $config['SharedSecret'],
                'code'          => $_GET['code'],
            );

            $uri = 'https://' . $config['ShopUrl'] . DIRECTORY_SEPARATOR . 'admin/oauth/access_token';
            $httpConnect = new HttpConnect();
            $response = $httpConnect->request( $uri , $data , HttpConnect::POST );
            $response = json_decode( $response ) ;
            return property_exists( $response , 'access_token') ? $response->access_token : null;
        } else {
            throw new \Exception("This request is not initiated from a valid shopify shop!");
        }
    }

    public static function getCurrentUrl()
    {
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https';
        }
        else {
            $protocol = 'http';
        }

        return "$protocol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}