<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language.php");
if($_GET["type"]=='category'){
	if($_GET["flag"]=='add'){
		$function_name = $text_genfaq_categoryadd;
	}else if($_GET["flag"]=='edit'){
		$function_name =$text_genfaq_categoryedit;
		$query_edit=$db->query("select * from f_cat where f_id='".$_GET["f_id"]."' ");
		$R_EDIT=$db->db_fetch_array($query_edit);
		$t_topic = $R_EDIT[f_cate];
		$t_detail = $R_EDIT[f_detail];
		$t_no  = $R_EDIT[f_no];
	}
$page_name = $text_general_back;
$page_link = "<a href=\"faq_cate.php\"><img src=\"../theme/main_theme/g_back.gif\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\">".$page_name."</a>";
}else{
	if($_GET["flag"]=='add'){
		$function_name = $text_genfaq_categoryadd_sub;
	}else if($_GET["flag"]=='edit'){
		$function_name = $text_genfaq_categoryedit_sub;
		$query_edit=$db->query("select * from f_subcat where f_sub_id='".$_GET["f_sub_id"]."' ");
		$R_EDIT=$db->db_fetch_array($query_edit);
		$f_id=$R_EDIT[f_id];
		$t_topic = $R_EDIT[f_subcate];
		$t_detail = $R_EDIT[f_subdetail];
		$t_no =  $R_EDIT[f_sub_no];
	}
	$page_name = $text_general_back;
$page_link = "<a href=\"faq_sub.php?f_id=".$_GET["f_id"]."\"><img src=\"../theme/main_theme/g_back.gif\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\">".$page_name."</a>";

}

 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" class="normal_font">
<form name="form1" enctype="multipart/form-data" method="post" action="faqfunction.php" onSubmit="return CHK()">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
<?php
echo "SELECT * FROM f_cat WHERE  f_id = '".$_GET["f_id"]."' ";
$Execsql1 = $db->query("SELECT * FROM f_cat WHERE  f_id = '".$_GET["f_id"]."' ");
$R1 = mysql_fetch_array($Execsql1);

if($_GET["type"]=='category_sub'){
$function_name1 = "<a href=\"faq_cate.php\">".$text_genfaq_category." : ".$R1[f_cate]."</a> >>".$function_name;
//}else{
///$function_name1 = "<a href=\"faq_cate.php\">".$text_genfaq_category." : ". biz($R1[f_cate])."</a> >><a href=\"faq_sub.php?f_id=".$f_id."\">".$text_genfaq_categorysub.": ".$R_SUB[f_subcate]."</a> >>".$function_name;
}else{
$function_name1 = "<a href=\"faq_cate.php\">".$text_genfaq_category." </a> >>".$function_name;
}
?>
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"> <?php echo $function_name1;?> </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><?php echo $page_link;?>
    <hr> </td>
  </tr>
</table>
<table width="70%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> <?php echo $function_name;?>  </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%"><?php echo $text_genfaq_categoryname;?><font color="#FF0000">*</font></td>
    <td width="62%"><input name="t_topic" type="text" class="normaltxt" id="t_topic" size="60" value="<?php echo $t_topic?>"> </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td><?php echo $text_genfaq_categorydetail;?><font color="#FF0000">*</font></td>
    <td><textarea name="t_detail" cols="60" rows="4" wrap="VIRTUAL" class="normaltxt" id="t_detail"><?php echo $t_detail?></textarea></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td><?php echo $text_genfaq_categorystep;?></td>
    <td><input name="f_no" type="text" id="f_sub_no" value="<?php echo $t_no?>" size="3" maxlength="3"  onKeyPress="return(NumberFormat(this,event));"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="<?php echo $text_general_submit;?>">
      <input type="reset" name="Submit" value="<?php echo $text_general_Reset;?>">
	  <input name="flag" type="hidden" id="flag" value="<?php echo $_GET["flag"];?>"> 
	   <input name="type" type="hidden" id="type" value="<?php echo $_GET["type"];?>">
	  <input name="f_id" type="hidden" id="f_id" value="<?php echo $_GET["f_id"];?>">
	  <input name="f_sub_id" type="hidden" id="f_sub_id" value="<?php echo $_GET["f_sub_id"]?>"></td>
  </tr>
</table>
</form>
</body>
</html>
<script language="JavaScript">
function CHK(){
if(document.form1.t_topic.value == ""){
alert("<?php echo $text_genfaq_alertitem;?>");
document.form1.t_topic.focus();
return false;
}
if(document.form1.t_detail.value == ""){
alert("<?php echo $text_genfaq_alertdetail;?>");
document.form1.t_detail.focus();
return false;
}
}
function NumberFormat(fld,e){
					var strCheck = '0123456789.';
					var len = 0;
					var whichCode = (window.Event) ? e.which : e.keyCode;
					key = String.fromCharCode(whichCode); 
					if (strCheck.indexOf(key) == -1) {
					alert('<?php echo $text_general_alertnumber;?>');
					return false;
					}
}

</script>
