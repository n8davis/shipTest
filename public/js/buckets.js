$(document).ready(function(){
    $('#tab1').click(function(){
        $(this).children('button').addClass('Polaris-Tabs__Tab--selected');
        $('#tab2').children('button').removeClass('Polaris-Tabs__Tab--selected');
        $('.select-product-link').hide();
        // $('.table-header').hide();
        $('.table').hide();
    });

    $('#tab2').click(function(){
        $(this).children('button').addClass('Polaris-Tabs__Tab--selected');
        $('#tab1').children('button').removeClass('Polaris-Tabs__Tab--selected');
        $('.select-product-link').show();
        // $('.table-header').show();
        $('.table').show();

    });
});