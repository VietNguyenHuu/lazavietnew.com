<?php
    if($this->UserModel->get($idname,'m_level')<4)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $type_row=$this->PostTypeModel->get_row((int)$this->input->post("id_type"));
        if($type_row==false)
        {
            echo "<div class='stt_mistake'>Danh mục không khả dụng !</div>";
        }
        else if($type_row->id==1)
        {
            echo "<div class='stt_mistake'>Mục đang chọn hiện là mục gốc mặc định của hệ thống</div>";
        }
        else
        {
            $type_row_parent=$this->PostTypeModel->get_row((int)$this->input->post("id_parent"));
            if($type_row_parent==false)
            {
                echo "<div class='stt_mistake'>Danh mục gốc được chọn không khả dụng !</div>";
            }
            else if($type_row->id==$type_row_parent->id)
            {
                echo "<div class='stt_mistake'>Mục đang chọn trùng với mục gốc</div>";
            }
            else
            {
                if($this->PostTypeModel->set($type_row->id,'m_id_parent',$type_row_parent->id)==false)
                {
                    echo "<div class='stt_mistake'>Tác vụ thất bại, hãy thực hiện lại sau</div>";
                }
                else
                {
                    $this->PostTypeModel->update_all_direct_type();
                    echo "<div class='stt_avaiable'>Đã thực hiện chuyển mục gốc thành công</div>";
                    echo "<div class='margin_v padding'><a href='".site_url("admin/post")."'>Tải lại trang</a></div>";
                }
            }
        }
    }
?>