<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $title=$this->input->post('title');
        if($title==""||$title=='undefined')
        {
            echo "<div class='stt_mistake'>Hãy nhập vào tên mẫu phản hồi !</div>";
        }
        else
        {
            $add=$this->PostReportPatternModel->add(Array(
                'title'=>$title
           ));
            if($add==false)
            {
                echo "<div class='stt_mistake'>Không thêm được mẫu phản hồi, hãy thử lại sau !</div>";
            }
            else
            {
                echo "<div class='stt_avaiable'>Đã thêm mẫu phản hồi !</div>";
            }
        }
    }
?>