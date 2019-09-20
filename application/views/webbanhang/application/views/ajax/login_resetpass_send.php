<?php
    $email=$this->input->post("email");
    if($email==""||$email=='undefined')
    {
        echo "<div class='stt_mistake'>Hãy nhập vào email của bạn !</div>";
    }
    else
    {
        if($this->UserModel->check_exit_email($email)!=true)
        {
            echo "<div class='stt_mistake'>Địa chỉ email này không trùng khớp với bất kỳ tài khoản nào tại ". $this->SystemParamModel->get('Site_domain_name', 'm_value') ." !</div>";
        }
        else
        {
            $row=$this->db->query("SELECT * FROM ".$this->UserModel->get_table_name_resetpass()." WHERE(m_email='".$email."')")->result();
            if(count($row)<1)//chưa có trong bảng reset pass=>thêm mới
            {
                $id_new=$this->UserModel->resetpass_add($email);
                if($id_new==false)
                {
                    echo "<div class='stt_mistake'>Đã xảy ra lỗi, vui lòng thử lại !</div>";
                }
                else
                {
                    echo "<div class='stt_avaiable'>Chúng tôi đã gởi email cho bạn, hãy kiểm tra email và làm theo hướng dẫn.</div>";
                }
            }
            else//đã có trong bảng reset pass
            {
                $row=$row[0];
                if(time()-$row->m_time<5*60)//trong thời gian không cho phép cập nhật(5 phút)
                {
                    echo "<div class='stt_tip'>Cách đây ".my_time_ago_str($row->m_time).", Chúng tôi đã gởi email đến bạn.</div>";
                }
                else//cập nhật lại token và numcheck
                {
                    if($this->UserModel->resetpass_update($row->id)==false)
                    {
                        echo "<div class='stt_mistake'>Đã có lỗi xảy ra, vui lòng thử lại !</div>";
                    }
                    else
                    {
                        echo "<div class='stt_avaiable'>Chúng tôi đã gởi email cho bạn, hãy kiểm tra email và làm theo hướng dẫn.</div>";
                    }
                }
            }
        }
    }
?>