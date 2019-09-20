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
            $index=(int)$this->input->post('index');
            if($index==$pattern_row->m_index)
            {
                echo "<div class='stt_mistake'>Không có cập nhật mới nào</div>";
            }
            else
            {
                //lấy id mẫu hoán đổi
                $pattern_row_replace=$this->db->query("SELECT * FROM ".$this->PostReportPatternModel->get_table_name()." WHERE m_index=".$index)->row();
                if($pattern_row_replace==false||$pattern_row_replace==null)
                {
                    echo "<div class='stt_mistake'>Không thể thay đổi thứ tự thành ".$index."</div>";
                }
                else
                {
                    if($this->PostReportPatternModel->set($pattern_row->id,'m_index',$pattern_row_replace->m_index)==false)
                    {
                        echo "<div class='stt_mistake'>Không cập nhật được thứ tự mẫu báo cáo<br>Hãy thực hiện lại sau</div>";
                    }
                    else
                    {
                        $this->PostReportPatternModel->set($pattern_row_replace->id,'m_index',$pattern_row->m_index);
                        echo "<div class='stt_avaiable'>Đã đổi thứ tự mẫu thành công ! </div>";
                    }
                }
            }
        }
    }
?>