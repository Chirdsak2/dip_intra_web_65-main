<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
include("../language.php");

$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);
		 $sel = "SELECT   f_subcat.f_subcate,  faq_user.*
		FROM  f_subcat INNER JOIN faq_user ON (f_subcat.f_sub_id = faq_user.f_sub_id) WHERE faq_status='0' ";

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
 <?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $text_genfaq_function_user;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genfaq_function_user);?>&module=faq&url=<?php echo urlencode("faq_user.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <hr>
    </td>
  </tr>
</table>
<!--<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td align="left">&nbsp;<img src="../theme/main_theme/c.gif" width="16" height="16" align="absmiddle"> 
      Search 
      <input type="text" name="textfield">
      <input type="submit" name="Submit" value="Search"></td>
  </tr>
</table>-->
<form action="faqfunction.php" method="post" name="form">
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td width="58%" ><?php echo $text_genfaq_function_user;?></td>
    <td width="8%" >หมวด</td>
    <td width="10%" align="center" ><?php echo $text_general_approve;?></td>
    <td width="19%" align="center"><?php echo $text_general_disapprove;?></td>
  </tr>
                    <?php
					$i=0;
	  if($rows > 0){
   while($R = mysql_fetch_array($Execsql)){ 
	?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><nobr>&nbsp;</nobr></td>
    <td><a href="##" onClick="window.open('faq_userview.php?faq_user_id=<?php echo $R[faq_user_id]; ?>','','toolbars=no,menubar=no,locatoion=on,scrollbars=yes,width=600,height=300')"><?php biz($R[faq_user_name]); ?>   </a>
      <input type="hidden" name="user_id[<?php echo $i;?>]" value="<?php echo $R[faq_user_id];?>">     </td>
    <td><?php echo $R[f_subcate];?></td>
    <td align="center"><input name="<?php echo $i."_".$R[faq_user_id];?>" type="radio" value="1" checked="checked"></td>
    <td align="center"><input name="<?php echo $i."_".$R[faq_user_id];?>" type="radio" value="2"></td>
  </tr>
  <?php $i++; } ?>
  <tr align="right" bgcolor="#FFFFFF"> 
    <td colspan="3">&nbsp;</td>
    <td colspan="2" align="center"><input type="submit" name="Submit" value="<?php echo $text_general_submit;?>">
      <input type="hidden" name="flag" value="approve"></td>
  </tr>
  <?php }else{ ?>
  <tr align="right" bgcolor="#FFFFFF">
    <td colspan="5" align="center"><span style="color:#FF0000"><?php echo $text_genfaq_user_disabledata;?></span></td>
  </tr>
  <?php } ?>
</table>
</form>
<!--<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>Page : &lt;&lt; Pre&nbsp;&nbsp;1&nbsp;&nbsp;<strong>[2]</strong>&nbsp;&nbsp;3&nbsp;&nbsp;4&nbsp;&nbsp;5&nbsp;&nbsp;6&nbsp;&nbsp;Next &gt;&gt;</td>
  </tr>
</table>-->

</body>
</html>
<?php @$db->db_close(); ?>