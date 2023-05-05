<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
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
  <tr bgcolor="#FFFFFF"> 
    <td width="1" rowspan="2" valign="top" class="ewtfunction"> 
      <?php include("com_left.php"); ?>
    </td>
    <td class="ewtfunction">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle" border="0">&nbsp;กำหนด module ที่ต้องการใช้</td>
  </tr>
  <tr valign="top"> 
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
            <td colspan="2"><strong>Config</strong></td>
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
            <td colspan="2" align="center"><a href="#set" onClick="window.open('ewt_permission1.php?UID=<?php echo $R["UID"]; ?>','config','width=750,height=550,scrollbars=1,resizable=1');">Config</a></td>
          </tr>
          <?php $i++; } ?>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="5">&nbsp;</td>
          </tr>
          <?php }else{ ?>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td height="35" colspan="5"><font color="#FF0000"><strong>No data 
              found.</strong></font></td>
          </tr>
          <?php  } ?>
        </form>
      </table></td>
    <td width="1"> 
      <?php include("com_right.php"); ?>
    </td>
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
