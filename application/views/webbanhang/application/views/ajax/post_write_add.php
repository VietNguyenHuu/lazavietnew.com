<?php

if ($this->UserModel->get($idname, 'm_level') > 0) {
    $title = $this->input->post('title');

    //ghi vào cơ sở dữ liệu
    $a_success = $this->PostContentModel->add(Array(
        'id_user' => $idname,
        'title' => $title
    ));


    if ($a_success != false) {
        echo "<div class='stt_avaiable'>Đã thêm bài viết '" . $title . "' vào mục hiện tại</div><div class='stt_tip'>Bài viết sẽ sớm được kiểm duyệt và khi đó sẽ sẵn sàng hiển thị công khai</div><div class=''>Chân thành cám ơn bạn đã đóng góp bài viết này, hy vọng bài viết của bạn sẽ là kiến thức hữu ích cho mọi người.</div>";
        echo "<div class='align_center padding_v margin_v' style='margin-top:30px'><a href='" . site_url("quan-ly-bai-viet.html") . "'><span class='button padding fontsize_d2'>Tải lại DS bài viết</span></a></div>";
    } else {
        echo "Không thêm được bài viết vào mục hiện tại";
    }
} else {
    echo "Đăng nhập để đăng bài";
}
