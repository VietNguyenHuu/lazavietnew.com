<?php
    if($this->UserModel->get($idname,'m_level')<4)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép !</div>";
    }
    else
    {
        $temp=$this->SystemParamModel->get('admin_post_content_lastresetview','m_value');
        if($temp===false||((int)$temp)<time()-24*60*60)
        {
            if($this->PostViewModel->view_reset()!=true)
            {
                echo "<div class='stt_mistake'>Tác vụ thất bại, hãy thực hiện lại</div>";
            }
            else
            {
                $temp=$this->SystemParamModel->set('admin_post_content_lastresetview','m_value',''.time());
                echo "<div class='stt_avaiable'>Đã đặt lại lượt truy cập cho tất cả bài viết</div>";
            }
        }
        else
        {
            echo "<div class='stt_tip'>Đã cập nhật lượt xem trong vòng 1 ngày trước, bạn chỉ cần thực hiện tác vụ này mỗi ngày 1 lần.</div>";
        }
    }
?>