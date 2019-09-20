<?php

//class phục vụ cho việc xử lí hình ảnh
class image_helper {

    private $_ar_filetype = "";

    public function __construct() {
        $this->_ar_filetype = Array('png' => 'image/png', 'wbmp' => 'image/bmp', 'gif' => 'image/gif', 'jpg' => 'image/jpeg');
    }

    public function get_image_data($path = false) {
        $out = Array(
            'data' => false,
            'type' => false,
            'width' => 0,
            'height' => 0
        );
        if ($path == false) {
            return $out;
        }
        $image = @imagecreatefrompng($path);
        if ($image != null && $image) {
            $out['type'] = 'png';
        } else {
            $image = @imagecreatefromgif($path);
            if ($image != null && $image) {
                $out['type'] = 'gif';
            } else {
                $image = @imagecreatefromwbmp($path);
                if ($image != null && $image) {
                    $out['type'] = 'wbmp';
                } else {
                    $image = @imagecreatefromjpeg($path);
                    if ($image != null && $image) {
                        $out['type'] = 'jpg';
                    } else {
                        $image = false;
                    }
                }
            }
        }
        $out['data'] = $image;
        if ($image == false) {
            return $out;
        }
        $out['width'] = @imagesx($image);
        if (!$out['width']) {
            $out['width'] = 0;
        }
        $out['height'] = @imagesy($image);
        if (!$out['height']) {
            $out['height'] = 0;
        }
        if ($out['height'] != 0) {
            $out['ratio'] = $out['width'] / $out['height'];
        } else {
            $out['ratio'] = 0;
        }
        return $out;
    }

    public function resize($path, $save = false, $option = Array()) {
        /*
          $path=đường dẫn hình ảnh đưa vào
          $save=false, đường dẫn lưu hình dạng 'duong_dan' không gồm file type
          $option=Array
          (
          'type'=>auto//ép kiểu hình thành, auto:giữ nguyên như file vào, jpg, png, gif
          'crop'=>auto,autofill,cut
          'width'=>auto,px
          'height'=>auto,px
          'ratio'=>auto,ratio//tỉ lệ width/height
          )
         */
        if (!isset($option)) {
            $option = Array
                (
                'type' => 'auto',
                'crop' => 'auto',
                'width' => 'auto',
                'height' => 'auto',
                'ratio' => 'auto'
            );
        }
        if (!isset($option['type'])) {
            $option['type'] = 'auto';
        }
        if (!isset($option['crop'])) {
            $option['crop'] = 'auto';
        }
        if (!isset($option['width'])) {
            $option['width'] = 'auto';
        }
        if (!isset($option['height'])) {
            $option['height'] = 'auto';
        }
        if (!isset($option['ratio'])) {
            $option['ratio'] = 'auto';
        }
        $image_in = $this->get_image_data($path);
        if ($image_in['data'] == false) {
            return false;
        }
        if ($option['ratio'] == 'auto') {
            $option['ratio'] = $image_in['ratio'];
        }
        $image_out = Array(
            'data' => $image_in['data'],
            'type' => $image_in['type'],
            'width' => $image_in['width'],
            'height' => $image_in['height']
        );
        if ($option['type'] != 'auto') {
            $image_out['type'] = $option['type'];
        }

        if ($option['width'] != 'auto') {
            $image_out['width'] = $option['width'];
            if ($option['height'] != 'auto') {
                $image_out['height'] = $option['height'];
            } else {
                $image_out['height'] = $image_out['width'] / $option['ratio'];
            }
        } else {
            if ($option['height'] != 'auto') {
                $image_out['height'] = $option['height'];
                $image_out['width'] = $option['ratio'] * $image_out['height'];
            } else {
                $image_out['width'] = $image_in['width'];
                $image_out['height'] = $image_out['width'] / $option['ratio'];
            }
        }
        $image_out['data'] = imagecreatetruecolor($image_out['width'], $image_out['height']);

        $image_out['ratio'] = $image_out['width'] / $image_out['height'];
        if ($option['crop'] == 'autofill') {
            $copy = Array(
                'from_x' => 0,
                'from_y' => 0,
                'from_width' => $image_in['width'],
                'from_height' => $image_in['height'],
                'to_x' => 0,
                'to_y' => 0,
                'to_width' => $image_out['width'],
                'to_height' => $image_out['height']
            );
            $copy['to_height'] = $copy['to_width'] / $image_in['ratio'];
            if ($copy['to_height'] > $image_out['height']) {
                $copy['to_height'] = $image_out['height'];
                $copy['to_width'] = $copy['to_height'] * $image_in['ratio'];
            }
            $copy['to_x'] = ($image_out['width'] - $copy['to_width']) / 2;
            $copy['to_y'] = ($image_out['height'] - $copy['to_height']) / 2;
        } else if ($option['crop'] == 'cut') {
            $copy = Array(
                'from_x' => 0,
                'from_y' => 0,
                'from_width' => $image_in['width'],
                'from_height' => $image_in['height'],
                'to_x' => 0,
                'to_y' => 0,
                'to_width' => $image_out['width'],
                'to_height' => $image_out['height']
            );
            $copy['from_height'] = $copy['from_width'] / $image_out['ratio'];
            if ($copy['from_height'] > $image_in['height']) {
                $copy['from_height'] = $image_in['height'];
                $copy['from_width'] = $copy['from_height'] * $image_out['ratio'];
            }
            $copy['from_x'] = ($image_in['width'] - $copy['from_width']) / 2;
            $copy['from_y'] = ($image_in['height'] - $copy['from_height']) / 2;
        } else {
            $copy = Array(
                'from_x' => 0,
                'from_y' => 0,
                'from_width' => $image_in['width'],
                'from_height' => $image_in['height'],
                'to_x' => 0,
                'to_y' => 0,
                'to_width' => $image_out['width'],
                'to_height' => $image_out['height']
            );
        }
        imagecopyresampled($image_out['data'], $image_in['data'], $copy['to_x'], $copy['to_y'], $copy['from_x'], $copy['from_y'], $copy['to_width'], $copy['to_height'], $copy['from_width'], $copy['from_height']);
        if ($save != false) {
            $this->save_image($image_out, $save);
        }
        return $image_out;
    }

