<?php

if ($this->UserModel->get($idname, 'm_level') > 3) {
    echo $this->load->design('block/admin/user/main.html');
}
?>