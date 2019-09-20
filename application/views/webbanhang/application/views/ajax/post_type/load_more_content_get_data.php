<?php
    $posttype=(int)$this->input->post("posttype");
    $lastpostrow=$this->PostContentModel->get_row((int)$this->input->post("lastpostid"));
    $direct=$this->input->post("direct");
    $temp_content="";
    if($direct=="right")
    {
        $direct="<";
    }
    else
    {
        $direct=">";
    }
    if($lastpostrow != false)
    {
        //tải thêm 3 bài viết cùng chủ đề với bài viết này
        $addedid=Array();
        array_push($addedid,$lastpostrow->id);
        $ar_content=$this->db->query("SELECT * FROM ".$this->PostContentModel->get_table_name()." WHERE id!=".$lastpostrow->id." AND m_status='public' AND m_id_type=".$lastpostrow->m_id_type." AND m_militime ".$direct." ".$lastpostrow->m_militime." ORDER BY m_militime DESC LIMIT 0,3")->result();
        $max=count($ar_content);
        $needadd=3;
        if($max>0&&$ar_content!=null&&$ar_content!=false)
        {
            $max_temp=min(3,$max);
            for($i=0;$i<$max_temp;$i++)
            {
                $needadd--;
                array_push($addedid,$ar_content[$i]->id);
                $temp_content.="<div class='width_40 padding post_content_item_box' data-id='".$ar_content[$i]->id."'>";
                    $temp_content.=$this->PostContentModel->get_str_item($ar_content[$i]);
                $temp_content.="</div>";
            }
        }
        //lấp đầy 4 bài viết bằng các bài viết khác
        if($needadd>0)
        {
            $list_type=Array();//mảng các chủ đề thuộc phạm vi chủ đề hiện tại
            $this->PostTypeModel->get_list_type($list_type,$posttype);
            $ar_content=$this->db->query("SELECT * FROM ".$this->PostContentModel->get_table_name()." WHERE id NOT IN(".implode(',',$addedid).") AND m_status='public' AND m_id_type IN(".implode(',',$list_type).") AND m_militime ".$direct." ".$lastpostrow->m_militime." ORDER BY m_militime DESC LIMIT 0,".$needadd)->result();
            $max=count($ar_content);
            $needadd=3;
            if($max>0&&$ar_content!=null&&$ar_content!=false)
            {
                $max_temp=min($needadd,$max);
                for($i=0;$i<$max_temp;$i++)
                {
                    $temp_content.="<div class='width_40 padding post_content_item_box' data-id='".$ar_content[$i]->id."'>";
                        $temp_content.=$this->PostContentModel->get_str_item($ar_content[$i]);
                    $temp_content.="</div>";
                }
            }
        }
    }
    echo $temp_content;
?>