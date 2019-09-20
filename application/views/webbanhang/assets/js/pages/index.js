$(window).ready(function()
{
    $("#search").attr('action','shop/search');
    
    $('#main img.lazyload').lazyload();
    $('#main img.lazyload_1').lazyload();
    $('#main img.lazyload_2').lazyload();
    $('#main img.lazyload_3').lazyload();
    
    $("#main .product_item_2_store img").lazyload();
    
    $(".btn-close-box").click(function()
    {
        $(this).parents('.box').addClass('hide');
    });
});