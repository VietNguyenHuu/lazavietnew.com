<?php
    if($this->UserModel->get($idname,'m_level'))
	{
		$id=$this->input->post('id');
        $post_old=$this->PostContentModel->get_row($id);
		if($post_old!=false)
		{
            if($this->UserModel->get($idname,'m_level')<=$this->UserModel->get($this->PostContentModel->get($id,'m_id_user'),'m_level')&&$this->PostContentModel->get($id,'m_id_user')!=$idname)
            {
                echo "Tác vụ thất bại";
            }
            else
            {
                $title=$this->input->post('title');
                $id_type=$this->input->post('id_type');
    			$content=$this->input->post('content');
    			$avata=$this->input->post('avata');
    			$seo_title=$this->input->post('seo_title');
                $seo_keyword=$this->input->post('seo_keyword');
                $seo_description=$this->input->post('seo_description');
                $avata_hide=$this->input->post('avata_hide');
                $change_time=$this->input->post('change_time');
                
    			if($avata!=""&&$avata!='undefined')//ghi file avata
    			{
    				$this->PostContentModel->set_avata($id,$avata);
    			}
    			//cập nhật vào cơ sở dữ liệu
                if($title!=""&&$title!=$post_old->m_title)
                {
                    $this->PostContentModel->set($id,"m_title",$title);
                }
    			if($this->PostTypeModel->check_exit($id_type)&&$id_type!=$post_old->m_id_type)
                {
                    $this->PostContentModel->set($id,"m_id_type",$id_type);
                }
    			$this->PostContentModel->set($id,"m_content",$content);
                
                $this->PostContentModel->set($id,"m_seo_title",$seo_title);
                $this->PostContentModel->set($id,"m_seo_keyword",$seo_keyword);
                $this->PostContentModel->set($id,"m_seo_description",$seo_description);
                if($avata_hide=='0'||$avata_hide==1)
                {
                    $this->PostContentModel->set($id,"m_avata_hide",$avata_hide);
                }
                if($change_time=='1')
                {
                    $this->PostContentModel->set($id,'m_militime',time());
                }
    			echo "Đã cập nhật bài viết ".$this->PostContentModel->get($id,"m_title");
            }
		}
		else
		{
			echo "Tác vụ thất bại";
		}
	}
	else
	{
		echo "Cần quyền quản trị";
	}
?>