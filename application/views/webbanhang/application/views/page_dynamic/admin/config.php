<?php
if ($this->UserModel->get($idname, 'm_level') > 3) {
    $ar_content = [
        '{{title}}' => 'Cấu hình website',
        '{{shortcut_items}}' => '',
        '{{auto_hide_grids}}' => ''
    ];
    
    $ar_shortcut = Array(
        Array(
            'icon' => 'newspaper-o',
            'title' => 'Logo icon', 
            'bg' => '#efef69', 
            'id' => 'admin_config_logo',
            'content' => $this->load->design('block/admin/config/logo.html')
        ),
        
        Array(
            'icon' => 'code', 
            'title' => 'System param', 
            'bg' => '#ef99ff', 
            'id' => 'admin_config_system_param',
            'content' => $this->load->design('block/admin/config/system_param.html')
        )
    );
    
    $shortcut_temp = $this->load->design('block/admin/shortcut_item.html');
    $grid_temp = $this->load->design('block/admin/auto_hide_grid.html');
    foreach ($ar_shortcut as $line) {
        $ar_content['{{shortcut_items}}'] .= mystr()->get_from_template(
            $shortcut_temp,
            [
                '{{bg}}' => $line['bg'],
                '{{id}}' => $line['id'],
                '{{title}}' => $line['title'],
                '{{iconclass}}' => 'fa-' . $line['icon']
            ]
        );
        $ar_content['{{auto_hide_grids}}'] .= mystr()->get_from_template(
            $grid_temp,
            [
                '{{id}}' => $line['id'],
                '{{title}}' => $line['title'],
                '{{content}}' => $line['content']
            ]
        );
    }
    
    echo mystr()->get_from_template(
        $this->load->design('block/admin/content.html'),
        $ar_content
    );
}