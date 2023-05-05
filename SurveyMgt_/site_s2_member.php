<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");
 //$db->query("use  db_56_dmr_web");
 $db->query("USE ".$EWT_DB_USER);

if($_POST["Flag"] == "Add"){
        $db->query("use  ".$EWT_DB_NAME);
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
		$uid = $_POST["uid".$i];
		$utype = $_POST["utype".$i];
		if($chk == "Y"){
		//$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = '".$utype."' AND ugm_tid = '".$uid."' ");
 		 $sqlchk = $db->query("SELECT COUNT(sg_oid) FROM p_survey_group WHERE s_id = '".$_POST["ug"]."'  AND sg_oid = '$uid' ");
 		$C = $db->db_fetch_row($sqlchk);
		 		if($C[0] == 0){
						//$db->query("INSERT INTO user_group_member (ug_id,ugm_type,ugm_tid) VALUES ('".$_POST["ug"]."','".$utype."','".$uid."') ");
						$db->query("INSERT INTO p_survey_group (s_id,sg_mid,sg_oid) VALUES ('".$_POST["ug"]."','','$uid') ");
				}
		}else{
				//$sqlchk = $db->query("DELETE FROM user_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = '".$utype."' AND ugm_tid = '".$uid."' ");
				$sqlchk = $db->query("DELETE FROM p_survey_group WHERE s_id = '".$_POST["ug"]."' AND sg_mid = '' AND sg_oid = '$uid' ");
		}
	}
	?>
	<script language="JavaScript">
	//window.opener.member_list.location.reload();
	self.close();
	</script>
	<?php
	$db->query("USE ".$EWT_DB_USER);
}else{
		
function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}
function GenPic($data){
$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}

$sql_group = $db->query("SELECT * FROM org_name ORDER BY parent_org_id ASC");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function divshow(c,d){
	if(c.style.display == ""){
	c.style.display = 'none';
	d.src = "../images/plus.gif";
	}else{
		c.style.display = '';
	d.src = "../images/minus.gif";
	}
}
function divshow1(c){
	if(c.style.display == ""){
	c.style.display = 'none';
	}else{
		c.style.display = '';
	}
}
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" method="post" target="_top" action="site_s2_member.php">
<input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Add">
<tr> 
    <td>
  <?php
  $i = 0;
  $k = 0;
  $LenChk =0;
  	while($R = $db->db_fetch_array($sql_group)){
		$sql_sub = $db->query("SELECT COUNT(org_id) FROM org_name WHERE parent_org_id LIKE '".$R["parent_org_id"]."_%'");
	$count_sub = $db->db_fetch_row($sql_sub);
				$len = GenLen($R["parent_org_id"],"_");
		
			if($LenChk > $len ){
				for($y=$len;$y<$LenChk;$y++){
					echo "</div>";
			}
		}
		  $LenChk = $len;
  ?>
        <div>
      <?php
				   $db->query("use  ".$EWT_DB_NAME);
				//$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' AND ugm_type = 'D' AND ugm_tid = '".$R["org_id"]."' ");
				 $sqlchk = $db->query("SELECT COUNT(sg_oid) FROM p_survey_group WHERE s_id = '".$_GET["ug"]."'  AND sg_oid = '".$R["org_id"]."' ");
				$C = $db->db_fetch_row($sqlchk);
				$db->query("USE ".$EWT_DB_USER);
		  		GenPic($R["parent_org_id"]);
		   if($count_sub[0] > 0){ ?><img src="../images/plus.gif" border="0" align="absmiddle" onClick="divshow(document.all.dv<?php echo $i; ?>,this)"><?php }else{ ?><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php } ?><input type="checkbox" name="chk<?php echo $k; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?>>
        <a href="#show" onClick="divshow1(document.all.dp<?php echo $i; ?>)"><img src="../images/user_group.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<?php echo $R["name_org"]; ?></a> 
        <input type="hidden" name="uid<?php echo $k; ?>" value="<?php echo $R["org_id"]; ?>"><input type="hidden" name="utype<?php echo $k; ?>" value="D">
      </div>
	   <?php
	   $k++;
			   $sql_position = $db->query("SELECT * FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.org_id = '".$R["org_id"]."' ORDER BY user_position.up_rank ASC");
				echo "<div id=\"dp".$i."\"  style=\"display:none\">";
					while($P = $db->db_fetch_array($sql_position)){
					   $db->query("use  ".$EWT_DB_NAME);
					//$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' AND ugm_type = 'P' AND ugm_tid = '".$P["up_id"]."' ");
					$sqlchk = $db->query("SELECT COUNT(sg_oid) FROM p_survey_group WHERE s_id = '".$_GET["ug"]."'  AND sg_oid = '".$P["up_id"]."' ");
					$C = $db->db_fetch_row($sqlchk);
					$db->query("USE ".$EWT_DB_USER);
						GenPic($R["parent_org_id"]);
						?>
						<img src="../images/o.gif" width="40" height="20" border="0" align="absmiddle"><img src="../images/l_pos.gif" width="20" height="20" border="0" align="absmiddle"><input type="checkbox" name="chk<?php echo $k; ?>" value="Y" <?php if($C[0] > 0){ echo "checked"; } ?>><img src="../images/user_pos.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<?php echo $P["pos_name"]; ?><input type="hidden" name="uid<?php echo $k; ?>" value="<?php echo $P["up_id"]; ?>"><input type="hidden" name="utype<?php echo $k; ?>" value="P"><br>
						<?php
						$k++;
					}
				echo "</div>";
		   ?>
	   <?php  if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  style=\"display:none\">"; }  ?>
  <?php 
	
   $i++; } ?>
  </div>
</td>
  </tr><input name="alli" type="hidden" value="<?php echo $k; ?>"></form>
</table>
</body>
</html>
<?php
}
$db->db_close();
?>
