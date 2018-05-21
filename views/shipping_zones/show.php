{% extends "layouts/app.php" %}
{% block header %}
<link rel="stylesheet" href="{{ appUrl }}css/shipfree.css">
<script src="{{ appUrl }}js/functions.js"></script>
{% endblock %}
{% block body %}

<div class="container single-bucket-container">
    <div class="message"></div>
    <div class="row shipping-row">
        <div class="description-box">
            <div class="description-header">
                <h2>{{ zone.name }}</h2>
            </div>
            <div class="description-text">
                <p>
                    Edit Your Shipping Zone Here
                </p>
            </div>
        </div>
        <div class="white-box">
            <form name="editBucket" id="editBucket" >
                <input type="hidden" value="{{ zone.id }}" name="id" id="collection_id">
                <div class="">
                    <div class="Polaris-Labelled__LabelWrapper">
                        <div class="Polaris-Label"><label id="TextField1Label" for="TextField1" class="Polaris-Label__Text">Shipping Zone Name</label></div>
                    </div>
                    <div class="Polaris-TextField">
                        <input id="collection_name" name="name" class="Polaris-TextField__Input" aria-labelledby="TextField1Label" aria-invalid="false" value="{{ zone.name }}">
                        <div class="Polaris-TextField__Backdrop"></div>
                    </div>
                </div>

                <div class="">
                    <div class="Polaris-Labelled__LabelWrapper">
                        <div class="Polaris-Label"><label id="Select2Label" for="Select2" class="Polaris-Label__Text">Country</label></div>
                    </div>
                    <div class="Polaris-Select">
                        <select name="countries" id="countries" multiple="true" class="Polaris-Select__Input" aria-invalid="false">
                            {% for abbr,name in countries %}
                            <option {% if abbr in selectedCountries %} selected {%endif%} value='{{ abbr }}'>{{name}}</option>
                            {% endfor %}
                        </select>
                        <div class="Polaris-Select__Icon">
                            <span class="Polaris-Icon">
                                <svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true">
