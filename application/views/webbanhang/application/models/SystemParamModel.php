<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class SystemParamModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'system_param';
        $this->_list_field = Array('m_name', 'm_value', 'm_comment');
        $this->_primary_field = 'm_name';
    }

    public function add($para = Array('name' => '', 'value' => '', 'comment' => '')) {
        if (!isset($para['name'])) {
            return false;
        }
        if ($this->check_exit($para['name']) == true) {
            return false;
        }
        if (!isset($para['value'])) {
            $para['value'] = '';
        }
        if (!isset($para['comment'])) {
            $para['comment'] = '';
        }
        $add = Array(
            'm_name' => $para['name'],
            'm_value' => $para['value'],
            'm_comment' => $para['comment']
        );
        parent::add($add);
        if ($this->check_exit($para['name']) == true) {
            return true;
        }
        return false;
    }

}
