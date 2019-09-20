<?php
    if($idname==false)
    {
        echo "<div class='stt_mistake'>Đăng nhập để xem tin nhắn</div>";
    }
    else
    {
        $user_width_row=$this->UserModel->get_row($this->input->post('id_user_with'));
        $page=$this->input->post('page');
        if($user_width_row==false)
        {
            echo "<div class='stt_mistake'>Người dùng không khả dụng</div>";
        }
        else
        {
            $list_m=$this->db->query("SELECT id FROM ".$this->TinNhanModel->get_table_name()." WHERE ((m_id_user_from=".$user_width_row->id." AND m_id_user_to=".$idname.") OR (m_id_user_to=".$user_width_row->id." AND m_id_user_from=".$idname."))")->num_rows();
            if($list_m<1)
            {
                echo "<div class=''>Chưa có tin nhắn nào !</div>";
            }
            else
            {
                $phantrang=page_seperator($list_m,$page,10,Array('class_name'=>'page_seperator_item','strlink'=>"javascript:tin_nhan.stream_load_list(".$user_width_row->id.",".$page.")"));
                $list_m=$this->db->query("SELECT * FROM ".$this->TinNhanModel->get_table_name()." WHERE ((m_id_user_from=".$user_width_row->id." AND m_id_user_to=".$idname.") OR (m_id_user_to=".$user_width_row->id." AND m_id_user_from=".$idname.")) ORDER BY id DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
                if($list_m!=false&&$list_m!=null)
                {
                    if($phantrang['recent_page']<$phantrang['total_page'])
                    {
                        echo "<div class='align_center padding margin_v'><span class='font_roboto stt_action stt_highlight' onclick='$(this).hide();tin_nhan.stream_load_list_goto(".($phantrang['recent_page']+1).")'>Xem tin nhắn cũ hơn</span></div>";
                    }
                    $list_m=array_reverse($list_m);
                    foreach($list_m as $m_line)
                    {
                        $temp_direction_class='float_left';
                        if($m_line->m_id_user_from==$idname)
                        {
                            $temp_direction_class='float_right';
                        }
                        if($m_line->m_id_user_to==$idname)
                        {
                            $this->TinNhanModel->set($m_line->id,'m_militime_receive',time());
                        }
                        echo "<div class='font_roboto ".$temp_direction_class." tin_nhan_stream_detail_content_item'>";
                            echo nl2br($m_line->m_content);
                            echo "<br><span class='stt_tip fontsize_d2'><i class='fa fa-clock-o'></i> ".my_time_ago_str($m_line->m_militime_send)."</span>";
                        echo "</div>";
                        echo "<div class='clear_both'></div>";
                    }
                    if($phantrang['recent_page']>1)
                    {
                        echo "<div class='align_center padding margin_v'><span class='font_roboto stt_action stt_highlight' onclick='$(this).hide();tin_nhan.stream_load_list_goto(".($phantrang['recent_page']-1).")'>Xem tin nhắn mới hơn</span></div>";
                    }
                }
            }
        }
    }
?>