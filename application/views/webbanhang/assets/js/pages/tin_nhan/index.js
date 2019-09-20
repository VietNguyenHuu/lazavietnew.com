//js for page
function f_tin_nhan()
{
    this.id_user_with=$('.tin_nhan_stream_detail_content').attr('data-id-user-with');
    this.page=1;
    this.is_bottom=false;
    if(this.id_user_with==""||this.id_user_with==undefined)
    {
        this.id_user_with=false;
    }
    this.load_new_form=function()
    {
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'tin_nhan/load_new_form'
			},
            beforeSend:function()
            {
               dialog("Soạn tin nhắn","<div class='padding_v' id='tin_nhan_new_form'><i class='fa fa-refresh fa-spin'></i> Đang tải dữ liệu...</div>");
            },
			success : function (result)
			{
			     $("#tin_nhan_new_form").html(result);
			},
			error:function()
			{
			     $("#tin_nhan_new_form").html("<span class='stt_mistake'>Đã có lỗi xảy ra</span>, <span class='stt_avaiable stt_action' onclick='tin_nhan.load_new_form()'>Nhấn để thực hiện lại</span>");
			}
		});
    }
    this.soantin_search_to=function()
    {
        var realname=$("#tin_nhan_new_form_to_search_input").val();
        
        if(realname==""||realname==undefined)
        {
            $("#tin_nhan_new_form_to_search_result").html("<div class='stt_tip'>Hãy nhập tên người nhận tin để tìm</div>");
            return false;
        }
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'tin_nhan/soantin_search_to',
                realname:realname
			},
            beforeSend:function()
            {
               $("#tin_nhan_new_form_to_search_result").html("<div class='padding_v'><i class='fa fa-refresh fa-spin'></i> Đang tìm thành viên...</div>");
            },
			success : function (result)
			{
			     $("#tin_nhan_new_form_to_search_result").html(result);
			},
			error:function()
			{
			     $("#tin_nhan_new_form_to_search_result").html("<span class='stt_mistake'>Đã có lỗi xảy ra</span>, <span class='stt_avaiable stt_action' onclick='tin_nhan.soantin_search_to()'>Nhấn để thực hiện lại</span>");
			}
		});
    }
    this.soantin_add_to=function(id, realname, avata)
    {
        if(id==false)
        {
            return false;
        }
        $("#tin_nhan_new_form_to_selected").append("<div class='width_40 padding tin_nhan_new_form_to_selected_item fontsize_d2' data-id='"+id+"'><div class='stt_action stt_avaiable font_roboto bg_highlight padding'><img src='"+avata+"' class='align_middle' style='height:1.5em;width:1.5em'><span class='margin_l align_middle'>"+realname+"</span> <span class='float_right stt_mistake stt_action' onclick='$(this).parents(\".tin_nhan_new_form_to_selected_item\").remove()'> x </span><div class='clear_both'></div></div></div>");
        $(".tin_nhan_new_form_to_search_result_item[data-id='"+id+"']").remove();
        $("#tin_nhan_new_form_to_search_result").html("");
    }
    this.soantin_send=function()
    {
        var ar_to=Array();
        $(".tin_nhan_new_form_to_selected_item").each(function(f)
        {
            ar_to.push($(this).attr('data-id'));
        });
        if(ar_to.length<1)
        {
            tooltip("<span class='stt_mistake fontsize_d2'>Hãy chọn người nhận tin</span>",2000);
            return false;
        }
        var content=$("#tin_nhan_new_form_content").val();
        if(content==""||content==undefined)
        {
            tooltip("<span class='stt_mistake fontsize_d2'>Hãy nhập nội dung tin nhắn</span>",2000);
            return false;
        }
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'tin_nhan/soantin_send',
                send_to:ar_to.join(","),
                send_content:content
			},
            beforeSend:function()
            {
               dialog("Gửi tin nhắn","<div class='padding_v tin_nhan_new_form_sending'><i class='fa fa-refresh fa-spin'></i> Đang gửi tin nhắn...</div>");
            },
			success : function (result)
			{
			     $(".tin_nhan_new_form_sending").html(result);
			},
			error:function()
			{
			     $(".tin_nhan_new_form_sending").html("<span class='stt_mistake'>Đã có lỗi xảy ra, không gửi được tin nhắn</span>");
			}
		});
    }
    this.stream_load_list=function(w)
    {
        var ww=w;
        if(ww==undefined||ww==''||ww==false)
        {
            ww=this.id_user_with;
        }
        page=this.page;
        if(page<1)
        {
            page=1;
        }
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'tin_nhan/stream_load_list',
                id_user_with:ww,
                page:page
			},
			success : function (result)
			{
			     if($(".tin_nhan_stream_detail_content").html()!=result)
                 {
                    $(".tin_nhan_stream_detail_content").html(result);
                    tin_nhan.stream_autoscroolbottom();
                 }
                 setTimeout("tin_nhan.stream_load_list()",5000);
			},
			error:function()
			{
			     $(".tin_nhan_stream_detail_content").html("<span class='stt_mistake'>Đã có lỗi xảy ra, không tải được danh sách tin nhắn</span>");
			}
		});
    }
    this.stream_load_list_goto=function(p)
    {
        this.page=p;
        $(".tin_nhan_stream_detail_content").html("<div class='padding margin stt_tip align_center'>Đang tải tin nhắn, xin chờ...</div>");
    }
    this.stream_autoscroolbottom=function()
    {
        if(this.is_bottom==false)
        {
            this.is_bottom=true;
            $(".tin_nhan_stream_detail_content").scrollTop(50000);
        }
    }
    this.stream_send=function()
    {
        var nd=$(".tin_nhan_stream_detail_form_nd_input").val();
        if(nd==""||nd==undefined)
        {
            tooltip("<span class='fontsize_d2 stt_mistake'>Hãy nhập nội dung tin nhắn</span>",2000);
            return false;
        }
        if(this.id_user_with==false)
        {
            tooltip("<span class='fontsize_d2 stt_mistake'>Hãy chọn người nhận tin</span>",2000);
            return false;
        }
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'tin_nhan/stream_send',
                id_user_with:this.id_user_with,
                nd:nd
			},
			success : function (result)
			{
			     tooltip("<span class='fontsize_d2'>"+result+"</span>",2000);
                 $(".tin_nhan_stream_detail_form_nd_input").val('');
                 tin_nhan.stream_load_list();
			},
			error:function()
			{
			     tooltip("<span class='fontsize_d2'>"+result+"</span>",2000);
			}
		});
    }
    this.delallmessage_with=function()
    {
        dialog("Bạn chắc chắn muốn xóa tất cả tin nhắn với người này ?","<div class='padding stt_tip font_roboto fontsize_a2'><i class='fa fa-exclamation-circle'></i> Tất cả tin nhắn của bạn và người này sẽ bị xóa vĩnh viễn, và không thể khôi phục lại được, hãy cân nhắc thật kỹ !</div><div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='tin_nhan.delallmessage_with_real();uncaption()'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    }
    this.delallmessage_with_real=function()
    {
        if(this.id_user_with==false)
        {
            return false;
        }
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'tin_nhan/del_all_message_with',
                id_user_with:this.id_user_with
			},
			success : function (result)
			{
			     tooltip("<span class='fontsize_d2'>"+result+"</span>",2000);
                 tin_nhan.stream_load_list();
			},
			error:function()
			{
			     tooltip("<span class='fontsize_d2'>"+result+"</span>",2000);
			}
		});
    }
    if(this.id_user_with!=false)
    {
        this.stream_load_list();
    }
}
tin_nhan="";
$(window).ready(function()
{
    tin_nhan=new f_tin_nhan();
});