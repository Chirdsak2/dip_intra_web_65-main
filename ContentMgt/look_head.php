<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$group = "SELECT temp_index.template_id,design_list.d_name FROM  temp_index  INNER JOIN design_list ON temp_index.template_id = design_list.d_id WHERE temp_index.filename = '".$_GET["filename"]."'";
$sql_group= $db->query($group);
if($db->db_num_rows($sql_group)==0){
?>
<script language="JavaScript">
alert("File Not Found!!!");
self.top.ewt_main.location.href='../ewt_main.php';
</script>
<?php
exit;
}

$R = $db->db_fetch_array($sql_group);

		if(!(session_is_registered("EWT_HIDDEN_DESIGN"))){
			session_register("EWT_HIDDEN_DESIGN");
			$_SESSION["EWT_HIDDEN_DESIGN"] = "N";
		}	
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script type='text/javascript' src='../js/jquery/jquery-1.2.3.min.js'></script>
<script type='text/javascript' src='../js/jquery/jquery.jqDock.js'></script>
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
	window.open('','content_popup','top=60,left=80,width=800,height=600,resizable=1,status=0');
		document.formPopUpIns.stype.value = c;
		formPopUpIns.submit();
}
	function choose_d(c){
	formPopUpIns.action = "../FileMgt/download_insert.php";
	window.open('','content_popup','top=60,left=80,width=800,height=600,resizable=1,status=0');
		document.formPopUpIns.stype.value = c;
		formPopUpIns.submit();
}
function hiddendesign(){
	var allTables = iframe_data.document.getElementsByTagName("tr");
	var y = 0;
	 for (i=0; i < allTables.length; i++) {
		 if(allTables[i].id.search("tr") >= 0){
		 allTables[i].style.display = 'none';
		 iframe_data.document.all.EWTpospic[y].src = "../../images/bar_down.gif";
		 y++;
		 }
	}
}
function showdesign(){
	var allTables = iframe_data.document.getElementsByTagName("tr");
	var y = 0;
	 for (i=0; i < allTables.length; i++) {
		 if(allTables[i].id.search("tr") >= 0){
		 allTables[i].style.display = '';
		 iframe_data.document.all.EWTpospic[y].src = "../../images/bar_up.gif";
		 y++;
		 }
	}
}
function plustext(){
	var txt = "";
	var allDIV = iframe_data.document.getElementsByTagName("DIV");
	 for (i=0; i < allDIV.length; i++) {
		txt  = txt + allDIV[i].id;
	}
	return txt;
}
function SaveChange(){
		iframe_data.auto_save.document.form1.tagdetect.value=plustext();
		iframe_data.auto_save.form1.submit();
}
function SaveChange1(){
				SaveChange();
				formSavetoTemplate.submit();
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
	//			win2 = window.open('content_org.php?filename=' + c + '','InsContentOrg','top=20,left=80,width=640,height=550,resizable=1,scrollbars=1,status=0');
	//			win2.focus();
		formPopUpIns.action = "content_org.php?filename="+c;
		window.open('','content_popup','top=60,left=80,width=800,height=600,resizable=1,status=0,scrollbars=1');
		document.formPopUpIns.stype.value = c;
		formPopUpIns.submit();
}
function Public(c){
		SaveChange();
		window.open('','content_popup','top=60,left=80,width=400,height=350,resizable=1,status=0,scrollbars=1');
		formPublic.submit();
}
function Properties(){
				win2 = window.open('look_properties.php?filename=<?php echo $_GET["filename"]; ?>','ContentProperties','top=20,left=80,width=800,height=550,resizable=1,status=0');
				win2.focus();
}
</script>

