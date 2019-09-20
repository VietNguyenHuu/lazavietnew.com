<?php
    if($this->UserModel->get($idname,'m_level')>2)
	{
		$id=$this->input->post('del_id');
		$title=$this->PostContentModel->get($id,'m_title');
		if($this->PostContentModel->del($id)==true)
		{
			echo "Đã xóa bài viết ".$title;
		}
		else
		{
			echo "Không xóa được bài viết";
		}
	}
	else
	{
		echo "Cần quyền quản trị";
	}
?>