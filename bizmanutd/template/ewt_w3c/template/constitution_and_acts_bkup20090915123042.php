
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML lang="th">
	<HEAD>
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
 table.c-7 {WIDTH: 100%; HEIGHT: 60px}
 td.c-6 { background-color:#FFFFFF;}
 td.c-5 { background-color:#FFFFFF; height:160px;}
 span.c-4 {FONT-SIZE: 10pt; COLOR: #0033ff; FONT-FAMILY: Tahoma}
 td.c-3 { background-color:#FFFFFF}
 table.c-2 {WIDTH: 100%; BORDER-COLLAPSE: collapse}
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
<table class="c-2">
<tbody>
<tr>
<td><img alt="" src="../images/design/constitution_and_acts/11.jpg" border="0"></td>
</tr>
</tbody>
</table>
</div>
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="main.php?filename=index08">เมนูหลักรัฐธรรมนูญ</a></td>
</tr>
<tr valign="top">
<td><a href="main.php?filename=index08">หน้าแรก</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1840">รัฐธรรมนูญฉบับปัจจุบัน</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1841">รวมรัฐธรรมนูญไทย</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1842">สาระน่ารู้ / บทความ</a></td>
</tr>
<tr valign="top">
<td><a href="http://www.parliament.go.th/parcy/sapa_db/cons_doc/constitutions/index.htm">
รัฐธรรมนูญทั่วโลก</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1844">พระราชบัญญัติประกอบรัฐธรรมนูญ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2939&amp;amp;filename=index">การแก้ไขเพิ่มเติมรัฐธรรมนูญ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2940&amp;amp;filename=index">รายงานคณะกรรมาธิการวิสามัญ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2941&amp;amp;filename=index">รายงานคณะกรรมาธิการสามัญ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2942&amp;amp;filename=index">เอกสารอื่นๆ</a></td>
</tr>
<tr valign="top">
<td><a href="main.php?filename=index08">เมนูหลักพระราชบัญญัติ</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=11087&amp;amp;filename=index">ความรู้ที่เกี่ยวกับพระราชบัญญัติ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2284">พระราชบัญญัติที่เป็นกฎหมาย</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2285">กฎหมายประกอบรัฐธรรมนูญรายปี</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2286">รวมกฎหมายรายปี</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2287">พระราชบัญญัติงบประมาณรายจ่าย</a></td>
</tr>
<tr valign="top">
<td>การพิจารณาร่างพระราชบัญญัติ
<ul>
<li><a href="more_news.php?cid=1822">ร่างพระราชบัญญัติที่อยู่ระหว่าง<br>
การพิจารณา จำแนกตามชุดของสภา</a></li>
<li><a href="more_news.php?cid=2292">พระราชบัญญัติที่ผ่านความ<br>
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
<td><a href="main.php?filename=sitemap_08">แผนผังเว็บไซต์</a></td>
</tr>
</table>
</div>
<div>
<hr>
<table width="100%" border="0">
<tr>
<td>ปฏิทินกิจกรรมประจำเดือน กันยายน  2552</td>
</tr>
<tr>
<td>ไม่พบข้อมูลกิจกรรม</td>
</tr>
</table>
</div>
<div>
<hr>
<form name="search124" method="post" action="search_result.php">
<table cellpadding="0" cellspacing="0">
<tr>
<td><span class="head">ค้นหา</span></td>
<td></td>
</tr>
<tr>
<td><input name="keyword" type="text" id="keyword" size="10" alt="กรุณาใส่คำค้น"> <input name="filename" type="hidden" id="filename" value="constitution_and_acts" alt="constitution_and_acts">
<input name="oper" type="hidden" id="oper" value="OR" alt="oper"></td>
<td><input type="button" name="Submit" onclick="
          if(document.search124.searchby.value==2){
            //location.href='http://www.google.co.th/search?q='+document.search124.keyword.value;
            window.open ('http://www.google.co.th/search?q='+document.search124.keyword.value,'mygoogle'); 
          }else{
            document.search124.submit();
          }" value="ค้นหา..." alt="ค้นหา"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="searchby" value="1" alt="searchby"> <input type="radio" name="chk" alt="เลือกค้นหาจากในเว็บ" checked value="1" onclick="if(this.checked==true){document.search124.searchby.value=this.value;} ">
 ค้นหาจากในเว็บ<br>
<input type="radio" name="chk" alt="เลือกค้นหาจาก Google " value="2" onclick="if(this.checked==true){document.search124.searchby.value=this.value;} ">
 ค้นหาจาก Google</td>
</tr>
</table>
</form>
</div>
<div>
<hr>
<table>
<tr>
<td align="center">จำนวนผู้เยี่ยมชมเว็บไซต์<br>
<img src="../ewt_c.php?n=OTAz" alt="000903"></td>
</tr>
</table>
</div>
</td>
<td id="ewt_main_structure_body" width="723" class="c-5"><?#w3c_spliter#?>

<div>
<table cellspacing="0" cellpadding="0" width="98%" align="center" border="0">
<tbody>
<tr>
<td> </td>
</tr>
<tr>
<td><span class="c-4">...ยินดีต้อนรับเข้าสู่เว็บไซต์
&quot;รัฐธรรมนูญและพระราชบัญญัติ&quot;...</span></td>
</tr>
<tr>
<td> </td>
</tr>
</tbody>
</table>
</div>
</td>
<td id="ewt_main_structure_right" width="10" class="c-6"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-6" colspan="3">
<div>
<table class="c-7" cellspacing="0" cellpadding="0" border="0">
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
<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a></body></HTML>