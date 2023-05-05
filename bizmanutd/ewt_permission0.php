<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
$i = 0;
function level_name($L,$id){
	global $db;
		if($L == "A"){
			echo "<img src=\"../images/user_a.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT ug_name FROM user_group WHERE ug_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
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
	
	
	$sql = "SELECT pu_id,p_type FROM permission where UID ='".$UID."' group by pu_id ";
	$query = $db->query($sql);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><span class="ewtfunction">รายชื่อสิทธิ์ในระบบ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
<hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td width="49%" >ชื่อ - สกุล</td>
    <td width="46%" align="center" >สิทธิ์</td>
  </tr>
  <?php
  $i = 1;
  while($rec=$db->db_fetch_array($query)){
 // echo $rec["pu_id"];
 if($rec["p_type"] == 'U'){
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center" valign="top"><?php echo $i++;?></td>
    <td valign="top"><?php level_name($rec["p_type"],$rec["pu_id"]); ?></td>
    <td><?php
		$sql_sadmin = $db->query("SELECT * FROM permission WHERE  pu_id = '".$rec["pu_id"]."' AND UID = '".$UID."'  AND s_type = 'suser' ");
	if($db->db_num_rows($sql_sadmin) > 0){
			echo "<li>Super admin</li>";
	}else{
	$sql_p = $db->query("SELECT web_permission.p_name FROM permission INNER JOIN web_permission ON permission.s_type = web_permission.p_code WHERE permission.p_type = '".$rec["p_type"]."' AND permission.pu_id = '".$rec["pu_id"]."' AND permission.UID = '".$UID."'  GROUP BY web_permission.p_name ORDER BY web_permission.p_id");
		while($PP = $db->db_fetch_row($sql_p)){
			echo "<li> ".$PP[0]."</li>";
		}
		}
	?></td>
  </tr>
  <?php 
  }
  } 
  if($db->db_num_rows($query)==0){
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="30" colspan="3" align="center"><font color="#FF0000">ไม่มีข้อมูลการกำหนดสิทธิ์</font></td>
  </tr>
  <?php } ?>
</table>
<br>
</body>
</html>
<?php
$db->db_close(); ?>