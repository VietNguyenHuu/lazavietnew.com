<?php
    if($this->UserModel->get($idname,'m_level')>2)
    {
        $id=$this->input->post('id');
        $post_line=$this->PostContentModel->get_row($id);
    	if($post_line!=false)
    	{
    		$str="<div class='line_height_2_5' style='margin:5px 0px;'><span class='button padding float_right margin_b line_height_1_5' onclick='admin_post_content.update(".$id.")'>Cập nhật</span><input class='margin_b' type='text' placeholder='Tiêu đề' value='".$this->PostContentModel->get($id,'m_title')."' name='admin_post_content_update_title'>";
                $act3='document.getElementById("admin_post_update_inputavata").click()';
    			$str.="<input class='' type='file' id='admin_post_update_inputavata' onchange='admin_post_content.update_setavata(this)' style='display:none;'><span class='button gray padding margin_b line_height_1 margin_r' onclick='".$act3."'><img src='".$this->PostContentModel->get_avata($id)."' name='admin_post_update_avata' style='width:18;height:18px;margin-right:10px;vertical-align:middle;'>Ảnh đại diện</span>";
                $str.="<span class='button gray padding display_inline_block line_height_1_5' id='post_update_type' data-id='".$this->PostContentModel->get($id,'m_id_type')."' onclick='admin_post_content.update_load_type()'>Mục: ".$this->PostTypeModel->get($this->PostContentModel->get($id,'m_id_type'),"m_title")."</span>";
                $str.="<div class='hide line_height_1_5' id='post_update_type_choose'></div>";
            $str.="<div class='clear_both'></div></div>";
            $str.="<div class='padding_v margin_v admin_post_content_update_nd_box_togglehide'><span class='stt_highlight stt_action' onclick='$(\".admin_post_content_update_nd_box_togglehide\").toggleClass(\"hide\")'>Hiện nội dung bài viết</span></div>";
            $str.="<div class='padding_v margin_v hide admin_post_content_update_nd_box_togglehide'><span class='stt_highlight stt_action' onclick='$(\".admin_post_content_update_nd_box_togglehide\").toggleClass(\"hide\")'>Ẩn nội dung bài viết</span></div>";
            
            $str.="<div class='hide admin_post_content_update_nd_box_togglehide'>";
        		$str.="<div id='admin_post_content_update_nd_pane'></div>";
        		$str.="<div id='admin_post_content_update_nd' style='width:100%;border:1px solid #ddddff;min-height:300px;background-color:#ffffff;max-width:100%;max-height:500px;overflow:auto;'>".$this->PostContentModel->get($id,'m_content')."</div>";
                $str.="<div class='padding_v'><span class='button padding fontsize_d3' id='admin_post_content_update_extra_btn'>Mở rộng</span></div><div class='padding' id='admin_post_content_update_extra_temp'></div>";
                $str.="<div class='padding_v margin_v'><span class='stt_highlight stt_action' onclick='$(\".admin_post_content_update_nd_box_togglehide\").toggleClass(\"hide\")'>Ẩn nội dung bài viết</span></div>";
            $str.="</div>";
            //cài đặt nâng cao
            $str.="<div class='margin_t padding'>";
                $str.="Nâng cao > SEO:<br>";
                $str.="<i class='fa fa-level-up fa-rotate-90'></i> Tiêu đề SEO<br><textarea style='width:100%;max-width:100%;max-height:150px' id='admin_post_content_update_seo_title' placeholder='Tiêu đề seo'>".str_to_view($post_line->m_seo_title)."</textarea>";
                $str.="<br><i class='fa fa-level-up fa-rotate-90'></i> Keyword SEO<br><textarea style='width:100%;max-width:100%;max-height:150px' id='admin_post_content_update_seo_keyword' placeholder='Keyword seo'>".str_to_view($post_line->m_seo_keyword)."</textarea>";
                $str.="<br><i class='fa fa-level-up fa-rotate-90'></i> Mô tả SEO<br><textarea style='width:100%;max-width:100%;max-height:150px' id='admin_post_content_update_seo_description' placeholder='Mô tả seo'>".str_to_view($post_line->m_seo_description)."</textarea>";
            $str.="</div>";
            
            $str.="<div class='margin_t padding'>";
                $str.="Nâng cao > Hình ảnh:<br>";
                $str.="<div class='padding_v admin_post_content_hideavata line_height_2' data-hide='".$post_line->m_avata_hide."'><i class='fa fa-level-up fa-rotate-90'></i> Hiển thị ảnh bìa khi xem bài viết: ";
                
                $temp_class='';
                if($post_line->m_avata_hide==1)
                {
                    $temp_class='hide';
                }
                $str.="<span class='".$temp_class." admin_post_content_hideavata_viewing'><span class='stt_avaiable'>Đang hiện</span> <span class='button padding red off fontsize_d2' onclick='$(this).parents(\".admin_post_content_hideavata\").attr(\"data-hide\",\"1\");$(\".admin_post_content_hideavata_viewing\").addClass(\"hide\");$(\".admin_post_content_hideavata_hidding\").removeClass(\"hide\");'>Tắt</span></span>";
            
                $temp_class='';
                if($post_line->m_avata_hide==0)
                {
                    $temp_class='hide';
                }
                $str.="<span class='".$temp_class." admin_post_content_hideavata_hidding'><span class='stt_mistake'>đang tắt</span> <span class='button padding fontsize_d2' onclick='$(this).parents(\".admin_post_content_hideavata\").attr(\"data-hide\",\"0\");$(\".admin_post_content_hideavata_viewing\").removeClass(\"hide\");$(\".admin_post_content_hideavata_hidding\").addClass(\"hide\");'>Bật</span></span>";
                $str.="</div>";
            $str.="</div>";
            
            $str.="<div class='margin_t padding'>";
                $str.="Nâng cao > Thời gian:<br>";
                $str.="<div class='margin_t'><i class='fa fa-level-up fa-rotate-90'></i> <input type='checkbox' id='admin_post_content_update_changetime'><label for='admin_post_content_update_changetime'>Cập nhật lại thời gian</label></div>";
            $str.="</div>";
            echo $str;
    	}
    	else
    	{
    		echo "Tác vụ thất bại";
    	}
    }
    else
    {
        echo "Cần quyền quản trị";
    }
    
?>