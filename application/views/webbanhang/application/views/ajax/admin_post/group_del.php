<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $del_id=$this->input->post('del_id');
        $post_group_row=$this->PostGroupModel->get_row($del_id);
        if($post_group_row==false)
        {
            echo "<div class='stt_mistake'>Nhóm bài viết không khả dụng để xoá</div>";
        }
        else
        {
            if($this->PostGroupModel->del($post_group_row->id)!=false)
            {
                echo "<div class='stt_avaiable'>Nhóm bài viết đã được xoá thành công</div>";
            }
            else
            {
                echo "<div class='stt_mistake'>Không xoá được nhóm bài viết</div>";
            }
        }
    }
?>