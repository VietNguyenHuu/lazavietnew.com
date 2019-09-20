<?php

if ($this->UserModel->get($idname, 'm_level') < 3) {
    echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
} else {

    $post_row = $this->PostContentModel->get_row($this->input->post('idpost'));
    if ($post_row == false) {
        echo "<div class='stt_mistake'>Bài viết không khả dụng để xóa khỏi nhóm</div>";
    } else {
        if ($this->PostContentModel->set($post_row->id, 'm_id_group', -1) == true) {
            //reset index of current post group
            $this->db->query("UPDATE post_content SET m_group_index = (m_group_index - 1) WHERE m_id_group=" . $post_row->m_id_group . " AND m_group_index > " . $post_row->m_group_index);
            $this->PostContentModel->set($post_row->id, 'm_group_index', -1);
            echo "1";
        } else {
            echo "Không xóa được bài viết khỏi nhóm !";
        }
    }
}