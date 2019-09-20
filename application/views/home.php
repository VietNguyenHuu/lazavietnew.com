<?php
$this->load->view('header');
?>
<!--thẻ danh mục - slider-->
<div class="slider">
    <div class="max_width1188">
        <div class="display_table margin_bottom_0">
            <div class="display_table_row">
                <div class="display_table_cell vertical_align_top slider_left_cell">
                    <ul class="product_type text_transform_capitalize">
                        <?php
                        $list = $this->db->query("SELECT * FROM category")->result();
                        if (!empty($list)) {
                            foreach ($list as $item) {
                                echo "<li><a>" . $item->title . "</a>";
                                $list2 = $this->db->query("SELECT * FROM category where id_parent=" . $item->id)->result();
                                if (!empty($list2)) {
                                    echo '<ul class="list_style_type_none text_transform_capitalize">';
                                    foreach ($list2 as $item2) {
                                        echo "<li><a>" . $item2->title . "</a>";
                                        $list3 = $this->db->query("SELECT * FROM category where id_parent=" . $item2->id)->result();
                                        if (!empty($list3)) {
                                            echo '<ul class="list_style_type_none text_transform_capitalize">';
                                            foreach ($list3 as $item3) {
                                                echo "<li><a>" . $item3->title . "</a>";

                                                echo "</li>";
                                            }
                                            echo '</ul>';
                                        }
                                        echo "</li>";
                                    }
                                    echo '</ul>';
                                }
                                echo "</li>";
                            }
                        } else {
                            echo "danh muc san pham trong !";
                        }
                        ?>
                        <!--                                <li>Thiết bị điện tử
                                                            <ul class="list_style_type_none text_transform_capitalize">
                                                                <li><a>Điện thoại di động</a>
                                                                    <ul class="list_style_type_none">
                                                                        <li><a>Xiaomi</a><li>
                                                                        <li><a>Nokia</a><li>
                                                                        <li><a>Samsung</a><li>
                                                                        <li><a>Oppo</a><li>
                                                                    </ul>
                                                                </li>
                                                                <li><a>Laptop</a><li>
                                                                <li><a>Máy tính bảng</a><li>
                                                                <li><a>Máy tính để bàn</a><li>
                                                                <li><a>Âm thanh</a><li>
                                                                <li><a>Máy chơi game</a><li>
                                                                <li><a>Camera hành động/máy quay</a><li>
                                                                <li><a>Camera giám sát</a><li>
                                                                <li><a>Camera kỹ thuật số</a><li>
                                                                <li><a>Thiết bị số</a><li>
                                                            </ul>
                                                        </li>
                                                        <li>Phụ kiện điện tử</li>
                                                        <li>TV & Thiết Bị Điện Gia Dụng</li>
                                                        <li>Sức khỏe & làm đẹp</li>
                                                        <li>Hàng mẹ, bé & đồ chơi</li>
                                                        <li>Siêu thị tạp hóa</li>
                                                        <li>Hàng gia dụng & đời sống</li>
                                                        <li>Thời trang nữ</li>
                                                        <li>Thời trang nam</li>
                                                        <li>Phụ kiện thời trang</li>
                                                        <li>Thể thao & du lịch</li>
                                                        <li>Ôto, xe máy & thiết bị định vị
                                                        </li>-->
                    </ul>
                </div>
                <div class="display_table_cell vertical_align_top">
                    <img class="max" src="asset/images/2.jpg">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- thẻ page -->
<div class="page">
    <div class="max_width1188">
        <div class="DanhMuc margin_top_15">
            <ul class="box_sizing list_style_type_none text_transform_capitalize font_size_18 ">
                <li class="box_sizing width_percent_25 float_left"><a>LazMall</a></li>
                <li class="box_sizing width_percent_25 float_left">Hàng quốc tế</li>
                <li class="box_sizing width_percent_25 float_left">Dịch vụ & nạp thẻ</li>
                <li class="box_sizing width_percent_25 float_left">Mã giảm giá</li>
                <div class="clear_both"></div>
            </ul>
        </div>
        <div class="TimKiemPB margin_bottom_20 margin_top_20">
            <span>Tìm kiếm phổ biến</span>
            <br>

            <div class="TimKiem_first width_percent_20 margin_top_10 float_left">Tìm kiếm đầu tiên</div>
            <div class="TimKiem_8 float_left">
                <?php
                $Ar = [1, 2, 3];

                function RenderSearch($i) {
                    echo "<div class='TimKiem_8_child'><span>$i</span></div>";
                }

                for ($i = 0; $i < 2; $i++) {
                    for ($j = 0; $j < 4; $j++) {
                        RenderSearch($i);
                    }
                }
                ?>
                <div class="clear_both"></div>
            </div>
            <div class="clear_both"></div>
        </div>
        <div class="FlashDeal">
            <span class="text_transform_capitalize">Deal chớp nhoáng</span>
            <div class="margin_20">
                <?php
                include "timehelper_helper.php";
                $t = TimeHelper();
                ?>
                <span>giờ: <?php echo $t->_gio . ":" . $t->_phut . ":" . $t->_giay; ?></span>
            </div>
            <div>
                <?php
                for ($i = 1; $i <= 7; $i++) {
                    echo"<div class='float_left'><img src='asset/images/dealchopnhoang/$i.webp'></div>";
                }
                echo '<div class="clear_both"></div>';
                ?>
            </div>
        </div>
        <div class="product_render">
            <h3>
                <u>Tất cả sản phẩm</u>
            </h3>
                <div class="product_show">
                    
                    <?php
                        $product = $this->db->query("select * from product")->result();
                        foreach($product as $item){
                            echo loadtemplate("home/product_show_item.html",[
                                '__id__' => $item->id,
                                '__title__' => $item->title,
                                '__avata__' => "asset/images/product_avata/".$item->id.".".$item->file_ex,
                                '__price__' => $item->price
                            ]);
                        }
                        
                        ?>
                    <div class="clear_both"></div>
                </div>
                </h3>
            </div>
        </div>
    </div>


    <?php
    $this->load->view('footer');
    ?>
