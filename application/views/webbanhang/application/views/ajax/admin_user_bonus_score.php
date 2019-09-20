<?php 
	$id=$this->input->post('id_user');
    $score=(int)$this->input->post('score');
	$str="";
	if(!$this->UserModel->check_exit($id))
	{
		$str.="Thành viên không tồn tại";
	}
    else if($this->UserModel->get($idname,'m_level')<=$this->UserModel->get($id,'m_level')||$this->UserModel->get($idname,'m_level')<3)
    {
        $str.="Tác vụ không được phép";
    }
	else
	{
	   if($score==0)
       {
            echo "<span class='stt_mistake'>Đã thoát khỏi tác vụ</span>";
       }
       else
       {
            $new_score=$this->UserModel->bonus_score($id,$score);
            if($new_score===false)
            {
                echo "<span class='stt_mistake'>Tác vụ thất bại, hãy thực hiện lại</span>";
            }
            else
            {
                echo "<span class='stt_avaiable'>Đã cộng ".$score." điểm.</span>";
                $score_note=$this->input->post('score_note');
                if($score_note==""&&$score_note=="undefined")
                {
                    $score_note="Không có ghi chú.";
                }
                $temp_id_tn=$this->TinNhanModel->add(Array(
                    'id_user_from'=>$idname,
                    'id_user_to'=>$id,
                    'content'=>"Bạn được cộng ".$score." điểm, Ghi chú: ".$score_note
               ));
            }
       }
	}
?>