<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostTagsModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'post_tags';
        $this->_list_field = Array(
            'id', 'm_id_post', 'm_title', 'm_title_search'
        );
        $this->_primary_field = 'id';
        $this->_str_link = "post/tags/{{m_title}}";
    }

    public function add($data = Array(
        'id_post' => -1,
        'title' => 'ten tags'
    )) {
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_post' => $data['id_post'],
            'm_title' => $data['title']
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            $this->set_title_search($add['id']);
            $this->CacheModel->del("template_posttype_toptags");
            return $add['id'];
        }
        return false;
    }

    public function del($id) {
        if ($this->check_exit($id) == false) {
            return false;
        }
        parent::del($id);
        if ($this->check_exit($id) != false) {
            return false;
        }
        $this->CacheModel->del("template_posttype_toptags");
        return true;
    }

    public function get_link_from_id($id) {
        $data = $this->get_row($id);
        if ($data == false) {
            return false;
        }
        return $this->get_link_from_row(['m_title' => $data->m_title]);
    }


    public function set($id, $field, $new) {
        if ($field == 'm_title') {
            $this->CacheModel->del("template_posttype_toptags");
        }
        return parent::set($id, $field, $new);
    }

    public function set_title_search($id) {
        $row = $this->get_row($id);
        if ($row == false) {
            return false;
        }
        $this->set($id, 'm_title_search', mystr()->addmask(bodau($row->m_title)));
        return true;
    }
}