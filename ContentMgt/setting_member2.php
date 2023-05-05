<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql1 = $db->query("SELECT * FROM user_group WHERE ug_id = '".$_GET["ug"]."' ");
$G = $db->db_fetch_array($sql1);
	function level_name($L,$id){
	global $db;
		if($L == "D"){
			echo "<img src=\"../images/user_group.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_org FROM org_name WHERE org_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "L"){
			echo "<img src=\"../images/user_c.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT ul_name FROM user_level WHERE ul_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "P"){
			echo "<img src=\"../images/user_pos.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT position_name.pos_name FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.up_id = '".$id."'  ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "U"){
			echo "<img src=\"../images/user_logo.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_thai,surname_thai FROM gen_user WHERE gen_user_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0]." ".$R[1];
		}
	}
	
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
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC"><form name="form1" method="post" action="setting_member2_function.php">
  <tr align="center" bgcolor="E0DFE3"> 
      <td class="head_table">Group or user name
        <input name="s_type" type="hidden" value="<?php echo $_GET["s_type"]; ?>"><input name="s_id" type="hidden" id="s_id" value="<?php echo $_GET["s_id"]; ?>"><input name="s_name" type="hidden" id="s_name" value="<?php echo $_GET["s_name"]; ?>">
        <input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Add"><input name="plan" type="hidden" value=""></td>
      <td width="10%" class="head_table"> Read</td>
      <td width="10%" class="head_table"> Write</td>
  </tr>
  <tr bgcolor="#F7F7F7"> 
      <td bgcolor="#EEEEEE"> <strong><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> 
        <?php echo $G[1]; ?> 
        <input name="p_type0" type="hidden" value="A">
        <input type="hidden" name="pu_id0" value="<?php echo $_GET["ug"]; ?>">
        </strong></td>
    <td align="center" bgcolor="#E7E7E7"><?php $db->query("USE ".$_SESSION["EWT_SDB"]); ?>
		<?php
					if($_GET["s_type"] == "Fo"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND s_type = 'Fo'  AND s_id = '".$_GET["s_id"]."'  AND s_permission = 'r' ");
				}
				if($_GET["s_type"] == "Fi"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND s_type = 'Fi'  AND s_name = '".$_GET["s_name"]."'  AND s_permission = 'r' ");
				}
 					$GR = $db->db_fetch_row($sqlchk);
	?>
      <input name="chr0" type="checkbox" value="Y" onClick="chk(this,'chr');" <?php if($GR[0] > 0){ echo "checked"; } ?>>
        </td>
				<?php
					if($_GET["s_type"] == "Fo"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND s_type = 'Fo'  AND s_id = '".$_GET["s_id"]."'  AND s_permission = 'w' ");
				}
				if($_GET["s_type"] == "Fi"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND s_type = 'Fi'  AND s_name = '".$_GET["s_name"]."'  AND s_permission = 'w' ");
				}
 					$GW = $db->db_fetch_row($sqlchk);
	?>
    <td align="center" bgcolor="#EEEEEE"><input name="chw0" type="checkbox" value="Y" onClick="chk(this,'chw');" <?php if($GW[0] > 0){ echo "checked"; } ?>></td>
	<?php $db->query("USE ".$EWT_DB_USER); ?>
  </tr>
  <?php
  $sql = $db->query("SELECT * FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' ORDER BY ugm_type ASC");
  $i = 1;
 if($db->db_num_rows($sql) > 0){
  while($U = $db->db_fetch_array($sql)){
  ?>
  <tr bgcolor="#FFFFFF"> 
      <td> 
        <?php level_name($U["ugm_type"],$U["ugm_tid"]); ?>
		<input name="p_type<?php echo $i; ?>" type="hidden" value="<?php echo $U["ugm_type"]; ?>">
        <input name="pu_id<?php echo $i; ?>" type="hidden" value="<?php echo $U["ugm_tid"]; ?>">
      </td>
    <td align="center" bgcolor="#F7F7F7"><?php $db->query("USE ".$_SESSION["EWT_SDB"]); ?>
	<?php
					if($_GET["s_type"] == "Fo"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND s_type = 'Fo'  AND s_id = '".$_GET["s_id"]."'  AND s_permission = 'r' ");
				}
				if($_GET["s_type"] == "Fi"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND s_type = 'Fi'  AND s_name = '".$_GET["s_name"]."'  AND s_permission = 'r' ");
				}
 					$C = $db->db_fetch_row($sqlchk);
	?>
      <input name="chr<?php echo $i; ?>" type="checkbox" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?> <?php if($GR[0] > 0){ echo "disabled"; } ?> ></td>
	  	<?php
					if($_GET["s_type"] == "Fo"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND s_type = 'Fo'  AND s_id = '".$_GET["s_id"]."'  AND s_permission = 'w' ");
				}
				if($_GET["s_type"] == "Fi"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND s_type = 'Fi'  AND s_name = '".$_GET["s_name"]."'  AND s_permission = 'w' ");
				}
 					$C = $db->db_fetch_row($sqlchk);
	?>
    <td align="center"><input name="chw<?php echo $i; ?>" type="checkbox" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?> <?php if($GW[0] > 0){ echo "disabled"; } ?>></td>
  </tr><?php $db->query("USE ".$EWT_DB_USER); ?>
  <?php
  
  $i++;
  }
  }  ?><input name="allrow" type="hidden" id="allrow" value="<?php echo $i; ?>"></form>
</table>
<script language="JavaScript">
function chk(c,d){
var e = document.form1.allrow.value;
if(c.checked == true){
		for(i=1;i<e;i++){
		document.form1.elements[d+i].disabled = true;
		}
}else{
		for(i=1;i<e;i++){
		document.form1.elements[d+i].disabled = false;
		}
}
}
top.document.all.Buttonxo.disabled = false;
top.document.all.Buttonxa.disabled = false;
</script>
</body>
</html>
<?php $db->db_close(); ?>
