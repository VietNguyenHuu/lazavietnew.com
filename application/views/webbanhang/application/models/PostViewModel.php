<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostViewModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'post_view';
        $this->_list_field = Array(
            'id_post', 'm_n1', 'm_n2', 'm_n3', 'm_n4',
            'm_n5', 'm_n6', 'm_n7', 'm_2day', 'm_3day',
            'm_week', 'm_week_max'
        );
        $this->_primary_field = "id_post";
    }

    public function add($data = Array(
        'id_post' => -1
    )) {
        $add = array(
            'id_post' => $data['id_post']
        );
        parent::add($add);
        if ($this->check_exit($add['id_post'])) {
            return $add['id_post'];
        }
        return false;
    }

    public function del($id) {
        parent::del($id);
        if ($this->check_exit($id) != false) {
            return false;
        }

        return true;
    }

    public function view($id) {
        if ($this->check_exit($id)) {
            $data_row = $this->get_row($id);
            $this->set($id, "m_n1", $data_row->m_n1 + 1);
            return $data_row->m_n1 + 1;
        } else {
            return false;
        }
    }

    public function view_reset() {
        $this->db->query("UPDATE " . $this->get_table_name() . " SET m_2day=m_n1,m_3day=m_n1+m_n2,m_week=m_n1+m_n2+m_n3+m_n4+m_n5+m_n6,m_n7=m_n6,m_n6=m_n5,m_n5=m_n4,m_n4=m_n3,m_n3=m_n2,m_n2=m_n1,m_n1=0");
        $this->CacheModel->del('template_home_topauthor'); //Cập nhật lại top tác giả tuần
        return true;
    }

}

?>