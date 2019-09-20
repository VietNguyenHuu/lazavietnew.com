<?php
    $user=$this->UserModel;
    if($this->UserModel->get($idname,'m_level')>2)
    {
        $str="<div name='admin_content_header'>Quản lý nội dung </div>";
    	$str.="<div name='admin_content_body'>";
        $ar=Array(
            Array('icon'=>'bell','title'=>'Thông báo','bg'=>'#efef69','linked'=>'thong_bao'),
            Array('icon'=>'pencil','title'=>'Bài viết','bg'=>'#ef99ff','linked'=>'bai_viet'),
            Array('icon'=>'pencil','title'=>'Nhóm bài viết','bg'=>'#feaaff','linked'=>'nhom_bai_viet'),
            Array('icon'=>'folder-open','title'=>'Danh mục','bg'=>'#74c8f1','linked'=>'danh_muc'),
            Array('icon'=>'user','title'=>'Tác giả','bg'=>'#f7afa4','linked'=>'tac_gia'),
            Array('icon'=>'bug','title'=>'Mẫu phản hồi','bg'=>'#f18599','linked'=>'phan_hoi'),
            Array('icon'=>'bug','title'=>'Phản hồi','bg'=>'#f18599','linked'=>'phan_hoi_content'),
            Array('icon'=>'ellipsis-h','title'=>'Tác vụ khác','bg'=>'#f1f196','linked'=>'khac')
        );
        $str.="<div class='padding_v margin_v toggle_hide_box'>";
            foreach($ar as $line)
            {
                $str.="<div class='width3 width3_0_6 width3_480_4 width3_1024_2 padding align_center'><div class='padding stt_action' style='background-color:".$line['bg']."' onclick='$(\".toggle_hide_box_linked_".$line['linked']."\").toggleClass(\"hide\");$(\".toggle_hide_box\").addClass(\"hide\")'><i class='fa fa-".$line['icon']." fa-3x'></i><br><span class='fontsize_a2'>".$line['title']."</span></div></div>";
            }
            $str.="<div class='clear_both'></div>";
        $str.="</div>";
        
        $ar_grid=Array(
            'thong_bao'=>Array('id'=>'admin_post_alert_cover','content'=>""),
            'bai_viet'=>Array('id'=>'admin_post_content','content'=>""),
            'nhom_bai_viet'=>Array('id'=>'admin_post_group_content','content'=>""),
            'danh_muc'=>Array('id'=>'admin_post_type','content'=>""),
            'tac_gia'=>Array('id'=>'admin_post_author','content'=>""),
            'phan_hoi'=>Array('id'=>'admin_post_report','content'=>""),
            'phan_hoi_content'=>Array('id'=>'admin_post_report_content','content'=>""),
            'khac'=>Array('id'=>'admin_post_other','content'=>"")
        );
        $this->load->library("html/html");
        
        $ar_grid['thong_bao']['content']="<div class='padding_v'><i class='fa fa-bell-o stt_tip admin_post_alert_real_time' data-detail='' onclick='admin_post_alert.realtime_detail()'></i> <spam class='button padding fontsize_d2' onclick='admin_post_alert.update()'><i class='fa fa-refresh'></i> Làm mới</span></div>";
        $ar_grid['thong_bao']['content'].="<div id='admin_post_alert'>";
        $ar_grid['thong_bao']['content'].="</div>";
        
        $ar_grid['danh_muc']['content'].="<div class='margin_v padding_v'>";
            $ar_grid['danh_muc']['content'].="<span class='button padding' onclick='admin_post_type.loadlist(1);$(this).addClass(\"hide\")'><i class='fa fa-list'></i> Tải danh mục</span>";
        $ar_grid['danh_muc']['content'].="</div>";
        $ar_grid['danh_muc']['content'].="<div id='admin_post_type_list'></div>";
                
        $ar_grid['bai_viet']['content'].="<div class='padding_v line_height_2'>";
        $ar_grid['bai_viet']['content'].="<input class='margin_b' type='text' id='admin_post_content_search_input' value='' placeholder='Tìm tên bài viết'>";
        $ar_grid['bai_viet']['content'].="<select class='margin_b margin_r' id='admin_post_content_ischeck'>";
            $ar_grid['bai_viet']['content'].="<option value='all'>Tất cả</option>";
            $ar_grid['bai_viet']['content'].="<option value='checked'>Đã duyệt</option>";
            $ar_grid['bai_viet']['content'].="<option value='wait_check'>Chờ duyệt</option>";
            $ar_grid['bai_viet']['content'].="<option value='deleted'>Thùng rác</option>";
        $ar_grid['bai_viet']['content'].="</select>";
        $ar_grid['bai_viet']['content'].="<span class='button padding margin_b' onclick='admin_post_content.loadlist(1)'>Tải danh sách</span>";
        $ar_grid['bai_viet']['content'].="</div>";
        $ar_grid['bai_viet']['content'].="<div class='clear_both'></div>";
        $ar_grid['bai_viet']['content'].="<div id='admin_post_content_list'></div>";
        
        $ar_grid['nhom_bai_viet']['content'].="<div class='padding_v line_height_2 '>";
        $ar_grid['nhom_bai_viet']['content'].="<input class='margin_b' type='text' id='admin_post_group_search_input' value='' placeholder='Tìm nhóm bài viết'>";
        $ar_grid['nhom_bai_viet']['content'].="<span class='button padding margin_b margin_r1em' onclick='admin_post_group.loadlist(1)'><i class='fa fa-list'></i> Tải danh sách</span>";
        $ar_grid['nhom_bai_viet']['content'].="<span class='button padding' onclick='admin_post_group.load_form_add()'><i class='fa fa-plus'></i> Thêm nhóm</span>";
        $ar_grid['nhom_bai_viet']['content'].="</div>";
        $ar_grid['nhom_bai_viet']['content'].="<div id='admin_post_group_list'></div>";
        
        $ar_grid['tac_gia']['content'].="<div class='margin_v padding_v'>";
            $ar_grid['tac_gia']['content'].="<span class='button padding' onclick='admin_post_author.loadlist(1)'><i class='fa fa-list'></i> Tải danh sách</span> ";
            $ar_grid['tac_gia']['content'].="<span class='button padding' onclick='admin_post_author.load_form_add()'>+ Thêm tác giả</span> ";
        $ar_grid['tac_gia']['content'].="</div>";
        $ar_grid['tac_gia']['content'].="<div class='margin_t' id='admin_post_author_list'></div>";
        
        $ar_grid['phan_hoi']['content'].="<div class='margin_v padding_v'>";
            $ar_grid['phan_hoi']['content'].="<span class='button padding' onclick='admin_post_report_pattern.loadlist(1)'><i class='fa fa-list'></i> Tải danh sách</span> ";
            $ar_grid['phan_hoi']['content'].="<span class='button padding' onclick='admin_post_report_pattern.load_form_add()'>+ Thêm Mẫu</span> ";
        $ar_grid['phan_hoi']['content'].="</div>";
        $ar_grid['phan_hoi']['content'].="<div class='margin_t' id='admin_post_report_pattern_list'></div>";
        
        $ar_grid['khac']['content']="";
        $temp=$this->SystemParamModel->get('admin_post_content_lastresetview','m_value');
        if($temp!==false)
        {
            if($temp===false||((int)$temp)<time()-24*60*60)//quá 24 giờ
            {
                $ar_grid['khac']['content'].="<div class='padding line_height_2'><span class='button padding' onclick='admin_post_content.reset_view()'>Reset view</span><span class='stt_tip'>Chạy một lần trong ngày để cập nhật lượng xem</span></div><div class='clear_both'></div>";
            }
        }
        
        $ar_grid['phan_hoi_content']['content'] = ""
        . Html::div(['class'=>'padding_v'])->setHtml(
                Html::span([
                    'class' => 'button padding fontsize_d2',
                    'onclick' => 'admin_post_report_content.loadlist(1)'
                ])->setHtml("<i class='fa fa-list'></i> Tải danh sách")->out()
        )->out()
        . Html::div(['id'=>'admin_post_report_content_list'])->out();
        
        $str_auto_hide_grid="<div class='grid_header_label grid_header_control disable' onclick='$(\".toggle_hide_box\").removeClass(\"hide\");$(\".toggle_hide_box_linked\").addClass(\"hide\");'><i class='fa fa-times' title='Ẩn'></i></div>";
        foreach($ar as $line)
        {
            if(isset($ar_grid[$line['linked']]))
            {
                $grid=$ar_grid[$line['linked']];
                $str.="<div class='hide toggle_hide_box_linked toggle_hide_box_linked_".$line['linked']."'><div id='".$grid['id']."'>";
                    $str.="<div class='grid'>";
                        $str.="<div class='grid_header' style='padding-left:10px'><div class='grid_header_label' style='margin-left:0px;padding-left:0px'>".$line['title']."</div>".$str_auto_hide_grid."<div class='clear_both'></div></div>";
                        $str.="<div class='grid_content' style='padding-left:10px'>";
                            $str.=$grid['content'];
                        $str.="</div>";
                    $str.="</div>";
                $str.="</div></div>";
            }
        }
    	$str.="</div>";
    	echo $str;
    }