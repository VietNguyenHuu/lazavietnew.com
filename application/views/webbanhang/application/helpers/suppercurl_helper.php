<?php
    
class supper_curl
{
    public function get($href="",$array_setopt=Array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $href);
        curl_setopt($ch, CURLOPT_CERTINFO, true);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        foreach($array_setopt as $key => $value)
        {
            curl_setopt($ch, $key, $value);
        }
        $str= curl_exec($ch);
        curl_close($ch);
        return $str;
    }
}
function supper_curl()
{
    return new supper_curl;
}
/*vi du
$str=$class_supper_curl->get('https://mbasic.facebook.com/',
    Array(
        CURLOPT_COOKIEFILE=>getcwd () . '/mirazmac_cookie.txt',
        CURLOPT_COOKIEJAR=>getcwd () . '/mirazmac_cookie.txt'
    ));
*/
/*list opt
    CURLOPT_COOKIEFILE
    CURLOPT_COOKIEJAR
    CURLOPT_URL
    CURLOPT_CERTINFO
    CURLOPT_FOLLOWLOCATION
    CURLOPT_SSL_VERIFYPEER
    CURLOPT_SSL_VERIFYHOST
    CURLOPT_RETURNTRANSFER
    CURLOPT_USERAGENT
    CURLOPT_HEADER
    
*/
?>