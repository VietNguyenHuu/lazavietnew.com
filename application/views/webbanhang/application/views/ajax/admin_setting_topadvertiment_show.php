<?php 
	if($this->UserModel->get($idname,'m_level')>3)
	{
		$id=$this->input->post('id');
		if($this->AdvertimentModel->check_exit($id))
		{
			$this->AdvertimentModel->set($id,'m_status',"on");
			echo "Đã hiện 1 mục trong quảng cáo chính";
		}
		else
		{
			echo "Tác vụ thất bại";
		}
	}
	else
	{
		echo "Cần quyền quản trị để ẩn mục";
	}
?>