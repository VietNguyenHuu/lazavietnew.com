<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class AdvertimentModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'advertiment';
        $this->_list_field = Array('id', 'm_id_user', 'm_title', 'm_link', 'm_view', 'm_click', 'm_type', 'm_status', 'm_id_user_check', 'm_file_type');
        $this->_primary_field = "id";
        $this->_avata_field = "m_file_type";
        $this->_avata_folder = "upload/img/advertiment_avata/";
        $this->_avata_default = "upload/img/advertiment_avata/default.png";
        $this->_avata_thumb = Array(
           'small'=>Array('path'=>"upload/img/advertiment_avata_thumb/", 'width'=>300, 'height'=>300)
         );
    }

    public function add($data = Array(
        'title' => 'Tên quảng cáo',
        'link' => 'link',
        'type' => 'navi'
    )) {
        if (!in_array($data['type'], Array('navi', 'main'))) {
            $data['type'] = 'navi';
        }
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_user' => $this->UserModel->check_login(),
            'm_title' => $data['title'],
            'm_link' => $data['link'],
            'm_view' => 0,
            'm_click' => 0,
            'm_type' => $data['type'],
            'm_status' => 'on',
            'm_id_user_check' => -1,
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

    public function del($id) {
        parent::del($id);
        if ($this->check_exit($id) != false) {
            return false;
        }
        $this->del_avata($id);
        return true;
    }

    public function get_rand($type = 'navi') {
        $num = $this->db->query("SELECT id FROM " . $this->get_table_name() . " WHERE m_status='on' AND m_type='" . $type . "'")->num_rows();
        if ($num < 1) {
            return false;
        }
        $kq = $this->db->query("SELECT * FROM " . $this->get_table_name() . " WHERE m_status='on'  AND m_type='" . $type . "' ORDER BY id DESC LIMIT " . rand(0, $num - 1) . ",1")->result();
        if (!empty($kq)){
            $this->view($kq[0]->id);
            return $kq;
        } else {
            return false;
        }
    }

    public function check_publish($id) {
        if (in_array($this->get($id, "m_status"), Array('on'))) {
            return true;
        } else {
            return false;
        }
    }

    public function view($id) {
        
        $this->set($id, "m_view", $this->get($id, "m_view") + 1);
        return $this->get($id, "m_view");
        
    }
}
?>