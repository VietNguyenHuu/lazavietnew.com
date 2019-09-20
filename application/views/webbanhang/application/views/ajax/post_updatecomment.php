<?php
	$id=$this->input->post('id');
	if($this->PostContentModel->check_publish($id))
	{
	   $post_row=$this->PostContentModel->get_row($id);
	   $comment_type=$this->input->post('comment_type');
		$str="";
		$data=$this->PostCommentModel->filter('m_id_content',$id);
		if($data!=false)
		{
            $m=count($data);
            for($i=0;$i<$m;$i++)
			{
			     $data[$i]->rank=$this->PostCommentModel->get_rank($data[$i]->id);
            }
            if($comment_type=='by_rank')
            {
                //sắp xếp lại biến data theo sao
                for($i=0;$i<$m-1;$i++)
    			{
        			 for($j=$i;$j<$m;$j++)
        			{
        			     if($data[$i]->rank<$data[$j]->rank)
                         {
                            $temp=$data[$i];
                            $data[$i]=$data[$j];
                            $data[$j]=$temp;
                         }
        			}
    			}
            }
			
			for($i=0;$i<$m;$i++)
			{
				$str.="<div class='post_comment_item'>";
					$str.="<img class='post_comment_item_avata' src='".$this->UserModel->get_avata($this->PostCommentModel->get($data[$i]->id,'m_id_user'))."'>";
					$str.="<div class='post_comment_item_status'><a href='".$this->UserModel->get_link_from_id($this->PostCommentModel->get($data[$i]->id,'m_id_user'))."'>".$this->UserModel->get($this->PostCommentModel->get($data[$i]->id,'m_id_user'),'m_realname')."</a><span class='tip' style='font-size:14px;margin-left:20px;'><i class='fa fa-clock-o'></i> ".$data[$i]->m_date."</span>";
                        if($data[$i]->m_id_user==$idname||($this->UserModel->get($idname,'m_level')>3&&$this->UserModel->get($idname,'m_level')>$this->UserModel->get($data[$i]->m_id_user,'m_level')))
                        {
                            $str.="<i class='float_right stt_action stt_mistake fa fa-trash-o margin_l fontsize_d2' style='margin-top:0.125em' onclick='post.del_comment(".$data[$i]->id.")'></i>";
                        }
                        $temp_c_star=$data[$i]->rank;
                        $str_rank="";
        				for($j=1;$j<=$temp_c_star;$j++)
        				{
        					$str_rank.="<i class='stt_action fa fa-star stt_highlight' onclick='post.rank_comment(".$data[$i]->id.",".$j.",".$id.")'></i>";
        				}
        				for($j=$temp_c_star+1;$j<=5;$j++)
        				{
        					$str_rank.="<i class='stt_action fa fa-star-o stt_tip' onclick='post.rank_comment(".$data[$i]->id.",".$j.",".$id.")'></i>";
        				}
                        $str.="<span class='float_right fontsize_d2 display_inline_block'>Đánh giá ".$str_rank."</span>";
                    $str.="</div>";
					$str.="<div class='post_comment_item_content'>".nl2br($data[$i]->m_content)."</div>";
                    $str.="<div class'clear_both'></div>";
				$str.="</div>";
			}
		}
		else
		{
            if($post_row==false)
            {
                $str.="<div class='stt_tip' style='padding:0.5em 0px;'>Chưa có bình luận nào !</div>";
            }
			else
            {
                $str.="<div class='stt_tip' style='padding:0.5em 0px;'>Hãy là người đầu tiên nhận xét về ".str_to_view($post_row->m_title)." !</div>";
            }
		}
		echo $str;
	}
	else
	{
		echo "Không có nội dung bình luận";
	}
?>