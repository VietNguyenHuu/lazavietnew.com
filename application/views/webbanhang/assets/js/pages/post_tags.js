$(window).ready(function()
{
    $("#main .post_tag_contain img[data-original]").lazyload();
    $("#main .post_tag_navi img[data-original]").lazyload();
    $("#search").attr('action','post/search');
    $("#search").attr('method','get');
    $("#search input[name='search_input']").attr('placeholder','Tìm bài viết...');
});