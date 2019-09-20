<?php
    if($idname==false)
    {
        echo "<div class='stt_mistake'>Đăng nhập để thực hiện tác vụ này !</div>";
    }
    else
    {
        $id_user_with=$this->input->post("id_user_with");
        if($id_user_with==false||$id_user_with=='undefined'||$id_user_with=="")
        {
            echo "<div class='stt_mistake'>Đã có lỗi xảy ra, hãy thực hiện lại !</div>";
        }
        else
        {
            $this->db->query("DELETE FROM ".$this->TinNhanModel->get_table_name()." WHERE ((m_id_user_from=".$idname." AND m_id_user_to=".$id_user_with.") OR (m_id_user_from=".$id_user_with." AND m_id_user_to=".$idname."))");
            echo "<div class='stt_avaiable'>Đã xóa tất cả tin nhắn trong cuộc hội thoại</div>";
        }
    }
?>