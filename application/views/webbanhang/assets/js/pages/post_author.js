$(window).ready(function()
{
    $("#search").attr('action','post/search');
    $("#search").attr('method','get');
    $("#main img[data-original]").lazyload();
});