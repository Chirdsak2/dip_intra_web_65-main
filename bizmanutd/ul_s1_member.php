<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
if($_POST["Flag"] == "Add"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
		$uid = $_POST["uid".$i];
		if($chk == "Y"){
		$sqlchk = $db->query("SELECT COUNT(under_id) FROM leader_list WHERE leader_id = '".$_POST["G"]."' AND under_id = '".$uid."'  ");
 		 $C = $db->db_fetch_row($sqlchk);
		 		if($C[0] == 0){
						$db->query("INSERT INTO leader_list (leader_id,under_id) VALUES ('".$_POST["G"]."','".$uid."') ");
				}
		}else{
				$sqlchk = $db->query("DELETE FROM leader_list WHERE leader_id = '".$_POST["G"]."' AND under_id = '".$uid."'  ");
		}
	}
	?>
	<script language="JavaScript">
	window.opener.member_list.location.reload();
	self.close();
	</script>
	<?php
	
}else{
	$run = "SELECT * FROM gen_user INNER JOIN org_name ON org_name.org_id = gen_user.org_id "; 
	$run .=  "WHERE gen_user.gen_user_id <> '".$_POST[G]."'";
	if($_POST["search_title"] == '0'){
		if($_POST["fname"] != ""){
			$run .= " AND gen_user.name_thai LIKE '%".$_POST["fname"]."%' OR gen_user.surname_thai LIKE '%".$_POST["fname"]."%' ";
		}
	}else{
		if($_POST["org_id"] != ""){
		//$run .= " WHERE gen_user.org_id LIKE '".$_POST["org_id"]."' ";
		$run.=" AND (org_name.name_org  LIKE  '%".$org_id."%')  ";
		}
	}
	
	$run .= " ORDER BY gen_user.gen_user_id";
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
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC"><form name="form1" method="post" target="_top" action="ul_s1_member.php">
  <tr align="center" bgcolor="E0DFE3"> 
    <td width="50%" class="head_table">ชื่อ - สกุล <input name="G" type="hidden" id="G" value="<?php echo $_POST["G"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Add"></td>
    <td class="head_table">หน่วยงาน</td>
  </tr>
  <?php
  if($rows > 0){
  $i = 0;
  while($U = $db->db_fetch_array($sql)){
  $sqlchk = $db->query("SELECT COUNT(under_id) FROM leader_list WHERE leader_id = '".$_POST["G"]."' AND under_id = '".$U["gen_user_id"]."' ");
  $C = $db->db_fetch_row($sqlchk);

  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><input type="checkbox" name="chk<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?>>
        <img src="../images/user_logo.gif" width="20" height="20" border="0" align="absmiddle"> 
        <?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?> <input name="uid<?php echo $i; ?>" type="hidden" value="<?php echo $U["gen_user_id"]; ?>"> 
      </td>
    <td><?php echo $U["name_org"]; ?></td>
  </tr>
  <?php $i++; }}else{ ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td height="40" colspan="2"><font color="#FF0000">ไม่มีรายชื่อสมาชิก</font></td>
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
