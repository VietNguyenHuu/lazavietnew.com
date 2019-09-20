<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class TinNhanModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'message';
        $this->_list_field = Array('id', 'm_id_user_from', 'm_id_user_to', 'm_content', 'm_militime_send', 'm_militime_receive', 'm_is_show', 'm_feel', 'm_is_spam');
        $this->_primary_field = 'id';
    }

    public function add($data = Array(
        'id_user_from' => -1,
        'id_user_to' => -1,
        'content' => 'nội dung tin nhắn'
    )) {
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_user_to' => $data['id_user_to'],
            'm_id_user_from' => $data['id_user_from'],
            'm_content' => $data['content'],
            'm_militime_send' => time()
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

}
