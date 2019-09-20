<?php
    if($this->UserModel->get($idname,'m_level')>3)
    {
    	$id=$this->input->post('id');
    	$this->ContributeModel->del($id);
    	echo "Đã xóa một mục trong ý kiến người dùng";
    }
    else
    {
    	echo "Cần quyền quản trị để xóa mục";
    }
?>