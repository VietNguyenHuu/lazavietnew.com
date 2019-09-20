<?php
	$id=$this->input->post('id');
	$this->PostFollowModel->add(Array(
        'id_user'=>$idname,
        'm_type'=>'author',
        'id_value'=>$id
   ));
   echo $this->PostFollowModel->get_follow_count('author',$id);
?>