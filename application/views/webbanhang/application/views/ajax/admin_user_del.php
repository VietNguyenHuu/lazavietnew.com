<?php 
	$id=$this->input->post('id');
	$str="";
	if(!$this->UserModel->check_exit($id))
	{
		$str.="Thành viên không tồn tại";
	}
    else if($this->UserModel->get($idname,'m_level')<=$this->UserModel->get($id,'m_level'))
    {
        $str.="Tác vụ không được phép";
    }
	else
	{
		$realname=$this->UserModel->get($id,'m_realname');
        if($this->UserModel->del($id)==false)
        {
            $str.="Không xóa được thành viên ".$realname;
        }
        else
        {
            $str.="Đã xóa thành viên ".$realname;
        }
	}
	echo $str;
?>