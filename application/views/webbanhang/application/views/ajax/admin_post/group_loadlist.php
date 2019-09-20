<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $list=$this->db->query("SELECT * FROM ".$this->PostGroupModel->get_table_name()." ORDER BY id DESC")->result();
        if(count($list)>0&&$list!=null&&$list!=false)
        {
            echo "<div class='list'>";
            $temp_template = $this->load->design('block/admin/post/group_item.html');
            foreach($list as $key=>$item)
            {
                echo mystr()->get_from_template(
                    $temp_template, 
                    [
                        '{{m_title}}' => $item->m_title,
                        '{{id}}' => $item->id,
                        '{{text_linethrough}}' => ($item->m_status == 'trash') ? "text_linethrough" : '',
                        '{{deltype}}' => ($item->m_status != 'trash') ? 'del' : 'del_penaty'
                    ]
                );
            }
            echo "</div>";
        }
        else
        {
            echo "<div class='stt_tip'>Chưa có nhóm bài viết nào</div>";
        }
    }
?>