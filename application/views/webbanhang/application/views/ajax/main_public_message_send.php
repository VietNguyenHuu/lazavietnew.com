<?php 
	$email=$this->input->post('email');
	$content=$this->input->post('content');
    $fromlink=$this->input->post('fromlink');
	if($this->UserModel->check_exit($idname))
	{
		$id_user=$idname;
	}
	else
	{
		$id_user=-1;
	}
	if($this->PublicMessageModel->add($data=Array(
       
        'id_user'=>$id_user,
        'email'=>$email,
        'content'=>$content,
        'strtime'=>TimeHelper()->_strtime,
        'fromlink'=>$fromlink
   ))!=false)
    {
        echo "Đã gửi tin nhắn";
    }
    else
    {
        echo "Tác vụ thất bại";
    }
	
?>