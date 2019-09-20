<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $id_user=$this->input->post('id_user');
        $user_row=$this->UserModel->get_row($id_user);
        if($user_row==false)
        {
            echo "<div class='stt_mistake'>Người dùng không khả dụng</div>";
        }
        else
        {
            $score=(int)$this->input->post('score');
            $new_author=$this->PostAuthorModel->add($data=Array(
                'id_user'=>$user_row->id,
                'date'=>time(),
                'status'=>'active',
                'score_multi'=>$score
           ));
           if($new_author==false)
           {
                echo "<div class='stt_mistake'>Không thêm được tác giả, hãy thực hiện lại sau</div>";
           }
           else
           {
                echo "<div class='stt_avaiable'>Đã thêm tác giả</div>";
           }
        }
    }
?>