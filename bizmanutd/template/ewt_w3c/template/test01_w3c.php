
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
 td.c-8 { background-color:#FFFFFF;}
 td.c-7 { background-color:#FFFFFF;}
 td.c-6 { background-color:#FFFFFF; height:160px;}
 td.c-5 { background-color:#FFFFFF}
 a.c-4 {font-weight: bold}
 td.c-3 { background-color:#FFFFFF; height:257px; }
 td.c-2 {COLOR: #555555; FONT-FAMILY: Tahoma; FONT-SIZE: 11px; FONT-WEIGHT: bold; TEXT-DECORATION: none; background-color: #FFFFFF}
 div.c-1 {text-align: center}
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
<td id="ewt_main_structure_top" class="c-3" colspan="3">
<div class="c-1"><span title="test"><script type="text/javascript" src="js/media.js" language="javascript1.1">
</script></span>
<div id="flash5570"></div>
<span title="test"><script type="text/javascript" language="javascript1.1">
                  var flash_src = '../images/ss/head_3.swf';
                  var player = new GMedia('player' , flash_src,,,'test'); 
                  player.addParam('flashvars','file=' + flash_src,,,'test'); 
                  player.write('flash5570'); 
</script></span></div>
<div>
<table width="100%" border="0">
<tr>
<td>
<table cellspacing="1" cellpadding="6" width="120" border="0">
<tbody>
<tr>
<td class="c-2">FONTSIZE <a onclick="changeStyle('small');" href="#size"><img height="10" src="../mainpic/s.gif" width="10" border="0" alt="small"></a> <a onclick="changeStyle('normal');" href="#size"><img height="10" src="../mainpic/n.gif" width="10" border="0" alt="normal"></a> <a onclick="changeStyle('big');" href="#size"><img height="10" src="../mainpic/b.gif" width="10" border="0" alt="big"></a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="208" class="c-5">
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a class="c-4" href="main.php?filename=index_05" title="หน้าแรก(accesskey=1)" accesskey="1">หน้าแรก</a></td>
</tr>
<tr valign="top">
<td>แนะนำสำนักงานฯ
<p><a href="ewt_news.php?nid=2406&amp;amp;amp;filename=index" title="ประวัติความเป็นมา(accesskey=2)" accesskey="2">ประวัติความเป็นมา</a></p>
<p><a href="more_news.php?cid=1896" title="อำนาจหน้าที่(accesskey=3)" accesskey="3">อำนาจหน้าที่</a></p>
<p><a href="more_news.php?cid=1897" title="แผนผังการบังคับบัญชา(accesskey=4)" accesskey="4">แผนผังการบังคับบัญชา</a></p>
<p><a href="more_news.php?cid=2103" title="อัตรากำลัง(accesskey=5)" accesskey="5">อัตรากำลัง</a></p>
<p><a href="more_news.php?cid=2104" title="ทำเนียบเลขาธิการ(accesskey=6)" accesskey="6">ทำเนียบเลขาธิการ</a></p>
</td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=2419" title="วิสัยทัศน์ พันธกิจ(accesskey=7)" accesskey="7">วิสัยทัศน์
พันธกิจ</a></td>
</tr>
<tr valign="top">
<td><a href="../download/Secretary/35-20070727112509_OrganizationChartThai2.pdf" title="โครงสร้าง การแบ่งส่วนราชการ (accesskey=8)" accesskey="8">โครงสร้าง การแบ่งส่วนราชการ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1900" title="ผู้บริหาร(accesskey=9)" accesskey="9">ผู้บริหาร</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1901" title="แผนงาน/โครงการ/งบประมาณ(accesskey=10)" accesskey="10">แผนงาน/โครงการ/งบประมาณ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=1909" title="ผลการดำเนินงานประจำปี(accesskey=11)" accesskey="11">ผลการดำเนินงานประจำปี</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2936" title="กฎหมายและระเบียบ(accesskey=12)" accesskey="12">กฎหมายและระเบียบ</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=2452" title="มาตรฐานคุณธรรมและจริยธรรม(accesskey=13)" accesskey="13">มาตรฐานคุณธรรมและจริยธรรม</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2937&amp;amp;amp;filename=index" title="ติดต่อสำนักงานฯ(accesskey=14)" accesskey="14">ติดต่อสำนักงานฯ</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=34" title="กิจกรรม(accesskey=15)" accesskey="15">กิจกรรม</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2106" title="ภาพ และ ข้อความ Event(accesskey=16)" accesskey="16">ภาพ และ
ข้อความ Event</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=39" title="ข่าวจัดซื้อจัดจ้าง(accesskey=17)" accesskey="17">ข่าวจัดซื้อจัดจ้าง</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=41" title="ข่าวตำแหน่งงาน(accesskey=18)" accesskey="18">ข่าวตำแหน่งงาน</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2106" title="เข้าสู่เมล์รัฐสภา(accesskey=19)" accesskey="19">เข้าสู่เมล์รัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2107" title="เอกสารเผยแพร่ วารสาร จุลสาร(accesskey=20)" accesskey="20">เอกสารเผยแพร่ วารสาร จุลสาร</a></td>
</tr>
<tr valign="top">
<td>หน่วยงานภายในสำนักงาน
<p><a href="#" title=" กลุ่มงานผู้นำฝ่ายค้านในสภาผู้แทนราษฎร(accesskey=21)" accesskey="21">กลุ่มงานผู้นำฝ่ายค้านในสภาผู้แทนราษฎร</a></p>
<p><a href="#" title=" กลุ่มตรวจสอบภายใน(accesskey=22)" accesskey="22">กลุ่มตรวจสอบภายใน</a></p>
<p><a href="#" title=" กลุ่มช่วยอำนวยการนักบริหาร(accesskey=23)" accesskey="23">กลุ่มช่วยอำนวยการนักบริหาร</a></p>
<p><a href="#" title=" สำนักนโยบายและแผน(accesskey=24)" accesskey="24">สำนักนโยบายและแผน</a></p>
<p><a href="#" title=" สำนักงานประธานสภาผู้แทนราษฎร(accesskey=25)" accesskey="25">สำนักงานประธานสภาผู้แทนราษฎร</a></p>
<p><a href="#" title=" สำนักงานเลขานุการ ก.ร.(accesskey=26)" accesskey="26">สำนักงานเลขานุการ ก.ร.</a></p>
<p><a href="#" title=" สำนักบริหารงานกลาง(accesskey=27)" accesskey="27">สำนักบริหารงานกลาง</a></p>
<p><a href="#" title=" สำนักพัฒนาบุคลากร(accesskey=28)" accesskey="28">สำนักพัฒนาบุคลากร</a></p>
<p><a href="#" title=" สำนักการคลังและงบประมาณ(accesskey=29)" accesskey="29">สำนักการคลังและงบประมาณ</a></p>
<p><a href="#" title=" สำนักการพิมพ์(accesskey=30)" accesskey="30">สำนักการพิมพ์</a></p>
<p><a href="#" title=" สำนักรักษาความปลอดภัย(accesskey=31)" accesskey="31">สำนักรักษาความปลอดภัย</a></p>
<p><a href="#" title=" สำนักประชาสัมพันธ์(accesskey=32)" accesskey="32">สำนักประชาสัมพันธ์</a></p>
<p><a href="#" title=" สถานีวิทยุกระจายเสียงและวิทยุโทรทัศน์รัฐสภา(accesskey=33)" accesskey="33">สถานีวิทยุกระจายเสียงและวิทยุโทรทัศน์รัฐสภา</a></p>
<p><a href="#" title=" สำนักองค์การรัฐสภาระหว่างประเทศ(accesskey=34)" accesskey="34">สำนักองค์การรัฐสภาระหว่างประเทศ</a></p>
<p><a href="#" title=" สำนักความสัมพันธ์ระหว่างประเทศ(accesskey=35)" accesskey="35">สำนักความสัมพันธ์ระหว่างประเทศ</a></p>
<p><a href="#" title=" สำนักภาษาต่างประเทศ(accesskey=36)" accesskey="36">สำนักภาษาต่างประเทศ</a></p>
<p><a href="#" title=" สำนักวิชาการ(accesskey=37)" accesskey="37">สำนักวิชาการ</a></p>
<p><a href="main.php?filename=it_01" title=" สำนักสารสนเทศ(accesskey=38)" accesskey="38"> สำนักสารสนเทศ</a></p>
<p><a href="#" title=" สำนักการประชุม(accesskey=39)" accesskey="39">สำนักการประชุม</a></p>
<p><a href="#" title=" สำนักกฎหมาย(accesskey=40)" accesskey="40">สำนักกฎหมาย</a></p>
<p><a href="#" title=" สำนักรายงานการประชุมและชวเลข(accesskey=41)" accesskey="41">สำนักรายงานการประชุมและชวเลข</a></p>
<p><a href="#" title=" สำนักกรรมาธิการ ๑(accesskey=42)" accesskey="42">สำนักกรรมาธิการ ๑</a></p>
<p><a href="#" title=" สำนักกรรมาธิการ ๒(accesskey=43)" accesskey="43">สำนักกรรมาธิการ ๒</a></p>
<p><a href="#" title=" สำนักกรรมาธิการ ๓(accesskey=44)" accesskey="44">สำนักกรรมาธิการ ๓</a></p>
</td>
</tr>
</table>
</div>
<div>
<hr>
<form name="PollForm8z9S5564" action="ewt_vote.php?filename=test01_w3c" method="post" id="PollForm8z9S5564">
<table width="100%" border="0">
<tr>
<td colspan="2"><span class="text_normal">การสำรวจ</span></td>
</tr>
<tr>
<td colspan="2"><label><input type="radio" value="5" name="vote" alt="เลือกความคิดเห็นที่ 1"> <span class="text_normal">ความคิดเห็นที่ 1</span></label></td>
</tr>
<tr>
<td colspan="2"><label><input type="radio" value="6" name="vote" alt="เลือกความคิดเห็นที่ 2"> <span class="text_normal">ความคิดเห็นที่ 2</span></label></td>
</tr>
<tr>
<td><label><input type="hidden" name="flag" alt="flag">
<input type="Submit" name="submit" alt="โหวต" value="โหวต" onclick="document.PollForm8z9S5564.flag.value='0'; return chkPoll8z9S();">
 <input type="Submit" name="views" alt="ผลโหวต" value="ผลโหวต" onclick="document.PollForm8z9S5564.flag.value='1'; "><input name="cad_id" type="hidden" id="cad_id" value="1" alt="1"></label></td>
<td> </td>
</tr>
</table>
</form>
</div>
</td>
<td id="ewt_main_structure_body" width="748" class="c-6"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="0" class="c-7">
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td></td>
</tr>
</table>
</div>
<div class="c-1"><span title="test"><script type="text/javascript" language="javascript1.1">
                  var str = '<object type="application/x-mplayer2" data="http://server.burtondns.org:PORT/" height=180 width=330 classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" id="mediaplayer5566" title=test>';
                  str +='<param name="Filename" value="../download/file_vdo/national_thailand.swf">';
                  str +='<param name="movie" value="ttp://server.burtondns.org:PORT/">';
                  str +='<param name="AutoStart" value="False">';
                  str +='<param name="ShowControls" value="True">';
                  str +='<param name="ShowStatusBar" value="True">';
                  str +='<param name="ShowDisplay" value="False">';
                  str +='<param name="AutoRewind" value="False">';
                  str +='<param NAME="WindowlessVideo" value="1">';
                   str += '<\/object>';
                document.write(str);
</script></span></div>
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
<td><a href="calendar_all.php?filename=test01_w3c" accesskey="45">ดูปฏิทินทั้งหมด</a></td>
</tr>
</table>
</div>
<div>
<hr>
<form name="search5568" method="post" action="search_result.php" id="search5568">
<table cellpadding="0" cellspacing="0">
<tr>
<td>
<h1><span class="text_head">ค้นหา</span></h1>
</td>
<td></td>
</tr>
<tr>
<td><input name="keyword" type="text" id="keyword" size="10" alt="กรุณาใส่คำค้น"> <input name="filename" type="hidden" id="filename" value="test01_w3c" alt="test01_w3c"> <input name="oper" type="hidden" id="oper" value="OR" alt="oper"></td>
<td><input type="button" name="Submit" onclick="
          if(document.search5568.searchby.value==2){
            //location.href='http://www.google.co.th/search?q='+document.search5568.keyword.value;
            window.open ('http://www.google.co.th/search?q='+document.search5568.keyword.value,'mygoogle'); 
          }else{
            document.search5568.submit();
          }" value="ค้นหา.." alt="ค้นหา"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="searchby" value="1" alt="searchby"> <input type="radio" name="chk" alt="ค้นหาจากในเว็บ" checked value="1" onclick="if(this.checked==true){document.search5568.searchby.value=this.value;} ">
ค้นหาจากในเว็บ<br>
<input type="radio" name="chk" alt="ค้นหาจาก google " value="2" onclick="if(this.checked==true){document.search5568.searchby.value=this.value;} ">
 ค้นหาจาก Google</td>
</tr>
</table>
</form>
</div>
<div>
<hr>
<table>
<tr>
<td align="center">ขณะนี้มีผู้ Online อยู่<br>
<img src="../ewt_c.php?n=MQ==" alt="000001"></td>
</tr>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-8" colspan="3"></td>
</tr>
<tr>
<td colspan="3" align="center"><span id="formtextchangelang"></span></td>
</tr>
</table>
</body></HTML>