<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
if($_GET["Flag"] == "Del"){
			$db->query("DELETE FROM user_group_member WHERE ugm_id = '".$_GET["ugm_id"]."'");
		?>
		<script language="JavaScript">
		self.location.href = "site_member.php?ug=<?php echo $_GET["ug"]; ?>";
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
  <tr align="center" bgcolor="E0DFE3"> 
    <td class="head_table">Group or user name</td>
    <td width="10%" class="head_table">Cancel</td>
  </tr>
  <?php
 if($db->db_num_rows($sql) > 0){
  while($U = $db->db_fetch_array($sql)){
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td> 
      <?php level_name($U["ugm_type"],$U["ugm_tid"]); ?>
    </td>
    <td align="center"><img src="../images/content_del.gif" width="16" height="16" onClick="self.location.href='site_member.php?Flag=Del&ugm_id=<?php echo $U["ugm_id"]; ?>&ug=<?php echo $_GET["ug"]; ?>';"></td>
  </tr>
  <?php 
  }
  }else{ ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td height="40" colspan="2"><font color="#FF0000">ไม่มีสมาชิกในกลุ่มนี้</font></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php
$db->db_close();
?>
