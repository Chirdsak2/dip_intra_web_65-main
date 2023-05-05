<?php
	session_start();
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");


	$db->query("USE ".$EWT_DB_NAME_MOTS);
	
	if($_POST[proc]=='save'){
		$db->query("UPDATE faq_config SET email = '".$_POST[email]."'");
	}
	
	$rec = $db->db_fetch_array ($db->query("select * from faq_config")); 
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="style_calendar.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
}
function validEMail(mo){
		if (validLength(mo,1,50)){
			if (mo.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
				return true;
			else return false;
 		}
		return true;
}
function chkinput(){
	if(document.frm1.email.value == ''){
	alert("กรุณากรอก E-mail !");
	return false;
	}
	if(frm1.email.value != '' && !validEMail(frm1.email.value.toLowerCase())){
		
		alert('กรุณากรอกรูปแบบ Email  ให้ถูกต้อง')
		frm1.email.focus()
		frm1.email.select()
		return false;
	}
return true;
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
	<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr><td><img src="../theme/main_theme/calendar_function.gif" width="32" height="32" align="absmiddle"><span class="ewtfunction">&nbsp;ตั้งค่าปฏิทิน</span> </td></tr>
	</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ตั้งค่าเมลล์ผู้ดูแล");?>&module=calendar&url=<?php echo urlencode("calendar_config.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<hr>
    </td>
  </tr>
</table>

		<form name="frm1" action="" method="post" onSubmit="return chkinput();">
  <table width="64%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="67%" colspan="2" ><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewttableuse" style="border-collapse:collapse">
                  <tr>
                    <td>
                      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#B2B2B2" >
                <tr class="ewttablehead"> 
                  <td colspan="2"><span class="ewtfunction">ตั้งค่าเมลล์ผู้ดูแล</span></td>
                </tr>
                <tr> 
                  <td width="28%" align="left" bgcolor="#FFFFFF">อีเมล์ของผู้ดูแล</td>
                  <td width="72%" align="left" bgcolor="#FFFFFF"><input name="email" type="text" size="50" id="email" value="<?php echo $rec[email];?>"></td>
                </tr>
                <tr align="right"> 
                  <td colspan="2" align="center" bgcolor="#FFFFFF"> <input name="Submit" type="submit" value="บันทึก"  >
                  <input type="hidden" name="proc" value="save"></td>
                </tr>
              </table></td>
                  </tr>
              </table></td>
    </tr>
  </table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp;
    </td>
  </tr>
</table>
<!--
	<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
		<tr><td align="right"><a href="calendar_addedit_category.php?flag=add"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0" alt="<?php echo $text_gencalendar_addcat ;?>"><font style="color:#000000"> <?php echo $text_gencalendar_addcat ;?></font></a><hr></td></tr>
	</table> -->
<br>
		</form>
</body>
</html>
<?php $db->db_close();  ?>