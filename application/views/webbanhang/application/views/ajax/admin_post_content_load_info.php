<?php
    if($this->UserModel->get($idname,'m_level')>2)
	{
		$id=$this->input->post('id');
        $post_row=$this->PostContentModel->get_row($id);
        if($post_row==false)
        {
            echo "<div class='stt_mistake'>Bài viết không khả dụng.</div>";
        }
        else
        {
            echo "<div class='stt_highlight fontsize_a2'><a href='".$this->PostContentModel->get_link_from_id($post_row->id)."' target='_blank'>".$post_row->m_title."</div>";
            $ar_type=$this->PostTypeModel->get_link_type($post_row->m_id_type);
            if($ar_type!=false)
            {
                $max=count($ar_type);
                for($i=0;$i<$max;$i++)
                {
                    if($ar_type[$i]!=1)
                    {
                        $ar_type[$i]="<a href='".$this->PostTypeModel->get_link_from_id($ar_type[$i])."' target='_blank'>".$this->PostTypeModel->get($ar_type[$i],'m_title')."</a>";
                    }
                    else
                    {
                        $ar_type[$i]="<a href='".site_url("danh-muc/1.html")."'>Bài viết</a>";
                    }
                }
            }
            echo "<div class=''>".implode(" / ",$ar_type)."</div>";
            echo "<div class=''>Trạng thái <span class='stt_tip'>".$post_row->m_status."</span></div>";
            echo "<div class=''>Lượt xem <span class='stt_tip'>".$post_row->m_view."</span></div>";
            echo "<div class=''>Lượt thích <span class='stt_tip'>".$post_row->m_like."</span></div>";
            echo "<div class=''>Đăng lúc <span class='stt_tip'>".TimeHelper()->sql_to_view($post_row->m_date,"[date]/[month]/[year], [hourse]:[minute]")."</span></div>";
            echo "<div class=''>Cập nhật <span class='stt_tip'>".my_time_ago_str($post_row->m_militime)."</span></div>";
            echo "<div class=''>Đánh giá <span class='stt_tip'>".$post_row->m_rank."</span></div>";
            echo "<div class=''>Bài viết của ".$this->UserModel->get($post_row->m_id_user,'m_realname')."</div>";
            if($post_row->m_id_user_check==-1)
            {
                echo "<div class='stt_mistake'>Bài viết chưa được kiểm duyệt.</div>";
            }
            else
            {
                echo "<div class=''><img style='height:1em;border-radius:50%;border:1px solid #666;margin-right:0.5em;vertical-align:middle' src='".$this->UserModel->get_avata($post_row->m_id_user_check)."'>Đã được duyệt bởi <span class='stt_tip'>".$this->UserModel->get($post_row->m_id_user_check,'m_realname')."</span></div>";
            }
            echo "<div class='padding_v margin_t fontsize_a3'>Thông tin thêm</div>";
            $str=str_get_html($post_row->m_content);
            if($str!=false&&$str!="")
            {
                 $str_plain=$str->plaintext;
                 $str_h2=$str->find("h2");
                 $str_h3=$str->find("h3");
                 $str_a=$str->find("a");
                 echo "<span class='display_inline_block'>Số từ: ".str_word_count($str_plain).",</span> &nbsp;&nbsp;<span class='display_inline_block'>Số ký tự: ".strlen($str_plain).",</span> &nbsp;&nbsp;<span class='display_inline_block'>Hình ảnh: ".count($str->find("img"))."</span>";
                 echo "<div class=''>";
                    echo "<span class='display_inline_block'>Thẻ H2: ".count($str_h2).",</span> &nbsp;&nbsp; <span class='display_inline_block'>Thẻ H3: ".count($str_h3).",</span> &nbsp;&nbsp; <span class='display_inline_block'>Liên kết: ".count($str_a)."</span>";
                 echo "</div>";
            }
            echo "<div class='margin_t padding_v' style='border-top:1px soild #999999'><span class='fontsize_a3'>Nâng cao</span> / google search<div class='padding margin_t admin_post_content_supinfo'><textarea style='width:100%;max-height:150px' placeholder='Tìm với từ khoá...' id='admin_post_content_supinfo_wordinput' value='".str_to_view($post_row->m_title,false)."'>".$post_row->m_title."</textarea><div class='padding'><span class='button padding fontsize_d2' onclick='admin_post_content.load_supinfo(".$post_row->id.")'>Nhấn để xem thông tin</span></div><div class='realcontent'></div></div></div>";
            
            echo "<div class='align_center' style='margin-top:2em'><span class='button red padding' onclick='uncaption()'>Đóng</span></div>";
        }
	}
	else
	{
		echo "Tác vụ không được phép";
	}
?>