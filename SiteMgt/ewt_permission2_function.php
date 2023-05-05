<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql_leader = $db->query("INSERT INTO permission_approve (UID,myFlag,f_from,f_date,f_time,t_set,t_to,t_date,t_time,t_status) VALUES ('".$_SESSION["EWT_SUID"]."','".$_POST["myFlag"]."','".$_SESSION["EWT_SMID"]."','".date("Y-m-d")."','".date("H:i:s")."','".$_POST["t_set"]."','".$_POST["t_to"]."','0000-00-00','00:00:00','W')");

				$sql_user = $db->query("SELECT name_thai,surname_thai FROM gen_user  WHERE gen_user_id = '".$_POST["t_set"]."' ");
				$U = $db->db_fetch_row($sql_user);
				$sql_leader = $db->query("SELECT name_thai,surname_thai FROM gen_user  WHERE gen_user_id = '".$_POST["t_to"]."' ");
				$L = $db->db_fetch_row($sql_leader);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript">
		alert("ระบบทำการส่งข้อมูลกำหนดสิทธิ์ของ <?php echo $U[0]." ".$U[1]; ?> \nเพื่อให้ <?php echo $L[0]." ".$L[1]; ?> พิจารณาแล้ว");
		self.location.href = "ewt_permission0.php";
</script>
</head>
</html>
<?php

$db->db_close(); ?>
