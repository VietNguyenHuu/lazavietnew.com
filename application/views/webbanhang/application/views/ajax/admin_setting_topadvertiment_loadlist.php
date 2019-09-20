<?php

/* tai danh sach quang cao chính (top) */
//$this->load->model('AdvertimentModel');
$str = "";
$data = $this->AdvertimentModel->getAll();
if (!$data) {
    $str .= "Chưa có quảng cáo nào";
} else {
    $m = count($data);
    $str .= "<div class='list'>";
    for ($i = 0; $i < $m; $i++) {
        $str .= "<div class='item top_advertiment'>";
        if ($this->AdvertimentModel->check_publish($data[$i]->id)) {
            $temp = "<i class='fa fa-eye button padding gray' class='action' onclick='top_advertiment.hide(" . $data[$i]->id . ")'>Ẩn</i>";
        } else {
            $temp = "<i class='fa fa-eye button padding gray' class='action' onclick='top_advertiment.show(" . $data[$i]->id . ")'>Hiện</i>";
        }

        $str .= "<img class='align_middle margin_r' style='max-width:5em;height:2em;' src='" . $this->AdvertimentModel->get_avata($data[$i]->id) . "'><span class='align_middle'>" . $data[$i]->m_title . " <span class='tip'>-- " . $data[$i]->m_view . " Lượt xem</span></span>";
        $str .= "<div class='float_right'> ";
        $str .= $temp;
        $str .= " <i class='fa fa-pencil button padding' onclick='top_advertiment.load_form_edit(" . $data[$i]->id . ")'></i>";
        $str .= " <i class='fa fa-trash-o button padding stt_mistake red' onclick='top_advertiment.del(" . $data[$i]->id . ")'></i>";

        $str .= "</div>";
        $str .= "<div class='clear_both'></div>";
        $str .= "</div>";
    }
    $str .= "</div>";
}
echo $str;
?>