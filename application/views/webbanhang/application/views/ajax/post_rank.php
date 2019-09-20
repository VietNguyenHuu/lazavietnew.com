<?php
	$id=$this->input->post('id');
	$rank=$this->input->post('rank');
	if($this->PostContentModel->check_publish($id))
	{
		echo $this->PostContentModel->rank($id,$rank);
	}
?>