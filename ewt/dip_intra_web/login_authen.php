<?php
DEFINE('path', 'assets/');
include path . 'config/config.inc.php';
$url_authen = $sso->decrypt($_GET["authen"],'prd_authen','hnqbioi7l0r7lrhjpfltv6tlq3');
$authen = explode(',',$url_authen);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $authen[0],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_POSTFIELDS => 'username='.$authen[1].'&percardno='.$authen[2].'',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
    ),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;
exit;

