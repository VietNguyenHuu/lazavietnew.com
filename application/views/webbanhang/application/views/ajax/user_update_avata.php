<?php

    if($this->UserModel->check_login()==false)

    {

        echo "<div class='stt_mistake'>Đăng nhập để cập nhật ảnh đại diện</div>";

    }

    else

    {

        $avata=$this->input->post('avata');

        if($this->UserModel->set_avata($idname,$avata)==false)

        {

            echo "<div class='stt_mistake'>Tác vụ thất bại, hãy thực hiện lại</div>";

        }

        else

        {

            echo "<div class='stt_avaiable'>Đã cập nhật ảnh đại diện</div>";

        }

    }

?>