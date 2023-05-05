<?php
$path = "../";
include($path."lib/function.php");
include($path."lib/user_config.php");
include($path."lib/connect.php");
include($path."language/language.php");

$query =$db->query( "SELECT * FROM site_info ");
$R=$db->db_fetch_array($query );
$txt_website_of_name=$R[site_top];
$txt_website_of_name1=$R[site_bottom];

 $query =$db->query( "SELECT * FROM faq WHERE fa_id = '$fa_id' ");
$R=$db->db_fetch_array($query );

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
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
.style1 {
	color: #0000FF;
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
<title>FAQ...</title></head>

<body >
<div align="center">
  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
  
    <tr valign="top">
      <td width="100%"><br>        
      <br>
      <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	   <tr >
          <td align="left" valign="top"><img src="../mainpic/faq.gif" width="64" height="80" alt="FAQ"><span class="style1"><?php echo $txt_website_of_name;?></span></td>
        </tr>
        <tr>
          <th scope="col"><table width="98%" border="0"  cellpadding="3" cellspacing="1" class="normal_font">
			<tr class="head_font">
              <td width="19%" valign="top"><?php echo $text_genfaq_question2;?> : </td>
              <td width="81%" align="left"> <? echo nl2br($R[fa_name]); ?> </td>
            </tr>
            <tr >
              <td valign="top"><?php echo $text_genfaq_detail;?> : </td>
              <td width="81%" align="left" valign="top"> <? if($R[fa_detail] != ''){ echo nl2br($R[fa_detail]); }else { echo '-';} ?> </td>
            </tr>
            <tr >
              <td valign="top"><?php echo $text_genfaq_answer ;?> : </td>
              <td align="left"> <? echo nl2br($R[fa_ans]); ?> </td>
            </tr>
          </table></th>
        </tr>
         <tr  id="tr_print">
          <td align="center"><form name="form1" method="post" action="faq_send.php">
            <input type="button" name="Submit3" value="<?php echo $text_general_print;?>"  onClick="tr_print.style.display='';window.print();tr_print.style.display='none';">
          </form></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr >
          <td align="center"><hr></td>
        </tr>
        <tr>
          <td align="center"><p><?php echo $txt_website_of_name1;?></p></td>
        </tr>
      </table> <table width="100%" border="0">
      <tr>
        <td align="center">	<?php include("include_logo_w3c_template2.php");?>	<?php  include("ewt_span.php");?></td>
      </tr>
    </table></td>
    </tr>
  </table>
</div>
</body>
</html>
