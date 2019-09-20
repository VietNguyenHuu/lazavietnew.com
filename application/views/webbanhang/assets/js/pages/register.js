function kt_name()
{
	ten=document.getElementById("register_name").value;
	add="Tên hợp lệ<br>Đang kiểm tra tính khả thi...";
	add_c="avaiable";
	if(ten.length>30||ten.length<8)
	{
		add="Độ dài tên không hợp lệ !";
		add_c="mistake";
	}
	$("#register_check_name").html("<div class='"+add_c+"'>"+add+"</div>");
	if(add_c=="avaiable")
	{
		$.ajax(
		{
			url : "index.php/ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'check_existsname',
				name:ten
			},
			success : function (result)
			{
				var k=result;
				if(k=='1')//tên đã tồn tại
				{
					$("#register_check_name").html("<div class='mistake'>Rất tiếc, Tên này đã tồn tại, hãy chọn tên khác</div>");
				}
				else
				{
					$("#register_check_name").html("<div class='avaiable'>Có thể sử dụng tên này</div>");
				}
			}
		});
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
function kt_pass()
{
	ten=document.getElementById("register_pass").value;
	add="Mật khẩu đủ mạnh";
	add_c="avaiable";
	if(ten.length>20||ten.length<8)
	{
		add="mật khẩu yếu hoặc quá dài !";
		add_c="mistake";
	}
	$("#register_check_pass").html("<div class='"+add_c+"'>"+add+"</div>");
}
function kt_repass()
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
//end kiem tra loi
function register_tick()
{
	if($("#register_checkbox").prop("checked")==true)
	{
		tooltip("Bạn vừa đồng ý với các điều khoản sử dụng !",2000);
	}
	else
	{
		tooltip("Bạn phải đồng ý với điều khoản sử dụng !",2000);
	}
}
function register_reset()
{
	$("#register_check_name").html(" ");
	$("#register_check_pass").html(" ");
	$("#register_check_repass").html(" ");
	$("#register_check_realname").html(" ");
}
function view_policy()
{
	var editform="<div class='padding' id='register_policy'></div>";
	dialog('Điều khoản sử dụng',editform);
	$("#register_policy").append("<div name='policy'>"+$("div[name='policy']").html()+"</div>");
}
function register_go_step(stt)
{
    $("#register_form .step_box").addClass("hide");
    $("#register_form .step_box[stt='"+stt+"']").removeClass("hide");
}
$(window).ready(function(){
	$("#register_form input[type='submit']").click(function(){
		if($("#register_checkbox").prop("checked")!=true)
		{
			tooltip("Bạn phải đồng ý với điều khoản sử dụng",2000);
			return false;
		}
	});
});