<?php
if ($this->UserModel->getLevel($idname) > 3){
    echo mystr()->get_from_template(
        $this->load->design('block/admin/config/system_param_form_add.html'),
        []
    );
}