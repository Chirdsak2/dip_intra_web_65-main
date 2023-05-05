<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE db_moc_tor");
if($_POST["flag"]=='sent_data'){
$day = date("Y-m-d");
$time = date("H:i:s");
$db->query("insert into tor_comment (t_id,tc_name,tc_detail,tc_date,tc_time) value ('".$_POST["tid"]."','".htmlspecialchars (addslashes  ($_POST["tdname"]))."','".htmlspecialchars (addslashes  ($_POST["tddetail"]))."','$day','$time')");
	?>
	<script language="javascript" type="text/javascript">
		 				alert('บันทึกข้อมูลเรียบร้อย'); 
		 				self.location.href='tor_news.php?tid=<?php echo $_POST["tgid"];?>';
		 </script>
	<?php
	exit;
}
$db->query("USE ".$EWT_DB_NAME);
$db->db_close(); 
?>