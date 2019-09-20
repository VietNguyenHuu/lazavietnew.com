<div class="width_max1300px">
<?php
    $str_menu="";
    $ar_action=Array(
        'ql_statistic'=>Array(
                                'label'=>"<i class='fa fa-line-chart'></i><span class='submenu_item_title'> Thống kê website</span>",
                                'quyen'=>3,
                                'link'=>site_url('admin/statistic')
                            ),
        'ql_setting'=>Array(
                                'label'=>"<i class='fa fa-cogs'></i><span class='submenu_item_title'> Cài đặt hệ thống</span>",
                                'quyen'=>4,
                                'link'=>site_url('admin/setting')
                            ),
        'ql_config'=>Array(
                                'label'=>"<i class='fa fa-sliders'></i><span class='submenu_item_title'> Cấu hình website</span>",
                                'quyen'=>3,
                                'link'=>site_url('admin/config')
                            ),     
        'ql_user'=>Array(
                                'label'=>"<i class='fa fa-users'></i><span class='submenu_item_title'> Quản lý thành viên</span>",
                                'quyen'=>4,
                                'link'=>site_url('admin/user')
                            ),
         
         'ql_post'=>Array(
                                'label'=>"<i class='fa fa-pencil'></i><span class='submenu_item_title'> Quản lí nội dung</span>",
                                'quyen'=>3,
                                'link'=>site_url('admin/post')
                            )
                
    );
    foreach ( $ar_action as $key => $value ) {
        if($this->UserModel->get($idname,'m_level')>=$value['quyen'])//có quyền thao tác với chức năng hiện tại
        {
            $temp_current="";
            if(strpos($value['link'],current_url())!==false)
            {
                $temp_current=" current ";
            }
            $str_menu.= "<a class='font_roboto submenu_item".$temp_current."' href='".$value['link']."'>".$value['label']."</a>";
        }
    }
    $str_menu.="<div class='clear_both'></div>";
?>
<div class="admin_contaner">
<div class='admin_navi_left'><div class="admin_navi_left_fix_minheight">
    <div class='align_middle admin_navi_left_header'>
        <i class='fa fa-tachometer fa-lg align_middle'></i> 
        <span class="align_middle">Quản lý</span>
        <i class="fa fa-angle-left admin_navi_left_minium_toggle_btn" title='Thu / phóng menu' onclick="$(this).parents('.admin_navi_left').toggleClass('minium');$(this).toggleClass('fa-rotate-180')"></i>
    </div>
    <?php echo $str_menu;?>
</div></div>
<div class='admin_content'>
<?php 
	if(isset($data['adminPage']))
    {
        if(file_exists(VIEWPATH . "page_dynamic/admin/" . $data['adminPage'] . '.php'))
        {
            include_once(VIEWPATH . "page_dynamic/admin/" . $data['adminPage'] . '.php');
        }
    }
?>
</div>
<div class="clear_both"></div>
</div>
</div>