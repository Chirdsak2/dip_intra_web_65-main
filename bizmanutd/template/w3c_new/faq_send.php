<?php
$path = "../";
include($path."lib/function.php");
include($path."lib/user_config.php");
include($path."lib/connect.php");
if($send){
$to  =$email_to;
$subject = "คุณ  ".$name_from."   ได้ส่ง  FAQ ที่น่าสนใจให้คุณ  ".$name_to;
$message = '
<html><head><title>เพื่อนอยากให้คุณดู</title></head><body>
<table>
 <tr> <th>URL  :<a href="'.$page.'" target="_blank">'.$page.'</a></th></tr>
 <tr><th>ข้อความที่เพื่อนคุณฝากถึง  :'.$detail.'</th></tr>
</table>
</body></html>
';

/* To send HTML mail, you can set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n"; 
 $headers .= "Content-Type: text/html; charset='UTF-8' \r\n"; 
/* additional headers */
$headers .= "From: ".$name_from." <".$email_from.">\r\n";
/* and now mail it */
@mail($to, $subject, $message, $headers);
   ?>
<script>
alert('ส่ง E-mail เรียบร้อยแล้ว');
location=('<?php echo $page?>');
</script>
<?php

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title>ส่งให้เพื่อน</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link id="stext" href="css/normal.css" rel="stylesheet" type="text/css">
<link  href="css/interface.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript">
function chk_input(){
		if(document.send_mail.email_from.value == '' ){
				alert('กรุณาระบุ e-mail ผู้ส่ง');
				return false;
		}else if(document.send_mail.email_to.value == '' ){
				alert('กรุณาระบุ e-mail ผู้รับ');
				return false;
		}else{
			return true;
		}
}
</script>
 <script language="javascript" type="text/javascript" >
function chk_mail(mail,N){
						if(mail){
						var goodEmail = mail.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)|(\..{2,2}))$)\b/gi);
						if (goodEmail){					
						} else {
							alert('กรุณากรอกรูปแบบ Email ให้ถูกต้อง')
						document.getElementById( N ).focus();
							return false;
						}
					}
		}
</script>
</head>

<body>
<form name="send_mail" method="post" action="">
  <br>
  
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B07331" class="normal_font">
	 <tr bgcolor="#FFDA45">
	  <td colspan="2" valign="TOP" ><img src="../mainpic/mail2.gif" width="24" height="24"  alt="mail"><font size="2"><strong> ส่งต่อให้เพื่อน</strong></font>  </td>   
	</tr>
</table><br>

  <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
    <tr bgcolor="#FFFFFF">
      <td width="31%" >ชื่อผู้ส่ง</td>
      <td width="69%" ><input name="name_from" type="text" size="30"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>e-mail ผุ้ส่ง </td>
      <td><input name="email_from" type="text" size="30" onBlur="chk_mail(this.value,this.name);"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>ชื่อผู้รับ</td>
      <td><input name="name_to" type="text" size="30"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>e-mail ผู้รับ</td>
      <td><input name="email_to" type="text" size="30"  onBlur="chk_mail(this.value,this.name);"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>รายละเอียด</td>
      <td><textarea name="detail" cols="30" rows="5"></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td><input type="submit" name="send" value="  ส่ง  " onClick=" return chk_input();">
      <input type="hidden" name="page" value="<?php echo $HTTP_REFERER;?>"></td>
    </tr> 
  </table>
  <a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</form>
</body>
</html>

