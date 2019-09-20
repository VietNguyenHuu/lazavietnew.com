<div class="width_max1300px">
<?php
    define('POST_WRITE_INPAGE',10);
    echo "<h1 class='page_title radius_none' style='margin-bottom:0px'>Quản lý bài viết</h1>";
    if($idname!="")
    {
        echo "<div class='padding margin_b fontsize_d2 radius_none font_helvetica post_write_fast_alert'>";
            echo "Chào mừng bạn đến với trang quản lý bài viết dành cho thành viên. Bạn có thể viết bài mới để chia sẻ với mọi người và quản lý tất cả các bài bạn đã viết.";
            echo "<i class='fa fa-times-circle stt_action margin_l float_right' onclick=\"$(this).parents('.post_write_fast_alert').addClass('hide')\" title='Tắt thông báo'></i>";
            echo "<div class='clear_both'></div>";
        echo "</div>";
        //form add post
        $post_add_form = $this->load->design('block/post/write/form_addpost.html');
        //end form add post
        echo myhtml_grid(
            "",
            "<div class='grid_content padding' id='post_add_form'>".$post_add_form."</div>"
        );
        
        //tạo str_list bài viết đã đăng
        $checktype=$data['checktype'];
        
        $num_post_wrote_all=$this->db->query("SELECT id FROM post_content WHERE m_status!='trash' AND m_id_user=".$idname)->num_rows();
        $num_post_wrote_waitcheck=$this->db->query("SELECT id FROM post_content WHERE m_id_user=".$idname." AND m_id_user_check=-1 AND m_status!='trash'")->num_rows();
        $disable_all='disable';
        $disable_waitcheck='disable';
        $disable_reject='disable';
        $str_list="";
        $recent_page=1;
        $str_page=strpage()->decode($data['str_page']);
        if($str_page['pagetype']=='trang')
        {
            $recent_page=$str_page['pagenumber'];
        }
        if($checktype=='tat-ca')
        {
            $phantrang=page_seperator($num_post_wrote_all,$recent_page,POST_WRITE_INPAGE,Array('class_name'=>'page_seperator_item','strlink'=>"quan-ly-bai-viet/".$checktype."/trang-[[pagenumber]].html"));
            $list=$this->db->query("SELECT * FROM post_content WHERE m_status!='trash' AND m_id_user=".$idname." ORDER BY id DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
            $disable_all='';
        }
        else if($checktype=='cho-duyet')
        {
            $phantrang=page_seperator($num_post_wrote_waitcheck,$recent_page,POST_WRITE_INPAGE,Array('class_name'=>'page_seperator_item','strlink'=>"quan-ly-bai-viet/".$checktype."/trang-[[pagenumber]].html"));
            $list=$this->db->query("SELECT * FROM post_content WHERE m_status!='trash' AND m_id_user=".$idname." AND m_id_user_check=-1 ORDER BY id DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
            $disable_waitcheck='';
        }
        else if($checktype=='tu-choi')
        {
            $phantrang=page_seperator($num_post_wrote_all,$recent_page,POST_WRITE_INPAGE,Array('class_name'=>'page_seperator_item','strlink'=>"quan-ly-bai-viet/".$checktype."/trang-[[pagenumber]].html"));
            $list=$this->db->query("SELECT * FROM post_content WHERE m_status!='trash' AND m_id_user=".$idname." ORDER BY id DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
            $disable_reject='';
        }
        $str_list.="<div class='list post_wrote_list'>";
            if(count($list)>0&&$list!=null&&$list!=false)
            {
                foreach($list as $post_line)
                {
                    $str_list.="<div class='item' style='border-bottom:1px solid #999999'><a href='".site_url("post/write_detail/".$post_line->id)."' target='_blank'><img class='post_wrote_list_avata' src='".$this->PostContentModel->get_avata($post_line->id)."'>".$post_line->m_title."</a>";
                        $str_list.="<div class='item_control float_right'>";
                            $str_list.="<i class='fa fa-info-circle stt_action margin_r stt_tip' title='Xem thông tin' onclick='post_write.load_info(".$post_line->id.")'></i> ";
                            $str_list.="<i class='fa fa-pencil stt_action margin_r' title='Chỉnh sửa' onclick='post_write.load_form_update(".$post_line->id.")'>";
                            $str_list.="</i> ";
                            $str_list.="<i class='fa fa-trash-o stt_action stt_mistake' title='Xóa' onclick='post_write.del(".$post_line->id.")'>";
                            $str_list.="</i>";
                        $str_list.="</div>";
                        $str_list.="<div class='clear_both'></div>";
                    $str_list.="</div>";
                }
            }
        $str_list.="</div>";
        $str_list.="<div class='page_seperator_box'>".$phantrang['str_link']."</div>";
    
        //end tạo str_list bài viết đã đăng
        echo myhtml_grid(
            "<a class='grid_header_label ".$disable_all."' href='".site_url("quan-ly-bai-viet.html")."'>Đã viết <span class='fontsize_d2'>(".$num_post_wrote_all.")</span></a><a class='grid_header_label ".$disable_waitcheck."' href='".site_url("quan-ly-bai-viet/cho-duyet.html")."'>Chờ duyệt <span class='fontsize_d2'>(".$num_post_wrote_waitcheck.")</span></a><div class='grid_header_label ".$disable_reject."'>Từ chối</div>",
            "<div class='grid_content padding'>".$str_list."</div>"
        );
        echo "<div id='post_write_status' data-status='success'></div>";
    }
    else
    {
        echo "<div class='stt_mistake padding align_center' id='post_write_status' data-status='no sign in'>Hãy <a href='".site_url('login/index/'.str_replace("=","",base64_encode($page_fb_url)))."'>đăng nhập</a> để viết bài</div>";
    }
?>
</div>