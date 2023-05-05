<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($flag=='del'){
$sql_sel = "select myFlag from permission_approve where ap_id = '$t_id'";
$query_sel = $db->query($sql_sel);
$rec = $db->db_fetch_array($query_sel);
$myflag = $rec[myFlag];
$sql_del = "DELETE FROM permission2 WHERE myFlag = '$myflag'";
$db->query($sql_del);
$sql_del = "DELETE FROM permission_approve WHERE ap_id = '$t_id'";
$db->query($sql_del);
?>
<script language="javascript">
		alert("ทำการยกเลิกเรียบร้อยแล้ว");
		self.location.href = "wait_permission.php";
</script>
<?php
}
$sql = $db->query("SELECT * FROM user_info WHERE UID = '".$_SESSION["EWT_SUID"]."' ");
$R = $db->db_fetch_array($sql);
$sql_app = $db->query("SELECT * FROM permission_approve WHERE UID = '".$_SESSION["EWT_SUID"]."' AND f_from = '".$_SESSION["EWT_SMID"]."'  ");
$st["W"] = "<font color=blue>รอการอนุมัติ</font>";
$st["A"] = "<font color=green>อนุมัติ</font>";
$st["N"] = "<font color=red>ไม่อนุมัติ</font>";

function show_permission($type,$id,$flag){
	global $db,$EWT_DB_USER;
	echo "<ul>";
			$sql_sadmin = $db->query("SELECT p_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'suser' AND myFlag = '$flag' ");
	if($db->db_num_rows($sql_sadmin) > 0){
			echo "<li>Super admin</li>";
	}else{
	$sql_p = $db->query("SELECT web_permission.p_name,web_permission.p_code,web_permission.p_type FROM permission2 INNER JOIN web_permission ON permission2.s_type = web_permission.p_code AND permission2.s_permission = web_permission.p_type WHERE permission2.p_type = '".$type."' AND permission2.pu_id = '".$id."' AND permission2.UID = '".$_SESSION["EWT_SUID"]."' AND permission2.myFlag = '$flag' GROUP BY web_permission.p_name ORDER BY web_permission.p_id");

		while($PP = $db->db_fetch_row($sql_p)){
			echo "<li> ".$PP[0]."</li>";
			    // cms w
				if($PP[1] == "cms" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'w' AND s_id = '0' AND myFlag = '$flag'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'w'  AND myFlag = '$flag'");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT Main_Group_Name FROM temp_main_group WHERE Main_Group_ID = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// cms a
				if($PP[1] == "cms" AND $PP[2] == "a"){
					$sql_f_all = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'a' AND s_id = '0' AND myFlag = '$flag'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'a'  AND myFlag = '$flag'");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT Main_Group_Name FROM temp_main_group WHERE Main_Group_ID = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				// art w
				if($PP[1] == "art" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'w' AND s_id = '0' AND myFlag = '$flag'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'w'  AND myFlag = '$flag'");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT c_name FROM article_group WHERE c_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				//art a
				if($PP[1] == "art" AND $PP[2] == "a"){
					$sql_f_all = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'a' AND s_id = '0' AND myFlag = '$flag'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'a'  AND myFlag = '$flag'");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT c_name FROM article_group WHERE c_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				
				//Gallery w 
				if($PP[1] == "Gallery" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Gg' AND s_permission = 'w' AND s_id = '0' AND myFlag = '$flag'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Gg' AND s_permission = 'w'  AND myFlag = '$flag'");
					if($db->db_num_rows($sql_cmsw) > 0){
					echo "<ul>";
						while($F = $db->db_fetch_row($sql_cmsw)){
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						$sql_f = $db->query("SELECT category_name FROM gallery_category WHERE category_id = '$F[0]' ");
							if($db->db_num_rows($sql_f) > 0){
								$Fo = $db->db_fetch_row($sql_f);
								echo "<li>หมวด ".$Fo[0]."</li>";
							}
						$db->query("USE ".$EWT_DB_USER);
						}
					echo "</ul>";
					}
					}
				}
				//end check
		}
		}
		echo "</ul>";
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
<form name="formlink" method="post" action="">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ติดตามผลการดำเนินงาน</span> <input type="hidden" name="mid" value=""><input type="hidden" name="mtype" value=""><input type="hidden" name="muse" value="">
        <input name="Flag" type="hidden" id="Flag"></td>
  </tr>
  </form>
</table>
<table width="94%"  border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr> 
    <td  bgcolor="#FFFFFF"><hr></td>
  </tr>
  <tr> 
    <td align="center" valign="top" bgcolor="F3F3EE">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#666666"  class="ewttableuse">
        <tr align="center" bgcolor="#CCCCCC"  class="ewttablehead"> 
          <td width="10%"><strong>วันที่</strong></td>
          <td width="10%"><strong>เวลา</strong></td>
          <td width="20%"><strong>ผู้ถูกกำหนดสิทธิ์</strong></td>
          <td width="20%"><strong>หัวหน้า/ผู้อนุมัติ</strong></td>
          <td width="20%"><strong>สิทธิ์ที่กำหนด</strong></td>
          <td width="10%"><strong>สถานะ</strong></td>
          <td width="10%"><strong>ยกเลิกการส่งคำขอ</strong></td>
        </tr>
		<?php
		if($db->db_num_rows($sql_app) > 0){
		while($A = $db->db_fetch_array($sql_app)){
		?>
        <tr valign="top"> 
          <td bgcolor="#FFFFFF"><?php echo $A[f_date]; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $A[f_time]; ?></td>
          <td bgcolor="#FFFFFF"><?php
		  		$sql_user = $db->query("SELECT name_thai,surname_thai FROM gen_user  WHERE gen_user_id = '".$A[t_set]."' ");
				$U = $db->db_fetch_row($sql_user);
		   echo $U[0]." ".$U[1]; ?></td>
          <td bgcolor="#FFFFFF"><?php
		  		$sql_user = $db->query("SELECT name_thai,surname_thai FROM gen_user  WHERE gen_user_id = '".$A[t_to]."' ");
				$U = $db->db_fetch_row($sql_user);
		   echo $U[0]." ".$U[1]; ?></td>
          <td bgcolor="#FFFFFF"><?php show_permission("U",$A[t_set],$A[myFlag]); ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $st[$A[t_status]]; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php
		  if($A[t_status] == "W"){
		  ?><a href="?flag=del&t_id=<?php echo $A[ap_id];?>">ยกเลิก</a><?php
		  }else{
		  echo "-";
		  }
		  ?></td>
        </tr>
		<?php }}else{ ?>
        <tr align="center"> 
          <td height="30" colspan="7" bgcolor="#FFFFFF"><font color="#FF0000">ไม่มีข้อมูลการขอสิทธิ์</font></td>
        </tr>
		<?php } ?>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
