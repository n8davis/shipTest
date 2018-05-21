<?php
namespace ShipFree\Controller;


use Monolog\Logger;
use ShipFree\Model\Rule;

class RulesController
{
    protected $view;
    protected $logger;

    public function __construct(\Slim\Views\Twig $view , Logger $logger ) {
        $this->view = $view;
        $this->logger = $logger;
    }

    public function store($request, $response, $args)
    {
        $post   = $request->getParsedBody();
        $params = $request->getQueryParams();
        $goBack = $_SERVER['HTTP_REFERER'];

        $shop = array_key_exists( 'shop' , $params ) ? $params[ 'shop' ] : '';

        $rule = new Rule();
        $rule->type = $post[ 'product_type' ];
        $rule->name = $post[ 'name' ];
        $rule->zone_id = $post[ 'zone_id' ];
        $rule->first_item = $post[ 'first_item' ];
        $rule->additional_item = $post[ 'additional_item' ];
        $rule->shop = $shop;
        $rule->save();
        return $response->withRedirect( $goBack );
    }

    public function remove($request, $response, $args)
    {
        $post   = $request->getParsedBody();
        $params = $request->getQueryParams();
        $shop = array_key_exists( 'shop' , $params ) ? $params[ 'shop' ] : '';

        $rule = Rule::find( $post[ 'id' ] );

        return $rule->delete() ? json_encode( true ) : json_encode( false );
    }
    
    public function update($request, $response, $args){
        $post   = $request->getParsedBody();
        $params = $request->getQueryParams();
        $shop = array_key_exists( 'shop' , $params ) ? $params[ 'shop' ] : '';

        $rule = Rule::find( $post[ 'id' ] );

        if( $rule === null ) return json_encode( false );
        $rule->name = $post['name'];
        $rule->first_item = number_format((float) $post[ 'first_item' ], 2, '.', '');
        $rule->additional_item = number_format((float) $post[ 'additional_item' ], 2, '.', '');
        $rule->type = $post[ 'type' ];

        return $rule->save() ? json_encode( true ) : json_encode( false ) ;
    }
}