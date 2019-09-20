<div class="width_max1300px">
<?php
    if($idname==false)
    {
        echo "<div class='stt_mistake'><a class='stt_mistake' href='".site_url('login/index/'.str_replace("=","",base64_encode($page_fb_url)))."'><span class='stt_mistake'>Đăng nhập để có thể gởi và nhận tin nhắn</span></a></div>";
    }
    else
    {
        $user_width_row=$this->UserModel->get_row($data['with_user']);
        echo "<div class='tin_nhan'>";
            echo "<div class='tin_nhan_left'>";
                echo "<div class='tin_nhan_left_header'>";
                    echo "<span class='margin_r stt_avaiable stt_action'><i class='fa fa-cog' title='Cài đặt tin nhắn'></i> Cài đặt</span>";
                    echo "<span class='float_right stt_avaiable stt_action' onclick='tin_nhan.load_new_form()'><i class='fa fa-plus' title='Soạn tin nhắn'></i> Soạn tin</span>";
                    echo "<div class='clear_both'></div>";
                echo "</div>";
                echo "<div class='tin_nhan_left_content'>";
                    $list_user_with_real=Array();
                    $list_user_with=$this->db->query("SELECT m_id_user_from,m_id_user_to FROM ".$this->TinNhanModel->get_table_name()." WHERE (m_id_user_from=".$idname.") GROUP BY m_id_user_to LIMIT 0,200")->result();
                    if(count($list_user_with)>0)
                    {
                        foreach($list_user_with as $line)
                        {
                            if(!in_array($line->m_id_user_to,$list_user_with_real))
                            {
                                array_push($list_user_with_real,$line->m_id_user_to);
                            }
                        }
                    }
                    $list_user_with=$this->db->query("SELECT m_id_user_from,m_id_user_to FROM ".$this->TinNhanModel->get_table_name()." WHERE (m_id_user_to=".$idname.") GROUP BY m_id_user_from LIMIT 0,200")->result();
                    if(count($list_user_with)>0)
                    {
                        foreach($list_user_with as $line)
                        {
                            if(!in_array($line->m_id_user_from,$list_user_with_real))
                            {
                                array_push($list_user_with_real,$line->m_id_user_from);
                            }
                        }
                    }
                    
                    $max=count($list_user_with_real);
                    if($max<1)
                    {
                        echo "<div class='stt_tip'>Chưa có cuộc hội thoại nào.</div>";
                    }
                    else
                    {
                        echo "<div class='padding_v tin_nhan_short_statistic stt_action stt_highlight' onclick='$(\".tin_nhan_user_with\").toggleClass(\"minium\")'><i class='fa fa-folder-open'></i> Tất cả ".$max." cuộc hội thoại</div>";
                        $temp_class='';
                        if($user_width_row!=false)
                        {
                            $temp_class=' minium ';
                        }
                        echo "<div class='tin_nhan_user_with".$temp_class."'>";
                            foreach($list_user_with_real as $line)
                            {
                                echo "<div class='padding'>";
                                    echo "<a href='".site_url("tin-nhan/with/".$line)."'>";
                                        echo "<img class='align_middle tin_nhan_user_with_avata' src='".$this->UserModel->get_avata($line)."'>";
                                        echo "<span class='align_middle tin_nhan_user_with_realname'>".str_to_view($this->UserModel->get($line,'m_realname'))."</span>";
                                    echo "</a>";
                                echo "</div>";
                            }
                        echo "</div>";
                    }
                echo "</div>";
            echo "</div>";
            echo "<div class='tin_nhan_content'>";
                echo "<div class='tin_nhan_content_header'>";
                    if($user_width_row==false)
                    {
                        echo "Tất cả cuộc hội thoại";
                    }
                    else
                    {
                        echo "Tin nhắn với <a href='".$this->UserModel->get_link_from_id($user_width_row->id)."' title='".str_to_view($user_width_row->m_realname,false)."'>".str_to_view($user_width_row->m_realname)."</a>";
                    }
                echo "</div>";
                echo "<div class='tin_nhan_content_content'>";
                    if($user_width_row==false)
                    {
                        //echo "Tất cả cuộc hội thoại";
                    }
                    else
                    {
                        echo "<div class='tin_nhan_stream'>";
                            echo "<div class='tin_nhan_stream_detail'><div class='tin_nhan_stream_detail_minheight'>";
                                echo "<div class='tin_nhan_stream_detail_content' data-id-user-with='".$user_width_row->id."'>";
                                    
                                echo "</div>";
                                echo "<div class='tin_nhan_stream_detail_form'>";
                                    echo "<div class='tin_nhan_stream_detail_form_nd'><textarea class='tin_nhan_stream_detail_form_nd_input' placeholder='Nhập tin nhắn...'></textarea></div>";
                                    echo "<div class='tin_nhan_stream_detail_form_buttonsend'><span class='button padding tin_nhan_stream_detail_form_buttonsend_button' onclick='tin_nhan.stream_send()'><i class='fa fa-send'></i> Gửi</span></div>";
                                echo "</div>";
                            echo "</div></div>";
                            echo "<div class='tin_nhan_stream_statistic'>";
                                echo "<div class='font_roboto stt_tip fontsize_a2 padding bg_dark'><i class='fa fa-line-chart'></i> Thống kê</div>";
                                    echo "<div class='padding_l padding_v'>";
                                    $temp_max=$this->db->query("SELECT id FROM ".$this->TinNhanModel->get_table_name()." WHERE ((m_id_user_from=".$user_width_row->id." AND m_id_user_to=".$idname.") OR (m_id_user_to=".$user_width_row->id." AND m_id_user_from=".$idname."))")->num_rows();
                                    if($temp_max<1)
                                    {
                                        echo "<div class=''>Chưa có tin nhắn nào !</div>";
                                    }
                                    else
                                    {
                                        echo "<div class=''><i class='fa fa-level-up fa-rotate-90'></i> ".$temp_max." Tin nhắn tất cả</div>";
                                        $temp_max=$this->db->query("SELECT id FROM ".$this->TinNhanModel->get_table_name()." WHERE (((m_id_user_from=".$user_width_row->id." AND m_id_user_to=".$idname.") OR (m_id_user_to=".$user_width_row->id." AND m_id_user_from=".$idname.")) AND m_militime_receive=-1)")->num_rows();
                                        if($temp_max<1)
                                        {
                                            echo "<div class='stt_avaiable'><i class='fa fa-level-up fa-rotate-90'></i> 0 tin nhắn chưa đọc</div>";
                                        }
                                        else
                                        {
                                            echo "<div class='stt_mistake'><i class='fa fa-level-up fa-rotate-90'></i> ".$temp_max." Tin nhắn chưa đọc</div>";
                                            
                                        }
                                    }
                                    echo "</div>";
                                echo "<div class='font_roboto stt_tip fontsize_a2 padding bg_dark'><i class='fa fa-bars'></i> Tùy chọn</div>"; 
                                   echo "<div class='padding_l padding_v'>";
                                        echo "<div class=''><span class='stt_mistake' onclick='tin_nhan.delallmessage_with()'><i class='fa fa-times'></i> Xóa dữ liệu cuộc trò chuyện</span></div>";
                                   echo "</div>"; 
                            echo "</div>";
                        echo "</div>";
                    }
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
?>
</div>