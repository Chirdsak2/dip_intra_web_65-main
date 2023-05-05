<?php
include("admin.php");

?>
<html>
<head>
<title>Vote</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="onbody.css" type="text/css">
</head>
<?php
$PollSel = $db->query("SELECT * FROM `poll_cat` WHERE  `c_id` = '$cad_id' ");
$pollR = mysql_fetch_array($PollSel);
 ?>
<body leftmargin="0" topmargin="0">
<table width="450" height="310" border="0" cellpadding="2" cellspacing="0">
  <form name="form1" method="post" action="function_edit.php">
  <tr>
    <td height="30" valign="middle" bgcolor="#333333">
        
        <font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $text_genpoll_topic;?> : 
          </strong></font>        <input name="topic" type="text" id="topic" value="<?php echo stripslashes($pollR[c_name]); ?>" size="60" class="normal_font">
      </td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="0">
      <tr >
        <td colspan="2" height="10"></td>
        </tr>
		<?php 		
		$SelPoll = $db->query("SELECT * FROM `poll_ans` WHERE `c_id` = '$pollR[c_id]' ORDER BY `a_id` ASC"); 
		$i = 0;
while($pollAns = mysql_fetch_array($SelPoll)){
?>
      <tr>
        <td width="76"><font size="2" face="Tahoma"><?php echo $text_genpoll_Choice;?><?php echo $i+1; ?></font></td>
        <td width="370" ><input name="ans_name<?php echo $i; ?>" type="text" class="normal_font" id="ans_name<?php echo $i; ?>" value="<?php echo stripslashes($pollAns[a_name]); ?>" size="50">
          <input name="ans_id<?php echo $i; ?>" type="hidden" value="<?php echo $pollAns[a_id]; ?>"></td>
        </tr><?php $i++; } ?>
	  <tr >
        <td colspan="2" height="10"></td>
        </tr>
      <tr>
        <td colspan="2" bgcolor="#CCCCCC"><div align="right"><font size="2" face="Tahoma">
          <input name="cad_id" type="hidden" id="cad_id" value="<?php echo $cad_id; ?>">
          <input name="all" type="hidden" id="all" value="<?php echo $i; ?>">
          <input type="submit" name="Submit" value="<?php echo $text_general_submit;?>" class="normal_font">
        </font></div></td>
        </tr>
	  
    </table></td>
  </tr></form>
</table>
</body>
</html>
