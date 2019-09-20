<?php

if ($this->UserModel->get($idname, 'm_level') > 0) {
    $id = $this->input->post('id');
    $post_row = $this->PostContentModel->get_row($id);
    if ($post_row == false) {
        echo "<div class='stt_mistake'>Bài viết không khả dụng.</div>";
    } else {
        $post_update_form = "<div style='margin:5px 0px;'><span class='button padding float_right' onclick='post_write_detail.update(" . $post_row->id . ")'>Cập nhật</span><input type='text' placeholder='Tiêu đề' value='" . $post_row->m_title . "' name='post_update_title'>";
        $act3 = 'document.getElementById("post_update_inputavata").click()';
        $post_update_form .= "<input type='file' id='post_update_inputavata' onchange='post_write_detail.update_setavata(this)' style='display:none;'><span class='button gray padding' onclick='" . $act3 . "'><img src='" . $this->PostContentModel->get_avata($id) . "' name='post_update_avata' style='width:18;height:18px;margin-right:10px;vertical-align:middle;'>Ảnh đại diện</span>";
        $post_update_form .= "<span class='button gray padding margin_l' id='post_update_type' data-id='" . $post_row->m_id_type . "' onclick='post_write_detail.update_load_type()'>Mục: " . $this->PostTypeModel->get($post_row->m_id_type, "m_title") . "</span>";
        $post_update_form .= "<div class='hide' id='post_update_type_choose'></div>";
        $post_update_form .= "<div class='clear_both'></div></div>";
        $post_update_form .= "<div id='post_update_nd_pane'></div>";
        $post_update_form .= "<div id='post_update_nd' style='width:100%;border:1px solid #ddddff;min-height:300px;background-color:#ffffff;max-width:100%;max-height:500px;overflow:auto;'>" . $post_row->m_content . "</div>";
        echo $post_update_form;
    }
} else {
    echo "Đăng nhập để thực hiện chức năng";
}
?>