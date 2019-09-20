<?php

	$title=$this->input->post('title');
	$link=$this->input->post('link');
	$data=$this->input->post('avata');
    $adstype=$this->input->post('adstype');

	//ghi vào cơ sở dữ liệu
	$a_success=$this->AdvertimentModel->add(Array(
       
            'title'=>$title,
            'link'=>$link,
            'type'=>$adstype
       ));
	if($a_success!=false)
	{
	   $this->AdvertimentModel->set_avata($a_success,$data);
		echo "Đã thêm quảng cáo '".$this->AdvertimentModel->get($a_success,'m_title')."' vào mục quảng cáo chính";
	}
	else
	{
		echo "Không thêm được quảng cáo vào mục quảng cáo chính";
	}
?>