<?php 
	$id=$this->input->post('id');
    $l=$this->input->post('l');
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
		if($this->UserModel->get($idname,'m_level')<=$l)
        {
            $str.="Tác vụ Thất bại";
        }
        else
        {
            $this->UserModel->set($id,'m_level',$l);
            if($this->UserModel->get($id,'m_level')!=$l)
            {
                $str.="Tác vụ Thất bại";
            }
            else
            {
                $str.="Thành công";
            }
        }
	}
	echo $str;
?>