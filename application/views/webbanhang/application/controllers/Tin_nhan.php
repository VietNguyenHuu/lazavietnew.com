<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tin_nhan extends MY_Controller {

    public function index() {
        $this->with(false);
    }

    public function with($id_user = -1) {
        $this->autoinit('tin_nhan/index');
        $data = Array(
            'data' => Array('with_user' => $id_user)
        );
        $this->renderview($data);
    }

}
