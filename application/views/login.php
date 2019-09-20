<?php 
    
    
    
?> 
<?php
$this->load->view('header');
?>
<div class="login">
    <div class="max_width1188">
        <div class="login_form">
        <h3 class="float_left">Chào mừng đến với Lazada. Đăng nhập ngay!</h3>
        
        <div class="clear_both"></div>
            </div>
        
        <form class="login_form" action="" method="post">
            <div class="float_left">
            <h4>Đăng nhập</h4>
            </div>
            <div class="float_right">
                <a href="http://lazavietnew.com:8080/index.php/register.php">Đăng ký</a>
            </div>
            <div class="clear_both"></div>
            <br>
            <input name="UserName" type="text" placeholder="Tên đăng nhập">
           
            
            <br>
            <input name="PassWord" type="password" placeholder="Mật khẩu">
            <br>
            <button class="float_right" type="submit">Đăng nhập</button>
            <div class="clear_both"></div>
        </form>
    </div>
</div>

<?php
$this->load->view('footer');
?>