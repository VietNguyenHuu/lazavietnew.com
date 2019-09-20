<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $post_group_row=$this->PostGroupModel->get_row($this->input->post('id'));
        if($post_group_row==false)
        {
            echo "<div class='stt_mistake'>Nhóm bài viết không khả dụng để sửa</div>";
        }
        else
        {
            $title=$this->input->post('title');
            if(trim($title)==""||$title=="undefined")
            {
                echo "<span class='stt_mistake'>Hãy nhập vào tên nhóm bài viết</span>";
            }
            else
            {
                $description=$this->input->post('description');
                //sửa tên
                if($this->PostGroupModel->set($post_group_row->id, 'm_title', $title)==false)
                {
                    echo "<div class='stt_mistake'>Không sửa được tên nhóm bài viết</div>";
                }
                else
                {
                    echo "<div class='stt_available'>Đã sửa tên nhóm bài viết</div>";
                }
                //sửa mô tả
                if($this->PostGroupModel->set($post_group_row->id, 'm_description', $description)==false)
                {
                    echo "<div class='stt_mistake'>Không sửa được mô tả nhóm bài viết</div>";
                }
                else
                {
                    echo "<div class='stt_available'>Đã sửa mô tả nhóm bài viết</div>";
                }
                
                //sửa hình đại diện
                $avata = $this->input->post('avata');
                if ($avata != "" && $avata != 'undefined') {
                    $this->PostGroupModel->set_avata($post_group_row->id, $avata);
                }
                
                //sửa last modify time
                $this->PostGroupModel->set($post_group_row->id, 'm_militime_modify', time());
                
                echo "<div class='margin_t pading_v align_center'><span class='button padding fontsize_d2' onclick='admin_post_group.loadlist(); uncaption()'>Tải lại danh sách</span></div>";
            }
        }
    }
?>