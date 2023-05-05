<?php
$path = "../";
	session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("../language/language.php");
	include("ewt_template.php");
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
				  <td colspan="2" align="left" valign="TOP"><img src="../mainpic/faq.gif" width="64" height="80"  alt="FAQ"><font size="3"><strong>FAQ</strong></font>  </td>   
				</tr>
			</table>
		      <table width="98%" border="0"  cellpadding="3" cellspacing="1" bgcolor="#B07331" class="normal_font">
			<tr bgcolor="#3399FF" class="head_font">
              <td width="19%" bgcolor="#FFDA45" ><?php echo $text_genfaq_question2;?></td>
              <td width="81%" align="left" bgcolor="#FFDA45" > <?php echo nl2br($R[fa_name]); ?> </td>
            </tr>
            <tr bgcolor="#F7F7F7">
              <td><?php echo $text_genfaq_detail;?></td>
              <td width="81%" align="left" valign="top"> <?php echo nl2br($R[fa_detail]); ?> </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td><?php echo $text_genfaq_answer ;?></td>
              <td align="left"> <?php echo nl2br($R[fa_ans]); ?> </td>
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
      </table>  <a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?></td>
    </tr>
  </table>

</body>
</html>
