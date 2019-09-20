<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
    	$page=$this->input->post('page');
    	if($page<1){$page=1;}
        
        $m=$this->db->query("SELECT id FROM ".$this->PostAuthorModel->get_table_name())->num_rows();
    	if($m>0)
    	{
    		$str="";
    		//thong so dung cho phan trang
            $phantrang=page_seperator($m,$page,20,Array('class_name'=>'page_seperator_item','strlink'=>'javascript:admin_post_author.loadlist([[pagenumber]])'));
            
            $list=$this->db->query("SELECT  * FROM ".$this->PostAuthorModel->get_table_name()." ORDER BY id DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
    		if(count($list)<1)
            {
                $str.= "<div class='stt_mistake'>Không có kết quả trang này</div>";
            }
            else
            {
                $str.="<div class=''><i class='fa fa-folder-open'></i> Tất cả <b>".count($list)."</b> Tác giả</div>";
                $str.= "<div class='list'>";
                foreach($list as $line)
                {
                    $str.= "<div class='item padding'>";
                        $str.="<img class='align_middle radius_50 margin_r' style='height:2em;width:2em' src='".$this->UserModel->get_avata($line->m_id_user)."'>";
                        $str.= "<a href='".$this->PostAuthorModel->get_link_from_id($line->m_id_user)."' target='_blank'><span class='align_middle'>".$this->UserModel->get($line->m_id_user,'m_realname')."</span></a>";
                        $str.="<div class='float_right'><i class='fa fa-bars stt_action stt_highlight' onclick='admin_post_author.loadinfo(".$line->id.")' title='Tùy chọn'></i></div>";
                        $str.="<div class='clear_both'></div>";
                    $str.= "</div>";
                }
                $str.= "</div>";
            }
            $str.="<div class='clear_both'></div>";
    		//phan trang
    		$str.="<div class='page_seperator_box'>";
                $str.=$phantrang['str_link'];
    		$str.="</div>";
    		//end phan trang
    		echo $str;
    	}
    	else
    	{
    		$str="";
    		$str.="<div class='tip align_center' style='padding:50px 0px;font-size:24px;'>Chưa có Tác giả</div>";
    		$str.="<div class='clear_both'></div>";
    		$str.="</div>";
    		echo $str;
    	}
     }
?>