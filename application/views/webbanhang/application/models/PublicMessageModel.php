<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PublicMessageModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'public_message';
        $this->_list_field = Array('id', 'm_id_user', 'm_email', 'm_content', 'm_date', 'm_fromlink');
        $this->_primary_field = 'id';
    }

    public function add($data = Array(
        'id_user' => -1,
        'email' => 'email',
        'content' => 'noi dung',
        'strtime' => 'thoi gian',
        'fromlink' => ''
    )) {
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_user' => $data['id_user'],
            'm_content' => $data['content'],
            'm_date' => $data['strtime'],
            'm_email' => $data['email'],
            'm_fromlink' => $data['fromlink']
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

}
