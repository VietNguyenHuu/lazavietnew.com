function f_post()
{
    this.isfollow=false;
    this.follow_type=function(id)
	{
	   if(this.isfollow==false)
       {
            this.isfollow=true;
            $.ajax(
    		{
    			url : "ajax_center",
    			type : "post",
    			dateType:"json",
    			data : 
    			{
    				type:'post_follow_type',
    				id:id
    			},
    			success : function (result)
    			{
    				$("#post_content_follow_type_count").html(result);
    			},
    			error:function()
    			{
    				tooltip("Sự cố mạng",2000);
    			}
    		});
            return true;
       }
       return false;
	}
}
function post_type_f()
{
    this.load_more_content_intype_loadding=false;
    this.load_more_content_template_item=false;
    //tài thêm bài viết trong chuyên mục
    this.load_more_content_intype=function(typeobj,direct)
    {
        if(this.load_more_content_intype_loadding!=false)
        {
            return true;
        }
        this.load_more_content_intype_loadding=true;
        if(this.load_more_content_template_item==false)
        {
            $.ajax(
    		{
    			url : "ajax_center",
    			type : "post",
    			dateType:"json",
    			data : 
    			{
    				type:'post_type/load_more_content_template_item'
    			},
    			success : function (result)
    			{
    			     post_type.load_more_content_template_item=result;
                    post_type.load_more_content_intype_process(typeobj, direct);
    			},
    			error:function()
    			{
    				tooltip("Sự cố mạng",2000);
                    this.load_more_content_intype_loadding=false;
    			}
    		});
        }
        else
        {
            this.load_more_content_intype_process(typeobj, direct);
        }
    }
    this.load_more_content_intype_process=function(typeobj, direct)
    {
        //xử lí
        var ar_post_content=typeobj.find(".post_content_item_box");
        if(direct=='right')
        {
            //get content data over ajax
            $.ajax(
    		{
    			url : "ajax_center",
    			type : "post",
    			dateType:"json",
    			data : 
    			{
    				type:'post_type/load_more_content_get_data',
                    posttype:typeobj.find('h2').attr('data-id'),
                    lastpostid:$(ar_post_content[(ar_post_content.length-1)]).attr('data-id'),
                    direct:'right'
    			},
    			success : function (result)
    			{
    			     if(result != "")
                     {
                        for(i=0; i<ar_post_content.length-1; i++)
                        {
                            $(ar_post_content[i]).remove();
                        }
                        typeobj.find(".post_content_item_box").after(result);
                        typeobj.find("img[data-original]").lazyload();
                     }
    			},
    			error:function()
    			{
    				tooltip("Sự cố mạng",2000);
    			}
    		});
        }
        else if(direct=='left')
        {
            //get content data over ajax
            $.ajax(
    		{
    			url : "ajax_center",
    			type : "post",
    			dateType:"json",
    			data : 
    			{
    				type:'post_type/load_more_content_get_data',
                    posttype:typeobj.find('h2').attr('data-id'),
                    lastpostid:$(ar_post_content[0]).attr('data-id'),
                    direct:'left'
    			},
    			success : function (result)
    			{
    			     if(result != "")
                     {
                        for(i=1; i<ar_post_content.length; i++)
                        {
                            $(ar_post_content[i]).remove();
                        }
                        $(ar_post_content[0]).before(result);
                        typeobj.find("img[data-original]").lazyload();
                     }
    			},
    			error:function()
    			{
    				tooltip("Sự cố mạng",2000);
    			}
    		});
        }
        //end xử lí
        this.load_more_content_intype_loadding=false;
    }
    //bắt sự kiện tải thêm bài viết trong chuyên mục
    $(".post_group .post_loadmore_button").click(function(){
        var typeobj=$(this).parents(".grid");
        if($(this).hasClass('left'))
        {
            post_type.load_more_content_intype(typeobj,"left");
        }
        else
        {
            post_type.load_more_content_intype(typeobj,"right");
        }
    });
}
post="";
post_type="";
$(window).ready(function()
{
    post=new f_post();
    post_type=new post_type_f();
    $(".post_type_contain img[data-original]").lazyload();
    $(".post_type_navi img[data-original]").lazyload();
    $("#search").attr('action','post/search');
    $("#search").attr('method','get');
    $("#search input").attr('placeholder','Tìm bài viết...');
});