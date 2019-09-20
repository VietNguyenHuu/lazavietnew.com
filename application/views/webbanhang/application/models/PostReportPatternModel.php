<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostReportPatternModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'post_report_pattern';
        $this->_list_field = Array(
            'id', 'm_title', 'm_index'
        );
        $this->_primary_field = 'id';
    }

    public function add($data = Array(
        'title' => 'Tên pattern'
    )) {
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_title' => $data['title'],
            'm_index' => $this->get_num_row() + 1
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

}