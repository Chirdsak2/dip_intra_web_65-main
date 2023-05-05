<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$user_id =$_SESSION["EWT_MID"];
$sql = "select * from contact_group where contact_group_id = '".$_GET["groupid"]."'";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
?>
<html>
<head>
<title>My Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #006699}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td class="myhead_02"><img src="mainpic/edit_user.gif" width="25" height="25" align="absmiddle"><STRONG><A href="contact_add_group.php" target="contact_body">&nbsp;&nbsp;<span class="style2">บริหารกลุ่ม</span></A></STRONG> </td>
      </tr>
    </table>
      <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
      <tr>
        <td align="right"><a href="contact_add_group.php"><img src="mainpic/m_home.gif" width="24" height="24" border="0" align="absmiddle">กลับ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><hr>
           </td>
      </tr>
    </table>
	<br><br>
      <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td align="center"><form name="form1" method="post" action="contact_function.php">
          แก้ไขกลุ่ม :
          <input name="group_name" type="text" size="30" value="<?php echo $R[contact_group_name];?>">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="Submit" value="บันทึก">
          <input type="hidden" name="flag" value="edit">
          <input type="hidden" name="groupid" value="<?php echo $_GET["groupid"];?>">
                </form></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
