<?php 
	if($this->UserModel->get($idname,'m_level')>2)
	{
		$id=$this->input->post('check_id');
        $post_row=$this->PostContentModel->get_row($id);
        if($post_row==false)
        {
            echo "<div class='stt_mistake'>Bài viết không khả dụng để duyệt</div>";
        }
        else
        {
            echo "<div>Duyệt bài viết ".str_to_view($post_row->m_title)."</div>";
            //tác giả
            $author=$this->db->query("SELECT * FROM ".$this->PostAuthorModel->get_table_name()." WHERE m_id_user=".$post_row->m_id_user." LIMIT 0,1")->row();
            $userauthor=$this->UserModel->get_row($post_row->m_id_user);
            if($author!=false&&$author)
            {
                echo "<div class='padding_v'>Tác giả <b>".$userauthor->m_realname."</b> sẽ được cộng <b>".valid_money($author->m_score_multi+ (int)$this->SystemParamModel->get('Post_bonus_score_write', 'm_value'))."</b> điểm.";
            }
            echo "<div class='line_height_2'>Nhập số điểm bạn muốn cộng thêm nữa.<br>";
                echo "<input type='number' id='admin_post_content_check_addscore_input' value='0' placeholder='Nhập điểm cộng thêm' style='margin-left:0px'>";
            echo "</div>";
            echo "<div class='padding_v margin_t'><span class='button padding fontsize_d2' onclick='admin_post_content.check(".$post_row->id.")'>Duyệt bài</span></div>";
        }
	}
	else
	{
		echo "Cần quyền quản trị";
	}
?>