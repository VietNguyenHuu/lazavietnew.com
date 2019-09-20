<?php
    if($this->UserModel->get($idname,'m_level')>2)
	{
		$id=$this->input->post('id');
        $post_row=$this->PostContentModel->get_row($id);
        if($post_row==false)
        {
            echo "<div class='stt_mistake'>Bài viết không khả dụng.</div>";
        }
        else
        {
            $str="";
            $page=(int)$this->input->post('page');
            $kw=$this->input->post('keyword');
            if($page<1)
            {
                $page=1;
            }
            if($kw=="")
            {
                $kw=urlencode($post_row->m_title);
            }
            else
            {
                $kw=urlencode($kw);
            }
            $str_html=supper_curl()->get("https://www.google.com.vn/search?q=".$kw."&start=".(($page-1)*10));
            $str_html=str_get_html($str_html);
            if($str_html!=false&&$str_html!=null)
            {
                $list_link=$str_html->find(".g");
                if(count($list_link)>0&&$list_link!=false&&$list_link!=null)
                {
                    foreach($list_link as $key=>$list_link_line)
                    {
                        $ar_href=$list_link_line->find("a");
                        if(count($ar_href)>0&&$ar_href!=false&&$ar_href!=null)
                        {
                            $added=false;
                            foreach($ar_href as $ar_href_line)
                            {
                                if($added==false&&strpos($ar_href_line->__get('href'), $this->SystemParamModel->get('Site_domain_name', 'm_value'))!=false)
                                {
                                    $str.="<div class='padding_v' style='border-top:1px solid #999999'>Vị trí Trang ".$page." / thứ ".($key+1)."<br><div>".$list_link_line->innertext()."</div></div>";
                                    $added=true;
                                }
                            }
                        }
                    }
                }
            }
            if($str=="")
            {
                $str="<div class='stt_mistake'>Không tìm thấy trong trang ".$page."</div>";
                //$str.=$str_html;
            }
            echo $str;
        }
	}
	else
	{
		echo "Tác vụ không được phép";
	}
?>