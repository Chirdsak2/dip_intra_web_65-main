<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<title>Verify</title></head>
<script language="javascript1.1">
	function plustext(){
		var txt = "";
		var allDIV =window.opener.iframe_data.document.getElementsByTagName("DIV");
		 for (i=0; i < allDIV.length; i++) {
			txt  = txt + allDIV[i].id;
		}
		return txt;
	}
function chk(){
	if(document.form_verify.chkpic1.value == ""){
	alert("กรุณาใส่อักษรภาพ!");
	return false;
	}else{
	window.opener.iframe_data.auto_save.document.form1.tagdetect.value=plustext();
	window.opener.iframe_data.auto_save.document.form1.verify.value = document.form_verify.chkpic1.value;
	window.opener.iframe_data.auto_save.form1.submit();
	window.close();
	}
}
</script>
<body >
<table width="400" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FF9933">
  <tr>
    <td><table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
      <form action="" method="post" name="form_verify" id="form_verify" >
        <tr bgcolor="#FFFFFF">
          <td height="30" colspan="2"><br ><strong>กรุณาใส่อักษรภาพที่ปรากฏ</strong><br ><hr ></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="137">ภาพ :</td>
          <td width="248"><span id="logpic"><img src="ewt_pic.php" align="absmiddle" /></span>
              <input type="button" name="Submit3" value="เลือกภาพใหม่" onclick="document.all.logpic.innerHTML = '&lt;img src=ewt_pic.php align=absmiddle&gt;';" /></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>พิมพ์ตัวอักษรที่อยู่ในภาพ :</td>
          <td><input name="chkpic1" type="text" id="chkpic1" size="8" maxlength="8" /></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>&nbsp;</td>
          <td><input type="button" name="Button" value="ตกลง"  onclick="chk();"></td>
        </tr>
      </form>
    </table></td>
  </tr>
</table>
</body>
</html>
