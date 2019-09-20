<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostCommentModel extends BaseModel 
{
    public function __construct() {
        parent::__construct();
        $this->_table_name = 'post_comment';
        $this->_list_field = Array('id', 'm_id_content', 'm_id_user', 'm_content', 'm_date', 'm_status', 'm_rank');
        $this->_primary_field = "id";
    }

    public function add($data = Array('id_content' => 2, 'id_user' => 2, 'content' => "nội dung bình luận", 'date' => '1970-06-18')) {
        if ($this->PostContentModel->check_exit($data['id_content']) == false) {
            return false;
        }
        if ($this->UserModel->check_exit($data['id_user']) == false) {
            return false;
        }
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_id_content' => $data['id_content'],
            'm_id_user' => $data['id_user'],
            'm_content' => $data['content'],
            'm_date' => $data['date'],
            'm_status' => 'ready',
            'm_rank' => '0'
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

    public function get_rank($id) {
        if ($this->check_exit($id)) {
            if ($this->get($id, 'm_rank') == 0)
                return 0;
            $str = explode("/", $this->get($id, 'm_rank'));
            $temp = explode(".", $str[0] / $str[1] . "");
            return $temp[0];
        }
        else {
            return false;
        }
    }

    public function rank($id, $rank) {
        if ($this->check_exit($id)) {
            if ($this->get($id, 'm_rank') == '0') {
                $this->set($id, 'm_rank', $rank . "/1");
            } else {
                $str = explode("/", $this->get($id, 'm_rank'));
                $str[1] ++;
                $str[0] += $rank;
                $this->set($id, 'm_rank', implode("/", $str));
            }
            return $this->get_rank($id);
        } else {
            return false;
        }
    }

}