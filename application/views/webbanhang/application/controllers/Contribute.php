<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contribute extends MY_Controller {

    public function index() {
        $this->_data['page_title']          = "Form đóng góp ý kiến người dùng | ". $this->_data['page_domain_name'];
        $this->_data['page_keyword']        = "đóng góp ý kiến, ý kiến, dong gop y kien, y kien, " . $this->_data['page_domain_name'];
        $this->_data['page_description']    = "Nếu bạn có bất kỳ ý kiến hay thắc mắc nào xin hãy gởi về hệ thống, chúng tôi xin ghi nhận và giải quyết trong thời gian sớm nhất có thể.";
        $this->_data['page_fb_title']       = "Tiếp nhận ý kiến phản hồi - ". $this->_data['page_domain_name'];
        $this->_data['page_fb_image']       = base_url()."assets/img/system/favico.png";
        $this->_data['page_fb_description'] = "Hệ thống ghi nhận và phản hồi ý kiến người dùng.";
        
        $this->autorenderview('contribute');
    }

}
