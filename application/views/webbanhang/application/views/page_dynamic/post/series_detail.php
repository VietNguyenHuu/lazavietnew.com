<?php

include_once("application/views/page_dynamic/post/include_post_header.php");

$series_row = $this->PostGroupModel->get_row($data['id']);

if (empty($series_row)) {
    echo "<div class='stt_mistake'>Nhóm bài viết không khả dụng !</div>";
} else {
    $listpost = $this->db->query(""
            . "SELECT * FROM " . $this->PostContentModel->get_table_name()
            . " WHERE m_id_group = " . $series_row->id
            . " ORDER BY m_group_index ASC"
        )->result();
    $listpost_str = '';
    foreach ($listpost as $key => $value){
        $listpost_str .= ""
                . "<div class='width_40 padding post_content_item_box'>"
                .       $this->PostContentModel->get_str_item($value)
                . "</div>";
    }
    echo mystr()->get_from_template(
        $this->load->design('block/post/series/detail.html'), 
        [
            '{{title}}' => $series_row->m_title,
            '{{numpost}}' => count($listpost),
            '{{listpost}}' => $listpost_str,
            '{{rightadver}}' => ''
        ]
    );
}