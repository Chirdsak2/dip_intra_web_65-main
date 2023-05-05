<?php
/*include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");*/
include("../EWT_ADMIN/comtop_pop.php");
$db->query("USE ".$EWT_DB_USER);
$tid=$_GET['tid'];
$sql = $db->query("select url from user_info where EWT_User = '".$EWT_FOLDER_USER."'");
$R=$db->db_fetch_array($sql);
$url = $R[url];
$db->query("USE ".$EWT_DB_NAME);
echo "<title>Template Preview</title>";

$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";

//include($Path_true."/".$tid.".html");
		$fp = fopen ($Path_true."/".$tid.".html", 'rb');
		$ata = fread( $fp,  @filesize($Path_true."/".$tid.".html"));

	if(!eregi("href=\"http://",$ata)){
	$ata = str_replace('href="','href="'.$url,$ata);
	}
	echo $ata;

$db->db_close(); 
?>