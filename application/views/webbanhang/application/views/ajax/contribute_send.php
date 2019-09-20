<?php
	$andanh=$this->input->post('andanh');
	$nd=$this->input->post('nd');
	if($this->UserModel->check_exit($idname))
	{
		$id_user=$idname;
	}
	else
	{
		$id=-1;
	}
	if($andanh==1)
	{
		$id_user=-1;
	}
	$str="";
	$this->ContributeModel->add(Array(
        'id_user'=>$id_user,
        'content'=>$nd,
        'strtime'=>TimeHelper()->_strtime
   ));
	$str="Đã cập nhật phản hồi thành công";
	echo $str;
?>