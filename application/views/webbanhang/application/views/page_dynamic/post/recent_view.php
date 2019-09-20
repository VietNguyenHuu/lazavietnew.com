<div class="width_max1300px">
<?php
include_once("application/views/page_dynamic/post/include_post_header.php");

    $page=(int)$data['page'];
    if($page<1)
    {
        $page=1;
    }
    echo "<div class='page_title'><i class='fa fa-star-o'></i> Bài viết được quan tâm gần đây</div>";
    $total=$this->db->query("SELECT id FROM post_content WHERE m_status='public' LIMIT 0,100")->num_rows();
    if($total<1)
    {
        echo "<div class='stt_tip'>Không có bài viết nào được hiển thị tại đây !</div>";
    }
    else
    {
        $phantrang=page_seperator($total,$page,24,Array('class_name'=>'page_seperator_item','strlink'=>"bai-viet-quan-tam/trang-[[pagenumber]].html"));
        $list=$this->db->query("SELECT post_content.id  AS id,post_view.m_3day AS m_3day FROM post_content,post_view WHERE (post_content.m_status='public' AND post_content.id=post_view.id_post) ORDER BY m_3day DESC,id DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
        if($list==false||$list==null||count($list)<1)
        {
            echo "<div class='stt_tip'>Không có bài viết nào được hiển thị tại đây</div>";
        }
        else
        {
            echo "<div class='width3 width3_0_12 width3_980_9'>";
                foreach($list as $item)
                {
                    $post_row=$this->PostContentModel->get_row($item->id);
                    if($post_row!=false)
                    {
                        $post_row->m_view_recent=$item->m_3day;
                    }
                    echo "<div class='width_40 padding'>".$this->PostContentModel->get_str_item_recent_view($post_row)."</div>";
                }
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