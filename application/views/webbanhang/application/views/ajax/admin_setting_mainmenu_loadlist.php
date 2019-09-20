<?php

$p_id = $this->input->post('id_parent');
//tao thanh dieu huong
$id = $p_id;
$str = "";
$pr = $id;
$data = $this->StaticPageModel->getAll();
if ($data != false) {

    function idtostt($in, $dt) {
        $maxdt = count($dt);
        for ($i = 0; $i < $maxdt; $i++) {
            if ($dt[$i]->id == $in) {
                return $i;
            }
        }
        return -1;
    }

    do {
        $stt = idtostt($pr, $data);
        if ($stt != -1) {
            $act = 'main_menu.load_list(' . $data[$stt]->id . ')';
            $str = htmlspecialchars(" / ") . " <a href='javascript:" . $act . "'>" . str_to_view($data[$stt]->m_title) . "</a>" . $str;
            $pr = $data[$stt]->m_id_parent;
        }
    } while ($pr != 1);
}

$item_str = '';
$static_page = $this->StaticPageModel;
$data = $static_page->get_direct_type($p_id);
if ($data !== false) {
    $item_temp = $this->load->design('block/admin/setting/staticPage_list_item.html');
    $max = count($data);
    for ($i = 0; $i < $max; $i++) {
        if ($data[$i]['m_type'] == 'system') {
            $temp_link = base_url() . "" . $data[$i]['m_link'];
        } else {
            $temp_link = $this->StaticPageModel->get_link_from_id($data[$i]['id']);
        }
        
        $item_str .= mystr()->get_from_template(
        $item_temp, 
        [
            '{{id}}' => $data[$i]['id'],
            '{{title}}' => str_to_view($data[$i]['m_title']),
            '{{avata}}' => $static_page->get_avata($data[$i]['id']),
            '{{link}}' => $temp_link
        ]);
        }
} else {
    $item_str = "Không có trang nào trong mục này !";
}


echo mystr()->get_from_template(
        $this->load->design('block/admin/setting/staticPage_list.html'), 
        [
            '{{breakcump}}' => $str,
            '{{items}}' => $item_str
        ]);