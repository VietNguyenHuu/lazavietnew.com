<?php
include_once("application/views/page_dynamic/post/include_post_header.php");

/*
 * Main Advertiment
 */
$advermain = "";
$adver_row = $this->AdvertimentModel->get_rand('main');
if ($adver_row != false) {
    $adver_row = $adver_row[0];

    $advermain = mystr()->get_from_template(
        $this->load->design('block/post/adver_main.php'), 
        [
            '{{link}}' => $adver_row->m_link,
            '{{titlese}}' => str_to_view($adver_row->m_title, false),
            '{{avata}}' => $this->AdvertimentModel->get_avata_original($adver_row->id)
        ]
    );
}

$post_line = $data['post_line'];

if ($post_line == false){
    echo mystr()->get_from_template(
        $this->load->design('block/post/content/error_notfound.html'), 
        [
            '{{link_home}}' => site_url(),
            '{{link_report}}' => site_url("contribute")
        ]
    );
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
    if (!in_array("'" . $post_line->id . "'", $sess_post_view)) {
        $this->PostContentModel->view($post_line->id);
        array_push($sess_post_view, "'" . $post_line->id . "'");
        $this->session->set_userdata('post_recent_content', $sess_post_view);
    }

    /*
     * Breakcum to linked this post
     */
    $breakcump = "";
    $link_type = $this->PostTypeModel->get_link_type($data['recent_post_type']);
    $max = count($link_type);
    if ($max > 0) {
        $breakcump_item = $this->load->design('block/post/content/breakcump_item.html');
        for ($i = 0; $i < $max; $i++) {
            if ($link_type[$i] != 1) {
                $breakcump .= mystr()->get_from_template(
                    $breakcump_item, 
                    [
                        '{{href}}' => $this->PostTypeModel->get_link_from_id($link_type[$i]),
                        '{{title}}' => str_to_view($this->PostTypeModel->get($link_type[$i], 'm_title'))
                    ]
                );
                if ($i < $max - 1) {
                    $breakcump .= " / ";
                }
            }
        }
    }
    /*
     * Tags of this post
     */
    $tags = "";
    $list_tags = $this->db->query(""
            . "SELECT * FROM " . $this->PostTagsModel->get_table_name() 
            . " WHERE (m_id_post=" . $post_line->id . ") "
            . " ORDER BY id ASC"
            )->result();
    if (!empty($list_tags)) {
        $tag_temp = $this->load->design('block/post/content/tag_item.html');
        foreach ($list_tags as $line) {
            $tags .= mystr()->get_from_template(
                $tag_temp, 
                [
                    '{{href}}' => $this->PostTagsModel->get_link_from_id($line->id),
                    '{{title}}' => str_to_view($line->m_title)
                ]
            );
        }
    }
    /*
     * Comment of this post
     */
    $temp_num_comment = $this->db->query(""
            . "SELECT id FROM " . $this->PostCommentModel->get_table_name()
            . " WHERE m_id_content=" . $post_line->id
        )->num_rows();
    $comment_str = "";
    if ($temp_num_comment > 0){
        $comment_list = $this->db->query(""
            . "SELECT * FROM post_comment"
            . " WHERE m_id_content=" . $data['recent_post_content'] 
            . " ORDER BY id ASC LIMIT 0,10"
        )->result();
        if (!empty($comment_list)){
            $comment_item_temp = $this->load->design('block/post/content/comment_item.html');
            $comment_item_delbtntemp = $this->load->design('block/post/content/comment_item_delbtn.html');
            $comment_item_rank_temp = $this->load->design('block/post/content/comment_item_rank.html');
            foreach ($comment_list as $item) {
                $btndel = "";
                $ranks = "";

                if ($item->m_id_user == $idname || ($this->UserModel->get($idname, 'm_level') > 3 && $this->UserModel->get($idname, 'm_level') > $this->UserModel->get($item->m_id_user, 'm_level'))) {
                    $btndel .= mystr()->get_from_template(
                        $comment_item_delbtntemp, 
                        [
                            '{{comment_id}}' => $item->id
                        ]
                    );
                }
                $item->rank = $this->PostCommentModel->get_rank($item->id);
                for ($j = 1; $j <= $item->rank; $j++) {
                    $ranks .= mystr()->get_from_template(
                        $comment_item_rank_temp, 
                        [
                            '{{class}}' => 'fa-star stt_highlight',
                            '{{comment_id}}' => $item->id,
                            '{{stt}}' => $j,
                            '{{post_id}}' => $post_line->id
                        ]
                    );
                }
                for ($j = $item->rank + 1; $j <= 5; $j++) {
                    $ranks .= mystr()->get_from_template(
                        $comment_item_rank_temp, 
                        [
                            '{{class}}' => 'fa-star-o stt_tip',
                            '{{comment_id}}' => $item->id,
                            '{{stt}}' => $j,
                            '{{post_id}}' => $post_line->id
                        ]
                    );
                }
                $comment_str .= mystr()->get_from_template(
                    $comment_item_temp, 
                    [
                        '{{user_avata}}' => $this->UserModel->get_avata($item->m_id_user),
                        '{{user_realname}}' => str_to_view($this->UserModel->get($item->m_id_user, 'm_realname'), false),
                        '{{user_link}}' => $this->UserModel->get_link_from_id($item->m_id_user),
                        '{{comment_send}}' => $item->m_date,
                        '{{comment_delbtn}}' => $btndel,
                        '{{comment_ranks}}' => $ranks,
                        '{{comment_content}}' => nl2br($item->m_content)
                    ]
                );
            }
        }
    }

    /*
     * Quich edit button
     */
    $quickedit = "";
    if ($post_line->m_id_user == $idname) {
        $quickedit .= mystr()->get_from_template(
            $this->load->design('block/post/content/quickedit.html'), 
            [
                '{{id}}' => $post_line->id
            ]
        );
    }

    /*
     * Rank of this post
     */
    $rank_str = "";
    $rank_temp = $this->load->design('block/post/content/rank_item.html');
    $temp_c_star = $this->PostContentModel->get_rank($post_line->id);
    for ($i = 1; $i <= $temp_c_star; $i++) {
        $rank_str .= mystr()->get_from_template(
            $rank_temp, 
            [
                '{{icon}}' => 'fa-star',
                '{{highlight}}' => 'stt_highlight',
                '{{id}}' => $post_line->id,
                '{{stt}}' => $i
            ]
        );
    }
    for ($i = $temp_c_star + 1; $i <= 5; $i++) {
        $rank_str .= mystr()->get_from_template(
            $rank_temp, 
            [
                '{{icon}}' => 'fa-star-o',
                '{{highlight}}' => '',
                '{{id}}' => $post_line->id,
                '{{stt}}' => $i
            ]
        );
    }

    $author_line = $this->UserModel->get_row($post_line->m_id_user);
    /*
     * Relative post, contain samptype and sampauthor
     */
    $navi_samptypes_temp = $this->load->design('block/post/content/navi_samptype_item.html');
    $navi_sampauthor = "";
    if ($author_line != false){
        $list_related_post = $this->db->query(""
            . "SELECT id,m_title FROM post_content"
            . " WHERE m_id_user=" . $author_line->id
            . " AND id != " . $post_line->id
            . " AND m_status='public'"
            . " ORDER BY m_militime DESC"
            . " LIMIT 0,4"
        )->result();
        if (!empty($list_related_post)){
            foreach ($list_related_post as $item){
                $navi_sampauthor .= mystr()->get_from_template(
                    $navi_samptypes_temp, 
                    [
                        '{{link}}' => $this->PostContentModel->get_link_from_id($item->id),
                        '{{title}}' => str_to_view($item->m_title),
                        '{{titlese}}' => str_to_view($item->m_title, false),
                        '{{avata}}' => $this->PostContentModel->get_avata($item->id, 'verysmall')
                    ]
                );
            }
        }
    }
    $navi_samptypes = "";
    $navi_samptypes_ar = [];
    $navi_samptypes_arid = [];
    array_push($navi_samptypes_arid, $post_line->id);
    /*
     * 3 bài viết liên quan trong chuyên mục
     */
    $list_related_post = $this->db->query(""
            . "SELECT id,m_title FROM post_content"
            . " WHERE m_id_type=" . $data['recent_post_type']
            . " AND MATCH(m_title_search)AGAINST('" . mystr()->addmask(str_to_view(trichdan(bodau($post_line->m_title), 100), false)) . "')"
            . " AND id != " . $post_line->id
            . " AND m_status='public'"
            . " LIMIT 0,3"
        )->result();
    if (!empty($list_related_post)) {
        foreach ($list_related_post as $item) {
            array_push($navi_samptypes_ar, $item);
            array_push($navi_samptypes_arid, $item->id);
        }
    }
    /*
     * 2 bài viết mới nhất cùng chuyên mục
     */
    $list_related_post = $this->db->query(""
            . "SELECT id,m_title FROM post_content"
            . " WHERE m_id_type=" . $data['recent_post_type']
            . " AND id NOT IN(" . implode(",", $navi_samptypes_arid) . ") "
            . " AND m_status='public'"
            . " ORDER BY id DESC"
            . " LIMIT 0,2"
        )->result();
    if (!empty($list_related_post)) {
        foreach ($list_related_post as $item) {
            array_push($navi_samptypes_ar, $item);
        }
    }
    if (!empty($navi_samptypes_ar)){
        foreach ($navi_samptypes_ar as $item) {
            $navi_samptypes .= mystr()->get_from_template(
                $navi_samptypes_temp, 
                [
                    '{{link}}' => $this->PostContentModel->get_link_from_id($item->id),
                    '{{title}}' => str_to_view($item->m_title),
                    '{{titlese}}' => str_to_view($item->m_title, false),
                    '{{avata}}' => $this->PostContentModel->get_avata($item->id, 'verysmall')
                ]
            );
        }
    }

    /*
     * Generate post template
     */
    echo mystr()->get_from_template(
        $this->load->design('block/post/content/main.html'),
        [
            '{{advermain}}' => $advermain,
            '{{url_current}}' => $page_fb_url,
            '{{page_domain}}' => $page_domain_name,
            '{{str_like_full}}' => get_str_like_full($page_fb_url),
            '{{comment_facebook}}' => get_str_fb_comment($page_fb_url),
            '{{facebook_fanpage}}' => get_str_fb_fanpage(Array('fanpage' => $page_fb_fanpage, 'fanpage_title' => $page_fb_fanpage_title)),

            '{{id}}' => $post_line->id,
            '{{title}}' => str_to_view($post_line->m_title),
            '{{titlese}}' => str_to_view($post_line->m_title, false),
            '{{content}}' => $this->PostContentModel->get($post_line->id, "m_content"),
            '{{last_update}}' => my_time_ago_str($post_line->m_militime),
            '{{avata_original}}' => $this->PostContentModel->get_avata_original($post_line->id),
            '{{breakcump}}' => $breakcump,
            '{{comment_num}}' => $temp_num_comment,
            '{{view_num}}' => $post_line->m_view,
            '{{like_num}}' => $post_line->m_like,
            '{{follow_num}}' => $this->PostFollowModel->get_follow_count('post', $post_line->id),
            '{{quickedit}}' => $quickedit,

            '{{tags}}' => $tags,
            '{{comments}}' => $comment_str,
            '{{str_rank}}' => $rank_str,

            '{{author_id}}' => $author_line->id,
            '{{author_link}}' => $this->PostAuthorModel->get_link_from_id($author_line->id),
            '{{author_realname}}' => $author_line->m_realname,
            '{{author_avata}}' => $this->UserModel->get_avata($author_line->id),
            '{{author_numfollow}}' => $this->PostFollowModel->get_follow_count('author', $author_line->id),

            '{{user_avata}}' => $this->UserModel->get_avata($idname),
            '{{user_realname}}' => $this->UserModel->get($idname, 'm_realname'),

            '{{navi_samptypes}}' => $navi_samptypes,
            '{{navi_sampauthor}}' => $navi_sampauthor
        ]
    );
}