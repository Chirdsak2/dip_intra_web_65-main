<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$user_id =$_SESSION["EWT_MID"];

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
        <td class="myhead_02"><img src="mainpic/edit_user.gif" width="25" height="25" align="absmiddle">&nbsp;&nbsp;บริหารกลุ่ม</td>
      </tr>
    </table>
	<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp;
      <hr>
    </td>
  </tr>
</table>
      <br><br>
      <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
          <td align="center"><form name="form1" method="post" action="contact_function.php">
            เพิ่มกลุ่ม :
            <input name="group_name" type="text" size="30">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" name="Submit" value="บันทึก">
            <input type="hidden" name="flag" value="add">
                    </form></td>
        </tr>
        <tr>
          <td align="center"><table width="60%" border="0" cellpadding="5" cellspacing="1" bgcolor="#959595">
		    <tr>
              <td align="center" bgcolor="#ECE9EF">ชื่อกลุ่ม</td>
              <td align="center" bgcolor="#ECE9EF">&nbsp;</td>
            </tr>
            <?php
							$sql = "select * from contact_group where user_id = '$user_id'";
							$query = $db->query($sql);
							$num = mysql_num_rows($query);
							if($num > 0){
							while($R = $db->db_fetch_array($query)){
							?>
            <tr>
              <td width="86%" bgcolor="#FFFFFF"><?php echo $R["contact_group_name"];?></td>
              <td width="14%" align="center" bgcolor="#FFFFFF"><a href="contact_edit_group.php?groupid=<?php echo $R[contact_group_id];?>"><img src="mainpic/cal_edit.gif" alt="แก้ไข" width="16" height="16" border="0"></a>&nbsp;&nbsp;<a href="contact_function.php?flag=del&groupid=<?php echo $R[contact_group_id];?>"><img src="mainpic/b_delete.gif" alt="ลบ" width="14" height="14" border="0"></a> </td>
            </tr>
            <?php }}else{ ?>
            <tr>
              <td colspan="2" align="center" bgcolor="#FFFFFF"><span class="style1">----ไม่มีรายการกลุ่ม-----</span></td>
            </tr>
          
            <?php } ?>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
