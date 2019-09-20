<?php
    $ar_patern=array(
        '{{postlink}}'=>"",
        '{{posttitle}}'=>"...",
        '{{posttitlese}}'=>"...",
        '{{postavata}}'=>"assets/img/system/lazyload.gif",
        '{{posttypelink}}'=>"",
        '{{posttypetitle}}'=>"...",
        '{{posttypetitlese}}'=>"...",
        '{{postago}}'=>"...",
        '{{postcustomstatistic}}'=>""
    );
    echo str_replace(array_keys($ar_patern), array_values($ar_patern), $this->PostContentModel->get_layout_item());
?>