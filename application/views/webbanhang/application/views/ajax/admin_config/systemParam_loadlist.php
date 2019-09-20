<?php
if ($this->UserModel->getLevel($idname) > 3){
    $ar = [
        '{{total}}' => '',
        '{{numpage}}' => 1,
        '{{items}}' => '',
        '{{paging}}' => ''
    ];
    $sql = 'SELECT * FROM '.$this->SystemParamModel->get_table_name(). " ORDER BY m_name ASC";
    $params = $this->db->query($sql)->result();
    if ($params == null){
        $ar['{{items}}'] = 'Không có thông số hệ thống nào trên hệ thống !';
        $ar['{{total}}'] = 0;
    } else {
        $ar['{{total}}'] = count($params);
        $item_template = $this->load->design('block/admin/config/system_param_list_item.html');
        foreach ($params as $key => $line){
            $ar['{{items}}'] .= mystr()->get_from_template(
                $item_template, 
                [
                    '{{title}}' => $line->m_name,
                    '{{value}}' => $line->m_value,
                    '{{comment}}' => $line->m_comment
                ]
            );
        }
        
    }
    echo mystr()->get_from_template(
        $this->load->design('block/admin/config/system_param_list.html'),
        $ar
    );
}