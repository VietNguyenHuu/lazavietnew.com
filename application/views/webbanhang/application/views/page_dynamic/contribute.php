<div class="width_max1300px">
<?php 
	if($idname!=""||$this->UserModel->check_exit($idname))
	{
		$ky_danh=$this->UserModel->get($idname,'m_realname');
	}
	else
	{
		$ky_danh="Khách tham quan";
	}
?>
<div name='sending_status'></div>
<div name='title'>Form tiếp nhận ý kiến đóng góp người dùng - Version 1.0</div>
<div name='contribute_content'>
	<div name='ky_danh'><span class='label'>Ký danh:</span> <span name='n'><?php echo $ky_danh?></span></div>
	<textarea name='opinion' placeholder='Viết gì đó để gửi đi...'></textarea>
	<input type='checkbox' id='contribute_andanh' onclick='contribute.togle_andanh()'></span><label for='contribute_andanh' style='font-size:18px;margin-left:10px;font-weight:normal;'>Gửi ở chế độ ẩn danh</label>
	<span name='contribute_submit' onclick='contribute.send()' class='button stt_action padding float_right'>Gửi phản hồi</span>
</div>
</div>