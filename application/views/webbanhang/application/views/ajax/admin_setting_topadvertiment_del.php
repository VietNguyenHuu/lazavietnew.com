<?php 
	if($this->UserModel->get($idname,'m_level')>3)
	{
		$id=$this->input->post('id');
		if($this->AdvertimentModel->check_exit($id))
		{
			$this->AdvertimentModel->del($id);
            if($this->AdvertimentModel->check_exit($id))
    		  {
    		      echo "Không xóa được quảng cáo";
    		  }
              else
              {
                echo "Đã xóa 1 mục trong quảng cáo chính";
              }
			
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