<?php
define('STR_REGISTER_CAPCHA', 'capcha_register');

$dk_capcha = $this->input->post('register_capcha');
$dk_name = $this->input->post('register_name');
$dk_pass = $this->input->post('register_pass');
$dk_repass = $this->input->post('register_repass');
$dk_realname = $this->input->post('register_realname');
$dk_year = $this->input->post('register_year');
$dk_sex = $this->input->post('register_sex');
$dk_phone = $this->input->post('register_phone');
$dk_email = $this->input->post('register_email');
$dk_province = $this->input->post('register_province');
$dk_address = $this->input->post('register_address');
$dk_tick = $this->input->post('register_checkbox');

$thanhcong = false;
if ($dk_realname == "") {
    $dk_realname = $dk_name;
}
$ar_temp = [
    '{{domain_name}}' => $page_domain_name,
    '{{status}}' => '',
    '{{form}}' => ''
];

if ($dk_name != "") {
    
    $loi = "";
    //kt trung ten
    if ($this->UserModel->check_exit_username($dk_name) != false) {
        $loi = "Tên đăng nhập đã tồn tại !";
        $ar_temp['{{status}}'] .= "<div class='mistake'>" . $loi . "</div>";
    } else {
        //da khong trung ten
        if ($dk_capcha == "" || $dk_capcha == 'undefined' || $dk_capcha != $this->session->userdata(STR_REGISTER_CAPCHA)) {
            $loi = "Mã Capcha không đúng";
        }
        if ($this->UserModel->check_exit_email($dk_email) != false && $dk_email != "") {
            $loi = "Email đã tồn tại !";
        }
        if ($this->UserModel->check_exit_phone($dk_phone) != false) {
            $loi = "Số điện thoại đã tồn tại !";
        }
        if (strlen($dk_phone) < 8 || strlen($dk_phone) > 20) {
            $loi = $loi . "<br>Số điện thoại đăng ký không hợp lệ !";
        }
        if (strlen($dk_name) < 8 || strlen($dk_name) > 20) {
            $loi = $loi . "<br>Độ dài tên đăng ký không hợp lệ !";
        }
        if (strlen($dk_pass) < 8 || strlen($dk_pass) > 20) {
            $loi = $loi . "<br>Mật khẩu quá yếu hoặc quá dài!";
        }
        if ($dk_pass != $dk_repass) {
            $loi = $loi . "<br>Mật khẩu lặp lại không đúng !";
        }
        if (strlen($dk_realname) < 8 || strlen($dk_realname) > 50) {
            $loi = $loi . "<br>Độ dài tên thật đăng ký không hợp lệ";
        }
        if ($loi == "") {
            $id = $this->UserModel->add(Array(
                'username' => $dk_name,
                'password' => $dk_pass,
                'realname' => $dk_realname,
                'sex' => $dk_sex,
                'birthday' => $dk_year,
                'phone' => $dk_phone,
                'email' => $dk_email,
                'province_code' => $dk_province,
                'address' => $dk_address
            ));
            if ($id != false) {
                $this->UserModel->login($dk_name, $dk_pass);
                $user_row = $this->UserModel->get_row($id);
                $ar_temp['{{status}}'] .= mystr()->get_from_template(
                    $this->load->design('block/register/success.html'),
                    [
                        '{{realname}}' => $user_row->m_realname,
                        '{{domain_name}}' => $page_domain_name,
                        '{{userlink}}' => $this->UserModel->get_link_from_id($id)
                    ]
                );
                $thanhcong = true;
            } else {
                $ar_temp['{{status}}'] .= "<div class='bg_danger stt_white padding'>Đăng ký không thành công, hãy thực hiện lại sau !</div>";
            
            }
        } else {
            $ar_temp['{{status}}'] .= "<div class='bg_danger stt_white padding'>" . $loi . "</div>";
        }
    }
}
if ($thanhcong != true) {
    $temp_capcha = capcha()->generate();
    $this->session->set_userdata(STR_REGISTER_CAPCHA, $temp_capcha['capcha']);
    
    $ar_form = [
        '{{dk_name}}' => $dk_name,
        '{{dk_pass}}' => $dk_pass,
        '{{dk_repass}}' => $dk_repass,
        '{{dk_phone}}' => $dk_phone,
        '{{dk_realname}}' => $dk_realname,
        '{{dk_email}}' => $dk_email,
        '{{dk_address}}' => $dk_address,
        '{{dk_iswomen_check}}' => ($dk_sex == 1) ? '' : "selected='selected'",
        '{{dk_years}}' => '',
        '{{dk_provinces}}' => '',
        '{{capcha_src}}' => $temp_capcha['image']
    ];
    
    for ($i = 2000; $i > 1950; $i--) {
        if ($i != $dk_year) {
            $add = "";
        } else {
            $add = "selected='selected'";
        }
        $ar_form['{{dk_years}}'] .= "<option value=" . $i . " " . $add . ">" . $i . "</option>";
    }
    
    $data = $this->ProvinceCodeModel->getAll();
    if ($data == false) {
        $ar_form['{{dk_provinces}}'] .= "<span class='stt_mistake'>Không có danh sách khu vực !</span>";
    } else {
        foreach ($data as $r) {
            if ($r->m_code != $dk_province) {
                $add = "";
            } else {
                $add = "selected='selected'";
            }
            $ar_form['{{dk_provinces}}'] .= "<option value=" . $r->m_code . " " . $add . ">" . $r->m_title . "</option>";
        }
    }
    
    $ar_temp['{{form}}'] .= mystr()->get_from_template(
        $this->load->design('block/register/form.html'),
        $ar_form
    ); 
}
echo mystr()->get_from_template(
    $this->load->design('block/register/register.html'),
    $ar_temp
);