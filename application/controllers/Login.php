<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        $username = $this->input->post('UserName');
        $password = $this->input->post('PassWord');
        // var_dump($username);
        // var_dump($password);
        $kq = $this->db->query("SELECT V_UserName FROM user WHERE V_UserName='" . $username . "' AND V_PassWord='" . $password . "'");
        if ($kq) {
            $kq = $kq->result();
            if ($kq != false) {
                //echo"<div>Dang nhap thanh cong!</div>";
                $this->session->set_userdata('username', $username);
                redirect('');
            } else {
                //echo"<div>Dang nhap that bai!</div>";
            }
        }
        $this->load->view('Login', ['addcss' => 'login.css']);
    }

}
