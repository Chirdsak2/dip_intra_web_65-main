<?php
$path = "../";
	session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("../language/language.php");
	include("ewt_template.php");
	$db->access=200;
	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");
	 $query =$db->query( "SELECT * FROM faq WHERE fa_id = '$fa_id' ");
$R=$db->db_fetch_array($query );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link id="stext" href="../css/normal.css" rel="stylesheet" type="text/css">
<link  href="../css/interface.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
<title>FAQ...</title></head>

<body>

  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td width="100%" align="center"><br>        
      <br>
      <table width="90%" border="0"  cellpadding="0" cellspacing="0">
        <tr>
          <th scope="col">
		   <table width="98%" border="0"  cellpadding="0" cellspacing="1" bgcolor="#B07331" class="normal_font">
				 <tr bgcolor="#FFFFFF">
				  <td colspan="2" align="left" valign="TOP"><img src="../mainpic/faq.gif" width="64" height="80"  alt="FAQ"><h1>FAQ</h1></td>   
				</tr>
			</table>
		      <table width="98%" border="0"  cellpadding="3" cellspacing="1" bgcolor="#B07331" class="normal_font">
			<tr bgcolor="#3399FF" class="head_font">
              <td width="19%" bgcolor="#FFDA45" ><?php echo $text_genfaq_question2;?></td>
              <td width="81%" align="left" bgcolor="#FFDA45" > <? echo preg_replace ($search, $replace,nl2br($R[fa_name])); ?> </td>
            </tr>
            <tr bgcolor="#F7F7F7">
              <td><?php echo $text_genfaq_detail;?></td>
              <td width="81%" align="left" valign="top"> <? echo preg_replace ($search, $replace,nl2br($R[fa_detail])); ?> </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td><?php echo $text_genfaq_answer ;?></td>
              <td align="left"> <? echo preg_replace ($search, $replace,nl2br($R[fa_ans])); ?> </td>
            </tr>
          </table></th>
        </tr>
        <tr  id="tr_print">
          <td><form name="form1" method="post" action="faq_send.php">
            <input type="button" name="Submit3" value="<?php echo $text_general_print;?>"  onClick="window.location.href='faq_print.php?fa_id=<?php echo $fa_id;?>';">
            <input type="button" name="Submit2" value="<?php echo $text_general_closethis;?>"  onClick="window.close();"> 
            <input type="submit" name="Submit" value="<?php echo $text_general_senttofriend;?>"  >
          </form></td>
        </tr>
      </table>  <table width="100%" border="0">
      <tr>
        <td align="center">	<?php include("include_logo_w3c_template2.php");?>	<?php  include("ewt_span.php");?></td>
      </tr>
    </table></td>
    </tr>
  </table>

</body>
</html>
