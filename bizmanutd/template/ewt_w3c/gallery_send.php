<?php
$path = '../';
session_start();
include($path."lib/function.php");
include($path."lib/user_config.php");
include($path."lib/connect.php");
$lang_sh1 = explode('___',$_REQUEST[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
	include("../language/language".$lang_sh.".php");
if($send){
//$subject = "คุณ  ".$name_from."   ได้ส่ง  Gallery ที่น่าสนใจให้คุณ  ".$name_to;
//$message ="URL  :".$page."<BR>";
//$message .=$detail;
/* recipients */
$to  =$email_to;

/* subject */
$subject = "เพื่อนอยากให้คุณดู";

/* message */
$message = '
<html>
<head>
 <title>เพื่อนอยากให้คุณดู</title>
</head>
<body>
<table>
 <tr>
  <th>คุณ  '.$name_from.'   ได้ส่ง  Gallery ที่น่าสนใจให้คุณ  '.$name_to.'</th>
 </tr>
 <tr>
  <th>URL  :<a href="'.$page.'" target="_blank" accesskey=a>'.$page.'</a></th>
 </tr>
 <tr>
  <th>ข้อความที่เพื่อนคุณฝากถึง  :'.$detail.'</th>
 </tr>
</table>
</body>
</html>
';
	include('../lib/libmail.php');
	$m = new Mail();
	$m->From($name_from."<".$email_from.">");
	$m->Subject((iconv('UTF-8','UTF-8',$subject)));
	$m->Body($message,"UTF-8");
	$m->To(trim($to));
	@$m->Send();

   ?>
<script language="javascript" type="text/javascript">
alert('<?php echo iconv('UTF-8','UTF-8',$text_GenGallery_alertsentmail);?>');
window.close();
</script>
<?
exit;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
	color: #99CC00;
}
-->
</style>

<script language="javascript" type="text/javascript">
function chk_mail(mail,N){
						if(mail){
						var goodEmail = mail.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)|(\..{2,2}))$)\b/gi);
						if (goodEmail){					
						} else {
							alert('<?php echo $text_GenGallery_alertinputemail;?>')
						document.getElementById( N ).focus();
							return false;
						}
					}
		}
</script>
<script language="javascript" type="text/javascript">
function chk_input(){
		if(document.send_mail.email_from.value == '' ){
				alert('<?php echo $text_GenGallery_alertinputusersent;?>');
				return false;
		}else if(document.send_mail.email_to.value == '' ){
				alert('<?php echo $text_GenGallery_alertinputuserresive;?>');
				return false;
		}else{
			return true;
		}
}
</script>
</head>

<body>
<form name="send_mail" method="post" action="">
  <br>
  <table width="88%" border="0" align="center" cellpadding="3" cellspacing="1">
   <tr bgcolor="#FFFFFF">
      <td colspan="2"  class="mytext_normal">
        <span class="style1"><?php echo $text_GenGallery_sandtofriend;?> </span>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="22%" ><?php echo $text_GenGallery_usersent;?> :&nbsp;&nbsp; </td>
      <td width="78%" ><input name="name_from" type="text" size="30"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td><?php echo $text_GenGallery_mailsent;?> :&nbsp;&nbsp; </td>
      <td><input name="email_from" type="text" size="30" onBlur="chk_mail(this.value,this.name);"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td><?php echo $text_GenGallery_userresive;?> :&nbsp;&nbsp; </td>
      <td><input name="name_to" type="text" size="30"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td><?php echo $text_GenGallery_mailreceive;?> :&nbsp;&nbsp; </td>
      <td><input name="email_to" type="text" size="30"  onBlur="chk_mail(this.value,this.name);"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td><?php echo $text_GenGallery_detail;?> :&nbsp;&nbsp; </td>
      <td><textarea name="detail" cols="30" rows="5"></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="send" value="    <?php echo $text_GenGallery_sentto;?>    " onClick=" return chk_input();">
      <input type="hidden" name="page" value="<?=$HTTP_REFERER;?>">
	   <input type="hidden" name="filename" value="<?=$_REQUEST[filename];?>"></td></tr>
    <tr bgcolor="#FFFFFF">
      <td colspan="2">&nbsp;</td>
    </tr>
  </table> <table width="100%" border="0">
      <tr>
        <td align="center">	<?php include("include_logo_w3c_template2.php");?>	
		<script language="javascript" type="text/javascript">
			document.send_mail.page.value = window.opener.document.URL;
		</script></td>
      </tr>
    </table>

</form>
</body>
</html>

