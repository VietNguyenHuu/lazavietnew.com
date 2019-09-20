<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $title=$this->input->post('title');
        if($title==""||$title=='undefined')
        {
            echo "<div class='stt_mistake'>Nhập tên tags để tìm</div>";
        }
        else
        {
            //tags liên quan
            $list_tags_lq=$this->db->query("SELECT * FROM ".$this->PostTagsModel->get_table_name()." WHERE (MATCH(m_title_search)AGAINST('".mystr()->addmask($title)."')) GROUP BY m_title ORDER BY MATCH(m_title_search)AGAINST('".mystr()->addmask($title)."') DESC LIMIT 0,20")->result();
            if(count($list_tags_lq)>0)
            {
                echo "<div class='margin_v padding_v post_tags_box'><b class='stt_tip'><i class='fa fa-tags fa-rotate-270'></i> TAGS liên quan: </b>";
                foreach($list_tags_lq as $line)
                {
                    echo "<a href=\"javascript:admin_post_content.addtags_assign_search('".str_to_view($line->m_title,false)."')\" class='bg_highlight padding margin font_roboto post_tags_item' style='display:inline-block'><i class='fa fa-tag'></i> ".str_to_view($line->m_title)."</a>";
                }
                echo "</div>";
            }
            else
            {
                echo "<div class='stt_tip'>Tags chưa có sẵn</div>";
            }
            //end tags liên quan
        }
    }
?>