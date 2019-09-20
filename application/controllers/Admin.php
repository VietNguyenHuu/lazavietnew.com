<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index() {
        $this->load->view('Admin', ['addcss' => 'admin.css']);
    }

    public function category_add() {
        $title = $this->input->post('t');
        $id_parent = $this->input->post('id_parent');

        $this->db->query("INSERT  INTO category(title,id_parent)VALUES('" . $title . "', " . $id_parent . ")");
    }

    public function category_loadlist() {
        $list = $this->db->query("SELECT * FROM category")->result();
        if (!empty($list)) {
            foreach ($list as $item) {
                echo "<div class='item' id='category_item_" . $item->id . "'>"
                . "<span class='title'>" . $item->title . "</span>"
                . "<span class='float_right'>"
                . "<i class='fas fa-save' style='color:blue' onclick='admin.update(" . $item->id . ")'></i>"
                . "&nbsp;&nbsp;<i class='fas fa-trash' style='color:red' onclick='admin.delete(" . $item->id . ")'></i>"
                . "&nbsp;&nbsp;<i class='fas fa-pencil-alt' style='color:green' onclick='admin.edit(" . $item->id . ")'></i>"
                . "</span>"
                . "<div class='clear_both'></div>"
                . "</div>";
            }
        } else {
            echo "danh muc san pham trong !";
        }
    }

    public function category_delete() {

        $id = (int) $this->input->post('id');
        $sql = "DELETE FROM category WHERE id=" . $id;
        $this->db->query($sql);
    }

    public function category_update() {
        $id = (int) $this->input->post('id');
        $title = $this->input->post('title');
        $sql = "UPDATE category SET title='" . $title . "' WHERE id=" . $id;
        $this->db->query($sql);
        echo $sql;
    }

    public function product_add() {
        $title = $this->input->post('t');


        $this->db->query("INSERT  INTO product(title)VALUES('" . $title . "')");
    }

    public function product_loadlist() {
        $list = $this->db->query("SELECT * FROM product")->result();
        if (!empty($list)) {
            foreach ($list as $item) {
                echo "<div class='item' id='product_item_" . $item->id . "'>"
                . "<span class='title'>" . $item->title . "</span>"
                . "<span class='float_right'>"
                . "<i class='fas fa-save' style='color:blue' onclick='admin_product.update(" . $item->id . ")'></i>"
                . "&nbsp;&nbsp;<i class='fas fa-trash' style='color:red' onclick='admin_product.delete(" . $item->id . ")'></i>"
                . "&nbsp;&nbsp;<i class='fas fa-pencil-alt' style='color:green' onclick='admin_product.edit(" . $item->id . ")'></i>"
                . "</span>"
                . "<div class='clear_both'></div>"
                . "</div>";
            }
        } else {
            echo "khong co san pham nao !";
        }
    }

    public function product_delete() {

        $id = (int) $this->input->post('id');
        $sql = "DELETE FROM product WHERE id=" . $id;
        $this->db->query($sql);
    }

    public function product_loadedit() {
        $id = $this->input->post('id');
        $title = $this->db->query("select * from product where id=" . $id)->result()[0]->title;
        $price = $this->db->query("select * from product where id=" . $id)->result()[0]->price;
        $file_ex = $this->db->query("select * from product where id=" . $id)->result()[0]->file_ex;
        $id_category = $this->db->query("select * from product where id=" . $id)->result()[0]->id_category;
        echo '<form class="sanpham margin_top_10" action="javascript:void(0)">
                <input class="admin_product_update_title popup_input_text " type="text" value="' . $title . '">
             <select class="admin_product_update_id_parent popup_input_text ">
                    <option value="-1">chon danh muc san pham</option>
                    ';
        $list = $this->db->query("SELECT * FROM category")->result();
        if (!empty($list)) {
            foreach ($list as $item) {
                $temp = '';
                if ($id_category == $item->id) {
                    $temp = "selected='selected'";
                }
                echo "<option " . $temp . " value= '" . $item->id . "'>" . $item->title . "</option>";
            }
        }
        echo '
                </select>
                <input class="admin_product_update_price" type="text" value="' . $price . '"></input>
                    
                <input type="file" id="admin_product_update_avata_input" onchange="admin_product.update_setavata(this)">
                <img src="asset/images/product_avata/'.$id.'.'.$file_ex.'" id="admin_product_update_avata_view" onclick="$(\'#admin_product_update_avata_input\').click()">
                <br>
                <textarea id="admin_product_update_detail">'.$this->db->query("select * from product where id=" . $id)->result()[0]->detail.'</textarea>
                <br>
                <input class="padding_5 popup_input_submit" type="submit" value="Cập nhật" onclick="admin_product.update(' . $id . ')">
                <input class="padding_5 popup_input_cancel" type="button" value="Hủy" onclick="admin_product.edit_cancel()">
            </form>';
    }

    public function product_update() {
        $id = (int) $this->input->post('id');
        $title = $this->input->post('title');
        $price = $this->input->post('price');
        $id_category = $this->input->post('id_category');
        $detail = $this->input->post('detail');
        
        $avata = $this->input->post('avata');
        $avata = explode(";base64,", $avata);
        $file_ex = $this->db->query("SELECT * FROM product WHERE id=".$id)->result()[0]->file_ex;
        if(count($avata) == 2)
        {
            $file_ex = str_replace("data:image/", "", $avata[0]);
            if($file_ex == "jpeg")
            {
                $file_ex = "jpg";
            }
            file_put_contents("asset/images/product_avata/".$id.".".$file_ex, base64_decode($avata[1]));
        }
        $sql = "UPDATE product SET title='" . $title . "', price=" . $price . ", id_category=" . $id_category . " , file_ex= '".$file_ex."' , detail= '".$detail."' WHERE id=" . $id;
        $this->db->query($sql);
        
        //echo $sql;
    }

}
