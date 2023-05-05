<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
if($_POST["Flag"] == "Set"){
			for($i=0;$i<$_POST["alli"];$i++){
		$suser = $_POST["suser".$i];
		$cmsw = $_POST["cmsw".$i];
		$cmsa = $_POST["cmsa".$i];
		$artw = $_POST["artw".$i];
		$arta = $_POST["arta".$i];
		$p_type = $_POST["p_type".$i];
		$pu_id = $_POST["pu_id".$i];
		
			if($suser == "Y" OR $_POST["suser0"] == "Y"){
				$sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'suser' ");
	 			$C = $db->db_fetch_row($sql_p);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission (p_type,pu_id,UID,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','".$_POST["UID"]."','suser','','','') ");
					}
			}else{
			$db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'suser' ");
			}
			
			if($cmsw == "Y" OR $_POST["cmsw0"] == "Y"){
				$sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'cms' AND s_permission = 'w' ");
	 			$C = $db->db_fetch_row($sql_p);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission (p_type,pu_id,UID,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','".$_POST["UID"]."','cms','','','w') ");
					}
			}else{
			$db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'cms' AND s_permission = 'w' ");
			}
			
			if($cmsa == "Y" OR $_POST["cmsa0"] == "Y"){
				$sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'cms' AND s_permission = 'a' ");
	 			$C = $db->db_fetch_row($sql_p);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission (p_type,pu_id,UID,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','".$_POST["UID"]."','cms','','','a') ");
					}
			}else{
			$db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'cms' AND s_permission = 'a' ");
			}
			
				if($artw == "Y" OR $_POST["artw0"] == "Y"){
				$sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'art' AND s_permission = 'w' ");
	 			$C = $db->db_fetch_row($sql_p);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission (p_type,pu_id,UID,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','".$_POST["UID"]."','art','','','w') ");
					}
			}else{
			$db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'art' AND s_permission = 'w' ");
			}
			
			if($arta == "Y" OR $_POST["arta0"] == "Y"){
				$sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'art' AND s_permission = 'a' ");
	 			$C = $db->db_fetch_row($sql_p);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission (p_type,pu_id,UID,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','".$_POST["UID"]."','art','','','a') ");
					}
			}else{
			$db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND UID = '".$_POST["UID"]."' AND s_type = 'art' AND s_permission = 'a' ");
			}
			
			
			}
		?>
		<script language="JavaScript">
		self.location.href = "site_g_permission.php?ug=<?php echo $_POST["ug"]; ?>&UID=<?php echo $_POST["UID"]; ?>";
		</script>
		<?php
		exit;
}

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
			$sql = $db->query("SELECT position_name.pos_name FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.up_id = '".$id."' ORDER BY user_position.up_rank ASC ");
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

	$sql = $db->query("SELECT * FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' ORDER BY ugm_type ASC");
	$sql_g = $db->query("SELECT * FROM user_group WHERE ug_id = '".$_GET["ug"]."'  ");
	$G = $db->db_fetch_array($sql_g);
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
<script language="JavaScript">
function chuid(c){
self.location.href='site_g_permission.php?ug=<?php echo $_GET["ug"]; ?>&UID=' + c;
}
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
  <form name="form1" method="post" action="site_g_permission.php">
  <?php 
  $sql1 = $db->query("SELECT * FROM user_info WHERE EWT_Status = 'Y' ");
  ?>
    <tr bgcolor="E0DFE3"> 
      <td height="40" colspan="6">WebSite : 
        <select name="UID" onChange="chuid(this.value)">
          <option value="">Select Site User</option>
		  <?php while($U=$db->db_fetch_array($sql1)){ ?>
		   <option value="<?php echo $U[UID]; ?>" <?php if($U[UID] == $_GET[UID]){ echo "selected"; } ?>><?php echo $U[EWT_User]; ?></option>
		   <?php } ?>
        </select> </td>
    </tr>
	<?php if($_GET["UID"] != ""){ ?>
    <tr bgcolor="E0DFE3"> 
      <td rowspan="2" align="center" bgcolor="E0DFE3" class="head_table">Group or user name</td>
      <td width="5%" rowspan="2" align="center" class="head_table">บ.ก.<br>
        SuperUser </td>
		<!--
      <td colspan="2" align="center" class="head_table">Content</td>
      <td colspan="2" align="center" class="head_table">Article</td> -->
    </tr>
    <tr bgcolor="E0DFE3"> <!--
      <td width="5%" align="center" class="head_table">Manage</td>
      <td width="5%" align="center" class="head_table">Approve</td>
      <td width="5%" align="center" class="head_table">Manage</td>
      <td width="5%" align="center" class="head_table">Approve</td> -->
    </tr>
	<?php $i = 0; ?>
	<tr bgcolor="#E7E7E7"> 
      <td> 
        <strong><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> 
        <?php echo $G[1]; ?> 
		<input name="p_type<?php echo $i; ?>" type="hidden" value="A">
        <input name="pu_id<?php echo $i; ?>" type="hidden" value="<?php echo $_GET["ug"]; ?>">
      </strong></td>
	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'suser' ");
	  $C0 = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="suser<?php echo $i; ?>" value="Y" <?php if($C0[0] > 0){ echo "checked"; } ?> onClick="chk(this,'suser');"></td><!--
	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'cms' AND s_permission = 'w' ");
	  $C1 = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="cmsw<?php echo $i; ?>" value="Y" <?php if($C1[0] > 0){ echo "checked"; } ?> onClick="chk(this,'cmsw');"></td>
	  	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'cms' AND s_permission = 'a' ");
	  $C2 = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="cmsa<?php echo $i; ?>" value="Y" <?php if($C2[0] > 0){ echo "checked"; } ?> onClick="chk(this,'cmsa');"></td>
	  	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'art' AND s_permission = 'w' ");
	  $C3 = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="artw<?php echo $i; ?>" value="Y" <?php if($C3[0] > 0){ echo "checked"; } ?> onClick="chk(this,'artw');"></td>
	  	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'art' AND s_permission = 'a' ");
	  $C4 = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="arta<?php echo $i; ?>" value="Y" <?php if($C4[0] > 0){ echo "checked"; } ?> onClick="chk(this,'arta');"></td> -->
    </tr>
    <?php
 if($db->db_num_rows($sql) > 0){
 $i=1;
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td> 
        <?php level_name($U["ugm_type"],$U["ugm_tid"]); ?>
		<input name="p_type<?php echo $i; ?>" type="hidden" value="<?php echo $U["ugm_type"]; ?>">
        <input name="pu_id<?php echo $i; ?>" type="hidden" value="<?php echo $U["ugm_tid"]; ?>">
      </td>
	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'suser' ");
	  $C = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="suser<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?> <?php if($C0[0] > 0){ echo "disabled"; } ?>></td> <!--
	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'cms' AND s_permission = 'w' ");
	  $C = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="cmsw<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?> <?php if($C1[0] > 0){ echo "disabled"; } ?>></td>
	  	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'cms' AND s_permission = 'a' ");
	  $C = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="cmsa<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?> <?php if($C2[0] > 0){ echo "disabled"; } ?>></td>
	  	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'art' AND s_permission = 'w' ");
	  $C = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="artw<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?> <?php if($C3[0] > 0){ echo "disabled"; } ?>></td>
	  	  <?php
	  $sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND UID = '".$_GET["UID"]."' AND s_type = 'art' AND s_permission = 'a' ");
	  $C = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center"><input type="checkbox" name="arta<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?> <?php if($C4[0] > 0){ echo "disabled"; } ?>></td> -->
    </tr>
    <?php 
	$i++;
  }
  ?>
    <tr bgcolor="E0DFE3"> 
      <td height="30" colspan="6" align="center" class="head_table"><input type="submit" name="Submit" value="Submit"> 
        <input type="reset" name="Submit2" value="Reset">
        <input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>">
        <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Set"></td>
    </tr>
 <?php }else{ ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="40" colspan="6" align="center"><font color="#FF0000">ไม่มีสมาชิกในกลุ่มนี้</font></td>
    </tr>
    <?php }} ?>
  </form>
</table>
<script language="JavaScript">
function chk(c,d){
var e = document.form1.alli.value;
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
</script>
</body>
</html>
<?php
$db->db_close();
?>
