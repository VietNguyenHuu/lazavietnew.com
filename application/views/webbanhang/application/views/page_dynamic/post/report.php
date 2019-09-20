<div class="width_max1300px">
<?php
    echo "<h1 class='page_title'>Báo cáo sai phạm bài viết</h1>";
    $post_row=$this->PostContentModel->get_row($data['id_post']);
    if($post_row==false)
    {
        echo "<p class='fontsize_a2'>Trân trọng cám ơn bạn đã bỏ chút thời gian để gởi phản hồi cho chúng tôi, nhưng rất tiếc, bài viết bạn muốn báo cáo hiện không khả dụng !</p>";
        
        echo "<p class='fontsize_a3'>Bạn có thể </p>";
        echo "<div class='width_40 padding'><div class='padding' style='background-color: #66ccff;'><a href='".site_url()."><p class='align_center'><i class='fa fa-home fa-3x'></i></p><p class='align_center fontsize_a2'>Về trang chủ</p></a></div></div>";
        echo "<div class='width_40 padding'><div class='padding' style='background-color: #f7b3b3;'><a href='".site_url("contribute")."''><p class='align_center'><i class='fa fa-bug fa-3x'></i></p><p class='align_center fontsize_a2'>Báo cáo lỗi</p></a></div></div>";
        echo "<div class='width_40 padding'><div class='padding' style='background-color: #a0f391;'><a href='".$page_fb_url."><p class='align_center'><i class='fa fa-refresh fa-3x'></i></p><p class='align_center fontsize_a2'>Tải lại trang</p></a></div></div>";
        echo "<div class='width_40 padding'><div class='padding' style='background-color: #66ccff;'><a href='".$page_fb_fanpage."><p class='align_center'><i class='fa fa-facebook-official fa-3x'></i></p><p class='align_center fontsize_a2'>Vào fanpage Facebook</p></a></div></div>";
        echo "<div class='clear_both'></div>";
    }
    else
    {
        echo "<div class='width_max800px'>";
            echo "<h2 class='font_roboto'>Báo lỗi bài viết / ".str_to_view($post_row->m_title)."</h2>";
            echo "<p class='fontsize_a2 padding_v margin_b' style='border-bottom:1px dotted #333333'>Trân trọng cám ơn bạn đã bỏ chút thời gian để gởi phản hồi cho chúng tôi, hãy cho chúng tôi biết bạn gặp phải lỗi gì trong bài viết này !</p>";
            
            
            $list=$this->db->query("SELECT * FROM ".$this->PostReportPatternModel->get_table_name()." ORDER BY m_index ASC")->result();
            if(count($list)>0&&$list!=false)
            {
                foreach($list as $item)
                {
                    echo "<div class='stt_tip margin_v'>";
                        echo "<p class='margin_v font_helvetica'><input type='radio' class='' name='post_report_nd_type' id='post_report_nd_type_".$item->m_index."' value='".$item->id."'>";
                        echo "<label for='post_report_nd_type_".$item->m_index."' class='font_helvetica'>".$item->m_title."</label></p>";
                    echo "</div>";
                }
            }
            echo "<textarea id='post_report_nd_extra' placeholder='Bổ sung về nội dung phản hồi...' style='min-height:3em;width:100%'></textarea>";
            
            echo "<div class='padding_v margin_v'>";
            echo "<select name='post_report_user_id'>";
                echo "<option value='-1'>Khách (ẩn danh)</option>";
                if($idname!=false)
                {
                    echo "<option value='".$idname."' selected='selected'>".$this->UserModel->get($idname,'m_realname')."</option>";
                }
            echo "</select>";
            echo "<span class='button padding' onclick='post_report.send()' id='post_report_send_btn' data-post-id='".$post_row->id."'><i class='fa fa-send'></i> Gửi phản hồi</span>";
            echo "</div>";
        echo "</div>";
    }
?>
</div>