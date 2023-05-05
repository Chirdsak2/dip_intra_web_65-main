<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST["Flag"]=='Approve'){
$sql_sel = "select myFlag from permission_approve where ap_id = '".$_POST["apid"]."'";
$query_sel = $db->query($sql_sel);
$rec = $db->db_fetch_array($query_sel);
$myflag = $rec[myFlag];
$sql_p = $db->query("SELECT * FROM permission2 WHERE myFlag = '".$myflag."' ");
while($P = $db->db_fetch_array($sql_p)){
			$sql_text = "";
			if($P["s_id"] != "" AND $P["s_id"] != "0"){
				$sql_text .= " AND s_id = '".$P["s_id"]."' ";
			}
			if($P["s_name"] != ""){
				$sql_text .= " AND s_name = '".$P["s_name"]."' ";
			}
							$sql_p1 = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$P["p_type"]."' AND pu_id = '".$P["pu_id"]."' AND UID = '".$P["UID"]."' AND s_type = '".$P["s_type"]."' AND s_permission = '".$P["s_permission"]."' ".$sql_text);
	 			$C = $db->db_fetch_row($sql_p1);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission (p_type,pu_id,UID,s_type,s_id,s_name,s_permission) VALUES ('".$P["p_type"]."','".$P["pu_id"]."','".$P["UID"]."','".$P["s_type"]."','".$P["s_id"]."','".$P["s_name"]."','".$P["s_permission"]."') ");
					}
}
$sql_update = "update  permission_approve SET t_status = 'A' WHERE ap_id = '".$_POST["apid"]."'";
$db->query($sql_update);
?>
<script language="javascript">
		alert("ทำการอนุมัติเรียบร้อยแล้ว");
		window.opener.location.reload();
		self.close();
</script>
<?php
exit;
}
if($_POST["Flag"]=='UnApprove'){
$sql_update = "update  permission_approve SET t_status = 'N' WHERE ap_id = '".$_POST["apid"]."'";
$db->query($sql_update);
?>
<script language="javascript">
		window.opener.location.reload();
		self.close();
</script>
<?php
exit;
}
$sql_app = $db->query("SELECT * FROM permission_approve WHERE ap_id = '".$_GET["apid"]."' ");
$A = $db->db_fetch_array($sql_app);
				$sql_userf = $db->query("SELECT name_thai,surname_thai FROM gen_user  WHERE gen_user_id = '".$A[f_from]."' ");
				$Uf = $db->db_fetch_row($sql_userf);
				$sql_users = $db->query("SELECT name_thai,surname_thai FROM gen_user  WHERE gen_user_id = '".$A[t_set]."' ");
				$Us = $db->db_fetch_row($sql_users);
				$sql_usert = $db->query("SELECT name_thai,surname_thai FROM gen_user  WHERE gen_user_id = '".$A[t_to]."' ");
				$Ut = $db->db_fetch_row($sql_usert);
		
		function show_permission($type,$id,$flag){
	global $db,$EWT_DB_USER;
	echo "<ul>";
			$sql_sadmin = $db->query("SELECT p_id FROM permission2 WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'suser' AND myFlag = '$flag' ");
	if($db->db_num_rows($sql_sadmin) > 0){
			echo "<li>Super admin</li>";
	}else{
	$sql_p = $db->query("SELECT web_permission.p_name,web_permission.p_code,web_permission.p_type FROM permission2 INNER JOIN web_permission ON permission2.s_type = web_permission.p_code AND permission2.s_permission = web_permission.p_type  WHERE permission2.p_type = '".$type."' AND permission2.pu_id = '".$id."' AND permission2.UID = '".$_SESSION["EWT_SUID"]."' AND permission2.myFlag = '$flag' GROUP BY web_permission.p_name ORDER BY web_permission.p_id");

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
<script language="javascript1.2">
function link_app(){
document.form1.Flag.value = "Approve";
form1.submit();
}
function link_unapp(){
document.form1.Flag.value = "UnApprove";
form1.submit();
}
</script>

</head>
<body leftmargin="0" topmargin="0">
<strong><font size="2" face="Tahoma">คุณ <?php echo $Uf[0]." ".$Uf[1]; ?> ต้องการกำหนดสิทธิ์ให้กับ 
<?php echo $Us[0]." ".$Us[1]; ?> ดังนี้</font></strong> 
<hr size="1">

<table width="100%" border="0" cellspacing="0" cellpadding="5"  class="ewttableuse">
<form name="form1" method="post" action="">
  <tr>
    <td bgcolor="#FFFFFF" ><?php show_permission("U",$A[t_set],$A[myFlag]); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;
    <input name="Approve" type="button" value="อนุมัติ" onClick="link_app();" >&nbsp;&nbsp;<input name="cancle" type="button" value="ไม่อนุมัติ" onClick="link_unapp();">
      
        <input name="apid" type="hidden" id="apid" value="<?php echo $_GET["apid"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value=""> </td>
  </tr></form>
</table>


</body>
</html>
<?php
$db->db_close(); ?>
