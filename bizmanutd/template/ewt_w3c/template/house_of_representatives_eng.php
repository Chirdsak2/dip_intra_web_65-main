
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML lang="th">
	<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
	<title>ยินดีต้อนรับเข้าสู่ เว็บไซต์รัฐสภาไทย</title>
<meta name="Keywords" content="ยินดีต้อนรับสู่ รัฐสภาไทย">
<meta name="Description" content="ยินดีต้อนรับสู่ รัฐสภาไทย">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<link id="stext" href="../css/normal.css" rel="stylesheet" type="text/css">
<link href="../css/style_w3c.css" rel="stylesheet" type="text/css">
<link href="../css/jquery.cluetip.css" rel="stylesheet" type="text/css">
<style type="text/css">
 body {
 background-image: url(images/design/house_of_representatives/house_of_representatives_01.jpg);
 }
 td.c-14 { background-color:#FFFFFF;}
 div.c-13 {text-align: center}
 p.c-12 {text-align: left}
 span.c-11 {FONT-SIZE: 10pt; COLOR: #71633e; FONT-FAMILY: Tahoma}
 td.c-10 { background-color:#FFFFE5;}
 td.c-9 { background-color:#FFFFE5; height:160px;}
 td.c-8 { background:url(images/design/house_of_representatives/house_of_representatives_27.jpg);}
 span.c-7 {COLOR: #ffffff; FONT-FAMILY: Tahoma}
 span.c-6 {FONT-SIZE: 10pt}
 td.c-5 {background-color: #E0C36E}
 img.c-4 {cursor:pointer}
 td.c-3 { background-color:#FFFFE5;  }
 span.c-2 {FONT-SIZE: 8pt; COLOR: #c66105; FONT-FAMILY: Tahoma}
 a.c-1 {COLOR: #b11216}
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
function txt_area2(prov,gid) {
  var objDiv = document.getElementById("nav2"+gid);
  objDiv.style.display = '';
  url='list_aumphur.php?prov='+prov+'&gid='+gid;

          
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
function validLength(item,min,max){
      return (item.length>= min) && (item.length<=max)
}
function valid2EMail(mailObj){
    if (validLength(mailObj.value,1,50)){
      //return false;
      if (mailObj.value.search("^.+@.+\\..+$") != -1)
        return true;
      else return false;
    }
    return true;
}
function validEMail(mailObj){
    if (validLength(mailObj.value,1,50)){
      //return false;
      if (mailObj.value.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
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
<table id="ewt_main_structure" width="956" border="0" cellpadding="0" cellspacing="0" align="center">
<tr valign="top">
<td id="ewt_main_structure_top" class="c-3" colspan="3">
<div><script type="text/JavaScript">
//<![CDATA[
<!--
function MM_preloadImages() { //v3.0
 var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
 var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
 if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
 var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
 var p,i,x; if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
 d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
 if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
 for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
 if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
 var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
 if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
//]]>
</script>
<table cellspacing="0" cellpadding="0" width="100%" border="0">
<tbody>
<tr>
<td width="385"><img alt="" src="../images/design/house_of_representatives/h_eng_02.jpg" border="0"></td>
<td width="214"><img height="85" src="../images/design/house_of_representatives/house_eng_03.jpg" width="214" alt=""></td>
<td valign="top" style="background:url(../images/design/house_of_representatives/house_of_representatives_04.jpg)">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
<tbody>
<tr>
<td align="right"><img height="27" src="../images/design/house_of_representatives/back_home.jpg" width="24" alt=""></td>
<td width="47"><span class="c-2"><strong><a title="Home" class="c-1" href="main.php?filename=portal_01___EN">Home</a></strong></span></td>
</tr>
</tbody>
</table>
</td>
<td valign="top" width="105" style="background:url(../images/design/house_of_representatives/house_of_representatives_04.jpg)">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
<tbody>
<tr>
<td width="20"><img height="28" src="../images/design/house_of_representatives/house_of_representatives_06.jpg" width="20" alt=""></td>
<td width="22"><a href="main.php?filename=index02"><img id="Image1" onmouseover="MM_swapImage('Image1','','images/design/house_of_representatives/th_eng_07.jpg',1)" onmouseout="MM_swapImgRestore()" height="28" alt="THAI" src="../images/design/house_of_representatives/house_of_representatives_07.jpg" width="22" border="0" name="Image1"></a></td>
<td width="6"><img height="28" src="../images/design/house_of_representatives/house_of_representatives_08.jpg" width="6" alt=""></td>
<td width="30"><a href="main.php?filename=index02___EN"><img id="Image2" onmouseover="MM_swapImage('Image2','','images/design/house_of_representatives/th_eng_09.jpg',1)" onmouseout="MM_swapImgRestore()" height="28" alt="ENG" src="../images/design/house_of_representatives/house_of_representatives_09.jpg" width="30" border="0" name="Image2"></a></td>
<td><img height="28" src="../images/design/house_of_representatives/house_of_representatives_10.jpg" width="27" alt=""></td>
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
<td><a href="main.php?filename=index01___EN" accesskey="1">The National Assembly</a></td>
<td>|</td>
<td><a href="main.php?filename=index02___EN" accesskey="2">The
House of Representatives</a></td>
<td>|</td>
<td><a href="main.php?filename=index_03___EN" accesskey="3">The Senate</a></td>
<td>|</td>
<td><a href="main.php?filename=index_05___EN" accesskey="4">The Secretariat of The House of Representatives</a></td>
<td>|</td>
<td><a href="main.php?filename=index_06___EN" accesskey="5">The Secretariat of The Senate</a></td>
</tr>
</table>
</div>
<div>
<table width="100%" border="0">
<tr valign="top">
<td>Committees
<ul>
<li><a href="ewt_news.php?nid=9589" accesskey="6">The Committees of The House of Representatives</a></li>
<li><a href="ewt_news.php?nid=9590" accesskey="7">The Committees of The Senate</a></li>
</ul>
</td>
<td>|</td>
<td><a href="main.php?filename=index_07___EN" accesskey="8">Inter Parliamentary Works</a></td>
<td>|</td>
<td><a href="main.php?filename=index08___EN" accesskey="9">Constitution and Acts</a></td>
<td>|</td>
<td><a href="main.php?filename=index09___EN" accesskey="10">Parliament and People</a></td>
<td>|</td>
<td><a href="parliament_en.php" accesskey="11">Members of
Parliament</a></td>
</tr>
</table>
</div>
<div>
<table cellspacing="0" cellpadding="0" width="100%" border="0">
<tbody>
<tr>
<td style="background:url(../images/design/house_of_representatives/house_of_representatives_16.jpg)">
 </td>
<td align="center" width="907"><object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" height="164" width="941" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param name="_cx" value="24897">
<param name="_cy" value="4339">
<param name="FlashVars" value="">
<param name="Movie" value="images/design/flash/house.swf">
<param name="Src" value="images/design/flash/house.swf">
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
<td style="background:url(../images/design/house_of_representatives/house_of_representatives_18.jpg)">
 </td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="228" class="c-8">
<div><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="c-5">
<form name="search2173" method="post" action="search_result.php">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>Search : <input type="text" name="keyword" id="keyword" size="20" value="" alt=""></td>
<td><img src="../images/icon_search2.jpg" class="c-4" onclick="document.search2173.submit();" alt=""></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</div>
<div>
<table cellspacing="0" cellpadding="0" width="228" border="0">
<tbody>
<tr>
<td style="background:url(../images/design/house_of_representatives/house_of_representatives_27.jpg)">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
<tbody>
<tr>
<td style="background:url(../images/design/house_of_representatives/house_of_representatives_19.jpg)" height="32"><span class="c-7"><strong><span class="c-6">   Main
Menu</span></strong></span></td>
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
<td><a href="main.php?filename=index02___EN" accesskey="12">Home</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=57" accesskey="13">Roles /Powers and
Duties<br>
/Missions</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=58" accesskey="14">The House of
Representatives<br>
System</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=64" accesskey="15">The current rules
of procedure<br>
of the House of Representatives</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=59" accesskey="16">The Speaker of
the House<br>
of Representatives</a></td>
</tr>
<tr valign="top">
<td>Deputy Speaker of the House<br>
of Representatives
<ul>
<li><a href="more_news.php?cid=60" accesskey="17">   First Deputy Speaker of  the House of Representatives</a></li>
<li><a href="more_news.php?cid=61" accesskey="18">   Second Deputy Speaker of the House of Representatives</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=62" accesskey="19">Leader of the Opposition</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=63" accesskey="20">Biographical
Directory of the<br>
Speakers of the House<br>
of Rrepresentatives</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=66" accesskey="21">The 23rd Members
of the<br>
House of Representatives</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2206" accesskey="22">services</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=68" accesskey="23">The Bills which
are being<br>
considered by the House<br>
of Representatives</a></td>
</tr>
<tr valign="top">
<td><a href="main.php?filename=sitemap_02___EN" accesskey="24">Sitemap</a></td>
</tr>
<tr valign="top">
<td></td>
</tr>
</table>
</div>
<div>
<hr>
<table width="100%" border="0">
<tr>
<td>
<h1>ปฏิทินกิจกรรม ธันวาคม  2552</h1>
</td>
</tr>
<tr>
<td>ไม่พบข้อมูล</td>
</tr>
<tr>
<td><a href="calendar_all.php?filename=house_of_representatives_eng" accesskey="25">ดูปฏิทินทั้งหมด</a></td>
</tr>
</table>
</div>
<div>
<hr>
<table>
<tr>
<td align="center">จำนวนผู้เยี่ยมชมเว็บไซต์<br>
<img src="../ewt_c.php?n=MjYzNzQ1" alt="263745"></td>
</tr>
</table>
</div>
</td>
<td id="ewt_main_structure_body" width="720" class="c-9"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="8" class="c-10"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-14" colspan="3">
<div>
<table cellspacing="0" cellpadding="0" width="100%" border="0">
<tbody>
<tr>
<td style="background:url(../images/design/house_of_representatives/house_of_representatives_31.jpg)" height="30"> </td>
<td align="center" style="background:url(../images/design/house_of_representatives/house_of_representatives_31.jpg)">
<p class="c-12"><span class="c-11"> </span></p>
</td>
<td style="background:url(../images/design/house_of_representatives/house_of_representatives_31.jpg)">
 </td>
</tr>
<tr>
<td style="background:url(../images/design/house_of_representatives/house_of_representatives_35.jpg)">
 </td>
<td width="870" style="background:url(../images/design/house_of_representatives/house_of_representatives_36.jpg)" height="42"> </td>
<td style="background:url(../images/design/house_of_representatives/house_of_representatives_37.jpg)">
 </td>
</tr>
<tr>
<td> </td>
<td>
<div class="c-13"><span class="c-11"><img alt="" src="../images/design/house_of_representatives/2.jpg" border="0"></span></div>
</td>
<td> </td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
<tr>
<td colspan="3" align="center"><span id="formtextchangelang"></span></td>
</tr>
</table>
</body></HTML>