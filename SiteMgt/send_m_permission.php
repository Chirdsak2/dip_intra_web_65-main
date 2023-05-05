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
		$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$uid."' ");
 		 $C = $db->db_fetch_row($sqlchk);
		 		if($C[0] == 0){
						$db->query("INSERT INTO web_group_member (ug_id,ugm_type,ugm_tid) VALUES ('".$_POST["ug"]."','U','".$uid."') ");
				}
		}else{
				$sqlchk = $db->query("DELETE FROM web_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$uid."' ");
				$sqlchk = $db->query("DELETE FROM permission WHERE UID = '".$_POST["ug"]."' AND p_type = 'U' AND pu_id = '".$uid."' ");
		}
	}
	?>
	<script language="JavaScript">
	window.opener.p_user_list.location.reload();
	self.close();
	</script>
	<?php
	
}else{

	$run = "SELECT * FROM gen_user INNER JOIN org_name ON org_name.org_id = gen_user.org_id "; 
		if($_POST["fname"] != ""){
			$run .= " WHERE gen_user.name_thai LIKE '%".$_POST["fname"]."%' OR gen_user.surname_thai LIKE '%".$_POST["fname"]."%' ";
		}else{
		if($_POST["org_id"] != ""){
		//$run .= " WHERE gen_user.org_id LIKE '".$_POST["org_id"]."' ";
		$run.=" WHERE (org_name.name_org  LIKE  '%".$org_id."%')  ";
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
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
  <form name="form1" method="post" target="_top" action="ewt_s1_member.php">
    <tr align="center" bgcolor="E0DFE3"> 
      <td width="48%" class="head_table">ชื่อ - สกุล 
        <input name="ug" type="hidden" id="ug" value="<?php echo $_POST["ug"]; ?>"> 
        <input name="Flag" type="hidden" id="Flag" value="Add"></td>
      <td width="30%" class="head_table">หน่วยงาน</td>
      <td width="22%" class="head_table">หัวหน้า</td>
    </tr>
    <?php
  if($rows > 0){
  $i = 0;
  while($U = $db->db_fetch_array($sql)){
  $sqlchk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$U["gen_user_id"]."' ");
  $C = $db->db_fetch_row($sqlchk);
  $sql_lead = $db->query("SELECT gen_user.name_thai,gen_user.surname_thai,leader_list.leader_id FROM gen_user INNER JOIN leader_list ON gen_user.gen_user_id = leader_list.leader_id WHERE leader_list.under_id = '".$U["gen_user_id"]."' ");
  $rows_lead = $db->db_num_rows($sql_lead);
  $Lname = "";
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td> <input type="button" name="Button" value="เลือก" onClick="self.parent.location.href='ewt_permission2.php?gid=<?php echo $U["gen_user_id"]; ?>';" <?php if($rows_lead == 0 ){ 
	  echo "disabled";
	  $Lname = "-";
	   }else{
	   $L = $db->db_fetch_row($sql_lead);
	   $Lname = $L[0]." ".$L[1];
	   		if($L[2] == $_SESSION["EWT_SMID"] OR $U["gen_user_id"] == $_SESSION["EWT_SMID"] ){
	   echo "disabled";
		   }
	   } ?>> 
        <img src="../images/user_logo.gif" width="20" height="20" border="0" align="absmiddle"> 
        <?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?> </td>
      <td><?php echo $U["name_org"]; ?></td>
      <td><?php echo $Lname; ?></td>
    </tr>
    <?php $i++; }}else{ ?>
    <tr align="center" bgcolor="#FFFFFF"> 
      <td height="40" colspan="3"><font color="#FF0000">ไม่มีรายชื่อสมาชิก</font></td>
    </tr>
    <?php } ?>
    <input name="alli" type="hidden" value="<?php echo $i; ?>">
  </form>
</table>
</body>
</html>
<?php
}
$db->db_close();
?>
