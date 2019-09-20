<?php
    if($this->UserModel->get($idname,'m_level')<3)
    {
        echo "<div class='stt_mistake'>Cần quyền quản trị</div>";
    }
    else
    {
        $page=$this->input->post('page');
    	if($page<1){$page=1;}
        
        $m=$this->db->query("SELECT id FROM ".$this->PostReportPatternModel->get_table_name())->num_rows();
    	if($m>0)
    	{
    		$str="";
    		//thong so dung cho phan trang
            $phantrang=page_seperator($m,$page,20,Array('class_name'=>'page_seperator_item','strlink'=>'javascript:admin_post_report_pattern.loadlist([[pagenumber]])'));
            
            $list=$this->db->query("SELECT  * FROM ".$this->PostReportPatternModel->get_table_name()." ORDER BY m_index ASC LIMIT ".$phantrang['start'].",".$phantrang['limit'])->result();
    		if(count($list)<1)
            {
                $str.= "<div class='stt_mistake'>Không có kết quả trang này</div>";
            }
            else
            {
                $str.="<div class=''><i class='fa fa-folder-open'></i> Tất cả <b>".count($list)."</b> Mẫu phản hồi bài viết</div>";
                $str.= "<div class='list'>";
                foreach($list as $line)
                {
                    $str.= "<div class='item padding'>";
                        $str.= "<span class='stt_tip'>".$line->m_index." - </span><span class=''>".$line->m_title."</span>";
                        $str.="<div class='float_right'><i class='fa fa-bars stt_action stt_highlight' onclick='admin_post_report_pattern.loadinfo(".$line->id.")' title='Tùy chọn'></i></div>";
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
    		$str.="<div class='tip align_center' style='padding:50px 0px;font-size:24px;'>Chưa có mẫu phản hồi nào !</div>";
    		$str.="<div class='clear_both'></div>";
    		$str.="</div>";
    		echo $str;
    	}
    }
?>