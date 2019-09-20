<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        echo "<div class='padding_v margin_v'>";
            echo "<input type='' id='admin_post_report_pattern_formadd_title' value='' placeholder='Tiêu đề mẫu'>";
            echo "<span class='button padding' onclick='admin_post_report_pattern.add()'>Thêm</span>";
        echo "</div>";
        echo "<div class='stt_tip'>Hướng dẫn: Mẫu phản hồi là một lựa chọn để người dùng chọn vào khi muốn báo cáo lỗi về bài viết. Ví dụ về mẫu phản hồi: 'Bài viết có nội dung không lành mạnh'</div>";
    }
?>