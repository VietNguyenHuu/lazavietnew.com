<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function index() {
        $this->load->view('cart', ['addcss' => 'cart.css']);
        if (empty($this->session->userdata('username')) == FALSE) {
            $id = $this->db->query("select * from user where V_UserName = '" . $this->session->userdata('username') . "'");
            $id_user = $id->result()[0]->ID;
        }
    }

    public function loadnumber() {
        if (empty($this->session->userdata('username')) == FALSE) {
            $id = $this->db->query("select * from user where V_UserName = '" . $this->session->userdata('username') . "'");
            $id_user = $id->result()[0]->ID;
            echo $this->db->query("select count(v_id_user) as soluong from cart where v_id_user = " . $id_user . " group by v_id_user")->result()[0]->soluong;
            
        } else {
            echo '0';
        }
    }
    public function delete() {
        
        foreach($this->input->post("ar") as $row) //$this->input->post("ar") = $_POST[ar]
        {
            $this->db->query("delete from cart where id=".$row);
        }
    }

}
