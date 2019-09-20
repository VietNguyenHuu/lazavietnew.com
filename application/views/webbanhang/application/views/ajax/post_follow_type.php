<?php
	$id=$this->input->post('id');
	$this->PostFollowModel->add(Array(
        'id_user'=>$idname,
        'm_type'=>'type',
        'id_value'=>$id
   ));
   echo $this->PostFollowModel->get_follow_count('type',$id);
?>