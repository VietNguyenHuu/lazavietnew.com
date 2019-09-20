<?php

class TimeHelper {

    public $_ngay = '';
    public $_thang = '';
    public $_nam = '';
    public $_gio = '';
    public $_phut = '';
    public $_giay = '';
    public $_buoi = '';
    public $_thu = '';
    public $_strtime = '';
    public $_strtime_to_sql = '';

    public function __construct() {
        //
    }

    public function time_from_timestamp($timestamp = false) {
        Date_default_timezone_set("Asia/Ho_Chi_Minh");
        if ($timestamp == false) {
            $timestamp = time();
        }
        $strtime = date('H,i,s,a,D,d,m,Y', $timestamp);
        
        $artime = explode(",", $strtime); //hàm chuyển từ chuỗi thành mảng
        $this->_gio = $artime[0];
        $this->_phut = $artime[1];
        $this->_giay = $artime[2];
        $this->_buoi = $artime[3];
        $this->_thu = $artime[4];
        $this->_ngay = $artime[5];
        $this->_thang = $artime[6];
        $this->_nam = $artime[7];
        if ($this->_buoi == "am") {
            $this->_buoi = "sáng";
        } else {
            $this->_buoi = "chiều";
        }
        if ($this->_thu == "Mon") {
            $this->_thu = "thứ hai";
        }
        if ($this->_thu == "Tue") {
            $this->_thu = "thứ ba";
        }
        if ($this->_thu == "Wed") {
            $this->_thu = "thứ tư";
        }
        if ($this->_thu == "Thu") {
            $this->_thu = "thứ năm";
        }
        if ($this->_thu == "Fri") {
            $this->_thu = "thứ sáu";
        }
        if ($this->_thu == "Sat") {
            $this->_thu = "thứ bảy";
        }
        if ($this->_thu == "Sun") {
            $this->_thu = "chủ nhật";
        }
        $this->_strtime = $this->_gio . ":" . $this->_phut . "," . $this->_ngay . "/" . $this->_thang . "/" . $this->_nam;
        $this->_strtime_to_sql = $this->_nam . "-" . $this->_thang . "-" . $this->_ngay . " " . $this->_gio . ":" . $this->_phut . ":" . $this->_giay;
        return $this;
    }

    public function to_str($paterm = "[nam]-[thang]-[ngay] [gio]:[phut]:[giay]") {
        return str_replace(Array('[ngay]', '[thang]', '[nam]', '[gio]', '[phut]', '[giay]', '[buoi]', '[thu]'), Array($this->_ngay, $this->_thang, $this->_nam, $this->_gio, $this->_phut, $this->_giay, $this->_buoi, $this->_thu), $paterm);
    }

    public function sql_to_view($time_on_sql = "2016-08-20 05:00:00", $paterm = "[date]/[month] [hourse]:[minute]") {
        $time_on_sql = explode(" ", $time_on_sql);
        $temp_day = explode("-", $time_on_sql[0]);
        if (isset($time_on_sql[1])) {
            $temp_time = explode(":", $time_on_sql[1]);
            return str_replace(Array('[date]', '[month]', '[year]', '[hourse]', '[minute]', '[second]'), Array($temp_day[2], $temp_day[1], $temp_day[0], $temp_time[0], $temp_time[1], $temp_time[2]), $paterm);
        }
        return str_replace(Array('[date]', '[month]', '[year]'), Array($temp_day[2], $temp_day[1], $temp_day[0]), $paterm);
    }

}

function TimeHelper($timestamp = false) {
    $t = new TimeHelper;
    return $t->time_from_timestamp($timestamp);
}

?>