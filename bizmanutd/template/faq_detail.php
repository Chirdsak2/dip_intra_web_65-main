<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("language/language.php");
$fa_id=$_GET['fa_id'];
 $query =$db->query( "SELECT * FROM faq WHERE fa_id = '$fa_id' ");
$R=$db->db_fetch_array($query );
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link id="stext" href="css/normal.css" rel="stylesheet" type="text/css">
<link  href="css/interface.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
<title>FAQ...</title></head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td width="100%"><br>        
      <br>
      <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th scope="col">
		   <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B07331" class="normal_font">
				 <tr bgcolor="#FFFFFF">
				  <td colspan="2" valign="TOP"><img src="mainpic/faq.gif" height="40"  align="absmiddle"><font size="3"><strong>FAQ</strong></font>  </td>   
				</tr>
			</table>
		      <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B07331" class="normal_font">
						<tr bgcolor="#3399FF" class="head_font">
              <td width="19%" bgcolor="#FFDA45" background="mainpic/toolbars.gif" style="background-repeat:no-repeat;"><?php echo $text_genfaq_question2;?></td>
              <td width="81%" bgcolor="#FFDA45" background="mainpic/toolbars.gif" style="background-repeat:no-repeat;"> <?php echo nl2br($R[fa_name]); ?> </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td>ผู้ถาม</td>
              <td> <?php echo nl2br($R[fa_user_ask]);
												echo ($R['fa_user_ask_email']!='')?' - '.$R['fa_user_ask_email ']:''; ?> </td>
            </tr>
            <tr bgcolor="#3399FF" class="head_font">
              <td width="19%" bgcolor="#FFDA45" background="mainpic/toolbars.gif" style="background-repeat:no-repeat;">คำตอบ</td>
              <td width="81%" bgcolor="#FFDA45" background="mainpic/toolbars.gif" style="background-repeat:no-repeat;"> <?php echo nl2br($R[fa_ans]); ?> </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td>ผู้ตอบ</td>
              <td> <?php echo nl2br($R[fa_user_ans]); ?> </td>
            </tr>
          </table></th>
        </tr>
        <tr  id="tr_print">
          <td align="center"><form name="form1" method="post" action="faq_send.php">
            <input type="button" name="Submit3" value="<?php echo $text_general_print;?>"  onClick="window.location.href='faq_print.php?fa_id=<?php echo $fa_id;?>';">
            <input type="button" name="Submit2" value="<?php echo $text_general_closethis;?>"  onClick="window.close();"> 
            <!--input type="submit" name="Submit" value="<?php //echo $text_general_senttofriend;?>"  >
			<input type="button" name="Submit4" value="<?php //echo 'ส่งคำถามเพิ่มเติม';?>" onClick="window.location.href='faq_answer.php?fa_id=<?php //echo $fa_id;?>';" -->
          </form></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>
