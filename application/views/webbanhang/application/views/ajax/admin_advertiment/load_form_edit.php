<?php
    if($this->UserModel->get($idname,'m_level')<4)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $adver_row=$this->AdvertimentModel->get_row($this->input->post('id'));
        if($adver_row==false)
        {
            echo "<div class='stt_mistake'>Quảng cáo không khả dụng</div>";
        }
        else
        {
            echo "<div class='padding'></div>";
            $str="<input type='text' name='title' placeholder='Tiêu đề' value='".str_to_view($adver_row->m_title,false)."'> ";
			$str.="<input type='text' name='link' placeholder='link đích' value='".str_to_view($adver_row->m_link,false)."'> ";
			if($adver_row->m_type=='navi')
            {
                $str.="<select name='adstype'><option value='navi' selected='selected'>NAVI</option><option value='main'>MAIN</option></select>";
            }
            elseif($adver_row->m_type=='main')
            {
                $str.="<select name='adstype'><option value='navi'>NAVI</option><option value='main' selected='selected'>MAIN</option></select>";
            }
            else
            {
                $str.="<select name='adstype'><option value='navi'>NAVI</option><option value='main'>MAIN</option></select>";
            }
            $act3='document.getElementById("top_advertiment_update_inputavata").click()';
			$str.="<input type='file' id='top_advertiment_update_inputavata' onchange='top_advertiment.update_setavata(this)' style='display:none;'><span class='button gray padding' onclick='".$act3."'><img src='".$this->AdvertimentModel->get_avata($adver_row->id)."' name='top_advertiment_update_avata' class='align_middle' style='width:1em;height:1em;'><span class='align_middle margin_l'>Hình ảnh</span></span>";
			$str.="<input class='margin_l' type='button' value=' Cập nhật ' onclick='top_advertiment.update(".$adver_row->id.")'>";
            echo $str;
        }
    }
    
?>