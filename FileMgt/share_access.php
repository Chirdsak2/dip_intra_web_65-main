<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/share_config.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST["Flag"] == "Remove"){

$file_rn = base64_decode($_POST["r_name"]);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><form name="form1" method="post" action="share_function.php">
<tr>
      <td height="30" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<a href="<?php if($_SERVER["HTTP_REFERER"] != ""){ echo $_SERVER["HTTP_REFERER"]; }else{ echo "share_index.php"; } ?>" ><img src="../images/content_back.gif" width="24" height="24" border="0" align="absmiddle"> 
        Back</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="r_name" type="hidden" id="r_name" value="<?php echo $_POST["r_name"]; ?>">
        <input name="direct" type="hidden" id="direct" value="<?php echo $_POST["direct"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Access">
		<input name="chk0" type="hidden" id="chk0" value="<?php echo $_SESSION["EWT_SUSER"]; ?>">
        Access to folder <?php echo $file_rn; ?></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
      <td align="center" valign="top"><DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: scroll;WIDTH: 100%"><?php
	$sql = $db->query("SELECT * FROM user_info WHERE EWT_Status = 'Y' AND EWT_User != '".$_SESSION["EWT_SUSER"]."' ");
	?><table width="96%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
          <tr align="center" bgcolor="#F7F7F7"> 
            <td width="15%">&nbsp;</td>
          <td width="56%"><strong>Website name</strong></td>
            <td width="29%"><strong>Folder</strong></td>
        </tr>
		<?php
		if($db->db_num_rows($sql) > 0){
		$i=1;
		while($R = $db->db_fetch_array($sql)){
		$sql_chk = $db->query("SELECT * FROM file_access WHERE file_name = '$file_rn' AND user_info = '".$R["EWT_User"]."' ");
		?>
          <tr bgcolor="#FFFFFF"> 
            <td align="center"><input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $R["EWT_User"]; ?>" <?php if($db->db_num_rows($sql_chk) > 0){ echo "checked"; } ?>></td>
          <td><?php echo $R["WebsiteName"]; ?></td>
          <td><?php echo $R["EWT_User"]; ?></td>
        </tr>
		<?php $i++; } ?>
		    <tr align="center" bgcolor="#FFFFFF"> 
              <td height="35" colspan="3"><input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
                <input type="submit" name="Submit" value=" Save ">
                <input type="reset" name="Submit2" value="Reset"> </td>
        </tr>
		<?php }else{ ?>
        <tr align="center" bgcolor="#FFFFFF"> 
          <td height="35" colspan="3"><font color="#FF0000"><strong>No data found.</strong></font></td>
        </tr>
		<?php  } ?>
      </table></DIV></td>
  </tr></form>
</table>
</body>
<?php } ?>
