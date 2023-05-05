
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
 td.c-6 { background-color:#FFFFFF;}
 td.c-5 { background-color:#FFFFFF; height:160px;}
 td.c-4 { background-color:#FFFFFF}
 td.c-3 {font-weight: bold}
 td.c-2 { background-color:#FFFFFF; height:257px; }
 img.c-1 {WIDTH: 1024px; HEIGHT: 107px}
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
<table id="ewt_main_structure" width="956" border="0" cellpadding="0" cellspacing="0" align="center">
<tr valign="top">
<td id="ewt_main_structure_top" class="c-2" colspan="3">
<div><img class="c-1" border="0" alt="หัวเว็บไซต์" src="../images/Dock.jpg" width="1024" height="766"></div>
<div>
<ul class="v_menu">
<li><a href="main.php?filename=index01" title="รัฐสภา(accesskey=1)" accesskey="1">รัฐสภา</a></li>
<li><a href="main.php?filename=index02" title="สภาผู้แทนราษฎร(accesskey=2)" accesskey="2">สภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/main/senate/" title="วุฒิสภา(accesskey=3)" accesskey="3">วุฒิสภา</a></li>
<li><a href="http://www.parliament.go.th/parcy/committee_index.php" title="คณะกรรมาธิการสภาผู้แทนราษฎร(accesskey=4)" accesskey="4">คณะกรรมาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/committee2551/main/committee.php" title="คณะกรรมาธิการวุฒิสภา(accesskey=5)" accesskey="5">คณะกรรมาธิการวุฒิสภา</a></li>
<li><a href="main.php?filename=index_05" title="สำนักงานเลขาธิการสภาผู้แทนราษฎร(accesskey=6)" accesskey="6">สำนักงานเลขาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/2009/" title="สำนักงานเลขาธิการวุฒิสภา(accesskey=7)" accesskey="7">สำนักงานเลขาธิการวุฒิสภา</a></li>
<li><a href="main.php?filename=index_07" title="รัฐสภาระหว่างประเทศ(accesskey=8)" accesskey="8">รัฐสภาระหว่างประเทศ</a></li>
<li><a href="main.php?filename=index08" title="รัฐธรรมนูญและพระราชบัญญัติ(accesskey=9)" accesskey="9">รัฐธรรมนูญและพระราชบัญญัติ</a></li>
<li><a href="main.php?filename=index09" title="รัฐสภาคู่ประชาชน(accesskey=10)" accesskey="10">รัฐสภาคู่ประชาชน</a></li>
<li><a href="#" title="สมาชิกรัฐสภา(accesskey=11)" accesskey="11">สมาชิกรัฐสภา</a></li>
<li><a href="http://mp.parliament.go.th/biographical/frontweb/Human_Resource/PersonList.aspx" title="สมาชิกสภาผู้แทนราษฎร(accesskey=12)" accesskey="12">สมาชิกสภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/profile/main.php" title="สมาชิกวุฒิสภา(accesskey=13)" accesskey="13">สมาชิกวุฒิสภา</a></li>
</ul>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="208" class="c-4">
<div>
<table width="100%" border="0">
<tr valign="top">
<td class="c-3">เมนูหลัก</td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=10837" title="ประธานรัฐสภา(accesskey=14)" accesskey="14">ประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=10838" title="รองประธานรัฐสภา(accesskey=15)" accesskey="15">รองประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=326&amp;amp;amp;filename=index" title="ประธานสภาผู้แทนราษฎร (accesskey=16)" accesskey="16">ประธานสภาผู้แทนราษฎร</a></td>
</tr>
<tr valign="top">
<td>รองประธานสภาผู้แทนราษฎร  
<p><a href="ewt_news.php?nid=329&amp;amp;amp;filename=index" title="รองประธาน คนที่ 1(accesskey=17)" accesskey="17">รองประธาน คนที่
1</a></p>
<p><a href="ewt_news.php?nid=332&amp;amp;amp;filename=index" title="รองประธาน คนที่ 2(accesskey=18)" accesskey="18">รองประธาน คนที่
2</a></p>
</td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=335&amp;amp;amp;filename=index" title="ผู้นำฝ่ายค้าน(accesskey=19)" accesskey="19">ผู้นำฝ่ายค้าน</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=1057&amp;amp;amp;filename=index" title="ประธานวุฒิสภา(accesskey=20)" accesskey="20">ประธานวุฒิสภา</a>
<p><a href="ewt_news.php?nid=1059&amp;amp;amp;filename=index" title="รองประธานวุฒิสภาคนที่ 1(accesskey=21)" accesskey="21">รองประธานวุฒิสภาคนที่ 1</a></p>
<p><a href="ewt_news.php?nid=1061&amp;amp;amp;filename=index" title="รองประธานวุฒิสภาคนที่ 2(accesskey=22)" accesskey="22">รองประธานวุฒิสภาคนที่ 2</a></p>
</td>
</tr>
<tr valign="top">
<td>ทำเนียบสมาชิกรัฐสภา
<p><a href="more_news.php?cid=66&amp;amp;amp;filename=index012" title="สมาชิกสภาผู้แทนราษฎร (accesskey=23)" accesskey="23">สมาชิกสภาผู้แทนราษฎร</a></p>
<p><a href="more_news.php?cid=83&amp;amp;amp;filename=index" title="สมาชิกวุฒิสภา (accesskey=24)" accesskey="24">สมาชิกวุฒิสภา</a></p>
</td>
</tr>
</table>
</div>
</td>
<td id="ewt_main_structure_body" width="748" class="c-5"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="0" class="c-6"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-7" colspan="3"></td>
</tr>
<tr>
<td colspan="3" align="center"><span id="formtextchangelang"></span></td>
</tr>
</table>
</body></HTML>#htmlw3c_spliter#</td>
</tr>
</table>
</body>