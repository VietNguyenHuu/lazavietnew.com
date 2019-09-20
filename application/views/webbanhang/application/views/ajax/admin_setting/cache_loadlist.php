<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $num_list=$this->db->query("SELECT m_name FROM ".$this->CacheModel->get_table_name())->num_rows();
        if($num_list<1)
        {
            echo "<div class='stt_tip'>Hiện chưa có cache trong hệ thống</div>";
        }
        else
        {
            $page=(int)$this->input->post('page');
            if($page<1)
            {
                $page=1;
            }
            echo "<div class='fontsize_a2 padding'><i class='fa fa-folder-o'></i> Tất cả <b>".$num_list."</b> cache trong hệ thống</div>";
            $phantrang=page_seperator($num_list,$page,40,Array('class_name'=>'page_seperator_item','strlink'=>'javascript:admin_setting_cache.loadlist([[pagenumber]])'));
            $list=$this->db->query("SELECT * FROM ".$this->CacheModel->get_table_name()." ORDER BY m_name LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
            if(count($list)<1)
            {
                echo "<div class='stt_tip'>Hiện chưa có cache ở trang này</div>";
            }
            else
            {
                echo "<div class='list'>";
                foreach($list as $key=>$list_item)
                {
                    echo "<div class='item'><span class='stt_tip'>".(($page-1)*40+$key+1)." - </span>".$list_item->m_name."<div class='float_right'><i class='fa fa-info-circle stt_action stt_tip' onclick=\"admin_setting_cache.loadinfo('".$list_item->m_name."')\" title='Xem chi tiết'></i>&nbsp;&nbsp;&nbsp;<i class='fa fa-trash-o stt_action stt_mistake' onclick=\"admin_setting_cache.del('".$list_item->m_name."')\" title='Xóa'></i></div><div class='clear_both'></div></div>";
                }
                echo "</div>";
            }
        }
    }
?>