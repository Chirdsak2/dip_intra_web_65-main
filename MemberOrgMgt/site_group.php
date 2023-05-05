<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
	if($_GET["Flag"] == "DG" AND $_GET["ug"] != ""){
		$db->query("DELETE FROM permission1 WHERE p_type = 'A' AND pu_id = '".$_GET["ug"]."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type != 'suser'");
		$db->query("DELETE  FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' ");
		$db->query("DELETE  FROM user_group WHERE ug_id = '".$_GET["ug"]."' ");
		?>
		<script language="JavaScript">
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
				<script language="JavaScript">
				alert("Duplicate group name!!!");
				self.location.href = "site_group.php";
				</script>
				<?php
				exit;
			}
			$db->query("INSERT INTO user_group (ug_name,ug_desc,ug_status) VALUES ('".$g_name."','".$g_des."','Y') ");
		?>
		<script language="JavaScript">
		self.location.href = "site_group.php";
		</script>
		<?php
		exit;
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
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">บริหารกลุ่มสิทธิ์  </span> </td>
  </tr>
</table>
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
	  <script language="JavaScript">
function chk(){
	if(document.form_g.gname.value == ""){
			alert("Please input group name");
			document.form_g.gname.focus();
			return false;
	}
}
</script>
<?php }else{ ?>
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("บริหารกลุ่มสิทธิ์");?>&module=org&url=<?php echo urlencode("site_group.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="site_group.php?Flag=Add"><img border="0" src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle"> 
     เพิ่มกลุ่ม</a> 
      <hr>
    </td>
  </tr>
</table>
<?php
	$sql = $db->query("SELECT * FROM user_group WHERE ug_status = 'Y' ORDER BY ug_id");
	?>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse">
  <form name="form1" method="post" action="">
    <tr align="center" class="ewttablehead"> 
      <td width="10%">&nbsp;</td>
      <td width="45%"><strong>Group name</strong></td>
      <td ><strong>Group description</strong></td>
    </tr>
    <?php
		if($db->db_num_rows($sql) > 0){
		while($R = $db->db_fetch_array($sql)){
		?>
    <tr bgcolor="#FFFFFF"> 
      <?php 
			$sql_num = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$R["ug_id"]."' ");
			$N = $db->db_fetch_row($sql_num);
			 ?>
      <td align="center"><nobr><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไขข้อมูล" onMouseOver="this.style.cursor='hand';"  onClick="popo=window.open('site_g_member.php?ug=<?php echo $R["ug_id"]; ?>','popug','width=800,height=600,scrollbars=1,resizable=1');popo.focus();">   <a href="#d" onClick="if(confirm('คุณต้องการลบข้อมูลหรือไม่?')){ window.location.href='site_group.php?Flag=DG&ug=<?php echo $R["ug_id"]; ?>'; }"><img src="../theme/main_theme/g_del.gif" alt="ลบข้อมูล" width="16" height="16" border="0" onMouseOver="this.style.cursor='hand';" ></a></nobr></td>
      <td> <?php echo $R["ug_name"]; ?> </td>
      <td><?php echo $R["ug_desc"]; ?></td>
    </tr>
    <?php $i++; } ?>
    <?php }else{ ?>
    <tr align="center" bgcolor="#FFFFFF"> 
      <td height="35" colspan="3"><font color="#FF0000"><strong>No data found.</strong></font></td>
    </tr>
    <?php  } ?>
  </form>
</table>
<?php } ?>
</body>
</html>
<?php

$db->db_close(); ?>