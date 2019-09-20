<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $author=$this->PostAuthorModel->get_row($this->input->post('id_author'));
        if($author==false)
        {
            echo "<div class='stt_mistake'>Tác giả không khả dụng</div>";
        }
        else
        {
            $score=(int)$this->input->post('score');
            if($this->PostAuthorModel->set($author->id,'m_score_multi',$score)!=true)
            {
                echo "<div class='stt_mistake'>Không cập nhật được thông tin tác giả, hãy thực hiện lại</div>";
            }
            else
            {
                echo "<div class='stt_avaiable'>Cập nhật thông tin tác giả thành công</div>";
            }
        }
    }
?>