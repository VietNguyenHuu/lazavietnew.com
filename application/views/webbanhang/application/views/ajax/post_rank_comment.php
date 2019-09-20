<?php
	$id=$this->input->post('id');
	$rank=$this->input->post('rank');
	if($this->PostCommentModel->check_exit($id))
	{
		echo $this->PostCommentModel->rank($id,$rank);
	}
?>