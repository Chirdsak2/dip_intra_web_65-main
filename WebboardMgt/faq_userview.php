<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
include("../language.php");
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);
		 $sel = "SELECT   f_subcat.f_subcate,   faq_user.*
		FROM   f_subcat  INNER JOIN faq_user ON (f_subcat.f_sub_id = faq_user.f_sub_id) WHERE faq_user_id='".$_GET["faq_user_id"]."' ";

   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = $CO[c_number];

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = $db->query($Show); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" class="normal_font">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top">
	<DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"> 
                <p>
                  <?php
	  if($rows > 0){
   while($R = mysql_fetch_array($Execsql)){ 
	?>
                </p>
                <table width="547" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><img src="../images/win_top.jpg" width="547" height="12"></td>
                  </tr>
                  <tr align="center">
                    <td background="../images/win_bg_bot.gif"><table width="450" border="0" cellpadding="0" cellspacing="0" class="ewttableuse">
                      <tr bgcolor="#FFFFFF" class="ewttablehead">
                        <td height="20" background="../images/content_bg_left.gif" bgcolor="#FFFFFF"><?php echo $text_genfaq_category;?> : </td>
                        <td height="20" background="../images/content_bg_left.gif" bgcolor="#FFFFFF"><?php echo $R[f_cate]?></td>
                      </tr>
                      <tr bgcolor="#FFFFFF" class="head_font">
                        <td height="20"><?php echo $text_genfaq_categorysub;?> : </td>
                        <td height="20"><?php echo $R[f_subcate]?></td>
                      </tr>
                      <tr bgcolor="#FFFFFF" class="head_font">
                        <td width="21%" height="20"><?php echo $text_genfaq_ask;?> : </td>
                        <td width="79%" height="20"><?php biz($R[faq_user_name]); ?>                        </td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td height="20"><?php echo $text_genfaq_categorydetail;?> : </td>
                        <td width="79%" height="20"><?php biz($R[faq_user_detail]); ?>                        </td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td height="20"><?php echo $text_genfaq_answer;?> : </td>
                        <td height="20"><?php biz($R[faq_user_ans]); ?>                        </td>
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
                  <?php }} ?>
                
	</DIV></td>
  </tr>
</table>
</body>
</html>
<?php @$db->db_close(); ?>