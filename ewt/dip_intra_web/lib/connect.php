<?php
if($EWT_DB_NAME=="##db##") {
	echo "Not installed.";
	exit;
}else {
	$db= new PHPDB($EWT_DB_TYPE,$EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD,$EWT_DB_USER);
	$connectdb=$db->CONNECT_SERVER();
	//$db->query("SET NAMES 'utf8' ");
	
	$sql_p = $db->query("SELECT EWT_Permission FROM user_info WHERE EWT_User = '".$EWT_FOLDER_USER."' AND db_db = '".$EWT_DB_NAME."' ");
	$Pm = $db->db_fetch_array($sql_p);
		if($Pm["EWT_Permission"] == "Y" AND $_SESSION["EWT_MID"] == ""){
				?>
				<script language="javascript">
				self.location.href = "ewt_login.php";	
				</script>
				<?php
			exit();
		}
		$db->query("USE ".$EWT_DB_NAME);
}
?>