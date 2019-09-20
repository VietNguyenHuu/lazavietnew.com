<?php
if ($this->UserModel->get($idname, 'm_level') > 3) {
    ?>   
    <form action='javascript:main_menu.add()'>
        <div class="line_height_2_5">
            <div class="padding_r">
                <input class='padding' type='text' name='main_menu_add_title' placeholder=' Nhập tên mục ' style='width:100%; max-width: 100%;'>
            </div>
            <div class='padding_r'>
                <input type='text' name='main_menu_add_link' placeholder=' URL trang ' style='width:100%; max-width: 100%'>
            </div>
            <div>
                <select name='main_menu_add_type'>
                    <?php 
                    foreach ($this->StaticPageModel->label_type() as $key => $value)
                    {
                        echo "<option value='$key'>$value</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div>
                <input class="button" type='submit' value=' Thêm mục'>
            </div>
        </div>
    </form>
    <?php
}