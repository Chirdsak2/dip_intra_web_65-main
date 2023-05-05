<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
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
    <td class="ewtfunction">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle" border="0">&nbsp;Report Bugs </td>
  </tr>
  <tr valign="top"> 
    <td> 
      <table width="96%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <form name="form1" method="post" action="">
          <tr align="center" bgcolor="#F7F7F7"> 
		  <td width="15%"><strong>วันที่แจ้ง</strong></td>
            <td width="30%"><strong>เรื่อง</strong></td>
            <td width="30%"><strong>รายละเอียด</strong></td>
            <td width="10%"><strong>Url</strong></td>
            <td width="5%"><strong>User</strong></td>
            <td width="10%"><strong>Website</strong></td>
            <td width="10%"><strong>สถานะ</strong></td>
          </tr>
		  <?php
		  $sql = "select * from report_bugs";
		  $query = $db->query($sql);
		  while($R = $db->db_fetch_array($query)){
		  ?>
          <tr bgcolor="#FFFFFF"> 
            <td><?php echo $R[report_date_sent];?></td>
            <td ><?php echo $R[report_name];?></td>
            <td><?php echo $R[report_detail];?></td>
            <td><?php echo $R[report_url];?></td>
            <td ><?php echo $R[report_user];?></td>
			<td ><?php echo $R[report_website];?></td>
            <td >&nbsp;</td>
          </tr>
<?php
}
?>
<?php if($db->db_num_rows($query)==0){?>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td height="35" colspan="7"><font color="#FF0000"><strong>No data 
              found.</strong></font></td>
          </tr>
<?php } ?>       
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
