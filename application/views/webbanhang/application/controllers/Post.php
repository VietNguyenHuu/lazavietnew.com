<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends MY_Controller {

    public function index($page = 1) {
        $this->type(1, $page);
    }

    public function tat_ca_danh_muc() {
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_alltype');
        $data = Array(
            'page_dynamic' => 'post/alltype'
        );
        $this->renderview($data);
    }

    public function type($type = 1, $page = 1) {
        $type = strpage()->decode($type)['pagenumber'];
        $page = strpage()->decode($page)['pagenumber'];

        $post_type = $this->PostTypeModel->get_row($type);
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

            $this->_data['page_fb_image'] = base_url() . $this->PostTypeModel->get_avata($type);
        }

        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css', parent::$pos_head_end, parent::$render_type_plain);
        $this->autoinit('post_type');
        $data = Array(
            'page_dynamic' => 'post/type',
            'data' => Array(
                'postPage' => 'type',
                'recent_post_type' => $type,
                'recent_post_type_row' => $post_type,
                'recent_post_page' => $page
            )
        );
        $this->renderview($data);
    }

    public function content($content = 1) {
        $content = strpage()->decode($content)['pagenumber'];
        $post_line = $this->PostContentModel->get_row($content);
        if ($post_line != false) {
            if ($post_line->m_seo_title == "") {
                $this->_data['page_title'] = str_to_view($post_line->m_title, false) . " | " . str_to_view($this->PostTypeModel->get($post_line->m_id_type, 'm_title'));
                $this->_data['page_fb_title'] = str_to_view($post_line->m_title, false) . " - " . str_to_view($this->PostTypeModel->get($post_line->m_id_type, 'm_title'));
            } else {
                $this->_data['page_title'] = str_to_view($post_line->m_seo_title, false);
                $this->_data['page_fb_title'] = str_to_view($post_line->m_seo_title, false);
            }

            if ($post_line->m_seo_keyword == "") {
                $this->_data['page_keyword'] = str_to_view(bodau($post_line->m_title), false) . ", " . str_to_view($post_line->m_title, false) . ", " . bodau($this->PostTypeModel->get($post_line->m_id_type, 'm_title'));
            } else {
                $this->_data['page_keyword'] = str_to_view($post_line->m_seo_keyword, false);
            }

            if ($post_line->m_seo_description == "") {
                $list_tags = $this->db->query("SELECT * FROM " . $this->PostTagsModel->get_table_name() . " WHERE (m_id_post=" . $post_line->id . ") ORDER BY id ASC")->result();
                $str_c = Array();
                if (count($list_tags) > 0) {
                    foreach ($list_tags as $line) {
                        array_push($str_c, str_to_view($line->m_title, false));
                    }
                }
                if (count($str_c) > 0) {
                    $str_c = " " . implode(", ", $str_c) . ".";
                } else {
                    $str_c = "";
                }
                $this->_data['page_description'] = str_to_view($post_line->m_title, false) . " | " . $this->PostTypeModel->get($post_line->m_id_type, 'm_title') . "." . $str_c;
                $this->_data['page_fb_description'] = str_to_view($post_line->m_title, false) . " - " . $this->PostTypeModel->get($post_line->m_id_type, 'm_title') . ". " . $str_c;
            } else {
                $this->_data['page_description'] = str_to_view($post_line->m_seo_description, false);
                $this->_data['page_fb_description'] = str_to_view($post_line->m_seo_description, false);
            }

            $this->_data['page_fb_image'] = base_url() . $this->PostContentModel->get_avata_original($post_line->id);
        }

        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css', parent::$pos_head_end, parent::$render_type_plain);
        $this->addCSS(parent::$base_static_folder . 'css/pages/post.css', parent::$pos_head_end, parent::$render_type_plain);
        $this->autoinit('post_content');
        $data = Array(
            'page_dynamic' => 'post/content',
            'data' => Array(
                'recent_post_type' => $this->PostContentModel->get($content, 'm_id_type'),
                'recent_post_content' => $content,
                'post_line' => $post_line
            )
        );
        $this->renderview($data);
    }

    public function search($str_page = 'trang-1') {
        $search_word = trichdan(urldecode($this->input->get('w')), 100);
        $page = $this->input->get('p');

        $this->_data['page_title'] = "Tìm kiếm bài viết tại " . $this->_data['page_domain_name'];
        $this->_data['page_keyword'] = "tim kiem, tim kiem bai viet, bai viet, bai viet moi";
        $this->_data['page_description'] = "Hệ thống tìm kiếm bài viết tại " . $this->_data['page_domain_name'] . ", với những bài viết mới nhất được cập nhật từ nhiều chủ đề được bạn đọc quan tâm.";
        $this->_data['page_fb_title'] = "Tìm kiếm bài viết tại " . $this->_data['page_domain_name'];
        $this->_data['page_fb_description'] = "Hệ thống tìm kiếm bài viết tại " . $this->_data['page_domain_name'] . ", với những bài viết mới nhất được cập nhật từ nhiều chủ đề được bạn đọc quan tâm.";
        $this->_data['page_fb_image'] = base_url() . "assets/img/system/search-glass.png";

        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->addJS(parent::$base_static_folder . 'js/pages/post_content.js');
        $this->autoinit('post_search');
        $data = Array(
            'page_dynamic' => 'post/search',
            'data' => Array(
                'postPage' => 'search',
                'search_word' => $search_word,
                'page' => $page
            )
        );
        $this->renderview($data);
    }

    public function write($checktype = 'tat-ca', $str_page = 'trang-1') {//checktype=tat-ca,cho-duyet,tu-choi 
        if ($checktype != 'tat-ca' && $checktype != 'cho-duyet' && $checktype != 'tu-choi') {
            $checktype = 'tat-ca';
        }
        
        $this->_data['page_title'] ="Đăng bài viết tại ".$this->_data['page_domain_name'];
        $this->_data['page_keyword'] ="viet bai, bai viet, bai viet moi";
        $this->_data['page_description'] ="Hệ thống viết bài tại ".$this->_data['page_domain_name'];
        $this->_data['page_fb_title'] ="Đăng bài viết tại ".$this->_data['page_domain_name'];
        $this->_data['page_fb_image'] =base_url()."assets/img/system/favico.png";
        $this->_data['page_fb_description'] ="Hệ thống viết bài tại ".$this->_data['page_domain_name'];
    
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->addJS(parent::$base_static_folder . 'js/dnedit.js');
        $this->addJS(parent::$base_static_folder . 'js/ckeditor/ckeditor.js');
        $this->addJS(parent::$base_static_folder . 'js/pages/post_content.js');
        $this->autoinit('post_write');
        $data = Array(
            'page_dynamic' => 'post/write',
            'data' => Array(
                'str_page' => $str_page,
                'checktype' => $checktype
            )
        );
        $this->renderview($data);
    }

    public function write_detail($id_post = -1) {
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_write_detail');
        $data = Array(
            'page_dynamic' => 'post/write_detail',
            'data' => Array('id_post' => (int) $id_post)
        );
        $this->renderview($data);
    }

    public function follow_manager($str_page = 'trang-1') {
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_follow_manager');
        $data = Array(
            'page_dynamic' => 'post/follow_manager',
            'data' => Array('str_page' => $str_page)
        );
        $this->renderview($data);
    }

    public function author($str_author = '-1', $str_page = 'trang-1') {
        $author_user = $this->UserModel->get_row(strpage()->decode($str_author)['pagenumber']);
        if ($author_user != false) {
            $numpost = $this->db->query("SELECT id FROM " . $this->PostContentModel->get_table_name() . " WHERE m_id_user=" . $author_user->id . " AND m_id_user_check!=-1")->num_rows();

            $this->_data['page_title'] = "Tác giả " . str_to_view($author_user->m_realname, false) . " | " . $this->_data['page_domain_name'];
            $this->_data['page_keyword'] = bodau(str_to_view($author_user->m_realname, false)) . "," . str_to_view($author_user->m_realname, false) . ",tác giả " . str_to_view($author_user->m_realname, false);
            $this->_data['page_description'] = "Tác giả " . str_to_view($author_user->m_realname, false) . " hiện có tất cả " . $numpost . " bài viết. Xem danh sách bài viết của tác giả " . str_to_view($author_user->m_realname, false);
            $this->_data['page_fb_title'] = "Tác giả " . str_to_view($author_user->m_realname, false) . " - " . $this->_data['page_domain_name'];
            $this->_data['page_fb_description'] = "Tác giả " . str_to_view($author_user->m_realname, false) . " hiện có tất cả " . $numpost . " bài viết. Xem danh sách bài viết của tác giả " . str_to_view($author_user->m_realname, false);
            $this->_data['page_fb_image'] = base_url() . $this->UserModel->get_avata_original($author_user->id);
        }

        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_author');
        $data = Array(
            'page_dynamic' => 'post/author',
            'data' => Array(
                'str_page' => $str_page,
                'str_author' => $str_author
            )
        );
        $this->renderview($data);
    }

    public function all_author($page = 'trang-1') {
        $page = strpage()->decode($page)['pagenumber'];
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_all_author');
        $data = Array(
            'page_dynamic' => 'post/all_author',
            'data' => Array('page' => $page)
        );
        $this->renderview($data);
    }

    public function tags($str_tags = "", $str_page = 'trang-1') {
        $tags_word = str_to_view(str_replace(Array('-'), Array(' '), $str_tags), false);

        $this->_data['page_title'] = $tags_word . " | các bài viết trong tags " . $tags_word;
        $this->_data['page_keyword'] = $tags_word . ", " . bodau($tags_word);
        $this->_data['page_description'] = $tags_word . ", Các bài viết mới nhất và cập nhật liên tục trong tags " . $tags_word;
        $this->_data['page_fb_title'] = $tags_word . " | các bài viết trong tags " . $tags_word;
        $this->_data['page_fb_image'] = base_url() . "assets/img/system/search-glass.png";
        $this->_data['page_fb_description'] = $this->_data['page_description'];

        $this->addJS(parent::$base_static_folder . 'js/pages/post_content.js');
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_tags');
        $data = Array(
            'page_dynamic' => 'post/tags',
            'data' => Array(
                'postPage' => 'tags',
                'recent_post_type' => 1,
                'tags_word' => $str_tags,
                'str_page' => $str_page
            )
        );
        $this->renderview($data);
    }

    public function all_tag($str_page = 'trang-1') {
        $page = strpage()->decode($str_page)['pagenumber'];
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_all_tag');
        $data = Array(
            'page_dynamic' => 'post/all_tag',
            'data' => Array('page' => $page)
        );
        $this->renderview($data);
    }

    public function download($id_content = -1) {
        $id_content = (int) $id_content;
        $post_line = $this->PostContentModel->get_row($id_content);
        if ($post_line == false) {
            redirect(base_url());
        }
        //cho phép download file pdf cho bài viết
        $file_des = "download/post_pdf/" . $post_line->id . '.pdf';
        if (!file_exists($file_des)) {//nếu file chưa tồn tại
            set_time_limit(300);
            ini_set('memory_limit', "500M");
            $this->load->library('tcpdf/tcpdf');
            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($this->_data['page_author']);
            $pdf->SetTitle($post_line->m_title);
            $pdf->SetSubject('Xam bài viết dưới dạng PDF');
            $pdf->SetKeywords(bodau($post_line->m_title));

            $pdf->SetFont('dejavusans', '', 12, '', true);
            $pdf->SetHeaderData(null, null, $this->_data['page_slogend'], $this->SystemParamModel->get('Site_domain_name', 'm_value'), array(0, 64, 255), array(0, 64, 128));
            $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
            $pdf->setHeaderFont(Array('dejavusans', '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array('dejavusans', '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('dejavusans', '', 12, '', true);

            $pdf->AddPage();
            //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
            //nội dung
            //tiêu đề
            $html = "<h1 style='color:#3333ff'><font color='#3333ff'>" . $post_line->m_title . "</font></h1>";
            //content
            $html .= "<div>" . strip_tags($post_line->m_content, "<p><span><div><img><h1><h2><h3><h4><h5><h6><a><b><u><i><ul><ol><li>") . "</div>";
            //info
            //kết xuất file
            $pdf->writeHTML($html, true, false, true, false, '');
            //xuất pdf ra file
            file_put_contents($file_des, $pdf->Output($file_des, 'S'));
        }
        if (!file_exists($file_des)) {
            redirect(site_url(""));
        } else {
            if (ob_get_contents()) {
                //$this->Error('Some data has already been output, can\'t send PDF file');
            }
            if (php_sapi_name() != 'cli') {
                // send output to a browser
                header('Content-Type: application/pdf');
                if (headers_sent()) {
                    //$this->Error('Some data has already been output to browser, can\'t send PDF file');
                }
                header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
                //header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
                header('Pragma: public');
                header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
                header('Content-Disposition: inline; filename="' . dn_urlencode($post_line->m_title) . '.pdf' . '"');
                //TCPDF_STATIC::sendOutputData($this->getBuffer(), $this->bufferlen);
                echo file_get_contents($file_des);
            } else {
                file_get_contents($file_des);
            }
        }
    }

    public function bao_loi($id_post = -1) {
        //$this->addCSS(parent::$base_static_folder. 'css/pages/post_material.css');
        $this->autoinit('post_report');
        $data = Array(
            'page_dynamic' => 'post/report',
            'data' => Array('id_post' => $id_post)
        );
        $this->renderview($data);
    }

    public function recent_view($page = 1) { //bài viết được quan tâm gần đây
        $page = strpage()->decode($page)['pagenumber'];
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_recent_view');
        $data = Array(
            'page_dynamic' => 'post/recent_view',
            'data' => Array('page' => $page)
        );
        $this->renderview($data);
    }

    public function like($page = 1) {//bài viết được yêu thích 
        $page = strpage()->decode($page)['pagenumber'];
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_like');
        $data = Array(
            'page_dynamic' => 'post/like',
            'data' => Array('page' => $page)
        );
        $this->renderview($data);
    }

    public function series($page = 1)
    {
        $this->load->model('PostGroupModel');
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_series');
        $data = [
            'data' => ['page' => $page],
            'page_dynamic' => 'post/series',
        ];
        $this->renderview($data);
    }
    public function series_detail($id = -1)
    {
        $this->load->model('PostGroupModel');
        $this->addCSS(parent::$base_static_folder . 'css/pages/post_material.css');
        $this->autoinit('post_series_detail');
        $data = [
            'data' => ['id' => $id],
            'page_dynamic' => 'post/series_detail',
        ];
        $this->renderview($data);
    }
}
