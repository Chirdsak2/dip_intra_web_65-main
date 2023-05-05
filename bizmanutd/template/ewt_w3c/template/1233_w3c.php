
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML lang="th">
	<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
	<title>ยินดีต้อนรับเข้าสู่ เว็บไซต์รัฐสภาไทย</title>
<meta name="Keywords" content="ยินดีต้อนรับสู่ รัฐสภาไทย">
<meta name="Description" content="ยินดีต้อนรับสู่ รัฐสภาไทย">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<link id="stext" href="../css/normal_w3c.css" rel="stylesheet" type="text/css">
<link href="../css/style_w3c.css" rel="stylesheet" type="text/css">
<link href="../css/w3c.css" rel="stylesheet" type="text/css">
<style type="text/css">
 td.c-7 { background-color:#FFFFFF;}
 span.c-6 {FONT-SIZE: 10pt; FONT-FAMILY: Verdana}
 td.c-5 { background-color:#FFFFFF;}
 td.c-4 { background-color:#FFFFFF; height:160px;}
 td.c-3 { background-color:#FFFFFF}
 td.c-2 { background-color:#FFFFFF;  }
 span.c-1 {FONT-SIZE: 24pt; FONT-FAMILY: Trebuchet MS}
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
  function changeStyle(c) {
    var x = document.getElementsByTagName("span");
    for (i=0;x && i < x.length; i++) {
      x[i].removeAttribute("style");
    }
    document.all.stext.href='../css/'+c+'_w3c.css';
  }
</script>
<noscript>Your browser does not support JavaScript!</noscript>
<table id="ewt_main_structure" width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
<tr valign="top">
<td id="ewt_main_structure_top" class="c-2" colspan="3">
<div><span class="c-1">646464</span></div>
<div>
<ul class="v_menu">
<li><a href="main.php?filename=index01___EN" title="The National Assembly(accesskey=1)" accesskey="1">The National Assembly</a></li>
<li><a href="main.php?filename=index02___EN" title="The House of Representatives(accesskey=2)" accesskey="2">The House
of Representatives</a></li>
<li><a href="main.php?filename=index_03___EN" title="The Senate(accesskey=3)" accesskey="3">The Senate</a></li>
<li><a href="main.php?filename=index_05___EN" title="The Secretariat of The House of Representatives(accesskey=4)" accesskey="4">The Secretariat of The House of Representatives</a></li>
<li><a href="main.php?filename=index_06___EN" title="The Secretariat of The Senate(accesskey=5)" accesskey="5">The Secretariat of The Senate</a></li>
</ul>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="20%" class="c-3">
<div>
<h1>ภาพข่าวสำนักงานเลขาธิการวุฒิสภา</h1>
<hr>
<ul>
<li><img src="../phpThumb.php?w=90&amp;amp;h=90&amp;amp;src=images/article/news11977/n20090626_11977.jpg" alt="วันคล้ายวันเกิดรองประธานวุฒิสภา คนที่สอง " align="middle"> <a href="ewt_news.php?filename=1233_w3c&amp;amp;nid=11977" target="_self" accesskey="6">วันคล้ายวันเกิดรองประธานวุฒิสภา
คนที่สอง</a></li>
<li><img src="../phpThumb.php?w=90&amp;amp;h=90&amp;amp;src=images/article/news11975/n20090626_11975.jpg" alt="วางพวงมาลา" align="middle"> <a href="ewt_news.php?filename=1233_w3c&amp;amp;nid=11975" target="_self" accesskey="7">วางพวงมาลา</a></li>
<li><img src="../phpThumb.php?w=90&amp;amp;h=90&amp;amp;src=images/article/news11974/n20090626_11974.jpg" alt="ยื่นหนังสือ" align="middle"> <a href="ewt_news.php?filename=1233_w3c&amp;amp;nid=11974" target="_self" accesskey="8">ยื่นหนังสือ</a></li>
<li><img src="../phpThumb.php?w=90&amp;amp;h=90&amp;amp;src=images/article/news11973/n20090626_11973.jpg" alt="วันที่ระลึกพระบาทสมเด็จพระปกเกล้าเจ้าอยู่หัว" align="middle"> <a href="ewt_news.php?filename=1233_w3c&amp;amp;nid=11973" target="_self" accesskey="9">วันที่ระลึกพระบาทสมเด็จพระปกเกล้าเจ้าอยู่หัว</a></li>
<li><img src="../phpThumb.php?w=90&amp;amp;h=90&amp;amp;src=images/article/news11972/n20090626_11972.jpg" alt="โครงการเสริมสร้างความพร้อมแก่ท้องถิ่น หลักสูตร กระบวนการเสริมสร้างผู้นำนักประชาธิปไตยแบบมีส่วนร่วม " align="middle"> <a href="ewt_news.php?filename=1233_w3c&amp;amp;nid=11972" target="_self" accesskey="10">โครงการเสริมสร้างความพร้อมแก่ท้องถิ่น หลักสูตร
กระบวนการเสริมสร้างผู้นำนักประชาธิปไตยแบบมีส่วนร่วม</a></li>
</ul>
<br>
<br>
<a href="more_news.php?filename=1233_w3c&amp;amp;cid=35" accesskey="11">อ่านทั้งหมด</a><br>
<br></div>
</td>
<td id="ewt_main_structure_body" width="60%" class="c-4"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="20%" class="c-5">
<div>
<hr>
<table width="100%" border="0">
<tr>
<td>
<h1>ปฏิทินกิจกรรม มิถุนายน  2553</h1>
</td>
</tr>
<tr>
<td>ไม่พบข้อมูล</td>
</tr>
<tr>
<td><a href="calendar_all.php?filename=1233_w3c" accesskey="12">ดูปฏิทินทั้งหมด</a></td>
</tr>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-7" colspan="3">
<div><span class="c-6">64646</span></div>
</td>
</tr>
<tr>
<td colspan="3" align="center"><span id="formtextchangelang"></span>#htmlw3c_spliter#</td>
</tr>
</table>
</body></HTML>