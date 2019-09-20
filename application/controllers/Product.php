<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function index($id) {
        $this->load->view('product', ['id' => $id, 'addcss' => 'product.css']);
    }

    public function addtocart() {
        if (empty($this->session->userdata('username')) == FALSE) {
            $id = $this->db->query("select * from user where V_UserName = '".$this->session->userdata('username')."'");
            $id_user = $id->result()[0]->ID;
           
            $id_product = $this->input->post("id");
            $count = $this->input->post("count");
            $this->db->query("INSERT  INTO cart(v_id_user, v_id_product, v_count)VALUES(" . $id_user . ", " . $id_product . ", ".$count.")");
            echo '<span class="success">Da them vao gio hang thanh cong</span>';
       
        }
    }

}
