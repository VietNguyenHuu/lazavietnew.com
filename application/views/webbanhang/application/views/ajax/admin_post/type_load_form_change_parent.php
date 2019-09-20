<?php
    if($this->UserModel->get($idname,'m_level')<4)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $type_row=$this->PostTypeModel->get_row((int)$this->input->post("id"));
        if($type_row==false)
        {
            echo "<div class='mistake'>Danh mục không khả dụng !</div>";
        }
        else if($type_row->id==1)
        {
            echo "<div class='mistake'>Mục đang chọn hiện là mục gốc mặc định của hệ thống</div>";
        }
        else
        {
            echo "<div class='stt_tip'>Bạn đang tiến hành thay đổi mục gốc cho mục <b>".str_to_view($type_row->m_title)."</b>, Hãy chọn mục làm mục gốc trong danh sách sau đây:</div>";
            $type_root=$this->PostTypeModel->get_row(1);
            if($type_root!=false)
            {
                echo "<div class='padding_v' style='border-bottom:1px solid #999999'>".str_to_view($type_root->m_title)." <span class='button fontsize_d2' onclick='admin_post_type.change_parent(".$type_row->id.",".$type_root->id.")'>Chọn</span></div>";
            }
            function admin_post_get_change_parent(&$strr,$id_parent,$id_current,$padding)
    		{
    			$p_t=new PostTypeModel;
    			$p=new PostContentModel;
    			$ar=$p_t->get_direct_type($id_parent);
    			$m=count($ar);
    			for($i=0;$i<$m;$i++)
    			{
                    $temp_add_class='';
                    $temp_select=" <span class='button fontsize_d2 padding_h' onclick='admin_post_type.change_parent(".$id_current.",".$ar[$i]['id'].")'>Chọn</span>";
    				if($id_current==$ar[$i]['id'])
                    {
                        $temp_add_class=' stt_highlight';
                        $temp_select="";
                    }
    				$strr.="<div class='item padding_v".$temp_add_class."' data-id='".$ar[$i]['id']."' data-title='".$p_t->get($ar[$i]['id'],'m_title')."' style='padding-left:".$padding."em;border-bottom:1px solid #999999'>".$p_t->get($ar[$i]['id'],'m_title')."".$temp_select."</div>";
    				if($p_t->get_direct_type($ar[$i]['id'])!=false&&$temp_add_class=='')
    				{
    					admin_post_get_change_parent($strr,$ar[$i]['id'],$id_current,$padding+1);
    				}
    			}
    		}
            $str="";
    		admin_post_get_change_parent($str,1,$type_row->id,1);
            echo $str;
        }
    }
?>