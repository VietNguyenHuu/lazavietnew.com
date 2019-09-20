<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $tags_row=$this->PostTagsModel->get_row($this->input->post('id_tags'));
        if($tags_row==false)
        {
            echo "<div class='stt_mistake'>Tags bài viết không khả dụng</div>";
        }
        else
        {
            if($this->PostTagsModel->del($tags_row->id)!=true)
            {
                echo "<div class='stt_mistake'>Không xóa được tags, <br>Hãy thực hiện lại</div>";
            }
            else
            {
                echo "<div class='stt_avaiable'>Đã xóa tags</div>";
            }
        }
    }
?>