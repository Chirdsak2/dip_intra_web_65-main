<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
	if($_GET["Flag"] == "DG" AND $_GET["ug"] != ""){
		$db->query("DELETE  FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' ");
		$db->query("DELETE  FROM user_group WHERE ug_id = '".$_GET["ug"]."' ");
		?>
		<script >
		self.location.href = "site_group.php";
		</script>
		<?php
		exit;
	}
if($_POST["Flag"] == "AddG"){
		$g_name = stripslashes(htmlspecialchars($_POST["gname"],ENT_QUOTES));
		$g_des = stripslashes(htmlspecialchars($_POST["gdesc"],ENT_QUOTES));
	$check = $db->query("SELECT COUNT(ug_name) FROM user_group WHERE ug_name = '".$g_name."' ");
	$C = $db->db_fetch_row($check);
			if($C[0] > 0 ){
				?>
				<script >
				alert("Duplicate group name!!!");
				self.location.href = "site_group.php";
				</script>
				<?php
				exit;
			}
			$db->query("INSERT INTO user_group (ug_name,ug_desc,ug_status) VALUES ('".$g_name."','".$g_des."','Y') ");
		?>
		<script >
		self.location.href = "site_group.php";
		</script>
		<?php
		exit;
}
function show_permission($type,$id){
	global $db,$EWT_DB_USER;
	echo "<ul>";
			$sql_sadmin = $db->query("SELECT * FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'suser' ");
	if($db->db_num_rows($sql_sadmin) > 0){
			echo "<li>Super admin</li>";
	}else{
	$sql_p = $db->query("SELECT web_permission.p_name,web_permission.p_code,web_permission.p_type FROM permission INNER JOIN web_permission ON permission.s_type = web_permission.p_code WHERE permission.p_type = '".$type."' AND permission.pu_id = '".$id."' AND permission.UID = '".$_SESSION["EWT_SUID"]."'  GROUP BY web_permission.p_name ORDER BY web_permission.p_id");
		while($PP = $db->db_fetch_row($sql_p)){
			echo "<li> ".$PP[0]."</li>";
			    // cms w
				if($PP[1] == "cms" AND $PP[2] == "w"){
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'w' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'w' ");
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
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'a' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Fo' AND s_permission = 'a' ");
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
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'w' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'w' ");
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
					$sql_f_all = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'a' AND s_id = '0'");
					if($db->db_num_rows($sql_f_all) > 0){
					echo "<ul><li>ทุกหมวด</li></ul>";
					}else{
					$sql_cmsw = $db->query("SELECT s_id FROM permission WHERE p_type = '".$type."' AND pu_id = '".$id."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = 'Ag' AND s_permission = 'a' ");
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
				//end check
		}
		}
		echo "</ul>";
	}
	
include("../lib/config_path.php");
include("../header.php");	
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
</head>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>


<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?="กำหนดสิทธิ์กลุ่มผู้ใช้งาน" ;?></h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12"></div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >
</div>
</div>
</div>	
<div class="clearfix">&nbsp;</div>
<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">กำหนดสิทธิ์กลุ่มผู้ใช้งาน</span> </td>
  </tr>
</table>-->

<?php if($_GET["Flag"] == "Add"){ ?>


	  <table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <form name="form_g" method="post" action="site_group.php" onSubmit="return chk();">
          <tr bgcolor="#F7F7F7"> 
            <td colspan="2"><strong>Add new group users</strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="137">Group name :</td>
            <td width="248"><input name="gname" type="text" id="gname" size="30"></td>
          </tr>
		  <tr bgcolor="#FFFFFF"> 
            <td>Group description :</td>
            <td><textarea name="gdesc" cols="30" rows="4" id="gdesc"></textarea></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Submit"> <input type="reset" name="Submit2" value="Reset"> 
              <input name="Flag" type="hidden" id="Flag" value="AddG"></td>
          </tr>
        </form>
      </table>
	  
	  
<script >
function chk(){
	if(document.form_g.gname.value == ""){
			alert("Please input group name");
			document.form_g.gname.focus();
			return false;
	}
}
</script>
<?php }else{ ?>


<?php
	$sql = $db->query("SELECT * FROM user_group WHERE ug_status = 'Y' ORDER BY ug_id");
?>


<table width="90%" border="0" align="center" class="table table-bordered">
<form name="form1" method="post" action="">
    
	<tr align="center" class="ewttablehead"> 
      <th width="10%" style="text-align:center;">&nbsp;</th>
      <th width="45%" style="text-align:center;">ชื่อกลุ่ม</th>
      <th width="45%" style="text-align:center;">สิทธิ์ </th>
    </tr>
	
<?php
if($db->db_num_rows($sql) > 0){
	
		while($R = $db->db_fetch_array($sql)){
?>

<tr bgcolor="#FFFFFF"> 
<?php 
		//	$sql_num = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$R["ug_id"]."' ");
		//	$N = $db->db_fetch_row($sql_num);
?>
<td align="center" valign="top">
	  <nobr>
	  <a href="#123" onClick="self.location.href='ewt_permission1.php?mid=<?php echo $R["ug_id"]; ?>&mtype=A';">
	  <img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" title="กำหนดสิทธิ์">
	  </a> 
      </nobr>
</td>
<td valign="top"><?php echo $R["ug_name"]; ?></td>
<td>
<?php
show_permission("A",$R["ug_id"]);
?>
</td>
</tr>
<?php 
$i++; } 
?>
<?php }else{ ?>	
<tr align="center" bgcolor="#FFFFFF"> 
<td height="35" colspan="3"><font color="#FF0000"><strong>No data found.</strong></font></td>
</tr>
<?php  } ?>
</form>
</table>

<?php } ?>

</div>
</div>	
<?php
include('footer.php');
?>
</body>
</html>
<?php
$db->db_close(); 
?>