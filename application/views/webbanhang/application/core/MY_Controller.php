<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    protected $_main_template = '';
    protected $_data = [];
    
    /*
     * For css and js file
     */
    protected static $base_static_folder = 'assets/';
    protected static $pos_head_start = 'POS_HEAD_START';
    protected static $pos_head_end = 'POS_HEAD_END';
    protected static $pos_body_start = 'POS_BODY_START';
    protected static $pos_body_end = 'POS_BODY_END';
    protected static $render_type_plain = 'PLAIN';
    protected static $render_type_file = 'FILE';


    public function __construct() 
    {
        parent::__construct();
        $this->_main_template = 'template';
        $idname = $this->UserModel->check_login();
        $port=":".$_SERVER['SERVER_PORT'];
        if($port == ":80" || $port == ':443')
        {
            $port = "";
        }
        $this->_data = [
            'idname' => $idname,
            'page_js' => [],
            'page_css'=> [],
            'page_css_custom'=> '',
            'page_js_custom'=> '',
            'page_dynamic' => '',
            'page_slogend' => $this->SystemParamModel->get('Site_slogend', 'm_value'),
            'page_title' => $this->SystemParamModel->get('Site_title', 'm_value'),
            'page_description' => $this->SystemParamModel->get('Site_description', 'm_value'),
            'page_keyword' => $this->SystemParamModel->get('Site_keyword', 'm_value'),
            'page_fb_title' => $this->SystemParamModel->get('Site_fb_title', 'm_value'),
            'page_fb_description' => $this->SystemParamModel->get('Site_fb_description', 'm_value'),
            'page_fb_url' => $this->config->item('myconfig_protocol') . "://" . $_SERVER["SERVER_NAME"] . $port . $_SERVER['REQUEST_URI'],
            'page_fb_image' => 'assets/img/system/cover.jpg',
            'page_fb_fanpage' => $this->SystemParamModel->get('facebook_fanpage', 'm_value'),
            'page_fb_fanpage_title' => $this->SystemParamModel->get('facebook_fanpage_title', 'm_value'),
            'page_author' => $this->SystemParamModel->get('Site_domain_name', 'm_value'),
            'page_domain_name' => $this->SystemParamModel->get('Site_domain_name', 'm_value'),
            'page_option_showheader' => true,
            'page_option_showfooter' => true,
            'page_option_showanalytic' => ($this->SystemParamModel->get('page_option_showanalytic', 'm_value') == 'true') ? true : false,
            'page_option_showpublicmessage' => ($this->SystemParamModel->get('page_option_showpublicmessage', 'm_value') == 'true') ? true : false,
            'data' => []
        ];
        $this->addJS(
            self::$base_static_folder . "js/summary.js"
        );
        $this->addJS(
            "https://apis.google.com/js/platform.js",
            self::$pos_body_end,
            self::$render_type_file,
            true
        );
        
        $file = self::$base_static_folder . "css/summary.css";
        if (file_exists(self::$base_static_folder . "css/summary.min.css")){
            $file = self::$base_static_folder ."css/summary.min.css";
        }
        $this->addCSS($file);
    }
    
    public function renderview($data = [])
    {
        $data = array_merge($this->_data, $data );
        $this->load->view($this->_main_template, $data);
    }
    public function autoinit($str)
    {
        $this->addCSS(self::$base_static_folder . "css/pages/".$str.".css", self::$pos_head_end, self::$render_type_plain);
        $this->addJS(self::$base_static_folder . "js/pages/".$str.".js");
        $this->_data['page_dynamic'] = $str;
    }
    public function autorenderview($str)
    {
        $this->autoinit($str);
        $this->renderview();
    }
    
    public function addCSS($file = '', $pos = 'POS_HEAD_END', $renderType = 'FILE') {
        
        if (empty($file)){
            return false;
        }
        
        if (!file_exists($file)){
            return false;
        }
        if (empty($pos)){
            $pos = self::$pos_head_end;
        }
        array_push($this->_data['page_css'], [
            'file' => $file,
            'pos' => $pos,
            'type' => $renderType
        ]);
        
        return true;
    }
    public function addJS($file = '', $pos = 'POS_BODY_END', $renderType = 'FILE', $async = false) {
        
        if (empty($file)){
            return false;
        }
        
        if (!file_exists($file) && strpos($file, 'http') === false){
            return false;
        }
        if (empty($pos)){
            $pos = self::$pos_body_end;
        }
        if (empty($renderType)){
            $renderType = self::$render_type_file;
        }
        array_push($this->_data['page_js'], [
            'file' => $file,
            'pos' => $pos,
            'type' => $renderType,
            'async' => $async
        ]);
        
        return true;
    }
    
    public function addCSSCustom($str = '') {
        if (!empty($str)){
            $this->_data['page_css_custom'] .= $str;
        }
    }
    
    
    public function addJSCustom($str = '') {
        if (!empty($str)){
            $this->_data['page_js_custom'] .= $str;
        }
    }
}