<?php
    if($idname==false)
    {
        echo "<div class='stt_mistake'>Đăng nhập để xem tin nhắn</div>";
    }
    else
    {
        $user_width_row=$this->UserModel->get_row($this->input->post('id_user_with'));
        if($user_width_row==false)
        {
            echo "<div class='stt_mistake'>Người dùng không khả dụng</div>";
        }
        else
        {
            $content=$this->input->post('nd');
            if($content==""||$content=='undefined')
            {
                echo "<div class='stt_mistake'>Hãy nhập nội dung tin nhắn !</div>";
            }
            else
            {
                $temp_id_tn=$this->TinNhanModel->add(Array(
                    'id_user_from'=>$idname,
                    'id_user_to'=>$user_width_row->id,
                    'content'=>$content
               ));
               if($temp_id_tn==false)
               {
                    echo "<div class='stt_mistake'>Không gửi được tin nhắn</div>";
               }
               else
               {
                    echo "<div class='stt_avaiable'>Đã gửi tin nhắn</div>";
               }
            }
        }
    }
?>