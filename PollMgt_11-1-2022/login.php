<?php
session_start();
include("config.php");
if($user == $username and $pass == $password){

session_register("adminlogin");

$adminlogin = "Y";

?>
<script language="javascript">
	window.location.href = "index.php?login=success";
</script>
	<?php
}else{
?>
<script language="javascript">
	window.location.href = "index.php?error=password";
</script>
	<?php
}
?>
