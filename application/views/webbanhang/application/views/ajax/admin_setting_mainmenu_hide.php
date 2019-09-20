<?php 
	if($this->UserModel->get($idname,'m_level')>3)
	{
		$id=$this->input->post('id');
		if($this->StaticPageModel->check_exit($id))
		{
			$this->StaticPageModel->set($id,'m_status','off');
			echo "Đã ẩn 1 mục trong menu";
		}
		else
		{
			echo "Tác vụ thất bại";
		}
	}
	else
	{
		echo "Cần quyền quản trị để hiện mục";
	}
?>