<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends My_Controller {

    public function index() {
        redirect("admin/statistic");
    }

    public function user() {
        $this->autoinit('admin');
        $this->addCSS(parent::$base_static_folder . 'css/pages/admin_user.css');
        $this->addJS(parent::$base_static_folder . 'js/pages/admin_user.js');
        $data = [
            'data' => ['adminPage' => 'user'],
            'page_option_showanalytic' => false
        ];
        $this->renderview($data);
    }

    public function setting() {
        $this->autoinit('admin');
        $this->addCSS(parent::$base_static_folder . 'css/pages/admin_setting.css');
        $this->addJS(parent::$base_static_folder . 'js/ckeditor/ckeditor.js');
        $this->addJS(parent::$base_static_folder . 'js/pages/admin_setting.js');
        $data = [
            'data' => ['adminPage' => 'setting'],
            'page_option_showanalytic' => false
        ];
        $this->renderview($data);
    }

    public function post() {
        $this->addJS(parent::$base_static_folder . 'js/buzz.js');
        $this->addJS(parent::$base_static_folder . 'js/ckeditor/ckeditor.js');
        $this->autoinit('admin');
        $this->addJS(parent::$base_static_folder . 'js/pages/admin_post.js');
        $this->addCSS(parent::$base_static_folder . 'css/pages/admin_post.css');
        $data = [
            'data' => ['adminPage' => 'post'],
            'page_option_showanalytic' => false
        ];
        $this->renderview($data);
    }

    public function statistic() {
        $this->addJS(parent::$base_static_folder . 'js/dygraph-combined.js');
        $this->autoinit('admin');
        $this->addJS(parent::$base_static_folder . 'js/pages/admin_statistic.js');
        $this->addCSS(parent::$base_static_folder . 'css/pages/admin_statistic.css');
        $data = [
            'data' => ['adminPage' => 'statistic'],
            'page_option_showanalytic' => false
        ];
        $this->renderview($data);
    }

    public function config() {
        $this->autoinit('admin');
        $this->addJS(parent::$base_static_folder . 'js/pages/admin_config.js');
        $this->addCSS(parent::$base_static_folder . 'css/pages/admin_config.css');
        $data = [
            'data' => ['adminPage' => 'config'],
            'page_option_showanalytic' => false
        ];
        $this->renderview($data);
    }

}
