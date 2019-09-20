<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $image=$this->input->post('image');
        $avata=explode(";base64,",$image);
        if(count($avata>1))
        {
            $avata_metadata=$avata[0];
            $avata=$avata[1];
        	$avata=base64_decode($avata);
            $file_type=false;
            foreach($this->config->item('myconfig_array_image_filetype') as $key => $value)
            {
                if("data:".$value==$avata_metadata)
                {
                    $file_type=$key;
                }
            }
            if($file_type==false)
            {
                $file_type='gif';
            }
            $filepath="assets/img/system/favico_temp_".time().".".$file_type;
			file_put_contents($filepath,$avata);
            if(file_exists($filepath))
            {
                $thumb=image_helper()->resize($filepath,"assets/img/system/favico",Array('width'=>200,'height'=>200,'crop'=>'cut','type'=>'png'));
                unlink($filepath);
                echo "<div class='stt_highlight'>Đã cập nhật ảnh logo<div class='padding_v'><span class='stt_action' onclick='javascript:window.location=location.href;'>Tải lại trang để xem thay đổi</span></div></div>";
            }
            else
            {
                echo "<div class='stt_mistake'>Không cập nhật được logo mới</div>";
            }
        }
    }
?>