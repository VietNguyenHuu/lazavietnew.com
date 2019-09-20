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
		$this->UserModel->set($id,'m_lock',1);
        if($this->UserModel->get($id,'m_lock')!=1)
        {
            $str.="Tác vụ Thất bại";
        }
        else
        {
            $str.="Đã khóa";
        }
	}
	echo $str;
?>