<?php
    if($idname==false)
    {
        echo "<div class='stt_mistake'>Đăng nhập để viết tin nhắn</div>";
    }
    else
    {
        $realname=$this->input->post('realname');
        if($realname==""||$realname=='undefined')
        {
            echo "<div class='stt_mistake'>Hãy nhập tên để tìm kiếm</div>";
        }
        else
        {
            $realname=trichdan($realname,30);
            $list=$this->db->query("SELECT * FROM ".$this->UserModel->get_table_name()." WHERE MATCH(m_realname_search)AGAINST('".mystr()->addmask($realname)."')")->result();
            if(count($list)<0)
            {
                echo "<div class='stt_mistake'>Không tìm thấy thành viên nào !</div>";
            }
            else
            {
                echo "<div class='padding_v'><i class='fa fa-folder-open'></i> Tìm được ".count($list)." thành viên, nhấn vào tên để chọn</div>";
                echo "<div class='list'>";
                    foreach($list as $key=>$value)
                    {
                        echo "<div class='width_40 padding tin_nhan_new_form_to_search_result_item' data-id='".$value->id."'><div class='stt_action stt_avaiable font_roboto bg_highlight padding' onclick=\"tin_nhan.soantin_add_to(".$value->id.",'".str_to_view($value->m_realname,false)."','".$this->UserModel->get_avata($value->id)."')\"><img src='".$this->UserModel->get_avata($value->id)."' class='align_middle' style='height:1.5em;width:1.5em'><span class='margin_l align_middle'>".str_to_view($value->m_realname)."</span></div></div>";
                    }
                    echo "<div class='clear_both'></div>";
                echo "</div>";
            }
        }
    }
?>