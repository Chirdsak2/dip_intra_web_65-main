<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//$db->query("USE ".$EWT_DB_USER);


if($_POST[flag] == "save"){
	    $sql_chk = "select * from member_setting";
		$query = $db->query($sql_chk);
		if($db->db_num_rows($query)>0){
			 $sql_chk = "update  member_setting set  set_type= '$_POST[set_type]' ";
		}else{
			 $sql_chk = "insert into  member_setting(set_type) VALUES('$_POST[set_type]')";
		}
		$query = $db->query($sql_chk);
		echo "<script language=\"javascript\">";
		echo "alert('บันทึกการตั้งค่าเรียบร้อยแล้ว');";
		echo "document.location.href='member_setting.php'";
		echo "</script>";
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ตั้งค่าระบบสมาชิก</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
      <hr>
    </td>
  </tr>
</table>
<form action="" name="myForm" method="post">
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse" style="border-collapse:collapse">
                <tr class="ewttablehead">
				<td align="left" colspan="2">&nbsp;ตั้งค่าระบบสมาชิก</td> 
                </tr>
				
                <tr >
				 <td align="right" bgcolor="#FFFFFF" valign="top">การรับสมัคร : </td>
                <td height="20" align="left" bgcolor="#FFFFFF">
				<?php 
				  	$sql_chk = "select * from member_setting";
					$query = $db->query($sql_chk);
					if($db->db_num_rows($query)>0){
					   $rec=$db->db_fetch_array($query);
					 }
					?>
				<select name="set_type">
				<option value="1" <?php if($rec[set_type]=='1') echo 'selected'; ?>>สมัครแล้วเป็นสมาชิกทันที</option>
				<option value="2" <?php if($rec[set_type]=='2') echo 'selected'; ?>>สมัครแล้วยืนยันผ่าน E-Mail</option>
				<option value="3" <?php if($rec[set_type]=='3') echo 'selected'; ?>>สมัครแล้วรอการอนุมัติจาก Admin</option>
				</select>
				</tr>
				
				 <tr bgcolor="#FFFFFF">
						<td width="15%" align="center" ></td>
                  		<td height="20" align="left" ><input type="hidden" name="flag" value="save"><input  type="submit" value="บันทึก"></td>
                </tr>
</table>
</form>
</body>
</html>
<?php

$db->db_close(); ?>