<?php
    $login_id=$this->input->post('login_id');
    $temp_login=$this->UserModel->login_width_fb($login_id);
    if($temp_login!=false)
    {
        echo "Đăng nhập thành công";
        echo "<a href='#' id='register_successs_autodirect'><div class='stt_avaiable'>Nhấn vào đây nếu bạn không được chuyển trang tự động</div></a>";
    }
    else
    {
        $login_link=$this->input->post('login_id');
        $login_name=$this->input->post('login_name');
        $login_email=$this->input->post('login_email');
        $login_birthday=$this->input->post('login_birthday');
        $login_gender=$this->input->post('login_gender');
        
        $login_name_view=$login_name;
        $login_name=strtolower(bodau($login_name));
        $digit_add=1;
        $login_name_real=$login_name;
        while($this->UserModel->check_exit_username($login_name_real)!=false)
        {
            $login_name_real=$login_name_real."_".$digit_add;
            $digit_add++;
        }
        $login_name=$login_name_real;
        
        $str="<form action='javascript:login_width_fb.register()' method='post'>";
            $str.="<div class='stt_highlight' style='padding:0.5em 0px;border-bottom:1px solid #bbbbbb'>Chào ".$login_name_view."</div>";
            $str.="<div class='stt_tip fontsize_d2 padding_v'>Hãy chọn một tài khoản để đăng nhập bằng Facebook</div>";
            $str.="<div class='hide' id='register_width_fb_error_box' style='padding:0.5em'></div>";
            $str.="<table class='table_basic' style='width:100%;max-width:400px'>";
            $str.="<tr><td>Tên đăng nhập </td><td><input type='text' id='register_width_fb_name' value='".$login_name."' placeholder='Tên đăng nhập' onchange='login_width_fb.check_username()'></td></tr>";
            $str.="<tr><td>Mật khẩu </td><td><input type='password' id='register_width_fb_pass' value='' placeholder='Mật khẩu'  onchange='login_width_fb.check_pass()' autofocus></td></tr>";
            $str.="<tr><td>Lặp lại mật khẩu </td><td><input type='password' id='register_width_fb_repass' value='' placeholder='Lặp lại mật khẩu' onchange='login_width_fb.check_repass()'></td></tr>";
            $str.="<tr><td>Tên hiển thị </td><td><input type='text' id='register_width_fb_realname' value='".$login_name_view."' placeholder='Tên hiển thị'></td></tr>";
            $str.="</table>";
            $str.="<input hidden id='register_width_fb_email' value='".$login_email."' placeholder='Email'>";
            $str.="<input hidden id='register_width_fb_birthday' value='".$login_birthday."' placeholder='Ngày sinh'>";
            $str.="<input hidden id='register_width_fb_gender' value='".$login_gender."' placeholder='Giới tính'>";
            $str.="<input hidden id='register_width_fb_id' value='".$login_id."' placeholder='facebook id'>"; 
            $str.="<div class='align_center' style='margin:1em 0px'><button type='reset' class='padding_v'><span class='button padding'>Làm lại</span></button><button type='submit' class='padding_v'><span class='button padding'>Hoàn tất</span></button></div>";
        $str.="</form>";
        echo $str;
    }
?>