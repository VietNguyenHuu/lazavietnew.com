<?php

function trichdan($chuoi_vao, $n, $strip_tag = 1) {
    $chuoi_vao = ($strip_tag == 1) ? strip_tags($chuoi_vao, "<br>") : $chuoi_vao;
    if ($n >= strlen($chuoi_vao)) {
        $chuoi_ra = $chuoi_vao;
    } else {
        $chuoi_ra = substr($chuoi_vao, 0, $n);
        $chuoi_ra = explode(" ", $chuoi_ra);
        $chuoi_ra[count($chuoi_ra) - 1] = "";
        $chuoi_ra = implode(" ", $chuoi_ra) . " ...";
    }
    return $chuoi_ra;
}

//ham loai bo dau tieng viet
function bodau($str) {
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|ä|å|æ',
        'c' => 'ç',
        'd' => 'đ|ð',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|ë',
        'i' => 'í|ì|ỉ|ĩ|ị|î|ï',
        'n' => 'ñ',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|ö',
        'p' => 'þ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|û|ü',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ|ÿ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|Ä|Å|Æ',
        'B' => 'ß',
        'C' => 'Ç',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|Ë',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị|Î|Ï',
        'N' => 'Ñ',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|Ö',
        'P' => 'Þ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|Û|Ü',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ');
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return $str;
}

function dn_urlencode($str, $length = 100) {
    $str = strtolower(str_replace(" ", "-", trichdan(bodau(html_entity_decode($str)), min($length, 100))));
    $str2 = "";
    $allow = explode(",", "-,z,x,c,v,b,n,m,a,s,d,f,g,h,j,k,l,q,w,e,r,t,y,u,i,o,p,0,9,8,7,6,5,4,3,2,1,_");
    for ($i = 0; $i < strlen($str); $i++) {
        $char = substr($str, $i, 1);
        if (in_array($char, $allow)) {
            $str2 .= $char;
        }
    }
    $str2 = str_replace(Array("----", "---", "--"), "-", $str2);
    return trim($str2, "-");
}

//chia lay nguyen
function chianguyen($a, $b) {
    $t = $a / $b;
    $t = $t . "";
    $t = explode(".", $t);
    $t = $t[0] + 0;
    return $t;
}

function valid_money($money) {//t?o d?u ch?m cho ti?n t?
    $money = (int) $money . "";
    $len = strlen($money);
    $new = "";
    for ($ii = 0; $ii < $len - 1; $ii++) {
        if (($len - $ii) % 3 === 1) {
            $new .= substr($money, $ii, 1) . '.';
        } else {
            $new .= substr($money, $ii, 1);
        }
    }
    $new .= substr($money, $len - 1, 1);
    return $new;
}

//ham chuyen huong trang bang javascript
function j_movepage($strpage) {
    echo "<script type='text/javascript'>window.location='" . $strpage . "';</script>";
}

//ham thong bao bang javascript
function j_alert($stralert) {
    echo "<script type='text/javascript'>alert('" . $stralert . "');</script>";
}

class myhtml_grid {

    private $_str_header = "";
    private $_str_content = "";

    function __construct() {
        //
    }

    public function set($header, $content) {
        $this->_str_header = $header;
        $this->_str_content = $content;
    }

    function get_html() {
        $str = "<div class='grid'>";
        $str .= "<div class='grid_header'>";
        $str .= $this->_str_header;
        $str .= "<div class='clear_both'></div>";
        $str .= "</div>";
        $str .= $this->_str_content;
        $str .= "</div>";
        return $str;
    }

}

function myhtml_grid($header, $content) {
    $grid = new myhtml_grid;
    $grid->set($header, $content);
    return $grid->get_html();
}

class strpage {

    private $_str_patern = "";

    function __construct() {
        $this->_str_patern = "[[pagetype]]-[[pagenumber]]";
    }

    function decode($str_page) {
        $ar = Array('pagetype' => false, 'pagenumber' => 1);
        $ar_page = explode("-", $str_page);
        $count = count($ar_page);
        if ($count > 0 && $str_page != "") {
            $ar['pagenumber'] = $ar_page[$count - 1];
            array_pop($ar_page);
            $ar['pagetype'] = implode("-", $ar_page);
        }
        return $ar;
    }

}

function strpage() {
    return new strpage;
}

class mystr {

    function addmask($str = "", $sepe = " ", $mask = 'sbsb') {
        $ar = explode($sepe, $str);
        if (count($ar) > 0 && $str != "") {
            foreach ($ar as $key => $value) {
                $ar[$key] = $ar[$key] . "" . $mask;
            }
            return implode($sepe, $ar);
        }
        return $str;
    }

