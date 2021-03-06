<?php
function dumper ( $some_var, $msg = '' )
{
    echo "<pre>\n";
    if ( !empty($msg) )
        echo "$msg\n";
    var_dump( $some_var );
    echo "</pre>\n";
}

function is_email ($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) && 
        preg_match('/@.+\./', $email);
}

function is_url ($url )
{
    return filter_var($url, FILTER_VALIDATE_URL);
}

// @TODO add secure hash too
// http://web.archive.org/web/20130727034425/http://blog.kevburnsjr.com/php-unique-hash
// NOT TOO HARD
// below is base 62, because there are 62 chars
// $chars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'

// thx http://programanddesign.com/php/base62-encode/

// below default is base 35, because there are 35 chars
/**
 * Converts a base 10 number to any other base.
 * 
 * @param int $val   Decimal number
 * @param int $base  Base to convert to. If null, will use strlen($chars) as base.
 * @param string $chars Characters used in base, arranged lowest to highest. Must be at least $base characters long.
 * 
 * @return string    Number converted to specified base
 */
function base_encode($val, $base=62, $chars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    if(!isset($base)) $base = strlen($chars);
    $str = '';
    do {
        $m = bcmod($val, $base);
        $str = $chars[$m] . $str;
        $val = bcdiv(bcsub($val, $m), $base);
    } while(bccomp($val,0)>0);
    return $str;
}

/**
 * Convert a number from any base to base 10
 * 
 * @param string $str   Number
 * @param int $base  Base of number. If null, will use strlen($chars) as base.
 * @param string $chars Characters use in base, arranged lowest to highest. Must be at least $base characters long.
 * 
 * @return int    Number converted to base 10
 */
function base_decode($str, $base=62, $chars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    if(!isset($base)) $base = strlen($chars);
    $len = strlen($str);
    $val = 0;
    $arr = array_flip(str_split($chars));
    for($i = 0; $i < $len; ++$i) {
        $val = bcadd($val, bcmul($arr[$str[$i]], bcpow($base, $len-$i-1)));
    }
    return $val;
}

function is_ip_allowed ()
{
    // check if the client IP is allowed to shorten
    if($_SERVER['REMOTE_ADDR'] != LIMIT_TO_IP)
    {
        die('You are not allowed to shorten URLs with this service.');
    }

}

/**
 * check if a url is real, and this also NEEDS an internet connection.
 */
function is_url_real ($url_to_shorten)
{
    $test_flag = true;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_to_shorten);
    curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    if( curl_getinfo($ch, CURLINFO_HTTP_CODE) == '404' ||
        FALSE == $response )
    {
        dumper($response);
        $test_flag = false;
    }
    curl_close($ch);
    return $test_flag;
}

function encodeURI($uri)
{
    return preg_replace_callback("{[^0-9a-z_.!~*'();,/?:@&=+$#]}i",
        function ($m) 
    {
        return sprintf('%%%02X', ord($m[0]));
    }, $uri);
}

function cleanVal ($val)
{
    // return encodeURI(str_replace(PHP_EOL, ', ', trim($val)));
    return encodeURI($val);
}

function get_short_url_path ($key)
{

    return ( empty($_SERVER['HTTPS']) ? 'http://' : 'https://' ) . 
                $_SERVER['SERVER_NAME'] . 
                dirname( $_SERVER['SCRIPT_NAME'] ) . '/' . $key;

}

// no defaul: $service = 'http://service.localhost/u2s'
function get_short_url ($url, $service)
{
    $test_flag = true;
    $ready_url = $service . '/set/?l=' . urlencode($url);
    // dumper($ready_url);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ready_url);
    curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    if( curl_getinfo($ch, CURLINFO_HTTP_CODE) == '404' ||
        FALSE == $response )
    {
        $test_flag = false;
        curl_close($ch);
        return $test_flag;
    }
    curl_close($ch);
    return $response;
    
}

?>
