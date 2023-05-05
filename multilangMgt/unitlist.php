<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
include("../lib/set_lang.php");
if($_POST[flag]=='set_lang'){
	for($i=0;$i<$_POST[num];$i++){
		set_lang($_POST[c_id],$_POST[lang_name],$_POST[lang_field][$i],$_POST[lang_detail][$i],$module);
	}
	?>
      <script language="JavaScript">
		  alert('บันทึกข้อมูลเรียร้อย');
          location.href='../MemberMgt/unitList.php';
     </script>
   <?php
   exit;
}
$modulename = 'org_name';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chk(){
	if(document.form1.lang_name.value == ""){
		alert("Please insert languang!!");
		document.form1.lang_name.focus();
		return false;
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="unitList.php" onSubmit="return chk();">
  <?php
 $sql = $db->query("SELECT * FROM org_name where org_id  = '$id' ");
$R = mysql_fetch_array($sql);
$LastTopic=$R[name_org];
$Lastshort_name=$R[short_name];
$Lastdesription=$R[desription];
$Lastorg_object=$R[org_object];
$Lastorg_place=$R[org_place];
$Lastorg_address=$R[org_address];
 
  ?>
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle" /> <span class="ewtfunction">บริหารหน่วยงาน</span> </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"> <a href="../MemberMgt/unitList.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle" />กลับ</a> 
          <hr />
      </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"><a href="javascript:void(0);" onClick="document.getElementById('nav').style.display='none';"></a></td>
      </tr>
    </table>
    <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#999999" class="ewttableuse">
  <tr>
    <th height="23" colspan="4" bgcolor="#FFFFFF" class="ewttablehead" scope="col"><div align="left">&bull;&nbsp;กรุณาใส่ภาษาตามที่ท่านเลือก(<?php echo $_GET[lang];?>)</div></th>
  </tr>

  <tr>
    <td width="21%" height="11" valign="top" bgcolor="#FFFFFF">ชื่อหน่วยงาน : <strong style="color:#FF0000"></strong></td>
    <td width="32%" height="0" bgcolor="#FFFFFF"><input name="lang_detail[0]" type="text" size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'name_org',$modulename);?>"><input type="hidden" name="lang_field[0]" value="name_org"></td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="45%" bgcolor="#FFFFFF"><?php echo $LastTopic;?></td>
  </tr>
  <tr>
    <td height="10" valign="top" bgcolor="#FFFFFF">ชื่อย่อหน่วยงาน : </td>
    <td width="32%" height="0" bgcolor="#FFFFFF"><input name="lang_detail[1]" type="text" class="normal_font" id="lang_detail[1]" size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'short_name',$modulename);?>"><input type="hidden" name="lang_field[1]" value="short_name"></td>
    <td width="2%" height="20" rowspan="7" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="45%" height="0" bgcolor="#FFFFFF"><?php echo $Lastshort_name;?></td>
  </tr>
  <tr>
    <td height="10" valign="top" bgcolor="#FFFFFF">คำอธิบาย : </td>
    <td width="32%" height="0" bgcolor="#FFFFFF"><textarea name="lang_detail[2]" cols="50" rows="5"><?php echo select_lang_detail($_GET[id],$_GET[langid],'desription',$modulename);?></textarea><input type="hidden" name="lang_field2]" value="desription"></td>
    <td width="45%" height="0" bgcolor="#FFFFFF"><?php echo $Lastdesription;?></td>
  </tr>
  <tr>
    <td height="20" valign="top" bgcolor="#FFFFFF">วัตถุประสงค์และภารกิจ :</td>
    <td width="32%" height="0" bgcolor="#FFFFFF"><textarea name="lang_detail[3]" cols="50" rows="5"><?php echo select_lang_detail($_GET[id],$_GET[langid],'org_object',$modulename);?></textarea><input type="hidden" name="lang_field[3]" value="org_object"></td>
    <td width="45%" height="0" bgcolor="#FFFFFF"><?php echo $Lastorg_object;?></td>
  </tr>
  <tr>
    <td height="20" valign="top" bgcolor="#FFFFFF">สถานที่ตั้ง :</td>
    <td width="32%" height="0" bgcolor="#FFFFFF"><textarea name="lang_detail[4]" cols="50" rows="5"><?php echo select_lang_detail($_GET[id],$_GET[langid],'org_place',$modulename);?></textarea><input type="hidden" name="lang_field[4]" value="org_place"></td>
    <td width="45%" height="0" bgcolor="#FFFFFF"><?php echo $Lastorg_place;?></td>
  </tr>
  <tr>
    <td height="20" valign="top" bgcolor="#FFFFFF">ที่อยู่ :</td>
    <td width="32%" height="0" bgcolor="#FFFFFF"><textarea name="lang_detail[5]" cols="50" rows="5"><?php echo select_lang_detail($_GET[id],$_GET[langid],'org_address',$modulename);?></textarea><input type="hidden" name="lang_field[5]" value="org_address"></td>
    <td width="45%" height="0" bgcolor="#FFFFFF"><?php echo $Lastorg_address;?></td>
  </tr>
   <tr>
    <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="23" colspan="3" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="Submit" value="บันทึก">
      
      <input type="hidden" name="flag" value="set_lang">
      <input type="hidden" name="num" value="<?php echo '5';?>">
      <!--<input type="hidden" name="c_parent" value="<?php//php echo $R[category_id];?>">-->
      <input type="hidden" name="c_id" value="<?php echo $_GET[id]?>">
      <input type="hidden" name="lang_name" value="<?php echo $_GET[langid]?>">
      <input type="hidden" name="module" value="<?php echo $modulename;?>"></td></tr>
</table></td>
  </tr>
</table>

</form>
</body>
</html>