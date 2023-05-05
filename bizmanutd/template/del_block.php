<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

exit;
$sql_index = $db->query("SELECT block.BID FROM block LEFT JOIN block_function ON block.BID = block_function.BID WHERE block_function.BFID IS NULL");
while($F = $db->db_fetch_row($sql_index)){
	echo $F[0]."<br>";
$db->query("DELETE FROM block_text WHERE BID = '$F[0]' ");
$db->query("DELETE FROM block WHERE BID = '$F[0]' ");
}
echo "Finish<br>";
$db->db_close(); ?>
