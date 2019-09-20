<?php
    $adver_row=$this->AdvertimentModel->get_rand();
    if($adver_row!=false)
    {
        $adver_row=$adver_row[0];
        $str_adver=<<<EOD
<a class='radius_none post_adver_item' href='{{link}}' target='_blank' title='{{titlese}}'>
    <img class='post_adver_item_avata' src='{{avata}}' alt='titlese'>
    <br>
    <span class='radius_none post_adver_item_title'>{{title}}</span>
</a>
EOD;
        $ar_patern=Array
        (
            '{{link}}'=>$adver_row->m_link,
            '{{title}}'=>str_to_view($adver_row->m_title),
            '{{titlese}}'=>str_to_view($adver_row->m_title, false),
            '{{avata}}'=>$this->AdvertimentModel->get_avata($adver_row->id),
        );
        echo str_replace(array_keys($ar_patern), array_values($ar_patern), $str_adver);
    }
?>