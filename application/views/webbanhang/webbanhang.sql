-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 07, 2018 lúc 02:18 PM
-- Phiên bản máy phục vụ: 10.1.36-MariaDB
-- Phiên bản PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbanhang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `advertiment`
--

CREATE TABLE `advertiment` (
  `id` bigint(20) NOT NULL,
  `m_id_user` bigint(20) NOT NULL DEFAULT '-1',
  `m_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'quảng cáo',
  `m_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_view` int(11) NOT NULL DEFAULT '0',
  `m_click` int(11) NOT NULL DEFAULT '0',
  `m_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'navi',
  `m_id_user_check` bigint(20) NOT NULL DEFAULT '-1',
  `m_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'on',
  `m_file_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'gif'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `m_name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `m_content` longtext COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`m_name`, `m_content`) VALUES
('template_posttype_toptags', '<div class=\'navi_item\'>\n    <div class=\'navi_item_header\'>\n        <span class=\'align_middle\'>TAGS nổi bật</span>\n    </div>\n    <div class=\'navi_submenu\'>\n        <div class=\'margin_v padding_v post_tags_box\'>\n            \n        </div>\n    </div>\n</div>'),
('template_home_topauthor', '<div class=\'navi_item\'><div class=\'navi_item_header\'><span class=\'align_middle\'>Top tác giả tuần</span></div><div class=\'navi_submenu\'></div></div>');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0uq7kegpcjni3ms1144idjq6e5rhbmm6', '127.0.0.1', 1544188677, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534343138383635363b6964757365727c733a313a2231223b);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `company`
--

CREATE TABLE `company` (
  `id` bigint(20) NOT NULL,
  `m_title` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_leader` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_link` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_province_code` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_province_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contribute`
--

CREATE TABLE `contribute` (
  `id` bigint(20) NOT NULL,
  `m_id_user` bigint(20) DEFAULT NULL,
  `m_content` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_date` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `message`
--

CREATE TABLE `message` (
  `id` bigint(20) NOT NULL,
  `m_id_user_from` bigint(20) NOT NULL,
  `m_id_user_to` bigint(20) NOT NULL,
  `m_content` text COLLATE utf8_unicode_ci NOT NULL,
  `m_militime_send` bigint(20) NOT NULL,
  `m_militime_receive` bigint(20) NOT NULL DEFAULT '-1',
  `m_is_show` tinyint(4) NOT NULL DEFAULT '1',
  `m_feel` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `m_is_spam` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_author`
--

CREATE TABLE `post_author` (
  `id` bigint(20) NOT NULL,
  `m_id_user` bigint(20) NOT NULL,
  `m_date` bigint(20) DEFAULT '-1',
  `m_status` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'active' COMMENT 'active/unactive',
  `m_score_multi` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_comment`
--

CREATE TABLE `post_comment` (
  `id` bigint(20) NOT NULL,
  `m_id_content` bigint(20) NOT NULL,
  `m_id_user` bigint(20) NOT NULL,
  `m_content` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `m_date` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_status` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ready',
  `m_rank` varchar(20) COLLATE utf8_unicode_ci DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_content`
--

CREATE TABLE `post_content` (
  `id` bigint(20) NOT NULL,
  `m_id_type` bigint(20) NOT NULL,
  `m_id_user` bigint(20) NOT NULL,
  `m_id_group` bigint(20) NOT NULL DEFAULT '-1',
  `m_group_index` int(11) NOT NULL DEFAULT '1',
  `m_title` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `m_title_search` varchar(300) COLLATE utf8_unicode_ci DEFAULT '',
  `m_status` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'ready',
  `m_view` int(11) NOT NULL DEFAULT '1',
  `m_like` int(11) NOT NULL DEFAULT '1',
  `m_date` datetime DEFAULT '1970-01-01 00:00:00',
  `m_rank` varchar(20) COLLATE utf8_unicode_ci DEFAULT '0',
  `m_militime` bigint(20) NOT NULL,
  `m_id_user_check` bigint(20) DEFAULT '-1',
  `m_avata_hide` tinyint(4) DEFAULT '0',
  `m_file_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'gif',
  `m_seo_title` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `m_seo_keyword` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `m_seo_description` varchar(250) COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_content_content`
--

CREATE TABLE `post_content_content` (
  `id` bigint(20) NOT NULL,
  `m_content` longtext COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_follow`
--

CREATE TABLE `post_follow` (
  `id` bigint(20) NOT NULL,
  `m_id_user` bigint(20) NOT NULL,
  `m_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'post' COMMENT 'post/ type/ author',
  `m_id_value` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_group`
--

CREATE TABLE `post_group` (
  `id` bigint(20) NOT NULL,
  `m_id_user_create` bigint(20) NOT NULL,
  `m_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `m_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `m_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ready' COMMENT 'ready / public / trash',
  `m_view` int(11) NOT NULL DEFAULT '0',
  `m_like` int(11) NOT NULL DEFAULT '0',
  `m_militime` bigint(20) NOT NULL,
  `m_militime_modify` bigint(20) NOT NULL,
  `m_file_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'gif',
  `m_seo_title` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_seo_keyword` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_seo_description` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_report`
--

CREATE TABLE `post_report` (
  `id` bigint(20) NOT NULL,
  `m_id_user` bigint(20) NOT NULL DEFAULT '-1',
  `m_id_post` bigint(20) NOT NULL,
  `m_id_pattern` bigint(20) NOT NULL DEFAULT '-1',
  `m_ex` varchar(2000) COLLATE utf8_unicode_ci DEFAULT '',
  `m_militime` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_report_pattern`
--

CREATE TABLE `post_report_pattern` (
  `id` bigint(20) NOT NULL,
  `m_title` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `m_index` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_tags`
--

CREATE TABLE `post_tags` (
  `id` bigint(20) NOT NULL,
  `m_id_post` bigint(20) NOT NULL,
  `m_title` varchar(200) NOT NULL,
  `m_title_search` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_type`
--

CREATE TABLE `post_type` (
  `id` bigint(20) NOT NULL,
  `m_id_parent` bigint(20) NOT NULL DEFAULT '1',
  `m_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_view` int(11) NOT NULL DEFAULT '1',
  `m_status` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ready',
  `m_index` int(11) DEFAULT '1',
  `m_new_post_time` bigint(20) DEFAULT '0',
  `m_ar_direct_type` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `m_ar_list_type` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `m_seo_title` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_seo_keyword` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_seo_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post_type`
--

INSERT INTO `post_type` (`id`, `m_id_parent`, `m_title`, `m_view`, `m_status`, `m_index`, `m_new_post_time`, `m_ar_direct_type`, `m_ar_list_type`, `m_seo_title`, `m_seo_keyword`, `m_seo_description`) VALUES
(1, -1, 'web ban hang', 0, 'ready', 1, 0, '', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_view`
--

CREATE TABLE `post_view` (
  `id_post` mediumint(9) NOT NULL,
  `m_n1` mediumint(9) DEFAULT '0',
  `m_n2` mediumint(9) DEFAULT '0',
  `m_n3` mediumint(9) DEFAULT '0',
  `m_n4` mediumint(9) DEFAULT '0',
  `m_n5` mediumint(9) DEFAULT '0',
  `m_n6` mediumint(9) DEFAULT '0',
  `m_n7` mediumint(9) DEFAULT '0',
  `m_2day` mediumint(9) DEFAULT '0',
  `m_3day` mediumint(9) DEFAULT '0',
  `m_week` mediumint(9) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `province_code`
--

CREATE TABLE `province_code` (
  `m_code` int(11) NOT NULL,
  `m_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `province_code`
--

INSERT INTO `province_code` (`m_code`, `m_title`) VALUES
(0, 'khác'),
(1, 'Hà Nội'),
(2, 'Thành Phố Hồ Chí Minh'),
(3, 'Hải Phòng'),
(4, 'Đà Nẵng'),
(5, 'Cần thơ'),
(6, 'An Giang'),
(7, 'Bà Rịa vũng Tàu'),
(8, 'Bắc Giang'),
(9, 'Bắc Cạn'),
(10, 'Bạc Liêu'),
(11, 'Bắc Ninh'),
(12, 'Bến Tre'),
(13, 'Bình Định'),
(14, 'Bình dương'),
(15, 'Bình phước'),
(16, 'Bình Thuận'),
(17, 'Cà Mau'),
(18, 'Cao Bằng'),
(19, 'Đắc Nông '),
(20, 'ĐắkLắk'),
(21, 'Điện Biên'),
(22, 'Đồng Nai'),
(23, 'Đồng Tháp'),
(24, 'Gia Lai'),
(25, 'Hà Giang'),
(26, 'Hà Nam'),
(27, 'Hà Tĩnh'),
(28, 'Hải Dương'),
(29, 'Hậu Giang  '),
(30, 'Hoà Bình'),
(31, 'Hưng Yên'),
(32, 'Khánh Hoà'),
(33, 'Kiên Giang'),
(34, 'Kon Tum'),
(35, 'Lai Châu'),
(36, 'Lâm Đồng'),
(37, 'Lạng Sơn'),
(38, 'Lào Cai'),
(39, 'Long An'),
(40, 'Nam Định'),
(41, 'Nghệ An'),
(42, 'Ninh Bình'),
(43, 'Ninh Thuận'),
(44, 'Phú Thọ'),
(45, 'Phú Yên'),
(46, 'Quảng Bình'),
(47, 'Quảng Nam'),
(48, 'Quảng Ngãi'),
(49, 'Quảng Ninh'),
(50, 'Quảng Trị'),
(51, 'Sóc Trăng'),
(52, 'Sơn La'),
(53, 'Tây Ninh'),
(54, 'Thái Bình'),
(55, 'Thái Nguyên'),
(56, 'Thanh Hoá'),
(57, 'Thừa Thiên Huế'),
(58, 'Tiền Giang'),
(59, 'Trà Vinh'),
(60, 'Tuyên Quang'),
(61, 'Vĩnh Long'),
(62, 'Vĩnh Phúc'),
(63, 'Yên Bái');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `public_message`
--

CREATE TABLE `public_message` (
  `id` bigint(20) NOT NULL,
  `m_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `m_date` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_id_user` bigint(20) DEFAULT NULL,
  `m_fromlink` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reset_pass`
--

CREATE TABLE `reset_pass` (
  `id` bigint(20) NOT NULL,
  `m_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `m_token` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `m_time` bigint(20) NOT NULL,
  `m_numcheck` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `search_link`
--

CREATE TABLE `search_link` (
  `id` bigint(20) NOT NULL,
  `m_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `m_id_user_add` bigint(20) NOT NULL DEFAULT '-1',
  `m_title` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `m_keyword` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_description` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_updatetime` bigint(20) NOT NULL DEFAULT '-1',
  `m_h1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_h2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_total_click` mediumint(9) NOT NULL DEFAULT '0',
  `m_link_type` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'normal',
  `m_rank` mediumint(9) DEFAULT '0',
  `m_exactly_word` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `search_word`
--

CREATE TABLE `search_word` (
  `id` bigint(20) NOT NULL,
  `m_word` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `m_str_link` mediumtext COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `static_page`
--

CREATE TABLE `static_page` (
  `id` bigint(20) NOT NULL,
  `m_id_parent` bigint(20) NOT NULL DEFAULT '1',
  `m_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'system',
  `m_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'static page',
  `m_title_shorcut` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `m_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_index` int(11) NOT NULL DEFAULT '1',
  `m_content` longtext COLLATE utf8_unicode_ci,
  `m_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'on',
  `m_view` int(11) NOT NULL DEFAULT '1',
  `m_is_primary` int(11) DEFAULT '0',
  `m_option_showheader` tinyint(4) NOT NULL DEFAULT '1',
  `m_option_showfooter` tinyint(4) NOT NULL DEFAULT '1',
  `m_option_showinheader` tinyint(4) NOT NULL DEFAULT '0',
  `m_option_showinfooter` tinyint(4) NOT NULL DEFAULT '0',
  `m_option_showbreakcump` tinyint(4) NOT NULL DEFAULT '1',
  `m_option_showfullshare` tinyint(4) DEFAULT '1',
  `m_option_showquickmessage` tinyint(4) DEFAULT '1',
  `m_adding_css` longtext COLLATE utf8_unicode_ci,
  `m_adding_js` longtext COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `statistic_access`
--

CREATE TABLE `statistic_access` (
  `id` bigint(20) NOT NULL,
  `m_year` smallint(11) NOT NULL,
  `m_month` tinyint(11) NOT NULL,
  `m_date` tinyint(11) NOT NULL,
  `m_hour` tinyint(11) NOT NULL,
  `m_total` mediumint(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `statistic_access`
--

INSERT INTO `statistic_access` (`id`, `m_year`, `m_month`, `m_date`, `m_hour`, `m_total`) VALUES
(2, 2018, 12, 7, 20, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `system`
--

CREATE TABLE `system` (
  `id` int(11) NOT NULL,
  `m_creatted_id` bigint(20) NOT NULL,
  `m_count_access` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `system`
--

INSERT INTO `system` (`id`, `m_creatted_id`, `m_count_access`) VALUES
(1, 3, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `system_param`
--

CREATE TABLE `system_param` (
  `m_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `m_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `m_comment` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `system_param`
--

INSERT INTO `system_param` (`m_name`, `m_value`, `m_comment`) VALUES
('admin_post_content_lastresetview', '0', 'Thời gian cuối cập nhật lượt xem cho tất cả bài viết'),
('googleAnalyticCode', '', ''),
('facebookSdkCode', '', ''),
('Phone_support', '', 'Phone for support in website, customer of website can view this phone.'),
('Company_name', '', 'Full name of company.'),
('Post_mg_when_check', 'Bài viết của bạn đã được duyệt và hiển thị tại {{link}}, hãy chia sẻ tới bạn bè để mọi người cùng đọc nhé ! \n Bạn được cộng {{bonus_score}} điểm cho bài viết này !', 'Message will send to post author, when admin check this post'),
('Post_bonus_score_write', '0', 'Score to add into author when post check'),
('Post_bonus_score_view', '0', 'Score to add into author when post view'),
('Site_domain_name', 'webbanhang.com', 'Domain name of website'),
('Site_slogend', 'website web ban hang', 'Slogend of site'),
('facebook_fanpage', '', 'Link to facebook fanpage'),
('facebook_fanpage_title', '', 'Title of fanpage facebook'),
('Site_title', 'web ban hang', 'Default title of website'),
('Site_description', 'Chào mứng bạn đến với web ban hang', 'Default scription of website'),
('Site_keyword', 'web ban hang', 'Default keyword of website'),
('Site_fb_title', 'web ban hang', 'Default fb title of website'),
('Site_fb_description', 'Chào mứng bạn đến với web ban hang', 'Default description fb of website'),
('page_option_showpublicmessage', 'true', 'Show quick public message in footer. This allow all person can send a message to your website.'),
('page_option_showanalytic', 'true', 'Allow google analytic tracking website');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `m_fb_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT '-1',
  `m_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `m_pass` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `m_realname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `m_realname_search` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_level` int(11) NOT NULL,
  `m_money` bigint(20) NOT NULL DEFAULT '0',
  `m_sex` int(11) NOT NULL,
  `m_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `m_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `m_birth` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `m_province_code` int(11) NOT NULL,
  `m_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `m_score` int(11) NOT NULL,
  `m_lock` int(11) DEFAULT '0',
  `m_lasttime` int(11) NOT NULL,
  `m_file_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'gif'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `m_fb_token`, `m_name`, `m_pass`, `m_realname`, `m_realname_search`, `m_level`, `m_money`, `m_sex`, `m_phone`, `m_email`, `m_birth`, `m_province_code`, `m_address`, `m_score`, `m_lock`, `m_lasttime`, `m_file_type`) VALUES
(1, '-1', 'webbanhang', 'c4a4d34fdb3b452d4d264a625c4c305e', 'Admin', 'Adminsbsb', 5, 0, 1, 'no', 'dinhnam2901@gmail.com', '1970-01-01', 0, 'no', 100, 0, 1544188677, 'gif');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `advertiment`
--
ALTER TABLE `advertiment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_status` (`m_status`),
  ADD KEY `m_type` (`m_type`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`m_name`),
  ADD UNIQUE KEY `m_name` (`m_name`);

--
-- Chỉ mục cho bảng `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contribute`
--
ALTER TABLE `contribute`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id_user_from` (`m_id_user_from`),
  ADD KEY `m_id_user_to` (`m_id_user_to`);

--
-- Chỉ mục cho bảng `post_author`
--
ALTER TABLE `post_author`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id_user` (`m_id_user`);

--
-- Chỉ mục cho bảng `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id_user` (`m_id_user`),
  ADD KEY `m_id_content` (`m_id_content`);

--
-- Chỉ mục cho bảng `post_content`
--
ALTER TABLE `post_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_militime` (`m_militime`),
  ADD KEY `m_id_type` (`m_id_type`),
  ADD KEY `m_id_user` (`m_id_user`),
  ADD KEY `m_id_user_check` (`m_id_user_check`),
  ADD KEY `m_status` (`m_status`),
  ADD KEY `m_id_group` (`m_id_group`),
  ADD KEY `m_group_index` (`m_group_index`);
ALTER TABLE `post_content` ADD FULLTEXT KEY `m_title_search` (`m_title_search`);

--
-- Chỉ mục cho bảng `post_content_content`
--
ALTER TABLE `post_content_content`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `post_follow`
--
ALTER TABLE `post_follow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id_user` (`m_id_user`);

--
-- Chỉ mục cho bảng `post_group`
--
ALTER TABLE `post_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id_user_create` (`m_id_user_create`),
  ADD KEY `m_status` (`m_status`);

--
-- Chỉ mục cho bảng `post_report`
--
ALTER TABLE `post_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id_user` (`m_id_user`);

--
-- Chỉ mục cho bảng `post_report_pattern`
--
ALTER TABLE `post_report_pattern`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_index` (`m_index`);

--
-- Chỉ mục cho bảng `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id_post` (`m_id_post`),
  ADD KEY `m_title_search_2` (`m_title_search`);
ALTER TABLE `post_tags` ADD FULLTEXT KEY `m_title_search` (`m_title_search`);

--
-- Chỉ mục cho bảng `post_type`
--
ALTER TABLE `post_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id_parent` (`m_id_parent`),
  ADD KEY `m_index` (`m_index`),
  ADD KEY `m_new_post_time` (`m_new_post_time`);

--
-- Chỉ mục cho bảng `post_view`
--
ALTER TABLE `post_view`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `m_3day` (`m_3day`),
  ADD KEY `m_week` (`m_week`);

--
-- Chỉ mục cho bảng `province_code`
--
ALTER TABLE `province_code`
  ADD PRIMARY KEY (`m_code`);

--
-- Chỉ mục cho bảng `public_message`
--
ALTER TABLE `public_message`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reset_pass`
--
ALTER TABLE `reset_pass`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `search_link`
--
ALTER TABLE `search_link`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `static_page`
--
ALTER TABLE `static_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id_parent` (`m_id_parent`),
  ADD KEY `m_index` (`m_index`),
  ADD KEY `m_status` (`m_status`),
  ADD KEY `m_is_primary` (`m_is_primary`);

--
-- Chỉ mục cho bảng `statistic_access`
--
ALTER TABLE `statistic_access`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `system_param`
--
ALTER TABLE `system_param`
  ADD PRIMARY KEY (`m_name`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `user` ADD FULLTEXT KEY `m_realname_search` (`m_realname_search`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `company`
--
ALTER TABLE `company`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
