<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostReportModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'post_report';
        $this->_list_field = Array(
            'id', 'm_id_user', 'm_id_post', 'm_id_pattern', 'm_ex', 'm_militime'
        );
        $this->_primary_field = 'id';
    }

    public function add($data = Array(
        'id_user' => -1,
        'id_post' => -1,
        'id_pattern' => -1,
        'ex' => "Lý do thêm"
    )) {
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_user' => $data['id_user'],
            'm_id_post' => $data['id_post'],
            'm_id_pattern' => $data['id_pattern'],
            'm_ex' => $data['ex'],
            'm_militime' => time()
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

}
