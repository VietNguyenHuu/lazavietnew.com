<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $del_id=$this->input->post('del_id');
        $post_report_content_row=$this->PostReportModel->get_row($del_id);
        if($post_report_content_row==false)
        {
            echo "<div class='stt_mistake'>Phản hồi bài viết không khả dụng để xoá</div>";
        }
        else
        {
            if($this->PostReportModel->del($post_report_content_row->id)!=false)
            {
                echo "<div class='stt_avaiable'>Phản hồi bài viết đã được xoá thành công</div>";
            }
            else
            {
                echo "<div class='stt_mistake'>Không xoá được phản hồi bài viết</div>";
            }
        }
    }
?>