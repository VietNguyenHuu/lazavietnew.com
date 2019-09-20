<?php
$err = "";
if(!empty($this->input->post('submit'))){
    $username = $this->input->post('UserName');
if (strlen($username) == 0) {
    $err = "<div class='err'>username khong duoc de trong!</div>";
} else {
    $kq = $this->db->query("SELECT V_UserName FROM user WHERE V_UserName='" . $username ."'");
    if ($kq) {
        $kq = $kq->result();
        if ($kq != FALSE) {
            $err = "<div class='err'>username da ton tai!</div>";
        } else {
            $password = $this->input->post('PassWord');
            if (strlen($password) >= 8) {
                $email = $this->input->post('Email');
                $this->db->query("insert into user(V_UserName, V_PassWord, V_Email) value('" . $username . "', '" . $password . "', '" . $email . "')");
            } else {
                $err = "<div class='err'>mat khau phai nhieu hon 8 ki tu!</div>";
            }
        }
    }
}
}

?>
<?php
$this->load->view('header');
?>

<div>
    <div class="max_width1188">
        <?php
        if (empty($err) == FALSE) {
            echo $err;
        }
        ?>
        <form class="register" action="" method="post">
            <label>Username</label>
            <br>
            <input name="UserName" type="text" value="<?php echo $this->input->post('UserName')?>"> 
            <br>
            <label>Password</label>
            <br>
            <input name="PassWord" type="password" value="<?php echo $this->input->post('PassWord')?>"> 
            <br>
            <label>Email</label>
            <br>
            <input name="Email" type="text" value="<?php echo $this->input->post('Email')?>">
            <br>
            <button  type="submit" name="submit" value="abc">OK</button>
        </form>
    </div>
</div>

<?php
$this->load->view('footer');
?>