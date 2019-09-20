<?php
	$id=$this->input->post('id');
	if($this->PostContentModel->check_publish($id))
	{
		$content=$this->input->post('content');
		if($content!=""&&$content!='undefined')
		{
			if($this->UserModel->check_exit($idname))
			{
				$result=$this->PostCommentModel->add(Array(
                    'id_content'=>$id,
                    'id_user'=>$idname,
                    'content'=>$content,
                    'date'=>TimeHelper()->_strtime
               ));
				if($result!=false)
				{
					echo "Đã gửi phản hồi";
				}
				else
				{
					echo "Không gửi được phản hồi";
				}
			}
			else
			{
				echo "Không gửi được phản hồi";
			}
		}
		else
		{
			echo "Không gửi được phản hồi";
		}
	}
	else
	{
		echo "Không gửi được phản hồi";
	}
?>