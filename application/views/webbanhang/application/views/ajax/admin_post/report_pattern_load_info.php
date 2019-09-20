<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $pattern_row=$this->PostReportPatternModel->get_row($this->input->post('id'));
        if($pattern_row==false)
        {
            echo "<div class='stt_mistake'>Mẫu báo cáo bài viết không khả dụng</div>";
        }
        else
        {
            echo "<p class='padding_v margin_v'>STT: ".$pattern_row->m_index." &nbsp;&nbsp;&nbsp;<i class='fa fa-pencil stt_highlight stt_action' title='Đổi thứ tự mẫu' onclick=\"$('.admin_post_report_pattern_edit_index_form').toggleClass('hide')\"></i></p>";
            echo "<div class='padding_v margin_v hide admin_post_report_pattern_edit_index_form'><div class=''>Đổi thứ tự mẫu thành:</div>";
                echo "<select name='admin_post_report_pattern_edit_index'>";
                    echo "<option value='0'>--Thứ tự mẫu--</option>";
                    $max=$this->PostReportPatternModel->get_num_row();
                    if($max>0)
                    {
                        for($i=1;$i<=$max;$i++)
                        {
                            $temp_str="";
                            if($pattern_row->m_index==$i)
                            {
                                $temp_str=" selected='selected' ";
                            }
                            echo "<option value='".$i."' ".$temp_str.">".$i."</option>";
                        }
                    }
                echo "</select>";
            echo "<span class='button padding' onclick='admin_post_report_pattern.update_index(".$pattern_row->id.")'>Cập nhật</span></div>";
            
            echo "<p class='padding_v margin_v'>Tên mẫu: ".$pattern_row->m_title." &nbsp;&nbsp;&nbsp;<i class='fa fa-pencil stt_highlight stt_action' title='Đổi tên mẫu' onclick=\"$('.admin_post_report_pattern_edit_title_form').toggleClass('hide')\"></i></p>";
            echo "<div class='padding_v margin_v hide admin_post_report_pattern_edit_title_form'><div class=''>Đổi tên mẫu thành:</div><input type='text' id='admin_post_report_pattern_edit_title' value='".str_to_view($pattern_row->m_title,false)."'><span class='button padding' onclick='admin_post_report_pattern.update_title(".$pattern_row->id.")'>Cập nhật</span></div>";
        }
    }
?>