<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_GET["flag"] == "u" AND $_GET["s"] != ""){
rename("../ewt/".$_GET["u"], "../ewt/".$_GET["u"]."_".$_GET["s"]."_bk");
$db->query("UPDATE user_info SET EWT_Status = 'N',WebsiteName = EWT_User WHERE UID = '".$_GET["s"]."' ");
$db->query("UPDATE user_info SET EWT_User = '' WHERE UID = '".$_GET["s"]."' ");
?>
<script language="JavaScript">
self.location.href = "site_main.php";
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
        <tr align="center" bgcolor="#F7F7F7"> 
          <td width="23%"><strong>Date Regis</strong></td>
          <td width="20%"><strong>Website name</strong></td>
          <td width="15%"><strong>Username</strong></td>
          <td width="10%"><strong>Config Login </strong></td>
          <td width="14%"><strong>Edit password</strong></td>
          <td width="5%"><strong>Backup</strong></td>
          <td width="6%"><strong>Restore</strong></td>
          <td width="7%"><strong>Delete</strong></td>
        </tr>
        <?php
		if($db->db_num_rows($sql) > 0){
		while($R = $db->db_fetch_array($sql)){
		?>
        <tr bgcolor="#FFFFFF"> 
          <td> 
            <?php $d = explode("-",$R["StartDate"]); echo $d[2]."/".$d[1]."/".$d[0]; ?>          </td>
          <td><?php echo $R["WebsiteName"]; ?></td>
          <td><?php echo $R["EWT_User"]; ?></td>
          <td align="center"><a href="#set" onClick="window.open('ewt_configlogin.php?UID=<?php echo $R["UID"]; ?>','config_login','width=350,height=350,scrollbars=1,resizable=1');"><img src="../images/bar_properties.gif" alt="ตั้งค่าการ login" width="20" height="20" border="0"></a></td>
          <td align="center"><a href="#set" onClick="window.open('ewt_editpassword.php?UID=<?php echo $R["UID"]; ?>','config','width=350,height=350,scrollbars=1,resizable=1');"><img src="../images/article_pencil.gif" width="16" height="16" border="0"></a></td>
          <td align="center"><a href="site_backup.php?UID=<?php echo $R["UID"]; ?>" target="_blank"><img src="../images/folder_dl.gif" width="20" height="20" border="0"></a></td>
          <td align="center"><a href="site_restore.php?UID=<?php echo $R["UID"]; ?>" target="_blank"><img src="../images/folder_into.gif" width="16" height="16" border="0"></a></td>
          <td align="center"><a href="#del" onClick="if(confirm('Are you sure to delete website?')){ self.location.href='site_main.php?flag=u&s=<?php echo $R["UID"]; ?>&u=<?php echo $R["EWT_User"]; ?>'; }"><img src="../images/b_delete.gif" width="14" height="14" border="0"></a></td>
        </tr>
        <?php }}else{ ?>
        <tr align="center" bgcolor="#FFFFFF"> 
          <td height="35" colspan="8"><font color="#FF0000"><strong>No data found.</strong></font></td>
        </tr>
        <?php  } ?>
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
