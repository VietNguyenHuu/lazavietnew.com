<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $name=$this->input->post('id');
        if($this->CacheModel->del($name)==false)
        {
            echo "<div class='stt_mistake'>Không xóa được cache, hãy thực hiện lại</div>";
        }
        else
        {
            echo "<div class='stt_avaiable'>Đã xóa cache</div>";
        }
    }
?>