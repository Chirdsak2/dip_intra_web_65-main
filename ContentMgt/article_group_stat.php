<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}
		$_SESSION["EWT_OPEN_ARTICLE"] = "";
$db->write_log("view","article","เข้าสู่ Module Article");
$sql_article = $db->query("SELECT COUNT(n_id) as num,article_group.c_name FROM article_group,article_list where article_group.c_id = article_list.c_id group by article_group.c_name ORDER BY num DESC");
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script language="JavaScript">
//self.parent.document.all.backon.style.display = 'none';
//self.parent.document.all.backoff.style.display = '';
//self.parent.document.all.folderoff.style.display = 'none';
//self.parent.document.all.folderon.style.display = '';
//self.parent.document.all.deloff.style.display = 'none';
//self.parent.document.all.delon.style.display = '';
			 function chkKeyFo(c){
			 		if(event.keyCode == 13){
						create_fo(c);
					}
			 }
			 function create_fo(c){
				if(c.value == ""){
					document.all.new_fo.style.display = 'none';
				}else{
					var gname = c.value;
					document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"article_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateFolder\"><input name=\"gname\" type=\"hidden\" id=\"gname\" value=\""+ gname + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
					createform.submit();

				}
			}
			function CHK(t){
	if(t.search_txt.value == '' && t.date_s.value == '' && t.date_e.value == ''){
	alert("กรุณาระบุเงื่อนไขการค้นหา!!!!!!!!!!!");
	return false;
	}else{
	return true;
	}
	return false;
	}
</script>
</head>
<body leftmargin="0" topmargin="0">

<?php 
$disabled1='style="display:none"';
$disabled2='style="display:none"';
if($db->check_permission('art','w','')){ $disabled1='';}
if($db->check_permission('art','a','')){ $disabled2=''; }
$db->query("USE ".$_SESSION["EWT_SDB"]);
?>

<span id="formtext"></span>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">จำนวนข่าว/บทความในหมวดต่างๆ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form2" method="get" action="article_list2.php"  onSubmit="return CHK(this)">
      <td>&nbsp;</td>
    </form>
  </tr>
</table>
<table  width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <form name="form1" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td height="18" align="center">ชื่อกลุ่มข่าว/บทความ</td>
      <td width="20%" align="center">จำนวนข่าว/บทความในหมวด</td>
    </tr>
    <?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_article)){ 
	 if($db->check_permission("Ag","",$G[c_id])){
	$articlr_totle +=$G[num];

	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <img src="../theme/main_theme/g_folder_closed.gif" alt="news folder" width="16" height="16" align="absmiddle">
      <?php echo $G["c_name"]; ?> </td>
      <td align="center" ><?php echo number_format($G[num],0); ?></td>
    </tr>
    <?php $i++; }} ?>
    <tr bgcolor="#FFFFFF"> 
      <td align="right" valign="top">รวมข่าว/บทความทั้งหมด</td>
      <td align="center"><?php echo number_format($articlr_totle,0); ?></td>
    </tr>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
  </form>
</table>
<br>

</body>
</html>
<?php $db->db_close(); ?>
