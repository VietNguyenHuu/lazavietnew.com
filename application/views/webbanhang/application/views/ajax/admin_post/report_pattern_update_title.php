<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $pattern_row=$this->PostReportPatternModel->get_row($this->input->post('id'));
        if($pattern_row==false)
        {
            echo "<div class='stt_mistake'>Mẫu báo cáo bài viết không khả dụng</div>";
        }
        else
        {
            $title=$this->input->post('title');
            if($title==$pattern_row->m_title)
            {
                echo "<div class='stt_mistake'>Không có cập nhật mới nào</div>";
            }
            else
            {
                if($this->PostReportPatternModel->set($pattern_row->id,'m_title',$title)==false)
                {
                    echo "<div class='stt_mistake'>Không cập nhật được tên mẫu báo cáo<br>Hãy thực hiện lại sau</div>";
                }
                else
                {
                    echo "<div class='stt_avaiable'>Đã đổi tên mẫu thành công ! </div>";
                }
            }
        }
    }
?>