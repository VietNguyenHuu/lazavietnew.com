<?php
    if($this->UserModel->get($idname,'m_level')>0)
	{
		$id=$this->input->post('id');
        $post_row=$this->PostContentModel->get_row($id);
        if($post_row==false)
        {
            echo "<div class='stt_mistake'>Bài viết không khả dụng.</div>";
        }
        else
        {
            echo "<div class='stt_highlight fontsize_a2'>".$post_row->m_title."</div>";
            $ar_type=$this->PostTypeModel->get_link_type($post_row->m_id_type);
            if($ar_type!=false)
            {
                $max=count($ar_type);
                for($i=0;$i<$max;$i++)
                {
                    if($ar_type[$i]!=1)
                    {
                        $ar_type[$i]="<a href='".$this->PostTypeModel->get_link_from_id($ar_type[$i])."'>".$this->PostTypeModel->get($ar_type[$i],'m_title')."</a>";
                    }
                    else
                    {
                        $ar_type[$i]="<a href='".$this->PostTypeModel->get_link_from_id(1)."'>Bài viết</a>";
                    }
                }
            }
            echo "<div class=''>".implode(" / ",$ar_type)."</div>";
            echo "<div class=''>Trạng thái <span class='stt_tip'>".$post_row->m_status."</span></div>";
            echo "<div class=''>Lượt xem <span class='stt_tip'>".$post_row->m_view."</span></div>";
            echo "<div class=''>Lượt thích <span class='stt_tip'>".$post_row->m_like."</span></div>";
            echo "<div class=''>Cập nhật <span class='stt_tip'>".$post_row->m_date."</span></div>";
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
            echo "<div class='align_center' style='margin-top:2em'><span class='button red padding' onclick='uncaption()'>Đóng</span></div>";
        }
	}
	else
	{
		echo "Đăng nhập để thực hiện chức năng";
	}
?>