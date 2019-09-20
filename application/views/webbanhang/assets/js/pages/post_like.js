$(window).ready(function()
{
    $("#main img[data-original]").lazyload();
    $("#search").attr('action','post/search');
    $("#search").attr('method','get');
    $("#search input[name='search_input']").attr('placeholder','Tìm bài viết...');
});