<?php

include_once("application/views/page_dynamic/post/include_post_header.php");
?>
<?php

$post_row = $this->PostContentModel->get_row($data['id_post']);
if ($post_row == false) {
    echo "<div class='stt_mistake'>Bài viêt không khả dụng</div>";
} else {
    if ($idname != $post_row->m_id_user) {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    } else {
        $ar_type = $this->PostTypeModel->get_link_type($post_row->m_id_type);
        if ($ar_type != false) {
            $max = count($ar_type);
            for ($i = 0; $i < $max; $i++) {
                if ($ar_type[$i] != 1) {
                    $ar_type[$i] = "<a href='" . $this->PostTypeModel->get_link_from_id($ar_type[$i]) . "'>" . $this->PostTypeModel->get($ar_type[$i], 'm_title') . "</a>";
                } else {
                    $ar_type[$i] = "<a href='" . $this->PostTypeModel->get_link_from_id(1) . "'><i class='fa fa-home'></i> </a>";
                }
            }
        }
        if ($post_row->m_id_user_check == -1) {
            $checkby = "<span class='stt_mistake'>Chưa kiểm duyệt</span>";
        } else {
            $checkby = ""
                    . "<img class='align_middle margin_r' style='height:1em;border:1px solid #666;' src='" . $this->UserModel->get_avata($post_row->m_id_user_check) . "'>"
                    . $this->UserModel->get($post_row->m_id_user_check, 'm_realname');
        }
        $post_comment = $this->db->query("SELECT id FROM " . $this->PostCommentModel->get_table_name() . " WHERE m_id_content=" . $post_row->id)->num_rows();

        echo mystr()->get_from_template($this->load->design('block/post/write_detail/main.html'), [
            '{{post_title}}' => $post_row->m_title,
            '{{post_linkto}}' => implode(" / ", $ar_type),
            '{{post_status}}' => $this->PostContentModel->label_status()[$post_row->m_status],
            '{{post_updatetime}}' => my_time_ago_str($post_row->m_militime),
            '{{post_checkedby}}' => $checkby,
            '{{post_view}}' => $post_row->m_view,
            '{{post_like}}' => $post_row->m_like,
            '{{post_rank}}' => $post_row->m_rank,
            '{{post_comment}}' => $post_comment,
            '{{post_commentlist}}' => '',
            '{{post_reportlist}}' => '',
            '{{post_id}}' => $post_row->id,
            '{{}}' => '',
        ]);
    }
}