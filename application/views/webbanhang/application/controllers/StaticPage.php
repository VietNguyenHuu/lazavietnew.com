<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StaticPage extends MY_Controller {

    public function index($id_page) {
        $static_page_row = $this->StaticPageModel->get_row(strpage()->decode($id_page)['pagenumber']);
        if ($static_page_row != false) {
            $this->_data['page_title'] = $static_page_row->m_title . " | " . $this->_data['page_domain_name'];
            $this->_data['page_keyword'] = $static_page_row->m_title . ", " . bodau($static_page_row->m_title);
            $this->_data['page_description'] = $static_page_row->m_title;
            $this->_data['page_fb_title'] = $static_page_row->m_title;
            $this->_data['page_fb_image'] = base_url() . $this->StaticPageModel->get_avata_original($static_page_row->id);
            $this->_data['page_fb_description'] = $static_page_row->m_title;
            
            $this->addCSS(parent::$base_static_folder . 'css/pages/staticPage.css');
            $this->addCSS(parent::$base_static_folder . 'js/ckeditor/plugins/chart/chart.css');
            $this->addJS(parent::$base_static_folder . 'js/ckeditor/plugins/chart/lib/chart.min.js');
            $this->addJS(parent::$base_static_folder . 'js/ckeditor/plugins/chart/widget2chart.js');
            $this->addJS(parent::$base_static_folder . 'js/pages/staticPage.js');
            if (!empty($static_page_row->m_adding_css)){
                $this->addCSSCustom($static_page_row->m_adding_css);
            }
            if (!empty($static_page_row->m_adding_js)){
                $this->addJSCustom($static_page_row->m_adding_js);
            }
            $data = Array(
                'page_dynamic' => 'staticPage',
                'page_option_showheader' => ($static_page_row->m_option_showheader == 1) ? true : false,
                'page_option_showfooter' => ($static_page_row->m_option_showfooter == 1) ? true : false,
                'page_option_showpublicmessage' => ($static_page_row->m_option_showquickmessage == 1) ? true : false,
                
                'data' => Array('id_page' => $static_page_row->id, 'staticpage_row' => $static_page_row)
            );
            $this->renderview($data);
        } else {
            redirect();
        }
    }
}
