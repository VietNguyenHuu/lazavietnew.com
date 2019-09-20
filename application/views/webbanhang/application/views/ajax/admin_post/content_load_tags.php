<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $post_row=$this->PostContentModel->get_row($this->input->post('id'));
        if($post_row==false)
        {
            echo "<div class='stt_mistake'>Bài viết không khả dụng</div>";
        }
        else
        {
            echo "<div class='padding_v'>".str_to_view($post_row->m_title)." - (<i class='fa fa-search stt_action stt_avaiable' onclick=\"admin_post_content.addtags_assign_search('".str_to_view($post_row->m_title,false)."')\"></i>)</div>";
            //list tags
            $list_tags=$this->db->query("SELECT * FROM ".$this->PostTagsModel->get_table_name()." WHERE (m_id_post=".$post_row->id.") ORDER BY id ASC")->result();
            $str_tags="";
            if(count($list_tags)<1)
            {
                $str_tags.="<spn class='stt_tip'>Chưa có tags cho bài viết này</span>";
            }
            else
            {
                foreach($list_tags as $line)
                {
                    $str_tags.="<span class='bg_highlight padding margin display_inline_block'>".str_to_view($line->m_title)." <i class='fa fa-times stt_mistake margin_l stt_action' onclick='admin_post_content.deltags(".$post_row->id.",".$line->id.")'></i></span>";
                }
            }
            echo "<div class='padding_v' style='line-height:2em'>TAGS: ".$str_tags."</div>";
            //form add tags
            echo "<div class='margin_t'>Thêm tags</div>";
            echo "<div class='padding_v line_height_2'><input class='margin_b admin_post_tags_add_input' type='text' placeholder='Nhập tên tags'><span class='button padding margin_r gray' onclick='admin_post_content.addtags_search()'><i class='fa fa-search'></i> Tìm</span><span class='button padding' onclick='admin_post_content.addtags(".$post_row->id.")'>Thêm</span></div>";
            echo "<div class='padding_v admin_post_tags_add_search_result'></div>";
        }
    }
?>