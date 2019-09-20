<?php

if ($this->UserModel->get($idname, 'm_level') > 2) {
    $p_id = $this->input->post('id_parent');
    //in đường dẫn
    $list = $this->PostTypeModel->get_link_type($p_id);
    echo "<div class='margin_b padding_v'>";
    if ($list == false) {
        echo "<a href='javascript:admin_post_type.loadlist(1)'><i class='fa fa-list'></i> Danh mục chính</a>";
    } else {
        echo "<a href='javascript:admin_post_type.loadlist(1)'><i class='fa fa-list'></i> Danh mục chính</a>";
        $max = count($list);
        for ($i = 1; $i < $max; $i++) {
            echo " / <a href='javascript:admin_post_type.loadlist(" . $list[$i] . ")'>" . $this->PostTypeModel->get($list[$i], 'm_title') . "</a>";
        }
    }
    echo "</div>";
    //end in đường dẫn
    $data = $this->PostTypeModel->get_direct_type($p_id);
    if ($data != false) {
        $max = count($data);
        echo "<div class='padding_v margin_t'><i class='fa fa-folder-o'></i> Tất cả " . $max . " danh mục trong mục hiện tại</div>";
        for ($i = 0; $i < $max; $i++) {
            echo "<div class='padding_v item' style='border-bottom:1px dotted #999999'>";
            echo "<a href='javascript:admin_post_type.loadlist(" . $data[$i]['id'] . ")'><span class='stt_tip'>" . ($i + 1) . " - </span>" . $data[$i]['m_title'] . "</a>";
            echo "<div class='float_right'>";
            if ($data[$i]['m_index'] > 1) {
                echo "<i class='fa fa-arrow-up stt_action margin_r' title='Tăng thứ tự' onclick='admin_post_type.movies(" . $data[$i]['id'] . ",-1)'></i> ";
            }
            if ($data[$i]['m_index'] < $max) {
                echo "<i class='fa fa-arrow-down stt_action margin_r' title='Giảm thứ tự' onclick='admin_post_type.movies(" . $data[$i]['id'] . ",1)'></i> ";
            }
            echo "<i class='fa fa-pencil stt_action stt_highlight margin_r' title='Chỉnh sửa' onclick='admin_post_type.loadformedit(" . $data[$i]['id'] . ")'></i> ";
            echo "<i class='fa fa-trash-o stt_mistake stt_action margin_r' title='Xóa' onclick='admin_post_type.del(" . $data[$i]['id'] . ")'></i>";
            echo "</div>";
            echo "<div class='clear_both'></div>";
            echo "</div>";
        }
        echo "<div class='margin_t padding_v'><span class='button padding fontsize_d2 margin_r' onclick='admin_post_type.loadformedit(" . $p_id . ")'>Chỉnh sửa</span><span class='button padding fontsize_d2' onclick='admin_post_type.load_form_add()'>+ Thêm danh mục mới</span> <span class='button padding fontsize_d2' onclick='admin_post_type.load_form_change_parent()'><i class='fa fa-share-alt'></i> Đổi mục gốc</span></div>";
    } else {
        echo "<div class='tip align_center' style='padding:50px 0px;font-size:18px;'>Danh mục trống";
        echo "<div class='margin_t padding_v'><span class='button padding fontsize_d2 margin_r' onclick='admin_post_type.loadformedit(" . $p_id . ")'>Chỉnh sửa</span><span class='button padding fontsize_d2' onclick='admin_post_type.load_form_add()'>+ Thêm danh mục mới</span> <span class='button padding fontsize_d2' onclick='admin_post_type.load_form_change_parent()'><i class='fa fa-share-alt'></i> Đổi mục gốc</span></div></div>";
    }
} else {
    echo "Cần quyền quản trị";
}
?>