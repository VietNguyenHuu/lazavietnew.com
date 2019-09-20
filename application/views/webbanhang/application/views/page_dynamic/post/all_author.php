<?php
include_once("application/views/page_dynamic/post/include_post_header.php");
?>
<div class="width_max1300px">
<?php
    $page=(int)$data['page'];
    if($page<1)
    {
        $page=1;
    }
    echo "<h1 class='page_title'><i class='fa fa-tags fa-rotate-270'></i> Top tác giả bài viết</h1>";
    $total=$this->db->query("SELECT m_id_user FROM post_content,post_view WHERE id_post=id AND m_id_user_check!=-1 GROUP BY m_id_user LIMIT 0,100")->num_rows();
    if($total<1)
    {
        echo "<div class='stt_tip'>Không có tác giả bài viết nào được hiển thị tại đây !</div>";
    }
    else
    {
        $phantrang=page_seperator($total,$page,24,Array('class_name'=>'page_seperator_item','strlink'=>"tac-gia-bai-viet/trang-[[pagenumber]].html"));
        $list=$this->db->query("SELECT m_id_user,COUNT(m_id_user) AS num_post,SUM(m_week) AS view_in_week FROM post_content,post_view WHERE id_post=id AND m_id_user_check!=-1 GROUP BY m_id_user ORDER BY view_in_week DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
        if($list==false||$list==null||count($list)<1)
        {
            echo "<div class='stt_tip'>Không có tác giả bài viết nào được hiển thị tại đây</div>";
        }
        else
        {
            echo "<div class='width3 width3_0_12 width3_980_9'>";
                $str_all_author_header=<<<EOD
<div class='padding all_author_header'>
    <div class='width3 width3_0_12 width3_980_4'>
        <div class='width3 width3_0_12 font_roboto fontsize_a2'><i class='fa fa-user'></i> Tác giả</div>
        <div class='clear_both'></div>
    </div>
    <div class='width3 width3_0_12 width3_980_3'>
        <div class='width3 width3_0_4 font_roboto fontsize_a2'><i class='fa fa-circle'></i> Số bài</div>
        <div class='width3 width3_0_8 font_roboto fontsize_a2'><i class='fa fa-eye'></i> Xem/ tuần</div>
        <div class='clear_both'></div>
    </div>
    <div class='width3 width3_0_12 width3_720_5'>
        <span class='font_roboto fontsize_a2'><i class='fa fa-pencil'></i> Bài viết mới</span>
    </div>
    <div class='clear_both'></div>
</div>
EOD;
$str_post_item=<<<EOD
<div class='padding post_author_item'>
    <div class='width3 width3_0_12 width3_980_4'>
        <div class='width3 width3_0_12 post_author_item_tag'><a href='{{taglink}}' title='{{tagtitlese}}'><img class='margin_r display_inline_block align_middle post_author_item_tag_image' src='{{tagimage}}' title='{{tagtitlese}}' alt='{{tagtitlese}}' /><span class='align_middle'>{{tagtitle}}</span></a></div>
        <div class='clear_both'></div>
    </div>
    <div class='width3 width3_0_12 width3_980_3'>
        <div class='width3 width3_0_4 post_author_item_numtag'>{{numtag}}</div>
        <div class='width3 width3_0_8 post_author_item_lastupdate'><span class='fontsize_d2 stt_tip'>{{lastupdate}}</span></div>
        <div class='clear_both'></div>
    </div>
    <div class='width3 width3_0_12 width3_980_5'>
        <a class='post_author_item_lastpost' href='{{lastposthref}}' title='{{lastposttitlese}}'><img class='margin_r display_inline_block align_middle post_author_item_lastpost_image' src='{{lastpostimage}}' title='{{lastposttitlese}}' alt='{{lastposttitlese}}' /><span class='align_middle fontsize_d2 font_roboto'>{{lastposttitle}}</span></a>
    </div>
    <div class='clear_both'></div>
</div>
EOD;
                echo $str_all_author_header;
                echo "<div class='post_author_list'>";
                foreach($list as $top_author_line)
                {
                    $tem_real_name=$this->UserModel->get($top_author_line->m_id_user,'m_realname');
                        
                    $lastpost=$list_tags=$this->db->query("SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user=".$top_author_line->m_id_user." AND m_status='public' ORDER BY id DESC LIMIT 0,1")->row();
                    if($lastpost!=null&&$lastpost!=false)
                    {
                        $lastpost=$this->PostContentModel->get_row($lastpost->id);
                        if($lastpost!=false)
                        {
                            $ar_patern=Array(
                                '{{tagtitle}}'=>str_to_view($tem_real_name),
                                '{{tagtitlese}}'=>str_to_view($tem_real_name,false),
                                '{{tagimage}}'=>$this->UserModel->get_avata($top_author_line->m_id_user),
                                '{{taglink}}'=>$this->PostAuthorModel->get_link_from_id($top_author_line->m_id_user),
                                '{{numtag}}'=>$top_author_line->num_post,
                                '{{lastupdate}}'=>valid_money($top_author_line->view_in_week),
                                '{{lastposthref}}'=>$this->PostContentModel->get_link_from_row(Array('id'=>$lastpost->id,'m_title'=>$lastpost->m_title)),
                                '{{lastposttitle}}'=>str_to_view($lastpost->m_title),
                                '{{lastposttitlese}}'=>str_to_view($lastpost->m_title, false),
                                '{{lastpostimage}}'=>$this->PostContentModel->get_avata_small($lastpost->id)
                            );
                            
                            echo str_replace(array_keys($ar_patern), array_values($ar_patern), $str_post_item);
                        }
                    }
                }
                echo "</div>";
                echo "<div class='clear_both'></div>";
                echo "<div class='page_seperator_box'>".$phantrang['str_link']."</div>";
            echo "</div>";
            echo "<div class='width3 width3_0_12 width3_980_3'>";
                include_once("application/views/page_dynamic/post/include_post_adver.php");
            echo "</div>";
            echo "<div class='clear_both'></div>";
        }
    }
?>
</div>