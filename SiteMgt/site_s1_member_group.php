<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
function chk_header($hid,$uid){
global $db;
	//echo "SELECT COUNT(under_id) FROM leader_list WHERE leader_id = '".$hid."' AND under_id = '".$uid."' ";
	$sqlchk = $db->query("SELECT COUNT(under_id) FROM leader_list WHERE leader_id = '".$hid."' AND under_id = '".$uid."' ");
	 $C = $db->db_fetch_row($sqlchk);
	if($C[0]  > 0){
	return false;
	}else{
	return true;
	}
}

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
	$db->query("USE ".$EWT_DB_USER);
	$run = "SELECT * FROM gen_user INNER JOIN org_name ON org_name.org_id = gen_user.org_id "; 
		if($_POST["fname"] != ""){
			$run .= " WHERE gen_user.name_thai LIKE '%".$_POST["fname"]."%' OR gen_user.surname_thai LIKE '%".$_POST["fname"]."%' ";
		}
	$run .= "WHERE gen_user.gen_user_id = '".$_GET[G]."'";
	$run .= " ORDER BY gen_user.gen_user_id";
		$sql = $db->query($run);
		//$rows = $db->db_num_rows($sql);
		$rec = $db ->db_fetch_array($sql);
		$org_id = $rec[org_id];
		$orgid_total= substr($rec[parent_org_id], 0, 9);
	//file name user online
	$sql_user = "SELECT * FROM gen_user INNER JOIN org_name ON org_name.org_id = gen_user.org_id WHERE parent_org_id  like '$orgid_total%' and gen_user.gen_user_id <> '".$_GET[G]."'";
	$query_user = $db->query($sql_user);
	$rows = $db->db_num_rows($query_user);
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
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC"><form name="form1" method="post" target="_top" action="site_s1_member_group.php">
  <tr align="center" bgcolor="E0DFE3"> 
    <td width="50%" class="head_table">ชื่อ - สกุล <input name="G" type="hidden" id="G" value="<?php echo $_GET["G"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Add"></td>
    <td class="head_table">หน่วยงาน</td>
  </tr>
  <?php
  
  if($rows > 0){
  $i = 0;
  while($U = $db->db_fetch_array($query_user)){
  
   $sqlchk = $db->query("SELECT COUNT(under_id) FROM leader_list WHERE leader_id = '".$_GET["G"]."' AND under_id = '".$U["gen_user_id"]."' ");
  $C = $db->db_fetch_row($sqlchk);
  $disabled = '';
  //check 
  if(chk_header($U["gen_user_id"],$_GET["G"])==false){
  	$disabled = 'disabled';
  }else{
  	$disabled = '';
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><input type="checkbox" name="chk<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?> <?php echo $disabled;?>>
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
