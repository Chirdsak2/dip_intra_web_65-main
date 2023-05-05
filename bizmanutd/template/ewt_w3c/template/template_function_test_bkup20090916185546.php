<!doctype HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
	<html lang="th">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
	<title></title>
<meta name="Keywords" content="">
<meta name="Description" content="">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/jquery.cluetip.css" rel="stylesheet" type="text/css">
<link href="../css/normal.css" id="stext" rel="stylesheet" type="text/css">
<link href="../css/interface.css" rel="stylesheet" type="text/css">
<style type="text/css">
              <!--
                #body_wrap {
                  margin: 0 auto;
                }
                #content {
                  float: left;
                }
                .gallery {
                  min-height: 108px;
                  list-style: none;
                }
                * html .gallery {
                  height: 108px;
                }
                .gallery li {
                  float: left;
                  width: 120px;
                  height: 150px;
                  margin: 8px 8px 8px 8px;
                }
                -->
</style>

<style type="text/css">
 body {
 background-color: #FCF1BC;
 }
 table.c-6 {WIDTH: 100%; HEIGHT: 60px}
 td.c-5 { background-color:#FFFFFF;}
 td.c-4 { background-color:#FFFFFF; height:160px;}
 td.c-3 { background-color:#FFFFFF}
 td.c-2 {COLOR: #555555; FONT-FAMILY: Tahoma; FONT-SIZE: 11px; FONT-WEIGHT: bold; TEXT-DECORATION: none; background-color: #FFFFFF}
 td.c-1 { background:url(images/design/constitution_and_acts/bg_top.jpg); height:300px; }
</style>
</head><body>
<script language="JavaScript" type="text/javascript" src="../js/calendar.js">
</script>
<script language="JavaScript" type="text/javascript" src="../js/loadcalendar.js">
</script>
<script language="JavaScript" type="text/javascript" src="../js/calendar-th.js">
</script>
<script type="text/javascript" language="javascript" src="../js/AjaxRequest.js">
</script>
<script type="text/javascript" language="javascript" src="../js/excute.js">
</script>
<script type="text/javascript" language="javascript" src="../js/lang.js">
</script>
<script type="text/javascript" language="javascript" src="../js/jquery/jquery-1.2.3.pack.js">
</script>
<script src="../js/jquery/jquery.cluetip.js" type="text/javascript" language="javascript">
</script>
<script language="javascript1.2" type="text/javascript">
function txt_area(prov,amph,gid) {
 var objDiv = document.getElementById("nav"+gid);
 objDiv.style.display = '';
 url='list_tumbon.php?prov='+prov+'&&h='+amph+'&gid='+gid;

     
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
function validLength(item,min,max){
   return (item.length>= min) && (item.length<=max)
}
function valid2EMail(mailObj){
  if (validLength(mailObj.value,1,50)){
   //return false;
   if (mailObj.value.search("^.+@.+\..+$") != -1)
    return true;
   else return false;
  }
  return true;
}
function validEMail(mailObj){
  if (validLength(mailObj.value,1,50)){
   //return false;
   if (mailObj.value.search("^.+@.+(.com)|(.net)|(.edu)|(.mil)|(.gov)|(.org)|(.co.th)|(.go.th)|(.localnet)$") != -1)
    return true;
   else return false;
  }
  return true;
}

function help(page_id){
window.open('help.php?page='+page_id+'','help_popup','top=60,left=80,width=800,height=600,resizable=0,status=0');
}
</script>
<script type="text/javascript" language="javascript">
 function changeStyle(c) {
  var x = document.getElementsByTagName("span");
  for (i=0;x && i < x.length; i++) {
   x[i].removeAttribute("style");
  }
  document.all.stext.href='../css/'+c+'.css';
 }
</script>
<table id="ewt_main_structure" width="968" border="0" cellpadding="0" cellspacing="0" align="center">
<tr valign="top">
<td id="ewt_main_structure_top" class="c-1" colspan="3">
<div>
<table cellspacing="0" cellpadding="0" width="968" align="center" border="0">
<tbody>
<tr>
<td width="480"><img height="267" src="../images/design/constitution_and_acts/constitution1_01.jpg" width="480" alt=""></td>
<td width="404" style="background:url(../images/design/constitution_and_acts/constitution1_02.jpg)">
<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" height="267" width="404" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param name="_cx" value="10689">
<param name="_cy" value="7064">
<param name="FlashVars" value="">
<param name="Movie" value="images/design/flash/constitution.swf">
<param name="Src" value="images/design/flash/constitution.swf">
<param name="WMode" value="Transparent">
<param name="Play" value="-1">
<param name="Loop" value="-1">
<param name="Quality" value="High">
<param name="SAlign" value="">
<param name="Menu" value="-1">
<param name="Base" value="">
<param name="AllowScriptAccess" value="">
<param name="Scale" value="ShowAll">
<param name="DeviceFont" value="0">
<param name="EmbedMovie" value="0">
<param name="BGColor" value="">
<param name="SWRemote" value="">
<param name="MovieData" value="">
<param name="SeamlessTabbing" value="1">
<param name="Profile" value="0">
<param name="ProfileAddress" value="">
<param name="ProfilePort" value="0">
<param name="AllowNetworking" value="all">
<param name="AllowFullScreen" value="false">
</object></td>
<td valign="top">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
<tbody>
<tr>
<td><a title="Thai" href="main.php?filename=index08"><img height="23" alt="Thai" src="../images/design/constitution_and_acts/constitution1_03.jpg" width="84" border="0"></a></td>
</tr>
<tr>
<td><a title="Eng" href="main.php?filename=index08___EN"><img height="25" alt="Eng" src="../images/design/constitution_and_acts/constitution1_04.jpg" width="84" border="0"></a></td>
</tr>
<tr>
<td><a href="main.php?filename=portal_01"><img height="24" alt="กลับหน้าหลัก" src="../images/design/constitution_and_acts/back_home.jpg" width="84" border="0"></a></td>
</tr>
<tr>
<td><img height="195" src="../images/design/constitution_and_acts/constitution1_05.jpg" width="84" alt=""></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="main.php?filename=index01">รัฐสภา</a></td>
<td>|</td>
<td><a href="main.php?filename=index02">สภาผู้แทนราษฎร</a></td>
<td>|</td>
<td><a href="main.php?filename=index_03">วุฒิสภา</a></td>
<td>|</td>
<td>คณะกรรมาธิการ
<ul>
<li><a href="more_news.php?cid=88">คณะกรรมาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="more_news.php?cid=88">คณะกรรมาธิการวุฒิสภา</a></li>
</ul>
</td>
<td>|</td>
<td>สำนักงานเลขาธิการ
<ul>
<li><a href="main.php?filename=index_05">สำนักงานเลขาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="main.php?filename=index_06">สำนักงานเลขาธิการวุฒิสภา</a></li>
</ul>
</td>
<td>|</td>
<td><a href="main.php?filename=index_07">รัฐสภาระหว่างประเทศ</a></td>
<td>|</td>
<td><a href="main.php?filename=index08">รัฐธรรมนูญและพระราชบัญญัติ</a></td>
<td>|</td>
<td><a href="main.php?filename=index09">รัฐสภาคู่ประชาชน</a></td>
<td>|</td>
<td><a href="parliament.php">สมาชิกรัฐสภา</a></td>
</tr>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="235" class="c-3">
<div>
<table cellspacing="1" cellpadding="6" width="120" border="0">
<tbody>
<tr>
<td class="c-2">FONTSIZE <a onclick="changeStyle('small');" href="#size"><img height="10" src="../mainpic/s.gif" width="10" border="0" alt="small"></a> <a onclick="changeStyle('normal');" href="#size"><img height="10" src="../mainpic/n.gif" width="10" border="0" alt="normal"></a> <a onclick="changeStyle('big');" href="#size"><img height="10" src="../mainpic/b.gif" width="10" border="0" alt="big"></a></td>
</tr>
</tbody>
</table>
</div>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><a onclick="ChangeLanguage('','><?php echo $filename;?>')" href="#language"><span class="text_head">thai</span></a> | <a onclick="ChangeLanguage('EN','><?php echo $filename;?>')" href="#language"><span class="text_head">English</span></a> </td>
</tr>
</table>
</div>
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="main.php?filename=function_test_391">หน้าหลักการทดสอบ</a></td>
</tr>
<tr valign="top">
<td><a href="main.php?filename=test_01">3.2 ปรับขนาดตัวอักษร/3.3
การจัดการ content</a></td>
</tr>
<tr valign="top">
<td><a href="main.php?filename=function_test_391">3.4
ระบบรองรับหลายภาษา</a></td>
</tr>
<tr valign="top">
<td>3.8 ระบบแผนผังเว็บไซต์แบบไดนามิก </td>
</tr>
<tr valign="top">
<td>3.9 ลักษณะโมดูลตามรายละเอียดต่างๆ
<ul>
<li>(2) เมนู</li>
<li>(4) ขนาดตัวอีกษร</li>
<li>(5) การจัดการ content</li>
<li>(6) Article Management</li>
<li>(7) Multi-language</li>
<li>(9) banner</li>
<li>(10) fromgeneretor</li>
<li>(11) poll</li>
<li>(12) Enewsleter</li>
<li>(13) Webboard</li>
<li>(14) FAQ</li>
<li>(15) Link Management</li>
<li>(16) guest book</li>
<li>(17) site map</li>
<li>(18) การสมัครสมาชิก</li>
<li>(19) Orgenization Chat</li>
<li>(20) Calendar</li>
<li>(21) Gallery</li>
<li>(22) Counter</li>
<li>(24) E-book</li>
<li>(25) blog</li>
<li>(27) Share Content</li>
<li>(28) search</li>
</ul>
</td>
</tr>
</table>
</div>
</td>
<td id="ewt_main_structure_body" width="723" class="c-4"><?#w3c_spliter#?>
</td>
<td id="ewt_main_structure_right" width="10" class="c-5"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-5" colspan="3">
<div>
<table class="c-6" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td align="center" style="background:url(../images/design/constitution_and_acts/bg_bottom.jpg)"><img height="55" alt="" src="../images/design/constitution_and_acts/b3.jpg" width="519" border="0"></td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</table>
<span id="formtextchangelang"></span>
</body></html>