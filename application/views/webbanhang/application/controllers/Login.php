<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    public function index($base64_rdr = "") {
        $this->_data['page_title'] = "Đăng nhập | " . $this->_data['page_domain_name'];
        $this->_data['page_keyword'] = "Đăng nhập, dang nhap, " . $this->_data['page_domain_name'];
        $this->_data['page_description'] = "Chào mừng bạn đến với " . $this->_data['page_domain_name'] . ", hãy đăng nhập để sử dụng được đầy đủ chức năng";
        $this->_data['page_fb_title'] = "Đăng nhập - ".$this->_data['page_domain_name'];
        $this->_data['page_fb_description'] = "Hệ thống đăng nhập tại " . $this->_data['page_domain_name'] . ", hãy trở thành thành viên để sử dụng được đầy đủ chức năng";
        $this->_data['page_fb_image'] = base_url() . "assets/img/system/favico.png";
        $this->_data['page_option_showanalytic'] = false;
        $this->autoinit('login');
        $data = Array(
            'data' => Array('base64_rdr' => $base64_rdr)
        );
        $this->renderview($data);
    }

    public function resetpass($email = "", $token = "") 
    {
        $newpass = $this->input->post('resetpass_newpass');
        $renewpass = $this->input->post('resetpass_renewpass');
        $this->autoinit('login_resetpass');
        $data = Array(
            'data' => Array(
                'email' => $email, 
                'token' => $token,
                'pass' => $newpass, 
                'repass' => $renewpass
            )
        );
        $this->renderview($data);
    }

}
