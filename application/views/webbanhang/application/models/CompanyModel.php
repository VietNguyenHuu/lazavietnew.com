<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class CompanyModel extends CI_Model {

    private $_table_name = "";
    private $_list_field = Array();

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'company';
        $this->_list_field = Array('id', 'm_title', 'm_leader', 'm_phone', 'm_address', 'm_link', 'm_province_code', 'm_province_name');
    }

    public function add($data = Array(
        'm_title' => 'tên công ty',
        'm_leader' => 'giám đốc',
        'm_phone' => 'số điện thoại',
        'm_address' => 'địa chỉ',
        'm_link' => 'website',
        'm_province_code' => '-1',
        'm_province_name' => 'tên tỉnh'
    )) {
        $this->db->insert($this->_table_name, $data);
        return true;
    }

    public function del($id) {
        if ($this->check_exit($id) == false) {
            return false;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->_table_name);
        if ($this->check_exit($id) != false) {
            return false;
        }
        return true;
    }

    public function get($id, $field) {
        if ($this->check_exit($id) == false) {
            return false;
        }
        if (!in_array($field, $this->_list_field)) {
            return false;
        }
        $this->db->where('id', $id);
        return $this->db->get($this->_table_name)->row()->$field;
    }

    public function get_table_name() {
        return $this->_table_name;
    }

    public function set($id, $field, $new) {
        if ($this->check_exit($id) == false) {
            return false;
        }
        if (!in_array($field, $this->_list_field)) {
            return false;
        }
        $this->db->where('id', $id);
        $this->db->update($this->_table_name, Array($field => $new));
        return true;
    }

    public function check_exit($id) {
        $this->db->where('id', $id);
        if ($this->db->get($this->_table_name)->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>