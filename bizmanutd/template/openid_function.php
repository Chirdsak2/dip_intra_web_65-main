<?php
session_start();
//session_destroy();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect_uncheck.php");
if($_POST["identifier"] != ""){

		$sql_login = $db->query("SELECT * FROM gen_user WHERE position_person = '".trim($_POST["identifier"])."' and status ='Y'");
		$row = $db->db_num_rows($sql_login);
		if($row > 0){
		$M = $db->db_fetch_array($sql_login);
			session_register("EWT_MID");
			session_register("EWT_ORG");
			session_register("EWT_NAME");
			session_register("EWT_LEVEL");
			session_register("EWT_IMG");
			session_register("EWT_MAIL");
			session_register("EWT_USERNAME");
			$_SESSION["EWT_MID"] = $M["gen_user_id"];
			$_SESSION["EWT_ORG"] = $M["org_id"];
			$_SESSION["EWT_NAME"] = $M["name_thai"]." ".$M["surname_thai"];
			$_SESSION["EWT_LEVEL"] = $M["level_id"];
			$_SESSION["EWT_TYPE_ID"] = $M["emp_type_id"];
			$_SESSION["EWT_IMG"] = $M["path_image"];
			$_SESSION["EWT_MAIL"] = $M["email_person"];
			$_SESSION["EWT_FIGN"] = $M["fign"];
			$_SESSION["EWT_USERNAME"] = $M["gen_user"];
			$db->query("update gen_user set name_thai='".$_POST["displayName"]."',email_person='".$_POST["verifiedEmail"]."' where position_person = '".trim($_POST["identifier"])."' and status ='Y'");
		}else{
		$db->query("insert into gen_user (name_thai,email_person,position_person,status,web_use) values ('".$_POST["displayName"]."','".$_POST["verifiedEmail"]."','".$_POST["identifier"]."','Y','".$_POST["providerName"]."')");
		
		$sql_login = $db->query("SELECT * FROM gen_user WHERE position_person = '".trim($_POST["identifier"])."' and status ='Y'");
		$M = $db->db_fetch_array($sql_login);
			session_register("EWT_MID");
			session_register("EWT_ORG");
			session_register("EWT_NAME");
			session_register("EWT_LEVEL");
			session_register("EWT_IMG");
			session_register("EWT_MAIL");
			session_register("EWT_USERNAME");
			$_SESSION["EWT_MID"] = $M["gen_user_id"];
			$_SESSION["EWT_ORG"] = $M["org_id"];
			$_SESSION["EWT_NAME"] = $M["name_thai"]." ".$M["surname_thai"];
			$_SESSION["EWT_LEVEL"] = $M["level_id"];
			$_SESSION["EWT_TYPE_ID"] = $M["emp_type_id"];
			$_SESSION["EWT_IMG"] = $M["path_image"];
			$_SESSION["EWT_MAIL"] = $M["email_person"];
			$_SESSION["EWT_FIGN"] = $M["fign"];
			$_SESSION["EWT_USERNAME"] = $M["gen_user"];
		}
				?>
									<script language="JavaScript">
									self.location.href = "index.php";
								</script>
							<?php
							exit;
}else{
//cese no use LDAP and no Username
				?>
		<script language="JavaScript">
			alert("You can't sign in now!!!");
			self.location.href = "main.php?filename=index";
		</script>
		<?php
		exit;
}
$db->db_close(); ?>
