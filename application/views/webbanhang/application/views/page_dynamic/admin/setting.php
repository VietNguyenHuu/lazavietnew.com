<?php

if ($this->UserModel->get($idname, 'm_level') > 3) {
    $shortcut_items = "";
    $auto_hide_grids = "";
    $shortcut_temp = $this->load->design('block/admin/shortcut_item.html');
    $grid_temp = $this->load->design('block/admin/auto_hide_grid.html');
    
    $ar_shortcut = [
        Array(
            'icon' => 'newspaper-o',
            'title' => 'Trang tĩnh',
            'bg' => '#efef69',
            'id' => 'admin_setting_mainmenu',
            'content' => $this->load->design('block/admin/setting/mainmenu.html')
        ),
        Array(
            'icon' => 'file-sound-o',
            'title' => 'Quảng cáo',
            'bg' => '#ef99ff',
            'id' => 'admin_setting_adver',
            'content' => $this->load->design('block/admin/setting/adver.html')
        ),
        Array(
            'icon' => 'support',
            'title' => 'Hỗ trợ',
            'bg' => '#74c8f1',
            'id' => 'admin_setting_support',
            'content' => $this->load->design('block/admin/setting/support.html')
        ),
        Array(
            'icon' => 'user',
            'title' => 'Phản hồi',
            'bg' => '#f7afa4',
            'id' => 'admin_setting_report',
            'content' => $this->load->design('block/admin/setting/report.html')
        ),
        Array(
            'icon' => 'comments',
            'title' => 'Lời nhắn',
            'bg' => '#f18599',
            'id' => 'admin_setting_message',
            'content' => $this->load->design('block/admin/setting/message.html')
        ),
        Array(
            'icon' => 'rss',
            'title' => 'Sitemap',
            'bg' => '#f1f196',
            'id' => 'admin_setting_sitemap',
            'content' => $this->load->design('block/admin/setting/sitemap.html')
        ),
        Array(
            'icon' => 'history',
            'title' => 'Cache',
            'bg' => '#f1f196',
            'id' => 'admin_setting_cache',
            'content' => $this->load->design('block/admin/setting/cache.html')
        )
    ];
    foreach ($ar_shortcut as $line) {
        $shortcut_items .= mystr()->get_from_template(
            $shortcut_temp,
            [
                '{{bg}}' => $line['bg'],
                '{{id}}' => $line['id'],
                '{{title}}' => $line['title'],
                '{{iconclass}}' => 'fa-' . $line['icon']
            ]
        );
        $auto_hide_grids .= mystr()->get_from_template(
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
        [
            '{{title}}' => 'Cài đặt Hệ thống',
            '{{shortcut_items}}' => $shortcut_items,
            '{{auto_hide_grids}}' => $auto_hide_grids
        ]
    );
}