<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $post_group_row=$this->PostGroupModel->get_row($this->input->post('id'));
        if($post_group_row==false)
        {
            echo "<div class='stt_mistake'>Nhóm bài viết không khả dụng để sửa</div>";
        }
        else
        {
            echo "<div class='width3 width3_0_12 width3 width3_1024_2 padding_v align_right float_right'><span class='button padding display_inline_block' onclick='admin_post_group.edit(".$post_group_row->id.")'> Lưu </span></div>";
            echo "<div class='width3 width3_0_12 width3 width3_1024_10 padding_v padding_r float_right'><input type='text' class='fullwidth' id='admin_post_group_formadd_title' value='".str_to_view($post_group_row->m_title, false)."' placeholder='Tên nhóm bài viết' /></div>";
            echo "<div class='clear_both'></div>";
            echo "<img id='admin_post_group_formadd_avata' onclick=\"$('#admin_post_group_formadd_avata_in').click()\" src='" . $this->PostGroupModel->get_avata($post_group_row->id) . "' style='height:2em;width:2em;' />";
            echo "<input type='file' class='hide' id='admin_post_group_formadd_avata_in' onchange='admin_post_group.edit_setavata(this)' />";
            echo "<div id='admin_post_group_formadd_nd'>".$post_group_row->m_description."</div>";
        }
    }
?>