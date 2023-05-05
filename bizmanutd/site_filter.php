<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
if($_POST["Flag"] == "AddG"){
			$db->query("UPDATE file_type SET file_tname = '".$_POST["ttype"]."' ");
		?>
		<script language="JavaScript">
		self.location.href = "site_filter.php";
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
       <?php
	   $sql = $db->query("SELECT * FROM file_type");
	   $R = $db->db_fetch_array($sql);
	   ?>
    </td>
  </tr>
  <tr valign="top"> 
    <td width="1"><?php include("com_left.php"); ?></td>
    <td>
	  <table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <form name="form_g" method="post" action="site_filter.php">
          <tr bgcolor="#F7F7F7"> 
            <td colspan="2"><strong>Filetype Allow</strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="137" valign="top">Explode by (,)</td>
            <td width="248"><textarea name="ttype" cols="50" rows="5" id="ttype"><?php echo $R[file_tname]; ?></textarea></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Submit"> <input type="reset" name="Submit2" value="Reset"> 
              <input name="Flag" type="hidden" id="Flag" value="AddG"></td>
          </tr>
        </form>
      </table>
	  
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
