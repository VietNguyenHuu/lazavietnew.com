<?php
/*tai danh sach tin nhắn người dùng*/
	$str="";
	if($this->UserModel->get($idname,'m_level')<3)
	{
		$str.="Cần quyền quản trị";
	}
	else
	{
		$data=$this->PublicMessageModel->getAll();
		if($data==false)
		{
			$str.="Chưa có tin nhắn nào được gửi về hệ thống";
		}
		else
		{
			$max=count($data);
			for($i=0;$i<$max;$i++)
			{
				if($data[$i]->m_id_user==-1){$temp='Khách';}else{$temp=$this->UserModel->get($data[$i]->m_id_user,'m_realname');}
				$str.="<div style='border-bottom:1px dotted #000000;padding:5px 0px;'><b>".$temp."</b> - <b class='tip'>".$data[$i]->m_email."</b> - ".$data[$i]->m_content." - ".$data[$i]->m_fromlink."<div class='align_right'>".$data[$i]->m_date."</div></div>";
			}
		}
	}
	echo $str;
?>