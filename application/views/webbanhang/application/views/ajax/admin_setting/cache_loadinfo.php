<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $name=$this->input->post('cache_name');
        $cache_row=$this->CacheModel->get_row($name);
        if($cache_row==false)
        {
            echo "<div class='stt_mistake'>Không tải được cache</div>";
        }
        else
        {
            echo "<div class='padding_v margin_v'>Thông tin: ".strlen($cache_row->m_content)." len</div>";
            echo "<div class='margin_t' style='background-color:#999999'>".str_to_view($cache_row->m_content)."</div>";
        }
    }
?>