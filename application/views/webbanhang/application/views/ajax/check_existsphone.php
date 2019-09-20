<?php 
    $phone=$this->input->post('phone');
    if($this->UserModel->check_exit_phone($phone)!=false)
    {
        echo '1';
    }
    else
    {
        echo '-1';
    }
?>