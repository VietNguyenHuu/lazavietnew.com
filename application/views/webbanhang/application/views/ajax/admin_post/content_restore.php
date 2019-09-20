<?php
    if($this->UserModel->get($idname,'m_level')>2)
	{
		$id=$this->input->post('id');
		$title=$this->PostContentModel->get($id,'m_title');
		if($this->PostContentModel->set($id,'m_status','ready')==true)
		{
            if($this->PostContentModel->get($id,'m_id_user_check')!=-1)
            {
                $this->PostContentModel->set($id,'m_status','public');
            }
			echo "Đã khôi phục bài viết ".$title;
		}
		else
		{
			echo "Không khôi phục được bài viết";
		}
	}
	else
	{
		echo "Cần quyền quản trị";
	}
?>