{% extends "layouts/app.php" %}
{% block header %}
<link rel="stylesheet" href="{{ appUrl }}css/shipfree.css">
{% endblock %}
{% block body %}

<div class="container bucket-container">
    <div class="row">

        <h1>Shipping Zones</h1>

        <a href="#" class="create-bucket btn btn-info" data-toggle="modal" data-target="#createModal">Create Shipping Zone</a>

        <div class="text-right">
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="text-left modal-title" id="myModalLabel">Create Shipping Zone</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form class="createBucket">
                                <label for="">Name of Shipping Zone</label>
                                <input type="text" placeholder="e.g. T-Shirts, etc." name="bucket" id="name" class="full-width">
                                <label for="">Country</label> <br>
                                <select name="countries" id="countries" multiple="true" class="country-select full-width">
                                    {% for abbr,name in countries %}
                                        <option value='{{ abbr }}'>{{name}}</option>
                                    {% endfor %}
                                </select>
                                <input type="submit" class="btn btn-info full-width" value="Create" />
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bucket-flex">
        {% for zone in zones %}
            <div class="col-md-4">
                <div class="bucket-cards">
                    <div class="badges">
                        {% if zone.exclusive == 1 %}
                        <p class="left-badge text-left">
                            <i class="fa fa-check-square" aria-hidden="true"></i> Exclusive
                        </p>
                        {% endif %}
                        {% if zone.is_global == "Yes" %}
                        <p class="left-badge text-left">
                            <i class="fa fa-globe" aria-hidden="true"></i> Global
                        </p>
                        {% endif %}
                        {% if zone.is_default == 0 %}
                        <a data-id="{{ zone.id }}" class="delete_zone right-badge text-right cursor" href="#">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                        {% endif %}
                        <h1>
                            <a href="{{ appUrl }}/shipping_zone/{{ zone.id }}?shop={{ currentShop }}">
                                {{ zone.name }}
                            </a>
                        </h1>
                        <p>
<!--                            <strong>Created: </strong> {{ zone.created_at|date("M d, Y") }}-->
                        </p>
                        <p>
<!--                            <strong>Rate Type: </strong> {{ zone.rate_type }}-->
                        </p>
                    </div>
                </div>
            </div>
        {%endfor%}
    </div>
</div>

<script>
    var key = '{{ key }}',
        shop = '{{ shop }}',
        title = 'Dashboard';
    function send( uri , data , type , callback){
        var send = $.ajax({
            type: type,
            data: data ,
            url: uri

        });
        send.done(function (res, status, xhr) {
            callback(res) ;
        });
    }
    $( '.delete_zone' ).click( function () {
        var zone_id =  $( this ).attr( 'data-id' );

        ShopifyApp.Modal.confirm("Are you sure you want to?", function(result){
            if(result){
                var uri = "{{ appUrl }}/shipping_zone?shop={{ currentShop }}",
                    data = {
                        id: zone_id,
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

    $( '.createBucket' ).submit( function(){
        var name = $( '#name' ).val(),
            rate_type = $( '#rate_type' ).val(),
            global = $( '#global' ).val(),
            base_type = $( '#base_type' ).val(),
            countries = $( '#countries' ),
            countriesSelected = [];

        var options = countries.children();
        for( var i = 0 ; i < options.length ; i++ ){
            var country = countries.children()[ i ];
            var data = {
                abbr :country.value,
                name :country.innerHTML
            };
            if( country.selected === true ) countriesSelected.push( data ) ;
        }

        var dataToSend = {
            name : name,
            rate_type : rate_type,
            global : global ,
            base_type : base_type,
            countries : countriesSelected
        };
        var uri = "{{ appUrl }}/shipping_zone?shop={{ currentShop }}";

        send( uri , dataToSend , 'post' , function( data ){
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
</script>
{% endblock %}
