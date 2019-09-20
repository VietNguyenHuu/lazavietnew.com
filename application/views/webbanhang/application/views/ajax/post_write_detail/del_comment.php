<?php

$ar_del = $this->input->post('id_comment');
if (!empty($ar_del)) {
    if (is_array($ar_del)) {
        foreach ($ar_del as $ar_del_item) {
            $comment_row = $this->PostCommentModel->get_row($ar_del_item);
            if ($comment_row != false) {
                $post_row = $this->PostContentModel->get_row($comment_row->m_id_content);
                if ($post_row != false) {
                    if ($post_row->m_id_user == $idname) {
                        $this->PostCommentModel->del($comment_row->id);
                    }
                }
            }
        }
        echo "<div class='padding bg_success stt_white margin_v'>Đã xóa " . count($ar_del) . " bình luận bài viết</div>";
    }
}