<?php
include_once("application/views/page_dynamic/post/include_post_header.php");
?>
<div class="width_max1300px">
    <?php
    echo "<div class='width3 width3_0_12 width3_980_9 post_type_contain'>";
    include_once('application/views/page_dynamic/post/include_post_adver_main.php');
    if ($this->PostTypeModel->check_exit($data['recent_post_type']) != true) {
        echo "<div class='align_center padding stt_tip fontsize_a2'>Danh mục bài viết không khả dụng</div>";
    } else if ($this->PostTypeModel->check_publish($data['recent_post_type']) != true) {
        echo "<div class='align_center padding stt_tip fontsize_a2'>Danh mục bài viết hiện đang khóa</div>";
    } else {
        //các bài viết trực thuộc chủ đề
        echo "<h1 class='page_title fontsize_d2 radius_none'>" . $this->PostTypeModel->get($data['recent_post_type'], 'm_title') . "</h1>";
        $str = "";
        $max = $this->db->query("SELECT id FROM " . $this->PostContentModel->get_table_name() . " WHERE m_status='public' AND m_id_type = " . $data['recent_post_type'])->num_rows();
        if ($max > 0) {
            //thông số phân trang
            $item_per_page = 16;
            $phantrang = page_seperator($max, $data['recent_post_page'], $item_per_page, Array('class_name' => 'page_seperator_item', 'strlink' => $this->PostTypeModel->get_link_from_id($data['recent_post_type'], "[[pagenumber]]")));
            //end thông số phân trang
            $ar_content = $this->db->query("SELECT * FROM " . $this->PostContentModel->get_table_name() . " WHERE m_status='public' AND m_id_type = " . $data['recent_post_type'] . " ORDER BY m_militime DESC LIMIT " . $phantrang['start'] . "," . $phantrang['limit'])->result();
            $max = count($ar_content);
            if ($max > 0) {

                for ($i = 0; $i < $max; $i++) {
                    $str .= "<div class='width_40 padding'>";
                    $str .= $this->PostContentModel->get_str_item($ar_content[$i]);
                    $str .= "</div>";
                }
                $str .= "<div class='clear_both'></div>";
            }
            //phan trang
            $str .= "<div class='page_seperator_box'>";
            $str .= $phantrang['str_link'];
            $str .= "</div>";
            //end phân trang
        }
        echo $str;
        //end các bài viết trực thuộc chủ đề
        //các chủ đề trực thuộc
        $str = "";
        $ar_list = $this->PostTypeModel->get($data['recent_post_type'], 'm_ar_direct_type'); //ar_list là danh sách các danh mục con trong danh mục hiện tại

        if ($ar_list != false && $ar_list != '' && $ar_list != null) {
            $ar_list = $this->db->query("SELECT id,m_title,m_ar_direct_type FROM " . $this->PostTypeModel->get_table_name() . " WHERE (id IN(" . $ar_list . ") AND m_new_post_time != 0) ORDER BY m_new_post_time DESC")->result();
            if (count($ar_list) > 0) {
                foreach ($ar_list as $r) {
                    $temp_type_title = str_to_view($r->m_title);
                    $temp_header = "<h2 class='grid_header_label' data-id='" . $r->id . "'><a href='" . $this->PostTypeModel->get_link_from_row(Array('id' => $r->id, 'title' => $temp_type_title, 'page' => 1)) . "' title='" . $temp_type_title . "'>" . $temp_type_title . "</a></h2>";
                    $temp_content = "";

                    //in danh sách các chủ đề trực thuộc
                    if ($r->m_ar_direct_type != '' && $r->m_ar_direct_type != null && $r->m_ar_direct_type != false) {
                        $r->m_ar_direct_type = explode(",", $r->m_ar_direct_type);
                        foreach ($r->m_ar_direct_type as $key_r2 => $r2) {
                            if ($key_r2 < 6) {
                                $temp_type_title = str_to_view($this->PostTypeModel->get($r2, 'm_title'));
                                $temp_header .= "<a href='" . $this->PostTypeModel->get_link_from_row(Array('id' => $r2, 'title' => $temp_type_title, 'page' => 1)) . "' title='" . $temp_type_title . "' class='grid_header_label disable'><span class='fontsize_d3'>" . $temp_type_title . "</span></a>";
                            }
                        }
                    }
                    //end in danh sách các chủ đề trực thuộc
                    //in danh sách các bài viết trong mỗi chủ đề trực thuộc đã được sắp theo bài viết mới nhất
                    $list_type = Array(); //mảng các chủ đề thuộc phạm vi chủ đề hiện tại
                    $this->PostTypeModel->get_list_type($list_type, $r->id);
                    if (count($list_type) > 0) {
                        //tải 1 bài viết mới nhất
                        $ar_content = $this->db->query("SELECT * FROM " . $this->PostContentModel->get_table_name() . " WHERE m_status='public' AND m_id_type IN(" . implode(',', $list_type) . ") ORDER BY m_militime DESC LIMIT 0,1")->result();
                        if (count($ar_content) > 0 && $ar_content != null && $ar_content != false) {
                            $temp_content .= "<div class='width_40 padding post_content_item_box' data-id='" . $ar_content[0]->id . "'>";
                            $temp_content .= $this->PostContentModel->get_str_item($ar_content[0]);
                            $temp_content .= "</div>";

                            //tải thêm 3 bài viết cùng chủ đề với bài viết này
                            $addedid = Array();
                            array_push($addedid, $ar_content[0]->id);
                            $ar_content = $this->db->query("SELECT * FROM " . $this->PostContentModel->get_table_name() . " WHERE id!=" . $ar_content[0]->id . " AND m_status='public' AND m_id_type=" . $ar_content[0]->m_id_type . " ORDER BY m_militime DESC LIMIT 0,3")->result();
                            $max = count($ar_content);
                            $needadd = 3;
                            if ($max > 0 && $ar_content != null && $ar_content != false) {
                                $max_temp = min(3, $max);
                                for ($i = 0; $i < $max_temp; $i++) {
                                    $needadd--;
                                    array_push($addedid, $ar_content[$i]->id);
                                    $temp_content .= "<div class='width_40 padding post_content_item_box' data-id='" . $ar_content[$i]->id . "'>";
                                    $temp_content .= $this->PostContentModel->get_str_item($ar_content[$i]);
                                    $temp_content .= "</div>";
                                }
                            }
                            //lấp đầy 4 bài viết bằng các bài viết khác
                            if ($needadd > 0) {
                                $ar_content = $this->db->query("SELECT * FROM " . $this->PostContentModel->get_table_name() . " WHERE id NOT IN(" . implode(',', $addedid) . ") AND m_status='public' AND m_id_type IN(" . implode(',', $list_type) . ") ORDER BY m_militime DESC LIMIT 0," . $needadd)->result();
                                $max = count($ar_content);
                                $needadd = 3;
                                if ($max > 0 && $ar_content != null && $ar_content != false) {
                                    $max_temp = min($needadd, $max);
                                    for ($i = 0; $i < $max_temp; $i++) {
                                        $temp_content .= "<div class='width_40 padding post_content_item_box' data-id='" . $ar_content[$i]->id . "'>";
                                        $temp_content .= $this->PostContentModel->get_str_item($ar_content[$i]);
                                        $temp_content .= "</div>";
                                    }
                                }
                            }

                            //end tải thêm 3 bài viết cùng chủ đề với bài viết này

                            $temp_content .= "<div class='clear_both'></div>";
                            $temp_content .= "<span class='hide post_loadmore_button left' title='Tải thêm bài viết'><i class='fa fa-chevron-left'></i></span><span class='hide post_loadmore_button right' title='Tải thêm bài viết'><i class='fa fa-chevron-right'></i></span>";
                        }
                    }
                    //end in danh sách các bài viết....
                    $str .= myhtml_grid(
                            $temp_header, "<div class='grid_content post_group padding'>" . $temp_content . "</div>"
                    );
                }
            }
        }
        echo $str;
        //end các chủ đề trực thuộc
        //tùy chọn trong chủ đề
        if ($this->PostTypeModel->check_exit($data['recent_post_type']) == true) {
            $temp_content = "<br>";
            $temp_follow = $this->PostFollowModel->get_follow_count('type', $data['recent_post_type']);
            $temp_content .= "<div class='margin_b'> <span class='stt_tip'>Tip: nhấn theo dõi để tự động cập nhật tin mới nhất từ chuyên mục.</span></div>";
            $temp_content .= "<span class='stt_action stt_avaiable' onclick='post.follow_type(" . $data['recent_post_type'] . ")' title='Theo dõi mục " . str_to_view($this->PostTypeModel->get($data['recent_post_type'], 'm_title')) . "'><i class='fa fa-hand-o-right'></i> Theo dõi <i class='fa fa-rss'></i><span id='post_content_follow_type_count'>" . $temp_follow . "</span></span>";
            $temp_content .= "<div class='' title='Chia sẻ mục " . str_to_view($this->PostTypeModel->get($data['recent_post_type'], 'm_title')) . "'><div class='margin_t stt_tip'><i class='fa fa-share'></i> Hãy chia sẻ chuyên mục " . str_to_view($this->PostTypeModel->get($data['recent_post_type'], 'm_title')) . " tới bạn bè của mình để mọi người cùng đọc nhé !</div>" . get_str_like_full($page_fb_url) . "</div>";
            $temp_content .= "<div class='clear_both'></div>";
            echo myhtml_grid(
                    "<h2 class='grid_header_label'>Tùy chọn trong " . $this->PostTypeModel->get($data['recent_post_type'], 'm_title') . "</h2>", "<div class='grid_content padding'>" . $temp_content . "</div>"
            );
        }

        //end tùy chọn trong chủ đề
    }
    echo "</div>";
    echo "<div class='width3 width3_0_12 width3_980_3 padding_l post_type_navi'>";
    //theo dõi
    $post_follow = [
        'post' => "<span class='stt_tip fontsize_d2 font_helvetica'>Hiện tại bạn chưa chọn theo dõi bài viết nào</span>",
        'author' => "<span class='stt_tip fontsize_d2 font_helvetica'>Hiện tại bạn chưa chọn theo dõi tác giả nào</span>",
        'type' => "<span class='stt_tip fontsize_d2 font_helvetica'>Hiện tại bạn chưa chọn theo dõi chủ đề nào</span>"
    ];
    if ($idname != false) {
        $post_follow_temp = $this->db->query("SELECT id FROM " . $this->PostFollowModel->get_table_name() . " WHERE (m_id_user=" . $idname . " AND m_type='post') ORDER BY id DESC LIMIT 0,3")->result();
        if (count($post_follow_temp) > 0) {
            $post_follow['post'] = "<div class='list'>";
            foreach ($post_follow_temp as $post_follow_temp_line) {
                $temp_post_row = $this->PostContentModel->get_row($this->PostFollowModel->get($post_follow_temp_line->id, 'm_id_value'));
                $post_follow['post'] .= "<div class='margin_b item post_follow_item' data-id='" . $post_follow_temp_line->id . "'>";
                $post_follow['post'] .= "<a href='" . $this->PostContentModel->get_link_from_id($temp_post_row->id) . "' title='" . str_to_view($temp_post_row->m_title) . "'>";
                $post_follow['post'] .= "<div class='align_middle radius_50' style='height:1.5em;width:1.5em;display:inline-block;overflow:hidden'>";
                $post_follow['post'] .= "<img class='align_middle' style='height:1.5em;max-width:5em;' src='assets/img/system/favico.gif' data-original='" . $this->PostContentModel->get_avata_small($temp_post_row->id) . "' alt='" . str_to_view($temp_post_row->m_title) . "'>";
                $post_follow['post'] .= "</div>";
                $post_follow['post'] .= "<span class='align_middle margin_l'>" . str_to_view($temp_post_row->m_title) . "</span>";
                $post_follow['post'] .= "</a>";
                $post_follow['post'] .= "</div>";
            }
            $post_follow['post'] .= "</div>";
        }

        $post_follow_temp = $this->db->query("SELECT id FROM " . $this->PostFollowModel->get_table_name() . " WHERE (m_id_user=" . $idname . " AND m_type='author') ORDER BY id DESC LIMIT 0,3")->result();
        if (count($post_follow_temp) > 0) {
            $post_follow['author'] = "<div class='list'>";

            foreach ($post_follow_temp as $post_follow_temp_line) {
                $temp_user_row = $this->UserModel->get_row($this->PostFollowModel->get($post_follow_temp_line->id, 'm_id_value'));
                $post_follow['author'] .= "<div class='margin_b item post_follow_item'><a href='" . $this->PostAuthorModel->get_link_from_id($temp_user_row->id) . "' title='" . str_to_view($temp_user_row->m_realname) . "'><div class='align_middle radius_50' style='height:1.5em;width:1.5em;display:inline-block;overflow:hidden'><img class='align_middle' style='height:1.5em;max-width:5em;' src='assets/img/system/favico.gif' data-original='" . $this->UserModel->get_avata($temp_user_row->id) . "' alt='" . str_to_view($temp_user_row->m_realname) . "'></div><span class='align_middle margin_l'>" . str_to_view($temp_user_row->m_realname) . "</span></a></div>";
            }
            $post_follow['author'] .= "</div>";
        }

        $post_follow_temp = $this->db->query("SELECT id FROM " . $this->PostFollowModel->get_table_name() . " WHERE (m_id_user=" . $idname . " AND m_type='type') ORDER BY id DESC LIMIT 0,3")->result();
        if (count($post_follow_temp) > 0) {
            $post_follow['type'] = "<div class='list'>";
            foreach ($post_follow_temp as $post_follow_temp_line) {
                $temp_type_row = $this->PostTypeModel->get_row($this->PostFollowModel->get($post_follow_temp_line->id, 'm_id_value'));
                $post_follow['type'] .= "<div class='margin_b item post_follow_item'><a href='" . $this->PostTypeModel->get_link_from_id($temp_type_row->id) . "' title='" . str_to_view($temp_type_row->m_title) . "'><div class='align_middle radius_50' style='height:1.5em;width:1.5em;display:inline-block;overflow:hidden'><img class='align_middle' style='height:1.5em;max-width:5em;' src='assets/img/system/favico.gif' data-original='" . $this->PostTypeModel->get_avata($temp_type_row->id) . "' alt='" . str_to_view($temp_type_row->m_title) . "'></div><span class='align_middle margin_l'>" . str_to_view($temp_type_row->m_title) . "</span></a></div>";
            }
            $post_follow['type'] .= "</div>";
        }
    }
    echo mystr()->get_from_template(
            $this->load->design('block/post/navi_follow.php'), [
        '{{post}}' => $post_follow['post'],
        '{{author}}' => $post_follow['author'],
        '{{type}}' => $post_follow['type']
            ]
    );

    /*
     *  Post type detail
     */
    if ($data['recent_post_type_row'] !== false) {
        $direct_type = [
            '{{title}}' => $data['recent_post_type_row']->m_title,
            '{{description}}' => $data['recent_post_type_row']->m_seo_description,
            '{{list_child}}' => ''
        ];
        if (isset($ar_list)) {
            if (is_array($ar_list) && !empty($ar_list)) {
                $t = $this->load->design('block/post/navi_direct_type_item.php');
                foreach ($ar_list as $line) {
                    $direct_type['{{list_child}}'] .= mystr()->get_from_template(
                            $t, [
                        "{{link}}" => $this->PostTypeModel->get_link_from_row(['id' => $line->id, 'title' => $line->m_title, 'page' => 1]),
                        "{{title}}" => $line->m_title,
                        "{{titlese}}" => str_to_view($line->m_title, false),
                        "{{avata}}" => $this->PostTypeModel->get_avata($line->id)
                            ]
                    );
                }
            }
        }
        echo mystr()->get_from_template(
                $this->load->design('block/post/navi_direct_type.php'), $direct_type
        );
    }

    //top tags
    $cache = $this->CacheModel->get_row("template_posttype_toptags");
    if ($cache != false) {
        echo $cache->m_content;
    } else {
        $tags = "";
        $toptags = $this->db->query("SELECT *,COUNT(m_title) AS sd FROM post_tags GROUP BY m_title ORDER BY sd DESC LIMIT 0,12")->result();
        if (count($toptags) > 0) {
            $tempplate_toptag_item = $this->load->design('block/post/type/navi_toptag_item.html');
            foreach ($toptags as $line) {
                $tags .= mystr()->get_from_template(
                    $tempplate_toptag_item, 
                    [
                        '{{href}}' => $this->PostTagsModel->get_link_from_id($line->id),
                        '{{title}}' => str_to_view($line->m_title)
                    ]
                );
            }
        }
        $str = mystr()->get_from_template(
            $this->load->design('block/post/type/navi_toptag.html'), 
            [
                '{{tags}}' => $tags
            ]
        );
        echo $str;
        $this->CacheModel->add(Array(
            'name' => 'template_posttype_toptags',
            'content' => $str
        ));
    }
    //end top tags
    //top tác giả tuần
    $cache = $this->CacheModel->get_row("template_home_topauthor");
    if ($cache != false) {
        echo $cache->m_content;
        $cache = "";
    } else {
        $str = "<div class='navi_item'>";
        $str .= "<div class='navi_item_header'><span class='align_middle'>Top tác giả tuần</span>";
        $str .= "</div>";
        $str .= "<div class='navi_submenu'>";
        $top_author = $this->db->query("SELECT m_id_user,SUM(m_week) AS view_in_week FROM post_content,post_view WHERE id_post=id AND m_id_user_check!=-1 GROUP BY m_id_user ORDER BY view_in_week DESC LIMIT 0,5")->result();
        if (count($top_author) > 0) {
            foreach ($top_author as $key => $top_author_line) {
                $top_author_line->realname = $this->UserModel->get($top_author_line->m_id_user, 'm_realname');
                $str .= "<div class='navi_submenu_topauthor_item'>";
                $str .= "<div class='width3 width3_0_9 padding_r'><a href='" . $this->PostAuthorModel->get_link_from_id($top_author_line->m_id_user) . "'><img src='assets/img/system/lazyload.gif' class='lazyload navi_submenu_topauthor_item_avata' data-original='" . $this->UserModel->get_avata($top_author_line->m_id_user) . "' title='" . str_to_view($top_author_line->realname, false) . "' alt='" . str_to_view($top_author_line->realname, false) . "'><span class='align_middle'>" . $top_author_line->realname . "</span></a></div>";
                $str .= "<div class='width3 width3_0_3 align_right padding_r'>" . valid_money($top_author_line->view_in_week) . "</div>";
                $str .= "<div class='clear_both'></div>";
                $str .= "</div>";
            }
        }
        $str .= "</div>";
        $str .= "</div>";
        echo $str;
        $this->CacheModel->add(Array(
            'name' => 'template_home_topauthor',
            'content' => $str
        ));
    }

    /*
     * Facebook
     */
    echo mystr()->get_from_template(
            $this->load->design('block/post/navi_facebook.php'), [
        '{{fb_str}}' => get_str_fb_fanpage(
                [
                    'fanpage' => $page_fb_fanpage,
                    'fanpage_title' => $page_fb_fanpage_title
                ]
        )
            ]
    );

    echo "</div>";
    ?>
</div>