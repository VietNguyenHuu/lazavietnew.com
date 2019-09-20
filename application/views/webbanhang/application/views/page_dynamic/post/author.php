<?php
include_once("application/views/page_dynamic/post/include_post_header.php");
?>
<div class="width_max1300px">
<?php
    $author_user=$this->UserModel->get_row(strpage()->decode($data['str_author'])['pagenumber']);
    if($author_user==false)
    {
        echo "<div class='stt_mistake'>Tác giả không khả dụng !</div>";
    }
    else
    {
        echo "<div class='page_title'>Tác giả / <h1 class='display_inline_block'>".str_to_view($author_user->m_realname)."</h1><a class='float_right margin_t fontsize_d2' href='".$this->UserModel->get_link_from_id($author_user->id)."' title='Xem trang cá nhân của ".str_to_view($author_user->m_realname)."'><i class='fa fa-globe'></i> Xem trang cá nhân</a><div class='clear_both'></div></div>";
        echo "<div class='align_middle author_avata_box'><img class='lazyload author_avata' data-original='".$this->UserModel->get_avata($author_user->id)."'></div>";
        $intro="Tác giả [[realname]] hiện có tất cả [[numpost]] bài viết.<br>";
        $intro.="Đạt được [[numview]] lượt xem và [[numlike]] lượt thích.<br>";
        $intro.="Hiện có [[numfollow]] người đang theo dõi.";
        $realname=$author_user->m_realname;
        $numpost=$this->db->query("SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user=".$author_user->id." AND m_status='public'")->num_rows();
        $numview=$this->db->query("SELECT SUM(m_view) AS numview FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user=".$author_user->id." AND m_status='public' GROUP BY m_id_user")->result();
        if(count($numview)>0)
        {
            $numview=valid_money($numview[0]->numview);
        }
        else
        {
            $numview=0;
        }
        $numlike=$this->db->query("SELECT SUM(m_like) AS numlike FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user=".$author_user->id." AND m_status='public' GROUP BY m_id_user")->result();
        if(count($numlike)>0)
        {
            $numlike=$numlike[0]->numlike;
        }
        else
        {
            $numlike=0;
        }
        $numfollow=$this->db->query("SELECT id FROM ".$this->PostFollowModel->get_table_name()." WHERE m_id_value=".$author_user->id)->num_rows();
        echo "<p class='font_roboto line_height_2 align_middle author_intro'>".str_replace(Array('[[realname]]','[[numpost]]','[[numview]]','[[numlike]]','[[numfollow]]'),Array($realname,$numpost,$numview,$numlike,$numfollow),$intro)."</p>";
        echo "<div class='padding_v margin_v'>".get_str_like_full($page_fb_url)."</div>";
        if($numpost>0)
        {
            $phantrang=page_seperator($numpost,strpage()->decode($data['str_page'])['pagenumber'],25,Array('class_name'=>'page_seperator_item','strlink'=>str_replace(".html","/trang-[[pagenumber]].html",$this->PostAuthorModel->get_link_from_id($author_user->id))));
            $list=$this->db->query("SELECT * FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user=".$author_user->id." AND m_status='public' ORDER BY m_militime DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
            $str="";
            if(count($list)>0)
            {
                foreach($list as $line)
                {
                    $str.="<div class='width_20 padding'>".$this->PostContentModel->get_str_item($line)."</div>";
                }
                $str.="<div class='clear_both'></div>";
                $str.="<div class='page_seperator_box'>".$phantrang['str_link']."</div>";
            }
            echo myhtml_grid(
                "<div class='grid_header_label'>Danh sách bài viết</div>",
                "<div class='grid_content padding'>".$str."</div>"
            );
        }
    }
?>
</div>