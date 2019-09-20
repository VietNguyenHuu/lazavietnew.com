<?php
	$id=$this->input->post('id');
	if($this->PostContentModel->check_publish($id))
	{
		echo $this->PostContentModel->like($id);
	}
?>