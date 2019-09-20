<?php 
	if($this->UserModel->get($idname,'m_level')>3)
	{
		$id=$this->input->post('id');
		if($this->StaticPageModel->del($id)==true)
		{
			echo "Đã xóa 1 mục trong menu";
		}
		else
		{
			echo "Tác vụ thất bại";
		}
	}
	else
	{
		echo "Cần quyền quản trị để xóa mục";
	}
?>