<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class SystemModel extends BaseModel{

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'system';
        $this->_list_field = Array(
            'id', 'm_creatted_id', 'm_count_access'
        );
        $this->_primary_field = "id";
    }

    public function findAll() {
        return parent::getAll();
    }

    public function get_id() {
        $row = $this->get_row(1);
        if (empty($row)){
            return 0;
        }
        $this->set(1, 'm_creatted_id', $row->m_creatted_id + 1);
        return $row->m_creatted_id;
    }

    public function get_access() {
        $row = $this->get_row(1);
        if (empty($row)){
            return 0;
        }
        return $row->m_count_access;
    }

    public function increase_access() {
        $row = $this->get_row(1);
        if (empty($row)){
            return 0;
        }
        $this->set(1, 'm_count_access', $row->m_count_access + 1);
        return $row->m_count_access;
    }
}