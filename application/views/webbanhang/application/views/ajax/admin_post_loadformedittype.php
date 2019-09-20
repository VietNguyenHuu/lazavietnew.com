<?php
    if($this->UserModel->get($idname,'m_level')>2)
    {
        $edit_id=$this->input->post('edit_id');
        $edit_row=$this->PostTypeModel->get_row($edit_id);
        if($edit_row==false)
        {
            echo "Rất tiếc, danh mục không tồn tại !";
        }
        else
        {
            echo "<div class='width_50'><span class='stt_tip'>Tên danh mục</span>";
            echo "<br/><input id='admin_post_edit_type_title' type='text' placeholder='Nhập tên danh mục' value='".$edit_row->m_title."'>";
            echo "</div><div class='width_50'><span class='stt_tip'>Vị trí</span>";
            echo "<br/><input class='' id='admin_post_edit_type_index' type='number' value='".$edit_row->m_index."' />";
            echo "</div><div class='clear_both'></div>";
            echo "<div class='margin_t padding_v'>";
                echo "Nâng cao > SEO:<br>";
                echo "<span class='stt_tip fontsize_d2'><i class='fa fa-level-up fa-rotate-90'></i> Tiêu đề SEO</span><br><textarea style='width:100%;max-width:100%;max-height:150px' id='admin_post_edit_type_seo_title' placeholder='Tiêu đề seo'>".str_to_view($edit_row->m_seo_title)."</textarea>";
                echo "<br><span class='stt_tip fontsize_d2'><i class='fa fa-level-up fa-rotate-90'></i> Keyword SEO</span><br><textarea style='width:100%;max-width:100%;max-height:150px' id='admin_post_edit_type_seo_keyword' placeholder='Keyword seo'>".str_to_view($edit_row->m_seo_keyword)."</textarea>";
                echo "<br><span class='stt_tip fontsize_d2'><i class='fa fa-level-up fa-rotate-90'></i> Mô tả SEO</span><br><textarea style='width:100%;max-width:100%;max-height:150px' id='admin_post_edit_type_seo_description' placeholder='Mô tả seo'>".str_to_view($edit_row->m_seo_description)."</textarea>";
            echo "</div>";
            echo "<div class='padding_v margin_t line_height_2'><span class='button padding fontsize_d2' onclick='admin_post_type.edit(".$edit_id.")'>Cập nhật</span></div>";
        }
    }
    else
    {
        echo "Cần quyền quản trị";
    }
?>