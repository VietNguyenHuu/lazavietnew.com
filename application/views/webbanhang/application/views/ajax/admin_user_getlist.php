<?php

if ($this->UserModel->get($idname, 'm_level') < 4) {
    echo "<div class='stt_mistake'>Không lấy được danh sách thành viên</div>";
} else {
    $order = $this->input->post('order');
    if ($order == "" || $order == 'undefined') {
        $order = 'new';
    }
    $search = $this->input->post('search');
    if ($search == "" || $search == 'undefined') {
        $search = '';
    }
    $str = "";
    $gl_w = Array();
    array_push($gl_w, "m_level < " . $this->UserModel->get($idname, 'm_level'));
    if ($search != "") {
        array_push($gl_w, "MATCH(m_realname_search)AGAINST('" . addslashes(mystr()->addmask($search)) . "')");
    }
    $query = "SELECT * FROM user WHERE (" . implode(" AND ", $gl_w) . ")";
    $m = $this->db->query($query)->num_rows();
    if ($order == 'new') {
        $query .= " ORDER BY id DESC";
    } else if ($order == 'online') {
        $query .= " ORDER BY m_lasttime DESC";
    }
    $page = (int) $this->input->post("page");
    $phantrang = page_seperator($m, $page, 40, Array('class_name' => 'page_seperator_item', 'strlink' => 'javascript:user.loadlist([[pagenumber]])'));
    $query .= " LIMIT " . $phantrang['start'] . "," . $phantrang['limit'];
    $data = $this->db->query($query)->result_array();
    $max = count($data);
    if ($max < 1) {
        $str .= "Không có thành viên nào trong danh sách";
    } else {
        $str .= "<div style='max-height:300px;overflow:auto'>";
        for ($i = 0; $i < $max; $i++) {
            $temp_online = "";
            if (time() - $data[$i]['m_lasttime'] < 30 * 60) {
                $temp_online = ' online ';
            }
            if ($data[$i]['m_sex'] == '0') {
                $temp_sex = ' female';
            } else {
                $temp_sex = ' male';
            }
            $str .= "<div class='width_40 padding'><div class='stt_action padding user_item" . $temp_online . " user_item" . $temp_sex . "' onclick='user.loadinfo(" . $data[$i]['id'] . ")'><img src='" . $this->UserModel->get_avata($data[$i]['id']) . "' class='align_middle user_item_avata'><span class='align_middle'>" . $data[$i]['m_realname'] . "</span></div></div>";
        }
        $str .= "<div class='clear_both'></div>";
        $str .= "</div>";
    }
    $str .= "<div class='page_seperator_box'>" . $phantrang['str_link'] . "</div>";
    echo $str;
}
?>