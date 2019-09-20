<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Chào mừng bạn đến với Lazaviet</title>

        <meta name="dc.language" content="VN"/>
        <meta name="dc.source" content="{{base_url}}"/>
        <meta name="dc.creator" content="{{page_slogend}}" />
        <meta name="distribution" content="Global" />
        <meta name="geo.placename" content="Vietnamese" />
        <meta name="geo.region" content="Vietnamese" />
        <meta name="title" content="{{page_title}}"/>
        <meta name="description" content="{{page_description}}"/>
        <meta name="keywords" content="{{page_keyword}}"/>
        <meta name="news_keywords" content="{{page_keyword}}"/>
        <meta name="author" content="{{page_author}}"/>
        <meta name="robots" content="index, follow"/>
        <meta name='revisit-after' content='1 days'/>
        <meta property="og:locale" content="vi_VN" />
        <meta property="og:site_name" content="{{page_slogend}}" />
        <meta property="og:url" content="{{page_fb_url}}" />
        <meta property="og:type"  content="{{page_fb_type}}" />
        <meta property="og:title"  content="{{page_fb_title}}" />
        <meta property="og:description" content="{{page_fb_description}}" />
        <meta property="og:image" content="{{page_fb_image}}" />

        <meta name='viewport' content="width=device-width,initial-scale=1" />
        <base href="http://lazavietnew.com:8080/" />

        <link href='assets/img/system/favico.png' rel="shortcut icon" type="image/png" />

        <link type="text/css" href="asset/css/fontawesome.css" rel="stylesheet">

        <link type="text/css" href="asset/css/mylibri_viet.css" rel="stylesheet">
        <link type="text/css" href="asset/css/index.css" rel="stylesheet">
        <?php
        if (isset($addcss)) {
            echo '<link type="text/css" href="asset/css/' . $addcss . '" rel="stylesheet">';
        }
        ?>
        <script src="asset/js/Jquery.js"></script>
        <script src="../../ckeditor_4.11.3_full/ckeditor/ckeditor.js"></script>
        <script src="asset/js/header.js"></script>
    </head>
    <body>

        <div class="header">
            <div class="header_top">
                <div class="max_width1188">
                    <ul>
                        <li>CHĂM SÓC KHÁCH HÀNG</li>
                        <li>KIỂM TRA ĐƠN HÀNG</li>
                        <?php
                        if (empty($this->session->userdata('username')) == true) {
                            echo '<li><a href="http://lazavietnew.com:8080/index.php/login">ĐĂNG NHẬP</a></li>
                                 <li><a href="http://lazavietnew.com:8080/index.php/register">ĐĂNG KÝ</a></li>';
                        } else {
                            echo '<li>Xin chao ' . $this->session->userdata('username') . '</li>';
                            echo '<li><a href="http://lazavietnew.com:8080/index.php/logout">Đăng xuất</a></li>';
                        }
                        ?>

                        <li class="clearboth"></li>
                    </ul>
                    <div class="clearboth"></div>
                </div>
            </div>
            <div class="header_bottom">
                <div class="max_width1188">
                    <div class="header_bottom_left">
                        <a href="http://lazavietnew.com:8080/index.php">
                            <img src="asset/images/1.jpg">
                        </a>
                    </div>
                    <form class="header_bottom_mid" action="#" method="post">
                        <input type="text" value="" placeholder="Tìm kiếm sản phẩm" class="padding_left_20">
                        <button type="submit">
                            <i class="fas fa-2x fa-search"></i>
                        </button>
                        <div class="clearboth"></div>
                    </form>
                    <div class="header_bottom_right">
                        <a class="cart_button" href="http://lazavietnew.com:8080/index.php/cart/index">
                        <i class="fas fa-2x fa-cart-plus cart_button"></i>
                        </a>
                        <span class="user_cart_total"></span>
                    </div>
                    <div class="clearboth"></div>
                </div>
            </div>
        </div>