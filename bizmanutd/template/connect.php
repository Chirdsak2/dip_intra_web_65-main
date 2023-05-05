<?php
	$db=new PHPDB($EWT_DB_TYPE,$EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD,"ewt_user");
	$connectdb=$db->CONNECT_SERVER();
	
// check cookie

if($_SESSION["EWT_MID"] == ""){
	if($_COOKIE["EWT_COOKIE_LP"] != ""){
			$dec = base64_decode($_COOKIE["EWT_COOKIE_LP"]);	
			$decr = explode("ewtmy",$_COOKIE["EWT_COOKIE_LP"]);
			if(trim($decr[3]) != "" ){
					$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user_id = '".trim($decr[3])."'   ");
		$row = $db->db_num_rows($sql_login);
				if($row > 0){
		$M = $db->db_fetch_array($sql_login);
		session_register("EWT_MID");
		session_register("EWT_NAME");
		session_register("EWT_UNAME");
		session_register("EWT_LEVEL");
		session_register("EWT_IMG");
		session_register("EWT_MAIL");
		$_SESSION["EWT_MID"] = $M["gen_user_id"];
		$_SESSION["EWT_UNAME"] = $M["gen_user"];
		$_SESSION["EWT_NAME"] = $M["name_thai"]." ".$M["surname_thai"];
		$_SESSION["EWT_LEVEL"] = $M["level_id"];
		$_SESSION["EWT_TYPE_ID"] = $M["emp_type_id"];
		$_SESSION["EWT_IMG"] = $M["path_image"];
		$_SESSION["EWT_MAIL"] = $M["email_person"];
		$_SESSION["EWT_FIGN"] = $M["fign"];
				}
			}
	}
}

//end check cookie

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
?>