<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class PostcontentModel extends BaseModel {

    private $_table_name_content = "";
    private $_layout_item = "";

    public function __construct() {
        parent::__construct();
        $this->_table_name = "post_content";
        $this->_table_name_content = 'post_content_content';
        $this->_list_field = 
        [
            'id', 'm_id_type', 'm_id_user', 'm_id_group',
            'm_group_index', 'm_title', 'm_title_search', 'm_content',
            'm_status', 'm_view', 'm_like', 'm_date', 'm_rank',
            'm_militime', 'm_id_user_check', 'm_avata_hide', 'm_file_type',
            'm_seo_title', 'm_seo_keyword', 'm_seo_description'
        ];
        $this->_primary_field = "id";
        $this->_avata_field = "m_file_type";
        $this->_avata_folder = "upload/img/post_content_avata/";
        $this->_avata_default = "assets/img/default_avata/post_content.png";
        $this->_avata_thumb = Array(
            'small' => Array('path' => 'upload/img/post_content_avata_thumb/', 'width' => 200, 'height' => 200),
            'verysmall' => Array('path' => 'upload/img/post_content_avata_thumb_small/', 'width' => 60, 'height' => 60)
        );
        $this->_str_link = "bai-viet/{{m_title}}-{{id}}.html";
        $this->_layout_item = $this->load->design('block/post/item.php');
    }

    public function add($data = Array(
        'id_user' => 1,
        'title' => 'ten bai viet'
    )) {
        $data['date'] = TimeHelper()->to_str();
        $id = $this->SystemModel->get_id();
        $add = array(
            'id' => $id,
            'm_id_type' => 1,
            'm_id_user' => $data['id_user'],
            'm_title' => $data['title'],
            'm_status' => 'ready',
            'm_view' => 0,
            'm_like' => 0,
            'm_date' => TimeHelper()->to_str(),
            'm_rank' => 0,
            'm_militime' => time(),
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            $add2 = Array('id' => $id, 'm_content' => '');
            $this->db->insert($this->_table_name_content, $add2);

            $this->PostViewModel->add(Array('id_post' => $add['id']));
            $this->set_title_search($add['id']);

            return $add['id'];
        }
        return false;
    }

    public function del($id) {
        $post_row = $this->get_row($id, false);
        if ($post_row == false) {
            return false;
        }
        if ($post_row->m_id_user_check != -1) {//bài viết đã được duyệt, không cho xoá, sửa sau
            $current_user = $this->UserModel->check_login();
            if ($current_user == false) {
                return false;
            }
            if ($this->UserModel->get($current_user, 'm_level') < 3) {
                return false;
            }
        }
        $this->set($id, 'm_status', 'trash'); //đưa vào thùng rác
        return true;
    }

    public function del_pdf($id) {
        if (file_exists("download/post_pdf/" . $id . '.pdf')) {
            unlink("download/post_pdf/" . $id . '.pdf');
        }
        return true;
    }

    public function penaty_del($id) {//xoá trong thùng rác
        $post_row = $this->get_row($id, false);
        if ($post_row == false) {
            return false;
        }
        if ($post_row->m_id_user_check != -1) {//bài viết đã được duyệt, không cho xoá, sửa sau
            $current_user = $this->UserModel->check_login();
            if ($current_user == false) {
                return false;
            }
            if ($this->UserModel->get($current_user, 'm_level') < 3) {
                return false;
            }
        }
        //xóa avata
        $this->del_avata($id);
        //end xóa avata
        //xóa pdf
        $this->del_pdf($id);
        //end xóa pdf
        parent::del($id);
        if ($this->check_exit($id) != false) {
            return false;
        }
        //xóa bài viết trong post_content_content
        $this->db->where('id', $id);
        $this->db->delete($this->_table_name_content);
        //end xóa bài viết trong post_content_content
        //xóa view tương ứng trong postview
        $this->PostViewModel->del($id);
        //end xóa view tương ứng trong postview
        //xóa follow trong bảng post_follow
        $this->db->query("DELETE FROM " . $this->PostFollowModel->get_table_name() . " WHERE (m_type='post' AND m_id_value=" . $id . ")");
        //end xóa follow trong bảng post_follow
        $this->PostTypeModel->update_all_new_post();
        return true;
    }

    public function label_status() {
        return [
            'public' => 'Công khai',
            'ready' => 'Khởi tạo',
            'trash' => 'Đã xóa',
        ];
    }
    public function get($id, $field) {
        if ($field == 'm_content') {
            $this->db->where('id', $id);
            $kq = $this->db->get($this->_table_name_content)->row();
            if ($kq != null && $kq != false) {
                $kq = $kq->m_content;
            } else {
                $kq = "";
            }
            return $kq;
        }
        return parent::get($id, $field);
    }

    public function get_row($id, $get_content = true) {
        $kq = parent::get_row($id);
        if ($kq === false || $kq === null) {
            return false;
        }
        if ($get_content != true) {
            return $kq;
        }
        $this->db->where('id', $id);
        $kq->m_content = $this->db->get($this->_table_name_content)->row();
        if ($kq->m_content != null && $kq->m_content != false) {
            $kq->m_content = $kq->m_content->m_content;
        } else {
            $kq->m_content = "";
        }
        return $kq;
    }

    public function get_layout_item() {
        return $this->_layout_item;
    }

    public function gettop($type, $limit = 1, $id_type = 1) {
        $ar_type = Array();
        $this->PostTypeModel->get_list_type($ar_type, $id_type);
        $temp_add = "";
        if (count($ar_type) > 0 && implode(",", $ar_type) != "") {
            $temp_add = " AND m_id_type IN(" . implode(",", $ar_type) . ")";
        }
        $sql = "SELECT " . $type . " FROM " . $this->_table_name . " WHERE m_status='public' " . $temp_add . " ORDER BY m_militime DESC LIMIT 0," . $limit;
        $k = $this->db->query($sql);
        if ($k->num_rows() > 0) {
            return $k->result();
        } else {
            return false;
        }
    }

    public function gettop_by_like($type, $limit = 1, $id_type = 1) {
        $ar_type = Array();
        $this->PostTypeModel->get_list_type($ar_type, $id_type);
        $temp_add = "";
        if (count($ar_type) > 0 && implode(",", $ar_type) != "") {
            $temp_add = " AND m_id_type IN(" . implode(",", $ar_type) . ")";
        }
        $sql = "SELECT " . $type . " FROM " . $this->_table_name . " WHERE m_status='public' " . $temp_add . " ORDER BY m_like DESC LIMIT 0," . $limit;
        $k = $this->db->query($sql);
        if ($k->num_rows() > 0) {
            return $k->result();
        } else {
            return false;
        }
    }

    public function gettop_by_view($type, $limit = 1, $id_type = 1) {
        $ar_type = Array();
        $this->PostTypeModel->get_list_type($ar_type, $id_type);
        $temp_add = "";
        if (count($ar_type) > 0 && implode(",", $ar_type) != "") {
            $temp_add = " AND m_id_type IN(" . implode(",", $ar_type) . ")";
        }
        $sql = "SELECT " . $type . " FROM " . $this->_table_name . "," . $this->PostViewModel->get_table_name() . "  WHERE (m_status='public' " . $temp_add . " AND id=id_post) ORDER BY m_3day DESC LIMIT 0," . $limit;
        $k = $this->db->query($sql);
        if ($k->num_rows() > 0) {
            return $k->result();
        } else {
            return false;
        }
    }

    public function get_str_item($post_row, $action = "") {
        if ($post_row == false) {
            return false;
        }
        if ($action == "") {
            $action = $this->get_link_from_row(Array('id' => $post_row->id, 'm_title' => $post_row->m_title));
        }
        $temp_type_title = $this->PostTypeModel->get($post_row->m_id_type, 'm_title');
        $ar_patern = array(
            '{{postlink}}' => $action,
            '{{posttitle}}' => str_to_view($post_row->m_title),
            '{{posttitlese}}' => str_to_view($post_row->m_title, false),
            '{{postavata}}' => $this->PostContentModel->get_avata($post_row->id),
            '{{posttypelink}}' => $this->PostTypeModel->get_link_from_row($data = Array('id' => $post_row->m_id_type, 'title' => $temp_type_title, 'page' => 1)),
            '{{posttypetitle}}' => str_to_view($temp_type_title),
            '{{posttypetitlese}}' => str_to_view($temp_type_title, false),
            '{{postago}}' => my_time_ago_str($post_row->m_militime),
            '{{postcustomstatistic}}' => ""
        );
        return str_replace(array_keys($ar_patern), array_values($ar_patern), $this->_layout_item);
    }

    public function get_str_item_recent_view($post_row, $action = "") {
        if ($post_row == false) {
            return false;
        }
        if ($action == "") {
            $action = $this->get_link_from_row(Array('id' => $post_row->id, 'm_title' => $post_row->m_title));
        }
        $temp_type_title = $this->PostTypeModel->get($post_row->m_id_type, 'm_title');
        $ar_patern = array(
            '{{postlink}}' => $action,
            '{{posttitle}}' => str_to_view($post_row->m_title),
            '{{posttitlese}}' => str_to_view($post_row->m_title, false),
            '{{postavata}}' => $this->PostContentModel->get_avata($post_row->id),
            '{{posttypelink}}' => $this->PostTypeModel->get_link_from_row($data = Array('id' => $post_row->m_id_type, 'title' => $temp_type_title, 'page' => 1)),
            '{{posttypetitle}}' => str_to_view($temp_type_title),
            '{{posttypetitlese}}' => str_to_view($temp_type_title, false),
            '{{postago}}' => my_time_ago_str($post_row->m_militime),
            '{{postcustomstatistic}}' => " <i class='fa fa-eye'></i> " . $post_row->m_view_recent
        );
        return str_replace(array_keys($ar_patern), array_values($ar_patern), $this->_layout_item);
    }

    public function get_str_item_like($post_row, $action = "") {
        if ($post_row == false) {
            return false;
        }
        if ($action == "") {
            $action = $this->get_link_from_row(Array('id' => $post_row->id, 'm_title' => $post_row->m_title));
        }
        $temp_type_title = $this->PostTypeModel->get($post_row->m_id_type, 'm_title');
        $ar_patern = array(
            '{{postlink}}' => $action,
            '{{posttitle}}' => str_to_view($post_row->m_title),
            '{{posttitlese}}' => str_to_view($post_row->m_title, false),
            '{{postavata}}' => $this->PostContentModel->get_avata($post_row->id),
            '{{posttypelink}}' => $this->PostTypeModel->get_link_from_row($data = Array('id' => $post_row->m_id_type, 'title' => $temp_type_title, 'page' => 1)),
            '{{posttypetitle}}' => str_to_view($temp_type_title),
            '{{posttypetitlese}}' => str_to_view($temp_type_title, false),
            '{{postago}}' => my_time_ago_str($post_row->m_militime),
            '{{postcustomstatistic}}' => " <i class='fa fa-heart-o'></i> " . $post_row->m_like
        );
        return str_replace(array_keys($ar_patern), array_values($ar_patern), $this->_layout_item);
    }

    public function set($id, $field, $new) {
        if ($field == 'm_content') {//chỉnh sửa nội dung bài viết, nằm trong bảng nội dung
            $this->db->where('id', $id);
            $this->db->update($this->_table_name_content, Array($field => $new));
        } else {//nằm trong bảng hiện tại
            //cập nhật cho field hiện tại
            parent::set($id, $field, $new);
            if ($field == 'm_title') {//cập nhật search nếu field là tiêu đề
                $this->set_title_search($id);
            } else if ($field == 'm_status' || $field == 'm_id_type' || $field == 'm_militime') {//cập nhật bài viêt mới trong chủ đề nếu field là trạng thái duyệt, chủ đề, thời gian update
                $this->PostTypeModel->update_all_new_post();
            }
        }
        if ($field == "m_content" || $field == "m_title") {//cập nhật lại file download pdf
            $this->del_pdf($id);
        }
        return true;
    }

    public function set_title_search($id) {
        $row = $this->get_row($id);
        if ($row == false) {
            return false;
        }
        $row->m_title = preg_replace('/[^a-zA-Z0-9 ]/', " ", bodau($row->m_title));
        $this->set($id, 'm_title_search', mystr()->addmask($row->m_title));
        return true;
    }

    public function check_publish($id) {
        if (in_array($this->get($id, "m_status"), Array('ready', 'public'))) {
            if ($this->get($id, "m_id_user_check") != -1) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function get_permission($id_user = -1, $id_post = -1) {
        $user_row = $this->UserModel->get_row($id_user);
        $post_row = $this->get_row($id_post);
        $ar_per = Array(); //view,comment,like,add,update,delete,check,uncheck
        if ($post_row != false) {//bài viết có tồn tại
            array_push($ar_per, 'view');
            if ($user_row != false) {//người dùng có tồn tại
                array_push($ar_per, 'like', 'comment');
                if ($user_row->m_level > 2 || $user_row->id == $post_row->m_id_user) {//có quyền > 2 hoặc chính là người viết
                    array_push($ar_per, 'update', 'delete');
                }
                if ($user_row->m_level > 2) {//có quyền > 2
                    if ($post_row->m_id_user_check == -1) {//bài viết chưa được duyệt
                        array_push($ar_per, 'check');
                    } else {//bài viết đã được duyệt
                        $user_checked = $this->UserModel->get_row($post_row->m_id_user_check);
                        if ($user_checked == false) {//nhưng người duyệt hiện đã không tồn tại
                            array_push($ar_per, 'check', 'uncheck');
                        } else {//người duyệt có tồn tại
                            if ($user_row->m_level > $user_checked->m_level || $user_checked->id == $user_row->id || $user_row->m_level > 3) {//có quyền cao hơn người duyệt hoặc chính là người duyệt hoặc quyền >=4
                                array_push($ar_per, 'check', 'uncheck');
                            }
                        }
                    }
                }
            }
        } else {
            if ($user_row != false) {//người dùng có tồn tại
                array_push($ar_per, 'add');
            }
        }
        return $ar_per;
    }

    public function view($id) {
        if ($this->check_exit($id)) {
            $this->set($id, "m_view", $this->get($id, "m_view") + 1);
            $this->PostViewModel->view($id);
            $this->UserModel->bonus_score($this->get($id, "m_id_user"), (int)$this->SystemParamModel->get('Post_bonus_score_view', 'm_value'));
            return $this->get($id, "m_view");
        } else {
            return false;
        }
    }

    public function like($id) {
        if ($this->check_exit($id)) {
            $this->set($id, "m_like", $this->get($id, "m_like") + 1);
            return $this->get($id, "m_like");
        } else {
            return false;
        }
    }

    public function check_new($id) {
        if (!$this->check_exit($id)) {
            return false;
        }
        if (time() - $this->get($id, 'm_militime') > 2000 * 60) {
            return false;
        }
        return true;
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
            if ($this->get($id, 'm_rank') == 0) {
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

    public function get_avata_small($id) {//thumb small
        return parent::get_avata($id, 'verysmall');
    }
}

?>