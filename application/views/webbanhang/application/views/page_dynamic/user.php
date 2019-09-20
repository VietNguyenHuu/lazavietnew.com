<div class="width_max1300px">
<?php
    $str="";
    if($this->UserModel->check_exit($idname)==false)
	{
		$str.="<div class='mistake'>Trang cá nhân không khả dụng</div>";
	}
	else
	{
	   $id=$idname;
       $user=$this->UserModel;
       $str_layout=<<<EOD
<div class='grid'>
    <div class='grid_header'>
        <div class='grid_header_label'>Thông tin cá nhân</div>
        <div class='clear_both'></div>
    </div>
    <div class='grid_content padding user_info_view'>
        <div class='width3 width3_0_12 width3_720_6 width3_980_3 padding'>
            <div class='padding fontsize_a2 user_block_header'>Thông tin cơ bản</div>
             <div class='user_block_content user_block_basic'>
                <input type='file' class='hide' id='user_info_view_avata_input' onchange='user_info.set_avata(this)'>
                <img class='user_info_view_avata' src='{{useravata}}'>
                <p><i class='fa fa-user'></i> {{userrealname}} - {{useryear}} ({{userlevellabel}})</p>
                <span class='stt_highlight stt_action' onclick="$('#user_info_view_avata_input').click()"><i class='fa fa-camera bg_highlight stt_action'></i> Cập nhật hình đại diện</span>
                <p><a href='{{userlinkpublic}}' title='xem trang ở chế độ công khai'><i class='fa fa-globe'></i> Xem trang công khai</a></p>
             </div>
        </div>
        <div class='width3 width3_0_12 width3_720_6 width3_980_3 padding'>
            <div class='padding fontsize_a2 user_block_header'>Thông tin tài khoản</div>
             <div class='user_block_content user_block_money'>
                Số dư : {{usermoney}} vnđ 
                <p class='padding_v margin_t line_height_2'><span class='button padding'> Nạp tiền </span></p>
             </div>
        </div>
        <div class='width3 width3_0_12 width3_720_6 width3_980_3 padding'>
            <div class='padding fontsize_a2 user_block_header'>Điểm tích luỹ</div>
             <div class='user_block_content user_block_score'>
                Điểm tích lũy : {{userscore}} Điểm
                <p class='padding_v margin_t line_height_2'><span class='button padding' onclick='user_action.load_form_into_money()'>Đổi thành tiền</span></p>
             </div>
        </div>
        <div class='width3 width3_0_12 width3_720_6 width3_980_3 padding'>
            <div class='padding fontsize_a2 user_block_header'>Hoạt động</div>
             <div class='user_block_content user_block_action'>
                ...
             </div>
        </div>
        <div class='clear_both'></div>
    </div>
</div>
EOD;
        $user_row=$user->get_row($id);
        $ar_patern=Array(
            '{{useravata}}'=>$user->get_avata_original($id),
            '{{userrealname}}'=>str_to_view($user_row->m_realname),
            '{{useryear}}'=>$user_row->m_birth,
            '{{userlevellabel}}'=>str_replace(Array('1','2','3','4','5'),Array('Thành viên','Thành viên vip','Cộng tác viên','Quản trị viên','admin'),$user_row->m_level),
            '{{userlinkpublic}}'=>$user->get_link_from_id($id),
            '{{usermoney}}'=>valid_money($user_row->m_money),
            '{{userscore}}'=>valid_money($user_row->m_score)
        );
        echo str_replace(array_keys($ar_patern), array_values($ar_patern), $str_layout);
		
		$str.="<fieldset class='bg_highlight' name='user_info'><legend><i class='fa fa-pencil'></i> Chỉnh sửa thông tin cá nhân</legend>";
    		$str.="<div name='user_info_id' style='display:none;'>".$id."</div>";
    		$str.="<div class='width_50'>";
    			$str.="<div class='item'><span class='label'>Họ và tên </span><input type='text' value='".$user->get($id,'m_realname')."' id='register_realname' placeholder='vd: Nguyễn Văn A' name='register_realname' onchange='kt_realname()'><div id='register_check_realname' class='check'></div></div>";
    			if($user->get($id,'m_sex')==1){$add="";}else{$add="selected='selected'";}
    			$str.="<div class='item'><span class='label'>Giới tính </span><select name='register_sex'><option value=1>Nam</option><option value=0 ".$add.">Nữ</option></select></div>";
    			$str.="<div class='item' style='margin-bottom:20px;'><span class='label'>Năm sinh </span><select name='register_year'>";
    			for($i=2000;$i>1970;$i--)
    			{
    				if($i!=$user->get($id,'m_birth')){$add="";}else{$add="selected='selected'";}
    				$str.="<option value=".$i." ".$add.">".$i."</option>";
    			}
    			$str.="</select></div>";
    			$str.="<div class='item'><span class='label'>Đổi mật khẩu </span><input type='password' value='' id='register_oldpass' placeholder='mật khẩu cũ' name='register_oldpass' style='width:45%;max-width:200px;'><input type='password' value='' id='register_newpass' placeholder='mật khẩu mới' name='register_newpass' onchange='kt_newpass()' style='width:45%;max-width:200px;'><div id='register_check_newpass' class='check'></div></div>";
    		$str.="</div>";
    		$str.="<div class='width_50'>";
    			$str.="<div class='item'><span class='label'>Số điện thoại </span><input type='text' value='".$user->get($id,'m_phone')."' placeholder='vd: 01653302304' id='register_phone' name='register_phone' onchange='kt_phone()'><div id='register_check_phone' class='check'></div></div>";
    			$str.="<div class='item'><span class='label'>Địa chỉ email </span><input type='text' value='".$user->get($id,'m_email')."' id='register_email' placeholder='vd: dinhnam2901@gmail.com' name='register_email' onchange='kt_email()'><div id='register_check_email' class='check'></div></div>";
    			$str.="<div class='item' style='margin-bottom:20px;'><span class='label'>Tỉnh / Thành phố </span><select name='register_province'>";
    				$data=$this->ProvinceCodeModel->getAll();
                    $max=count($data);
    				if($max<1)
    				{
    					$str.= "<span class='mistake'>Không có danh sách khu vực !</span>";
    				}
    				else
    				{
    					for($i=0;$i<$max;$i++)
    					{
    						if($data[$i]->m_code!=$user->get($id,'m_province_code')){$add="";}else{$add="selected='selected'";}
    						$str.="<option value=".$data[$i]->m_code." ".$add.">".$data[$i]->m_title."</option>";
    					}
    				}
    			$str.="</select></div>";
    			$str.="<div class='item'><span class='label'>Địa chỉ </span><input type='text' value='".$user->get($id,'m_address')."' placeholder='vd: 123 cách mạng tháng tám, quận 10' id='register_address' name='register_address'></div>";
    		$str.="</div>";
    		
    		$str.="<div class='clear_both'></div>";
            $str.="<div name='user_info_status'><span class='float_right padding stt_action' style='background-color:#aaaaaa;color:#000000;margin:5px;border-radius:10px;' onclick='user_info.hide_updatestatus()'>&nbsp;x&nbsp;</span><div name='user_info_status_content'></div><div class='clear_both'></div></div>";
    		$str.="<div class='align_center' style='padding:5px;margin-top:20px;'><span class='button' style='padding:5px;' onclick='user_info.update()'> Cập nhật thông tin </span></div>";
		
		$str.="</fieldset>";
		
	}
	echo $str;
?>
</div>