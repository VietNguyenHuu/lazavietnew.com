<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        echo "<div class='padding'></div>";
        echo "<input class='admin_post_author_formadd_iduser' type='text' value='' placeholder='id user' title='id user'>";
        echo "<input class='admin_post_author_formadd_score' type='number' value='' title='Điểm cộng/ 1 bài viết'>";
        echo "<span class='button padding' onclick='admin_post_author.add()'>Thêm</span>";
        echo "<div class='padding_v stt_tip'>Nhập vào id_user là id của người mà bạn muốn thêm làm tác giả bài viết, số điểm cộng là điểm sẽ được tự động cộng thêm khi người dùng có id này viết một bài và được duyệt (lưu ý: 1 điểm tương ứng 10vnđ)</div>";
    }
?>