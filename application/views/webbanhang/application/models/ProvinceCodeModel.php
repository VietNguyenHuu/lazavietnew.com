<?php

class ProvinceCodeModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'province_code';
        $this->_list_field = Array('m_code', 'm_title');
        $this->_primary_field = 'm_code';
    }

    public function add($data = Array(
        'code' => 0,
        'title' => 'tên tỉnh'
    )) {
        if ($this->check_exit($data['code'])) {
            return false;
        }
        $add = array(
            'm_code' => $data['code'],
            'm_title' => $data['title']
        );
        parent::add($add);
        if ($this->check_exit($add['m_code'])) {
            return $add['m_code'];
        }
        return false;
    }

}
