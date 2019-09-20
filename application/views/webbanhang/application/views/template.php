<?php

$this->SystemModel->increase_access();
$t = TimeHelper();
$this->StatisticAccessModel->access($t->_nam, $t->_thang, $t->_ngay, $t->_gio);

$ar_replace = [
    '{{base_url}}' => $this->config->item('base_url'),
    '{{page_title}}' => $page_title,
    '{{page_slogend}}' => $page_slogend,
    '{{page_description}}' => $page_description,
    '{{page_keyword}}' => $page_keyword,
    '{{page_author}}' => $page_author,
    '{{page_fb_url}}' => $page_fb_url,
    '{{page_fb_type}}' => $this->config->item('myconfig_page_fb_type'),
    '{{page_fb_title}}' => $page_fb_title,
    '{{page_fb_description}}' => $page_fb_description,
    '{{page_fb_image}}' => $page_fb_image,
    '{{user_level}}' => $this->UserModel->get($idname, 'm_level'),
    '{{public_message}}' => '',
    '{{facebook_sdk}}' => $this->SystemParamModel->get('facebookSdkCode', 'm_value'),
    '{{google_analytic}}' => ($page_option_showanalytic == true) ? $this->SystemParamModel->get('googleAnalyticCode', 'm_value') : "",
    '{{page_css_head_end}}' => '',
    '{{page_js_head_end}}' => '',
    '{{page_js_body_start}}' => '',
    '{{page_js_body_end}}' => '',
    '{{page_js_custom}}' => $page_js_custom,
    '{{page_css_custom}}' => $page_css_custom,
    '{{mainmenu}}' => '',
    '{{header_area}}' => '',
    '{{main_dynamic_area}}' => '',
    '{{footer_area}}' => ''
];

/*
 * Calculator params
 */
if (isset($page_css)) {
    if (!empty($page_css)) {
        foreach ($page_css as $r) {
            if ($r['pos'] == 'POS_HEAD_END') {
                if ($r['type'] == 'FILE') {
                    $ar_replace['{{page_css_head_end}}'] .= "<link rel='stylesheet' type='text/css' href='" . $r['file'] . "' />\n";
                } else {
                    $ar_replace['{{page_css_head_end}}'] .= "<style>" . file_get_contents($r['file']) . "</style>\n";
                }
            }
        }
    }
}

if (isset($page_js)) {
    if (!empty($page_js)) {
        foreach ($page_js as $r) {
            if ($r['pos'] == 'POS_BODY_END') {
                if ($r['type'] == 'FILE') {
                    $ar_replace['{{page_js_body_end}}'] .= "<script src='" . $r['file'] . "' " . (($r['async']) ? 'async' : '') . "></script>\n";
                } else {
                    $ar_replace['{{page_js_body_end}}'] .= "<script>" . file_get_contents($r['file']) . "</script>\n";
                }
            }
        }
    }
}
/*
 * public message
 */
if ($page_option_showpublicmessage) {
    $ar_replace['{{public_message}}'] = mystr()->get_from_template(
            $this->load->design("block/public_message.html"), [
        '{{public_message_mail_input}}' => ''
            ]
    );
}

/*
 * Header area
 */

if ($page_option_showheader === true) {
    $s = $this->input->get('w');
    if (empty($s)) {
        $s = $this->input->post('w');
        if (empty($s)) {
            $s = "";
        }
    }
    /*
     * Member_area
     */
    $member_area = '';
    if ($idname != false) {
        $this->UserModel->set($idname, 'm_lasttime', time());
        $member_area = mystr()->get_from_template(
                $this->load->design("block/user_area_login.php"), [
            '{{avata}}' => $this->UserModel->get_avata($idname),
            '{{realname}}' => str_to_view($this->UserModel->get($idname, 'm_realname')),
            '{{mesageunread}}' => $this->db->query("SELECT id FROM " . $this->TinNhanModel->get_table_name() . " WHERE (m_id_user_to=" . $idname . "  AND m_militime_receive=-1)")->num_rows()
                ]
        );
    } else if (!in_array($this->router->fetch_class(), ['login', 'register'])) {
        $member_area = mystr()->get_from_template(
                $this->load->design("block/user_area_no_login.php"), [
            '{{link_login}}' => "login/index/" . str_replace("=", "", base64_encode($page_fb_url)),
            '{{link_register}}' => "register/index/" . str_replace("=", "", base64_encode($page_fb_url))
                ]
        );
    }

    /*
     * Main menu
     */
    $main_menu = '';
    if ($this->db->query("SELECT id FROM " . $this->StaticPageModel->get_table_name() . " WHERE (m_status='on' AND m_option_showinheader=1)")->num_rows() > 0) {

        function get_mainmenu($id_parent, &$strr, $static_page) {
            $strr .= "<ul>";
            $data = $static_page->get_direct_type($id_parent);
            if ($data !== false) {
                for ($i = 0; $i < count($data); $i++) {
                    if ($data[$i]['m_status'] == 'on' && $data[$i]['m_option_showinheader'] == 1) {
                        $link = $static_page->get_link_from_id($data[$i]['id']);
                        $temp_goto = $static_page->get_direct_type($data[$i]['id']);
                        if ($temp_goto != false) {
                            $temp_img_goto = "<i class=\"stt_highlight stt_action fa fa-chevron-circle-down fontsize_d2 goto\" onclick=\"$(this).parents('li').toggleClass('extra');$(this).toggleClass('fa-rotate-180')\"></i>";
                        } else {
                            $temp_img_goto = '';
                        }

                        $strr .= "<li><a href='" . $link . "'><img class='menu_icon' data-original='" . $static_page->get_avata($data[$i]['id']) . "' alt='" . html_entity_decode($data[$i]['m_title'], 1, 'utf-8') . "'/>" . html_entity_decode($data[$i]['m_title'], 1, 'utf-8') . "</a>" . $temp_img_goto;
                        if ($temp_goto !== false) {
                            get_mainmenu($data[$i]['id'], $strr, $static_page);
                        }
                        $strr .= "<div class='clear_both'></div></li>";
                    }
                }
                $strr .= "<div class='clear_both'></div></li>";
            }
            $strr .= "</ul>";
        }

        $str = "";
        get_mainmenu(1, $str, $this->StaticPageModel);
        $main_menu = mystr()->get_from_template(
                $this->load->design('block/mainmenu.php'), [
            '{{main_menu_items}}' => $str
                ]
        );
    }
    /*
     * Render header
     */
    $ar_replace['{{header_area}}'] = mystr()->get_from_template(
            $this->load->design('block/header.html'), [
        '{{page_search_value}}' => str_to_view($s, false),
        '{{member_area}}' => $member_area,
        '{{mainmenu}}' => $main_menu
            ]
    );
}

