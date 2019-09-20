<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $post_group_row=$this->PostGroupModel->get_row($this->input->post('idgroup'));
        if($post_group_row==false)
        {
            echo "<div class='stt_mistake'>Nhóm bài viết không khả dụng để thêm bài viết</div>";
        }
        else
        {
            $post_row=$this->PostContentModel->get_row($this->input->post('idpost'));
            if($post_row==false)
            {
                echo "<div class='stt_mistake'>Bài viết không khả dụng để thêm vào nhóm</div>";
            }
            else
            {
                $isadd=true;
                if($post_row->m_id_group!=-1)//có thể bài viết đang thuộc một nhóm khác
                {
                    if($this->PostGroupModel->check_exit($post_row->m_id_group)==true)//và nhóm khác thật sự còn tồn tại
                    {
                        if($post_row->m_id_group==$post_group_row->id)
                        {
                             echo "<div class='stt_tip'>Bài viết đã được thêm vào nhóm từ trước</div>";
                        }
                        else
                        {
                             echo "<div class='stt_mistake'>Bài viết đang thuộc một nhóm khác</div>";
                        }
                        $isadd=false;
                    }
                }
                if($isadd==true)
                {
                    //set m_id_group
                    $this->PostContentModel->set($post_row->id, "m_id_group", $post_group_row->id);
                    //set m_group_index
                    $last_index=$this->db->query("SELECT m_group_index FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_group=".$post_group_row->id." ORDER BY m_group_index DESC LIMIT 0,1")->result();
                    if($last_index==null || $last_index==false || count($last_index)<1)
                    {
                        $last_index=0;
                    }
                    $this->PostContentModel->set($post_row->id, "m_group_index", ($last_index[0]->m_group_index+1));
                    echo "<div class='stt_avaiable'>Đã thêm bài viết vào nhóm</div>";
                }
            }
        }
    }
?>