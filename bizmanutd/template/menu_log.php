<?php
	header ("Content-Type:text/html;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

	//====================================================================
	if($mp_id){ $mp_id=checkPttVar($mp_id); }
	if($_GET["mp_id"]){ $_GET["mp_id"]=checkPttVar($_GET["mp_id"]); }
	if($_POST["mp_id"]){ $_POST["mp_id"]=checkPttVar($_POST["mp_id"]); }
	//=====================================================================
	

if($_SERVER["REMOTE_ADDR"]){
			$ip_address = $_SERVER["REMOTE_ADDR"];
}else{
			$ip_address = $_SERVER["REMOTE_HOST"];
}
$date_time=date('YmdHis');
$_SESSION[EWT_MID];

$db->query("INSERT INTO menu_log(ml_menu_id,ml_sub_id,ml_ip,ml_datetime,ml_member_id)
                           VALUES('$_GET[m_id]','$_GET[mp_id]','$ip_address','$date_time','$_SESSION[EWT_MID]') ");

$query=$db->query("SELECT Glink,Gtarget FROM menu_properties WHERE mp_id = '$_GET[mp_id]'");
$R=$db->db_fetch_array($query);
if($R["Gtarget"] == '_blank'){
?>
<script language="JavaScript">
location.href='<?php echo stripslashes($R[Glink]);?>';
</script>

<?php
}
$db->db_close(); ?>