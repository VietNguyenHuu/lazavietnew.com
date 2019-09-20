<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostGroupModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'post_group';
        $this->_list_field = Array('id', 'm_id_user_create', 'm_title', 'm_description', 'm_status', 'm_view', 'm_like', 'm_militime', 'm_militime_modify', 'm_file_type', 'm_seo_title', 'm_seo_keyword', 'm_seo_description');
        $this->_primary_field = 'id';
        $this->_avata_folder = "upload/img/post_group_avata/";
        $this->_avata_default = "upload/img/post_group_avata/default.png";
        $this->_avata_thumb = Array(
            'small' => Array('path' => 'upload/img/post_group_avata_thumb/', 'width' => 200, 'height' => 200),
            'verysmall' => Array('path' => 'upload/img/post_group_avata_thumb_small/', 'width' => 60, 'height' => 60)
        );
        $this->_str_link = "series/{{m_title}}-{{id}}.html";
    }
    
    public function label_status()
    {
        return [
            'public' => 'Công khai',
            'trash' => 'Đã xóa'
        ];
    }

    public function add($data = Array(
        'id_user' => 1,
        'title' => 'ten nhom bai viet',
        'description' => ''
    )) {
        $id = $this->SystemModel->get_id();
        $t = time();
        $add = array(
            'id' => $id,
            'm_id_user_create' => $data['id_user'],
            'm_title' => $data['title'],
            'm_description' => $data['description'],
            'm_militime' => $t,
            'm_status' => 'public',
            'm_militime_modify' => $t
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

    public function del($id) {
        /*
         * Move post group into trash, not delete
         */
        $post_row = $this->get_row($id);
        if ($post_row == false) {
            return false;
        }
        $this->set($id, 'm_status', 'trash');
        return true;
    }

    public function penaty_del($id) {
        /*
         * Delete post group in trash
         */
        $post_row = $this->get_row($id);
        if ($post_row == false) {
            return false;
        }
        $this->del_avata($id);
        parent::del($id);
        if ($this->check_exit($id) != false) {
            return false;
        }
        /*
         * Reset group index for post with this group
         */
        $this->db->query("UPDATE " . $this->PostContentModel->get_table_name() . " SET m_group_index = 0 WHERE m_id_group = " . $id);
        
        /*
         * Delete group out of it's post
         */
        $this->db->query("UPDATE " . $this->PostContentModel->get_table_name() . " SET m_id_group = -1 WHERE m_id_group = " . $id);
        
        return true;
    }

    public function get_link_from_row($data = Array('id' => -1, 'title' => "")) {
        if (!isset($data['id'])) {
            return false;
        }
        if ($data['id'] == -1) {
            return false;
        }
        return parent::get_link_from_row(['id' => $data['id'], 'm_title' => $data['title']]);
    }

    public function get_avata_small($id) {
        return parent::get_avata($id, 'verysmall');
    }
}