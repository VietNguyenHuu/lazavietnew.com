<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Error_404 extends MY_Controller 
{

    public function index() {
        $this->_data['page_title'] = "Trang bạn vừa yêu cầu không tồn tại";
        $this->_data['page_keyword'] = "Trang bạn vừa yêu cầu không tồn tại";
        $this->_data['page_description'] = "Trang bạn vừa yêu cầu không tồn tại";
        $this->_data['page_fb_title'] = "Trang bạn vừa yêu cầu không tồn tại";
        $this->_data['page_fb_description'] = "Trang bạn vừa yêu cầu không tồn tại";
        $this->_data['page_fb_image'] = base_url() . "assets/img/system/favico.png";
        
        $this->autorenderview('error_404');
    }

}
