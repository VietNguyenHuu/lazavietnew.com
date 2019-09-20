<?php
    if($this->UserModel->get($idname,'m_level')>2)
	{
		$id_parent=$this->input->post('id_parent');
		$title=$this->input->post('title');
		$temp=$this->PostTypeModel->add(Array(
       
            'id_parent'=>$id_parent,
            'title'=>$title
       ));
        if($temp!=false)
        {
            echo "Đã thêm mục ".$title;
        }
        else
        {
            echo "Kông thêm được mục";
        }
	}
	else
	{
		echo "Cần quyền quản trị";
	}
?>