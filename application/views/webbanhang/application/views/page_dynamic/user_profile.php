<div class="width_max1300px">
<?php
    $user_row=$this->UserModel->get_row($data['id_user']);
    if($user_row!=false)
    {
        $str="";
        $str.="<div class='dn_grid2 user_profile'>";
            $str.="<div class='dn_grid2_header'><div class='dn_grid2_box'>";
                $str.="<img class='lazyload radius_50 avata' data-original='".$this->UserModel->get_avata($data['id_user'])."' alt='".str_to_view($user_row->m_realname)."'>";
                $str.="<h1 class='font_roboto'>".str_to_view($user_row->m_realname)."</h1>";
            $str.="</div></div>";
            $str.="<div class='dn_grid2_content'><div class='dn_grid2_box'>";
                $str.="<div>".get_str_like_fb($page_fb_url)."<span class='margin_t margin_l' style='position:relative;top:0.5em;'>".get_str_like_google()."</span></div>";
                $str.="<div class='margin_t padding_v'><b class='font_roboto'>Thông tin thêm</b></div>";
                $str.="<div class='font_roboto'>Điểm thưởng: ".valid_money($user_row->m_score)."</div>";
            $str.="</div></div>";
        $str.="</div>";
        
        
        
        $str.="";
        $str.="";
        $str.="";
        $str.="";
        $str.="";
        $str.="";
        echo $str;
    }
    else
    {
        echo "<div class='stt_tip'>Thành viên không khả dụng vào lúc này</div>";
    }
?>
</div>