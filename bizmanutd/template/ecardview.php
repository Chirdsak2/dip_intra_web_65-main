<?php
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

$sql="UPDATE  ecard_history SET  ech_status ='Y'  WHERE ech_id = '$_GET[hid]' AND  ech_to = '$_GET[fmail]'    ";
$db->query($sql);

$db->db_close(); 
?>