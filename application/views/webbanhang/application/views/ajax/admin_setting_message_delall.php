<?php 
	if($this->UserModel->get($idname,'m_level')>3)
	{
		$data=$this->PublicMessageModel->getAll();
		if($data!=false)
        {
            $max=count($data);
    		for($i=0;$i<$max;$i++)
    		{
    			$this->PublicMessageModel->del($data[$i]->id);
    		}
        }
        $data=$this->PublicMessageModel->getAll();
		if($data==false)
        {
            echo "Đã xóa tất cả tin nhắn";
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