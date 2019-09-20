<?php
$this->load->view('header');
?>
<?php
                $list = $this->db->query("SELECT * FROM category")->result();
                $str="";
                if (!empty($list)) {
                    foreach ($list as $item) {
                        $str.= "<option value= '" . $item->id . "'>" . $item->title . "</option>";
                    }
                }
                echo loadtemplate("admin/main.html", [
                    '__category_list__'=>$str
                ]);
                ?>

<?php
$this->load->view('footer');
?>
