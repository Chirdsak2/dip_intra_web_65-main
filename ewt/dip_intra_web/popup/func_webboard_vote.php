<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if(isset($_POST["proc"]) && $_POST["proc"] == "vote")
{
		$tid = $_POST['tid'];
		$aid = $_POST['aid'];

		$sql_intsert_vote = "INSERT INTO `w_vote` (
											`a_id`,
											`vote_choice`,
											`vote_date`,
											`vote_ip`,
											`vote_status`
											) 
											VALUES (
											'".$aid."',
											'".$_POST["vote"]."',
											NOW( ),
											'".getIP()."',
											'Y'
											)";									
																				
	$db->query($sql_intsert_vote);

}

exit;
	


?>
