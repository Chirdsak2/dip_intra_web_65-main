<?php 
DEFINE('path', 'assets/');
include path . 'config/config.inc.php';

$token = $_REQUEST["token"];
$key = $_REQUEST["key"];

$result = $sso->decrypt($token, "prd_authen", "hnqbioi7l0r7lrhjpfltv6tlq3");
$key_decrypt = $sso->decrypt($key,"hnqbioi7l0r7lrhjpfltv6tlq3","80702A9E-DF4C-B707-5741-16325FA0C8F0-biz-777-888-999-prd");

$array_list = array();
if($key_decrypt == "eHVZbVdOdFpSVnNIbFNzcHVVN09mdz09"){
    $array_list["data"] = $result;
    $array_list["status"] = "success";
    $array_list["message"] = "เรียกข้อมูลสำเร็จ";
}else{
    $array_list["data"] = null;
    $array_list["status"] = "error";
    $array_list["message"] = "ข้อมูลผิดพลาด";
}

echo json_encode($array_list);
exit;