<!--                                    <path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path>-->
                                </svg>
                            </span>
                        </div>
                        <div class="Polaris-Select__Backdrop"></div>
                    </div>
                </div>
                <input id="updateZone" type="submit" class="btn btn-info" value="Update">
            </form>
        </div>
    </div>
    <hr>
    <!--    Shipping Origin   -->
    <div class="row shipping-row">
        <div class="description-box">
            <div class="description-header">
                <h2>Shipping Origin</h2>
            </div>
            <div class="description-text">
                <p>
                    The address used to calculate shipping rates.
                </p>
            </div>
        </div>
        <div class="white-box">
            <p class="text-left"><strong>Shipping from</strong></p>
            <p class="text-right"><a href="https://{{ currentShop }}/admin/settings/general?locale=en" target="_top">Edit Address</a></p>

            <p>
                {{ currentShop }} <br>
                {{ storeInfo.address1 }} <br>
                {{ storeInfo.city }} {{ storeInfo.province }} {{ storeInfo.zip }} {{ storeInfo.country }}
                {{ storeInfo.phone }}
            </p>
        </div>
    </div>
    <hr>
    <!--    Product Section  -->
    <!--
    <div class="row shipping-row">
        <div class="description-box">
            <div class="description-header">
                <h2>Products</h2>
            </div>
            <div class="description-text">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam distinctio iure laboriosam,
                    minus officiis quas quasi! Ab earum itaque minima, molestiae molestias,
                    nemo nesciunt nulla suscipit tempore vero voluptas voluptatibus.
                </p>
            </div>
        </div>
        <div class="white-box">
            <button id="picker" type="button" class="Polaris-Button Polaris-Button--sizeLarge">
                <span class="Polaris-Button__Content">
                    <span>
                        Test Button
                    </span>
                </span>
            </button>
        </div>
    </div>
    <hr>
    -->
    <!--    Rates / Rules   -->
    {% if zone.is_default == 1 %}
    <div class="row shipping-row">
        <div class="description-box">
            <div class="description-header">
                <h2>Shipping Rates</h2>
            </div>
            <div class="description-text">
                <p>
                    Add Rate For Product Type
                </p>
            </div>
        </div>
        <div class="white-box">
            <p class="text-left"><strong>Current Rates</strong></p>

            <table class="table table-hover table-striped">
                <tr>
                    <th>Product Name</th>
                    <th>Product Type</th>
                    <th>First Item</th>
                    <th>Additional </th>
                    <th></th>
                </tr>
                {% for index,rule in rules %}
                    <tr class="cursor" >
                        <td>{{ rule.name }}</td>
                        <td>{{ rule.type }}</td>
                        <td>${{ rule.first_item }}</td>
                        <td>${{ rule.additional_item }}</td>
                        <td>
                            <button data-id="{{ rule.id }}" type="button" class="btn btn-default" data-toggle="modal" data-target="#editRule{{ rule.id }}">Edit</button>
                            <button data-id="{{ rule.id }}" type="button" class="btn btn-danger deleteRule" >Remove</button>
                        </td>

                        <div class="modal fade" id="editRule{{ rule.id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Rule: {{ rule.name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="container edit_rule">
                                            <input type="hidden" id="edit_rule_id" value="{{ rule.id }}" name="edit_rule_id">
                                            <input type="text" name="edit_rule_name" value="{{ rule.name }}" id="edit_rule_name" placeholder="Standard Shipping" class="full-width">
                                            <p>
                                                Customers will see this at checkout
                                            </p>
                                            <hr>
                                            <label for="edit_rule_product_type">Product Type</label> <br>
                                            <select id="edit_rule_product_type" name="edit_rule_product_type" class="country-select full-width">
                                                {% for type in productTypes %}
                                                <option {% if type == rule.type %} selected {%endif%} value='{{ type }}'>{{ type }}</option>
                                                {% endfor %}
                                            </select> <br>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6 min-price">
                                                    <label for="">First Item</label> <br>
                                                    <input class="full-width" type="text" name="edit_rule_first_item" id="edit_rule_first_item" value="{{ rule.first_item }}" placeholder="0">
                                                </div>
                                                <div class="col-sm-6 max-price">
                                                    <label for="">Additional Item(s)</label> <br>
                                                    <input class="full-width" type="text" name="edit_rule_additional_item" id="edit_rule_additional_item" value="{{ rule.additional_item }}" placeholder="0">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-info ">Save changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                {% endfor %}
            </table>
            {% if ( rules|length == 0  ) %}
            <button role="button" class="btn btn-info white_text" data-toggle="modal" data-target="#createModal" id="create-rule">Create Rule</button>
            {% endif %}
        </div>
    </div>
    <hr>
    {% endif %}

    <!-- MARK UP -->
    <div class="row shipping-row">
        <div class="description-box">
            <div class="description-header">
                <h2>Mark Up</h2>
            </div>
            <div class="description-text">
                <p>
                    Set a value that will be added to shipping rate.
                </p>
            </div>
        </div>
        <div class="white-box">
            <table class="table table-hover table-striped">
