<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
$group = "SELECT d_id FROM  design_list  WHERE d_id = '".$_GET["d_id"]."'";
$sql_group= $db->query($group);
if($db->db_num_rows($sql_group)==0){
?>
<script language="JavaScript">
alert("File Not Found!!!");
self.top.location.href='site_template.php';
</script>
<?php
exit;
}

	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript1.2" src="../js/stm31.js"></script>
<script language="javascript">
	function button_over(eButton){
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "buttonhighlight solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "buttonhighlight solid 1px";
	}
		function button_down(eButton){
		eButton.style.borderBottom = "buttonhighlight solid 1px";
		eButton.style.borderLeft = "buttonshadow solid 1px";
		eButton.style.borderRight = "buttonhighlight solid 1px";
		eButton.style.borderTop = "buttonshadow solid 1px";
	}
				
	function button_out(eButton){
	eButton.style.borderColor = "threedface";
		//eButton.removeAttribute("style");
	}
	function ClosePage(){
	formMin.submit();
	}
	function choose(c){
		document.formInsert.stype.value = c;
		formInsert.submit();
}
	function choose_p(c){
	formPopUpIns.action = "../FileMgt/gallery_insert.php";
	window.open('','content_popup','top=60,left=80,width=640,height=480,resizable=1,status=0');
		document.formPopUpIns.stype.value = c;
		formPopUpIns.submit();
}
	function choose_d(c){
	formPopUpIns.action = "../FileMgt/download_insert.php";
	window.open('','content_popup','top=60,left=80,width=640,height=480,resizable=1,status=0');
		document.formPopUpIns.stype.value = c;
		formPopUpIns.submit();
}
function hiddendesign(){
	var allTables = content_body.document.getElementsByTagName("tr");
	var y = 0;
	 for (i=0; i < allTables.length; i++) {
		 if(allTables[i].id.search("tr") >= 0){
		 allTables[i].style.display = 'none';
		 content_body.document.all.EWTpospic[y].src = "../../images/bar_down.gif";
		 y++;
		 }
	}
}
function showdesign(){
	var allTables = content_body.document.getElementsByTagName("tr");
	var y = 0;
	 for (i=0; i < allTables.length; i++) {
		 if(allTables[i].id.search("tr") >= 0){
		 allTables[i].style.display = '';
		 content_body.document.all.EWTpospic[y].src = "../../images/bar_up.gif";
		 y++;
		 }
	}
}
function SaveChange(){
		content_body.auto_save.document.form1.tagdetect.value=content_body.document.all.Demo4.innerHTML;
		content_body.auto_save.form1.submit();
		self.parent.content_properties.form2.submit();
}
function SaveAsTemplate(c){
				SaveChange();
				win2 = window.open('content_template.php?filename=' + c + '','ContentTemplate','top=20,left=80,width=640,height=550,resizable=1,status=0');
				win2.focus();
}
function ContentShare(c){
				SaveChange();
				win2 = window.open('content_share.php?filename=' + c + '','ContentShare','top=20,left=80,width=640,height=550,resizable=1,status=0');
				win2.focus();
}
function choose_share(c){
				SaveChange();
				win2 = window.open('content_i_share.php?filename=' + c + '','InsContentShare','top=20,left=80,width=640,height=550,resizable=1,status=0');
				win2.focus();
}
function choose_org(c){
				SaveChange();
				win2 = window.open('content_org.php?filename=' + c + '','InsContentOrg','top=20,left=80,width=640,height=550,resizable=1,scrollbars=1,status=0');
				win2.focus();
}
function Public(c){
		SaveChange();
		formPublic.submit();
}
</script>
</head>
<body bgcolor="808080" leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FB8233">
  <tr> 
    <td height="20" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> Edit 
      template</td>
  </tr>
  <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr> 
    <td height="20" bgcolor="F3F3EE"><table width="100%" height="24" border="0" cellpadding="0" cellspacing="0">
        <form name="formPopUpIns" method="post" action="" target="content_popup">
          <input name="position" type="hidden" id="position" value="last">
          <input name="stype" type="hidden" id="stype" value="">
          <input name="Flag" type="hidden" id="Flag" value="Choose">
          <input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>">
        </form>
        <form name="formInsert" method="post" action="content_function.php" target="save_function">
          <input name="stype" type="hidden" id="stype" value="">
          <input name="Flag" type="hidden" id="Flag" value="Choose">
          <input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>">
        </form>
        <form name="formPublic" method="post" action="public_function.php" target="save_function">
          <input name="Flag" type="hidden" id="Flag" value="ChoosePublic">
          <input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>">
        </form>
        <tr> 
          <td width="5" background="../images/content_bg_line.gif"></td>
          <td width="80" align="center" ><a href="site_template.php" target="_top">Back to main</a></td>
          <td width="24" align="center" ><a href="#preview" onClick="Preview('<?php echo $_GET["filename"]; ?>')"><img src="../images/bar_view.gif" width="20" height="20" border="1" style="border-Color:threedface"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Preview"></a></td>
          <td width="24" align="center" ><a href="#save" onClick="SaveChange()"><img src="../images/bar_save.gif" width="20" height="20" border="1" style="border-Color:threedface"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onMouseUp="button_over(this);" title="Save"></a></td>
          <td width="1" bgcolor="D8D2BD"></td>
          <td width="1" bgcolor="#FFFFFF"></td>
          <td width="5" background="../images/content_bg_line.gif"></td>
          <td width="35" nowrap> <script type="text/javascript" language="JavaScript1.2">
