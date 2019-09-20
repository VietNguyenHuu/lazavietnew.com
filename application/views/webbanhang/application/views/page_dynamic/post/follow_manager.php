<?php
include_once("application/views/page_dynamic/post/include_post_header.php");
?>
<div class="width_max1300px">
<?php
include_once("application/views/page_dynamic/post/include_post_header.php");
    if($idname==false)
    {
        echo "<div class='stt_tip padding'>Nếu đã đăng nhập, các bài viết mà bạn đang theo dõi sẽ hiển thị tại đây !</div>";
    }
    else
    {
        $layout_block=<<<EOD
<h1 class='page_title radius_none'>Bạn đang theo dõi ...</h1>
<div class='post_follow_contain'>
    <div class='width3 width3_0_12 width3_720_4 padding post_follow_block'>
        <div class='fontsize_a2 padding post_follow_header'>Bài viết</div>
        <div class='padding post_follow_content'>{{post_follow_content_post}}</div>
    </div>
    <div class='width3 width3_0_12 width3_720_4 padding post_follow_block'>
        <div class='fontsize_a2 padding post_follow_header'>Tác giả</div>
        <div class='padding post_follow_content'>{{post_follow_content_author}}</div>
    </div>
    <div class='width3 width3_0_12 width3_720_4 padding post_follow_block'>
        <div class='fontsize_a2 padding post_follow_header'>Chủ đề</div>
        <div class='padding post_follow_content'>{{post_follow_content_type}}</div>
    </div>
    <div class='clear_both'></div>
</div>
EOD;
        $layout_item=<<<EOD
<div class='item post_follow_item' data-id='{{follow_id}}'>
    <div class='width3 width3_0_10'>
        <a href='{{follow_link}}' title='{{follow_titlese}}'>
            <img class='radius_50 margin-right align_middle post_follow_item_avata' src='{{follow_avata}}' alt='{{follow_titlese}}' title='{{follow_titlese}}'/>
            <span class='align_middle'>{{follow_title}}</span>
        </a>
    </div>
    <div class='width3 width3_0_2 align_right'>
        <i class='fa fa-trash-o stt_mistake stt_action' onclick='post.unfollow(this)'></i>
    </div>
    <div class='clear_both'></div>
</div>
EOD;
        $ar_patern=Array(
            '{{post_follow_content_post}}'=>"<div class='stt_tip'>Các bài viết mà bạn đang theo dõi sẽ hiển thị tại đây.</div>",
            '{{post_follow_content_author}}'=>"<div class='stt_tip'>Các tác giả mà bạn đang theo dõi sẽ hiển thị tại đây.</div>",
            '{{post_follow_content_type}}'=>"<div class='stt_tip'>Các chủ đề mà bạn đang theo dõi sẽ hiển thị tại đây.</div>"
        );
        $post_follow=Array('post'=>false,'author'=>false,'type'=>false);
        $post_follow_temp=$this->db->query("SELECT id FROM ".$this->PostFollowModel->get_table_name()." WHERE (m_id_user=".$idname." AND m_type='post') ORDER BY id DESC LIMIT 0,10")->result();
        if(count($post_follow_temp)>0)
        {
            $ar_patern['{{post_follow_content_post}}']="";
            foreach($post_follow_temp as $post_follow_temp_line)
            {
                $temp_post_row=$this->PostContentModel->get_row($this->PostFollowModel->get($post_follow_temp_line->id,'m_id_value'));
                $ar_patern_item=Array(
                    '{{follow_id}}'=>$post_follow_temp_line->id,
                    '{{follow_link}}'=>$this->PostContentModel->get_link_from_id($temp_post_row->id),
                    '{{follow_title}}'=>str_to_view($temp_post_row->m_title),
                    '{{follow_titlese}}'=>str_to_view($temp_post_row->m_title, false),
                    '{{follow_avata}}'=>$this->PostContentModel->get_avata_small($temp_post_row->id)
                );
                $ar_patern['{{post_follow_content_post}}'].=str_replace(array_keys($ar_patern_item), array_values($ar_patern_item), $layout_item);
            }
        }
        $post_follow_temp=$this->db->query("SELECT id FROM ".$this->PostFollowModel->get_table_name()." WHERE (m_id_user=".$idname." AND m_type='author') ORDER BY id DESC LIMIT 0,10")->result();
        if(count($post_follow_temp)>0)
        {
            $ar_patern['{{post_follow_content_author}}']="";
            foreach($post_follow_temp as $post_follow_temp_line)
            {
                $temp_user_row=$this->UserModel->get_row($this->PostFollowModel->get($post_follow_temp_line->id,'m_id_value'));
                $ar_patern_item=Array(
                    '{{follow_id}}'=>$post_follow_temp_line->id,
                    '{{follow_link}}'=>$this->PostAuthorModel->get_link_from_id($temp_user_row->id),
                    '{{follow_title}}'=>str_to_view($temp_user_row->m_realname),
                    '{{follow_titlese}}'=>str_to_view($temp_user_row->m_realname, false),
                    '{{follow_avata}}'=>$this->UserModel->get_avata($temp_user_row->id)
                );
                $ar_patern['{{post_follow_content_author}}'].=str_replace(array_keys($ar_patern_item), array_values($ar_patern_item), $layout_item);
            }
        }
        $post_follow_temp=$this->db->query("SELECT id FROM ".$this->PostFollowModel->get_table_name()." WHERE (m_id_user=".$idname." AND m_type='type') ORDER BY id DESC LIMIT 0,10")->result();
        if(count($post_follow_temp)>0)
        {
            $ar_patern['{{post_follow_content_type}}']="";
            foreach($post_follow_temp as $post_follow_temp_line)
            {
                $temp_type_row=$this->PostTypeModel->get_row($this->PostFollowModel->get($post_follow_temp_line->id,'m_id_value'));
                $ar_patern_item=Array(
                    '{{follow_id}}'=>$post_follow_temp_line->id,
                    '{{follow_link}}'=>$this->PostTypeModel->get_link_from_id($temp_type_row->id),
                    '{{follow_title}}'=>str_to_view($temp_type_row->m_title),
                    '{{follow_titlese}}'=>str_to_view($temp_type_row->m_title, false),
                    '{{follow_avata}}'=>$this->PostTypeModel->get_avata($temp_type_row->id)
                );
                $ar_patern['{{post_follow_content_type}}'].=str_replace(array_keys($ar_patern_item), array_values($ar_patern_item), $layout_item);
            }
        }
        echo str_replace(array_keys($ar_patern), array_values($ar_patern), $layout_block);
    }
?>
</div>