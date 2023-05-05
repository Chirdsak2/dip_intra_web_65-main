<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST["Flag"] == "NewSite"){
		$sql_chk = $db->query("SELECT UID FROM user_info WHERE EWT_User = '".$_POST["u_name"]."' ");
		if($db->db_num_rows($sql_chk) > 0){
			?>
			<script language="javascript">
			alert("User \"<?php echo $_POST["u_name"]; ?>\" already exist!!");	
			self.location.href = "site_new.php";
			</script>
			<?php
				//exit;
		}
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
    <td align="center"><br>
    <form name="form1" method="post" action="site_function.php" >
	<table width="500" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
          <tr bgcolor="#E7E7E7"> 
            <td height="25" colspan="2"><strong>Confirm Register Your website.</strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="200" bgcolor="#F7F7F7">Website name</td>
            <td width="300"><?php echo stripslashes(htmlspecialchars($_POST["w_name"],ENT_QUOTES)); ?> <input name="w_name" type="hidden" id="w_name" value="<?php echo stripslashes(htmlspecialchars($_POST["w_name"],ENT_QUOTES)); ?>">            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td bgcolor="#F7F7F7">Username</td>
            <td><?php echo $_POST["u_name"]; ?><input name="u_name" type="hidden" id="u_name" value="<?php echo $_POST["u_name"]; ?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td bgcolor="#F7F7F7">Password</td>
            <td><em><font color="#999999">*** Encoding ***</font></em> 
              <input name="u_pass" type="hidden" id="u_pass"  value="<?php echo md5($_POST["u_pass"]); ?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td bgcolor="#F7F7F7">&nbsp;</td>
            <td><input type="submit" name="Submit" value="Register&amp;Install"> <input type="button" name="Submit2" value="Cancel" onClick="self.location.href = 'site_new.php';"> 
              <input name="Flag" type="hidden" id="Flag" value="NewSite"></td>
          </tr>
          </table>
      </form>
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
}
$db->db_close();
?>
