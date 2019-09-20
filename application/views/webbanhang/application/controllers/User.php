<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function index() {
        $this->autorenderview('user');
    }

    public function out() {
        $this->UserModel->out();
        redirect('');
    }

    public function profile($id_user) {
        $id_user = strpage()->decode($id_user)['pagenumber'];

        $user_row = $this->UserModel->get_row((int) $id_user);
        if ($user_row != false) {
            $this->_data['page_title'] = $user_row->m_realname . " | " . $this->_data['page_domain_name'];
            $this->_data['page_keyword'] = $user_row->m_realname . ", " . bodau($user_row->m_realname);
            $this->_data['page_description'] = $user_row->m_realname . " Là thành viên chính thức tại " . $this->_data['page_domain_name'] . ". Hãy trở thành thành viên và nhận thật nhiều ưu đãi từ hệ thống.";
            $this->_data['page_fb_title'] = $this->_data['page_title'];
            $this->_data['page_fb_image'] = base_url() . $this->UserModel->get_avata($id_user);
            $this->_data['page_fb_description'] = $user_row->m_realname . " Là thành viên chính thức tại " . $this->_data['page_domain_name'];
        }

        $this->autoinit('user_profile');
        $data = Array(
            'data' => Array('id_user' => (int) $id_user)
        );
        $this->renderview($data);
    }

}
