<?php

header('Content-type:text/html;charset=utf-8');
$url = "http://localhost/phpapi/server.php?a=info&qq=979137";
$arg = array(
    'a'  => 'info',
    'qq' => '979137',
);

$query_string = http_build_query($arg);

$ch = curl_init($url.'?'.$query_string);
curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_USERAGENT , 'QQ_Mobile_V5.5');
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 60 );
curl_setopt($ch, CURLOPT_TIMEOUT , 60);
curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch , CURLINFO_HTTP_CODE);
curl_close($ch);
if ($response === false) {
    var_dump(curl_error($ch));
} elseif ($httpcode != 200) {
    var_dump($httpcode, 'http request fail');
} else {
    $ret = json_decode($response, true);
    var_dump($ret);
}
