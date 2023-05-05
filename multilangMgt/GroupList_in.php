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
          location.href='../MemberMgt/GroupList_in.php';
     </script>
   <?php
   exit;
}
$modulename = 'emp_type';
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
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="GroupList_in.php" onSubmit="return chk();">
  <?php
 $sql = $db->query("SELECT * FROM emp_type where emp_type_id  = '$id' and emp_type_status = '2' ");
$R = mysql_fetch_array($sql);
$LastTopic=$R[emp_type_name];
 
  ?>
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle" /><span class="ewtfunction">บริหารกลุ่มบุคคลภายใน</span></td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"> <a href="../MemberMgt/GroupList_in.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle" />กลับ</a> 
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
    <td width="21%" height="11" valign="top" bgcolor="#FFFFFF">ชื่อกลุ่ม : <span class="style1">* </span></td>
    <td width="32%" height="0" bgcolor="#FFFFFF"><input name="lang_detail[0]" type="text" size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'emp_type_name',$modulename);?>"><input type="hidden" name="lang_field[0]" value="emp_type_name"></td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="45%" bgcolor="#FFFFFF"><?php echo $LastTopic;?></td>
  </tr>
   <tr>
    <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="23" colspan="3" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="Submit" value="บันทึก">
      
      <input type="hidden" name="flag" value="set_lang">
      <input type="hidden" name="num" value="<?php echo '1';?>">
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