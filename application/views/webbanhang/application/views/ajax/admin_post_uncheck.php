<?php 
	if($this->UserModel->get($idname,'m_level')>2)
	{
		$id=$this->input->post('check_id');
        if(in_array('uncheck',$this->PostContentModel->get_permission($idname,$id)))
        {
            if($this->PostContentModel->set($id,'m_id_user_check',-1)==false)
            {
                echo "Tác vụ thất bại";
            }
            else
            {
                $this->PostContentModel->set($id,'m_status','ready');
                $post_row=$this->PostContentModel->get_row($id);
                $bonus_score=0;
                $temp_author=$this->PostAuthorModel->filter('m_id_user',$post_row->m_id_user);
                if($temp_author!=false)
                {
                    $bonus_score=$temp_author[0]->m_score_multi;
                }
                $new_user_score=$this->UserModel->bonus_score($post_row->m_id_user,((int)$this->SystemParamModel->get('Post_bonus_score_write', 'm_value') +$bonus_score)*(-1));
                echo "Đã bỏ duyệt bài viết";
                echo "<br>Đã trừ ".((int)$this->SystemParamModel->get('Post_bonus_score_write', 'm_value') +$bonus_score)." điểm cho ".$this->UserModel->get($post_row->m_id_user,'m_realname');
            }
        }
        else
        {
            echo "Tác vụ thất bại";
        }
        
	}
	else
	{
		echo "Cần quyền quản trị";
	}
?>