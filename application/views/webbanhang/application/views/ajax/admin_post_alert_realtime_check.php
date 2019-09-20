<?php
    $str="";
    $list_post_wait=$this->db->query("SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user_check=-1")->num_rows();
    if($list_post_wait>0)
    {
        $str.=str_replace("'","\'","<div>Có ".$list_post_wait." bài viết đang chờ duyệt !</div>");
    }
    if($str=="")
    {
        echo '-1';
    }
    else
    {
        echo $str;
    }
?>