<?php
    if($this->UserModel->get($idname,'m_level')>0)
	{
		$id_type=$this->input->post('id_type');
		function post_add_load_type(&$strr,$id_parent,$id_current,$padding)
		{
			$p_t=new PostTypeModel;
			$p=new PostContentModel;
			$ar=$p_t->get_direct_type($id_parent);
			$m=count($ar);
			for($i=0;$i<$m;$i++)
			{
                $temp_add_class='';
				if($id_current==$ar[$i]['id'])
                {
                    $temp_add_class=' stt_highlight';
                }
				$strr.="<div class='item".$temp_add_class."' data-id='".$ar[$i]['id']."' data-title='".$p_t->get($ar[$i]['id'],'m_title')."' onclick='post_write.add_select_type(this)' style='padding-left:".$padding."em'>".$p_t->get($ar[$i]['id'],'m_title')."</div>";
				if($p_t->get_direct_type($ar[$i]['id'])!=false)
				{
					post_add_load_type($strr,$ar[$i]['id'],$id_current,$padding+1);
				}
				
			}
		}
        $str="";
		post_add_load_type($str,1,$id_type,1);
        echo $str;
	}
	else
	{
		echo "Đăng nhập để thực hiện chức năng";
	}
?>