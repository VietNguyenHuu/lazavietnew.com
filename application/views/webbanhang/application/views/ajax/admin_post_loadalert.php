<?php

if ($this->UserModel->get($idname, 'm_level') < 3) {
    echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
} else {
    //bình luận mới
    echo "<div class='stt_mistake'>-- Bình luận mới --</div>";
    $ar_new_bl = $this->db->query("SELECT * FROM " . $this->PostCommentModel->get_table_name() . " ORDER BY id DESC LIMIT 0,3")->result();
    if (count($ar_new_bl) > 0) {
        echo "<div class='list'>";
        foreach ($ar_new_bl as $ar_new_bl_line) {
            echo "<div class='item'>";
            echo $this->UserModel->get($ar_new_bl_line->m_id_user, 'm_realname') . " => " . trichdan($ar_new_bl_line->m_content, 100) . " -- Trong <a target='_blank' href='" . $this->PostContentModel->get_link_from_id($ar_new_bl_line->m_id_content) . "'>" . $this->PostContentModel->get($ar_new_bl_line->m_id_content, 'm_title') . "</a>";
            echo "<span class='stt_tip float_right'><i class='fa fa-clock-o'></i> " . $ar_new_bl_line->m_date . "</span>";
            echo "<div class='clear_both'></div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<div class='stt_tip'>Chưa có bình luận nào</div>";
    }
}