    private function save_image($image_data = false, $savepath = false) {
        if ($image_data == false || $savepath == false) {
            return false;
        }
        if ($image_data['type'] == 'png') {
            imagepng($image_data['data'], $savepath . "." . $image_data['type'], 0);
            return true;
        }
        if ($image_data['type'] == 'gif') {
            imagegif($image_data['data'], $savepath . "." . $image_data['type']);
            return true;
        }
        if ($image_data['type'] == 'jpg') {
            imagejpeg($image_data['data'], $savepath . "." . $image_data['type'], 100);
            return true;
        }
        if ($image_data['type'] == 'wbmp') {
            imagewbmp($image_data['data'], $savepath . "." . $image_data['type']);
            return true;
        }
        return false;
    }

}

function image_helper() {
    $temp = new image_helper;
    return $temp;
}

function image_add_watermast($image_path, $water_path, $savepath = false, $coor_x_mast = 'center', $coor_y_mast = 'middle') {
    $filetype = explode('.', $image_path);
    $filetype = end($filetype);
    $filetype = trim($filetype);
    $filetype_allow = false;
    foreach (get_instance()->config->item('myconfig_array_image_filetype') as $key => $value) {
        if ($filetype == $key) {
            $filetype_allow = true;
        }
    }
    if ($filetype_allow == false) {
        return false;
    }

    switch ($filetype) {
        case 'png': {
                $image = @imagecreatefrompng($image_path);
                break;
            }
        case 'gif': {
                $image = @imagecreatefromgif($image_path);
                break;
            }
        case 'wbmp': {
                $image = @imagecreatefromwbmp($image_path);
                break;
            }
        case 'jpg': {
                $image = @imagecreatefromjpeg($image_path);
                break;
            }
        default : {
                $image = false;
            }
    }
    if ($image == false || !$image) {
        return false;
    }
    $w_current = @imagesx($image);
    $h_current = @imagesy($image);
    if (!$w_current || !$h_current) {
        return false;
    }

    //tạo ảnh water
    $filetype_w = explode('.', $water_path);
    $filetype_w = end($filetype_w);
    $filetype_w = trim($filetype_w);
    $filetype_w_allow = false;
    foreach (get_instance()->config->item('myconfig_array_image_filetype') as $key => $value) {
        if ($filetype_w == $key) {
            $filetype_w_allow = true;
        }
    }
    if ($filetype_w_allow == false) {
        return false;
    }

    switch ($filetype_w) {
        case 'png': {
                $water = @imagecreatefrompng($water_path);
                break;
            }
        case 'gif': {
                $water = @imagecreatefromgif($water_path);
                break;
            }
        case 'wbmp': {
                $water = @imagecreatefromwbmp($water_path);
                break;
            }
        case 'jpg': {
                $water = @imagecreatefromjpeg($water_path);
                break;
            }
        default : {
                $water = false;
            }
    }
    if ($water == false || !$water) {
        return false;
    }
    $water_w_current = @imagesx($water);
    $water_h_current = @imagesy($water);
    if (!$water_w_current || !$water_h_current) {
        return false;
    }
    //end tạo ảnh water
    $temp_at_x = max(($w_current - $water_w_current) / 2, 0);
    if ($coor_x_mast == 'left') {
        $temp_at_x = 0;
    }
    if ($coor_x_mast == 'right') {
        $temp_at_x = $w_current - $water_w_current;
    }

    $temp_at_y = max(($h_current - $water_h_current) / 2, 0);
    if ($coor_y_mast == 'top') {
        $temp_at_y = 0;
    }
    if ($coor_y_mast == 'bottom') {
        $temp_at_y = $h_current - $water_h_current;
    }
    imagecopyresampled($image, $water, $temp_at_x, $temp_at_y, 0, 0, $water_w_current, $water_h_current, $water_w_current, $water_h_current);
    if ($savepath != false) {
        switch ($filetype) {
            case 'png': {
                    imagepng($image, $savepath . "" . $filetype, 0);
                    break;
                }
            case 'gif': {
                    imagegif($image, $savepath . "" . $filetype);
                    break;
                }
            case 'wbmp': {
                    imagewbmp($image, $savepath . "" . $filetype);
                    break;
                }
            case 'jpg': {
                    imagejpeg($image, $savepath . "" . $filetype, 100);
                    break;
                }
            default : {
                    //no save image
                }
        }
    }
    //imagedestroy($image);
    //($water);
    return Array('dataimage' => $image, 'filetype' => $filetype);
}

