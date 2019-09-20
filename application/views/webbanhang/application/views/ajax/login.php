<?php
    $name=$this->input->post('name');
    $pass=$this->input->post('pass');
    if($this->UserModel->login($name,$pass)!=false)
    {
        echo '1';
    }
    else
    {
        echo '-1';
    }
?>