<?php

$this->load->view('header');
?>
<?php

$item = $this->db->query("select * from product where id = " . $id)->result()[0];
echo loadtemplate("product/product_detail.html", [
    '__id__' => $item->id,
    '__title__' => $item->title,
    '__avata__' => "asset/images/product_avata/" . $item->id . "." . $item->file_ex,
    '__price__' => $item->price,
    '__count__' => 1
]);
?>


<?php

$this->load->view('footer');
?>
