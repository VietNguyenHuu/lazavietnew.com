<?php
    $r_id=$this->input->post('r_id');
    $r_username=$this->input->post('r_username');
    $r_pass=$this->input->post('r_pass');
    $r_repass=$this->input->post('r_repass');
    $r_realname=$this->input->post('r_realname');
    if(mb_strlen($r_username,'utf8')<2||mb_strlen($r_username,'utf8')>20)
    {
        echo "<div class='stt_mistake'>Đăng ký không thành công, độ dài tên không hợp lệ.<br>Tên hợp lệ phải từ 2 đến 20 ký tự</div>";
    }
    else if(preg_match('/[^a-zA-Z0-9 _]/',$r_username))
    {
        echo "<div class='stt_mistake'>Tên đăng ký chỉ được chứa ký tự chữ không dấu, số, khoảng trắng và dấu gạch dưới '_'</div>";
    }
    else if($this->UserModel->check_exit_username($r_username)!=false)
    {
        echo "<div class='stt_mistake'>Đăng ký không thành công, đã tồn tại người dùng với tên đăng nhập này</div>";
    }
    else if(mb_strlen($r_pass,'utf8')<2||mb_strlen($r_pass,'utf8')>20)
    {
        echo "<div class='stt_mistake'>Đăng ký không thành công, độ dài mật khẩu không hợp lệ.<br>Mật khẩu hợp lệ phải từ 2 đến 20 ký tự</div>";
    }
    else if($r_pass!=$r_repass)
    {
        echo "<div class='stt_mistake'>Đăng ký không thành công, mật khẩu lặp lại không trùng khớp</div>";
    }
    else
    {
        $tempp_tt=$this->UserModel->add(Array(
            'username'=>$r_username,
            'password'=>$r_pass,
            'realname'=>$r_realname,
            'sex'=>1,
            'birthday'=>'2000-01-01',
            'phone'=>'no',
            'email'=>'no',
            'province_code'=>0,
            'address'=>'no',
            'fb_token'=>$r_id
       ));
       if($tempp_tt!=false)
       {
            $this->UserModel->login_width_fb($r_id);
            echo "<div class='stt_avaiable'>Đăng ký thành công</div>";
            echo "<a href='#' id='register_successs_autodirect'><div class='stt_avaiable'>Nhấn vào đây nếu bạn không được chuyển trang tự động</div></a>";
       }
       else
       {
            echo "<div class='stt_mistake'>Đăng ký không thành công, hãy thực hiện lại sau.</div>".$r_username;
       }
    }
?>