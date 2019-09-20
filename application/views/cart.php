<?php

$this->load->view('header');
?>

<?php

$id = $this->db->query("select * from user where V_UserName = '" . $this->session->userdata('username') . "'");
$id_user = $id->result()[0]->ID;

$list = $this->db->query("select * from cart where v_id_user = " . $id_user);

$str = "";
foreach ($list->result() as $row) {
    $item = $this->db->query("select * from product where id = ".$row->v_id_product)->result()[0];
    $str .= loadtemplate("cart/cart_item.html", [
        '__avata__' => "asset/images/product_avata/".$item->id.".".$item->file_ex,
        '__id__' => $row->id,
        '__title__' => $this->db->query('select * from product where id = ' . $row->v_id_product)->result()[0]->title,
        '__count__' => $row->v_count,
        '__dongia__' => $this->db->query('select * from product where id = ' . $row->v_id_product)->result()[0]->price,
        '__thanhtien__' => number_format($row->v_count * $this->db->query('select * from product where id = ' . $row->v_id_product)->result()[0]->price)
    ]);
    //$str.= "<div><span class='list_cart_title'>".$this->db->query('select * from product where id = '.$row->v_id_product)->result()[0]->title."</span> <span>".$row->v_count."</span></div>";
}
echo loadtemplate("cart/index.html", [
    '__list__' => $str,
]);
?>

<script src ="asset/js/cart.js"></script>
        <?php

        $this->load->view('footer');
        ?>
