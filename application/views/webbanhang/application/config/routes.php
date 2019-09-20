<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = TRUE;

$route['page/(:any)-(:num).html']="staticPage/index/$2";

$route['quan-ly-bai-viet.html']="post/write";//quản lí viết bài
$route['quan-ly-bai-viet/(:any).html']="post/write/$1";//quản lí viết bài phan loại
$route['quan-ly-bai-viet/(:any)/(:any).html']="post/write/$1/$2";//quản lí viết bài phan trang phân loại

$route['danh-muc-bai-viet.html']="post/tat_ca_danh_muc";//xem tất cả danh mục bài viết
$route['danh-muc/(:any).html']="post/type/$1";//xem danh mục bài viết
$route['danh-muc/(:any)/(:any).html']="post/type/$1/$2";//xem danh mục bài viết phân trang

$route['bai-viet/(:any).html']="post/content/$1";//xem bài viết chi tiết
$route['tai-bai-viet/(:any).html']="post/download/$1";//tải bài viết chi tiết dưới dạng pdf

$route['tac-gia-bai-viet.html']="post/all_author";//xem tất cả tác giả bài viết
$route['tac-gia-bai-viet/(:any).html']="post/all_author/$1";//xem tất cả tác giả bài viết phân trang
$route['tac-gia/(:any).html']="post/author/$1";//xem tác giả bài viết
$route['tac-gia/(:any)/(:any).html']="post/author/$1/$2";//xem tác giả bài viết phân trang

$route['bao-loi-bai-viet/(:any).html']="post/bao_loi/$1";//Báo sai phạm bài viết

$route['bai-viet-quan-tam.html']="post/recent_view";//Bài viết được quan tâm
$route['bai-viet-quan-tam/(:any).html']="post/recent_view/$1";//Bài viết được quan tâm, phân trang

$route['bai-viet-yeu-thich.html']="post/like";//Bài viết được quan tâm
$route['bai-viet-yeu-thich/(:any).html']="post/like/$1";//Bài viết được quan tâm, phân trang

$route['nhom-bai-viet.html'] = 'post/series';
$route['nhom-bai-viet/trang-(:num).html'] = 'post/series/$1';
$route['series/(:any)-(:num).html'] = 'post/series_detail/$2';