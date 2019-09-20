contribute=
{
	normal_name:$("div[name='ky_danh'] span[name='n']").html(),
	count_swf:0,
	send:function()
	{
		if($("#contribute_andanh").prop('checked')==true)
		{
			andanh=1;
		}
		else
		{
			andanh=0;
		}
		nd=$("textarea[name='opinion']").val();
		if(nd==undefined||nd=="")
		{
			alert("Nhập nội dung trước khi gửi phản hồi !");
		}
		else
		{
			$("div[name='sending_status']").html("Đang gửi phản hồi, xin chờ...<br><img src='assets/img/system/loading.gif' style='width:100%;'>");
			$("div[name='sending_status']").show();
			$.ajax(
			{
				url : "ajax_center",
				type : "post",
				dateType:"json",
				data : 
				{
					type:'contribute_send',//gửi phản hồi
					andanh:andanh,
					nd:nd
				},
				success : function (result)
				{
					contribute.count_swf=0;
					$("div[name='sending_status']").html(result);
				},
				error:function()
				{
					$("div[name='sending_status']").html("<span class='mistake'>Sự cố mạng, phản hồi sẽ được gửi lại trong 5s..</span>");
					contribute.count_swf++;
					if(contribute.count_swf<10)
					{
						setTimeout("contribute.send()",5000);
					}
					else
					{
						contribute.count_swf=0;
						$("div[name='sending_status']").html("<span class='mistake'>Không gửi được phản hồi !</span>");
					}
				}
			});
		}
	},
	togle_andanh:function()
	{
		if($("#contribute_andanh").prop('checked')==true)
		{
			$("div[name='ky_danh'] span[name='n']").html("<span style='color:#bbbbbb;'>Ẩn danh</span>");
		}
		else
		{
			$("div[name='ky_danh'] span[name='n']").html(contribute.normal_name);
		}
	}
}