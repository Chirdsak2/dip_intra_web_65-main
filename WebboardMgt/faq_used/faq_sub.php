<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language.php");
$i=0;
$Execsql = $db->query("SELECT * FROM f_cat WHERE  f_id = '".$_GET["f_id"]."' ");
$R = mysql_fetch_array($Execsql);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function DelForm(){
		if(confirm("Are you sure you want to delete selected data?")){
			form1.submit();
		}
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
  <form name="form1" method="post" action="faqfunction.php">
  <input type="hidden" name="flag" value="delete">
  <input type="hidden" name="f_id" value="<?php echo $_GET["f_id"]?>">
   <input type="hidden" name="type" value="category_sub">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/fag_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">
   <a href="faq_cate.php"><?php echo $text_genfaq_category;?>  : <?php echo biz($R[f_cate]); ?></a> >> <?php echo $text_genfaq_categorysub;?></span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="faq_add.php?type=category_sub&flag=add&f_id=<?php echo $_GET["f_id"]?>"><img border="0" src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" alt=" <?php echo $text_general_add;?>"> 
      <?php echo $text_general_add;?></a>&nbsp;&nbsp;&nbsp;<a href="faq_cate.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" align="absmiddle" border="0" alt="<?php echo $text_genfaq_function;?>"> 
      <?php echo $text_general_back;?>  </a>
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
    <td width="55%" ><?php echo $text_genfaq_categorysub;?></td>
    <td width="15%" ><?php echo $text_genfaq_categorycount;?></td>
    <td width="5%" align="center"><?php echo $text_general_delete;?></td>
  </tr>
<?php   $sql_subcat="select * from f_subcat where f_id='".$_GET[f_id]."' order by  f_sub_no  "  ;
					$query_subcat=$db->query($sql_subcat);
					 if(mysql_num_rows($query_subcat) > 0){
					while($R_SUB=$db->db_fetch_array($query_subcat)){
 ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><nobr><a href="#" onClick="window.location.href='faq_add.php?type=category_sub&flag=edit&f_sub_id=<?php echo $R_SUB[f_sub_id];?>&f_id=<?php echo $_GET[f_id]?>'"><img border="0" src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="<?php echo $text_general_edit;?>"> </a>
				  <?php if($R_SUB[f_use]=='Y') {?>
				  <a href="faqfunction.php?type=category_sub&flag=hide&f_sub_id=<?php echo $R_SUB[f_sub_id];?>&f_id=<?php echo $_GET[f_id]?>" onClick="return confirm('Are you sure to drop this subcategory?');"><img src="../theme/main_theme/g_hide.gif" alt="<?php echo $text_general_hide;?>" width="16" height="16" border="0"></a>
				  <?php }else{  ?>
				  <a href="faqfunction.php?type=category_sub&flag=show&f_sub_id=<?php echo $R_SUB[f_sub_id];?>&f_id=<?php echo $_GET[f_id]?>" onClick="return confirm('Are you sure to show this subcategory?');"><img src="../theme/main_theme/g_show.gif" alt="<?php echo $text_general_enable;?>" width="16" height="16" border="0"></a>
				  <?php }?>
				  <a href="addfaq.php?f_sub_id=<?php echo $R_SUB[f_sub_id];?>&f_id=<?php echo $_GET["f_id"];?>"><img src="../theme/main_theme/faq_categoryadd_sub.gif" width="16" height="16" border="0" align="absmiddle" alt="<?php echo $text_genfaq_faqadd;?>"></a> </nobr></td>
    <td><a href="faq_question.php?f_id=<?php echo $R[f_id]; ?>&f_sub_id=<?php echo $R_SUB[f_sub_id]; ?>"><?php  biz($R_SUB[f_subcate]); ?></a></td>
    <td align="center"><?php
   $count2 = $db->query("SELECT fa_id FROM faq WHERE f_sub_id = '$R_SUB[f_sub_id]'  ");
  echo  mysql_num_rows($count2);
?></td>
    <td align="center"><input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $R_SUB[f_sub_id];?>"></td>
  </tr>
  <?php  $i++; } ?>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="3">&nbsp;</td>
    <td align="center"><input type="button" name="Button" value="<?php echo $text_general_delete;?>" onClick="DelForm()"></td>
  </tr>
  <?php }else{ ?>
    <tr bgcolor="#FFFFFF"> 
    <td colspan="4" align="center"><font color="#FF0000"><?php echo $text_genfaq_categorysub_disabledata;?></font></td>
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
