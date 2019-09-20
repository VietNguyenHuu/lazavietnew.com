<?php 
    $name=$this->input->post('name');
    if($this->UserModel->check_exit_username($name)!=false)
    {
        echo '1';
    }
    else
    {
        echo '-1';
    }
?>