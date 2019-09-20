sign=
{
    count_connect:0,
    send:function()
    {
        var ten_dn=$("#sign_content input[name='name']").val();
        var pass_dn=$("#sign_content input[name='pass']").val();
        if(ten_dn==undefined || pass_dn==undefined)
        {
            dialog("Thông báo đăng nhập","Không được để trống tên hoặc mật khẩu ");
        }
        else
        {
            dialog("Thông báo đăng nhập","<div style='width:400px;margin:20px auto;'>Đang gửi dữ liệu...<br><img style='width:100%;' src='assets/img/system/loading.gif'></div>");
            $.ajax(
            {
                url : "index.php/ajax_center",
                type : "post",
                dateType:"json",
                data : 
                {
                    type:'login',
                    name:ten_dn,
                    pass:pass_dn
                },
                success : function (result)
                {
                    var k=result;
                    if(k=='1')
                    {
                        //alert(result);
                        dialog("Thông báo đăng nhập","Đăng nhập thành công !<br><a href='"+$("#login_rdr").attr('data-rdr')+"'>Nếu không được chuyển trang tự động, hãy nhấn vào đây.</a>");
                        window.location=$("#login_rdr").attr('data-rdr');
                    }
                    else
                    {
                        dialog("Thông báo đăng nhập","<span style='color:#ff0000;'>Tên hoặc mật khẩu không đúng, vui lòng nhập lại</span>");
                    }
                },
                error:function()
                {
                    sign.count_connect++;
                    $("#sign_content div[name='status']").html("<span style='color:#ff0000;'>Sự cố mạng, Kết nối không thành công !</span><br>Đang kết nối lại... <span style='padding:2px 10px;background-color:#ffffaa;color:#00ff00;'>Lần "+sign.count_connect+"</span>");
                    setTimeout("sign.send()",3000);
                }
            });
        }
    }
};
function f_forget_password()
{
    this.load=function()
    {
        var str="";
        str+="<div class='padding_v margin_v'>Hãy nhập vào email của bạn</div>";
        str+="<input type='text' class='forget_password_email_input' placeholder='nhập vào Email'>";
        str+="<span class='button padding' onclick='forget_password.send()'>Lấy mật khẩu</span>";
        dialog("Quên mật khẩu",str);
    }
    this.send=function()
    {
        var email=$(".forget_password_email_input").val();
        if(email==""||email==undefined)
        {
            tooltip("<span class='stt_mistake'>Hãy nhập vào email</span>",2000);
            return false;
        }
        $.ajax(
		{
			url : "ajax_center",
			type : "post",
			dateType:"json",
			data : 
			{
				type:'login_resetpass_send',
				email:email
			},
            beforeSend:function()
            {
                dialog("Quên mật khẩu","<div class='padding_v margin_v'><i class='fa fa-spinner fa-spin'></i> Đang gửi yêu cầu...</div>");
            },
			success : function (result)
			{
			    dialog("Quên mật khẩu",result);
			},
			error:function()
			{
                dialog("Quên mật khẩu","<div class='padding_v margin_v'><span class='stt_mistake'>Sự cố mạng, hãy thực hiện lại sau !</span></div>");
			}
		});
    }
}
function f_login_width_fb()
{
    this.send=function()
    {
        FB.login(function(response) {

       if(response.status==='connected') {
            FB.getLoginStatus(function(response) 
              {
                    statusChangeCallback(response);
              });
       }
     }, {scope: 'public_profile,email',return_scopes: true});
    }
    this.login=function(response)
    {
        $.ajax(
        {
            url : "ajax_center",
            type : "post",
            dateType:"json",
            data : 
            {
                type:'login_width_fb',
                login_id:response.id,
                login_link:response.link,
                login_name:response.name,
                login_email:response.email,
                login_birthday:response.birthday,
                login_gender:response.gender
            },
            success : function (result)
            {
                dialog("Đăng nhập",result);
                if($("#register_successs_autodirect").attr('href')!=undefined)
                {
                    //window.location=$("#register_successs_autodirect").attr('href');
                    window.location=$("#login_rdr").attr('data-rdr');
                }
            },
            error:function()
            {
                tooltip("<span class='stt_mistake'>Lỗi kết nối, hãy thực hiện lại !</span>");
            }
        });
    }
    this.check_username=function()
    {
        ten=$("#register_width_fb_name").val();
    	add="Tên hợp lệ<br>Đang kiểm tra tính khả thi...";
    	add_c="stt_avaiable";
    	if(ten.length>20||ten.length<2)
    	{
            add="Độ dài tên không hợp lệ !<br>Tên hợp lệ phải từ 2 đến 20 ký tự";
            add_c="stt_mistake";
            tooltip("<div class='"+add_c+"'>"+add+"</div>",2000);
            return false;
    	}
    	else
        {
            if(ten.match(/[^a-zA-Z0-9 _]/gi))
            {
                add="Tên đăng ký chỉ được chứa ký tự chữ không dấu,<br> số, khoảng trắng và dấu gạch dưới '_'";
        		add_c="stt_mistake";
                tooltip("<div class='"+add_c+"'>"+add+"</div>",2000);
                return false;
            }
        }
    	if(add_c=="stt_avaiable")
    	{
            $.ajax(
            {
                url : "ajax_center",
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
                    off_tooltip(-1);
                    if(k=='1')//tên đã tồn tại
                    {
                            tooltip("<div class='stt_mistake'>Rất tiếc, Tên này đã tồn tại, hãy chọn tên khác</div>",2000);
                    }
                    else
                    {
                            tooltip("<div class='stt_avaiable'>Có thể sử dụng tên này</div>",2000);
                    }
                }
            });
    	}
    }
    this.check_pass=function()
    {
    	ten=$("#register_width_fb_pass").val();
    	add="Mật khẩu đủ mạnh";
    	add_c="stt_avaiable";
    	if(ten.length>20||ten.length<2)
    	{
            add="Mật khẩu chỉ được từ 2 đến 20 ký tự !";
            add_c="stt_mistake";
    	}
    	tooltip("<div class='"+add_c+"'>"+add+"</div>",2000);
    }
    this.check_repass=function()
    {
    	repass=$("#register_width_fb_repass").val();
    	pass=$("#register_width_fb_pass").val();
    	add="Mật khẩu lặp lại đúng";
    	add_c="stt_avaiable";
    	if(repass!=pass)
    	{
            add="Mật khẩu không trùng khớp !";
            add_c="stt_mistake";
    	}
    	tooltip("<div class='"+add_c+"'>"+add+"</div>",2000);
    }
    this.register=function()
    {
        $.ajax(
        {
            url : "ajax_center",
            type : "post",
            dateType:"json",
            data : 
            {
                type:'login_width_fb_register',
                r_repass:$("#register_width_fb_repass").val(),
                r_pass:$("#register_width_fb_pass").val(),
                r_username:$("#register_width_fb_name").val(),
                r_realname:$("#register_width_fb_realname").val(),
                r_id:$("#register_width_fb_id").val()
            },
            success : function (result)
            {
                $("#register_width_fb_error_box").html(result);
                if($("#register_successs_autodirect").attr('href')!=undefined)
                {
                    //window.location=$("#register_successs_autodirect").attr('href');
                    window.location=$("#login_rdr").attr('data-rdr');
                }
                else
                {
                    //$("#register_width_fb_error_box").html(result);
                    $("#register_width_fb_error_box").show();
                }
            }
        });
    }
}
//facebook sdk
function statusChangeCallback(response) 
{
    console.log('statusChangeCallback');
    console.log(response);
    if (response.status === 'connected') 
    {
        testAPI();
    } 
    else if (response.status === 'not_authorized') 
    {
        document.getElementById('facebook_status').innerHTML = 'Please log ' +
        'into this app.';
    } 
    else 
    {
        document.getElementById('facebook_status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
}
function checkLoginState() 
{
    FB.getLoginStatus(function(response) 
    {
        statusChangeCallback(response);
    });
}

window.fbAsyncInit = function() 
{
    FB.init(
    {
        appId      : 177034759502189,
        cookie     : true,  // enable cookies to allow the server to access 
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.9' // use graph api version 2.5
    });

    FB.getLoginStatus(function(response) 
    {
          //statusChangeCallback(response);
    });
};

// Load the SDK asynchronously
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function testAPI() 
{
    FB.api('/me', function(response) 
    {
        login_width_fb.login(response);
    });
}
//end facebook sdk
login_width_fb="";
forget_password="";
//login_width_google="";
$(window).ready(function()
{
    forget_password=new f_forget_password();
    login_width_fb=new f_login_width_fb();
    //login_width_google=new f_login_width_google();
});