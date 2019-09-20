<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class BaseModel extends CI_Model {

    protected $_table_name = "";
    protected $_list_field = Array();
    protected $_primary_field = "";
    protected $_avata_field = "";
    protected $_avata_folder = "";
    protected $_avata_default = "";

    /**
     *  Thumbnail avatar
     * Array(
     *      'small'=>Array('path'=>"upload/post_thumb1/", 'width'=>200, 'height'=>200),
     *      'verysmall'=>Array('path'=>"upload/post_thumb2/", 'width'=>100, 'height'=>100)
     * )
     */
    protected $_avata_thumb = Array();
    protected $_str_link = "";

    public function __construct() {
        parent::__construct();
        $this->_avata_field = "m_file_type";
        $this->_avata_default = "assets/img/system/logo.png";
    }

    public function add($data = Array()) {
        if (isset($data[$this->_primary_field])){
            if (empty($data[$this->_primary_field])){
                return false;
            }
        }
        $this->db->insert($this->_table_name, $data);
        return true;
    }

    public function del($id) {
        $this->db->where($this->_primary_field, $id);
        $this->db->delete($this->_table_name);
        return true;
    }
    
    public function delAllData() {
        $this->db->query("TRUNCATE " . $this->_table_name);
        return true;
    }

    public function get($id, $field) {
        if (!in_array($field, $this->_list_field)) {
            return false;
        }
        $this->db->where($this->_primary_field, $id);
        $t = $this->db->get($this->_table_name)->row();
        if ($t === false || $t === null) {
            return false;
        }
        return $t->$field;
    }

    public function get_row($id) {
        $this->db->where($this->_primary_field, $id);
        $t = $this->db->get($this->_table_name)->row();
        if ($t === false || $t === null) {
            return false;
        }
        return $t;
    }

    public function get_num_row() {
        return $this->db->get($this->_table_name)->num_rows();
    }
    
    public function getAll() {
        $data = $this->db->get($this->_table_name)->result();
        if (count($data) < 1) {
            return false;
        }
        return $data;
    }

    public function get_table_name() {
        return $this->_table_name;
    }

    public function get_link_from_row($data = Array()) {
        $ar_key = Array();
        $value = Array();
        foreach ($data as $keyline => $valueline) {
            array_push($ar_key, "{{" . $keyline . "}}");
            array_push($value, dn_urlencode($valueline, 80));
        }
        return str_replace($ar_key, $value, $this->_str_link);
    }

    public function get_link_from_id($id) {
        $this->db->where($this->_primary_field, $id);
        $t = $this->db->get($this->_table_name)->row_array();
        if ($t === false || $t === null) {
            return false;
        }
        return $this->get_link_from_row($t);
    }

    public function filter($field, $value) {
        if (!in_array($field, $this->_list_field)) {
            return false;
        }
        $this->db->where($field, $value);
        if ($this->db->get($this->_table_name)->num_rows() > 0) {
            $this->db->where($field, $value);
            return $this->db->get($this->_table_name)->result();
        }
        return false;
    }

    public function check_exit($id) {
        $this->db->where($this->_primary_field . "", $id);
        if ($this->db->get($this->_table_name)->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_avata($id, $thumb_label = 'small') {
        if (!isset($this->_avata_thumb[$thumb_label])) {
            return $this->get_avata_original($id);
        }
        if (file_exists($this->_avata_thumb[$thumb_label]['path'] . "" . $id . ".jpg")) {
            return $this->_avata_thumb[$thumb_label]['path'] . "" . $id . ".jpg";
        }
        return $this->get_avata_original($id);
    }

    public function get_avata_original($id) {
        if (file_exists($this->_avata_folder . "" . $id . "." . $this->get($id, $this->_avata_field))) {
            return $this->_avata_folder . "" . $id . "." . $this->get($id, $this->_avata_field);
        }
        return $this->_avata_default;
    }

    public function set($id, $field, $new) {
        if (!in_array($field, $this->_list_field)) {
            return false;
        }
        $this->db->where($this->_primary_field, $id);
        $this->db->update($this->_table_name, Array($field => $new));
        return true;
    }

    public function set_avata($id, $avata = false) {
        $avata = explode(";base64,", $avata);
        if (count($avata) > 1) {
            $avata_metadata = $avata[0];
            $avata = $avata[1];
            $avata = base64_decode($avata);
            $file_type = false;
            foreach ($this->config->item('myconfig_array_image_filetype') as $key => $value) {
                if ("data:" . $value == $avata_metadata) {
                    $file_type = $key;
                }
            }
            if ($file_type == false) {
                $file_type = 'gif';
            }
            $filepath = $this->_avata_folder . "" . $id . "." . $file_type;
            $this->del_avata($id);
            file_put_contents($filepath, $avata);
            $this->set($id, 'm_file_type', $file_type);
            if (file_exists($filepath)) {
                $this->set_avata_thumb($id, $filepath);
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function set_avata_thumb($id, $avata_origin = false) {
        if (!file_exists($avata_origin)) {
            $avata_origin = $this->get_avata_original($id);
        }
        foreach ($this->_avata_thumb as $key => $avatar_thumb_line) {
            $thumb = image_helper()->resize($avata_origin, $avatar_thumb_line['path'] . "" . $id, Array('width' => $avatar_thumb_line['width'], 'height' => $avatar_thumb_line['height'], 'crop' => 'cut', 'type' => 'jpg'));
        }
        return true;
    }

    public function del_avata($id) {
        if (file_exists($this->_avata_folder . "" . $id . "." . $this->get($id, $this->_avata_field))) {
            unlink($this->_avata_folder . "" . $id . "." . $this->get($id, $this->_avata_field));
        }
        foreach ($this->_avata_thumb as $key => $avatar_thumb_line) {
            if (file_exists($avatar_thumb_line['path'] . "" . $id . ".jpg")) {
                unlink($avatar_thumb_line['path'] . "" . $id . ".jpg");
            }
        }
        return true;
    }

}

?>