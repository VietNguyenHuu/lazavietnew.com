<div class="page_title">
    <h1 class="width_max800px">Trình cài đặt dữ liệu gốc website</h1>
</div>
<div class="width_max800px">
    <?php
    $ar_mistake = [];
    /*
     * Check data input
     */
    $reset_securecode = $this->input->post('reset_securecode');

    $reset_domainname = $this->input->post('reset_domainname');
    $reset_title = $this->input->post('reset_title');
    $reset_postroottype = $this->input->post('reset_postroottype');

    $reset_username = $this->input->post('reset_username');
    $reset_password = $this->input->post('reset_password');
    $reset_email = $this->input->post('reset_email');

    if (empty($reset_securecode)) {
        array_push($ar_mistake, 'Do not empty secure code');
    } else if ($reset_securecode != $this->config->item('myconfig_reset_secure_code')) {
        array_push($ar_mistake, 'Secure code is not match');
    } else if (empty($reset_username)) {
        array_push($ar_mistake, 'Do not empty admin username');
    } else if (empty($reset_password)) {
        array_push($ar_mistake, 'Do not empty admin password');
    } else if (empty($reset_email)) {
        array_push($ar_mistake, 'Do not empty admin email');
    }

    if (!empty($ar_mistake)) {
        foreach ($ar_mistake as $mistake) {
            echo "<div class='stt_mistake'>" . $mistake . "</div>";
        }
        echo mystr()->get_from_template($this->load->design('block/reset/form.html'), [
            '{{reset_securecode}}' => $reset_securecode,
            '{{reset_domainname}}' => $reset_domainname,
            '{{reset_title}}' => $reset_title,
            '{{reset_postroottype}}' => $reset_postroottype,
            '{{reset_username}}' => $reset_username,
            '{{reset_password}}' => $reset_password,
            '{{reset_email}}' => $reset_email
        ]);
    } else {
        /*
         * clear database
         */
        $ar_model = $data['ar_model'];
        if (!empty($ar_model)) {
            foreach ($ar_model as $modelline) {
                $this->$modelline->delAllData();
            }
        }
        $ar_table_toempty = [
            'ci_sessions',
            'post_content_content',
            'reset_pass',
        ];
        if (!empty($ar_table_toempty)) {
            foreach ($ar_table_toempty as $ar_table_toemptyline) {
                $this->db->query("TRUNCATE " . $ar_table_toemptyline);
            }
        }
        /*
         * init basic database
         */
        $this->db->insert($this->SystemModel->get_table_name(), [
            'id' => 1,
            'm_creatted_id' => 1,
            'm_count_access' => 0
        ]);
        $ar_system_param = [
            [
                'm_name' => "admin_post_content_lastresetview",
                'm_value' => "0",
                'm_comment' => "Thời gian cuối cập nhật lượt xem cho tất cả bài viết"
            ],
            [
                'm_name' => "googleAnalyticCode",
                'm_value' => "",
                'm_comment' => ""
            ],
            [
                'm_name' => "facebookSdkCode",
                'm_value' => "",
                'm_comment' => ""
            ],
            [
                'm_name' => "Phone_support",
                'm_value' => "",
                'm_comment' => "Phone for support in website, customer of website can view this phone."
            ],
            [
                'm_name' => "Company_name",
                'm_value' => "",
                'm_comment' => "Full name of company."
            ],
            [
                'm_name' => "Post_mg_when_check",
                'm_value' => "Bài viết của bạn đã được duyệt và hiển thị tại {{link}}, hãy chia sẻ tới bạn bè để mọi người cùng đọc nhé ! \n Bạn được cộng {{bonus_score}} điểm cho bài viết này !",
                'm_comment' => "Message will send to post author, when admin check this post"
            ],
            [
                'm_name' => "Post_bonus_score_write",
                'm_value' => "0",
                'm_comment' => "Score to add into author when post check"
            ],
            [
                'm_name' => "Post_bonus_score_view",
                'm_value' => "0",
                'm_comment' => "Score to add into author when post view"
            ],
            [
                'm_name' => "Site_domain_name",
                'm_value' => $reset_domainname,
                'm_comment' => "Domain name of website"
            ],
            [
                'm_name' => "Site_slogend",
                'm_value' => "website " . $reset_title,
                'm_comment' => "Slogend of site"
            ],
            [
                'm_name' => "facebook_fanpage",
                'm_value' => "",
                'm_comment' => "Link to facebook fanpage"
            ],
            [
                'm_name' => "facebook_fanpage_title",
                'm_value' => "",
                'm_comment' => "Title of fanpage facebook"
            ],
            [
                'm_name' => "Site_title",
                'm_value' => $reset_title,
                'm_comment' => "Default title of website"
            ],
            [
                'm_name' => "Site_description",
                'm_value' => "Chào mứng bạn đến với " . $reset_title,
                'm_comment' => "Default scription of website"
            ],
            [
                'm_name' => "Site_keyword",
                'm_value' => $reset_title,
                'm_comment' => "Default keyword of website"
            ],
            [
                'm_name' => "Site_fb_title",
                'm_value' => $reset_title,
                'm_comment' => "Default fb title of website"
            ],
            [
                'm_name' => "Site_fb_description",
                'm_value' => "Chào mứng bạn đến với " . $reset_title,
                'm_comment' => "Default description fb of website"
            ],
            [
                'm_name' => "page_option_showpublicmessage",
                'm_value' => "true",
                'm_comment' => "Show quick public message in footer. This allow all person can send a message to your website."
            ],
            [
                'm_name' => "page_option_showanalytic",
                'm_value' => "true",
                'm_comment' => "Allow google analytic tracking website"
            ],
        ];
        if (!empty($ar_system_param)) {
            foreach ($ar_system_param as $ar_system_param_line) {
                $this->db->insert($this->SystemParamModel->get_table_name(), $ar_system_param_line);
            }
        }
        $this->UserModel->add([
            'username' => $reset_username,
            'password' => $reset_password,
            'realname' => 'Admin',
            'sex' => 1,
            'birthday' => '1970-01-01',
            'phone' => 'no',
            'email' => $reset_email,
            'province_code' => 0,
            'address' => 'no',
            'fb_token' => '-1'
        ]);
        $this->db->insert($this->PostTypeModel->get_table_name(), [
            'id' => 1,
            'm_id_parent' => -1,
            'm_title' => $reset_postroottype,
            'm_index' => 1,
            'm_status' => 'ready',
            'm_view' => 0
        ]);
        /*
         * Clear files
         */
        $ar_folder_empty = [
            'download/post_pdf',
            'sitemap',
            'upload/img/',
            'sitemap.xml',
            'assets/img/ckeditor'
        ];
        if (!empty($ar_folder_empty)) {
            foreach ($ar_folder_empty as $ar_folder_empty_line) {
                folder_deleteAllFile($ar_folder_empty_line);
            }
        }

        /*
         * Init basic file
         */
        if (file_exists('assets/img/default_avata/favico.png')){
            file_put_contents('assets/img/system/favico.png', file_get_contents('assets/img/default_avata/favico.png'));
        }
        
        /*
         * Auto login admin
         */
        $idname = $this->UserModel->login($reset_username, $reset_password);
        
        /*
         * Show result
         */
        echo mystr()->get_from_template($this->load->design('block/reset/success.html'), [
            
        ]);
    }
    ?>
</div>
