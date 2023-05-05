
<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//print_r($_POST);

if(isset($_POST["proc"]) && $_POST["proc"] == "Delanswer")
{

	$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
	$CONF = $db->db_fetch_array($chk_config);
		$Request_type='A';
		//$wtid=$_POST['wtid'];
		$waid=$_POST['waid'];	
		$amsg=$_POST['del_comment'];
		//$aemail=$_POST['mail'];
		//$name=$_POST['name'];
		//$wc = $_POST['wc'];
		$tid = $_POST['tid'];
		$aid = $_POST['aid'];
		
		$sql_intsert_delanswer = "INSERT INTO `w_question_sts_request` (
											`t_id`,
											`a_id`,
											`request_createdate`,
											`request_lastdate`,
											`requestor_ip`,
											`request_reason`,
											`request_type`,
											`request_wid`,
											`request_email`
											) 
											VALUES ('".$tid."',
											'".$aid."',
											NOW( ),
											NOW( ),
											'".getIP()."',
											'".$amsg."',
											'".$Request_type."',
											'".$_SESSION['EWT_MID']."',
											'".$aemail."'
											)";									
																				

	$db->query($sql_intsert_delanswer);
	exit;
            
}

?>
