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
    echo "<h1 class='page_title radius_none'><i class='fa fa-tags fa-rotate-270'></i> Tags bài viết nổi bật</h1>";
    $total=$this->db->query("SELECT id FROM post_tags GROUP BY m_title LIMIT 0,100")->num_rows();
    if($total<1)
    {
        echo "<div class='stt_tip'>Không có tag bài viết nào được hiển thị tại đây !</div>";
    }
    else
    {
        $phantrang=page_seperator($total,$page,24,Array('class_name'=>'page_seperator_item','strlink'=>"post/all_tag/trang-[[pagenumber]]"));
        $list=$this->db->query("SELECT *,COUNT(m_title) AS sd FROM post_tags GROUP BY m_title ORDER BY sd DESC,id DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
        if($list==false||$list==null||count($list)<1)
        {
            echo "<div class='stt_tip'>Không có tag bài viết nào được hiển thị tại đây</div>";
        }
        else
        {
            echo "<div class='width3 width3_0_12 width3_980_9'>";
                $str_post_header=<<<EOD
<div class='padding post_tag_header'>
    <div class='width3 width3_0_12 width3_980_4'>
        <div class='width3 width3_0_12 font_roboto fontsize_a2'><i class='fa fa-tag'></i> TAG</div>
        <div class='clear_both'></div>
    </div>
    <div class='width3 width3_0_12 width3_980_3'>
        <div class='width3 width3_0_4 font_roboto fontsize_a2'><i class='fa fa-circle'></i> Số bài</div>
        <div class='width3 width3_0_8 font_roboto fontsize_a2'><i class='fa fa-clock-o'></i> Cập nhật</div>
        <div class='clear_both'></div>
    </div>
    <div class='width3 width3_0_12 width3_720_5'>
        <span class='font_roboto fontsize_a2'><i class='fa fa-pencil'></i> Bài viết mới</span>
    </div>
    <div class='clear_both'></div>
</div>
EOD;
$str_post_item=<<<EOD
<div class='padding post_tags_item'>
    <div class='width3 width3_0_12 width3_980_4'>
        <div class='width3 width3_0_12 post_tags_item_tag'><a href='{{taglink}}' title='{{tagtitle}}'><i class='fa fa-tag'></i> {{tagtitle}}</a></div>
        <div class='clear_both'></div>
    </div>
    <div class='width3 width3_0_12 width3_980_3'>
        <div class='width3 width3_0_4 post_tags_item_numtag'>{{numtag}}</div>
        <div class='width3 width3_0_8 post_tags_item_lastupdate'><span class='fontsize_d2 stt_tip'>{{lastupdate}}</span></div>
        <div class='clear_both'></div>
    </div>
    <div class='width3 width3_0_12 width3_980_5'>
        <a class='post_tags_item_lastpost' href='{{lastposthref}}' title='{{lastposttitlese}}'><img class='margin_r display_inline_block align_middle post_tags_item_lastpost_image' src='{{lastpostimage}}' title='{{lastposttitlese}}' alt='{{lastposttitlese}}' /><span class='align_middle fontsize_d2 font_roboto'>{{lastposttitle}}</span></a>
    </div>
    <div class='clear_both'></div>
</div>
EOD;
                echo $str_post_header;
                echo "<div class='post_tag_list'>";
                foreach($list as $line)
                {
                    $lastpost=$list_tags=$this->db->query("SELECT m_id_post FROM ".$this->PostTagsModel->get_table_name().",".$this->PostContentModel->get_table_name()." WHERE (".$this->PostTagsModel->get_table_name().".m_id_post=".$this->PostContentModel->get_table_name().".id AND ".$this->PostTagsModel->get_table_name().".m_title_search='".mystr()->addmask($line->m_title)."' AND m_status='public') ORDER BY m_id_post DESC LIMIT 0,1")->row();
                    if($lastpost!=null&&$lastpost!=false)
                    {
                        $lastpost=$this->PostContentModel->get_row($lastpost->m_id_post);
                        if($lastpost!=false)
                        {
                            $ar_patern=Array(
                                '{{tagtitle}}'=>str_to_view($line->m_title),
                                '{{taglink}}'=>$this->PostTagsModel->get_link_from_id($line->id),
                                '{{numtag}}'=>$line->sd,
                                '{{lastupdate}}'=>my_time_ago_str($lastpost->m_militime),
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