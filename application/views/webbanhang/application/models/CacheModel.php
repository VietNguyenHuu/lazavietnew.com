<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class CacheModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'cache';
        $this->_list_field = Array(
            'm_name', 'm_content'
        );
        $this->_primary_field = "m_name";
    }

    public function add($data = Array(
        'name' => 'name',
        'content' => 'content'
    )) {
        if ($this->check_exit($data['name']) == true) {
            $this->set($data['name'], 'm_content', $data['content']);
            return true;
        }
        $add = array(
            'm_name' => $data['name'],
            'm_content' => $data['content']
        );
        parent::add($add);
        if ($this->check_exit($add['m_name'])) {
            return $add['m_name'];
        }
        return false;
    }

    public function del($id) {
        parent::del($id);
        if ($this->check_exit($id) != false) {
            return false;
        }
        return true;
    }

    public function get_num_row() {
        return $this->db->get($this->_table_name)->num_rows();
    }
}