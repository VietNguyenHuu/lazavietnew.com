<div class="width_max1300px">
<?php
    echo "<div class='page_title'>Thay đổi mật khẩu</div>";
    $email=urldecode($data['email']);
    $row=$this->db->query("SELECT * FROM ".$this->UserModel->get_table_name_resetpass()." WHERE(m_email='".$email."')")->result();
    if(count($row)<1)
    {
        echo "<div class='stt_mistake'>Không có yêu cầu nào từ email này !</div>";
    }
    else if($this->UserModel->check_exit_email($email)!=true)
    {
        echo "<div class='stt_mistake'>Người dùng cho email này không tồn tại !</div>";
    }
    else
    {
        $row=$row[0];
        if(time()-$row->m_time>12*60*60)
        {
            echo "<div class='stt_mistake'>Yêu cầu thay đổi mật khẩu đã quá hạn !</div>";
            $this->UserModel->resetpass_del($row->id);
        }
        else
        {
            if($row->m_numcheck>3)
            {
                echo "<div class='stt_mistake'>Đã quá số lần truy cập phiên !</div>";
                $this->UserModel->resetpass_del($row->id);
            }
            else
            {
                $token=urldecode($data['token']);
                if($row->m_token!=$token)
                {
                    echo "<div class='stt_mistake'>Mã truy cập không hợp lệ !</div>";
                    $this->UserModel->resetpass_set($row->id,'m_numcheck',$row->m_numcheck+1);
                }
                else
                {
                    $loi="";
                    $pass=$data['pass'];
                    $repass=$data['repass'];
                    if((strlen($pass)<4||strlen($pass)>50)&&$pass!="")
                    {
                        $loi.="<div class=''>Mật khẩu phải từ 4 đến 50 ký tự</div>";
                    }
                    if($pass!=$repass&&$pass!="")
                    {
                        $loi.="<div class=''>Mật khẩu lặp lại không đúng</div>";
                    }
                    $tick=false;
                    if($loi!="")
                    {
                        echo "<div class='stt_mistake'>".$loi."</div>";
                    }
                    else
                    {
                        $user=$this->db->query("SELECT * FROM ".$this->UserModel->get_table_name()." WHERE(m_email='".$email."')")->result();
                        if(count($user)<1)
                        {
                            echo "<div class='stt_mistake'>Không tìm thấy người dùng email này !</div>";
                        }
                        else
                        {
                            if($pass!="")
                            {
                                $userid=$user[0]->id;
                                if($this->UserModel->set($userid,'m_pass',md5($pass))==false)
                                {
                                    echo "<div class='stt_mistake'>Không cập nhật được mật khẩu mới, hãy thử lại !</div>";
                                }
                                else
                                {
                                    $this->UserModel->resetpass_del($row->id);
                                    echo "<div class='stt_avaiable'>Đã cập nhật mật khẩu mới !</div>";
                                    $tick=true;
                                    if($this->UserModel->login($user[0]->m_name,$pass)==false)
                                    {
                                        echo "<div class='stt_tip'><a href='".site_url("login")."'>Nhấn vào đây để tới trang đăng nhập !</a></div>";
                                    }
                                    else
                                    {
                                        echo "<div class='stt_avaiable'><a href='".site_url("")."'>Đã đăng nhập tự động, nhấn để về trang chủ</a></div>";
                                    }
                                }
                            }
                            
                        }
                    }
                    if($tick==false)
                    {
                        $user=$this->db->query("SELECT * FROM ".$this->UserModel->get_table_name()." WHERE(m_email='".$email."')")->result();
                        if(count($user)>0)
                        {
                            $user=$user[0];
                            echo "<div>Tên truy cập: ".$user->m_name."</div>";
                            echo "<div>Tên thật: ".$user->m_realname."</div>";
                            echo "<div>Truy cập lần cuối: ".my_time_ago_str($user->m_lasttime)."</div>";
                        }
                        echo "<div class='padding_v margin_v'>Email: ".$email."</div>";
                        echo "<form name='resetpass' method='post' action=''>";
                            echo "<input type='text' name='resetpass_newpass' placeholder='Nhập mật khẩu mới' value='".$pass."'>";
                            echo "<input type='text' name='resetpass_renewpass' placeholder='Nhập lại mật khẩu mới' value='".$repass."'>";
                            echo "<input type='submit' value='OK'>";
                        echo "</form>";
                    }
                }
            }
        }
    }
?>
</div>