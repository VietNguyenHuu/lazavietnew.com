<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $title=$this->input->post('title');
        if(trim($title)==""||$title=="undefined")
        {
            echo "<span class='stt_mistake'>Hãy nhập vào tên nhóm bài viết</span>";
        }
        else
        {
            $description=$this->input->post('description');
            $n=$this->PostGroupModel->add(Array(
                'id_user'=>$idname,
                'title'=>$title,
                'description'=>$description
            ));
            if($n==false)
            {
                echo "<span class='stt_mistake'>Không thêm được nhóm bài viết, vui lòng thực hiện lại sau</span>";
            }
            else
            {
                echo "Đã thêm nhóm bài viết <b>".str_to_view($title)."</b>";
            }
        }
    }
?>