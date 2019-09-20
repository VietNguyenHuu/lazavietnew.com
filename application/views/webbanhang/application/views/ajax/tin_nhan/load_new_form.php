<?php
    if($idname==false)
    {
        echo "<div class='stt_mistake'>Đăng nhập để viết tin nhắn</div>";
    }
    else
    {
        echo "<div class='tin_nhan_new_form_to'>";
            echo "<div class=''>Chọn người nhận tin: </div>";
            echo "<div id='tin_nhan_new_form_to_selected'></div>";
            echo "<div class='clear_both'></div>";
            echo "<div class='line_height_2'><input class='margin_b' type='text' id='tin_nhan_new_form_to_search_input' placeholder='Tìm tên người nhận' style='margin-right:0px;border-radius:0px'><span class='button padding margin_b' style='margin-left:3px;border-radius:0px' onclick='tin_nhan.soantin_search_to()'><i class='fa fa-search'></i> Tìm</span></div>";
            echo "<div id='tin_nhan_new_form_to_search_result'></div>";
        echo "</div>";
        echo "<div class='padding_v'><textarea id='tin_nhan_new_form_content' placeholder='Nhập tin nhắn...'></textarea></div>";
        echo "<div class='padding_v align_right'><span class='button padding' onclick='tin_nhan.soantin_send()'><i class='fa fa-send margin_r'></i> Gửi tin nhắn</span></div>";
    }
?>