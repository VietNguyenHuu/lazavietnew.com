<?php

$id = $this->input->post('id');
$user_detail = $this->UserModel->get_row($id);
$user_current = $this->UserModel->get_row($idname); // admin hiện tại

if ($user_detail == false) {
    echo "Thành viên không tồn tại";
} else if ($user_current->m_level <= $user_detail->m_level) {
    echo "Tác vụ không được phép";
} else {
    $action_level = '';
    $action_lock = '';
    $arlv = $this->UserModel->label_level();
    for ($i = 1; $i <= $user_current->m_level; $i++) {
        $action_level .= "<span class='button padding fontsize_d2' onclick='user.setlevel(" . $id . "," . $i . ")' style='line-height:2.5em;'>&nbsp;" . $arlv[$i] . "&nbsp;</span> ";
    }
    
    if ($user_detail->m_lock == 1) {
        $action_lock .= "<span class='button padding fontsize_d2' onclick='user.unlock(" . $id . ")'><i class='fa fa-unlock-alt'></i> Mở khóa thành viên</span>";
    } else {
        $action_lock .= "<span class='button padding red fontsize_d2' onclick='user.lock(" . $id . ")'><i class='fa fa-lock'></i> Khóa thành viên</span> ";
    }
    
    echo mystr()->get_from_template(
            $this->load->design('block/admin/user/infodetail.html'), [
        '{{id}}' => $user_detail->id,
        '{{link}}' => $this->UserModel->get_link_from_id($user_detail->id),
        '{{avata}}' => $this->UserModel->get_avata($user_detail->id),
        '{{realname}}' => $user_detail->m_realname,
        '{{leveltxt}}' => $arlv[$user_detail->m_level],
        '{{username}}' => $user_detail->m_name,
        '{{sex}}' => $this->UserModel->label_sex()[$user_detail->m_sex],
        '{{birth}}' => $user_detail->m_birth,
        '{{phone}}' => $user_detail->m_phone,
        '{{email}}' => $user_detail->m_email,
        '{{lasttime}}' => TimeHelper($user_detail->m_lasttime)->to_str() . " (" . my_time_ago_str($user_detail->m_lasttime) . ")",
        '{{score}}' => $user_detail->m_score,
        '{{money}}' => $user_detail->m_money,
        '{{action_level}}' => $action_level,
        '{{action_lock}}' => $action_lock,
    ]);
}