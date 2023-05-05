
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
 background-color: #FFFFFF;
 }
 td.c-6 { background-color:#FFFFFF;}
 td.c-5 { background-color:#FFFFFF;}
 td.c-4 { height:160px;}
 td.c-3 { background-color:#FFFFFF}
 td.c-2 {  height:257px; }
 table.c-1 {WIDTH: 100%; BORDER-COLLAPSE: collapse}
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
<td id="ewt_main_structure_top" class="c-2" colspan="3">
<div>
<table class="c-1">
<tbody>
<tr>
<td><img border="0" alt="logo" src="../images/design/parliament_and_people/top1.jpg" width="376" height="184"></td>
</tr>
</tbody>
</table>
</div>
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="main.php?filename=committee_03" accesskey="1">หน้าแรก</a></td>
<td>|</td>
<td><a href="ewt_news.php?nid=1167" accesskey="2">อำนาจหน้าที่</a></td>
<td>|</td>
<td><a href="more_news.php?cid=375" accesskey="3">รายนามในคณะกรรมาธิการ</a></td>
<td>|</td>
<td><a href="more_news.php?cid=381" accesskey="4">การประชุม</a></td>
<td>|</td>
<td><a href="more_news.php?cid=384" accesskey="5">กิจกรรม</a></td>
<td>|</td>
<td><a href="more_news.php?cid=393" accesskey="6">รายชื่อคณะอนุกรรมาธิการ</a></td>
<td>|</td>
<td><a href="more_news.php?cid=403" accesskey="7">ข้อคิดเห็น</a></td>
<td>|</td>
<td><a href="more_news.php?cid=404" accesskey="8">ฝ่ายเลขานุการ</a></td>
</tr>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="208" class="c-3">
<div>
<table width="100%" border="0">
<tr valign="top">
<td>เมนูหลัก</td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=10837" accesskey="9">ประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=10838" accesskey="10">รองประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=326&amp;amp;filename=index" accesskey="11">ประธานสภาผู้แทนราษฎร</a></td>
</tr>
<tr valign="top">
<td>รองประธานสภาผู้แทนราษฎร  
<ul>
<li><a href="ewt_news.php?nid=329&amp;amp;filename=index" accesskey="12">รองประธาน คนที่ 1</a></li>
<li><a href="ewt_news.php?nid=332&amp;amp;filename=index" accesskey="13">รองประธาน คนที่ 2</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=335&amp;amp;filename=index" accesskey="14">ผู้นำฝ่ายค้าน</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=1057&amp;amp;filename=index" accesskey="15">ประธานวุฒิสภา</a>
<ul>
<li><a href="ewt_news.php?nid=1059&amp;amp;filename=index" accesskey="16">รองประธานวุฒิสภาคนที่ 1</a></li>
<li><a href="ewt_news.php?nid=1061&amp;amp;filename=index" accesskey="17">รองประธานวุฒิสภาคนที่ 2</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td>ทำเนียบสมาชิกรัฐสภา
<ul>
<li><a href="more_news.php?cid=66&amp;amp;filename=index012" accesskey="18">สมาชิกสภาผู้แทนราษฎร</a></li>
<li><a href="more_news.php?cid=83&amp;amp;filename=index" accesskey="19">สมาชิกวุฒิสภา</a></li>
</ul>
</td>
</tr>
</table>
</div>
</td>
<td id="ewt_main_structure_body" width="540" class="c-4"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="208" class="c-5"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-6" colspan="3">
<div>
<table class="c-1">
<tbody>
<tr>
<td><img height="55" alt="parlaiment" src="../images/design/parliament_and_people/b4.jpg" width="529" border="0"></td>
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