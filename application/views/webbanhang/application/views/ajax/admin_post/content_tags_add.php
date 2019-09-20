<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    }
    else
    {
        $post_row=$this->PostContentModel->get_row($this->input->post('id_post'));
        if($post_row==false)
        {
            echo "<div class='stt_mistake'>Bài viết không khả dụng</div>";
        }
        else
        {
            $title=$this->input->post('title');
            if($title==""||$title=="undefinded")
            {
                echo "<div class='stt_mistake'>Nhập tên tags để thêm</div>";
            }
            else
            {
                $new_tags=$this->PostTagsModel->add(Array(
                    'id_post'=>$post_row->id,
                    'title'=>$title
               ));
               if($new_tags==false)
               {
                    echo "<div class='stt_mistake'>Không thêm được tags,<br> hãy thực hiện lại</div>";
               }
               else
               {
                    echo "<div class='stt_avaiable'>Đã thêm tags</div>";
               }
            }
        }
    }
?>