<?php

$adver_row = $this->AdvertimentModel->get_rand('main');
if ($adver_row != false) {
    $adver_row = $adver_row[0];

    echo mystr()->get_from_template(
        $this->load->design('block/post/adver_main.php'), 
        [
            '{{link}}' => $adver_row->m_link,
            '{{titlese}}' => str_to_view($adver_row->m_title, false),
            '{{avata}}' => $this->AdvertimentModel->get_avata_original($adver_row->id)
        ]
    );
}
?>