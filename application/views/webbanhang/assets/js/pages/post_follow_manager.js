function f_post()
{
    this.selector_to_del=false;
    this.unfollow=function(selector)
    {
        this.selector_to_del=selector;
        dialog("Bạn chắc chắn muốn xóa theo dõi này ?","<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='post.real_unfollow()'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    }
    this.real_unfollow=function()
    {
        selector=this.selector_to_del;
        if(selector==false)
        {
            return false;
        }
        parent_selector=$(selector).parents(".post_follow_item");
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'post_unfollow',
				id:parent_selector.attr('data-id')
			},
			success : function (result)
			{
				dialog("Bỏ theo dõi", result);
                parent_selector.addClass("hide");
			},
			error:function()
			{
				tooltip("Sự cố mạng");
			}
		});
    }
}
post="";
//$(function(){
//	if(!flux.browser.supportsTransitions)
//		alert("Flux Slider requires a browser that supports CSS3 transitions");
//		
//	window.f = new flux.slider('#slider', {
//		pagination: true
//	});
//});
$(window).ready(function()
{
    $("#search").attr('action','post/search');
    $("#search").attr('method','get');
    post=new f_post();
});