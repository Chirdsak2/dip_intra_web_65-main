<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//main data
$sid = $_GET["sid"];
$sql = "select s_type,s_column from menu_setting where s_id='".$sid."'";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
$show_type = $R["s_type"];
$show_column = $R["s_column"];
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script  language="javascript1.1" type="text/javascript">
function isNum (charCode) {
	if (charCode >= 48 && charCode <= 57 ) return true;
	else return false;
}
function chkFormatNam (str) {//0-9
	strlen = str.length;
	for (i=0;i<strlen;i++) {
		var charCode = str.charCodeAt(i);
		if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
			return false;
		}
	}
	return true;
}
function chkformatnum(t) { 
	_MyObj = t;
	_MyObj_Name = t.name;
	_MyObj_Value = t.value;
	_MyObj_Strlen =_MyObj_Value.length; 
	if( _MyObj_Strlen >1 && _MyObj_Value.substr(0,1)==0){
		t.value = _MyObj_Value.substr(1);
	}
	if(!chkFormatNam (t.value)){
		alert('กรุณากรอกตัวเลขเท่านั้น');
		t.value = 0;
		t.focus();
	} 
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="menu_sitemap_function.php">
<table width="100%" border="0">
<tr>
      <td bgcolor="#FFFFFF" colspan="2"> <strong>ตั้งค่าการแสดงผล</strong></td>
</tr>
  <tr>
    <td width="50%"><input type="radio" name="show_type" value="0" <?php if($show_type == "0"){ echo "checked"; } ?>>
        แบบมาตรฐาน</td>
    <td width="50%"><input type="radio" name="show_type" value="1"  <?php if($show_type == "1"){ echo "checked"; } ?>>
แบบมีการซ้อนเมนูย่อย</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><hr><strong>#ตั้งค่าเพิ่มเติม  </strong></td>
    </tr>
  <tr>
    <td colspan="2"><?php echo $text_gensmap_formline;?>
      <input name="map_col" type="text" size="7" value="<?php echo $show_column;?>" onKeyUp="chkformatnum(this)" ><?php echo $text_gensmap_formline2;?>
      (กรุณาระบุตัวเลขตั้งแต่ 1 ขึ้นไป)</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="Submit" value="Submit">
        <input name="Flag" type="hidden" id="Flag" value="SetDisp">
        <input name="sid" type="hidden" id="sid" value="<?php echo $_GET["sid"]; ?>"></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
</body>
</html>
<?php $db->db_close(); ?>
