<div class="width_max1300px">
<?php
    include_once("application/views/page_dynamic/post/include_post_header.php");

    echo "<div class='width3 width3_0_12 width3_980_9 post_tag_contain'>";
        $tags_word=$data['tags_word'];
        if($tags_word!="")
        {
            $page=1;
            if(strpage()->decode($data['str_page'])['pagetype']=='trang')
            {
                $page=strpage()->decode($data['str_page'])['pagenumber'];
            }
            if($page<1)
            {
                $page=1;
            }
            $tags_word=str_replace(Array('-'),Array(' '),$tags_word);
            $list_tags_num=$this->db->query("SELECT id FROM ".$this->PostTagsModel->get_table_name()." WHERE (m_title_search='".mystr()->addmask($tags_word)."')")->num_rows();
            echo "<h1 class='page_title'><i class='fa fa-tags fa-rotate-270'></i> TAGS / <span class='fontsize_d2'>".str_to_view($tags_word)." <span class='stt_tip'>_ ".$list_tags_num." bài viết</span></span></h1>";
            if($list_tags_num>0)
            {
                $phantrang=page_seperator($list_tags_num,$page,24,Array('class_name'=>'page_seperator_item','strlink'=>site_url('post/tags/'.$data['tags_word'].'/trang-[[pagenumber]]')));
                $list_tags=$this->db->query("SELECT m_id_post FROM ".$this->PostTagsModel->get_table_name()." WHERE (m_title_search='".mystr()->addmask($tags_word)."') ORDER BY m_id_post DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
                if(count($list_tags)>0)
                {
                    echo "<div class='post_tags_list'>";
                    foreach($list_tags as $line)
                    {
                        echo "<div class='width_40 padding'>".$this->PostContentModel->get_str_item($this->PostContentModel->get_row($line->m_id_post))."</div>";
                    }
                    echo "<div class='clear_both'></div>";
                    echo "</div>";
                }
                echo "<div class='page_seperator_box'>".$phantrang['str_link']."</div>";
                echo "<div class='padding_v margin_v'><div class='fontsize_a2'><i class='fa fa-share'></i> Chia sẻ tag <b>".$tags_word."</b> tới bạn bè để mọi người cùng đọc nhé !</div><div class='margin_t'>".get_str_like_full($page_fb_url)."</div></div>";   
            }
        }
    echo "</div>";
    echo "<div class='width3 width3_0_12 width3_980_3 padding_l post_tag_navi'>";
        if($tags_word!="")
        {
            //tags liên quan
            $list_tags_lq=$this->db->query("SELECT * FROM ".$this->PostTagsModel->get_table_name()." WHERE (MATCH(m_title_search)AGAINST('".mystr()->addmask($tags_word)."')) GROUP BY m_title_search ORDER BY MATCH(m_title_search)AGAINST('".mystr()->addmask($tags_word)."') DESC LIMIT 0,20")->result();
            if(count($list_tags_lq)>0)
            {
                echo "<div class='margin_v padding_v post_tags_box navi_item'><div class='stt_tip navi_item_header'><i class='fa fa-tags fa-rotate-270 fa-2x'></i> TAGS liên quan</div>";
                echo "<div class='navi_submenu'>";
                foreach($list_tags_lq as $line)
                {
                    echo "<a href='".$this->PostTagsModel->get_link_from_id($line->id)."' class='bg_highlight padding margin font_roboto post_tags_item'><i class='fa fa-tag'></i> ".str_to_view($line->m_title)."</a>";
                }
                echo "</div>";
                echo "</div>";
            }
        }
        //end tags liên quan
    echo "</div>";
    echo "<div class='clear_both'></div>";
?>
</div>