<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller 
{

    public function index() 
    {
        $this->_data['page_title'] ="Đăng ký thành viên | ".$this->_data['page_domain_name'];
        $this->_data['page_keyword'] ="đăng ký, đăng ký thành viên mới, dang ky";
        $this->_data['page_description'] ="Chào mừng bạn đã đến với ".$this->_data['page_domain_name'].", hãy nhanh tay đăng ký tài khoản để trở thành thành viên chính thức và hưởng nhiều ưu đãi từ hệ thống.";
        $this->_data['page_fb_title'] ="Đăng ký thành viên mới";
        $this->_data['page_fb_image'] =base_url()."assets/img/system/favico.png";
        $this->_data['page_fb_description'] ="Trở thành thành viên và nhận thật nhiều ưu đãi từ hệ thống";
        $this->_data['page_option_showanalytic'] = false;
        $this->autorenderview('register');
    }

}
