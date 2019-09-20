<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class StaticPageModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'static_page';
        $this->_list_field = [
            'id',
            'm_id_parent',
            'm_type',
            'm_title',
            'm_title_shorcut',
            'm_link',
            'm_index',
            'm_content',
            'm_status',
            'm_view',
            'm_is_primary',
            'm_option_showheader',
            'm_option_showinheader',
            'm_option_showfooter',
            'm_option_showinfooter',
            'm_option_showbreakcump',
            'm_option_showfullshare',
            'm_option_showquickmessage',
            'm_adding_css',
            'm_adding_js'
        ];
        $this->_primary_field = 'id';
        $this->_avata_folder = "upload/img/static_page_avata/";
        $this->_avata_default = "assets/img/default_avata/staticpage.png";
        $this->_avata_thumb = Array(
            'small' => Array('path' => "upload/img/static_page_avata_thumb/", 'width' => 50, 'height' => 50)
        );
        $this->_str_link = "page/{{m_title}}-{{id}}.html";
    }

    public function label_type() {
        return [
            'system' => 'Hệ thống',
            'static' => 'Trang tĩnh'
        ];
    }

    public function label_status() {
        return [
            'on' => 'Hiển thị',
            'off' => 'Ẩn'
        ];
    }

    public function add($data = Array(
        'id_parent' => 1,
        'type' => 'static',
        'title' => 'ten trang',
        'link' => 'index.php'
    )) {
        $data['index'] = $this->get_current_index($data['id_parent']) + 1;
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_parent' => $data['id_parent'],
            'm_type' => $data['type'],
            'm_title' => $data['title'],
            'm_link' => $data['link'],
            'm_index' => $data['index'],
            'm_content' => '',
            'm_status' => 'on',
            'm_view' => 0,
            'm_is_primary' => 0
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

    public function del($id) {
        if ($this->check_exit($id) == false) {
            return false;
        }
        $ar = $this->filter('m_id_parent', $id);
        if ($ar != false) {
            return false;
        }
        parent::del($id);
        if ($this->check_exit($id) != false) {
            return false;
        }
        $this->del_avata($id);
        return true;
    }

    public function get_link_from_id($id) {
        $data = $this->get_row($id);
        if ($data == false) {
            return false;
        }
        if ($data->m_type == 'system') {
            return $data->m_link;
        }
        return parent::get_link_from_row(['id' => $data->id, 'm_title' => $data->m_title]);
    }

    public function check_publish($id) {
        if (in_array($this->get($id, "m_status"), Array('on'))) {
            return true;
        } else {
            return false;
        }
    }

    public function get_current_index($id_parent) {
        $sql = "SELECT count(*) AS t FROM static_page WHERE m_id_parent=" . $id_parent;
        $data = $this->db->query($sql);
        if ($data->num_rows() < 1) {
            return 0;
        }

        return $data->row()->t;
    }

    public function get_direct_type($id_parent) {
        $this->db->where('m_id_parent', $id_parent);
        $this->db->order_by('m_index', 'asc');
        if ($this->db->get($this->_table_name)->num_rows() < 1) {
            return false;
        }
        $this->db->where('m_id_parent', $id_parent);
        $this->db->order_by('m_index', 'asc');
        return $this->db->get($this->_table_name)->result_array();
    }

    public function view($id) {
        if ($this->check_exit($id)) {
            $this->set($id, "m_view", $this->get($id, "m_view") + 1);
            return $this->get($id, "m_view");
        } else {
            return false;
        }
    }

}
