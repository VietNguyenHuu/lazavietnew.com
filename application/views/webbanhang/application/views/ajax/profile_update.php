<?php 
    $id=$this->input->post('id');
	$realname=$this->input->post('realname');
	$sex=$this->input->post('sex');
	$birth=$this->input->post('birth');
	$oldpass=$this->input->post('oldpass');
	$newpass=$this->input->post('newpass');
	$phone=$this->input->post('phone');
	$email=$this->input->post('email');
	$province_code2=$this->input->post('province_code');
	$address=$this->input->post('address');
    
    $user=$this->UserModel;
	if($user->check_exit($id)&&$id==$idname)
	{
		$str="";
		if($realname!=$user->get($id,'m_realname'))
		{
			if(strlen($realname)<8||strlen($realname)>50)
			{
				$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa Họ và tên thành  <b>".$realname." </b></div>";
			}
			else
			{
				$user->set($id,'m_realname',$realname);
				$str.="<div class='avaiable'><img src='assets/img/system/tick.png'>Đã sửa Họ và tên thành <b>".$realname."</b></div>";
			}
		}
		if($sex!=$user->get($id,'m_sex'))
		{
			if(!in_array($sex,Array('0','1')))
			{
				$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa giới tính</div>";
			}
			else
			{
				$user->set($id,'m_sex',$sex);
				if($sex==0)
				{
					$temp="Nữ";
				}
				else
				{
					$temp="Nam";
				}
				$str.="<div class='avaiable'><img src='assets/img/system/tick.png'>Đã sửa giới tính thành <b>".$temp."</b></div>";
			}
		}
		if($birth!=$user->get($id,'m_birth'))
		{
			if($birth<1970||$birth>TimeHelper()->_nam)
			{
				$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa năm sinh thành  <b>".$birth."</b></div>";
			}
			else
			{
				$user->set($id,'m_birth',$birth);
				$str.="<div class='avaiable'><img src='assets/img/system/tick.png'>Đã sửa năm sinh thành <b>".$birth."</b></div>";
			}
		}
		if(md5($newpass)!=$user->get($id,'m_pass')&&!empty($newpass))
		{
			if(md5($oldpass)!=$user->get($id,'m_pass'))
			{
				$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa password thành  <b>".$newpass."</b> do mật khẩu cũ nhập vào không trùng khớp.</div>";
			}
			else if(strlen($newpass)<8||strlen($newpass)>20)
			{
				$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa password thành  <b>".$newpass."</b> do mật khẩu mới không hợp lệ, mật khẩu hợp lệ phải có độ dài từ 8 đến 20 ký tự.</div>";
			}
			else
			{
				$user->set($id,'m_pass',md5($newpass));
				$str.="<div class='avaiable'><img src='assets/img/system/tick.png'>Đã sửa password thành <b>".$newpass."</b></div>";
			}
		}
		if($phone!=$user->get($id,'m_phone'))
		{
			if(preg_match("/[^0-9]/",$phone)||strlen($phone)<8||strlen($phone)>15)
			{
				$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa số điện thoại thành  <b>".$phone."</b></div>";
			}
			else
			{
				if($user->check_exit_phone($phone)!=false)
				{
					$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa số điện thoại thành  <b>".$phone."</b></div>";
				}
				else
				{
					$user->set($id,'m_phone',$phone);
					$str.="<div class='avaiable'><img src='assets/img/system/tick.png'>Đã sửa số điện thoại thành <b>".$phone."</b></div>";
				}
			}
		}
		if($email!=$user->get($id,'m_email'))
		{
			if(!filter_var($email,FILTER_VALIDATE_EMAIL))
			{
				$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa email thành  <b>".$email."</b></div>";
			}
			else
			{
			     if($user->check_exit_email($email)!=false)
				{
					$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa email thành  <b>".$email."</b></div>";
				}
				else
				{
				    $user->set($id,'m_email',$email);
				    $str.="<div class='avaiable'><img src='assets/img/system/tick.png'>Đã sửa email thành <b>".$email."</b></div>";
				}
			}
		}
		if($province_code2!=$user->get($id,'m_province_code'))
		{
 
			if($this->ProvinceCodeModel->check_exit($province_code2)==false)
			{
				$str.="<div class='mistake'><img src='assets/img/system/error.png'>Không thể sửa tên tỉnh</div>";
			}
			else
			{
				$user->set($id,'m_province_code',$province_code2);
				$str.="<div class='avaiable'><img src='assets/img/system/tick.png'>Đã sửa tên tỉnh thành <b>".$this->ProvinceCodeModel->get($province_code2,"m_title")."</b></div>";
			}
		}
		
		if($address!=$user->get($id,'m_address'))
		{
			$user->set($id,'m_address',$address);
			$str.="<div class='avaiable'><img src='assets/img/system/tick.png'>Đã sửa địa chỉ thành <b>".$address."</b></div>";
		}
		echo $str;
	}
	else
	{
		echo "Không thể cập nhật thông tin";
	}
?>