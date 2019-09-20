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
            echo "<div class='stt_mistake'>Nhóm bài viết không khả dụng để quản lí</div>";
        }
        else
        {
            echo "<div class='margin_v' style='border-bottom: 1px dotted #333333'>".str_to_view($post_group_row->m_title)."</div>";
            echo "<div id='admin_post_group_detail_addpost' class='line_height_2_5' ><input type='text' value='' placeholder='Tìm tên bài viết...' id='admin_post_group_detail_addpost_searchinput' style='margin-left:0px' /> <span class='button padding radius_none ' onclick='admin_post_group.addpost_search(".$post_group_row->id.")' title='Tìm bài viết để thêm vào nhóm'> <i class='fa fa-search'></i> </span>";
                echo "<div id='admin_post_group_detail_addpost_search_result'></div>";
            echo "</div>";
            echo "<div class='admin_post_group_detail_listpost'>";
                echo "<p class='fontsize_a3 margin_t'>Danh sách bài viết</p>";
                $list_post=$this->db->query("SELECT * FROM post_content WHERE (m_id_group=".$post_group_row->id.") ORDER BY m_group_index ASC")->result();
                if($list_post != false && $list_post != null && count($list_post) >0)
                {
                    $layout_item=<<<EOD
<div class='padding_v admin_post_in_group_{{idpost}}' style='border-bottom:1px solid #999999'>
    <div class='width3 width3_0_10'>
        <span class='stt_tip'>{{index}} -</span><span class='font_roboto fontsize_d2'> {{title}}</span>
    </div>
    <div class='width3 width3_0_2 align_right'>
        <i class='fa fa-info-circle stt_action stt_tip'></i>&nbsp;&nbsp;&nbsp;
        <i class='fa fa-trash-o stt_action stt_mistake margin_r' onclick='admin_post_group.delpost({{idpost}})'></i>
    </div>
    <div class='clear_both'></div>
</div>
EOD;
                    echo "<div class='' style='max-height: 400px;overflow: auto;'>";
                    foreach($list_post as $key=>$list_post_line)
                    {
                        $ar_patern=Array(
                            '{{index}}'=>$list_post_line->m_group_index,
                            '{{title}}'=>str_to_view($list_post_line->m_title),
                            '{{idpost}}'=>$list_post_line->id
                        );
                        echo str_replace(array_keys($ar_patern), array_values($ar_patern), $layout_item);
                    }
                    echo "</div>";
                }
                else
                {
                    echo "<div class='stt_tip'>Chưa có bài viết nào trong nhóm !</div>";
                }
            echo "</div>";
        }
    }
?>