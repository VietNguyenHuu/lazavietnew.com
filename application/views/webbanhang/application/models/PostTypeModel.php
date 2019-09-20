<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostTypeModel extends BaseModel {
    public function __construct() {
        parent::__construct();
        $this->_table_name = 'post_type';
        $this->_primary_field = "id";
        $this->_avata_field = "m_file_type";
        $this->_list_field = Array('id', 'm_id_parent', 'm_title', 'm_index', 'm_status', 'm_view', 'm_new_post_time', 'm_ar_direct_type', 'm_ar_list_type', 'm_seo_title', 'm_seo_keyword', 'm_seo_description');
        $this->_avata_folder = "upload/img/post_type_avata/";
        $this->_avata_default = "assets/img/default_avata/post_type.png";
        $this->_str_link = "danh-muc/{{m_title}}-{{id}}.html";
    }
    
    public function add($data = Array(
        'id_parent' => 1,
        'title' => 'ten trang'
    )) {
        $data['index'] = $this->get_current_index($data['id_parent']) + 1;
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_parent' => $data['id_parent'],
            'm_title' => $data['title'],
            'm_index' => $data['index'],
            'm_status' => 'ready',
            'm_view' => 0
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            $this->update_all_direct_type();
            $this->CacheModel->del("template_home_menutype");
            return $add['id'];
        }
        return false;
    }

    public function del($id) {
        if ($this->check_exit($id) == false) {
            return false;
        }
        //xóa tất cả category thuộc category này
        $list_category = $this->get_direct_type($id);
        if ($list_category != false) {
            foreach ($list_category as $r) {
                $this->del($r['id']);
            }
        }
        //end xóa tất cả category
        parent::del($id);
        if ($this->check_exit($id) != false) {
            return false;
        }
        $this->update_all_direct_type();
        $this->CacheModel->del("template_home_menutype");
        return true;
    }

    public function get_link_from_row($data = Array('id' => -1, 'title' => "", 'page' => 1)) {
        if (!isset($data)) {
            return false;
        }
        if (!isset($data['id'])) {
            $data['id'] = 1;
        }
        if (!isset($data['title'])) {
            $data['title'] = "";
        }
        if (!isset($data['page'])) {
            $data['page'] = 1;
        }
        $data2 = array('id' => $data['id'], 'm_title' => $data['title']);
        $link = parent::get_link_from_row($data2);
        if ($data['page'] != 1) {
            return str_replace(".html", "/trang-" . $data['page'] . ".html", $link);
        }
        return $link;
    }

    public function get_link_from_id($id, $page = 1) {
        $data = $this->get_row($id);
        if ($data == false) {
            return false;
        }
        $link = parent::get_link_from_row($data);
        if($page != 1){
            return str_replace(".html", "/trang-" . $page . ".html", $link);
        }
        return $link;
    }

    public function set($id, $field, $new) {
        parent::set($id, $field, $new);
        $this->CacheModel->del("template_home_menutype");
        return true;
    }

    public function check_publish($id) {
        if (in_array($this->get($id, "m_status"), Array('ready'))) {
            return true;
        } else {
            return false;
        }
    }

    public function get_current_index($id_parent) {
        $sql = "SELECT count(*) AS t FROM " . $this->_table_name . " WHERE m_id_parent=" . $id_parent;
        $data = $this->db->query($sql);
        if ($data->num_rows() < 1) {
            return 0;
        }

        return $data->row()->t;
    }

    public function get_direct_type($id_parent) {
        $this->db->where('m_id_parent', $id_parent);
        if ($this->db->get($this->_table_name)->num_rows() < 1) {
            return false;
        }
        $this->db->where('m_id_parent', $id_parent);
        $this->db->order_by('m_index', 'asc');
        return $this->db->get($this->_table_name)->result_array();
    }

    public function get_direct_type_2($id_parent) {
        $ar = $this->get($id_parent, 'm_ar_direct_type');
        if ($ar == false || $ar == '' || $ar == null) {
            return false;
        }
        return explode(",", $ar);
    }

    public function get_link_type($id_type) {
        if ($id_type == 1) {
            return array('1');
        }
        if ($this->check_exit($id_type) == false) {
            return false;
        }
        $ar = Array();
        $pre = $id_type;
        do {
            array_push($ar, $id_type);
            $pre = $id_type;
            $id_type = $this->get($id_type, 'm_id_parent');
        } while ($this->check_exit($pre) != false && $pre != 1);
        return array_reverse($ar);
    }

    public function get_list_type(&$ar, $id_parent) {
        array_push($ar, $id_parent);
        $this->db->where('m_id_parent', $id_parent);
        $this->db->order_by('m_index', 'asc');
        $d = $this->db->get($this->_table_name);
        if ($d->num_rows() > 0) {
            $data = $d->result_array();

            for ($i = 0; $i < count($data); $i++) {
                $this->get_list_type($ar, $data[$i]['id']);
            }
        } else {
            
        }
    }

    public function update_all_new_post() {
        $ar = $this->db->query("SELECT id FROM " . $this->_table_name)->result();
        if (count($ar) > 0) {
            foreach ($ar as $line) {
                $ar_list_type = Array();
                $this->get_list_type($ar_list_type, $line->id);
                if (count($ar_list_type) > 0) {
                    $ar_list_type = implode(",", $ar_list_type);
                } else {
                    $ar_list_type = $line->id;
                }
                $newpost = $this->db->query("SELECT m_militime FROM " . $this->PostContentModel->get_table_name() . " WHERE (m_id_type IN(" . $ar_list_type . ") AND m_status='public') ORDER BY m_militime DESC LIMIT 0,1")->row();
                if ($newpost != null && $newpost != false) {
                    $this->set($line->id, 'm_new_post_time', $newpost->m_militime);
                } else {
                    $this->set($line->id, 'm_new_post_time', 0);
                }
            }
        }
    }

    public function update_all_direct_type() {
        $ar = $this->db->query("SELECT id FROM " . $this->_table_name)->result();
        if (count($ar) > 0) {
            foreach ($ar as $line) {
                $this->db->where('m_id_parent', $line->id);
                $this->db->order_by('m_index', 'asc');
                $ar_list = $this->db->get($this->_table_name)->result();
                $max = count($ar_list);
                if ($max > 0) {
                    for ($i = 0; $i < $max; $i++) {
                        $ar_list[$i] = $ar_list[$i]->id;
                    }
                    $this->set($line->id, 'm_ar_direct_type', implode(",", $ar_list));
                } else {
                    $this->set($line->id, 'm_ar_direct_type', "");
                }
            }
        }
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

?>