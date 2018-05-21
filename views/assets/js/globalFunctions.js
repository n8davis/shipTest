
$(document).ready( function()
{
    $('.changeStatus').click(function(){
        ShopifyApp.Modal.confirm("Are you sure you want to edit the service?", function(result){
            if(result){
                editService = $.param(config_object);
                var req = $.post({
                    type: "POST",
                    url: "post_products.php",
                    data: editService
                });
                req.done(function(response,status,jqXHR) {
                    if(status == "success"){
                        ShopifyApp.flashNotice("Your settings were updated successfully.");
                        window.setTimeout(function () {
                            location.reload()
                        }, 0000);
                    }
                });
            }else{
                window.setTimeout(function () {
                    location.reload()
                }, 0000);
            }
        });
    });

    $('#rate_type_create').change(function(){
        var option = $('#rate_type_create option:selected');
        if(option[0].label == "USPS") {
            $('.changing').css({"display" : "none"});
            var config = {
                get_config: true,
                db_memberKey: memberKey
            };
            var getConfig = $.param(config);
            // is the configuration set
            var req = $.post({
                type: "POST",
                url: "post_products.php",
                data: getConfig
            });
            req.done(function(response,status,jqXHR) {
                console.log(response);
                if(response == 0){
                    // config is not set
                    ShopifyApp.flashNotice("Please setup USPS in Config Section.");
                    $('.disable').prop("disabled", true);
                }else if(response > 0){
                    // the config is set
                    $('.disable').prop("disabled", false);
                }
            });
        }else {
            $('.disable').prop("disabled", false);
            $('.changing').css({"display" : "initial"});
        }
    });



    function searchString(re, str) {
//        var midstring;
        if (str.search(re) != -1) {
//            midstring = ' contains ';
            return true;
        } else {
//            midstring = ' does not contain ';
            return false;
        }
        return false;
    }
    //POST forms through AJAX using the Enter button
    $('form').submit(function (e)
    {
        e.preventDefault(); // Prevent the original submit
        $(this).find("button").click();
    });

    var changeBased = false, changeRateType = false;
    $('#base_type').change(function(){

        $('#base_type option:selected').each(function(){
            var otherOption = $(this).siblings();

            ShopifyApp.Modal.alert({
                title: "Warning!",
                message: "Changing the Rate Base Type Will Delete ALL Current Rates. Are you sure you want to change this? ",
                okButton: "I understand"
            }, function(result){

                if(result){
                    changeBased = true;
                    console.log("BASED CHANGED? ", changeBased);
                }else{
                    //other option becomes selected
                    otherOption.attr('selected', true);
                    changeBased = false;
                }

            });
        })
    });
    $('#rate_type').change(function(){

        $('#rate_type option:selected').each(function(){
            var other = $(this).siblings();
            // console.log(other);
            var elementClicked = $(this).val();

            ShopifyApp.Modal.alert({
                title: "Warning!",
                message: "Changing the Rate Type Will Delete ALL Current Rates. Are you sure you want to change this? ",
                okButton: "I understand"
            }, function(result){

                if(result){
                    changeRateType = true;
                    console.log("RATE CHANGED? ", changeRateType);
                    if(elementClicked == "Custom Flat Rate") {
                        $('#rate_type').after('<label for="" id="rate_based_label">Rate Based Type</label><select name="base_type" id="base_type"><option value="weight">Weight</option><option value="price">Price</option></select>');

                    }else if(elementClicked == "USPS") {
                        // alert("remove element")
                        $('#rate_based_label').toggle();
                        $('#base_type').toggle();
                    }
                }else{
                    //other option becomes selected
                    other.attr('selected', true);
                    // other.prop('selected', true);
                    // console.log(other);
                    changeRateType = false;
                }

            });
        })
    });
    ShopifyApp.Bar.loadingOff();

    $('.submitEditRate').click(function(){

//       e.preventDefault();
//         console.log($(this).parent().siblings('.modal-body').children('#rate-name').val());
//         console.log($(this).parent().siblings('.modal-body').children('.min-price').children('#rate-min').val());
//         console.log($(this).parent().siblings('.modal-body').children('.max-price').children('#rate-min').val());
//         console.log($(this).parent().siblings('.modal-body').children('.rateAmount').children('#rate-amount').val());
        var rate_name = $(this).parent().siblings('.modal-body').children('#rate-name').val(),
            rate_min = $(this).parent().siblings('.modal-body').children('.min-price').children('#rate-min').val(),
            rate_max = $(this).parent().siblings('.modal-body').children('.max-price').children('#rate-min').val(),
            rate_amount = $(this).parent().siblings('.modal-body').children('.rateAmount').children('#rate-amount').val(),
            rate_id = $(this).parent().siblings('.modal-body').children('#rateID').val();
        var edit = {
            rate_name : rate_name,
            rate_min : rate_min,
            rate_max : rate_max,
            rate_amount : rate_amount,
            rate_id : rate_id
        };
        var obj = {editRate : edit};
        editParams = $.param(obj);
        var req = $.post({
            type: "POST",
            url: "post_products.php",
            data: editParams
        });
        req.done(function(response,status,jqXHR) {
            console.log(response);
            if(status == "success"){
                $('modalR').modal('toggle');
                ShopifyApp.flashNotice("Your settings were updated successfully.");
                window.setTimeout(function () {
                    location.reload()
                }, 0000);
            }
        });
    });

    var displayingVariants = false;
    // var shop = '<?=$shop?>';

        //edit bucket
        $('#editBucket').submit(function(){


            var getRateType = $(this).children('#rate_type').children();
            for(var i = 0; i < getRateType.length; i++){
                // console.log(getRateType[i].value);
                // console.log(getRateType[i].selected);
                if(getRateType[i].selected == true){
                    rate_type = getRateType[i].value;
                }
            }

            var getGlobal = $(this).children('#global').children();
            for(var j = 0; j < getGlobal.length; j++){
                // console.log(getGlobal[j].value);
                // console.log(getGlobal[j].selected);
                if(getGlobal[j].selected == true){
                    global = getGlobal[j].value;
                }
            }

            var getBaseType = $(this).children('#base_type').children();
            for(var k = 0; k < getBaseType.length; k++){
                // console.log(getBaseType[k].value);
                // console.log(getBaseType[k].selected);
                if(getBaseType[k].selected == true){
                    base_type = getBaseType[k].value;
                }
            }

            var getCountries = $(this).children('#countries').children();
            var countries = [];
            for(var l = 0; l < getCountries.length; l++){
                if(getCountries[l].selected == true && getCountries[l] !== ""){
                    var c_obj = {
                        country_name : getCountries[l].innerHTML,
                        country_code : getCountries[l].value
                    };
                    countries.push(c_obj);
                }
            }

            // console.log($(this).children("#collection_id").val());
            if(typeof (global) === 'undefined'){
                global = "No";
            }
            if(changeBased === true){
                var deleteRates = true;
            }else{
                deleteRates = false;
            }
            if(changeRateType === true){
                deleteRates2 = true;
            }else{
                deleteRates2 = false;
            }
            if(typeof (base_type) === 'undefined'){
                base_type = null;
            }
            var editBucket = {
                id:$(this).children("#collection_id").val(),
                name:$(this).children("#collection_name").val(),
                rate_type:rate_type,
                global: global,
                base_type: base_type,
                deleteRates: deleteRates,
                deleteRates2: deleteRates2,
                countries: countries
            };
            console.log(editBucket);
            var editParams = {edit:editBucket};
            editParams = $.param(editParams);
            var req = $.ajax({
                type: "POST",
                url: "post_products.php",
                data: editParams
            });
            req.done(function(response,status,jqXHR){
                console.log(response);
                //send message
                if(response === editBucket.id){
                    // $('.editMessage').html('<p class="alert alert-warning">Edit Successful');
                }
                if(searchString("Can only have one Global Collection",response)){
                    // ShopifyApp.flashNotice("Can only have one Global Collection");
                    window.scrollTo(0, 0);
                    $('.message').append('<p class="alert text-center alert-danger">You can only have one Global ShippingCollection</p>');
                    window.setTimeout(function () {
                        location.reload()
                    }, 0000);
                }
                else {
                    //close modal
                    $('modalE').modal('toggle');
                    ShopifyApp.flashNotice("Your settings were updated successfully.");
                    window.setTimeout(function () {
                        location.reload()
                    }, 0000);
                }
            })
        });

        //delete bucket
        $('.delete_popup_bucket').click(function(){
            // var deleteBucket = {id:$(this).children('input')[0].value,name:$(this).children('input')[1].value};
            var deleteBucket = $(this).children('input').val();
            ShopifyApp.Modal.confirm("Are you sure you want to delete this Shipping Collection?", function(result){
                if(result){
                    console.log(deleteBucket);
                    var deleteParams = {delete:deleteBucket};
                    deleteParams = $.param(deleteParams);
                    var req = $.ajax({
                        type: "POST",
                        url: "post_products.php",
                        data: deleteParams
                    });
                    req.done(function(response,status,jqXHR){
                        console.log(response);
                        //send message
                        if(response === deleteBucket){
                            // $('.editMessage').html('<p class="alert alert-warning">Delete Successful');
                            //close modal
                            $('#deleteModal'+response).modal('toggle');
                            window.scrollTo(0,0);
                            ShopifyApp.flashNotice("Your settings were updated successfully.");
                            window.setTimeout(function(){location.reload()},0000);
                        }else{
                            //close modal
                            ShopifyApp.flashNotice("Something went wrong.");
                            // window.setTimeout(function(){location.reload()},0000);
                        }

                    })
                }
            });

        });



        // Select all links with hashes
        $('a[href*="#"]')
        // Remove links that don't actually link to anything
            .not('[href="#"]')
            .not('[href="#0"]')
            .click(function(event) {
                // On-page links
                if (
                    location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                    &&
                    location.hostname == this.hostname
                ) {
                    // Figure out element to scroll to
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    // Does a scroll target exist?
                    if (target.length) {
                        // Only prevent default if animation is actually gonna happen
                        event.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 1000, function() {
                            // Callback after animation
                            // Must change focus!
//                        var $target = $(target);
//                        $target.focus();
//                        if ($target.is(":focus")) { // Checking if the target was focused
//                            return false;
//                        } else {
//                            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
//                            $target.focus(); // Set focus again
//                        };
                        });
                    }
                }
            });
        var productData = new Array();

        $('.addRow').click(function(){
            $('.rowDiv').append('<div class="enterRates"><input type="text" placeholder="enter name"><input type="text" placeholder="enter rates"><button class="close"><i class="fa fa-times" aria-hidden="true"></i></button></div>')
        });
        $(document).on('click','.close',function(){

//        $(this).parent().css({'display':'none'});


            if($(this).parent('.selectedProductContainer')){
                for(var i = 0; i < productData.length;i++){
//                if(productData[i].length > 1){
                    for(var j = 0; j< productData[i].length;j++){
                        for(var key in productData[i][j]){
                            if(key === "id"){
                                if($(this).siblings('input').val() == productData[i][j].id){
                                    //located product to be removed
//                                    console.log(productData);
                                    productData[i][j].doNotInsert = true;

                                }
                            }
                        }
                    }
//                }
                }
            }
            $(this).parent("selectedProductContainer").remove();

        });
        $(document).on('click','#price_based',function(e){
            // e.preventDefault();
            console.log(bucket_id);
            $('#weight_based').attr('checked',false);
        });
        $(document).on('click','#weight_based',function(e){
            // e.preventDefault();
            console.log(bucket_id);
            $('#price_based').attr('checked',false);
        });
        function weightConverter(valNum) {
            document.getElementById("outputPounds").innerHTML=valNum*0.0625;
        }



        $(".tooltip").hover(function ()
        {
            $(this).attr("tooltip-data", $(this).attr("title"));
            $(this).removeAttr("title");
        }, function ()
        {
            $(this).attr("title", $(this).attr("tooltip-data"));
            $(this).removeAttr("tooltip-data");
        });



        $("[name='editProductBtn']").click(function ()
        {
            var productID = $(this).data("productid");
            //alert(productID);
            editProductRate(productID);
            $(this).find(".buttonText").css("display", "none");
            $(this).find(".buttonLoadingImage").css("display", "block");

        });

        $(".sortable").click(function ()
        {
            loadPage();
            var prevSortBy = '<?=$sortBy?>';
            var sortBy = $(this).data('sort');
            var sortDir = '<?=$sortDir?>';
            var grab = '<?=$grab?>';
            if (sortBy == prevSortBy) {
                if (sortDir == 'asc') {
                    sortDir = 'desc';
                } else {
                    sortDir = 'asc';
                }
            } else {
                sortDir = 'asc';
            }

            //alert(sortBy);

            var newURL = 'products.php?shop=' + shop + '&grab=' + grab + '&sort=' + sortBy + '&sortDir=' + sortDir;
            // console.log(newURL);
            document.location = newURL;
        });

        $("#grabAllProducts").click(function ()
        {
            loadPage();
            var prevSortBy = '<?=$sortBy?>';
            var sortBy = $(this).data('sort');
            var sortDir = '<?=$sortDir?>';
            var grab = 'all';

            var newURL = 'products.php?shop=' + shop + '&grab=' + grab + '&sort=' + sortBy + '&sortDir=' + sortDir;

            //console.log(newURL);
            document.location = newURL;
        });

        $("#grabSetRates").click(function ()
        {
            loadPage();
            var prevSortBy = '<?=$sortBy?>';
            var sortBy = $(this).data('sort');
            var sortDir = '<?=$sortDir?>';
            var grab = 'setRates';

            var newURL = 'products.php?shop=' + shop + '&grab=' + grab + '&sort=' + sortBy + '&sortDir=' + sortDir;
            //console.log(newURL);
            document.location = newURL;
        });




        $('.imperishable').click(function(){
            // Pick single or multiple products
            var singleProductOptions = {
                'selectMultiple': true
            };
            //initialize shopify product picker
            ShopifyApp.Modal.productPicker(singleProductOptions, function(success, data) {
                $('#checkboxI').attr('checked', false);
                if(!success) {
                    // Success is true when a resource is picked successfully
                    return;
                }
                // if there are products selected
                if (data.products.length > 0) {
                    var selectedProducts = data.products;
//                console.log("FIRST", selectedProducts);
                    for(var i = 0; i < selectedProducts.length; i++){
                        $('.bucket2').append("<div class='selectedProductContainer'><img src="+selectedProducts[i].image.src+" /></div>");
                    }
                    //check weight of product
                    for(var j=0;j<selectedProducts[0].variants.length;j++){
                        if(selectedProducts[0].variants[j].weight<=0){
//                        console.log("do not insert") // weight is less than or equal to zero
                        }
                        else{
//                        console.log("insert")
                        }
                    }
                    var productObject = {data: selectedProducts}; // Putting products in an object so that it can be sent in REQUEST
                    var productParams = $.param(productObject); // Params set up
                    //make ajax request
                    var request = $.ajax({
                        type: "POST",
                        url: "post_products.php",
                        data:productParams
                    });
                    request.done(function(response,status,jqXHR){
                        console.log(response);
                        console.log(status);
                        if(status==="success"){
                            var data = JSON.parse(response); // Response from Server | This should have the variants from product selected
                            window.productData.push(data); // Set response to global variable so that it can be access elsewhere
//                        console.log(data);
//                        $('.getRatesI').toggle();

                        }
                        //console.log(jqXHR.responseText);
                    })
                    request.fail(function(jqXHR,status,errorThrown){
                        console.log("NOPE");
                        console.log(errorThrown);
                        console.log(status);
                        console.log(jqXHR);
                    })
                }
                // error handling
                if (data.errors) {
                    console.error(data.errors);
                    alert(data.errors);
                }
            })
        });

        $('.getRatesP').submit(function(e){

            e.preventDefault();
            var n = $(this).parent();
//        console.log("parent: ", n);

            var setup = {},
                rates = [],
                bucketNames = [],
                productsArray = [];

            //buckets
            var findCheck = $(this).parent().children('#bucketContainer').children('.col-md-6').children('#bucketList').children('table').children('tbody').children('tr');
            for(var y = 0; y<findCheck.length;y++){
                bucketContainer = {};
                console.log(findCheck[y].children[1].children)
                //get ID
                if(findCheck[y].children[0].children[0].checked == true){
                    console.log(findCheck[y].children[0].children[0].id)
                    bucketContainer["id"] = findCheck[y].children[0].children[0].id
                    //get name
                    if(findCheck[y].children[1].children[0].htmlFor === findCheck[y].children[0].children[0].id){
                        console.log(findCheck[y].children[1].children[0].innerHTML)
                        bucketContainer["bucket_name"]=findCheck[y].children[1].children[0].innerHTML;
                    }
                }
                bucketNames.push(bucketContainer)
            }



            //rates
            getRates = n.children('#displayMailOptions').children('label');
            for (var j = 0; j < getRates.length; j++) {
                if (getRates[j].children[0].checked) {
                    var rate = {
                        name: getRates[j].children[0].id,
                        value: "5.25"
                    };
                    rates.push(rate);
                    console.log(getRates[j].children[0].id)
                }
            }
            getCustomRates = n.children('.rowDiv').children('div');
            for(var k = 0; k < getCustomRates.length;k++){
                if(getCustomRates[k].children[0].value !== "" && getCustomRates[k].children[1].value !== "") {
                    var rate = {
                        name: getCustomRates[k].children[0].value,
                        value: getCustomRates[k].children[1].value
                    };
                    rates.push(rate);
                }
            }
            console.log(getCustomRates);


            productsArray.push(productData);
            //console.log("window object: ", productData)
            setup.products = productsArray;
            setup.bucketNames = bucketNames;
            setup.rates = rates;
            setup.memberKey = "LFDKewCsrKBKXafazZEpkE3QFaqKYGT573JhGEBSjC2CD3SAQx";
            console.log("SETUP", setup);

            var setupObject = {setup: setup}; // Putting products in an object so that it can be sent in REQUEST
            var dataToPost = $.param(setupObject); // Params set up

            // send data to DB - memberKey, isGlobal, productID, variantID, shipRate, rateType,shipType, lastUpdate,sku
            var request = $.ajax({
                type: "POST",
                url: "post_products.php",
                data:dataToPost
            });
            request.done(function(response,status,jqXHR){
                console.log(response);
                if(status==="success"){
                    var ifError = searchString("ERROR",response);
                    if(ifError){
                        $('.message').css("display", "block");
                        $('.message').html('<p class="alert alert-danger">'+response+'</p>')
                    }else {
                        $('.enterRates').children('input').val("");
//                    $('#displayMailOptions').children(':checked').attr('checked',false);
                        $('.message').css("display", "block");
                        $('.message').html('<p class="alert alert-success">Collection Setup Successful!</p>')
                        window.scrollTo(0,0);
                    }
                }
            });
            request.fail(function(jqXHR,status,errorThrown){
                console.log(errorThrown);
                $('.message').css("display","block");
                $('.message').html('<p class="alert alert-success">'+errorThrown+'</p>');
                console.log(status);
//            console.log(jqXHR);
            });

        })



    function loadPage()
    {
        $("#loadingPage").css("display", "block");
    }


    $('#config').submit(function(e){
       e.preventDefault();
       var values = $(this).children('input');
       for(var i = 0; i < values.length - 1; i++){
           if(values[i].name == "user_id"){
              if(values[i].value === ""){
                  ShopifyApp.flashNotice("User ID Cannot Be Blank");
                  var stop = true;
              }else{
                  var user_id = values[i].value;
              }
           }else if(values[i].name == "key"){
               if(values[i].value === ""){
                   ShopifyApp.flashNotice("Password Cannot Be Blank");
                   stop = true;
               }else{
                   var key = values[i].value;
               }
           }
       }

      // make a test call to USPS to validate
        var uspsData = {validateUSPS: user_id};
        var valid;
        var uspsRequest = $.ajax({
            type: "POST",
            url: "post_products.php",
            data: uspsData
        });
        uspsRequest.done(function(response,status,xhr){
           console.log(response);
           if(response){
               valid = true;
               if(!stop) {
                   var config_obj = {
                       memberKey: memberKey,
                       shop: shop,
                       user_id: user_id,
                       key: key
                   };
                   var setupObject = {config: config_obj}; //
                   var data = $.param(setupObject); // Params set up
                   var request = $.ajax({
                       type: "POST",
                       url: "post_products.php",
                       data: data
                   });
                   request.done(function (res, status, xhr) {
                       if (res === "true") {
                           ShopifyApp.flashNotice("Settings Were Updated Successfully.");
                           window.setTimeout(function () {
                               location.reload()
                           }, 0000);
                       }
                   });
               }
           }else{
               $(".errormessage").append('<p class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error: </strong>USPS credentials are NOT valid.</p>')
               ShopifyApp.flashNotice("USPS credentials are NOT valid.");
           }
        });

    });





});

