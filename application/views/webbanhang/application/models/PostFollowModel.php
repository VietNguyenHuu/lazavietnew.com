<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostFollowModel extends BaseModel 
{

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'post_follow';
        $this->_list_field = Array(
            'id', 'm_id_user', 'm_type', 'm_id_value'//m_type in post, type, author
        );
        $this->_primary_field = 'id';
    }

    public function add($data = Array(
        'id_user' => -1,
        'm_type' => 'post',
        'id_value' => -1
    )) {
        if ($this->UserModel->check_exit($data['id_user']) != true) {
            return false;
        }
        if (isset($data['m_type'])) {
            if (!in_array($data['m_type'], array('post', 'type', 'author'))) {
                $data['m_type'] = 'post';
            }
        } else {
            $data['m_type'] = 'post';
        }
        if ($this->check_followed($data['id_user'], $data['m_type'], $data['id_value']) != false) {
            return false;
        }
        if ($data['m_type'] == 'type') {
            if ($this->PostTypeModel->check_exit($data['id_value']) != true) {
                return false;
            }
        }
        if ($data['m_type'] == 'post') {
            if ($this->PostContentModel->check_exit($data['id_value']) != true) {
                return false;
            }
        }
        if ($data['m_type'] == 'author') {
            if ($this->UserModel->check_exit($data['id_value']) != true) {
                return false;
            }
        }
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_user' => $data['id_user'],
            'm_type' => $data['m_type'],
            'm_id_value' => $data['id_value']
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

    public function get_follow_count($type = 'post', $value = -1) {
        $value = (int) $value;
        $this->db->where("m_type='" . $type . "' AND m_id_value=" . $value);
        return $this->db->get($this->_table_name)->num_rows();
    }

    public function check_followed($id_user, $type, $value) {
        $this->db->where("m_id_user=" . $id_user . " AND m_type='" . $type . "' AND m_id_value=" . $value);
        if ($this->db->get($this->_table_name)->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}