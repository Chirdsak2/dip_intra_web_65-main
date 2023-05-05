<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST["Flag"] == "Add") {
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		$bcode = base64_decode($_POST["B"]);
		$bid_a = explode("z",$bcode);
		$BID = $bid_a[1];
		$value = $_POST["inc"].",".$_POST["otype"].",".$_POST["showname"].",".$_POST["showpic"].",".$_POST["showdetail"];
		$db->query("UPDATE block SET block_link = '".$value."', block_name='".$_POST['block_name']."' WHERE BID = '".$BID."' ");
?>
<script language="JavaScript">self.close();</script>
<?php
	} else {
		$bcode = base64_decode($_GET["B"]);
		$bid_a = explode("z",$bcode);
		$BID = $bid_a[1];
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		$sql_file = $db->query("SELECT block_name,block_link FROM block WHERE BID = '".$BID."'");
		if($db->db_num_rows($sql_file) == 1) {
			$R = $db->db_fetch_array($sql_file);
			$block_name=$R['block_name'];
			$or = explode(",",$R[block_link]);
			$sname = $or[2];
			$spic = $or[3];
			$sdetail = $or[4];
			$db->query("USE ".$EWT_DB_USER);
			function GenLen($data,$op) {
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
function divshow(c,d) {
	if(c.style.display == "") {
		c.style.display = 'none';
		d.src = "../images/plus.gif";
	} else {
		c.style.display = '';
		d.src = "../images/minus.gif";
	}
}
function divshow1(c) {
	if(c.style.display == "") {
		c.style.display = 'none';
	} else {
		c.style.display = '';
	}
}
function choose(c) {
	document.form1.inc.value = c;
	//	form1.submit();
	//	top.close();
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
	<tr>
		<td bgcolor="F7F7F7">
			<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
				<form name="form1" method="post" action="content_org_edit.php">
					<input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
					<tr> 
						<td height="20">
							<img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
							<strong>Update Organization Chart <input type="submit" name="Submit" value="Save change"></strong> 
							<table width="100%" border="0" cellspacing="1" cellpadding="1">
								<tr> 
									<td>
										<table width="100%" border="0" cellspacing="1" cellpadding="0">
											<tr>
												<td colspan="5" align="left">Block name : <input type="text" name="block_name" id="block_name" value="<?php echo $block_name; ?>"></td>
											</tr>
											<tr> 
												<td width="20%"><input name="otype" type="radio" value="0" <?php if($or[1] == "0"){ echo "checked"; } ?>> แสดงหน่วยงานรูปแบบ tree</td>
												<td width="18%"><input type="radio" name="otype" value="1" <?php if($or[1] == "1"){ echo "checked"; } ?>>แสดงบุคคลในหน่วยงาน</td>
												<td width="20%"><input type="radio" name="otype" value="2" <?php if($or[1] == "2"){ echo "checked"; } ?>>แสดงหน่วยงานรูปแบบ chart</td>
									<td width="20%"><input type="radio" name="otype" value="3" <?php if($or[1] == "3"){ echo "checked"; } ?>>
												แสดงผังบุคลากรแบบ Chat </td>
												<td width="22%"><input type="radio" name="otype" value="4" <?php if($or[1] == "4"){ echo "checked"; } ?>>
						แสดงผังบุคลากรแบบรายการ</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<table width="100%" border="0" cellspacing="1" cellpadding="0">
											<tr>
												<td width="33%"><input name="showname" type="checkbox" id="showname" value="Y" <?php if($sname == "Y"){ echo "checked"; } ?>>แสดงชื่อ - สกุลบุคลากรในหน่วยงาน</td>
												<td width="33%"><input name="showpic" type="checkbox" id="showpic" value="Y" <?php if($spic == "Y"){ echo "checked"; } ?>>แสดงรูปภาพบุคลากร </td>
												<td><input name="showdetail" type="checkbox" id="showdetail" value="Y" <?php if($sdetail == "Y"){ echo "checked"; } ?>>แสดงรายละเอียดของหน่วยงาน </td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr> 
						<td valign="top">
							<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
								<tr> 
									<td valign="top" bgcolor="#FFFFFF">
										<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
											<input name="Flag" type="hidden" id="Flag" value="Add">
											<input name="inc" type="hidden" id="inc" value="<?php echo $or[0]; ?>">
											<input type="hidden" name = "filename" value = "<?php echo $_GET["filename"]; ?>">
											<tr>
												<td>
													<?php
														$i = 0;
														$k = 0;
														$LenChk =0;
														while($R = $db->db_fetch_array($sql_group)) {
															$sql_sub = $db->query("SELECT COUNT(org_id) FROM org_name WHERE parent_org_id LIKE '".$R["parent_org_id"]."_%'");
															$count_sub = $db->db_fetch_row($sql_sub);
															$len = GenLen($R["parent_org_id"],"_");
															if($LenChk > $len ) {
																for($y=$len;$y<$LenChk;$y++) {
																	echo "</div>";
																}
															}
															$LenChk = $len;
													?>
													<div>
													<?php
															$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' AND ugm_type = 'D' AND ugm_tid = '".$R["org_id"]."' ");
															$C = $db->db_fetch_row($sqlchk);
															GenPic($R["parent_org_id"]);
															if($count_sub[0] > 0) { 
													?>
														<img src="../images/plus.gif" border="0" align="absmiddle" onClick="divshow(document.all.dv<?php echo $i; ?>,this)"><?php }else{ ?><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php } ?>
														<input type="radio" name="chk" value="Y" onClick="choose('<?php echo $R["org_id"]; ?>')" <?php if($R["org_id"] == $or[0]){ echo "checked"; } ?>>
														<a href="#show" onClick="divshow1(document.all.dp<?php echo $i; ?>)"><img src="../images/user_group.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<?php echo $R["name_org"]; ?></a> 
														<input type="hidden" name="uid<?php echo $k; ?>" value="<?php echo $R["org_id"]; ?>">
														<input type="hidden" name="utype<?php echo $k; ?>" value="D">
													</div>
													<?php
																$k++;
																$sql_position = $db->query("SELECT * FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.org_id = '".$R["org_id"]."' ORDER BY user_position.up_rank ASC");
																echo "<div id=\"dp".$i."\"  style=\"display:none\">";
																while($P = $db->db_fetch_array($sql_position)) {
																	$sqlchk = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' AND ugm_type = 'P' AND ugm_tid = '".$P["up_id"]."' ");
																	$C = $db->db_fetch_row($sqlchk);
																	GenPic($R["parent_org_id"]);
													?>
													<img src="../images/o.gif" width="40" height="20" border="0" align="absmiddle"><img src="../images/l_pos.gif" width="20" height="20" border="0" align="absmiddle"><img src="../images/user_pos.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<?php echo $P["pos_name"]; ?>
													<input type="hidden" name="uid<?php echo $k; ?>" value="<?php echo $P["up_id"]; ?>"><input type="hidden" name="utype<?php echo $k; ?>" value="P"><br>
													<?php
																	$k++;
																}
																echo "</div>";
													?>
													<?php  if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  style=\"display:none\">"; }  ?>
													<?php 
																$i++; 
															} 
													?>
													</div>
												</td>
											</tr><input name="alli" type="hidden" value="<?php echo $k; ?>">
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</form>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
<?php
		}
	}
	$db->db_close(); 
?>
