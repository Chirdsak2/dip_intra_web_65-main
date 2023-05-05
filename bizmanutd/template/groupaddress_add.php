<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$id = $_GET[id];
if($id != ''){
$lable = 'แก้ไข';
}else{
$lable = 'เพิ่ม';
}
?>
<html>
<head>
<title>Add To Favorite</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript">
function Send_Data(Data){
	self.parent.document.getElementById('gid').value=Data; 
}
function ChkGroup(t){
	if(t.ganame.value == ''){
	alert("กรุณากรอกชื่อกลุ่ม!!!!!!");
	return false;
	}
	return true;
}
</script></head>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="mainpic/m_address.gif" width="24" height="24" align="absmiddle"><span class="myhead_02">บริหารกลุ่ม Address </span></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="groupaddress_list.php"><img src="mainpic/m_home.gif" width="24" height="24" border="0" align="absmiddle">กลับ</a>
        <hr /></td>
  </tr>
</table>
<form name="form1" action="address_function.php" method="post" onSubmit="return ChkGroup(this);">
              <input type="hidden" name="process" value="<?php echo $process;?>">
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <?php
						$recedit=$db->db_fetch_array($db->query("SELECT * FROM n_groupaddress WHERE id = '".$id."'"));
						$ganame=$recedit['ganame'];
				?>
              <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
                <tr>
                  <td bgcolor="#CCCCCC" colspan="2"><strong><?php echo $lable;?>กลุ่ม</strong></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="23%" align="right"><strong>ชื่อกลุ่ม : </strong></td>
                  <td width="77%"><input type="text" name="ganame" value="<?php echo $ganame;?>" size="50"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" align="center" colspan="2"><input type="submit"name="Input2" class="submit" value="บันทึก">
                  &nbsp;</td>
                </tr>
              </table>
</form>
</body>
</html>
<?php  $db->db_close(); ?>
