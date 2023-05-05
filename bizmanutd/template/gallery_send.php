<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$lang_sh1 = explode('___',$_REQUEST[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
	include("language/language".$lang_sh.".php");
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
  <th>URL  :<a href="'.$page.'" target="_blank">'.$page.'</a></th>
 </tr>
 <tr>
  <th>ข้อความที่เพื่อนคุณฝากถึง  :'.$detail.'</th>
 </tr>
</table>
</body>
</html>
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
alert('<?php echo $text_GenGallery_alertsentmail;?>');
window.close();
//location=('<?php//=$page?>');
</script>
<?php

}
?>

<html>
<head>
<title><?php echo $text_GenGallery_sandtofriend;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
	color: #99CC00;
}
-->
</style>

<script>
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
<script language="JavaScript">
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
      <td colspan="2" background="mainpic/guestbook/hi_box_ci7.gif" class="mytext_normal">
        <span class="style1"><li><?php echo $text_GenGallery_sandtofriend;?> </li></span>
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
      <input type="hidden" name="page" value="<?php echo $HTTP_REFERER;?>">
	   <input type="hidden" name="filename" value="<?php echo $_REQUEST[filename];?>"></td></tr>
    <tr bgcolor="#FFFFFF">
      <td colspan="2" background="mainpic/guestbook/bg_low.gif">&nbsp;</td>
    </tr>
  </table>
  <script language="JavaScript">
			document.send_mail.page.value = window.opener.document.URL;
		</script>
</form>
</body>
</html>

