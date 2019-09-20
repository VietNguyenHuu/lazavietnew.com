<?php
include_once("application/views/page_dynamic/post/include_post_header.php");
?>
<div class="width_max1300px">
    <div class='width3 width3_0_12 width3_980_9 post_content_nd_item'>
        <?php
        include_once('application/views/page_dynamic/post/include_post_adver_main.php');

        $id = $data['recent_post_content'];
        $post_line = $this->PostContentModel->get_row($id);
        if ($post_line == false) {
            $str = <<<EOD
<h1 class="page_title">Bài viết bạn vừa yêu cầu không tồn tại !</h1>
<p class="stt_tip">Có thể bài viết này không tồn tại trên hệ thống, hoặc đã di chuyển sang một địa chỉ khác.</p>
<p class="fontsize_a3">Bạn có thể </p>
<div class="width_50 padding"><div class="padding" style="background-color: #66ccff;"><a href="[link_home]"><p class="align_center"><i class="fa fa-home fa-3x"></i></p><p class="align_center fontsize_a2">Về trang chủ</p></a></div></div>
<div class="width_50 padding"><div class="padding" style="background-color: #f7b3b3;"><a href="[link_report]"><p class="align_center"><i class="fa fa-bug fa-3x"></i></p><p class="align_center fontsize_a2">Báo cáo lỗi</p></a></div></div>
<div class="clear_both"></div>
EOD;
            echo str_replace(Array('[link_home]', '[link_report]'), Array('' . site_url(), '' . site_url("contribute")), $str);
        } else if ($post_line->m_id_user_check == -1) {
            if ($post_line->m_id_user == $idname) {
                echo "<div class='stt_tip'>Bài viết này của bạn đang chờ kiểm duyệt</div>";
            } else {
                echo "<div class='stt_tip'>Bài viết đang chờ kiểm duyệt !</div>";
            }
        } else if ($post_line->m_status != 'public') {
            echo "<div class='stt_tip'>Bài viết chưa khả dụng để xem vào lúc này !</div>";
        } else {
            $sess_post_view = $this->session->userdata('post_recent_content');
            if (!is_array($sess_post_view)) {
                $sess_post_view = Array();
            }
            if (!in_array("'" . $id . "'", $sess_post_view)) {
                $this->PostContentModel->view($id);
                array_push($sess_post_view, "'" . $id . "'");
                $this->session->set_userdata('post_recent_content', $sess_post_view);
            }

            $str_c = "";
            $temp_avata = $this->PostContentModel->get_avata($id);
            $str_c .= "<div class='post_detailcontent_title'><h1>" . str_to_view($post_line->m_title) . "</h1>";
            if ($post_line->m_id_user == $idname) {
                $str_c .= "<a class='float_right margin_l fontsize_a4 margin_t' title='Chỉnh sửa' target='_blank' href='post/write_detail/" . $id . "'><i class='fontsize_a4 fa fa-pencil-square-o'></i></span></a>";
            }
            $str_c .= "<div class='clear_both'></div>";
            $str_c .= "</div>";
            //thông số
            $str_c .= "<div class='padding_h font_roboto fontsize_d2'>";
            $link_type = $this->PostTypeModel->get_link_type($data['recent_post_type']);
            $max = count($link_type);
            if ($max > 0) {
                $str_c .= "<i class='fa fa-folder-o'></i> ";
                for ($i = 0; $i < $max; $i++) {
                    if ($link_type[$i] != 1) {
                        $str_c .= "<a class=''  href='" . $this->PostTypeModel->get_link_from_id($link_type[$i]) . "'><span class='font_roboto' style='display:inline-block'>" . str_to_view($this->PostTypeModel->get($link_type[$i], 'm_title')) . "</span></a>";
                        if ($i < $max - 1) {
                            $str_c .= " / ";
                        }
                    }
                }
            }

            //xem,bình luận,thời gian
            $str_c .= "&nbsp;&nbsp;&nbsp;&nbsp;<span class='display_inline_block'>";
            $temp_num_comment = $this->db->query("SELECT id FROM " . $this->PostCommentModel->get_table_name() . " WHERE m_id_content=" . $post_line->id)->num_rows();
            $str_c .= "<i class='fa fa-eye' title='Lượt xem bài viết'></i> " . $post_line->m_view . " - <a title='Bình luận' href='" . current_url() . "#post_comment'><i class='fa fa-comments-o'></i> " . $temp_num_comment . "</a>";

            $str_c .= "&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-clock-o' title='Cập nhật lần cuối'></i> " . my_time_ago_str($post_line->m_militime);
            $str_c .= "</span>";
            $str_c .= "</div>";
            //end thông số
            if ($post_line != false) {
                if ($post_line->m_avata_hide == 0) {
                    $str_c .= "<div class='post_detailcontent_avatabox'><img class='lazyload' src='" . $temp_avata . "' data-original='" . $this->PostContentModel->get_avata_original($id) . "' alt='" . str_to_view($post_line->m_title) . "' title='" . str_to_view($post_line->m_title) . "'></div>";
                }
            }
            $str_c .= "<div class='width_max800px padding_h post_detailcontent_action' style='line-height:2.5em'>";
            $str_c .= "<div class='float_left' style='line-height:1.2em'>" . get_str_like_full($page_fb_url) . "</div>";
            //đánh giá
            $temp_c_star = $this->PostContentModel->get_rank($id);
            $str_rank = "";
            for ($i = 1; $i <= $temp_c_star; $i++) {
                $str_rank .= "<i class='fa fa-star stt_action stt_highlight' onclick='post.rank(" . $id . "," . $i . ",true)' title='Đánh giá " . $i . " sao'></i>";
            }
            for ($i = $temp_c_star + 1; $i <= 5; $i++) {
                $str_rank .= "<i class='fa fa-star-o stt_action' onclick='post.rank(" . $id . "," . $i . ",true)' title='Đánh giá " . $i . " sao'></i>";
            }

            $str_c .= "<span class='display_inline_block'>" . $str_rank . "</span>";
            //like
            $str_c .= "<span class='button' onclick='post.like(" . $id . ")' title='Thích bài này'><i class='fa fa-heart-o'></i> <span class=''><span id='post_content_like_count'>" . $post_line->m_like . "</span></span></span>";
            //follow
            $temp_follow = $this->PostFollowModel->get_follow_count('post', $id);
            $str_c .= "<span class='button' onclick='post.follow(" . $id . ")' title='Theo dõi bài này'><i class='fa fa-rss'></i> <span class=''><span id='post_content_follow_count'>" . $temp_follow . "</span></span></span>";
            //tải pdf
            $str_c .= "<a href='tai-bai-viet/" . $post_line->id . ".html' target='_blank'><span class='button' title='Tải bài này dưới dạng file pdf'><i class='fa fa-download'></i> Tải PDF</span></a>";

            $str_c .= "<div class='clear_both'></div>";
            $str_c .= "</div>";
            $str_c .= "<div class='width_max800px post_detailcontent_content'><div class='font_roboto'>" . $this->PostContentModel->get($id, "m_content") . "</div></div>";


            //list tags
            $list_tags = $this->db->query("SELECT * FROM " . $this->PostTagsModel->get_table_name() . " WHERE (m_id_post=" . $post_line->id . ") ORDER BY id ASC")->result();
            if (count($list_tags) > 0) {
                $str_c .= "<div class='width_max800px margin_v padding_v post_tags_box'><b class='stt_tip'><i class='fa fa-tags fa-rotate-270'></i> TAGS: </b>";
                foreach ($list_tags as $line) {
                    $str_c .= "<a href='" . $this->PostTagsModel->get_link_from_id($line->id) . "' class='bg_highlight padding margin font_roboto post_tags_item'><i class='fa fa-tag'></i> " . str_to_view($line->m_title) . "</a>";
                }
                $str_c .= "</div>";
            }
            //end list tags


            $str_c .= "<div class='width_max800px stt_tip post_detailcontent_date'>";
            $temp_post_user = $this->UserModel->get_row($post_line->m_id_user);
            if ($temp_post_user != false) {
                $str_c .= "<div class='padding_r align_left'>";
                $str_c .= "<a href='" . $this->PostAuthorModel->get_link_from_id($temp_post_user->id) . "' title='" . str_to_view($temp_post_user->m_realname) . "'><img class='lazyload radius_50 align_middle' src='assets/img/system/favico.gif' data-original='" . $this->UserModel->get_avata($temp_post_user->id) . "' style='height:2em;max-width:5em;border:1px solid #666' alt='" . str_to_view($temp_post_user->m_realname) . "'><span class='margin_h align_middle'>" . str_to_view($temp_post_user->m_realname) . "</span></a>";
                $temp_follow = $this->PostFollowModel->get_follow_count('author', $temp_post_user->id);
                $str_c .= "<span class='margin_r align_middle stt_action' onclick='post.follow_author(" . $temp_post_user->id . ")' title='Theo dõi " . str_to_view($temp_post_user->m_realname) . "'>Theo dõi <i class='fa fa-rss'></i><span class='margin_l' id='post_content_follow_author_count'>" . $temp_follow . "</span></span>";
                $str_c .= "</div>";
            }
            $str_c .= "</div>";

            $str_c .= "<div class='width_max800px margin_b padding_v'><div class='padding_v margin_v'><div class='fontsize_a2'><i class='fa fa-share'></i> Chia sẻ <b>" . str_to_view($post_line->m_title) . "</b> tới bạn bè để mọi người cùng đọc nhé !</div><div class='margin_t'>" . get_str_like_full($page_fb_url) . "</div></div></div>";

            //báo sai phạm

            $str_c .= "<div class='width_max800px padding_v margin_t' style='margin-bottom:2em;'><a href='" . site_url("bao-loi-bai-viet/" . $post_line->id . ".html") . "' title='Gởi báo cáo sai phạm bài viết'><span class='button padding red fontsize_d2'><i class='fa fa-send'></i> Gởi báo cáo sai phạm</span></a></div>";

            //end báo sai phạm

            $str_c .= "<div class='width_max800px'><div class='grid'><div class='grid_header'><a name='post_comment' class='grid_header_label' onclick='post.updatecomment(" . $id . ");$(this).parents(\".grid_header\").find(\".grid_header_label\").addClass(\"disable\");$(this).removeClass(\"disable\");'>Bình luận</a><div class='grid_header_label disable' onclick='post.updatecomment(" . $id . ",\"by_rank\");$(this).parents(\".grid_header\").find(\".grid_header_label\").addClass(\"disable\");$(this).removeClass(\"disable\");'>Top phản hồi</div><a class='grid_header_label disable' href='" . current_url() . "#post_comment_fb'>Bình luận bằng facebook</a><div class='clear_both'></div></div>";
            $temp_comment_summary_content = ""; //xem trước 10 bình luận
            $temp_comment_summary = $this->db->query("SELECT * FROM post_comment WHERE m_id_content=" . $data['recent_post_content'] . " ORDER BY id ASC LIMIT 0,10")->result();
            if ($temp_comment_summary != false && $temp_comment_summary != null && $temp_comment_summary != "") {
                foreach ($temp_comment_summary as $temp_comment_summary_line) {
                    $temp_comment_summary_line->rank = $this->PostCommentModel->get_rank($temp_comment_summary_line->id);
                    $temp_comment_summary_content .= "<div class='post_comment_item'>";
                    $temp_comment_summary_content .= "<img class='post_comment_item_avata' src='" . $this->UserModel->get_avata($temp_comment_summary_line->m_id_user) . "' alt='" . str_to_view($this->UserModel->get($temp_comment_summary_line->m_id_user, 'm_realname'), false) . "'>";
                    $temp_comment_summary_content .= "<div class='post_comment_item_status'><a href='" . $this->UserModel->get_link_from_id($temp_comment_summary_line->m_id_user) . "'>" . $this->UserModel->get($temp_comment_summary_line->m_id_user, 'm_realname') . "</a><span class='tip' style='font-size:14px;margin-left:20px;'> Đã gửi vào " . $temp_comment_summary_line->m_date . "</span>";
                    if ($temp_comment_summary_line->m_id_user == $idname || ($this->UserModel->get($idname, 'm_level') > 3 && $this->UserModel->get($idname, 'm_level') > $this->UserModel->get($temp_comment_summary_line->m_id_user, 'm_level'))) {
                        $temp_comment_summary_content .= "<i class='float_right stt_action stt_mistake fa fa-trash-o margin_l fontsize_d2' style='margin-top:0.125em' onclick='post.del_comment(" . $temp_comment_summary_line->id . ")'></i>";
                    }
                    $temp_c_star = $temp_comment_summary_line->rank;
                    $str_rank = "";
                    for ($j = 1; $j <= $temp_c_star; $j++) {
                        $str_rank .= "<i class='stt_action fa fa-star stt_highlight' onclick='post.rank_comment(" . $temp_comment_summary_line->id . "," . $j . "," . $data['recent_post_content'] . ")'></i>";
                    }
                    for ($j = $temp_c_star + 1; $j <= 5; $j++) {
                        $str_rank .= "<i class='stt_action fa fa-star-o stt_tip' onclick='post.rank_comment(" . $temp_comment_summary_line->id . "," . $j . "," . $data['recent_post_content'] . ")'></i>";
                    }
                    $temp_comment_summary_content .= "<span class='float_right fontsize_d2'>Đánh giá " . $str_rank . "</span>";
                    $temp_comment_summary_content .= "</div>";
                    $temp_comment_summary_content .= "<div class='post_comment_item_content'>" . nl2br($temp_comment_summary_line->m_content) . "</div>";
                    $temp_comment_summary_content .= "<div class='clear_both'></div>";
                    $temp_comment_summary_content .= "</div>";
                }
            } else {
                $temp_comment_summary_content = "";
            }
            $str_c .= "<div class='grid_content padding post_detailcontent_comment'><div class='c'><img src='assets/img/system/loading2.gif' class='align_middle margin_r' style='height:1em;' alt='Đang tải bình luận bài viết'>Phản hồi bài viết " . str_to_view($post_line->m_title) . "" . $temp_comment_summary_content . "</div>";
            if ($this->UserModel->check_exit($idname)) {
                $str_c .= "<textarea name='post_detailcontent_comment_form' placeholder='Bình luận'></textarea>";
                $str_c .= "<span name='post_detailcontent_comment_buttonsend' class='button' onclick='post.sendcomment(" . $id . ")'><i class='fa fa-send'></i><span class='margin_l'>Gửi đi</span></span>";
                $str_c .= "<img src='" . $this->UserModel->get_avata($idname) . "' class='align_middle radius_50' style='height:2em;max-width:5em;border:1px solid #666666;padding:1px;' alt='" . htmlspecialchars($this->UserModel->get($idname, 'm_realname'), 1, 'utf-8') . "'><span class='margin_l align_middle'>" . $this->UserModel->get($idname, 'm_realname') . "</span>";
                $str_c .= "<div class='clear_both'></div>";
            } else {
                $str_c .= "<div class='tip padding_v'><i class='fa fa-sign-in'></i> <a href='" . site_url('login/index/' . str_replace("=", "", base64_encode($page_fb_url))) . "' >Đăng nhập</a> để bình luận !</div>";
            }
            $str_c .= "</div></div></div>";
            $str_c .= "<div class='width_max800px'>" . myhtml_grid(
                            "<a class='grid_header_label' name='post_comment_fb'>Bình luận nhanh</a>", "<div class='grid_content padding'>" . get_str_fb_comment($page_fb_url) . "</div>"
                    ) . "</div>";
            echo $str_c;

            //copyright
            echo "<div class='width_max800px'><div class='padding_v margin_v'><i class='fa fa-copyright'></i> Bạn đang đọc bài viết <i>" . str_to_view($post_line->m_title) . "</i>, hãy để nguồn " . $page_domain_name . " khi phát hành lại nội dung này !</div></div>";
            //end copyright
        }
        ?>
    </div>
    <div class="hide" id="post_recent_content_id"><?php echo $data['recent_post_content']; ?></div>
        <?php
        echo "<div class='width3 width3_0_12 width3_980_3 padding_l post_content_navi'>";
        //bài viết cùng chuyên mục
        if ($post_line != false) {
            $str = "<div class='navi_item'>";
            $str .= "<div class='navi_item_header'><i class='fa fa-folder-o fa-2x align_middle'></i> <span class='align_middle'>Cùng chuyên mục</span>";
            $str .= "</div>";
            $str .= "<div class='navi_submenu'>";
            $list_related_post = $this->db->query("SELECT id,m_title FROM post_content WHERE m_id_type=" . $data['recent_post_type'] . " AND MATCH(m_title_search)AGAINST('" . mystr()->addmask(str_to_view(trichdan(bodau($post_line->m_title), 100), false)) . "') AND id != " . $post_line->id . " AND m_status='public' LIMIT 0,4")->result();
            if ($list_related_post != "" && $list_related_post != false && $list_related_post != null && count($list_related_post) > 0) {
                $str .= "<ul class='margin_v padding_v post_content_relative'>";
                foreach ($list_related_post as $item) {
                    $str .= "<li class='stt_tip padding_v margin_v post_content_relative_item'><a href='" . $this->PostContentModel->get_link_from_id($item->id) . "' title='" . str_to_view($item->m_title, false) . "'>";
                    $str .= "<span class='font_roboto'>" . str_to_view($item->m_title) . "</span>";
                    $str .= "</a></li>";
                }
                $str .= "</ul>";
            }
            $list_related_post = $this->PostContentModel->gettop('id,m_title', 4, $data['recent_post_type']);
            if ($list_related_post != "" && $list_related_post != false && $list_related_post != null && count($list_related_post) > 0) {
                $str .= "<ul class='margin_v padding_v post_content_samptype'>";
                foreach ($list_related_post as $item) {
                    $str .= "<li class='stt_tip padding_v margin_v post_content_samptype_item'><a href='" . $this->PostContentModel->get_link_from_id($item->id) . "' title='" . str_to_view($item->m_title, false) . "'>";
                    $str .= "<span class='font_roboto'>" . str_to_view($item->m_title) . "</span>";
                    $str .= "</a></li>";
                }
                $str .= "</ul>";
            }
            $str .= "</div>";
            $str .= "</div>";
            echo $str;
        }
        //end bài viết cùng chuyên mục
        //bài viết cùng tác giả
        if ($post_line != false) {
            $str = "<div class='navi_item'>";
            $str .= "<div class='navi_item_header'><i class='fa fa-user fa-2x align_middle'></i> <span class='align_middle'>Cùng tác giả</span>";
            $str .= "</div>";
            $str .= "<div class='navi_submenu'>";
            $list_related_post = $this->db->query("SELECT * FROM " . $this->PostContentModel->get_table_name() . " WHERE (m_status='public' AND m_id_user=" . $post_line->m_id_user . ") ORDER BY m_militime DESC LIMIT 0,4")->result();
            if ($list_related_post != "" && $list_related_post != false && $list_related_post != null && count($list_related_post) > 0) {
                $str .= "<ul class='margin_v padding_v post_content_samp_author'>";
                foreach ($list_related_post as $item) {
                    $str .= "<li class='stt_tip padding_v margin_v post_content_samp_author_item'><a href='" . $this->PostContentModel->get_link_from_id($item->id) . "' title='" . str_to_view($item->m_title, false) . "'>";
                    $str .= "<span class='font_roboto'>" . str_to_view($item->m_title) . "</span>";
                    $str .= "</a></li>";
                }
                $str .= "</ul>";
            }
            $str .= "</div>";
            $str .= "</div>";
            echo $str;
        }
        //end bài viết cùng tác giả
        //facebook
        $str = "<div class='navi_item'>";
        $str .= "<div class='navi_item_header'><i class='fa fa-facebook margin_r fa-2x align_middle'></i><span class='align_middle'>Theo dõi chúng tôi</span>";
        $str .= "</div>";
        $str .= "<div class='radius_none navi_submenu'>";
        $str .= get_str_fb_fanpage(Array('fanpage' => $page_fb_fanpage, 'fanpage_title' => $page_fb_fanpage_title));
        $str .= "</div>";
        $str .= "</div>";
        echo $str;
        //end facebook
        echo "</div>";
        ?>
</div>