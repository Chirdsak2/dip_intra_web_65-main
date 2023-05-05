
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
<link href="../css/w3c.css" rel="stylesheet" type="text/css">
<style type="text/css">
 body {
 background-color: #0000CC;
 }
 td.c-11 { background-color:#FFFFFF;}
 td.c-10 { background-color:#FFFFFF;}
 td.c-9 { background-color:#FFFFFF; height:160px;}
 td.c-8 { background-color:#FFFFFF}
 td.c-7 { background-color:#FFFF33; height:257px; }
 td.c-6 {COLOR: #555555; FONT-FAMILY: Tahoma; FONT-SIZE: 11px; FONT-WEIGHT: bold; TEXT-DECORATION: none; background-color: #FFFFFF}
 table.c-5 {BACKGROUND: #ffd700; WIDTH: 100%; BORDER-COLLAPSE: collapse}
 td.c-4 {BACKGROUND: #ffd700}
 span.c-3 {COLOR: #000000; FONT-FAMILY: Arial Black; FONT-SIZE: 24pt}
 span.c-2 {FONT-SIZE: 24pt; COLOR: #000000; FONT-FAMILY: Arial Black}
 img.c-1 {WIDTH: 132px; HEIGHT: 73px}
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
<td id="ewt_main_structure_top" class="c-7" colspan="3">
<div>
<table class="c-5">
<tbody>
<tr>
<td class="c-4"><span class="c-2"><img class="c-1" height="532" alt="" src="../images/rainbow.jpg" width="800" border="0"><span class="c-2">เว็บไซต์ผู้บกพร่องทางสายตา</span></span>
<div><span class="c-3">(template test_w3c)</span></div>
</td>
</tr>
<tr>
<td>
<div> </div>
</td>
</tr>
</tbody>
</table>
</div>
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="main.php?filename=index01" accesskey="1">รัฐสภา</a></td>
<td>|</td>
<td><a href="main.php?filename=index02" accesskey="2">สภาผู้แทนราษฎร</a></td>
<td>|</td>
<td><a href="http://www.senate.go.th/main/senate/" accesskey="3">วุฒิสภา</a></td>
<td>|</td>
<td>คณะกรรมาธิการ
<ul>
<li><a href="http://www.parliament.go.th/parcy/committee_index.php" accesskey="4">คณะกรรมาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/committee2551/main/committee.php" accesskey="5">คณะกรรมาธิการวุฒิสภา</a></li>
</ul>
</td>
<td>|</td>
<td>สำนักงานเลขาธิการ
<ul>
<li><a href="main.php?filename=index_05" accesskey="6">สำนักงานเลขาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/2009/" accesskey="7">สำนักงานเลขาธิการวุฒิสภา</a></li>
</ul>
</td>
<td>|</td>
<td><a href="main.php?filename=index_07" accesskey="8">รัฐสภาระหว่างประเทศ</a></td>
<td>|</td>
<td><a href="main.php?filename=index08" accesskey="9">รัฐธรรมนูญและพระราชบัญญัติ</a></td>
<td>|</td>
<td><a href="main.php?filename=index09" accesskey="10">รัฐสภาคู่ประชาชน</a></td>
<td>|</td>
<td><a href="#" accesskey="11">สมาชิกรัฐสภา</a></td>
</tr>
</table>
</div>
<div>
<table cellspacing="1" cellpadding="6" width="120" border="0">
<tbody>
<tr>
<td class="c-6">FONTSIZE <a onclick="changeStyle('small');" href="#size"><img height="10" src="../mainpic/s.gif" width="10" border="0" alt="small"></a> <a onclick="changeStyle('normal');" href="#size"><img height="10" src="../mainpic/n.gif" width="10" border="0" alt="normal"></a> <a onclick="changeStyle('big');" href="#size"><img height="10" src="../mainpic/b.gif" width="10" border="0" alt="big"></a></td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="208" class="c-8">
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="ewt_news.php?nid=10827" accesskey="12">รัฐสภาตามบทบัญญัติรัฐธรรมนูญ</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=10836" accesskey="13">โครงสร้างของรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=10834" accesskey="14">อำนาจหน้าที่</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=2352" accesskey="15">ประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=2356" accesskey="16">รองประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td>สมาชิกรัฐสภา
<ul>
<li>สมาชิกสภาผู้แทนราษฎร</li>
<li>สมาชิกวุฒิสภา</li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1803" accesskey="17">ทำเนียบประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td>----------------------------------</td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2926&amp;amp;filename=index" accesskey="18">กฎหมายและระเบียบ</a></td>
</tr>
<tr valign="top">
<td>แบบฟอร์มบริการ</td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=8663" accesskey="19">ข้อบังคับการประชุมรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="../download/parliament_law/13-20070827163114_1.pdf" accesskey="20">รัฐธรรมนูญฉบับปัจจุบัน</a></td>
</tr>
<tr valign="top">
<td>----------------------------------</td>
</tr>
<tr valign="top">
<td><a href="library2.parliament.go.th/library/home.html" accesskey="21">หอสมุดรัฐสภา</a></td>
</tr>
<tr valign="top">
<td>เยี่ยมชมรัฐสภา</td>
</tr>
</table>
</div>
</td>
<td id="ewt_main_structure_body" width="748" class="c-9"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="0" class="c-10"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-11" colspan="3"></td>
</tr>
<tr>
<td colspan="3" align="center"><span id="formtextchangelang"></span>#htmlw3c_spliter#</td>
</tr>
</table>
</body></HTML>