/*
 * Footer_area
 */
if ($page_option_showfooter === true) {
    $footer_links = '';
    $ar_footerlinkbox = $this->db->query(""
                    . "SELECT * FROM " . $this->StaticPageModel->get_table_name()
                    . " WHERE m_id_parent = 1"
                    . " ORDER BY m_index ASC"
            )->result();
    if (!empty($ar_footerlinkbox)) {
        $toggle_hide = "<div class=\"responsive_only_mobi float_right\"><i class=\"fa fa-chevron-circle-down\" onclick=\"$(this).parents('.footer_box').toggleClass('expand');$(this).toggleClass('fa-rotate-180')\"></i></div><div class=\"clear_both\"></div>";
        $temp_footerlinkbox = $this->load->design('block/footer_linkbox.html');
        $temp_footerlinkitem = $this->load->design('block/footer_linkitem.html');
        foreach ($ar_footerlinkbox as $linkbox) {
            $linksofbox = '';
            $ar_linksofbox = $this->db->query(""
                            . "SELECT * FROM " . $this->StaticPageModel->get_table_name()
                            . " WHERE m_id_parent = " . $linkbox->id
                            . " ORDER BY m_index ASC"
                    )->result();
            if (!empty($ar_linksofbox)) {
                foreach ($ar_linksofbox as $linkofbox) {
                    $linksofbox .= mystr()->get_from_template(
                            $temp_footerlinkitem, [
                        '{{href}}' => $this->StaticPageModel->get_link_from_id($linkofbox->id),
                        '{{title}}' => ($linkofbox->m_title_shorcut == '') ? $linkofbox->m_title : $linkofbox->m_title_shorcut
                            ]
                    );
                }
            }
            $footer_links .= mystr()->get_from_template(
                    $temp_footerlinkbox, [
                '{{widthclass}}' => 'width3 width3_0_12 width3_720_6 width3_1024_3',
                '{{title}}' => ($linkbox->m_title_shorcut == '') ? $linkbox->m_title : $linkbox->m_title_shorcut,
                '{{toggle_hide}}' => $toggle_hide,
                '{{links}}' => $linksofbox
                    ]
            );
        }
    }
    $ar_replace['{{footer_area}}'] = mystr()->get_from_template(
            $this->load->design('block/footer.html'), [
        '{{footer_links}}' => $footer_links,
        '{{fb_fanpage_link}}' => $page_fb_fanpage,
        '{{domain_name}}' => $this->SystemParamModel->get('Site_domain_name', 'm_value'),
        '{{current_year}}' => TimeHelper()->_nam,
        '{{page_slogend}}' => $page_slogend,
        '{{company_name}}' => $this->SystemParamModel->get('Company_name', 'm_value')
            ]
    );
}


/*
 * Render view
 */
$template = explode(
        '{{main_dynamic_area}}', $this->load->design('template.php')
);
$c = count($template);
if ($c > 0) {
    echo mystr()->get_from_template($template[0], $ar_replace);
    if (isset($page_dynamic)) {
        if (file_exists(VIEWPATH . "page_dynamic/" . $page_dynamic . '.php')) {
            include_once(VIEWPATH . "page_dynamic/" . $page_dynamic . '.php');
        }
    }
    if ($c > 1) {
        echo mystr()->get_from_template($template[1], $ar_replace);
    }
}
?>