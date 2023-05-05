<?php
session_start();

?>
<html>


<script language="JavaScript" type="text/JavaScript">
function chknull(a){
if(a.member_email.value==''){
		alert('กรุณาระบุ E-mail');
		a.member_card.focus();
		return false;
	}
}

function mail_format(obj){
		var goodEmail1 = obj.value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)|(\..{2,2}))$)\b/gi);
		 if (!goodEmail1){
			alert('รูปแบบ E-mail  ไม่ถูกต้อง')
			obj.focus()
			obj.select()
			return false;
		}
}
</script>
<title>ลืมรหัสผ่าน</title>
<style type="text/css">
<!--
BODY {
	FONT-SIZE: 11px; MARGIN: 0px; COLOR: #000000; FONT-FAMILY: "Tahoma"
}
.copyright {
	COLOR: #e1e1e1
}
A:link {
	COLOR: #000000; TEXT-DECORATION: none
}
A:visited {
	COLOR: #000000; TEXT-DECORATION: none
}
A:active {
	COLOR: #000000; TEXT-DECORATION: none
}
A:hover {
	COLOR: #000000; TEXT-DECORATION: none
}
.mytext_normal {
	FONT: 11px "Tahoma"
}
.myhead {
	FONT: 23px "Tahoma"
}
INPUT {
	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: "Tahoma"
}
TEXTAREA {
	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: "Tahoma"
}
TABLE {
	FONT: 11px "Tahoma"
}
SELECT {
	FONT: 11px "Tahoma"
}
-->
</style>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<form name="form1" method="post" action="ewt_login.php" onSubmit="return  chknull(this);">
  <br>
  <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
    <tr bgcolor="#E7E7E7"> 
      <td colspan="2"><div align="center"><strong>ลืมรหัสผ่าน </strong></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="15%"><strong>E-mail :<font color="#FF0000"></font></strong></td>
      <td width="85%"><input name="member_email" type="text" id="member_email" size="30"  onBlur="mail_format(this)"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td> <input name="บันทึก" type="submit" id="บันทึก" value="ตกลง"> <input type="reset" name="Submit2" value="ยกเลิก"> 
        <input type="hidden" name="Flag" value="forgot">
      </td>
    </tr>
  </table>
  <div align="center"></div>
</form>
</body>
</html>