<!--
stm_bm(["menu2ee91",430,"","../images/o.gif",0,"","",0,3,10,0,10,1,0,0,"","",0],this);
stm_bp("pd0",[0,4,0,0,1,4,0,0,100,"",-2,"",-2,50,0,0,"#D0D0D2","#f3f3ee","",3,0,0,"#000000"]);
stm_ai("pd0i0",[0," View ","","",-1,-1,0,"","_self","","","","",0,0,0,"","",0,0,0,0,1,"#f3f3ee",0,"#D6D6D8",0,"","",3,3,0,0,"#fffff7","#000000","#000000","#000000","8pt Tahoma","8pt Tahoma",0,0]);
stm_bp("pd1",[1,4,0,0,1,6,0,0,100,"arrow_d.gif",-2,"",-2,50,2,1,"#D6D6D8","#ffffff","",3,1,1,"#D6D6D8"]);
stm_aix("pd1i0","pd0i0",[0," Show design on this page... ","","",-1,-1,0,"javascript:showdesign();","_self","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#D6D6D8"]);
stm_aix("pd1i1","pd1i0",[0," Hidden design on this page... ","","",-1,-1,0,"javascript:hiddendesign();"]);
stm_ep();
stm_ep();
stm_em();
//-->
</script></td>
          <td width="9" align="center" ><img src="../images/arrow_d.gif" width="7" height="7" border="0" align="absmiddle"></td>
          <td width="1" bgcolor="D8D2BD"></td>
          <td width="1" bgcolor="#FFFFFF"></td>
          <td width="5" background="../images/content_bg_line.gif"></td>
          <td width="24" align="center" ><a href="#editor" onClick="choose('text')"><img src="../images/bar_etext.gif" width="20" height="20" border="1" style="border-Color:threedface"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Insert Block"></a></td>
          <td width="24" align="center" ><a href="#coding" onClick="choose('code')"><img src="../images/bar_code.gif" width="20" height="20" border="1" style="border-Color:threedface"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Insert Coding"></a></td>
          <td >&nbsp;</td>
        </tr>
      </table></td>
  </tr>
<tr>
    <td  bgcolor="#9D9DA1"><iframe name="content_body" src="../template/tmp<?php echo $_GET["d_id"]; ?>/ewt_preview.php?d_id=<?php echo $_GET["d_id"]; ?>" frameborder="1" width="100%" height="100%" scrolling="yes"></iframe></td>
  </tr>
  </table>
</body>
</html>
<?php $db->db_close(); ?>
