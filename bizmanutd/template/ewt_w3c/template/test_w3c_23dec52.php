
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
 td.c-6 { background-color:#FFFFFF;}
 div.c-5 {text-align: center}
 td.c-4 {COLOR: #555555; FONT-FAMILY: Tahoma; FONT-SIZE: 11px; FONT-WEIGHT: bold; TEXT-DECORATION: none; background-color: #FFFFFF}
 td.c-3 { height:160px;}
 td.c-2 {background-color: #FFFFFF}
 td.c-1 {  height:257px; }
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
<table id="ewt_main_structure" width="980" border="0" cellpadding="0" cellspacing="0" align="center">
<tr valign="top">
<td id="ewt_main_structure_top" class="c-1" colspan="3">
<div id="content_main">
<div id="top-nav">
<p>ข้ามไปสู่ <a href="#skip" accesskey="C" title="ไปสู่เนื้อหา - accesskey C">เนื้อหา</a> หรือ <a href="#mainnav" accesskey="M" title="ไปสู่เมนูหลัก - accesskey M">เมนูหลัก</a></p>
</div>
<div id="header" class="clearfix"><a title="กลับไปยังหน้าหลักรัฐสภาไทย" href="index.php"><img alt="โลโก้รัฐสภาไทย" src="../images/logo01.jpg"></a>
<h1>รัฐสภาไทย</h1>
<h1>Thai National Assembly</h1>
<h2>เว็บไซต์ www.parliament.go.th ยินดีต้อนรับ</h2>
</div>
<hr>
<a name="mainnav" id="mainnav"></a>
<div id="menu">
<ul>
<li><a href="index.php" title="หน้าหลัก">หน้าหลัก</a></li>
<li><a href="main.php?filename=index01" title="รัฐสภา">รัฐสภา</a></li>
<li><a href="main.php?filename=index02" title="สภาผู้แทนราษฎร">สภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/main/senate/" title="วุฒิสภา" target="_blank">วุฒิสภา</a></li>
<li><a href="http://www.parliament.go.th/parcy/committee_index.php" title="คณะกรรมาธิการสภาผู้แทนราษฎร" target="_blank">คณะกรรมาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/committee2551/main/committee.php" title="คณะกรรมาธิการวุฒิสภา" target="_blank">คณะกรรมาธิการวุฒิสภา</a></li>
<li><a href="main.php?filename=index_05" title="สำนักงานเลขาธิการสภาผู้แทนราษฎร">สำนักงานเลขาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/2009/" title="สำนักงานเลขาธิการวุฒิสภา" target="_blank">สำนักงานเลขาธิการวุฒิสภา</a></li>
<li><a href="main.php?filename=index_07" title="รัฐสภาระหว่างประเทศ">รัฐสภาระหว่างประเทศ</a></li>
<li><a href="main.php?filename=index08" title="รัฐธรรมนูญและพระราชบัญญัติ">รัฐธรรมนูญและพระราชบัญญัติ</a></li>
<li><a href="main.php?filename=index09" title="รัฐสภาคู่ประชาชน">รัฐสภาคู่ประชาชน</a></li>
</ul>
</div>
<hr class="clearfix"></div>
<a name="skip" id="skip"></a></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="100">
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="main.php?filename=index01" accesskey="1">หน้าแรก
    </a></td>
</tr>
<tr valign="top">
<td>เกี่ยวกับรัฐสภา
<ul>
<li><a href="ewt_news.php?nid=10827" accesskey="2">บทบาท</a></li>
<li><a href="ewt_news.php?nid=10834" accesskey="3">อำนาจหน้าที่</a></li>
<li><a href="ewt_news.php?nid=10836" accesskey="4">โครงสร้าง</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=8663" accesskey="5">ข้อบังคับการประชุมรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=2352" accesskey="6">ประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=2356" accesskey="7">รองประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td>ทำเนียบ
<ul>
<li><a href="more_news.php?cid=1803" accesskey="8">ประธานรัฐสภา</a></li>
<li><a href="ewt_news.php?nid=7242" accesskey="9">รองประธานรัฐสภา</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="../download/parliament_law/13-20070827163114_1.pdf" accesskey="10">รัฐธรรมนูญฉบับปัจจุบัน</a></td>
</tr>
<tr valign="top">
<td>ร่าง พรบ.</td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2926&amp;amp;filename=index" accesskey="11">กฎหมายและระเบียบ</a></td>
</tr>
<tr valign="top">
<td>เครือข่ายในวงงานรัฐสภา
<ul>
<li><a href="http://www.ipu.org/english/home.htm" accesskey="12">เครือข่ายรัฐสภาทั่วโลก</a></li>
<li><a href="ewt_news.php?nid=7244" accesskey="13">ฐานข้อมูลหน่วยงานภาครัฐ</a></li>
<li><a href="more_news.php?cid=1809" accesskey="14">เครือข่ายนิติบัญญัติ</a></li>
<li><a href="http://www.ect.go.th/newweb/th/politicalparty/" accesskey="15">เครือข่ายพรรคการเมือง</a></li>
<li><a href="more_news.php?cid=1812" accesskey="16">เครือข่ายองค์กรอิสระตามรัฐธรรมนูญ</a></li>
<li><a href="more_news.php?cid=3005" accesskey="17">เครือข่ายองค์กรอื่นตามรัฐธรรมนูญ</a></li>
<li><a href="http://library2.parliament.go.th/library/home.html" accesskey="18">ห้องสมุดรัฐสภา</a></li>
</ul>
</td>
</tr>
</table>
</div>
<div><script language="javascript1.2" type="text/javascript">
function show_hidden(id,mid,sid){
  if(document.getElementById(id).style.display == 'none'){
    document.getElementById('img_plus'+id).src = 'mainpic/minus_a.gif';
      document.getElementById(id).style.display = '';
      var objDiv = document.getElementById(id);
      objDiv.style.display = '';
      url='sitemap_list.php?mp_id='+mid+'&sid='+sid;
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
  }else{
      document.getElementById(id).style.display = 'none';
    document.getElementById('img_plus'+id).src = 'mainpic/plus_a.gif';
      
  }
}
</script></div>
<div>
<hr>
<table width="100%" border="0">
<tr>
<td>
<h1>ปฏิทินกิจกรรม มกราคม  2553</h1>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href="calendar_detail.php?event_id=32&amp;amp;filename=test_w3c_23dec52" accesskey="19">ศึกษาดูงาน(4 มกราคม2553  - 5 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href="calendar_detail.php?event_id=34&amp;amp;filename=test_w3c_23dec52" accesskey="20">xxxx(5 มกราคม2553  - 5 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href="calendar_detail.php?event_id=23&amp;amp;filename=test_w3c_23dec52" accesskey="21">วันเด็กแห่งชาติปี
53(9 มกราคม2553  - 9 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href="calendar_detail.php?event_id=9&amp;amp;filename=test_w3c_23dec52" accesskey="22">กีฬาสีสามสำนัก_pinyapat(21 มกราคม2553  - 22 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href="calendar_detail.php?event_id=27&amp;amp;filename=test_w3c_23dec52" accesskey="23">ฟังธรรม/99(25 มกราคม2553  - 25 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href="calendar_detail.php?event_id=14&amp;amp;filename=test_w3c_23dec52" accesskey="24">กีฬาภายใน
99(28 มกราคม2553  - 28 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href="calendar_detail.php?event_id=11&amp;amp;filename=test_w3c_23dec52" accesskey="25">jjj(29 มกราคม2553  - 31 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td><a href="calendar_all.php?filename=test_w3c_23dec52" accesskey="26">ดูปฏิทินทั้งหมด</a></td>
</tr>
</table>
</div>
<div><script language="javascript" type="text/javascript" src="../swfobject.js">
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="c-2" align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="left">
<h1>วีดีทัศน์เยี่ยมชมรัฐสภา</h1>
<hr></td>
</tr>
<tr>
<td align="left"><script language="javascript" type="text/javascript">

var urlname = document.URL.split("/");
var urlen = (urlname.length - 2);
var myurl = "";
for(i=0;i<urlen;i++){
myurl = myurl + urlname[i] + "/";
}
//alert(myurl);
     function play3055(vdoFile,id) {
        var s3055 = new SWFObject("../media/mediaplayer.swf","single3055","200","200","1");
        s3055.addParam("allowfullscreen","true");
        s3055.addVariable("file",myurl + vdoFile);
        s3055.addVariable("width","200");
        s3055.addVariable("height","200");
        s3055.addVariable("autostart","true");
        s3055.write("player3055");  
        vdo_count3055.location.href = "../vdo_count.php?v="+id;
      }
</script>
<p id="player3055"><a href="http://www.macromedia.com/go/getflashplayer">รัฐสภาไทย The
National Assembly of Thailand</a></p>
<script language="javascript" type="text/javascript">
        var s3055 = new SWFObject("../media/mediaplayer.swf","single3055","200","200","1");
        s3055.addParam("allowfullscreen","true");
        s3055.addVariable("file",myurl + "download/file_vdo/national_thailand.swf");
        s3055.addVariable("image","");
        s3055.addVariable("width","200");
        s3055.addVariable("height","200");
          s3055.write("player3055");
</script></td>
</tr>
<tr>
<td align="left">
<ul>
<li><a href="#view" onclick="play3055('download/file_vdo/national_thailand.swf','19'); " title="รัฐสภาไทย The National Assembly of Thailand,จำนวนผู้เข้าชม 1 คน" accesskey="27">รัฐสภาไทย The National Assembly of Thailand</a></li>
</ul>
</td>
</tr>
<tr>
<td align="left">
<ul>
<li><a href="#view" onclick="play3055('download/file_vdo/master2.swf','18'); " title="การ์ตูนแอนนิเมชั่น เรื่องรัฐสภาไทย,จำนวนผู้เข้าชม 4 คน" accesskey="28">การ์ตูนแอนนิเมชั่น เรื่องรัฐสภาไทย</a></li>
</ul>
</td>
</tr>
<tr>
<td align="left">
<ul>
<li><a href="#view" onclick="play3055('download/file_vdo/national_thai_eng.swf','16'); " title="The National Assembly of Thailand (English version,จำนวนผู้เข้าชม 3 คน" accesskey="29">The National Assembly of Thailand (English
version</a></li>
</ul>
</td>
</tr>
<tr>
<td align="left">
<ul>
<li><a href="#view" onclick="play3055('download/file_vdo/Committee.swf','15'); " title="กรรมาธิการ Committee,จำนวนผู้เข้าชม 4 คน" accesskey="30">กรรมาธิการ Committee</a></li>
</ul>
</td>
</tr>
<tr>
<td align="left">
<ul>
<li><a href="#view" onclick="play3055('download/file_vdo/vdo_35_20090114115352.flv','13'); " title="แนะนำสำนักงานเลขาธิการสภาผู้แทนราษฎร,จำนวนผู้เข้าชม 4 คน" accesskey="31">แนะนำสำนักงานเลขาธิการสภาผู้แทนราษฎร</a></li>
</ul>
</td>
</tr>
</table>
<script language="javascript" type="text/javascript">
var str = '<iframe name="vdo_count3055" src="" frameborder="0" width="0" height="0" scrolling="no"><\/iframe>';
 document.write(str);
</script></td>
</tr>
</table>
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
<td id="ewt_main_structure_body" width="840" class="c-3"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="40">
<div>
<table cellspacing="1" cellpadding="6" width="120" border="0">
<tbody>
<tr>
<td class="c-4">FONTSIZE <a onclick="changeStyle('small');" href="#size"><img height="10" src="../mainpic/s.gif" width="10" border="0" alt="small"></a> <a onclick="changeStyle('normal');" href="#size"><img height="10" src="../mainpic/n.gif" width="10" border="0" alt="normal"></a> <a onclick="changeStyle('big');" href="#size"><img height="10" src="../mainpic/b.gif" width="10" border="0" alt="big"></a></td>
</tr>
</tbody>
</table>
</div>
<div>
<hr>
<form name="search3051" method="post" action="search_result.php" id="search3051">
<table cellpadding="0" cellspacing="0">
<tr>
<td>
<h1><span class="text_head">ค้นหา</span></h1>
</td>
<td></td>
</tr>
<tr>
<td><input name="keyword" type="text" id="keyword" size="10" alt="กรุณาใส่คำค้น"> <input name="filename" type="hidden" id="filename" value="test_w3c_23dec52" alt="test_w3c_23dec52"> <input name="oper" type="hidden" id="oper" value="OR" alt="oper"></td>
<td><input type="button" name="Submit" onclick="
          if(document.search3051.searchby.value==2){
            //location.href='http://www.google.co.th/search?q='+document.search3051.keyword.value;
            window.open ('http://www.google.co.th/search?q='+document.search3051.keyword.value,'mygoogle'); 
          }else{
            document.search3051.submit();
          }" value="ค้นหา.." alt="ค้นหา"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="searchby" value="1" alt="searchby"> <input type="radio" name="chk" alt="ค้นหาจากในเว็บ" checked value="1" onclick="if(this.checked==true){document.search3051.searchby.value=this.value;} ">
ค้นหาจากในเว็บ<br>
<input type="radio" name="chk" alt="ค้นหาจาก google " value="2" onclick="if(this.checked==true){document.search3051.searchby.value=this.value;} ">
 ค้นหาจาก Google</td>
</tr>
</table>
</form>
</div>
<div>
<hr>
<form name="PollForm3zHX3049" action="ewt_vote.php?filename=test_w3c_23dec52" method="post" id="PollForm3zHX3049">
<table width="100%" border="0">
<tr>
<td colspan="2"><span class="text_normal">การแก้ไขรัฐธรรมนูญ</span></td>
</tr>
<tr>
<td colspan="2"><label><input type="radio" value="7" name="vote" alt="เลือกเห็นด้วย"> <span class="text_normal">เห็นด้วย</span></label></td>
</tr>
<tr>
<td colspan="2"><label><input type="radio" value="8" name="vote" alt="เลือกไม่เห็นด้วย"> <span class="text_normal">ไม่เห็นด้วย</span></label></td>
</tr>
<tr>
<td><label><input type="hidden" name="flag" alt="flag">
<input type="Submit" name="submit" alt="โหวต" value="โหวต" onclick="document.PollForm3zHX3049.flag.value='0'; return chkPoll3zHX();">
 <input type="Submit" name="views" alt="ผลโหวต" value="ผลโหวต" onclick="document.PollForm3zHX3049.flag.value='1'; "><input name="cad_id" type="hidden" id="cad_id" value="2" alt="2"></label></td>
<td> </td>
</tr>
</table>
</form>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-6" colspan="3">
<div>
<hr>
<table>
<tr>
<td align="center">
จำนวนผู้เยี่ยมชมเว็บไซต์ในหน้าtest_w3c_23dec52<br>
<img src="../ewt_c.php?n=MQ==" alt="000001"></td>
</tr>
</table>
</div>
<div>
<table width="100%" border="0">
<tr>
<td align="center"><a href="main.php?filename=webboard" target="_self" accesskey="32"><img src="../images/design/banner/banner4.jpg" border="0" alt="กระดานถาม-ตอบ"></a></td>
<td align="center"><a href="main.php?filename=member" target="_self" accesskey="33"><img src="../images/design/banner/banner3.jpg" border="0" alt="ลงทะเบียนสมาชิก"></a></td>
<td align="center"><a href="http://www.parliament.go.th/parcy/nmeeting_index.php" target="_blank" accesskey="34"><img src="../images/design/banner/MeetingBanner.jpg" border="0" alt="ข้อมูลการประชุม"></a></td>
<td align="center"><a href="http://www.parliament.go.th/parcy/sapa_db/member_f/index.php" target="_blank" accesskey="35"><img src="../images/design/parcy01/banner_sapa_member_f-2549.jpg" border="0" alt="สมาชิกสมัชชาแห่งชาติ ปี 2549"></a></td>
<td align="center"><a href="main.php?filename=index011" target="_self" accesskey="36"><img src="../images/design/banner/banner7.jpg" border="0" alt="ห้องข่าว"></a></td>
</tr>
</table>
</div>
<div class="c-5"><img border="0" alt="parlaiment" src="../images/design/parliament_and_people/b4.jpg" width="529" height="55"></div>
</td>
</tr>
<tr>
<td colspan="3" align="center"><span id="formtextchangelang"></span>#htmlw3c_spliter#</td>
</tr>
</table>
</body></HTML>