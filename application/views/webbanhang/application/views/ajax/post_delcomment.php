<?php
    $id=$this->input->post('id');
    $comment_row=$this->PostCommentModel->get_row($id);
    if($comment_row!=false)
    {
        if($comment_row->m_id_user==$idname||($this->UserModel->get($idname,'m_level')>3&&$this->UserModel->get($idname,'m_level')>$this->UserModel->get($comment_row->m_id_user,'m_level')))
        {
            if($this->PostCommentModel->del($id)==true)
            {
                echo "<div class='stt_avaiable'>Đã xóa bình luận</div>";
            }
            else
            {
                echo "<div class='stt_mistake'>Sự cố, hãy thực hiện lại sau</div>";
            }
        }
        else
        {
            echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
        }
    }
    else
    {
        echo "<div class='stt_mistake'>Bình luận không khả dụng</div>";
    }
?>