</head>
<body bgcolor="808080" leftmargin="0" topmargin="0">
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
      <form name="formPublic" method="post" action="apply_function.php" target="content_popup">
        <input name="Flag" type="hidden" id="Flag" value="ChoosePublic">
        <input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>">
		<input name="d_id" type="hidden" id="d_id" value="<?php echo $R["template_id"]; ?>">
      </form>
      <form name="formSavetoTemplate" method="post" action="template_function.php" target="save_function">
        <input name="Flag" type="hidden" id="Flag" value="ApplyToTemplate">
        <input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>">
		<input name="d_id" type="hidden" id="d_id" value="<?php echo $R["template_id"]; ?>">
      </form>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FB8233">
  <tr>
    <td height="20" bgcolor="F3F3EE" colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="1"><form name="formMin" method="post" action="content_function.php">
        <input name="file_name" type="hidden" id="file_name" value="<?php echo $_GET["filename"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Close">
        <tr>
          <td width="32"><img src="../theme/main_theme/ewt_logo.gif" width="28" height="28" align="absmiddle" onClick="top.ewt_main.location.href = '../ewt_main.php';"></td>
          <td><?php include("../ewt_menu.php"); ?>
		  <div  id=menu5 class="demo">
		 <?php include("../menu_ajax.php");?>
		 </div></td>
		  <td width="3" bgcolor="F3F3EE"    ><script type="text/javascript" language="JavaScript1.2">
			<!--
			stm_bm(["menu2ee91",430,"","<?php echo $EWT_PATH; ?>images/o.gif",0,"","",0,3,10,0,10,1,0,0,"","",0],this);
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
     <td width="10" bgcolor="F3F3EE"    ><img src="../images/arrow_d.gif" width="7" height="7" border="0" align="absmiddle"></td>
		  <td width="800" align="center" ><iframe name="save_function" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe></td>
		  <td width="15" align="right" valign="top"><img src="../images/bar_min.gif" width="15" height="13" border="1" style="border-Color:threedface"    title="Minimize" onClick="self.top.ewt_main.location.href='../ewt_main.php';"></td>
		  <td width="15" align="right" valign="top"><div align="right"><img src="../images/bar_close.gif" width="15" height="13" border="1" style="border-Color:threedface"  title="Close" onClick="top.ewt_main.location.href = '../ewt_main.php';"></div></td>
		  
        </tr></form>
      </table></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>

    <td height="20"   align="right" bgcolor="#FFFFFF" ><table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr> 
          <td align="right">Website : <?php echo $_SESSION["EWT_SUSER"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User : <?php echo $_SESSION["EWT_SMUSER"]; ?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>
	  <table width="100%" height="70" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr> 
    <td width="64" height="75"><img src="../theme/main_theme/g_template_64.gif" > </td>
                <td><span class="ewthead">Template : <?php echo $R["d_name"]; ?></span>
                  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
                  &nbsp;<a href="../LookMgt/look_index.php" target="ewt_main"><img src="../images/bar_home.gif"  alt="../theme/main_theme/icon_jquery_gif64/bar_home.gif" border="0"  title="Back to Main"></a> 
			<a href="#preview" onClick="Preview('<?php echo $_GET["filename"]; ?>')"><img src="../images/bar_view.gif"  alt="../theme/main_theme/icon_jquery_gif64/bar_view.gif" border="0"  title="Preview"></a> 
			<a href="#save" onClick="SaveChange1()"><img src="../images/bar_save.gif"  alt="../theme/main_theme/icon_jquery_gif64/bar_save.gif" border="0" title="Save Change"></a>
            <a href="#public"  onClick="Public()"><img src="../images/bar_public.gif"  alt="../theme/main_theme/icon_jquery_gif64/bar_public.gif" border="0"title="Apply Template to Website"></a>
        <a href="#properties" onClick="Properties()"><img src="../images/bar_properties.gif"  alt="../theme/main_theme/icon_jquery_gif64/bar_properties.gif" border="0"title="Template Properties"></a> 
		<a href="#preview" onClick="SaveAsTemplate('<?php echo $_GET["filename"]; ?>')"><img src="../images/bar_save_as.gif"  alt="../theme/main_theme/icon_jquery_gif64/bar_save_as.gif" border="0"title="Save Template As..."></a> 
<img  src="../images/o.gif"  alt="../theme/main_theme/icon_jquery_gif64/g_blank.gif" border="0" title=" ">
	<br><br><br><br>
		  </td>
  </tr>
</table>
    </td>
  </tr>
  <tr> 
    <td height="10" background="../theme/main_theme/bg.gif" bgcolor="#FF3300"></td>
  </tr>
  <tr>
    <td  bgcolor="#9D9DA1" ><iframe name="iframe_data" src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_preview_t.php?filename=<?php echo $_GET["filename"]; ?>" frameborder="1" width="100%" height="100%" scrolling="yes"></iframe></td>
  </tr>
</table>
</body>
</html>
<script>
	jQuery(document).ready(function(){
		var opts =
		{ align: 'bottom'
		, size: 20
		, labels: 'tc'
		, source: function(i){ return (this.alt) ? false : this.src.replace(/(jpg|gif)$/,'gif'); }
		};
		jQuery('#menu5').jqDock(opts);
	});
</script>
<?php $db->db_close(); ?>