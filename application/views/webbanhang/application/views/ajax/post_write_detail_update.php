<?php
    if($this->UserModel->get($idname,'m_level')>0)
	{
	   $id=$this->input->post('id');
       $id_type=$this->input->post('id_type');
		$title=$this->input->post('title');
		$content=$this->input->post('content');
		$avata=$this->input->post('avata');
		if($this->PostContentModel->check_exit($id)==false)
        {
            echo "<div class='stt_mistake'>Bài viết không khả dụng</div>";
        }
        else
        {
            if($title!=""&&$title!='undefined')
            {
                $this->PostContentModel->set($id,'m_title',$title);
                $this->PostContentModel->set($id,'m_content',$content);
                if($this->PostTypeModel->check_exit($id_type)==true)
                {
                    $this->PostContentModel->set($id,'m_id_type',$id_type);
                }
                if($avata!=""&&$avata!='undefined')
                {
                    $this->PostContentModel->set_avata($id,$avata);
                }
                echo "<div class='stt_avaiable'>Đã chỉnh sửa bài viết.</div>";
                echo "<div class='align_center'><a href=\"javascript:window.location=location.href\"><span class='button padding'>Làm mới trang</span></a><span class='button red padding' onclick='uncaption()'>Đóng</span></div>";
            }
            else
            {
                echo "<div class='stt_mistake'>Không được để trống tiêu đề bài viết</div>";
            }
        }
	}
	else
	{
		echo "Đăng nhập để sửa bài đăng";
	}
?>