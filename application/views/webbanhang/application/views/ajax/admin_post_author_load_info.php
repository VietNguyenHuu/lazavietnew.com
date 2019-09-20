<?php
    $author=$this->PostAuthorModel->get_row($this->input->post('id'));
    if($author==false)
    {
        echo "<div class='stt_mistake'>Tác giả không khả dụng</div>";
    }
    else
    {
        $userline=$this->UserModel->get_row($author->m_id_user);
        if($userline==false)
        {
            echo "<div class='stt_mistake'>Tác giả không khả dụng</div>";
        }
        else
        {
            echo "<div>Tác giả : <a href='".$this->PostAuthorModel->get_link_from_id($userline->id)."' target='_plank' title='Xem trang tác giả'>".$userline->m_realname."</a></div>";
            echo "<div>Điểm : ".$userline->m_score." điểm</div>";
            echo "<div>Tiền : ".valid_money($userline->m_money)." vnđ</div>";
            $posted=$this->db->query("SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user=".$userline->id)->num_rows();
            $posted_waitcheck=$this->db->query("SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user=".$userline->id." AND m_id_user_check=-1")->num_rows();
            echo "<div>Đã viết : ".$posted." bài (".$posted_waitcheck." chưa duyệt)</div>";
            $view=$this->db->query("SELECT SUM(m_view) AS view FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user=".$userline->id." GROUP BY m_id_user")->result()[0]->view;
            echo "<div>Lượt xem : ".$view." lượt</div>";
            
            echo "<div class='padding_v' style='border-bottom:1px solid #999999'></div>";
            echo "<div class='padding_v'>Điểm cộng / 1 bài viết <input type='text' class='admin_post_author_editform_score' value='".$author->m_score_multi."'><span class='button padding' onclick='admin_post_author.update_score(".$author->id.")'>Cập nhật</span></div>";
        }
    }
?>