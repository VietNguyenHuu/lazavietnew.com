<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Please change below values
 */
$config['myconfig_reset_secure_code'] = "1234567890";

/* -------- -------- --------- ----------- ----------- ---------- ---------- --------- */

/*
 * Consider and change below values corectly
 */
$config['myconfig_protocol'] = 'http';
$config['myconfig_baseurl_subfolder'] = '';

/* -------- -------- --------- ----------- ----------- ---------- ---------- --------- */

/*
 * Don't change below values
 */
$port = ":" . $_SERVER['SERVER_PORT'];
if ($port == ":80" || $port == ':443') {
    $port = "";
}
$config['base_url'] = ""
        . $config['myconfig_protocol']
        . "://"
        . $_SERVER["SERVER_NAME"]
        . $port
        . "/"
        . $config['myconfig_baseurl_subfolder'];

$config['myconfig_page_fb_type'] = 'website';

$config['myconfig_array_image_filetype'] = [
    'png' => 'image/png',
    'wbmp' => 'image/bmp',
    'gif' => 'image/gif',
    'jpg' => 'image/jpeg'
];

$config['myconfig_array_music_filetype'] = [
    'mp3' => 'audio/mpeg',
    'ogg' => 'audio/ogg',
    'wav' => 'audio/wav'
];

