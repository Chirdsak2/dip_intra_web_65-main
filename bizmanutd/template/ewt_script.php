<?php
if($filename == ""){
$filename = "index";
}
			$lang_sh1 = explode('___',$_GET["filename"]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				$lang_sh_flag =strtolower ($lang_shw);
			}else{
				$lang_sh ='';
				$lang_sh_flag ='th';
				$lang_shw='';
			}
?>
<link href="css/jquery.cluetip.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/style_calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/calendar-script-<?php echo $lang_sh_flag; ?>.js"></script>
<script type="text/javascript" src="js/loadcalendar.js"></script>
<script type="text/javascript" src="js/calendar-<?php echo $lang_sh_flag; ?>.js"></script>
<script type="text/javascript" src="js/AjaxRequest.js"></script>
<script type="text/javascript" src="js/excute.js"></script>
<script type="text/javascript" src="js/jquery/jquery-1.2.3.pack.js"></script>
<script type='text/javascript' src='js/jquery/jquery-1.2.3.min.js'></script>
<script type='text/javascript' src='js/jquery/jquery.jqDock.js'></script>
<script type="text/javascript" src="js/jquery/jquery.dimensions.js"></script>
<script type="text/javascript" src="js/jquery/jquery.hoverIntent.js"></script>
<script type="text/javascript" src="js/jquery/jquery.cluetip.js"></script>
<script type="text/javascript">
function txt_area(prov,amph,gid) {
	var objDiv = document.getElementById("nav"+gid);
	objDiv.style.display = '';
	url='list_tumbon.php?prov='+prov+'&&amph='+amph+'&gid='+gid;

					
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function loadnewsarea(bid,gid,data) {
	var objDiv = document.getElementById("show_comment"+bid);
	url='ewt_article_preview.php?bid='+bid+'&gid='+gid+'&data='+data;

					
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function help(page_id){
window.open('help.php?page='+page_id+'','help_popup','top=60,left=80,width=800,height=600,resizable=0,status=0');
}
</script>
<script type="text/javascript">
	function changeStyle(c) {
		var x = document.getElementsByTagName("span");
		for (i=0;x && i < x.length; i++) {
			x[i].removeAttribute("style");
		}
		document.all.stext.href='css/'+c+'.css';
	}
</script>

<link id="stext" href=""  rel="stylesheet" type="text/css">
<link  href="css/interface.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--

#icon_botton{
	PADDING-LEFT: 150px; POSITION: relative; TOP: 0px
}

DIV.jqDockLabel {
	BORDER-RIGHT: 0px; PADDING-RIGHT: 14px; BORDER-TOP: 0px; PADDING-LEFT: 4px; FONT-WEIGHT: bold; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; BORDER-LEFT: 0px; COLOR: #000000; PADDING-TOP: 0px; BORDER-BOTTOM: 8px; FONT-STYLE: italic; WHITE-SPACE: nowrap; BACKGROUND-COLOR: transparent
}
DIV.jqDockLabelLink {
	CURSOR: pointer
}
DIV.jqDockLabelImage {
	CURSOR: default
}
#icon_botton DIV.jqDockLabel {
	FONT-WEIGHT: normal; FONT-SIZE: 12px; PADDING-BOTTOM: 0px; COLOR: #000000; PADDING-TOP: 1px; 
}
.demo {
	DISPLAY: none
}
.demo IMG {
	BORDER-RIGHT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; VERTICAL-ALIGN: top; BORDER-LEFT: 0px; WIDTH: 48px; PADDING-TOP: 0px; BORDER-BOTTOM: 0px; HEIGHT: 48px
}
-->
</style>
<script type="text/javascript">
function show_article_rendom(bid,filename,mainwidth,global_theme) {
	var objDiv = document.getElementById("show_article_rendom"+bid);
	
	url='ad_script-bk.php?bid='+bid+'&filename='+filename+'&mainwidth='+mainwidth+'&global_theme='+global_theme;

					
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function show_virtual_list(bid,b_link) {
	var objDiv = document.getElementById("show_virtual_list"+bid);
	
	url='ewt_virtual.php?vid='+b_link;

					
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function show_org_list(bid) {
	var objDiv = document.getElementById("show_org_list"+bid);
	
	url='org_preview.php';

					
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;

 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
</script>
<script type="text/javascript">
function category_swebb(obj){
var objDiv = document.getElementById("category_swebb");
	url='webboard_category.php?type='+obj;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
}
function ajax_save_menu_log(m_id, mp_id, Glink, Gtarget){
	
var objDiv = document.getElementById("category_swebb");
	url='menu_log.php?m_id='+m_id+'&mp_id='+mp_id;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
				if(Gtarget=='_blank') {
					window.open(Glink,'myWindow');
				} else {
					window.location.href=Glink;
				}
			}
		}
	);
}
function ajax_save_log(url){
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
			}
		}
	);
}
</script>
<!-- script type="text/javascript">
function ChangeLanguage(lang){
 					document.all.formtextchangelang.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"changeform\" method=\"post\" action=\"ewt_language_block.php\"><input name=\"language\" type=\"hidden\" id=\"language\" value=\""+ lang +"\"><input name=\"filename\" type=\"hidden\" id=\"filename\" value=\"<?php echo $filename; ?>\"><input name=\"page\" type=\"hidden\" id=\"page\" value=\"" + this.location + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
changeform.submit();
 }
</script -->
<?php
/*	if($_SESSION["EWT_MID"] != ""){
		include("ewt_toolbar.php");
	} */


$show_file_type = 'N';//Y=แสดง icon file type ที่ article
$choose = 'Y';//ภาพ$choose = 'Y';//สร้าง//กำหนดที่ewt_c.php
//$set_article_date ='Y';//แสดงต่อท้าย
$set_article_date ='N';//แสดงบันทัดใหม่
$set_calendar_registor ='Y';//แสดงบันทัดใหม่
?>
<!-- span id="formtextchangelang"></span -->

<!-- ไฟล์นี้มีการเขียน html ซึ่งจะไปอยู่ใน body อัตโนมัติ จึงต้องเอาไว้ล่างสุด -->
<script type="text/javascript" src="js/stm31.js"></script>

