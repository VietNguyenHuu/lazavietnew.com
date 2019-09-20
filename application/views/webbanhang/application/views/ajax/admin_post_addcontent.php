<?php

if ($this->UserModel->get($idname, 'm_level') > 2) {
    $id_type = $this->input->post('id_type');
    $title = $this->input->post('title');
    $content = $this->input->post('content');
    $avata = $this->input->post('avata');

    //ghi vào cơ sở dữ liệu
    $a_success = $this->PostContentModel->add(Array(
        'id_type' => $id_type,
        'id_user' => $idname,
        'title' => $title,
        'content' => $content,
        'date' => TimeHelper()->_strtime
    ));


    if ($a_success != false) {
        if ($avata != "" && $avata != 'undefined') {//ghi file avata
            $this->PostContentModel->set_avata($a_success, $avata);
        }
        echo "Đã thêm bài viết '" . $this->PostContentModel->get($a_success, 'm_title') . "' vào mục hiện tại";
    } else {
        echo "Không thêm được bài viết vào mục hiện tại";
    }
} else {
    echo "Cần quyền quản trị";
}
?>