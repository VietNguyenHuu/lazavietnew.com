<?php

include_once("application/views/page_dynamic/post/include_post_header.php");

$num = $this->PostGroupModel->get_num_row();
$phantrang = page_seperator(
    $num,
    (int) $data['page'], 
    20, 
    Array(
        'class_name' => 'page_seperator_item',
        'strlink' => "nhom-bai-viet/trang-[[pagenumber]].html"
    )
);

$list = $this->db->query( ""
            . "SELECT * FROM " . $this->PostGroupModel->get_table_name() 
            . " WHERE m_status = 'public'"
            . " ORDER BY id DESC"
            . " LIMIT " . $phantrang['start'] . ", " . $phantrang['limit']
        )->result();

$listseries = '';
if (!empty($list)){
    $item_temp = $this->load->design('block/post/series/item.html');
    foreach ($list as $key => $value){
        $listseries .= mystr()->get_from_template(
            $item_temp,
            [
                '{{title}}' => $value->m_title,
                '{{link}}' => $this->PostGroupModel->get_link_from_row(['id' => $value->id, 'title' => $value->m_title]),
                '{{avata}}' => $this->PostGroupModel->get_avata($value->id),
                '{{timeago}}' => my_time_ago_str($value->m_militime_modify)
            ]
        );
    }
}

echo mystr()->get_from_template(
    $this->load->design('block/post/series/main.html'), 
    [
        '{{curentpage}}' => $phantrang['recent_page'],
        '{{totalpage}}' => $phantrang['total_page'],
        '{{numseries}}' => $num,
        '{{listseries}}' => $listseries,
        '{{rightadver}}' => '',
        '{{seperator}}' => $phantrang['str_link']
    ]
);
