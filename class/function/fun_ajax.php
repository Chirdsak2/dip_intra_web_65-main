<?php
include("../lib/fun_query.php");

$type = conText($_POST["type"]);
$c_id = conText($_POST["c_id"]);
$query = new article($c_id);

if($type == "group"){
    $data = $query->getAricleGroup();
    $status = "success";
}elseif($type == "s_group"){
    $data = $query->getAricleSubGroup();
    $status = "success";
}else{
    $data = [];
    $status = "error";
}

$array_list = array(
    "data" => $data,
    "status" => $status
);

echo json_encode($array_list);

