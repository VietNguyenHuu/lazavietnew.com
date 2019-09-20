<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

    public function index($page = 1) {
        $data = Array(
            'idname' => $this->UserModel->check_login()
        );
        if ($this->UserModel->get($data['idname'], 'm_level') > 3) {
            set_time_limit(1000);
            ini_set('memory_limit', "500M");
            $this->load->model("CompanyModel");
            $partern_link_page = "http://www.hosovietnam.com/index.php?page=hosovietnam&keyword=&sapxep=0&tinhthanh=[[province]]&quanhuyen=0&tungay=&dengay=&sapxepdidong=124&n=[[page]]";
            $province = '224'; //Bình Dương
            $province_name = 'Bình Dương';
            $page = 1;
            $max_page = 2;//352;
            for ($page_run = $page; $page_run <= $max_page; $page_run++) {
                $link_process = str_replace(Array('[[province]]', '[[page]]'), Array($province, $page_run), $partern_link_page);
                //echo $link_process."<br>";
                $str_html = supper_curl()->get($link_process); //lấy nội dung trang
                $str_html = str_get_html($str_html); //chuyển thành html project
                if ($str_html != null && $str_html != "" && $str_html != false) {
                    $list_item = $str_html->find("div.tc_have div.news-v3 h2 a");
                    if ($list_item != false && $list_item != null && $list_item != "") {
                        foreach ($list_item as $item) {
                            $comp_name = strtolower(dn_urlencode($item->innertext()));
                            if (strpos($comp_name, "chi-nhanh") !== false || strpos($comp_name, "van-phong-dai-dien") !== false || (strpos($comp_name, "cong-ty") === false && strpos($comp_name, "cty") === false)) {//không hợp lệ
                                //echo "<div style='color:red'>".$comp_name."</div>";
                            } else {
                                //echo "<div style='color:green'>".$comp_name."</div>";
                                $comp_link = $item->__get('href');
                                $str_html = supper_curl()->get($comp_link); //lấy nội dung trang chi tiết
                                $str_html = str_get_html($str_html); //chuyển thành html project
                                if ($str_html != null && $str_html != "" && $str_html != false) {
                                    $info = $str_html->find("div.tc_have div.item-page");
                                    if ($info != null && $info != false && $info != "") {
                                        $info = $info[0];
                                        //tên công ty
                                        $comp_name = $info->find("h1");
                                        if ($comp_name != "" && $comp_name != null && $comp_name != false) {
                                            $comp_name = $comp_name[0]->innertext();
                                        } else {
                                            $comp_name = "";
                                        }
                                        $comp_leader = "";
                                        $comp_add = "";
                                        $comp_phone = "";
                                        $moreinfo = $info->find("li");
                                        if ($moreinfo != "" && $moreinfo != null && $moreinfo != false) {
                                            foreach ($moreinfo as $moreinfo_line) {
                                                $plaintext = $moreinfo_line->plaintext;
                                                $mask = explode(":", $plaintext);
                                                if (count($mask) > 0) {
                                                    $mask = dn_urlencode($mask[0]);
                                                    if ($mask == 'dia-chi') {
                                                        $comp_add = str_replace(Array("Địa chỉ: ", "[Xem bản đồ]"), "", $plaintext);
                                                    } else if ($mask == 'ten-giam-doc') {
                                                        $comp_leader = str_replace(Array("Tên giám đốc: "), "", $plaintext);
                                                    } else if ($mask == 'dien-thoai') {
                                                        $comp_phone = str_replace(Array("Điện thoại: "), "", $plaintext);
                                                    }
                                                }
                                            }
                                        }
                                        $this->CompanyModel->add(Array(
                                            'm_title' => $comp_name,
                                            'm_leader' => $comp_leader,
                                            'm_phone' => $comp_phone,
                                            'm_address' => $comp_add,
                                            'm_link' => $comp_link,
                                            'm_province_code' => $province,
                                            'm_province_name' => $province_name
                                        ));
                                        usleep(300);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            echo "need permission !";
        }
    }

}
