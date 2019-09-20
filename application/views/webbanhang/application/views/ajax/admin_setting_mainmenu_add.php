<?php

$id_parent = $this->input->post('id_parent');
$type2 = $this->input->post('type2');
$title = $this->input->post('title');
$link = $this->input->post('link');

$a_success = $this->StaticPageModel->add(Array(
    'id_parent' => $id_parent,
    'type' => $type2,
    'title' => $title,
    'link' => $link
        ));
if ($a_success != false) {
    echo "Đã thêm menu '" . $this->StaticPageModel->get($a_success, 'm_title') . "' vào mục hiện tại";
} else {
    echo "Không thêm được menu vào mục hiện tại";
}
?>