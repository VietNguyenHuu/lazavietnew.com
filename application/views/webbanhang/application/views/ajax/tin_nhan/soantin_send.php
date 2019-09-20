<?php
    if($idname==false)
    {
        echo "<div class='stt_mistake'>Đăng nhập để gửi tin nhắn</div>";
    }
    else
    {
        $ar_to=$this->input->post('send_to');
        if($ar_to==""||$ar_to=='undefined')
        {
            echo "<div class='stt_mistake'>Hãy chọn ít nhất một người nhận tin !</div>";
        }
        else
        {
            $content=$this->input->post('send_content');
            if($content==""||$content=='undefined')
            {
                echo "<div class='stt_mistake'>Hãy nhập nội dung tin nhắn !</div>";
            }
            else
            {
                $ar_to=explode(",",$ar_to);
                $max=count($ar_to);
                $max_success=0;
                if($max>0)
                {
                    foreach($ar_to as $key=>$value)
                    {
                        $temp_id_tn=$this->TinNhanModel->add(Array(
                            'id_user_from'=>$idname,
                            'id_user_to'=>$value,
                            'content'=>$content
                       ));
                       if($temp_id_tn!=false)
                       {
                            $max_success++;
                       }
                    }
                }
                if($max_success==$max)
                {
                    echo "<div class='stt_avaiable'>Đã gởi tin nhắn đến ".$max." người.</div>";
                }
                else
                {
                    echo "<div class='stt_avaiable'>".$max_success." tin nhắn được gửi .</div>";
                    echo "<div class='stt_avaiable'>".($max-$max_success)." tin nhắn không được gửi .</div>";
                }
            }
        }
    }
?>