<?php
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

	$db->query("UPDATE vdo_list SET vdo_count = vdo_count+1 WHERE vdo_id = '".$_GET["v"]."' ");

$db->db_close(); ?>