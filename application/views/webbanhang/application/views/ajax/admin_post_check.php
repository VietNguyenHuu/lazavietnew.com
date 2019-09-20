<?php 
	if($this->UserModel->get($idname,'m_level')>2)
	{
		$id=$this->input->post('check_id');
        $post_row=$this->PostContentModel->get_row($id);
        if($post_row==false)
        {
            echo "Bài viết không khả dụng để duyệt";
        }
        else if($post_row->m_id_user_check!=-1)
        {
            echo "Bài viết đã được duyệt trước đó";
        }
        else
        {
            if($this->PostContentModel->set($id,'m_id_user_check',$idname)==false)
            {
                echo "Tác vụ thất bại";
            }
            else
            {
                $add_score=(int)($this->input->post('add_score'));
                $this->PostContentModel->set($id,'m_status','public');
                
                $title=$post_row->m_title;
                $bonus_score=0;
                $temp_author=$this->PostAuthorModel->filter('m_id_user',$post_row->m_id_user);
                if($temp_author!=false)
                {
                    $bonus_score=$temp_author[0]->m_score_multi;
                }
                $bonus_score= (int)$this->SystemParamModel->get('Post_bonus_score_write', 'm_value') +$bonus_score+$add_score;
                $new_user_score=$this->UserModel->bonus_score($post_row->m_id_user,$bonus_score);
                echo "Đã duyệt bài viết <span class='stt_tip'>".$title."</span>";
                echo "<br>Đã cộng ".($bonus_score)." điểm cho ".$this->UserModel->get($post_row->m_id_user,'m_realname');
                //gởi tin nhắn cho tác giả nếu cài đặt cho phép gởi
                $mg = $this->SystemParamModel->get('Post_mg_when_check', 'm_value');
                if($mg != "" && $mg != false)
                {
                    $nd = mystr()->get_from_template(
                        $mg, 
                        [
                            '{{link}}' => $this->PostContentModel->get_link_from_id($post_row->id),
                            '{{bonus_score}}' => $bonus_score
                        ]
                    );
                    $temp_id_tn = $this->TinNhanModel->add(Array(
                        'id_user_from'=>$idname,
                        'id_user_to'=>$post_row->m_id_user,
                        'content'=>$nd
                   ));
                   if($temp_id_tn!=false)
                   {
                        echo "<p class='stt_tip fontsize_d2'>Tin nhắn thông báo duyệt đã được gởi tới tác giả.</p>";
                   }
                }
                //end gởi tin nhắn
            }
        }
	}
	else
	{
		echo "Cần quyền quản trị";
	}
?>