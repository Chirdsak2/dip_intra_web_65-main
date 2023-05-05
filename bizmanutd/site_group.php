<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
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
$i = 0;
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td height="1" colspan="3"> 
      <?php include("com_top.php"); ?>
       
    </td>
  </tr>
  <tr valign="top"> 
    <td width="1"><?php include("com_left.php"); ?></td>
    <td>
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
	<?php
	$sql = $db->query("SELECT * FROM user_group WHERE ug_status = 'Y' ORDER BY ug_id");
	?><table width="96%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
          <td><a href="site_group.php?Flag=Add"><img src="../images/add.gif" width="16" height="16" border="0" align="absmiddle"> 
            Add new group users</a></td>
  </tr>
</table>

	  <table width="96%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <form name="form1" method="post" action="">
          <tr align="center" bgcolor="#F7F7F7"> 
            <td width="45%"><strong>Group name</strong></td>
            <td bgcolor="#F7F7F7"><strong>Group description</strong></td>
            <td width="10%"><strong>Manage Member</strong></td>
            <td width="10%"><strong>Manage Permission</strong></td>
          </tr>
          <?php
		if($db->db_num_rows($sql) > 0){
		while($R = $db->db_fetch_array($sql)){
		?>
          <tr bgcolor="#FFFFFF"> 
            <td> <?php echo $R["ug_name"]; ?> </td>
            <td><?php echo $R["ug_desc"]; ?></td>
            <?php 
			$sql_num = $db->query("SELECT COUNT(ugm_id) FROM user_group_member WHERE ug_id = '".$R["ug_id"]."' ");
			$N = $db->db_fetch_row($sql_num);
			 ?>
            <td align="center"><input type="button" name="Submit3" value="Member" onClick="popo=window.open('site_g_member.php?ug=<?php echo $R["ug_id"]; ?>','popug','width=800,height=600,scrollbars=1,resizable=1');popo.focus();"></td>
            <td align="center"><input type="button" name="Submit4" value="Permission" onClick="popo=window.open('site_g_permission.php?ug=<?php echo $R["ug_id"]; ?>','popup','width=850,height=700,scrollbars=1,resizable=1');popo.focus();"></td>
          </tr>
          <?php $i++; } ?>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php }else{ ?>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td height="35" colspan="4"><font color="#FF0000"><strong>No data 
              found.</strong></font></td>
          </tr>
          <?php  } ?>
        </form>
      </table>
	  <?php } ?>
	  </td>
    <td width="1"><?php include("com_right.php"); ?></td>
  </tr>
  <tr valign="top"> 
    <td height="1" colspan="3"> 
      <?php include("com_bottom.php"); ?>
    </td>
  </tr>
  
</table>
</body>
</html>
<?php
$db->db_close();
?>
