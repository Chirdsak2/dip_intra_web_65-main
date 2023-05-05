<?php
session_start();

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
		$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$uid."' ");
 		 $C = $db->db_fetch_row($sqlchk);
		 		if($C[0] == 0){
						$db->query("INSERT INTO user_group_member (ug_id,ugm_type,ugm_tid) VALUES ('".$_POST["ug"]."','U','".$uid."') ");
				}
		}else{
				$sqlchk = $db->query("DELETE FROM user_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$uid."' ");
		}
	}
	?>
	<script language="JavaScript">
	window.opener.member_list.location.reload();
	self.close();
	</script>
	<?php
	
}else{
	$run = "SELECT * FROM gen_user INNER JOIN emp_type ON emp_type.emp_type_id = gen_user.emp_type_id "; 
		if($_POST["fname"] != ""){
			$run .= " WHERE gen_user.name_thai LIKE '%".$_POST["fname"]."%' OR gen_user.surname_thai LIKE '%".$_POST["fname"]."%' ";
		}
	$run .= " ORDER BY emp_type.emp_type_name ASC ,gen_user.gen_user_id ASC";
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
<script language="javascript1.2">
function sand_to_parent(n,s,g){
	/*top.window.opener.document.myForm.hdd_uid.value=g;
	top.window.opener.document.myForm.name.value=n +' '+s;
	top.window.opener.document.getElementById('tr1').style.display='none';
	top.window.opener.document.getElementById('tr2').style.display='none';
	top.window.opener.document.getElementById('tr3').style.display='none';
	top.close();*/
	top.window.opener.document.getElementById('hdd_uid').value=g;
	top.window.opener.document.getElementById('name').value=n +' '+s;
	top.close();
}
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC"><form name="form1" method="post" target="_top" action="site_s1_member.php">
  <tr align="center" bgcolor="E0DFE3"> 
    <td width="50%" class="head_table">ชื่อ - สกุล <input name="ug" type="hidden" id="ug" value="<?php echo $_POST["ug"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Add"></td>
    <td class="head_table">กลุ่มสมาชิก</td>
  </tr>
  <?php
  if($rows > 0){
  $i = 0;
  while($U = $db->db_fetch_array($sql)){

  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><a href="##" onClick="sand_to_parent('<?php echo $U["name_thai"]; ?>','<?php echo $U["surname_thai"]; ?>','<?php echo $U["gen_user_id"]; ?>');">เลือก</a><img src="../images/user_logo.gif" width="20" height="20" border="0" align="absmiddle"> 
        <?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?> <input name="uid<?php echo $i; ?>" type="hidden" value="<?php echo $U["gen_user_id"]; ?>"> 
      </td><td><?php echo $U["emp_type_name"]; ?></td>
  </tr>
  <?php $i++; }}else{ ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td height="40" colspan="2"><font color="#FF0000">ไม่มีรายชื่อสมาชิก</font></td>
  </tr>
  <?php } ?><input name="alli" type="hidden" value="<?php echo $i; ?>"></form>
</table>
</body>
</html>

<?php
}
$db->db_close();
?>
