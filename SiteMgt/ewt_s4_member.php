<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST["Flag"] == "Add"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
		$uid = $_POST["uid".$i];
		if($chk == "Y"){
		$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'A' AND ugm_tid = '".$uid."' ");
 		 $C = $db->db_fetch_row($sqlchk);
		 		if($C[0] == 0){
						$db->query("INSERT INTO web_group_member (ug_id,ugm_type,ugm_tid) VALUES ('".$_POST["ug"]."','A','".$uid."') ");
				}
		}else{
				$sqlchk = $db->query("DELETE FROM web_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'A' AND ugm_tid = '".$uid."' ");
		}
	}
	?>
	<script language="JavaScript">
	window.opener.p_user_list.location.reload();
	self.close();
	</script>
	<?php
	
}else{
	$sql = $db->query("SELECT * FROM user_group ORDER BY ug_id ASC");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.head_table { 
	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
	}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC"><form name="form1" method="post" target="_top" action="ewt_s4_member.php">
<input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Add">
  <tr align="center" bgcolor="E0DFE3"> 
      <td width="50%" class="head_table">กลุ่มผู้ใช้งาน</td>
  </tr>
  <?php
  $i = 0;
while($U = $db->db_fetch_array($sql)){
$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE  ugm_type = 'A' AND ugm_tid = '".$U["ug_id"]."' ");
  $C = $db->db_fetch_row($sqlchk);
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><input type="checkbox" name="chk<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?>> <img src="../images/user_a.gif" width="20" height="20" border="0" align="absmiddle"> 
    <?php echo $U["ug_name"]; ?> <input name="uid<?php echo $i; ?>" type="hidden" value="<?php echo $U["ug_id"]; ?>"></td>
  </tr>
  <?php $i++; } ?><input name="alli" type="hidden" value="<?php echo $i; ?>"></form>
</table>
</body>
</html>
<?php
}
$db->db_close();
?>
