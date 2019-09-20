<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        echo "<div class='width3 width3_0_12 width3 width3_1024_2 padding_v align_right float_right'><span class='button padding display_inline_block' onclick='admin_post_group.add()'> Lưu </span></div>";
        echo "<div class='width3 width3_0_12 width3 width3_1024_10 padding_v padding_r float_right'><input type='text' class='fullwidth' id='admin_post_group_formadd_title' value='' placeholder='Tên nhóm bài viết' /></div>";
        echo "<div class='clear_both'></div>";
        echo "<div id='admin_post_group_formadd_nd_pane'></div>";
        echo "<div id='admin_post_group_formadd_nd'><span class='stt_tip'>Mô tả nhóm bài viết...</span></div>";
    }
?>