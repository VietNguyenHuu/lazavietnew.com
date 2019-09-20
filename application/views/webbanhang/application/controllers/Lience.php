<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lience extends MY_Controller {

    public function index() {
        $this->_data['page_title'] = "Điều khoản và chính sách | " . $this->_data['page_domain_name'];
        $this->_data['page_keyword'] = "điều khoản sử dụng, chính sách, dieu khoan, chinh sach, ".$this->_data['page_domain_name'];
        $this->_data['page_description'] = "Các quy định liên quan đến điều khoản và chính sách người dùng";
        $this->_data['page_fb_title'] = "Chính sách người dùng";
        $this->_data['page_fb_description'] = "Các quy định liên quan đến các điều khoản và chính sách người dùng.";
        $this->_data['page_fb_image'] = base_url()."assets/img/system/favico.png";
        
        $this->autorenderview('lience');
    }

}
