<?php
if ($this->UserModel->getLevel($idname) > 3){
    $paramName = $this->input->post('paramName');
    $paramValue = $this->input->post('paramValue');
    
    $r = $this->SystemParamModel->set($paramName, 'm_value', $paramValue);
    
    echo ($r) ? 'Update success !' : 'Update fail';
}
