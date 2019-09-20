<?php
    if($this->UserModel->get($idname,'m_level')>0)
	{
		$id=$this->input->post('del_id');
        if($this->PostContentModel->del($id)==false)
        {
            echo "<div class='stt_mistake'>Không xóa được bài viết</div>";
        }
        else
        {
            echo "<div class='stt_avaiable'>Đã xóa bài viết.</div>";
            echo "<div class='align_center padding_v margin_v' style='margin-top:2em'><a href='".site_url("quan-ly-bai-viet.html")."'><span class='button padding fontsize_d2'>Tải lại DS bài viết</span></a> <span class='button red padding fontsize_d2' onclick='uncaption()'>Đóng</span></div>";
        }
	}
	else
	{
		echo "Đăng nhập để thực hiện chức năng";
	}
?>
