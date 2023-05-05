<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
include("../language.php");
$fa_id = $_GET["fa_id"];
$sel = "SELECT * FROM faq WHERE  fa_id = '$fa_id' ORDER BY  faq_top DESC ,fa_id ASC";
$Show = $sel;
$Execsql = $db->query($Show); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top">
                <?php
   while($R = mysql_fetch_array($Execsql)){ 
	?>
                <table width="547" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><img src="../images/win_top.jpg" width="547" height="12"></td>
                  </tr>
                  <tr align="center">
                    <td background="../images/win_bg_bot.gif"><table width="450" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000" class="ewttableuse">
                        <tr  class="ewttablehead">
                          <td width="16%" background="../images/content_bg_left.gif"><?php echo $text_genfaq_ask;?>:</td>
                          <td width="84%" background="../images/content_bg_left.gif" ><?php biz($R[fa_name]); ?>                        </td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF"><?php echo $text_genfaq_categorydetail;?>:</td>
                          <td width="84%" bgcolor="#FFFFFF"><?php biz($R[fa_detail]); ?>                        </td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF"><?php echo $text_genfaq_answer;?>:</td>
                          <td bgcolor="#FFFFFF"><?php biz($R[fa_ans]); ?>                        </td>
                        </tr>
                        <tr >
                          <td bgcolor="#FFFFFF" ><?php echo $text_general_status;?>:</td>
                          <td bgcolor="#FFFFFF" ><?php if($R[faq_use]=='Y'){ echo $text_general_enable;  }else {echo $text_general_disable;} ?></td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF"  ><?php echo $text_general_introduce;?>:</td>
                          <td bgcolor="#FFFFFF"  ><?php if($R[faq_top]=='Y'){ echo $text_general_introduce;  }else {echo $text_general_notintroduce;} ?></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" bgcolor="#FFFFFF"  ><form name="form1" method="post" action="faq_send.php">
            <input type="button" name="Submit3" value="<?php echo $text_general_print ;?>"  onClick="tr_print.style.display='none';window.print();tr_print.style.display='';">
            <input type="button" name="Submit2" value="<?php echo $text_general_closepage;?>"  onClick="window.close();"> 
                          </form></td>
                        </tr>
                      
                                        </table></td>
                  </tr>
                  <tr>
                    <td><img src="../images/win_bot.jpg" width="547" height="13"></td>
                  </tr>
                </table>
                <br>
                  <?php } ?></td>
  </tr>
  </table>
</div>
</body>
</html>
