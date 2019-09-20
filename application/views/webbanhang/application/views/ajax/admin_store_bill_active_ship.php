<?php
	$id_bill=$this->input->post('id_bill');
	if($this->ShopBillModel->check_exit($id_bill))//hóa đơn phải tồn tại
	{
		$id_store=$this->ShopBillModel->get($id_bill,'m_id_store');
		if($this->ShopStoreModel->check_exit($id_store))//gian hàng phải tồn tại
		{
			if($this->ShopStoreModel->check_permision($id_store,'delete')!==false)//người dùng phải có quyền thao tác với gian hàng
			{
				$this->ShopBillModel->set($id_bill,'m_ship',1);
				echo "Đã giao hàng cho hóa đơn Hđ".$id_bill;
			}
		}
	}
?>