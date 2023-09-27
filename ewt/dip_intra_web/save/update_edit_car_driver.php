<?php
header('Content-Type: text/html; charset=utf-8');
include('../callservice.php');

	
 $getUpdateEditCarDriver = callAPI('getUpdateEditCarDriver', $_POST);
//  echo "1"; 

?>