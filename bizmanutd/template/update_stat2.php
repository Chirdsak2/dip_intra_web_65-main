<?php
//exit;
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

	$sql = $db->query("SELECT MIN(sv_id),sv_ip FROM stat_visitor GROUP BY sv_ip");
		while($R = $db->db_fetch_row($sql)){

		$db->query("UPDATE stat_visitor SET sv_new = 'Y' WHERE sv_id = '$R[0]'");
		echo "UPDATE stat_visitor SET sv_new = 'Y' WHERE sv_id = '$R[0]' <br>";

		}
		echo "Done";
 $db->db_close(); 
?>