<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language.php");
$i = 0;
$Execsql = $db->query("SELECT * FROM f_cat  ORDER BY f_no ASC");
$row = mysql_num_rows($Execsql); ?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function DelForm(){
		if(confirm("คุณแน่ใจที่จะลบข้อมูล?")){
			form1.submit();
		}
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
  <form name="form1" method="post" action="faqfunction.php">
  <input type="hidden" name="flag" value="delete">
   <input type="hidden" name="type" value="category">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/fag_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"> <?php echo $text_genfaq_category;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="faq_add.php?type=category&flag=add"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0" alt="<?php echo $text_general_add;?>"> 
      <?php echo $text_general_add;?> </a> 
      <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0">
  <!--<tr> 
    <td align="left">&nbsp;<img src="../theme/main_theme/g_search.gif" width="20" height="20" align="absmiddle"> 
      Search 
      <input type="text" name="textfield">
      <input type="submit" name="Submit" value="Search"></td>
  </tr>-->
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="10%" height="30" align="center">&nbsp;</td>
    <td ><?php echo $text_genfaq_category;?></td>
    <td width="5%" align="center"><?php echo $text_general_delete ;?></td>
  </tr>
    <?php
  if($row > 0){
   while($R = mysql_fetch_array($Execsql)){ 
   $count = $db->query("SELECT fa_id FROM faq WHERE f_id = '$R[f_id]'  ");
   $countrow = mysql_num_rows($count);

   ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<a href="#" onClick="window.location.href='faq_add.php?type=category&flag=edit&f_id=<?php echo $R[f_id]; ?>'"><img border="0" src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="<?php echo $text_general_edit;?>"></a>
	<?php if($R[f_use]=='Y') {?>
	<a href="faqfunction.php?type=category&flag=hide&f_id=<?php echo $R[f_id]; ?>" onClick="return confirm('Are you sure to hide this category?');"><img src="../theme/main_theme/g_hide.gif" alt="<?php echo $text_general_hide;?>" width="16" height="16" border="0"></a>
	<?php }else{  ?>
	<a href="faqfunction.php?type=category&flag=show&f_id=<?php echo $R[f_id]; ?>" onClick="return confirm('Are you sure to show this category?');"><img src="../theme/main_theme/g_show.gif" alt="<?php echo $text_general_enable;?>" width="16" height="16" border="0"></a>
	<?php }?>
	<a href="faq_add.php?type=category_sub&flag=add&f_id=<?php echo $R[f_id]; ?>"><img border="0" src="../theme/main_theme/faq_categoryadd.gif" width="16" height="16" align="absmiddle" alt=" <?php echo $text_genfaq_categoryadd_sub;?>"> </a></td>
    <td><a href="faq_sub.php?f_id=<?php echo $R[f_id]; ?>"><?php  biz($R[f_cate]); ?></a>  (<?php  biz($R[f_detail]); ?>)</td>
    <td align="center"><input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $R["f_id"]; ?>"></td>
  </tr>
  <?php $i++; } ?>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="2">&nbsp;</td>
    <td align="center"><input type="button" name="Button" value="<?php echo $text_general_delete;?>" onClick="DelForm()">
	</td>
  </tr>
  <?php }else{ ?>
    <tr bgcolor="#FFFFFF"> 
    <td colspan="3" align="center"><font color="#FF0000"><?php echo $text_genfaq_category_disabledata ;?></font></td>
  </tr>
  <?php } ?>
</table>
	<input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
  </form>
<!--<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>Page : &lt;&lt; Pre&nbsp;&nbsp;1&nbsp;&nbsp;<strong>[2]</strong>&nbsp;&nbsp;3&nbsp;&nbsp;4&nbsp;&nbsp;5&nbsp;&nbsp;6&nbsp;&nbsp;Next &gt;&gt;</td>
  </tr>
</table>-->
</body>
</html>
<?php @$db->db_close(); ?>