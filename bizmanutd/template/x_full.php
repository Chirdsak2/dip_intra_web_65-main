<?php
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
$sql = $db->query("USE datawarehouse");
	$sql = $db->query("SELECT ascii(attach_fulltext) FROM attach_file WHERE attach_file_id = '979' OR attach_file_id = '3175' ");
		while($R = $db->db_fetch_row($sql)){

		echo "x".$R[0]."x<br>";
		}
 $db->db_close(); 
?>