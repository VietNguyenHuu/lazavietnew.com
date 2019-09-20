<div class="width_max1300px">
<?php
    $search_word=strip_tags($data['search_word']);
    include_once("application/views/page_dynamic/post/include_post_header.php");

    echo "<div class='width3 width3_0_12 width3_980_9 post_search_contain'>";
        $str="<div class='post_search_headder'>";
        $str.="<div class='page_title'><i class='fa fa-search'></i> Tìm kiếm bài viết<span class='fontsize_d2'> / ".str_to_view($data['search_word'])."</span></div>";
        $str.="</div>";
        $str_kq="";
        $page=(int)$data['page'];
        if($page<1)
        {
            $page=1;
        }
        $str_query_quere=Array();
        array_push($str_query_quere,"m_status='public'");
        if($search_word!="")
        {
            array_push($str_query_quere,"MATCH(m_title_search)AGAINST('".mystr()->addmask(str_to_view(bodau($search_word)))."')");
        }
        $str_query_quere="WHERE (".implode(" AND ",$str_query_quere).")";
        $str_query="SELECT id FROM ".$this->PostContentModel->get_table_name()." ".$str_query_quere;
        
        $max=$this->db->query($str_query)->num_rows();
        if($max<1)
        {
            $str_kq.="<div class='stt_tip'>Không tìm thấy bài viết phù hợp !</div>";
        }
        else
        {
            $phantrang=page_seperator($max,$page,40,Array('class_name'=>'page_seperator_item','strlink'=>site_url("post/search/?w=")."".urlencode($search_word)."&p=[[pagenumber]]"));
            $list=$this->db->query($str_query." LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
            if(count($list)<1)
            {
                
            }
            else
            {
                $str_kq.="<div class='margin_v padding_v'><i class='fa fa-folder-open'></i> Tất cả <b>".$max."</b> kết quả tìm kiếm bài viết</div>";
                foreach($list as $line)
                {
                    $str_kq.="<div class='width_40 padding post_search_item2'>".$this->PostContentModel->get_str_item($this->PostContentModel->get_row($line->id))."</div>";
                }
                $str_kq.="<div class='clear_both'></div>";
                $str_kq.="<div class='page_seperator_box'>".$phantrang['str_link']."</div>";
            }
        }
        $str.="<div class='post_search_result_box'>".$str_kq."</div>";
        echo $str;
    echo "</div>";
    echo "<div class='width3 width3_0_12 width3_980_3 padding_l post_search_navi'>";
        //facebook
        $str="<div class='navi_item'>";
    		$str.="<div class='navi_item_header'><i class='fa fa-facebook margin_r fa-2x align_middle'></i><span class='align_middle'>Theo dõi chúng tôi</span>";
    		$str.="</div>";
    		$str.="<div class='navi_submenu'>";
                $str.=get_str_fb_fanpage(Array('fanpage'=>$page_fb_fanpage,'fanpage_title'=>$page_fb_fanpage_title));
            $str.="</div>";
    	$str.="</div>";
        echo $str;
        //end facebook
    echo "</div>";
    echo "<div class='clear_both'></div>";
?>
</div>