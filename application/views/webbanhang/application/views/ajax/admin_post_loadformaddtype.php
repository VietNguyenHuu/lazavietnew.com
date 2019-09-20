<?php
    if($this->UserModel->get($idname,'m_level')>2)
    {
        echo "<input id='admin_post_add_type_title' type='text' placeholder='Nhập tên danh mục' value=''>";
        echo "<span class='button padding' onclick='admin_post_type.add()'>Thêm</span>";
    }
    else
    {
        echo "Cần quyền quản trị";
    }
?>