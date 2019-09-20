<?php
    $id=$this->input->post('id');
    $follow_row=$this->PostFollowModel->get_row($id);
    if($follow_row==false)
    {
        echo "<div class='stt_mistake'>Theo dõi không khả dụng</div>";
    }
    else
    {
        if($idname!=$follow_row->m_id_user)
        {
            echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
        }
        else
        {
            if($this->PostFollowModel->del($id)==false)
            {
                echo "<div class='stt_mistake'>Không xóa bỏ theo dõi này, hãy thực hiện lại sau !</div>";
            }
            else
            {
                echo "<div class='stt_avaiable'>Đã bỏ theo dõi</div>";
            }
        }
    }
?>