<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PopUp Windows</title>
<SCRIPT LANGUAGE="JavaScript">
function customize(form,Flag) { 
var address = document.getElementById('path').value+document.getElementById('url').value;
var op_tool = (document.form1.tool.checked== true) ? 1 : 0; 
var op_loc_box = (document.form1.loc_box.checked == true) ? 1 : 0; 
var op_stat = (document.form1.stat.checked == true) ? 1 : 0; 
var op_menu = (document.form1.menu.checked == true) ? 1 : 0; 
var op_scroll = (document.form1.scroll.checked == true) ? 1 : 0; 
var op_resize = (document.form1.resize.checked == true) ? 1 : 0; 
var op_wid = document.form1.wid.value; 
var op_heigh = document.form1.heigh.value; 
var option = "width=" + op_wid +",height="+ op_heigh +",toolbar="+ op_tool +",location="+ op_loc_box +",status="+ op_stat +",menubar="+ op_menu +",scrollbars=" + op_scroll +",resizable=" + op_resize;
if(Flag == '0'){
var win3 = window.open("", "what_I_want", option); 
var win4 = window.open(address, "what_I_want");
}else{
var fulltext = "<"+"script type=\"text/javascript\">window.open('"+ address +"','','"+ option +"');<"+"/script>";
window.opener.document.htmlform.contentHtml.value = window.opener.document.htmlform.contentHtml.value + fulltext;
window.close();
}
}
function openAsset() { 
document.form1.url.value = window.showModalDialog('../FileMgt/link_index.php?stype=images&Flag=LinkReturn',window,
    "dialogWidth:780px;dialogHeight:540px;edge:Raised;center:1;help:0;resizable:1;name:real;");
}

</SCRIPT>
</head>

<body>
<table width="96%" align="center" border="0" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC" style="font-family:Tahoma; font-size:13px">
<FORM name="form1"   METHOD="POST">
  <tr>
    <td colspan="4" bgcolor="#FFFFFF">ตั้งค่า PopUp Windows </td>
    </tr>
  <tr>
    <td width="23%" bgcolor="#FFFFFF">หน้าเว็บที่ต้องการ</td>
    <td colspan="3" bgcolor="#FFFFFF"><INPUT NAME="url" TYPE="text" ID="url" value="" size="50" > <input type="button" value="" onClick="openAsset()" id="btnAsset" name="btnAsset" style="background:url('../ewt/scripts/openAsset.gif');width:23px;height:18px;border:#a5acb2 1px solid;margin-left:1px;"></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">ความกว้าง</td>
    <td colspan="3" bgcolor="#FFFFFF"><INPUT NAME="wid" TYPE="text" value="450" size="5" ></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">ความสูง</td>
    <td colspan="3" bgcolor="#FFFFFF"><INPUT NAME="heigh" TYPE="text" value="300" size="5"  ></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF"><INPUT TYPE="checkbox" NAME="tool"></td>
    <td width="27%" bgcolor="#FFFFFF">Toolbar</td>
    <td width="9%" align="right" bgcolor="#FFFFFF"><INPUT TYPE="checkbox" NAME="scroll"></td>
    <td width="41%" bgcolor="#FFFFFF">Scrollbars</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF"><INPUT TYPE="checkbox" NAME="loc_box"></td>
    <td bgcolor="#FFFFFF">Location</td>
    <td align="right" bgcolor="#FFFFFF"><INPUT TYPE="checkbox" NAME="resize"></td>
    <td bgcolor="#FFFFFF">Resizable</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF"><INPUT TYPE="checkbox" NAME="stat"></td>
    <td bgcolor="#FFFFFF">Status</td>
    <td align="right" bgcolor="#FFFFFF"><INPUT TYPE="checkbox" NAME="menu"></td>
    <td bgcolor="#FFFFFF">Menubar</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td colspan="3" bgcolor="#FFFFFF"><input type="button" name="Button" value="Preview" OnClick="customize(this.form,'0')">
      <input type="button" name="Submit2" value="  Save  " OnClick="customize(this.form,'1')"></td>
  </tr></FORM>
</table>
</CENTER>
<?php
	$db->query('USE '.$EWT_DB_USER);
	$qPath=$db->query('SELECT url FROM user_info WHERE UID = \''.$EWT_SUID.'\'');
	$rPath=$db->db_fetch_array($qPath);
	$path=$rPath[0];
	$db->query('USE '.$EWT_DB_NAME);
?>
<input type="hidden" name="path" id="path" value="<?php echo $path; ?>" />
</body>
</html>
<?php $db->db_close(); ?>