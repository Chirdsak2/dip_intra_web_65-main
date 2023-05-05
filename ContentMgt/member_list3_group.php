<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

 //$db->query("use  db_56_dmr_web");
 $db->query("USE ".$EWT_DB_USER);
 
if($_POST["Flag"] == "Add"){
   /*  $db->query("use  db_56_dmr_web");
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
		$uid = $_POST["uid".$i];
		if($chk == "Y"){
		//$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$uid."' ");
		 $sqlchk = $db->query("SELECT COUNT(sg_mid) FROM p_survey_group WHERE s_id = '".$_POST["ug"]."'  AND sg_mid = '$uid' ");
 		 $C = $db->db_fetch_row($sqlchk);
		 		if($C[0] == 0){
						//$db->query("INSERT INTO user_group_member (ug_id,ugm_type,ugm_tid) VALUES ('".$_POST["ug"]."','U','".$uid."') ");
						$db->query("INSERT INTO p_survey_group (s_id,sg_mid,sg_oid) VALUES ('".$_POST["ug"]."','$uid','') ");
				}
		}else{
				$sqlchk = $db->query("DELETE FROM p_survey_group WHERE s_id = '".$_POST["ug"]."' AND sg_mid = '$uid' AND sg_oid = '' ");
		}
	}
	?>
	<script language="JavaScript">
	//window.opener.member_list.location.reload();
	self.close();
	</script>
	<?php
	 $db->query("USE ".$EWT_DB_USER);*/
}else{
	$run = "SELECT * FROM user_group  "; 
		if($_POST["fname"] != ""){
			$run .= " WHERE user_group.ug_name LIKE '%".$_POST["fname"]."%' ";
		}
	$run .= " ORDER BY user_group.ug_id";
		$sql = $db->query($run);
		$rows = $db->db_num_rows($sql);
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
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC"><form name="form1" method="post" target="_top" action="member_list1_user.php" >
  <tr align="center" bgcolor="E0DFE3"> 
    <td width="50%" class="head_table">กลุ่มสิทธิ์
      <input name="ug" type="hidden" id="ug" value="<?php echo $_POST["ug"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Add"></td>
    <td class="head_table">&nbsp;</td>
  </tr>
  <?php
  if($rows > 0){
  $i = 0;
  while($U = $db->db_fetch_array($sql)){
  $explo_id = explode(',',$id2);
	$chk_id = '';
	for($x=0;$x<count($explo_id);$x++){
		if($U[ug_id] == $explo_id[$x]){
		$chk_id2= "checked";
		break;
		}
	}
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><input type="checkbox" name="chk<?php echo $i; ?>" value="Y" <?php echo $chk_id2; ?>>
        <img src="../images/user_pos.gif" width="20" height="20" border="0" align="absmiddle"> 
        <?php echo $U["ug_name"]; ?>  <input name="uid<?php echo $i; ?>" type="hidden" value="<?php echo $U["ug_id"]; ?>"> <input name="uname<?php echo $i; ?>" type="hidden" value="<?php echo $U["ug_name"]; ?> ">
      </td>
    <td>&nbsp;</td>
  </tr>
  <?php $i++; }}else{ ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td height="40" colspan="2"><font color="#FF0000">ไม่มีรายการกลุ่มสิทธิ์</font></td>
  </tr>
  <?php } ?><input name="alli" type="hidden" value="<?php echo $i; ?>"></form>
</table>
</body>
</html>
<script language="JavaScript">
<?php if($rows > 0){ ?>
top.document.all.btapply.disabled = false;
<?php }else{ ?>
top.document.all.btapply.disabled = true;
<?php } ?>
</script>
<?php
}
$db->db_close();
?>
