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
	$sql = $db->query("SELECT * FROM user_group WHERE ug_id = '".$_GET["ug"]."' ");
	$C = $db->db_fetch_array($sql);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body><br>

<table width="94%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#AAAAAA">
        <form name="form_g" method="post" action="site_group.php" onSubmit="return chk();">
          <tr bgcolor="#F7F7F7"> 
            
      <td height="30" colspan="2">&nbsp;<strong>Manage group users</strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="25%" height="30">&nbsp;Group name :</td>
            <td width="75%">&nbsp;<?php echo $C["ug_name"]; ?></td>
          </tr>
		  
    <tr bgcolor="#FFFFFF"> 
      <td height="30">&nbsp;</td>
            
      <td>&nbsp;
        <input type="button" name="Submit3" value="Add user" onClick="win3=window.open('site_s_member.php?ug=<?php echo $_GET["ug"]; ?>','users','width=600,height=400,scrollbars=1,resizable=1');win3.focus();"></td>
          </tr>
		  
    <tr bgcolor="#FFFFFF"> 
      <td height="30">&nbsp;</td>
      <td valign="top"><iframe name="member_list" src="site_member.php?ug=<?php echo $_GET["ug"]; ?>" frameborder="0"  width="100%" height="350" scrolling="yes"></iframe></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="30">&nbsp;</td>
            <td><input type="button" name="Button" value="Save"> <input type="reset" name="Submit2" value="Reset"> 
              <input name="Flag" type="hidden" id="Flag" value="AddG">
        <input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>"></td>
          </tr>
        </form>
      </table>
</body>
</html>
<?php
$db->db_close();
?>
