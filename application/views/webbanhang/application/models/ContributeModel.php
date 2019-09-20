<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class ContributeModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'contribute';
        $this->_list_field = Array('id', 'm_id_user', 'm_content', 'm_date');
        $this->_primary_field = "id";
    }

    public function add($data = Array(
        'id_user' => -1,
        'content' => 'noi dung',
        'strtime' => 'thoi gian'
    )) {
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_user' => $data['id_user'],
            'm_content' => $data['content'],
            'm_date' => $data['strtime']
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

    public function del($id) {
        return (parent::del($id)) ? true : false;
    }
}