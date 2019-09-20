<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_center extends CI_Controller {

    public function index() {
        $type = $this->input->post('type');
        $idname = $this->UserModel->check_login();
        $file = __DIR__ . "/Ajax_center/" . $type . ".php";
        if (file_exists($file)) {
            include_once($file);
        }
        $data = Array(
            'type' => $type,
            'idname' => $idname
        );
        $this->load->view('ajax', $data);
    }

}
