<?php
include_once("application/views/page_dynamic/post/include_post_header.php");
?>
<div class="width_max1300px">
<?php    
    $str="<div class='sub_menu' id='post_content_menu'>";
        $str.="<div class='sub_menu_list'>";
            $list_main_type=$this->PostTypeModel->get_direct_type(1);
            if($list_main_type!=false)
            {
                foreach($list_main_type as $key=>$list_main_type_line)
                {
                    $str.="<div class='width_40 padding'>";
                        $str.="<div class='font_roboto fontsize_a2 submenu_item'><a href='".$this->PostTypeModel->get_link_from_id($list_main_type_line['id'])."' title='".str_to_view($list_main_type_line['m_title'],false)."'>".$list_main_type_line['m_title']."</a></div>";
                        //sub main type
                        $list_main_type_sub=$this->PostTypeModel->get_direct_type($list_main_type_line['id']);
                        if(!empty($list_main_type_sub))
                        {
                            $str.="<div class='fontsize_d2 padding_t'>";
                            foreach($list_main_type_sub as $key_sub=>$list_main_type_line_sub)
                            {
                                $str.="<div class='submenu_item_sub'><a class='font_roboto' href='".$this->PostTypeModel->get_link_from_id($list_main_type_line_sub['id'])."' title='".str_to_view($list_main_type_line_sub['m_title'],false)."'>".$list_main_type_line_sub['m_title']."</a></div>";
                            }
                            $str.="</div>";
                        }
                        //end sub main type
                    $str.="</div>";
                    if($key%4==3)
                    {
                        $str.="<div class='clear_both'></div>";
                    }
                }
                $str.="<div class='clear_both'></div>";
            }
            else
            {
                $str.="Chưa có danh mục bài viết";
            }
        $str.="</div>";    
    $str.="</div>";
    echo $str;
?>
</div>