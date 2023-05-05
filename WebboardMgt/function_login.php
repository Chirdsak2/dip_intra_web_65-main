<?php
session_start();
include("inc.php");
include("lib/include.php");

if($Flag == "Login"){
$sql = $db->query("SELECT * FROM w_admin WHERE t_user = '$user' AND t_pass = '$pass'");
if(mysql_num_rows($sql)){
$R = mysql_fetch_array($sql);
session_register("LMS");
$LMS = "Y";
?>
<script language="JavaScript">
window.location.href = "index_cate.php";
</script>
	<?php
}else{
?>
<script language="JavaScript">
	alert("รหัสผ่านไม่ถูกต้อง");
window.location.href = "index.php";
</script>
	<?php
}
}
if($Flag == "Logout"){
session_unset();
session_destroy();

?>
<script language="JavaScript">
window.location.href = "login.php";
</script>
	<?php } ?>
