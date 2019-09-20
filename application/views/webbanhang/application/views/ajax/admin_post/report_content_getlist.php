<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $page=$this->input->post('page');
    	if($page<1){$page=1;}
        
        $m=$this->db->query("SELECT id FROM ".$this->PostReportModel->get_table_name())->num_rows();
    	if($m>0)
    	{
    		$str="";
    		//thong so dung cho phan trang
            $phantrang=page_seperator($m,$page,20,Array('class_name'=>'page_seperator_item','strlink'=>'javascript:admin_post_report_content.loadlist([[pagenumber]])'));
            
            $list=$this->db->query("SELECT  * FROM ".$this->PostReportModel->get_table_name()." ORDER BY id DESC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
    		if(count($list)<1)
            {
                $str.= "<div class='stt_mistake'>Không có kết quả trang này</div>";
            }
            else
            {
                $str.="<div class=''><i class='fa fa-folder-open'></i> Tất cả <b>".count($list)."</b> Phản hồi bài viết</div>";
                $str.= "<div class='list'>";
                foreach($list as $line)
                {
                    $str.= "<div class='item padding' style='border-bottom:1px dotted #333333'>";
                        $temp_user_row=$this->UserModel->get_row($line->m_id_user);
                        $temp_post_row=$this->PostContentModel->get_row($line->m_id_post);
                        $temp_patern_row=$this->PostReportPatternModel->get_row($line->m_id_pattern);
                        $str.="<i class='fa fa-trash-o fa-2x stt_mistake float_right stt_action' onclick='admin_post_report_content.del(".$line->id.")' title='Xoá phản hồi '></i>";
                        if($temp_user_row!=false)
                        {
                            $str.="<a href='".$this->UserModel->get_link_from_id($line->m_id_user)."'>".$temp_user_row->m_realname."</a>";
                        }
                        else
                        {
                            $str.="<span class='stt_tip'>Ẩn danh</span>";
                        }
                        $str.=" --> ";
                        $str.="<a href='".$this->PostContentModel->get_link_from_id($line->m_id_post)."'>".$temp_post_row->m_title."</a>";
                        $str.="<div>";
                        if($temp_patern_row!==false)
                        {
                            $str.=$temp_patern_row->m_title;
                        }
                        if($line->m_ex!="")
                        {
                            $str.="<span class='stt_tip'> (".$line->m_ex.") </span>";
                        }
                        $str.="</div>";
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
    		$str.="<div class='tip align_center' style='padding:50px 0px;font-size:24px;'>Chưa có phản hồi nào !</div>";
    		$str.="<div class='clear_both'></div>";
    		$str.="</div>";
    		echo $str;
    	}
    }
?>