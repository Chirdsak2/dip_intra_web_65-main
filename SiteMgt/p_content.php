<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($_POST["Flag"] == "Set"){
			for($i=0;$i<$_POST["alli"];$i++){
		$cmsw = $_POST["cmsw".$i];
		$cmsa = $_POST["cmsa".$i];
		$p_type = $_POST["p_type".$i];
		$pu_id = $_POST["pu_id".$i];
			
			if($cmsw == "Y"){
				$sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'cms' AND s_permission = 'w' ");
	 			$C = $db->db_fetch_row($sql_p);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission (p_type,pu_id,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','cms','','','w') ");
					}
			}else{
			$db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'cms' AND s_permission = 'w' ");
			}
			
			if($cmsa == "Y"){
				$sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'cms' AND s_permission = 'a' ");
	 			$C = $db->db_fetch_row($sql_p);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission (p_type,pu_id,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','cms','','','a') ");
					}
			}else{
			$db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'cms' AND s_permission = 'a' ");
			}
			
			for($x=0;$x<$_POST["allx"];$x++){
				$guse = $_POST["chkx".$x."y".$i];
				$gid = $_POST["grx".$x."y".$i];
				
			if($guse == "Y"){
				$sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fo' AND s_id = '$gid' ");
	 			$C = $db->db_fetch_row($sql_p);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission (p_type,pu_id,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','Fo','$gid','','') ");
					}
			}else{
			$db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fo' AND s_id = '$gid' ");
			}
			}
			
			}
		?>
		<script language="JavaScript">
		self.location.href = "p_content.php";
		</script>
		<?php
		exit;
}

	function level_name($L,$id){
	global $db,$EWT_DB_USER;
		if($L == "A"){
			echo "<img src=\"../images/user_a.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query_db("SELECT ug_name FROM user_group WHERE ug_id = '".$id."' ",$EWT_DB_USER);
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "D"){
			echo "<img src=\"../images/user_group.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query_db("SELECT name_org FROM org_name WHERE org_id = '".$id."' ",$EWT_DB_USER);
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "L"){
			echo "<img src=\"../images/user_c.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query_db("SELECT ul_name FROM user_level WHERE ul_id = '".$id."' ",$EWT_DB_USER);
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "P"){
			echo "<img src=\"../images/user_pos.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query_db("SELECT position_name.pos_name FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.up_id = '".$id."' ORDER BY user_position.up_rank ASC ",$EWT_DB_USER);
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "U"){
			echo "<img src=\"../images/user_logo.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query_db("SELECT name_thai,surname_thai FROM gen_user WHERE gen_user_id = '".$id."' ",$EWT_DB_USER);
			$R = $db->db_fetch_row($sql);
			echo $R[0]." ".$R[1];
		}
	}

	$sql = $db->query("SELECT * FROM web_group_member  ORDER BY ugm_type ASC");

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

<body><form name="form1" method="post" action="p_content.php">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="E0DFE3"> 
      <td rowspan="2" align="center" bgcolor="E0DFE3" class="head_table">Group 
        or user name</td>
      <td width="5%" rowspan="2" align="center" class="head_table">Manage</td>
      <td width="5%" rowspan="2" align="center" class="head_table">Approve</td>
	  <?php
	    $sql_group = $db->query("SELECT * FROM temp_main_group WHERE length(Main_Position) = 9 ORDER BY Main_Position ASC ");
		$rows = $db->db_num_rows($sql_group);
	  ?>
      <td colspan="<?php echo $rows; ?>" align="center" class="head_table">Folder permission</td>
    </tr>
    <tr bgcolor="E0DFE3"> 
      <?php 
	  $k=0;
	  $gid = array();
	  while($GR = $db->db_fetch_array($sql_group)){
	  $gid[$k] = $GR["Main_Group_ID"];
	   ?>
      <td width="5%" align="center" class="head_table"><?php echo $GR["Main_Group_Name"]; ?></td>
      <?php $k++; }  ?>
    </tr>
    <?php $i = 0; ?>
    <?php
 $i=0;
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td> 
        <?php level_name($U["ugm_type"],$U["ugm_tid"]); ?>
        <input name="p_type<?php echo $i; ?>" type="hidden" value="<?php echo $U["ugm_type"]; ?>"> 
        <input name="pu_id<?php echo $i; ?>" type="hidden" value="<?php echo $U["ugm_tid"]; ?>"> 
      </td>
      <?php
	  $sql_p = $db->query_db("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND s_type = 'cms' AND s_permission = 'w' ",$_SESSION["EWT_SDB"]);
	  $C = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center" bgcolor="#E7E7E7"><input type="checkbox" name="cmsw<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?>></td>
	  <?php
	  $sql_p = $db->query_db("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND s_type = 'cms' AND s_permission = 'a' ",$_SESSION["EWT_SDB"]);
	  $C = $db->db_fetch_row($sql_p);
	  ?>
      <td align="center" bgcolor="#E7E7E7"><input type="checkbox" name="cmsa<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?>></td>
	  <?php for($x=0;$x<$rows;$x++){ 
	  $sql_p = $db->query_db("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$U["ugm_type"]."' AND pu_id = '".$U["ugm_tid"]."' AND s_type = 'Fo' AND s_id = '$gid[$x]' ",$_SESSION["EWT_SDB"]);
	  $C = $db->db_fetch_row($sql_p);
	  ?>
      <td   align="center"><input type="checkbox" name="chkx<?php echo $x; ?>y<?php echo $i; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?>>
        <input type="hidden" name="grx<?php echo $x; ?>y<?php echo $i; ?>" value="<?php echo $gid[$x]; ?>"></td>
	  <?php } ?>
    </tr>
    <?php 
	$i++;
  }
  ?></tr>
  </table>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="E0DFE3"> 
      <td height="30" colspan="5" align="center" class="head_table"><input type="submit" name="Submit" value="Submit"> 
        <input type="reset" name="Submit2" value="Reset"> <input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>"> 
        <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>"> 
		<input name="allx" type="hidden" id="allx" value="<?php echo $rows; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Set"></td>
    </tr>
	</table></form>
</body>
</html>
<?php
$db->db_close();
?>
