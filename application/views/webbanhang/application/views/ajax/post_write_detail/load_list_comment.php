<?php

$post_row = $this->PostContentModel->get_row((int) $this->input->post('id'));
if ($post_row == false) {
    echo "<div class='stt_mistake'>Bài viết không khả dụng</div>";
} else {
    if ($post_row->m_id_user != $idname) {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    } else {
        $num_comment = $this->db->query("SELECT id FROM " . $this->PostCommentModel->get_table_name() . " WHERE (m_id_content=" . $post_row->id . ")")->num_rows();
        if ($num_comment < 1) {
            echo "<div class='stt_tip padding'>Chưa có bình luận nào được gởi trong bài viết này</div>";
        } else {
            $page = (int) $this->input->post('page');
            if ($page < 1) {
                $page = 1;
            }
            $phantrang = page_seperator($num_comment, $page, 40, Array('class_name' => 'page_seperator_item', 'strlink' => 'javascript:post_write_detail.load_listcomment([[pagenumber]])'));
            $list_comment = $this->db->query("SELECT * FROM " . $this->PostCommentModel->get_table_name() . " WHERE (m_id_content=" . $post_row->id . ") ORDER BY id DESC LIMIT " . $phantrang['start'] . "," . $phantrang['limit'])->result();
            if (count($list_comment) < 1) {
                echo "<div class='stt_tip padding'>Chưa có bình luận nào được gởi trong phân trang này</div>";
            } else {
                echo "<div class='list'>";
                $item_temp = $this->load->design('block/post/write_detail/comment_list_item.html');
                foreach ($list_comment as $list_comment_item) {
                    
                    echo mystr()->get_from_template($item_temp, [
                        '{{comment_id}}' => $list_comment_item->id,
                        '{{comment_user_realname}}' => $this->UserModel->get($list_comment_item->m_id_user, 'm_realname'),
                        '{{comment_user_link}}' => $this->UserModel->get_link_from_id($list_comment_item->m_id_user),
                        '{{comment_content}}' => trichdan($list_comment_item->m_content, 100)
                    ]);
                }
                echo "</div>";
                echo "<div class='page_seperator_box align_left'>" . $phantrang['str_link'] . "</div>";
            }
            
        }
    }
}
?>