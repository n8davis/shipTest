<?php
namespace ShipFree\Model;


use Illuminate\Database\Eloquent\Model;

class ShopOwner extends Model
{

    protected $table = 'shop_owners';
    protected $fillable = ['shop_name','timezone','shopify_access_token' , 'shop_key'];

}