<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");
if($_GET["flag"] == 'add'){
	$lable = 'เพิ่ม';
}else if($_GET["flag"] == 'edit'){
	$lable = 'แก้ไข';
	$sql_banner = "SELECT * FROM stat_population where p_id ='".$_GET["p_id"]."'";
	$rec = $db->db_fetch_array($db->query($sql_banner));
	$date_e = explode('-',$rec[p_date]);
	$ndate = $date_e[2].'/'.$date_e[1].'/'.($date_e[0]+543);
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
		  	function selColor(c,d){
				Win2=window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
			}
</script>
</head>
<script src="../js/jquery.min.js"></script>
<script language="javascript1.2">
	function CHK(t){
		if(t.g_subject.value == ''){
			alert("กรุณากรอก Subject!");
			t.g_subject.focus();
			return false;
		}
		if(t.g_width.value == ''){
			alert("กรุณากรอก Graph width!");
			t.g_width.focus();
			return false;
		}else{
			if(isNaN(t.g_width.value)){
				alert('กรุณากรอกตัวเลขเท่านั้น');
				t.g_width.focus();
				return false;
			}
		}
		if(t.g_height.value == ''){
			alert("กรุณากรอก Graph height!");
			t.g_height.focus();
			return false;
		}else{
			if(isNaN(t.g_height.value)){
				alert('กรุณากรอกตัวเลขเท่านั้น');
				t.g_height.focus();
				return false;
			}
		}
		
	}
</script>
<body leftmargin="0" topmargin="0">
<form action="graph_function.php"  method="post" enctype="multipart/form-data"   name="linkForm">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/banner_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">สร้างกราฟ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"> <a href="grap_main.php" target="_self"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php echo $text_genbanner_manage;?></a>
      <hr>
    </td>
  </tr>
</table>
  <table width="30%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999"  class="ewttableuse">
  <tr>
    <th height="23" colspan="2" class="ewttablehead"  scope="col"><div align="left"><?php echo $lable;?>สร้างกราฟ </div></th>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
  <td align="right"  width="30%">Subject : <font style="color:#FF0000"> *</font></td>
  <td  ><input name="g_subject" type="text" id="g_subject" value="Data Sheet" size="50"></td>
</tr>
<tr valign="top" bgcolor="#FFFFFF"> 
  <td align="right">Description : </td>
  <td><input name="g_desc" type="text" id="g_desc" value="Description" size="50"></td>
</tr>
<tr valign="top" bgcolor="#FFFFFF"> 
  <td align="right">Graph width : <font style="color:#FF0000"> *</font></td>
  <td><input name="g_width" type="text" id="g_width" value="400" size="5">
	Pixels </td>
</tr>
<tr valign="top" bgcolor="#FFFFFF">
  <td align="right">Graph height : <font style="color:#FF0000"> *</font></td>
  <td><input name="g_height" type="text" id="g_height" value="300" size="5">
	Pixels </td>
</tr>
<tr valign="top" bgcolor="#FFFFFF">
  <td align="right">Graph align : </td>
  <td><select name="g_align" id="g_align">
	  <option value="center" <?php if($R[graph_align] == "center"){ echo "selected"; } ?>>center</option>
	  <option value="left" <?php if($R[graph_align] == "left"){ echo "selected"; } ?>>left</option>
	  <option value="right" <?php if($R[graph_align] == "right"){ echo "selected"; } ?>>right</option>
	</select></td>
</tr>
<tr valign="top" bgcolor="#FFFFFF">
  <td align="right">Background color: </td>
  <td> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="21"><a id="CPreview1" style="background-color: <?php echo $R["graph_bgcolor"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.g_bgcolor.value','window.opener.document.all.CPreview1.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a></td>
		<td>&nbsp;<input name="g_bgcolor" type="text" id="g_bgcolor" value="#FFFFFF" size="7"></td>
	  </tr>
	</table></td>
</tr>
  <tr>
    <td height="23" bgcolor="#FFFFFF"></td>
    <td height="23" bgcolor="#FFFFFF"><label>
      <input type="submit" name="Submit" onclick="return CHK(document.linkForm);" value="<?php echo $text_genbanner_formupdate;?>">
&nbsp;&nbsp; </label>
      <input name="Flag" type="hidden" id="Flag" value="SaveGraph">
	  <input type="hidden" name="p_id" value="<?php echo $_GET[p_id]?>">
      </label></td>
  </tr>
</table>
<table width="90%" border="0" align="center">
  <tr>
    <th scope="col"><br>
      </th>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>
