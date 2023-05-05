<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
include("../language.php");
$f_sub_id = $_GET["f_sub_id"];
$f_id = $_GET["f_id"];
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);
  $sel = "SELECT * FROM faq WHERE f_sub_id = '$f_sub_id' ORDER BY  faq_top DESC ,fa_id ASC";

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
$Show = $sel;//." LIMIT $offset, $limit ";
$Execsql = $db->query($Show); ?>
<html>
<head>
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

<body leftmargin="0" topmargin="0" class="normal_font">
  <form name="form1" method="post" action="faqfunction.php">
  <input type="hidden" name="flag" value="delfaq">
  <input type="hidden" name="f_sub_id" value="<?php echo $_GET["f_sub_id"]?>">
  <input type="hidden" name="f_id" value="<?php echo $_GET["f_id"]?>">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
<?php
$Execsql1 = $db->query("SELECT * FROM f_cat WHERE  f_id = '".$_GET["f_id"]."' ");
$R1 = mysql_fetch_array($Execsql1);
$sql_subcat="select * from f_subcat where f_sub_id='".$_GET[f_sub_id]."' order by  f_sub_no  "  ;
$query_subcat=$db->query($sql_subcat);
$R_SUB=$db->db_fetch_array($query_subcat);
?>
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><a href="faq_cate.php"><?php echo $text_genfaq_category;?>  : <?php echo biz($R1[f_cate]); ?></a> >> <a href="faq_sub.php?f_id=<?php echo $f_id;?>"><?php echo $text_genfaq_categorysub;?>  : <?php echo $R_SUB[f_subcate];?></a> >> <?php echo $text_genfaq_faq;?></span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="addfaq.php?f_sub_id=<?php echo $f_sub_id;?>&f_id=<?php echo $f_id;?>"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
		<?php echo $text_general_add;?></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="faq_sub.php?f_id=<?php echo $f_id;?>"><img border="0" src="../theme/main_theme/g_back.gif" width="16" height="16" align="absmiddle"> 
     <?php echo $text_general_back;?></a>
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
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td ><?php echo $text_genfaq_faq;?></td>
    <td width="5%" align="center"><?php echo $text_general_delete;?></td>
  </tr>
    <?php
	$i = 0;
	if($rows > 0){
   while($R = mysql_fetch_array($Execsql)){ 
	?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><a href="addfaq.php?fa_id=<?php echo $R[fa_id]; ?>&f_sub_id=<?php echo $R[f_sub_id]; ?>&f_id=<?php echo $f_id;?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0"></a> </td>
    <td><a href="#" onClick="window.open('faq_view.php?fa_id=<?php echo $R[fa_id]; ?>','','toolbars=no,menubar=no,locatoion=on,scrollbars=yes,width=600,height=400')"><?php biz($R[fa_name]); ?></a></td>
    <td align="center"><input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $R[fa_id]; ?>"></td>
  </tr>
  <?php $i++; }?>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="2">&nbsp;</td>
    <td align="center"><input type="button" name="Button" value="<?php echo $text_general_delete;?>" onClick="DelForm()"></td>
  </tr>
  <?php }else{ ?>
    <tr bgcolor="#FFFFFF"> 
    <td colspan="3" align="center"><font color="#FF0000"><?php echo $text_genfaq_faq_disabledata;?></font></td>
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
