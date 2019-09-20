<?php
    /*tai danh sach ý kiến phản hồi*/
	$str="";
	if($this->UserModel->get($idname,'m_level')<3)
	{
		$str.="Cần quyền quản trị";
	}
	else
	{
		$data=$this->ContributeModel->getAll();
		if($data==false)
		{
			$str.="Chưa có phản hồi nào được gửi về hệ thống";
		}
		else
		{
			foreach($data as $r)
			{
				if($r->m_id_user==-1){$temp='Ẩn danh';}else{$temp=$this->UserModel->get($r->m_id_user,'m_realname');}
				$str.="<div style='border-bottom:1px dotted #ffffff;padding:5px 0px;'><span class='button' style='float:right' onclick='contribute.del(".$r->id.")'>Xóa</span><b>".$temp."</b> - ".$r->m_content."<div class='align_right'>".$r->m_date."</div><div class='clear_both'></div></div>";
			}
		}
	}
	echo $str;
?>