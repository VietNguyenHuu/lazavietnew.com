function f_user_info()
{
    this.avata=false;
    this.set_avata=function(f)
    {
        selt=this;
        var reader = new FileReader();
		reader.onload = function (e)
		{
    		  var str=e.target.result.substr(0,10);
              if(str=='data:image')
              {
                 	selt.avata=e.target.result;
        			$(".user_info_view_avata").attr('src',e.target.result);
                    selt.update_avata();
              }
              else
              {
                    dialog('Định dạng không hợp lệ!',"Chỉ được phép chọn định dạng là file ảnh</div>");
              }
         
		};
		reader.readAsDataURL(f.files[0]);
    }
    this.update_avata=function()
    {
        if(this.avata==false)
        {
            alert("Hãy chọn ảnh");
            return false;
        }
        dialog("Cập nhật ảnh đại diện","<div class='padding'><img src='assets/img/system/loading2.gif' style='width:1em;height:1em;margin-right:0.5em'>Đang cập nhật ảnh đại diện, xin chờ</div>");
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'user_update_avata',
				avata:this.avata
			},
			success : function (result)
			{
				dialog("Cập nhật ảnh đại diện",result);
			},
			error:function()
			{
				dialog("Cập nhật ảnh đại diện","<div class='stt_mistake'>Lỗi kết nối, hãy thực hiện lại</div>");
			}
		});
        this.avata=false;
        $("#user_info_view_avata_input").val("");
        return true;
    }
	this.update=function()
	{
		$.ajax(
		{
			url : "index.php/ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'profile_update',
				id:get_method().id||$("div[name='user_info_id']").html(),
				realname:$("#register_realname").val(),
				sex:$("select[name='register_sex']").val(),
				birth:$("select[name='register_year']").val(),
				oldpass:$("#register_oldpass").val(),
				newpass:$("#register_newpass").val(),
				province_code:$("select[name='register_province']").val(),
				phone:$("#register_phone").val(),
				email:$("#register_email").val(),
				address:$("#register_address").val()
			},
			success : function (result)
			{
				$("div[name='user_info_status_content']").html(result);
				$("div[name='user_info_status']").css({'display':'block'});
			},
			error:function()
			{
				$("div[name='user_info_status']").html("<span class='mistake'>Lỗi kết nối, hãy thực hiện lại.</span>");
			}
		});
	}
	this.hide_updatestatus=function()
	{
		$("div[name='user_info_status']").css({'display':'none'});
	}
}
function kt_realname()
{
	ten=document.getElementById("register_realname").value;
	add="Có thể sử dụng tên này";
	add_c="avaiable";
	if(ten.length>20||ten.length<8)
	{
		add="Độ dài tên không hợp lệ !";
		add_c="mistake";
	}
	$("#register_check_realname").html("<div class='"+add_c+"'>"+add+"</div>");
}
function kt_newpass()
{
	ten=document.getElementById("register_newpass").value;
	add="Mật khẩu mới hợp lệ";
	add_c="avaiable";
	if(ten.length>20||ten.length<8)
	{
		add="Mật khẩu mới không hợp lệ.<br>Mật khẩu hợp lệ phải từ 8 đến 20 ký tự. !";
		add_c="mistake";
	}
	$("#register_check_newpass").html("<div class='"+add_c+"'>"+add+"</div>");
}
function kt_renewpass()
{
	repass=document.getElementById("register_repass").value;
	pass=document.getElementById("register_pass").value;
	add="Mật khẩu lặp lại đúng";
	add_c="avaiable";
	if(repass!=pass)
	{
		add="Mật khẩu không trùng khớp !";
		add_c="mistake";
	}
	$("#register_check_repass").html("<div class='"+add_c+"'>"+add+"</div>");
}
function kt_phone()
{
	phone=$("#register_phone").val();
	add="Số điện thoại hợp lệ";
	add_c="avaiable";
	if(phone.length<8||phone.length>15||phone.match(/[^0-9]/g))
	{
		add="Số điện thoại không hợp lệ !";
		add_c="mistake";
		phone=$("#register_phone").focus();
	}
	$("#register_check_phone").html("<div class='"+add_c+"'>"+add+"</div>");
	if(add_c=="avaiable")
	{
		$.ajax(
		{
			url : "index.php/ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'check_existsphone',
				phone:phone
			},
			success : function (result)
			{
				var k=result;
				if(k=='1')//số điện thoại đã tồn tại
				{
					$("#register_check_phone").html("<div class='mistake'>Rất tiếc, số điện thoại này đã tồn tại, hãy chọn số khác</div>");
				}
				else
				{
					$("#register_check_phone").html("<div class='avaiable'>Có thể sử dụng số điện thoại này</div>");
				}
			}
		});
	}
}
function kt_email()
{
	phone=$("#register_email").val();
	add="Email hợp lệ";
	add_c="avaiable";
	if(phone==1)
	{
		add="Email không hợp lệ !";
		add_c="mistake";
		phone=$("#register_email").focus();
	}
	$("#register_check_email").html("<div class='"+add_c+"'>"+add+"</div>");
    if(add_c=="avaiable")
	{
		$.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'check_existsemail',
				email:phone
			},
			success : function (result)
			{
				var k=result;
				if(k=='1')//email đã tồn tại
				{
					$("#register_check_email").html("<div class='mistake'>Rất tiếc, email này đã tồn tại, hãy chọn email khác</div>");
				}
				else
				{
					$("#register_check_email").html("<div class='avaiable'>Có thể sử dụng email này</div>");
				}
			}
		});
	}
}
function f_user_action()
{
    this.load_form_into_money=function()
    {
        dialog("Chuyển điểm sang tài khoản","<div class='form_into_money'></div>");
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'user_load_form_into_money'
			},
			success : function (result)
			{
				$(".form_into_money").html(result);
			},
            error:function()
            {
                $(".form_into_money").html("Lỗi kết nối");
            }
		});
    }
    this.score_into_money=function()
    {
        var selector=$("#score_into_money_input");
        if(selector.val()<selector.attr('min')*1)
        {
            tooltip("<div class='stt_mistake'>Số điểm nhập vào không được nhỏ hơn "+selector.attr('min')+"</div>",2000);
            return false;
        }
        if(selector.val()>selector.attr('max')*1)
        {
            tooltip("<div class='stt_mistake'>Số điểm nhập vào không được lớn hơn "+selector.attr('max')+"</div>",2000);
            return false;
        }
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
            beforeSend:function()
            {
                $(".form_into_money").html("Đang thực hiện chuyển...");  
            },
			data : 
			{
				type:'user_score_into_money',
                score:selector.val()
			},
			success : function (result)
			{
				$(".form_into_money").html(result);
			},
            error:function()
            {
                $(".form_into_money").html("Lỗi kết nối");
            }
		});
    }
}
function starloadjs()
{
	user_info=new f_user_info();
    user_action=new f_user_action();
}
user_info="";
user_action="";
$(window).ready(starloadjs());