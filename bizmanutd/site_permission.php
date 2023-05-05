<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
if($_POST["Flag"] == "Set"){
		for($i=0;$i<$_POST["alli"];$i++){
				$chk = $_POST["chk".$i];
				$uid = $_POST["UID".$i];
				if($chk == "Y"){
				$db->query("UPDATE user_info SET EWT_Permission = 'Y' WHERE UID = '".$uid."'");
				}else{
				$db->query("UPDATE user_info SET EWT_Permission = 'N' WHERE UID = '".$uid."'");
				}
		}
		?>
		<script language="JavaScript">
		self.location.href = "site_permission.php";
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
	<?php
	$sql = $db->query("SELECT * FROM user_info WHERE EWT_Status = 'Y' ");
	?>
	  <table width="96%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <form name="form1" method="post" action="">
          <tr align="center" bgcolor="#F7F7F7"> 
            <td width="15%"><strong>Date Regis</strong></td>
            <td width="35%"><strong>Website name</strong></td>
            <td width="20%"><strong>User</strong></td>
            <td width="15%"><strong>Set User</strong></td>
            <td width="15%"><strong>Use Password</strong></td>
          </tr>
          <?php
		if($db->db_num_rows($sql) > 0){
		while($R = $db->db_fetch_array($sql)){
		?>
          <tr bgcolor="#FFFFFF"> 
            <td> 
              <?php $d = explode("-",$R["StartDate"]); echo $d[2]."/".$d[1]."/".$d[0]; ?>
            </td>
            <td><?php echo $R["WebsiteName"]; ?></td>
            <td><?php echo $R["EWT_User"]; ?></td>
            <td align="center"><a href="#set" onClick="window.open('ewt_permission.php?UID=<?php echo $R["UID"]; ?>','setting','width=750,height=550,scrollbars=1,resizable=1');">Setting</a></td>
            <td align="center"> <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="Y" <?php if($R["EWT_Permission"] == "Y"){ echo "checked"; } ?>> 
              <input name="UID<?php echo $i; ?>" type="hidden" id="UID<?php echo $i; ?>" value="<?php echo $R["UID"]; ?>"></td>
          </tr>
          <?php $i++; } ?>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="4">&nbsp;</td>
            <td><input type="submit" name="Submit" value="Submit"> <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>"> 
              <input name="Flag" type="hidden" id="Flag" value="Set"></td>
          </tr>
          <?php }else{ ?>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td height="35" colspan="5"><font color="#FF0000"><strong>No data 
              found.</strong></font></td>
          </tr>
          <?php  } ?>
        </form>
      </table></td>
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
