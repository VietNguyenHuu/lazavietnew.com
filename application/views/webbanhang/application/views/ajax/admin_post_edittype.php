<?php
    if($this->UserModel->get($idname,'m_level')>2)
    {
        $edit_id=$this->input->post('edit_id');
        $edit_row=$this->PostTypeModel->get_row($edit_id);
        if($edit_row==false)
        {
            echo "Rất tiếc, danh mục không tồn tại !";
        }
        else
        {
            $edit_title=$this->input->post('edit_title');
            $edit_index=$this->input->post('edit_index');
            $edit_seo_title=$this->input->post('edit_seo_title');
            $edit_seo_keyword=$this->input->post('edit_seo_keyword');
            $edit_seo_description=$this->input->post('edit_seo_description');
            $is_change=false;
            if($edit_title!="")
            {
                if($edit_row->m_title!=$edit_title)
                {
                    $this->PostTypeModel->set($edit_id,'m_title',$edit_title);
                    $is_change=true;
                    echo "<div class='stt_highlight'><i class='fa fa-check'></i> Đã đổi tên danh mục thành <span class='stt_tip'>".$edit_title."</span></div>";
                }
            }
            else
            {
                echo "<div class='stt_mistake'><i class='fa fa-times'></i> Không thể đổi tên thư mục thành ''</div>";
            }
            if($edit_row->m_index!=$edit_index)
            {
                $this->PostTypeModel->set($edit_id,'m_index',$edit_index);
                $is_change=true;
                echo "<div class='stt_highlight'><i class='fa fa-check'></i> Đã đổi thứ tự danh mục thành <span class='stt_tip'>".$edit_index."</span></div>";
            }
            if($edit_row->m_seo_title!=$edit_seo_title)
            {
                $this->PostTypeModel->set($edit_id,'m_seo_title',$edit_seo_title);
                $is_change=true;
                echo "<div class='stt_highlight'><i class='fa fa-check'></i> Đã đổi Tiêu đề SEO thành <span class='stt_tip'>".$edit_seo_title."</span></div>";
            }
            if($edit_row->m_seo_keyword!=$edit_seo_keyword)
            {
                $this->PostTypeModel->set($edit_id,'m_seo_keyword',$edit_seo_keyword);
                $is_change=true;
                echo "<div class='stt_highlight'><i class='fa fa-check'></i> Đã đổi Tiêu đề SEO thành <span class='stt_tip'>".$edit_seo_keyword."</span></div>";
            }
            if($edit_row->m_seo_description!=$edit_seo_description)
            {
                $this->PostTypeModel->set($edit_id,'m_seo_description',$edit_seo_description);
                $is_change=true;
                echo "<div class='stt_highlight'><i class='fa fa-check'></i> Đã đổi Tiêu đề SEO thành <span class='stt_tip'>".$edit_seo_description."</span></div>";
            }
            if(!$is_change)
            {
                echo "<div class='stt_tip'>Không có thay đổi nào được thực hiện.</div>";
            }
            echo "<div class='margin_t padding'>Tải lại trang để cập nhật thay đổi <span class='button padding' onclick='window.location=location.href'>Tải lại trang</span><span class='button padding red' onclick='uncaption()'>Đóng thông báo</span></div>";
        }
    }
    else
    {
        echo "Cần quyền quản trị";
    }
?>