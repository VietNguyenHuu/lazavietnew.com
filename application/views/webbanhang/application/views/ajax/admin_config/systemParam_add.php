<?php
if ($this->UserModel->getLevel($idname) > 3){
    $paramName = $this->input->post('paramName');
    $paramValue = $this->input->post('paramValue');
    $paramComment = $this->input->post('paramComment');
    $add = $this->SystemParamModel->add([
        'name' => $paramName,
        'value' => $paramValue,
        'comment' => $paramComment
    ]);
    echo ($add === false) ? "Cannot add this system param" : "Added this system param";
}