<!--                <p class="text-left"><strong>Your Markup</strong></p>-->
                <tr>
                    <th>Type</th>
                    <th>First Item</th>
                    <th>Additional</th>
                    <th></th>
                </tr>
                {% for index,markup in markups %}
                <tr>
                    <td>{{ markup.type|capitalize }}</td>
                    <td>
                        {% if markup.type == 'dollar' %} ${{ markup.first_item_amount|number_format(2, '.', ',') }} {% endif %}
                        {% if markup.type == 'percentage' %} {{ markup.first_item_amount }}% {% endif %}
                    </td>
                    <td>
                        {% if markup.type == 'dollar' %} ${{ markup.additional_item_amount|number_format(2, '.', ',') }}  {% endif %}
                        {% if markup.type == 'percentage' %} {{ markup.additional_item_amount }}% {% endif %}
                    </td>
                    <td>
                        <button data-id="{{ markup.id }}" type="button" class="btn btn-default" data-toggle="modal" data-target="#editMarkup{{ markup.id }}">Edit</button>

                        <button data-id="{{ markup.id }}" type="button" class="btn btn-danger deleteMarkup" >Remove</button>
                    </td>
                </tr>
                <div class="modal fade" id="editMarkup{{ markup.id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Markup: {{ markup.type|capitalize }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="createBucket editMarkup" >
                                    <input type="hidden" id="edit_markup_id" name="edit_markup_id" value='{{ markup.id }}'>
                                    <input type="hidden" id="edit_zone_id" name="edit_zone_id" value='{{ zone.id }}'>

                                    <label for="edit_markup_type">Markup Type</label> <br>
                                    <select id="edit_markup_type" name="edit_markup_type" class="country-select" style="width: 100%;display: block; margin:1.2em auto;">
                                        <option {% if markup.type == 'percentage' %} selected {%endif%} value="percentage">By Percentage</option>
                                        <option {% if markup.type == 'dollar' %} selected {%endif%} value="dollar">By Dollar Amount</option>
                                    </select>
                                    <label for="edit_first_item_amount">First Item</label> <br>
                                    <input value="{{ markup.first_item_amount}}" id="edit_first_item_amount" type="number"  name="edit_first_item_amount" style="width: 100%;display: block; margin:1.2em auto;">

                                    <label class="changing" for="edit_additional_item_amount"> Additional Item(s) </label> <br>
                                    <input value="{{ markup.additional_item_amount}}" id="edit_additional_item_amount" type="number"  name="edit_additional_item_amount" style="width: 100%;display: block; margin:1.2em auto;">
                                    <input type="submit" class="btn btn-info disable" value="Update" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {% endfor %}
            </table>
            {% if ( markups|length == 0  ) %}
            <button role="button" class="btn btn-info white_text" data-toggle="modal" data-target="#createMarkUp" id="create-markup">Create Mark Up</button>
            {% endif %}
        </div>
    </div>
    <hr>

    <!-- mark up modal -->

    <div class="modal fade" id="createMarkUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-left modal-title" id="myModalLabel">Create Mark Up</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="createBucket" id="createMarkup" method="post" action="{{ appUrl }}/markup?shop={{ currentShop }}">
                        <input type="hidden" name="zone_id" value='{{ zone.id }}'>

                        <label for="markup_type">Markup Type</label> <br>
                        <select id="markup_type" name="markup_type" class="country-select" style="width: 100%;display: block; margin:1.2em auto;">
                            <option value="percentage">By Percentage</option>
                            <option value="dollar">By Dollar Amount</option>
                        </select>
                        <label for="first_item_amount">First Item</label> <br>
                        <input id="first_item_amount" type="number"  name="first_item_amount" style="width: 100%;display: block; margin:1.2em auto;">

                        <label class="changing" for="additional_item_amount"> Additional Item(s) </label> <br>
                        <input id="additional_item_amount" type="number"  name="additional_item_amount" style="width: 100%;display: block; margin:1.2em auto;">
                        <input type="submit" class="btn btn-info disable" value="Create" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- add rule modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-left modal-title" id="myModalLabel">Create Shipping Rate</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="createBucket" id="createRule" method="post" action="{{ appUrl }}/rules?shop={{ currentShop }}">
                        <input type="hidden" name="zone_id" value='{{ zone.id }}'>
                        <label for="">Name of Shipping Rate</label>
                        <input id="name" type="text" name="name" style="width: 100%; display: block; margin: auto;">
                        <label for="">Product Type</label> <br>
                        <select id="product_type" name="product_type" id="product_type" class="country-select">
                            {% for type in productTypes %}
                            <option value='{{ type }}'>{{ type }}</option>
                            {% endfor %}
                        </select> <br>

                        <label for="">First Item</label> <br>
                        <input id="first_item" type="text"  name="first_item" style="width: 100%;display: block; margin:auto;">

                        <label class="changing" for=""> Additional Item(s) </label> <br>
                        <input id="additional_item" type="text"  name="additional_item" style="width: 100%;display: block; margin:auto;">
                        <input style="50%; " type="submit" class="btn btn-info disable" value="Create" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let key = '{{ key }}',
            shop = '{{ shop }}',
            title = 'Shipping Zone';

        $( document ).ready( function(){
            $( '#createMarkup' ).submit( function(){
                let type = $( '#markup_type' ).val(),
                    markup_first_item = $( '#first_item_amount' ).val(),
                    markup_additional = $( '#additional_item_amount' ).val();
                let elementsToCheck = [ type, markup_additional , markup_first_item ];

                for( let i = 0 ; i < elementsToCheck.length ; i++ ){
                    if( elementsToCheck[i].length === 0 ){
                        ShopifyApp.flashError( 'Please fill out all values ') ;
                        return false;
                    }
                }
                // send data to create markup
                let uri = "{{ appUrl }}/markup?shop={{ currentShop }}";
                let data = {
                    id : "{{ zone.id }}" ,
                    first_item_amount : markup_first_item,
                    additional_item_amount : markup_additional,
                    type : type
                };

                send( uri , data , 'post' , function( data ){
                    console.log( data ) ;
                    if( data != 'false' ){
                        ShopifyApp.flashNotice( 'Settings Successfully Updated.' ) ;
                        window.location.reload( true ) ;
                    }
                    else{
                        ShopifyApp.flashError( 'There was an error.' );
                    }
                });
                return false;
            });

            $( '.editMarkup' ).submit( function(){

                let zone_id = $( '#edit_zone_id').val(),
                    first_item = $('#edit_first_item_amount' ).val(),
                    markup_id = $('#edit_markup_id' ).val(),
                    additional_item = $('#edit_additional_item_amount').val(),
                    type = $('#edit_markup_type').val();

                let elementsToCheck = [
                    zone_id, first_item , additional_item ,type , markup_id
                ];

                // make sure all input fields have values
                for( let i = 0 ; i < elementsToCheck.length ; i++ ){
                    if( elementsToCheck[i].length === 0 ){
                        ShopifyApp.flashError( 'Please fill out all values' ) ;
                        return false;
                    }
                }

                // send data to edit markup
                let uri = "{{ appUrl }}/markup/"+markup_id+"?shop={{ currentShop }}";
                let data = {
                    zone_id : zone_id ,
                    id : markup_id ,
                    first_item : first_item,
                    additional_item : additional_item,
                    type : type
                };

                send( uri , data , 'put' , function( data ){
                    console.log( data ) ;
                    if( data != 'false' ){
                        ShopifyApp.flashNotice( 'Settings Successfully Updated.' ) ;
                        window.location.reload( true ) ;
                    }
                    else{
                        ShopifyApp.flashError( 'There was an error.' );
                    }
                });
                return false;
            });

           $( '.edit_rule' ).submit( function(){
                let name = $( '#edit_rule_name').val(),
                   id = $('#edit_rule_id').val(),
                   first_item = $('#edit_rule_first_item' ).val(),
                   additional_item = $('#edit_rule_additional_item').val(),
                   type = $('#edit_rule_product_type').val();

                let elementsToCheck = [
                 name, id, first_item , additional_item ,type
                ];

                // make sure all input fields have values
                for( let i = 0 ; i < elementsToCheck.length ; i++ ){
                   if( elementsToCheck[i].length === 0 ){
                       ShopifyApp.flashError( 'Please fill out all values' ) ;
                       return false;
                   }
                }

                // send data to edit rule
                let uri = "{{ appUrl }}/rules/"+id+"?shop={{ currentShop }}";
                let data = {
                    name : name,
                    id : id ,
                    first_item : first_item,
                    additional_item : additional_item,
                    type : type
                };

                send( uri , data , 'put' , function( data ){
                    console.log( data ) ;
                    if( data != 'false' ){
                        ShopifyApp.flashNotice( 'Settings Successfully Updated.' ) ;
                        window.location.reload( true ) ;
                    }
                    else{
                        ShopifyApp.flashError( 'There was an error.' );
                    }
                });
                return false;
            });

           $( '#editBucket' ).submit( function(){
               let name = $( '#collection_name' ).val(),
                   id   = $( '#collection_id' ).val(),
                   rate_type = $( '#rate_type' ).val(),
                   global = $( '#global' ).val(),
                   base_type = $( '#base_type' ).val(),
                   countries = $( '#countries' ),
                   countriesSelected = [];

               let options = countries.children();
               for( let i = 0 ; i < options.length ; i++ ){
                   let country = countries.children()[ i ];
                   let data = {
                       abbr :country.value,
                       name :country.innerHTML
                   };
                   if( country.selected === true ) countriesSelected.push( data ) ;
               }

               let dataToSend = {
                   name : name,
                   id  : id ,
                   rate_type : rate_type,
                   global : global ,
                   base_type : base_type,
                   countries : countriesSelected
               };
               let uri = "{{ appUrl }}shipping_zone/{{ id }}?shop={{ currentShop }}";

               send( uri , dataToSend , 'put' , function( data ){
                   if( data != 'false' ){
                       ShopifyApp.flashNotice( 'Settings Successfully Updated.' ) ;
                       window.location.reload( true ) ;
                   }
                   else{
                       ShopifyApp.flashError( 'There was an error.' );
                   }
               });
               return false;
           });

           $('#createRule').submit( function(){
                let additional_item = $( '#additional_item' ).val(),
                    first_item = $( '#first_item' ).val(),
                    product_type = $( '#product_type' ).val(),
                    name = $( '#name' ).val();
                let elementsToCheck = [
                    additional_item,
                    first_item,
                    product_type,
                    name
                ];

                for( let i = 0 ; i < elementsToCheck.length ; i++ ){
                    if( elementsToCheck[i].length === 0 ){
                        ShopifyApp.flashError( 'Please fill out all values' ) ;
                        return false;
                    }
                }
                ShopifyApp.flashNotice( 'Settings Successfully Updated' ) ;
            });

           $( '.deleteRule' ).click( function () {
               let rule_id =  $( this ).attr( 'data-id' );

               ShopifyApp.Modal.confirm("Are you sure you want to?", function(result){
                   if(result){
                       let uri = "{{ appUrl }}/rules?shop={{ currentShop }}",
                           data = {
                               id: rule_id,
                               shop:shop
                           };
                        send( uri , data , 'delete' , function( data ){
                            console.log( data ) ;
                            if( data != 'false' ){
                                ShopifyApp.flashNotice( 'Settings Successfully Updated.' ) ;
                                window.location.reload( true ) ;
                            }
                            else{
                                ShopifyApp.flashError( 'There was an error.' ); 
                            }
                        })
                   }
               });
           });

           $( '.deleteMarkup' ).click( function () {
               let id =  $( this ).attr( 'data-id' );

               ShopifyApp.Modal.confirm("Are you sure you want to?", function(result){
                   if(result){
                       let uri = "{{ appUrl }}/markup?shop={{ currentShop }}",
                           data = {
                               id: id,
                               shop:shop
                           };
                       send( uri , data , 'delete' , function( data ){
                           console.log( data ) ;
                           if( data != 'false' ){
                               ShopifyApp.flashNotice( 'Settings Successfully Updated.' ) ;
                               window.location.reload( true ) ;
                           }
                           else{
                               ShopifyApp.flashError( 'There was an error.' );
                           }
                       })
                   }
               });
           });
        });
    </script>
{% endblock %}