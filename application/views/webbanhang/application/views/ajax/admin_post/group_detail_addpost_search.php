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
            echo "<div class='stt_mistake'>Nhóm bài viết không khả dụng để tìm bài viết</div>";
        }
        else
        {
            $word=$this->input->post('word');
            $list=$this->db->query("SELECT id, m_title FROM ".$this->PostContentModel->get_table_name()." WHERE m_status='public' AND m_id_group = -1 AND MATCH(m_title_search)AGAINST('".addslashes(mystr()->addmask($word))."') LIMIT 0,15")->result();
            if(count($list)<1 || $list==false || $list==null)
            {
                echo "<div class='stt_tip'>Không tìm thấy bài viết phù hợp với từ khoá</div>";
            }
            else
            {
                echo "<p class='stt_highlight margin_t'><span class='fontsize_a2'>Tìm được <b>".count($list)."</b> bài viết </span>&nbsp;&nbsp;&nbsp;&nbsp; <span class='fa fa-times button padding gray radius_none fontsize_d2' onclick='$(\"#admin_post_group_detail_search_result_list\").toggleClass(\"hide\")'></span></p>";
                echo "<div class='line_height_2' id='admin_post_group_detail_search_result_list' style='max-height:400px; overflow:auto'>";
                foreach($list as $item)
                {
                    echo "<div class='padding_v admin_post_group_addpost_item_".$item->id."' style='border-bottom:1px dotted #999999'>";
                        echo "<div class='width3 width3_0_12 width3_980_10'><span class='stt_tip'>ID_".$item->id."</span> <span class='fontsize_d1 font_roboto'>".trichdan($item->m_title, 100)."</span></div>";
                        echo "<div class='width3 width3_0_12 width3_980_2 padding_h align_right'>";
                            echo "<span class='fa fa-plus button' title='Thêm vào nhóm' onclick='admin_post_group.addpost(".$post_group_row->id.",".$item->id.")'></span>";
                        echo "</div>";
                        echo "<div class='clear_both'></div>";
                        echo "<div class='alert'></div>";
                    echo"</div>";
                }
                echo "</div>";
            }
        }
    }
?>