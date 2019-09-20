<?php 
    $phone=$this->input->post('email');
    if($this->UserModel->check_exit_email($phone)!=false)
    {
        echo '1';
    }
    else
    {
        echo '-1';
    }
?>