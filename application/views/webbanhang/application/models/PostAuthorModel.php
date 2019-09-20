<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostAuthorModel extends BaseModel
{

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'post_author';
        $this->_list_field = Array(
            'id', 'm_id_user', 'm_date', 'm_status', 'm_score_multi'
        );
        $this->_primary_field = "id";
        $this->_str_link = "tac-gia/{{user_realname}}-{{id_author}}.html";
    }

    public function add($data = Array(
        'id_user' => -1,
        'date' => -1,
        'status' => 'active',
        'score_multi' => 1
    )) 
    {
        if ($this->filter('m_id_user', $data['id_user']) != false) {
            return false;
        }
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_user' => $data['id_user'],
            'm_date' => time(),
            'm_status' => $data['status'],
            'm_score_multi' => $data['score_multi']
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

    public function get_link_from_id($id) {
        $data = $this->UserModel->get_row($id);
        if ($data == false) {
            return false;
        }
        return parent::get_link_from_row(['id_author' => $id, 'user_realname' => $data->m_realname]);
    }
}

?>