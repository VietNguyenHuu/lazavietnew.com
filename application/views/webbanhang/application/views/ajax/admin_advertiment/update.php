<?php
    if($this->UserModel->get($idname,'m_level')<4)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $row=$this->AdvertimentModel->get_row($this->input->post('id'));
        if($row==false)
        {
            echo "<div class='stt_mistake'>Quảng cáo không khả dụng</div>";
        }
        else
        {
            $this->AdvertimentModel->set($row->id,'m_title',$this->input->post('title'));
            $this->AdvertimentModel->set($row->id,'m_link',$this->input->post('link'));
            $this->AdvertimentModel->set($row->id,'m_type',$this->input->post('adstype'));
            $avata=$this->input->post('avata');
            if($avata!=""&&$avata!='undefined')
            {
                $this->AdvertimentModel->set_avata($row->id,$avata);
            }
            echo "<div class='stt_avaiable'>Đã cập nhật quảng cáo</div>";
        }
    }
    
?>