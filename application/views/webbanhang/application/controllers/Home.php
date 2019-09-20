<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function index($page = 1) {
        $indexpage = $this->StaticPageModel->filter('m_is_primary', 1);
        if ($indexpage != false) {
            $indexpage = $indexpage[0];
            if ($indexpage->m_type == 'static') {
                /*
                 * include static page
                 */
                $static_page_row = $this->StaticPageModel->get_row($indexpage->id);
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
                    if (!empty($static_page_row->m_adding_css)) {
                        $this->addCSSCustom($static_page_row->m_adding_css);
                    }
                    if (!empty($static_page_row->m_adding_js)) {
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
                }
            } else {
                if (!in_array(strtolower($indexpage->m_link), Array('home', 'home/index', ''))) {
                    redirect($indexpage->m_link);
                }
            }
        } else {
            /*
             * include post home page
             */
            $post_type = $this->PostTypeModel->get_row(1);
            if ($post_type != false) {
                if ($post_type->m_seo_title != "" && $post_type->m_seo_title != null) {
                    $this->_data['page_title'] = $post_type->m_seo_title;
                    $this->_data['page_fb_title'] = $post_type->m_seo_title;
                } else {
                    $this->_data['page_title'] = $post_type->m_title . " - các bài viết trong chủ đề " . $post_type->m_title;
                    $this->_data['page_fb_title'] = $post_type->m_title . " - các bài viết trong chủ đề " . $post_type->m_title;
                }

                if ($post_type->m_seo_keyword != "" && $post_type->m_seo_keyword != null) {
                    $this->_data['page_keyword'] = $post_type->m_seo_keyword;
                } else {
                    $this->_data['page_keyword'] = bodau($post_type->m_title) . ", bai viet ve " . bodau($post_type->m_title);
                }

                if ($post_type->m_seo_description != "" && $post_type->m_seo_description != null) {
                    $this->_data['page_description'] = strip_tags($post_type->m_seo_description);
                    $this->_data['page_fb_description'] = $this->_data['page_description'];
                } else {
                    $this->_data['page_description'] = $post_type->m_title . ", Hệ thống bài viết tại " . $this->_data['page_domain_name'] . ", với những bài viết mới nhất được cập nhật trong chủ đề " . $post_type->m_title;
                    $this->_data['page_fb_description'] = $post_type->m_title . ", Hệ thống bài viết tại " . $this->_data['page_domain_name'] . ", với những bài viết mới nhất được cập nhật trong chủ đề " . $post_type->m_title;
                }

                $this->_data['page_fb_image'] = base_url() . $this->PostTypeModel->get_avata(1);
            }

            $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css', parent::$pos_head_end, parent::$render_type_plain);
            $this->autoinit('post_type');
            $data = Array(
                'page_dynamic' => 'post/type',
                'data' => Array(
                    'postPage' => 'type',
                    'recent_post_type' => 1,
                    'recent_post_type_row' => $post_type,
                    'recent_post_page' => 1
                )
            );
            $this->renderview($data);
        }
    }

}
