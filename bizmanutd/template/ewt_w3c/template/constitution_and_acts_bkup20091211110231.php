
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML lang="th">
	<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
	<meta name="Keywords" content="ยินดีต้อนรับสู่ รัฐสภาไทย">
<meta name="Description" content="ยินดีต้อนรับสู่ รัฐสภาไทย">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<link id="stext" href="../css/normal.css" rel="stylesheet" type="text/css">
<link href="../css/style_w3c.css" rel="stylesheet" type="text/css">
<link href="../css/jquery.cluetip.css" rel="stylesheet" type="text/css">
<style type="text/css">
 body {
 background-color: #FCF1BC;
 }
 td.c-8 { background-color:#FFFFFF;}
 table.c-7 {WIDTH: 100%; HEIGHT: 60px}
 td.c-6 { background-color:#FFFFFF;}
 td.c-5 { background-color:#FFFFFF; height:160px;}
 td.c-4 { background-color:#FFFFFF}
 td.c-3 {background-color: #E1E1E1}
 img.c-2 {cursor:pointer}
 td.c-1 { background:url(images/design/constitution_and_acts/bg_top.jpg); height:300px; }
</style>
</HEAD><body>



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
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="235" class="c-4">
<div><table width="98%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td class="c-3">
<form name="search2173" method="post" action="search_result.php">
<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>  ค้นหา : <input type="text" name="keyword" id="keyword" size="20" value="" alt=""></td>
<td><img src="../images/icon_search.jpg" class="c-2" onclick="document.search2173.submit();" alt=""></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</div>
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="main.php?filename=index08" accesskey="12">เมนูหลักรัฐธรรมนูญ</a></td>
</tr>
<tr valign="top">
<td><a href="main.php?filename=index08" accesskey="13">หน้าแรก</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1840" accesskey="14">รัฐธรรมนูญฉบับปัจจุบัน</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1841" accesskey="15">รวมรัฐธรรมนูญไทย</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1842" accesskey="16">สาระน่ารู้ /
บทความ</a></td>
</tr>
<tr valign="top">
<td><a href="http://www.parliament.go.th/parcy/sapa_db/cons_doc/constitutions/index.htm" accesskey="17">รัฐธรรมนูญทั่วโลก</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1844" accesskey="18">พระราชบัญญัติประกอบรัฐธรรมนูญ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2939&amp;amp;filename=index" accesskey="19">การแก้ไขเพิ่มเติมรัฐธรรมนูญ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2940&amp;amp;filename=index" accesskey="20">รายงานคณะกรรมาธิการวิสามัญ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2941&amp;amp;filename=index" accesskey="21">รายงานคณะกรรมาธิการสามัญ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2942&amp;amp;filename=index" accesskey="22">เอกสารอื่นๆ</a></td>
</tr>
<tr valign="top">
<td><a href="main.php?filename=index08" accesskey="23">เมนูหลักพระราชบัญญัติ</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=11087&amp;amp;filename=index" accesskey="24">ความรู้ที่เกี่ยวกับพระราชบัญญัติ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2284" accesskey="25">พระราชบัญญัติที่เป็นกฎหมาย</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2285" accesskey="26">กฎหมายประกอบรัฐธรรมนูญรายปี</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2286" accesskey="27">รวมกฎหมายรายปี</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2287" accesskey="28">พระราชบัญญัติงบประมาณรายจ่าย</a></td>
</tr>
<tr valign="top">
<td>การพิจารณาร่างพระราชบัญญัติ
<ul>
<li><a href="more_news.php?cid=1822" accesskey="29">ร่างพระราชบัญญัติที่อยู่ระหว่าง<br>
การพิจารณา จำแนกตามชุดของสภา</a></li>
<li><a href="more_news.php?cid=2292" accesskey="30">พระราชบัญญัติที่ผ่านความ<br>
เห็นชอบแล้ว จำแนกตามชุดของสภา</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td>การพิจารณาญัตติ
<ul>
<li>อยู่ระหว่างการพิจารณา</li>
<li>พิจารณาแล้วเสร็จ</li>
</ul>
</td>
</tr>
<tr valign="top">
<td>กระทู้ถาม
<ul>
<li>กระทู้ถามสด</li>
<li>กระทู้ถามทั่วไป</li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="main.php?filename=sitemap_08" accesskey="31">แผนผังเว็บไซต์</a></td>
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
<td><a href="calendar_all.php?filename=constitution_and_acts" accesskey="32">ดูปฏิทินทั้งหมด</a></td>
</tr>
</table>
</div>
<div>
<hr>
<table>
<tr>
<td align="center">จำนวนผู้เยี่ยมชมเว็บไซต์<br>
<img src="../ewt_c.php?n=MjYzNzE1" alt="263715"></td>
</tr>
</table>
</div>
</td>
<td id="ewt_main_structure_body" width="723" class="c-5"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="10" class="c-6"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-8" colspan="3">
<div>
<table class="c-7" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td align="center" style="background:url(../images/design/constitution_and_acts/bg_bottom.jpg)"><img height="60" alt="" src="../images/design/constitution_and_acts/b3.jpg" width="526" border="0"></td>
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