    function get_from_template($template, $array_replace) {
        if (!is_array($array_replace)) {
            return null;
        }
        return str_replace(array_keys($array_replace), array_values($array_replace), $template);
    }

}

function mystr() {
    return new mystr;
}

function str_to_view($str, $allow_quote = true) {
    if ($allow_quote == true) {
        return htmlspecialchars($str, 1, 'utf-8');
    }
    return str_replace(Array('"', "'"), " ", htmlspecialchars($str, 1, 'utf-8'));
}

class capcha {

    private $_str_capcha = "";
    private $_image = "";

    function generate() {
        $this->_str_capcha = rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9);
        $image = imagecreatetruecolor(100, 30);
        $color_bg = imagecolorallocate($image, 127, 127, 127);
        imagefill($image, 0, 0, $color_bg);
        $color_text = imagecolorallocate($image, 0, 0, 0);
        imagettftext($image, 20, 0, 3, 25, $color_text, realpath("assets/css/fonts/notica.ttf"), $this->_str_capcha);
        imagepng($image, 'assets/img/system/capcha_temp.png', 0);
        imagedestroy($image);
        $this->_image = "data:image/png;base64," . base64_encode(file_get_contents('assets/img/system/capcha_temp.png'));
        unlink('assets/img/system/capcha_temp.png');
        return Array('capcha' => $this->_str_capcha, 'image' => $this->_image);
    }

}

function capcha() {
    return new capcha;
}

function my_time_ago_str($timestamp = -1) {//trả về chuỗi thời gian từ timestamp đến hiện tại
    if ($timestamp == -1) {
        return "";
    }
    $now = time();
    $duration = $now - $timestamp; //giây
    if ($duration < 60) {
        return $duration . " giây trước";
    }
    $duration = chianguyen($duration, 60); //phút
    if ($duration < 60) {
        return $duration . " phút trước";
    }
    $duration = chianguyen($duration, 60); //giờ
    if ($duration < 24) {
        return $duration . " giờ trước";
    }
    $duration = chianguyen($duration, 24); //ngày
    if ($duration < 30) {
        return $duration . " ngày trước";
    }
    $duration = chianguyen($duration, 30); //tháng
    if ($duration < 12) {
        return $duration . " tháng trước";
    }
    $duration = chianguyen($duration, 12); //năm
    return $duration . " năm trước";
}

function my_swap(&$var1, &$var2) {
    $var = $var1;
    $var1 = $var2;
    $var2 = $var;
}

function refine_html_string($string = "") {
    $cl = "temp_class_" . time();
    $t = "<div class='" . $cl . "'>" . $string . "</div>";
    $t = str_get_html($t);
    $t = $t->find("div." . $cl);
    if ($t == false || $t == null || count($t) < 1) {
        return $string;
    } else {
        return $t[0]->innertext();
    }
}

function get_str_like_fb($fb_url = '') {
    $str = "<div class='fb-like' data-href='" . $fb_url . "' data-layout='button_count' data-action='like' data-show-faces='true' data-share='true'></div>";
    return $str;
}

function get_str_like_google() {
    return "<div class='display_inline_block g-plusone' data-size='tall'></div>";
}

function get_str_like_full($fb_url = '') {
    return get_str_like_fb($fb_url) . "<div class='display_inline_block margin_l' style='position:relative;top:0.5em;'>" . get_str_like_google() . "</div>";
}

function get_str_fb_comment($fb_url = '') {
    $str = "<div class='fb-comments' data-href='" . $fb_url . "' data-numposts='5' data-width='100%'></div>";
    return $str;
}

function get_str_fb_fanpage($setting = Array('fanpage' => '', 'fanpage_title' => '')) {
    if (!isset($setting)) {
        $setting = Array();
    }
    if (!isset($setting['fanpage'])) {
        $setting['fanpage'] = '';
    }
    if (!isset($setting['fanpage_title'])) {
        $setting['fanpage_title'] = '';
    }
    return "<div class='fb-page' data-href='" . $setting['fanpage'] . "' data-small-header='false' data-adapt-container-width='true' data-hide-cover='false' data-show-facepile='true'><blockquote cite='" . $setting['fanpage'] . "' class='fb-xfbml-parse-ignore'><a href='" . $setting['fanpage'] . "'>" . $setting['fanpage_title'] . "</a></blockquote></div>";
}

function folder_deleteAllFile($path) {
    $realpath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    if(is_dir($realpath)){
        $files = glob( rtrim($realpath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '*', GLOB_MARK );

        foreach( $files as $file ){
            folder_deleteAllFile( $file );      
        }
    } else if(is_file($realpath)) {
        unlink( $realpath );  
    }
}
