<?php
    if($this->UserModel->check_exit($idname))
    {
        if($this->UserModel->get($idname,"m_level")>3)
        {
            $idmenu=$this->input->post('id');
            
            $ar_indexed=$this->StaticPageModel->filter("m_is_primary",1);
            if($ar_indexed!=false)
            {
                $max=count($ar_indexed);
                for($i=0;$i<$max;$i++)
                {
                    $this->StaticPageModel->set($ar_indexed[$i]->id,"m_is_primary",0);
                }
            }
            
            $this->StaticPageModel->set($idmenu,"m_is_primary",1);
            if($this->StaticPageModel->get($idmenu,"m_is_primary")==1)
            {
                echo "<span class='stt_avaiable'>Đã đặt ".$this->StaticPageModel->get($idmenu,"m_title")." làm trang chủ</span>";
            }
            else
            {
                echo "<span class='stt_mistake'>Tác vụ thất bại ! <br><Hãy thực hiện lại></span>";
            }
        }
        else
        {
            echo "Tác vụ thất bại";
        }
    }
?>