function text_to_image($text = 'text to write', $savepath = false, $option = Array('max_width' => 300, 'left' => 5, 'top' => 5, 'fontsize' => 10, 'fontcolor' => Array('r' => 0, 'g' => 0, 'b' => 0), 'water_mast_path' => false)) {
    if ($text == "") {
        return false;
    }
    $text = preg_replace('/\n/', ' [[newline]] ', $text);
    //$text= trim(str_replace(array("/\n|\r/"),array(" [[newline]] "), $text));
    $bbox = imagettfbbox($option['fontsize'], 0, realpath('assets/css/fonts/notica.ttf'), "-");
    $white_space = $bbox[4] - $bbox[6];
    $bbox = imagettfbbox($option['fontsize'], 0, realpath('assets/css/fonts/notica.ttf'), "");
    $none_space = $bbox[4] - $bbox[6];
    $array_para_word = Array();
    $array_para_word[0] = "";
    $ar_text = explode(" ", $text);
    $temp_w = 0;
    foreach ($ar_text as $key => $value) {
        $bbox = imagettfbbox($option['fontsize'], 0, realpath('assets/css/fonts/notica.ttf'), $value);
        $x = $bbox[4] - $bbox[6];
        $temp_w += $x;
        if ($temp_w < $option['max_width'] && $value != '[[newline]]') {
            $array_para_word[count($array_para_word) - 1] .= $value . " ";
        } else {
            $temp_w = $x;
            if ($temp_w > $option['max_width']) {
                $max = strlen($value);
                $temp_w2 = 0;
                array_push($array_para_word, "");
                for ($i = 0; $i < $max; $i++) {
                    $w = substr($value, $i, 1);
                    $bbox = imagettfbbox($option['fontsize'], 0, realpath('assets/css/fonts/notica.ttf'), $w);
                    $x2 = $bbox[4] - $bbox[6];
                    $temp_w2 += $x2 + 0.8;
                    if ($temp_w2 < $option['max_width']) {
                        $array_para_word[count($array_para_word) - 1] .= $w;
                    } else {
                        array_push($array_para_word, "");
                        $temp_w2 = $x2;
                        $array_para_word[count($array_para_word) - 1] .= $w;
                    }
                }
            } else {
                if ($value == '[[newline]]') {
                    $temp_w = 0;
                }
                array_push($array_para_word, "");
                $array_para_word[count($array_para_word) - 1] .= $value . " ";
            }
        }
        $temp_w += $white_space;
    }
    $h_printed = 0;
    $ar_to_print = Array();
    foreach ($array_para_word as $key => $line) {
        $str_to_print = $line;
        $bbox = imagettfbbox($option['fontsize'], 0, realpath('assets/css/fonts/notica.ttf'), $str_to_print);
        $h_printed += $bbox[3] - $bbox[5] + 2;
        array_push($ar_to_print, Array('data' => $str_to_print, 'vt' => $h_printed));
    }
    $image = imagecreate($option['max_width'] + 6, $h_printed + 6);
    //imagesavealpha($image, TRUE);
    $empty = imagecolorallocatealpha($image, 255, 255, 255, 127);
    //add water mast
    if ($option['water_mast_path'] != false) {
        imagepng($image, "temp.png", 0);

        $image = image_add_watermast("temp.png", $option['water_mast_path'], false, 'center', 'middle');
        $image = $image['dataimage'];
        if (file_exists('temp.png')) {
            unlink('temp.png');
        }
    }

    $color_text = imagecolorallocate($image, 0, 0, 0);
    if (isset($option)) {
        if (isset($option['fontcolor'])) {
            $tempc = $option['fontcolor'];
            $color_text = imagecolorallocate($image, $tempc['r'], $tempc['g'], $tempc['b']);
        }
    }

    foreach ($ar_to_print as $line) {
        imagettftext($image, $option['fontsize'], 0, 3, $line['vt'], $color_text, realpath('assets/css/fonts/notica.ttf'), str_replace("[[newline]] ", "", $line['data']));
    }

    if ($savepath != false) {
        imagepng($image, $savepath . ".png", 0);
    }
    imagedestroy($image);
}
