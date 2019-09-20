<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class UserModel extends BaseModel {

    private $_table_name_resetpass = "";

    public function __construct() {
        parent::__construct();
        $this->_table_name_resetpass = 'reset_pass';
        $this->_table_name = 'user';
        $this->_list_field = Array('id', 'm_fb_token', 'm_name', 'm_pass', 'm_realname', 'm_realname_search', 'm_sex', 'm_level', 'm_phone', 'm_email', 'm_birth', 'm_province_code', 'm_address', 'm_money', 'm_score', 'm_lock', 'm_lasttime', 'm_file_type');
        $this->_primary_field = 'id';
        $this->_avata_folder = "upload/img/user_avata/";
        $this->_avata_thumb = Array(
            'small' => Array('path' => "upload/img/user_avata_thumb/", 'width' => 200, 'height' => 200)
        );
        $this->_avata_default = 'assets/img/default_avata/user.png';
        $this->_str_link = "user/profile/{{m_realname}}-{{id}}";
    }

    public function add($data = Array(
        'username' => 'nguyen dinh nam',
        'password' => 'nguyen dinh nam',
        'realname' => 'nguyen dinh nam',
        'sex' => 1,
        'birthday' => '1994-01-29',
        'phone' => 'no',
        'email' => 'no',
        'province_code' => 0,
        'address' => 'no',
        'fb_token' => '-1'
    )) {
        if ($this->check_exit_username($data['username'])) {
            return false;
        }
        if ($this->check_exit_phone($data['phone']) && $data['phone'] != "no") {
            return false;
        }
        if ($this->get_num_row() > 0) {
            $level = 1;
        } else {
            $level = 5;
        }
        if (!isset($data['fb_token'])) {
            $data['fb_token'] = '-1';
        }
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_fb_token' => $data['fb_token'],
            'm_name' => $data['username'],
            'm_pass' => md5($data['password']),
            'm_realname' => $data['realname'],
            'm_sex' => $data['sex'],
            'm_level' => $level,
            'm_phone' => $data['phone'],
            'm_email' => $data['email'],
            'm_birth' => $data['birthday'],
            'm_province_code' => $data['province_code'],
            'm_address' => $data['address'],
            'm_score' => 100,
            'm_lock' => 0,
            'm_lasttime' => time(),
            'm_file_type' => 'gif'
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            $this->set_realname_search($add['id']);
            return $add['id'];
        }
        return false;
    }

    public function del($id) {
        if ($this->check_exit($id) == false) {
            return false;
        }
        parent::del($id);
        if ($this->check_exit($id) != false) {
            return false;
        }
        $this->del_avata($id);
        return true;
    }

    public function get_table_name_resetpass() {
        return $this->_table_name_resetpass;
    }

    public function get_link_from_id($id) {
        $data = $this->get_row($id);
        if ($data == false) {
            return false;
        }
        return $this->get_link_from_row(['id' => $data->id, 'm_realname' => $data->m_realname]);
    }

    public function getLevel($id) {
        return $this->get($id, 'm_level');
    }

    public function label_level(){
        return [
            '1' => "Thành viên",
            '2' => "Thành viên vip",
            '3' => "Cộng tác viên",
            '4' => "Quản trị viên",
            '5' => "Admin",
        ];
    }
    public function label_sex(){
        return [
            '1' => 'Nam',
            '0' => 'Nữ'
        ];
    }
    public function set_realname_search($id) {
        $row = $this->get_row($id);
        if ($row == false) {
            return false;
        }
        $this->set($id, 'm_realname_search', mystr()->addmask($row->m_realname));
        return true;
    }

    public function check_exit_username($username) {
        $this->db->where('m_name', $username);
        if ($this->db->get($this->_table_name)->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exit_phone($phone) {
        $this->db->where('m_phone', $phone);
        if ($this->db->get($this->_table_name)->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exit_email($username) {
        if ($username == '' || $username == 'no') {
            return false;
        }
        $this->db->where('m_email', $username);
        if ($this->db->get($this->_table_name)->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_login() {
        if ($this->check_exit($this->session->userdata('iduser'))) {
            if ($this->get($this->session->userdata('iduser'), 'm_lock') == 1) {
                return false;
            }
            return $this->session->userdata('iduser');
        } else {
            return false;
        }
    }

    public function login($username, $password) {
        $this->db->where(Array('m_name' => $username, 'm_pass' => md5($password), 'm_lock' => 0));
        if ($this->db->get($this->_table_name)->num_rows() > 0) {
            $this->db->where(Array('m_name' => $username, 'm_pass' => md5($password), 'm_lock' => 0));
            $id = $this->db->get($this->_table_name)->row()->id;
            $this->session->set_userdata('iduser', $id);
            return $id;
        } else {
            return false;
        }
    }

    public function login_width_fb($id_fb) {
        $this->db->where(Array('m_fb_token' => $id_fb));
        if ($this->db->get($this->_table_name)->num_rows() > 0) {
            $this->db->where(Array('m_fb_token' => $id_fb));
            $id = $this->db->get($this->_table_name)->row()->id;
            $this->session->set_userdata('iduser', $id);
            $this->set($id, 'm_lasttime', time());
            return $id;
        } else {
            return false;
        }
    }

    public function out() {
        $this->session->unset_userdata('iduser');
    }

    public function get_current_id_login() {
        $this->session->userdata('iduser');
    }

    public function bonus_score($id_user = -1, $score = 0) {
        if ($this->check_exit($id_user) == false) {
            return false;
        }
        if ($score == 0) {
            return false;
        }
        $old_score = $this->get($id_user, 'm_score');
        $new_score = $old_score + $score;
        $this->set($id_user, 'm_score', $new_score);
        return $new_score;
    }

    public function bonus_money($id_user = -1, $money = 0) {
        if ($this->check_exit($id_user) == false) {
            return false;
        }
        if ($money == 0) {
            return false;
        }
        $old_money = $this->get($id_user, 'm_money');
        $new_money = $old_money + $money;
        $this->set($id_user, 'm_money', $new_money);
        return $new_money;
    }

    //reset pass
    public function resetpass_add($email = "") {
        if ($email == "") {
            return false;
        }
        $token_ar = Array("1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "x", "y", "z", "w");
        $token_ar_count = count($token_ar);
        $token = "";
        for ($i = 0; $i < 16; $i++) {
            $token .= $token_ar[rand(0, $token_ar_count - 1)];
        }
        if ($this->resetpass_sendmail($email, $token) != true) {
            return false;
        }
        $add = Array(
            'id' => $this->SystemModel->get_id(),
            'm_email' => $email,
            'm_token' => $token,
            'm_time' => time(),
            'm_numcheck' => 0
        );
        $this->db->insert($this->_table_name_resetpass, $add);
        if ($this->resetpass_check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

    public function resetpass_del($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_table_name_resetpass);
        return true;
    }

    public function resetpass_check_exit($id) {
        $this->db->where('id', $id);
        if ($this->db->get($this->_table_name_resetpass)->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function resetpass_update($id = -1) {
        if ($id == -1) {
            return false;
        }
        $this->db->quere('id', $id);
        $row = $this->db->get($this->_table_name_resetpass)->rusult();
        if (count($row) < 1) {
            return false;
        }
        $row = $row[0];
        $token_ar = Array("1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "x", "y", "z", "w");
        $token_ar_count = count($token_ar);
        $token = "";
        for ($i = 0; $i < 16; $i++) {
            $token .= $token_ar[rand(0, $token_ar_count - 1)];
        }
        if ($this->resetpass_sendmail($row['m_email'], $token) != true) {
            return false;
        }
        $this->db->where('id', $id);
        $this->db->update($this->_table_name_resetpass, Array('m_token' => $token, 'm_numcheck' => 0));
        return true;
    }

    public function resetpass_set($id, $field, $new) {
        $this->db->where('id', $id);
        $this->db->update($this->_table_name_resetpass, Array($field => $new));
        return true;
    }

    public function resetpass_sendmail($email = "", $token = "") {
        if ($email == "" || $token == "") {
            return false;
        }
        $user = $this->db->query("SELECT * FROM " . $this->get_table_name() . " WHERE(m_email='" . $email . "')")->result();
        if (count($user) < 1) {
            return false;
        }
        $user = $user[0];
        //send mail
        $to = $email;
        $subject = "Thay đổi mật khẩu - " . $this->SystemParamModel->get('Site_domain_name', 'm_value');

        $mes_patern = "<div>Chào {username},</div><br> Chúng tôi đã nhận được yêu cầu thay đổi mật khẩu của bạn tại website {domainname}.<br>Bạn vui lòng <a href='{link}'>nhấn vào liên kết này</a> để thực hiện thay đổi mật khẩu.<br><br><div>Trân trọng !<br><img src='" . base_url() . "assets/img/system/favico.png" . "'/>Từ " . $this->SystemParamModel->get('Site_domain_name', 'm_value') . " - " . $this->SystemParamModel->get('Site_slogend', 'm_value') . "</div>";
        $mes = str_replace(Array('{username}', '{domainname}', '{link}'), Array($user->m_realname, $this->SystemParamModel->get('Site_domain_name', 'm_value'), site_url('login/resetpass/' . urlencode($email) . "/" . urlencode($token))), $mes_patern);

        // Always set content-type when sending HTML email
        $h = "MIME-Version: 1.0" . "\r\n";
        $h .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $h .= 'From: <webmaster@' . $this->SystemParamModel->get('Site_domain_name', 'm_value') . '>' . "\r\n";

        mail($to, $subject, $mes, $h);
        //end end mail
        return true;
    }
}
