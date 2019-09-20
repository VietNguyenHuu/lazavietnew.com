<?php 
	if($this->UserModel->get($idname,'m_level')>2)
	{
		$id=$this->input->post('del_id');
		$title=$this->PostTypeModel->get($id,'m_title');
		if($this->PostTypeModel->del($id)==true)
        {
            echo "Đã xóa danh mục ".$title;
        }
        else
        {
            echo "Không xóa được danh mục";
        }
	}
	else
	{
		echo "Cần quyền quản trị";
	}
?>