<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
function random_code($len){
srand((double)microtime()*10000000);
$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
$ret_str = "";
$num = strlen($chars);
for($i=0;$i<$len;$i++){
$ret_str .= $chars[rand()%$num];
}
return $ret_str;
}
if($_POST["flag"]=='add'){
$Execsql = $db->query("INSERT INTO w_name (w_name) values ('".strtolower(addslashes(htmlspecialchars($_POST["txt_name"])))."')");
?>
<script language="JavaScript">
alert("บันทึกเรียบร้อย");
window.location.href = "user_noused.php";

</script>
<?php
}else if($_POST["flag"]=='edit'){
	$sql_update =$db->query("update w_name set w_name = '".strtolower(addslashes(htmlspecialchars($_POST["txt_name"])))."' where w_name_id = '".$_POST["id"]."'  ");
?>
<script language="JavaScript">
alert("แก้ไขเรียบร้อย");
window.location.href = "user_noused.php";

</script>
<?php
}else if($_GET["flag"]=='del' && !empty($_GET["id"])){
$sql_delete = $db->query("delete FROM w_name where w_name_id = '".$_GET["id"]."'");
?>
<script language="JavaScript">
alert("ลบเรียบร้อย");
window.location.href = "user_noused.php";
</script>
<?php
exit;
}
if(!empty($_GET["id"])){
$sql = "select *  from w_name where w_name_id = '".$_GET["id"]."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$name = $rec[w_name];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
.style3 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<form action="?" method="post" enctype="multipart/form-data" name="form1" onSubmit="return CHK(this);">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"><span class="ewtfunction"> กำหนดชื่อที่ห้ามใช้</span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="user_noused.php">&nbsp;&nbsp;&nbsp;<img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> กลับ</a>&nbsp;
      <hr>
    </td>
  </tr>
</table>

  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
   <tr>
      <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ชื่อที่ห้ามใช้</td>
    </tr>
    <tr>
      <td width="27%" bgcolor="#FFFFFF" class="MemberHead">ชื่อที่ห้ามใช้ :<span style="color:#FF0000">*</span></td>
      <td width="73%" bgcolor="#FFFFFF"><input name="txt_name" type="text" id="txt_name"  value="<?php echo $name;?>"></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="บันทึก">
      <input type="hidden" name="flag" value="<?php echo $_GET["flag"];?>"> 
	  <input type="hidden" name="id" value="<?php echo $_GET["id"];?>"></td>
    </tr>
  </table>
</form>
</body>
</html>
<script language="javascript1.2">
function CHK(t){

	if(t.txt_name.value == ''){
	alert("กรุณาใส่ชื่อที่ห้ามใช้");
	return false;
	}
	//if(t.name.value==''){
	//alert("กรุณาใส่ชื่อ emotion");
	//return false;
	//}
}
</script>
<?php $db->db_close(); ?>