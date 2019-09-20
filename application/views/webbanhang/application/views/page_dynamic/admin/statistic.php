<?php
if ($this->UserModel->get($idname, 'm_level') > 3) {
    ?>
    <div class='font_roboto' name='admin_content_header'>Thống kê website</div>
    <div class='admin_content_body' name='admin_content_body'>
        <?php
        //system noti
        $temp = $this->SystemParamModel->get('admin_post_content_lastresetview', 'm_value');
        if ($temp !== false) {
            if ($temp === false || ((int) $temp) < time() - 24 * 60 * 60) {//quá 24 giờ
                echo "<div class='stt_mistake font_roboto fontsize_d2 admin_statistic_flat_message'><i class='fa fa-bell-o'></i> Đã hơn 1 ngày chưa cập nhật lượt xem cho bài viết ! Bạn cần cập nhật lượt xem cho tất cả bài viết để có thể hiển thị đúng các bài viết mới nhất, hot nhất trong ngày, trong tuần.</div>";
            }
        }
        ?>
        <div class='admin_statistic_sumary_wrapper'>
            <?php
            //summary block
            $temp_template = <<<EOD
        <div class='width3 width3_0_12 width3_480_6 width3_980_3 padding admin_statistic_sumary'>
        <div class='admin_statistic_sumary_bg'>
            <div class='float_left admin_statistic_sumary_avatar'>
                {{avata}}
            </div>
            <div class='float_left admin_statistic_sumary_info'>
                <p class='font_roboto admin_statistic_sumary_title'>
                    {{title}}
                </p>
                <p class='font_roboto admin_statistic_sumary_number'>
                    {{number}}
                </p>
            </div>
            <div class='clear_both'></div>
        </div>
        </div>
EOD;

            echo mystr()->get_from_template(
                    $temp_template, array(
                "{{avata}}" => "<i class='fa fa-eye'></i>",
                "{{title}}" => "Lượt truy cập",
                "{{number}}" => valid_money($this->SystemModel->get_access())
                    )
            );

            $sl = $this->db->query("SELECT count(id) AS sl FROM " . $this->UserModel->get_table_name())->result()[0]->sl;
            echo mystr()->get_from_template(
                    $temp_template, array(
                "{{avata}}" => "<i class='fa fa-users'></i>",
                "{{title}}" => "Thành viên",
                "{{number}}" => valid_money($sl)
                    )
            );

            $sl = $this->db->query("SELECT count(id) AS sl FROM " . $this->ContributeModel->get_table_name())->result()[0]->sl;
            echo mystr()->get_from_template(
                    $temp_template, array(
                "{{avata}}" => "<i class='fa fa-bug'></i>",
                "{{title}}" => "Phản hồi người dùng",
                "{{number}}" => valid_money($sl)
                    )
            );

            $sl = $this->db->query("SELECT count(id) AS sl FROM " . $this->PublicMessageModel->get_table_name())->result()[0]->sl;
            echo mystr()->get_from_template(
                    $temp_template, array(
                "{{avata}}" => "<i class='fa fa-envelope'></i>",
                "{{title}}" => "Tin nhắn",
                "{{number}}" => valid_money($sl)
                    )
            );
            
            $sl = $this->db->query("SELECT count(id) AS sl FROM " . $this->PostContentModel->get_table_name())->result()[0]->sl;
            echo mystr()->get_from_template(
                    $temp_template, array(
                "{{avata}}" => "<i class='fa fa-book'></i>",
                "{{title}}" => "Bài viết",
                "{{number}}" => valid_money($sl)
                    )
            );

            $sl = $this->db->query("SELECT count(id) AS sl FROM " . $this->PostCommentModel->get_table_name())->result()[0]->sl;
            echo mystr()->get_from_template(
                    $temp_template, array(
                "{{avata}}" => "<i class='fa fa-comment-o'></i>",
                "{{title}}" => "Bình luận bài viết",
                "{{number}}" => valid_money($sl)
                    )
            );
            ?>
            <div class='clear_both'></div>
        </div>

        <div class='hide' id='admin_statistic_access_data'></div>
        <div class='grid admin_statistic_chartview_wrapper'>
            <div class='grid_header'>
                <span class='grid_header_label disable admin_statistic_type' data-type='all'>Lượt truy cập</span>
                <span class='grid_header_label admin_statistic_type' data-type='date'>Ngày</span>
                <span class='grid_header_label disable admin_statistic_type' data-type='month'>Tháng</span>
                <span class='grid_header_label disable admin_statistic_type' data-type='year'>Năm</span>
                <span class='grid_header_label disable admin_statistic_type' data-type='custom'>Tùy chỉnh</span>
                <div class='clear_both'></div>
            </div>
            <div class='grid_content padding'><div class='bg_highlight' id='admin_statistic_access' style='height:350px;'></div>
            </div>
        </div>
        <div class="admin_statistic_user_wrapper">
            <div class="width3 width3_0_12 width3_720_6 padding"> 
                <div class="admin_statistic_user_new">
                    <div class="font_roboto admin_statistic_user_header">
                        Thành viên mới
                    </div>
                    <div class="admin_statistic_user_content">
                        <?php
                        $list = $this->db->query("SELECT * FROM user ORDER by id DESC LIMIT 0,8")->result();
                        if ($list == null || $list == false || count($list) < 1) {
                            echo "<p class='stt_tip'>Không có thành viên đăng ký mới</p>";
                        } else {
                            $temp_template2 = <<<EOD
                                <div class='width3 width3_0_6 width3_720_3 padding align_center admin_statistic_user_item'>
                                    <div class='admin_statistic_user_item_avatar'>
                                        <img class='radius_50 lazyload' src='assets/img/system/lazyload.gif' data-original="{{avata}}"/>
                                    </div>
                                    <p class='font_roboto admin_statistic_user_item_name'>{{realname}}</p>
                                    <p class='font_roboto stt_tip fontsize_d3 admin_statistic_user_item_time'>{{time}}</p>
                                </div>    
EOD;
                            foreach ($list as $line){
                                echo mystr()->get_from_template(
                                    $temp_template2,
                                    array(
                                        "{{avata}}" => $this->UserModel->get_avata($line->id),
                                        "{{realname}}" => $line->m_realname,
                                        "{{time}}" => my_time_ago_str($line->m_lasttime)
                                    )
                                );
                            }
                            echo "<div class='clear_both'></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="width3 width3_0_12 width3_720_6 padding">
                <div class="admin_statistic_user_online">
                    <div class="font_roboto admin_statistic_user_header">
                        Online gần đây
                    </div>
                    <div class="admin_statistic_user_content">
                        <?php
                        $list = $this->db->query("SELECT * FROM user ORDER by m_lasttime DESC LIMIT 0,8")->result();
                        if ($list == null || $list == false || count($list) < 1) {
                            echo "<p class='stt_tip'>Không có thành viên đăng ký mới</p>";
                        } else {
                            $temp_template2 = <<<EOD
                                <div class='width3 width3_0_6 width3_720_3 padding align_center admin_statistic_user_item'>
                                    <div class='admin_statistic_user_item_avatar'>
                                        <img class='radius_50 lazyload' src='assets/img/system/lazyload.gif' data-original="{{avata}}"/>
                                    </div>
                                    <p class='font_roboto admin_statistic_user_item_name'>{{realname}}</p>
                                    <p class='font_roboto stt_tip fontsize_d3 admin_statistic_user_item_time'>{{time}}</p>
                                </div>    
EOD;
                            foreach ($list as $line){
                                echo mystr()->get_from_template(
                                    $temp_template2,
                                    array(
                                        "{{avata}}" => $this->UserModel->get_avata($line->id),
                                        "{{realname}}" => $line->m_realname,
                                        "{{time}}" => my_time_ago_str($line->m_lasttime)
                                    )
                                );
                            }
                            echo "<div class='clear_both'></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="clear_both"></div>
        </div>
        
        <div class="admin_statistic_post_wrapper">
            <div class="width3 width3_0_12 width3_720_4 padding"> 
                <div class="admin_statistic_post_new">
                    <div class="font_roboto admin_statistic_post_header">
                        Bài viết mới
                    </div>
                    <div class="admin_statistic_post_content">
                        <?php
                        $list = $this->db->query("SELECT * FROM post_content WHERE m_status != 'trash' ORDER by id DESC LIMIT 0,5")->result();
                        if ($list == null || $list == false || count($list) < 1) {
                            echo "<p class='stt_tip'>Không có bài viết mới</p>";
                        } else {
                            $temp_template2 = <<<EOD
                                <div class='padding_v admin_statistic_post_item'>
                                    <div class='float_left margin_r admin_statistic_post_item_avatar'>
                                        <img class='lazyload' src='assets/img/system/lazyload.gif' data-original="{{avata}}"/>
                                    </div>
                                    <p class='font_roboto admin_statistic_post_item_title'>{{realname}}</p>
                                    <p class='align_right font_roboto stt_tip fontsize_d3 admin_statistic_post_item_time'><i class='fa fa-clock-o'></i> {{time}}</p>
                                    <div class='clear_both'></div>
                                </div>    
EOD;
                            foreach ($list as $line){
                                echo mystr()->get_from_template(
                                    $temp_template2,
                                    array(
                                        "{{avata}}" => $this->PostContentModel->get_avata($line->id, "verysmall"),
                                        "{{realname}}" => $line->m_title,
                                        "{{time}}" => my_time_ago_str($line->m_militime)
                                    )
                                );
                            }
                            echo "<div class='clear_both'></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="width3 width3_0_12 width3_720_4 padding"> 
                <div class="admin_statistic_post_new_comment">
                    <div class="font_roboto admin_statistic_post_header">
                        Bình luận bài viết mới
                    </div>
                    <div class="admin_statistic_post_content">
                        <?php
                        $list = $this->db->query("SELECT * FROM post_comment ORDER by id DESC LIMIT 0,5")->result();
                        if ($list == null || $list == false || count($list) < 1) {
                            echo "<p class='stt_tip'>Không có bình luận bài viết mới</p>";
                        } else {
                            $temp_template2 = <<<EOD
                                <div class='padding_v admin_statistic_post_item'>
                                    <div class='float_left margin_r admin_statistic_post_comment_item_avatar'>
                                        <img class='lazyload' src='assets/img/system/lazyload.gif' data-original="{{avata}}"/>
                                    </div>
                                    <p class='font_roboto admin_statistic_post_item_comment_posttitle'>{{posttitle}}</p>
                                    <p class='font_roboto fontsize_d2 admin_statistic_post_item_comment_nd'><i class='fa fa-comment-o'></i> {{nd}}</p>
                                    <p class='align_right font_roboto stt_tip fontsize_d3 admin_statistic_post_comment_item_time'>
                                        <span class='stt_highlight display_inline_block'>
                                            <i class='fa fa-user'></i> {{userrealname}}
                                        </span>
                                        <span class='display_inline_block'>
                                            &nbsp;&nbsp;<i class='fa fa-clock-o'></i> {{time}}
                                        </span>
                                    </p>
                                    <div class='clear_both'></div>
                                </div>    
EOD;
                            foreach ($list as $line){
                                echo mystr()->get_from_template(
                                    $temp_template2,
                                    array(
                                        "{{avata}}" => $this->PostContentModel->get_avata($line->m_id_content, "verysmall"),
                                        "{{posttitle}}" => $this->PostContentModel->get($line->m_id_content, "m_title"),
                                        "{{time}}" => $line->m_date,
                                        "{{userrealname}}" => $this->UserModel->get($line->m_id_user, "m_realname"),
                                        "{{nd}}" => trichdan($line->m_content, 100)
                                    )
                                );
                            }
                            echo "<div class='clear_both'></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="width3 width3_0_12 width3_720_4 padding"> 
                <div class="admin_statistic_post_new">
                    <div class="font_roboto admin_statistic_post_header">
                        Xem nhiều trong tuần
                    </div>
                    <div class="admin_statistic_post_content">
                        <?php
                        $list = $this->db->query("SELECT * FROM post_content INNER JOIN post_view ON post_view.id_post = post_content.id WHERE m_status != 'trash' ORDER by m_week DESC LIMIT 0,5")->result();
                        if ($list == null || $list == false || count($list) < 1) {
                            echo "<p class='stt_tip'>Không có bài viết mới</p>";
                        } else {
                            $temp_template2 = <<<EOD
                                <div class='padding_v admin_statistic_post_item'>
                                    <div class='float_left margin_r admin_statistic_post_item_avatar'>
                                        <img class='lazyload' src='assets/img/system/lazyload.gif' data-original="{{avata}}"/>
                                    </div>
                                    <p class='font_roboto admin_statistic_post_item_title'>{{realname}}</p>
                                    <p class='align_right font_roboto stt_tip fontsize_d3 admin_statistic_post_item_time'>
                                        <span class='display_inline_block'>
                                            <i class='fa fa-eye'></i> {{view}}
                                        </span>
                                        <span class='display_inline_block'>
                                            &nbsp;&nbsp;<i class='fa fa-clock-o'></i> {{time}}
                                        </span>
                                    </p>
                                    <div class='clear_both'></div>
                                </div>    
EOD;
                            foreach ($list as $line){
                                echo mystr()->get_from_template(
                                    $temp_template2,
                                    array(
                                        "{{avata}}" => $this->PostContentModel->get_avata($line->id, "verysmall"),
                                        "{{realname}}" => $line->m_title,
                                        "{{view}}" => $line->m_week,
                                        "{{time}}" => my_time_ago_str($line->m_militime)
                                    )
                                );
                            }
                            echo "<div class='clear_both'></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="clear_both"></div>
        </div>
    </div>
    <?php
}
?>