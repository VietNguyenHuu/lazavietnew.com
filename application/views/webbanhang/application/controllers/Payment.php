<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller {

    public function index() {
        $this->_data['page_option_showanalytic'] = false;
        $this->autorenderview('payment/index');
    }
}
