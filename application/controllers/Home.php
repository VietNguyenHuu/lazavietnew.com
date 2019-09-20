<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->view('Home', ['addcss'=>'home.css']);
	}
        public function product_loadedit() {
        //$id = $this->input->post('id');
        $id = $this->db->query("select * from product")->result()[0]->id;
        $title = $this->db->query("select * from product")->result()[0]->title;
        $price = $this->db->query("select * from product")->result()[0]->price;
        $file_ex = $this->db->query("select * from product")->result()[0]->file_ex;
        $id_category = $this->db->query("select * from product")->result()[0]->id_category;
        echo '<div class="sanpham margin_top_10">
                <input class="admin_product_update_title popup_input_text " type="text" value="' . $title . '">
//             <select class="admin_product_update_id_parent popup_input_text ">
//                    <option value="-1">chon danh muc san pham</option>
//                    ';
//        $list = $this->db->query("SELECT * FROM category")->result();
//        if (!empty($list)) {
//            foreach ($list as $item) {
//                $temp = '';
//                if ($id_category == $item->id) {
//                    $temp = "selected='selected'";
//                }
//                echo "<option " . $temp . " value= '" . $item->id . "'>" . $item->title . "</option>";
//            }
//        }
//        echo '
//                </select>
//                <input class="admin_product_update_price" type="text" value="' . $price . '"></input>
//                    
//                <input type="file" id="admin_product_update_avata_input" onchange="admin_product.update_setavata(this)">
//                <img src="asset/images/product_avata/'.$id.'.'.$file_ex.'" id="admin_product_update_avata_view" onclick="$(\'#admin_product_update_avata_input\').click()">
//                <br>
//                <input class="padding_5 popup_input_submit" type="submit" value="Cập nhật" onclick="admin_product.update(' . $id . ')">
//                <input class="padding_5 popup_input_cancel" type="button" value="Hủy" onclick="admin_product.edit_cancel()">
          echo '</div>';
    }
}
