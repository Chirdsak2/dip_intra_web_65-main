<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
print_r($_SESSION['EWT_TOKEN']);
// $curl = curl_init();
// curl_setopt_array($curl, array(
//     CURLOPT_URL => 'http://203.151.166.133/DIP_SSO/api/public/GetSystem',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_SSL_VERIFYPEER => false,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'POST',
//     CURLOPT_HTTPHEADER => array(
//         'Authorization: Bearer '.$_SESSION['EWT_TOKEN'],
//         'Content-Type: application/json',
//         'Content-Length: 0'
//     ),
// ));

// $response = curl_exec($curl);
// $err = curl_error($curl);

// echo $err;
// curl_close($curl);

// $data = json_decode($response,true);

// echo "<pre>";
// print_r($response);
// echo "</pre>";
// echo $data['statusCode'];
