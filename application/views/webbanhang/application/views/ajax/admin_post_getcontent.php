<?php
    /*
	trả về danh sách các bài đăng để trình bày lên trang quản lí theo chủ đề đưa vào
	*/
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $p_id=$this->input->post('id_type');
        $ischeck=$this->input->post('content_ischeck');
        $search=$this->input->post('content_search');
    	$page=$this->input->post('page');
    	if($page<1){$page=1;}
        if($search=="undefined"||$search==false||$search==null||$search=="")
        {
            $search=false;
        }
        else if(trim($search)=="")
        {
            $search=false;
        }
    	//load mang chu de
    	$ar_p=Array();//day la mang cac chu de
        $this->PostTypeModel->get_list_type($ar_p,$p_id);
        
        if($search==false)
        {
            $q="SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_type IN(".implode(",",$ar_p).") AND m_status!='trash')";
        	if($ischeck=='checked')
            {
                $q="SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_type IN(".implode(",",$ar_p).") AND m_id_user_check!=-1 AND m_status!='trash')";
            }
            else if($ischeck=='wait_check')
            {
                $q="SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_type IN(".implode(",",$ar_p).") AND m_id_user_check=-1 AND m_status!='trash')";
            }
            else if($ischeck=='deleted')
            {
                $q="SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_type IN(".implode(",",$ar_p).") AND m_status='trash')";
            }
        }
        else
        {
            $q_search="MATCH(m_title_search)AGAINST('".addslashes(mystr()->addmask($search))."')";
            $q="SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_type IN(".implode(",",$ar_p).")  AND m_status!='trash' AND ".$q_search.")";
        	if($ischeck=='checked')
            {
                $q="SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_type IN(".implode(",",$ar_p).")  AND m_status!='trash' AND m_id_user_check!=-1 AND ".$q_search.")";
            }
            else if($ischeck=='wait_check')
            {
                $q="SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_type IN(".implode(",",$ar_p).")  AND m_status!='trash' AND m_id_user_check=-1 AND ".$q_search.")";
            }
            else if($ischeck=='deleted')
            {
                $q="SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_type IN(".implode(",",$ar_p).")  AND m_status='trash' AND ".$q_search.")";
            }
            $q_search=null;
        }
        $max=$this->db->query($q)->num_rows();
    	if($max>0)
    	{
    		$str="";
    		//thong so dung cho phan trang
            $max_post_in_page=10;
            $phantrang=page_seperator($max,$page,$max_post_in_page,Array('class_name'=>'page_seperator_item','strlink'=>'javascript:admin_post_content.loadlist([[pagenumber]])'));
    		//end thong so dung cho phan trang
            if($search==false)
            {
                $q_order=" ORDER BY id DESC";
            }
            else
            {
                $q_order="";
            }
            $q=$this->db->query($q."".$q_order." LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
            $q_order=null;
    		if($q!=false&&count($q)>0&&$q!=null&&$q!="")
            {
                foreach($q as $q_line)
                {
                    $q_line=$this->PostContentModel->get_row($q_line->id,false);
                    if($q_line!=false)
                    {
                        $str.="<div class='item' style='border-bottom:1px solid #999999'>";
                            $str.="<div class='width3 width3_0_12 width3_1024_10'>";
                				$str.="<a href='".site_url("admin/post_detail/".$q_line->id)."'><img class='align_middle item_avata' src='".$this->PostContentModel->get_avata($q_line->id)."'>";
                				    $str.="<span class='align_middle item_title'>".$q_line->m_title."</span>";
                                $str.="</a>";
                                if($q_line->m_status!='trash')
                                {
                                    if($q_line->m_id_user_check==-1)
                                    {
                                        $str.=" <span class='align_middle button padding' onclick='admin_post_content.pre_check(".$q_line->id.")'>Duyệt</span>";
                                    }
                                    else
                                    {
                                        $str.=" <span class='align_middle stt_tip'>Duyệt bởi: ".$this->UserModel->get($q_line->m_id_user_check,'m_realname')."</span>";
                                        if(in_array('uncheck',$this->PostContentModel->get_permission($idname,$q_line->id)))
                                        {
                                            $str.="<span class='stt_mistake align_middle stt_action' onclick='admin_post_content.uncheck(".$q_line->id.")'> - bỏ duyệt - </span>";
                                        }
                                    }
                                }
                            $str.="</div>";
                            $str.="<div class='width3 width3_0_12 width3_1024_2 align_right'>";
                                $str.="<i class='fa fa-info-circle margin_l1em stt_action' onclick='admin_post_content.loadinfo(".$q_line->id.")'></i>";
                                if($q_line->m_status!='trash')
                                {
                                    $temp_color=" stt_avaiable ";
                                    if($this->db->query("SELECT id FROM ".$this->PostTagsModel->get_table_name()." WHERE (m_id_post=".$q_line->id.")")->num_rows()<1)
                                    {
                                        $temp_color=' stt_mistake ';
                                    }
                                    $str.="<i class='fa fa-tags margin_l1em stt_action".$temp_color."' onclick='admin_post_content.loadtags(".$q_line->id.")'></i>";
                                    $str.="<i class='fa fa-pencil stt_avaiable margin_l1em stt_action' onclick='admin_post_content.loadformedit(".$q_line->id.")'></i>";
                                    $str.="<i class='fa fa-trash-o stt_mistake margin_l1em stt_action' onclick='admin_post_content.del(".$q_line->id.")'></i>";
                                }
                                else
                                {
                                    $str.="<i class='fa fa-undo stt_avaiable margin_l1em stt_action' onclick='admin_post_content.restore(".$q_line->id.")'></i>";
                                    $str.="<i class='fa fa-trash-o stt_mistake margin_l1em stt_action' onclick='admin_post_content.penaty_del(".$q_line->id.")'></i>";
                                }
                                
                            $str.="</div>";
                            $str.="<div class='clear_both'></div>";
                        $str.="</div>";
                    }
                    $q_line=null;
        		}
            }
    		$str.="<div class='clear_both'></div>";
    		//phan trang
    		$str.="<div class='page_seperator_box'>";
                $str.=$phantrang['str_link'];
    		$str.="</div>";
    		//end phan trang
    		echo $str;
            $q=null;
            $str=null;
            $phantrang=null;
    	}
    	else
    	{
    		$str="";
    		$str.="<div class='tip align_center' style='padding:50px 0px;font-size:24px;'>Chưa có bài viết</div>";
    		$str.="<div class='clear_both'></div>";
    		$str.="</div>";
    		echo $str;
    	}
    }
?>