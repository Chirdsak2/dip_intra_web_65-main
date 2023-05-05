<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML lang="th">
<head>
<title>test_bbb1</title>
<meta http-equiv="Content-Type" content=
"text/html; charset=UTF-8">
<meta name="Keywords" content="">
<meta name="Description" content=
"test_bbb1test_bbb1test_bbb1test_bbb1">
<link href="../css/style_calendar.css" rel="stylesheet" type=
"text/css">
<link id="stext" href="../css/normal.css" rel="stylesheet" type=
"text/css">
<link href="../css/style_w3c.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src=
"../js/calendar.js">
</script>
<script language="JavaScript" type="text/javascript" src=
"../js/loadcalendar.js">
</script>
<script language="JavaScript" type="text/javascript" src=
"../js/calendar-th.js">
</script>
<script type="text/javascript" language="javascript" src=
"../js/AjaxRequest.js">
</script>
<script type="text/javascript" language="javascript" src=
"../js/excute.js">
</script>
<script type="text/javascript" language="javascript" src=
"../js/lang.js">
</script>
<script type="text/javascript" language="javascript" src=
"../js/jquery/jquery-1.2.3.pack.js">
</script>
<script src="../js/jquery/jquery.cluetip.js" type="text/javascript"
language="javascript">
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
                        return (item.length >= min) && (item.length<=max)
}
function valid2EMail(mailObj){
                if (validLength(mailObj.value,1,50)){
                        //return false;
                        if (mailObj.value.search("^.+@.+..+$") != -1)
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
<link href="../css/w3c.css" rel="stylesheet" type="text/css">
<style type="text/css">
 body {
  background-image: url(images/design/35_committees/bg_yw01.jpg);
 }
 td.tp-12 {  background-color:#FFFFFF;}
 div.tp-11 {text-align: center}
 div.tp-10 {text-align: left}
 table.tp-9 {WIDTH: 100%; BORDER-COLLAPSE: collapse}
 div.tp-8 {text-align: right}
 span.tp-7 {FONT-SIZE: 8pt; FONT-FAMILY: Tahoma}
 td.tp-6 { background-color:#FFFFFF;}
 td.tp-5 {  background-color:#FFFFFF; height:160px;}
 td.tp-4 {  background-color:#FFFFFF}
 td.tp-3 {background-color: #FFFFFF}
 td.tp-2 {  background-color:#FFFFFF;   }
 span.tp-1 {FONT-FAMILY: Tahoma; COLOR: #daa520; FONT-SIZE: 18pt}
</style>
</head>
<body>
<table id="ewt_main_structure" width="920" border="0" cellpadding=
"0" cellspacing="0" align="center">
<tr valign="top">
<td id="ewt_main_structure_top" class="tp-2" colspan="3">
<div><img src=
"http://202.122.40.25/ewtadmin/ewt/parliament_parcy/images/design/35_committees/1_04.jpg"
width="78" height="79" alt="no insert title on tag images">
<div><span class="tp-1"><strong>คณะกรรมาธิการ<br>
การสวัสดิการสังคม</strong></span></div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" width="920">
<tbody>
<tr>
<td height="130" width="531"><img src=
"../images/design/committee/img2_03.jpg" width="531" height="130"
alt="no insert title on tag images"></td>
<td height="130" >88888</td>
</tr>
</tbody>
</table>
</div>
<div><a href="main.php?filename=committee_31" accesskey=
"1">หน้าหลัก</a> | <a href="ewt_news.php?nid=2015" accesskey=
"2">อำนาจหน้าที่</a> | <a href="more_news.php?cid=1047" accesskey=
"3">รายนามในคณะกรรมาธิการ</a> | <a href="more_news.php?cid=1052"
accesskey="4">การประชุม</a> | <a href="more_news.php?cid=1056"
accesskey="5">กิจกรรม</a> | <a href="more_news.php?cid=1062"
accesskey="6">รายชื่อคณะอนุกรรมาธิการ</a> | <a href=
"more_news.php?cid=1072" accesskey="7">ข้อคิดเห็น</a> | <a href=
"more_news.php?cid=1073" accesskey="8">ฝ่ายเลขานุการ</a></div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="199" class="tp-4">
<div>
<h1>สัมมนา/ศึกษาดูงาน</h1>
<hr>
<br>
<br>
<a href="more_news.php?cid=1060" accesskey="9">อ่านทั้งหมด</a><br>
<br></div>
<div>
<hr>
<table width="100%" border="0">
<tr>
<td>
<h1>ปฏิทินกิจกรรม มกราคม  2553</h1>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href=
"calendar_detail.php?event_id=32&filename=test_bbb1" accesskey=
"10">ศึกษาดูงาน(4 มกราคม2553  - 5 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href=
"calendar_detail.php?event_id=34&filename=test_bbb1" accesskey=
"11">xxxx(5 มกราคม2553  - 5 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href=
"calendar_detail.php?event_id=23&filename=test_bbb1" accesskey=
"12">วันเด็กแห่งชาติปี 53(9 มกราคม2553  - 9 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href="calendar_detail.php?event_id=9&filename=test_bbb1"
accesskey=
"13">กีฬาสีสามสำนัก_pinyapat(21 มกราคม2553  - 22 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href=
"calendar_detail.php?event_id=27&filename=test_bbb1" accesskey=
"14">ฟังธรรม/99(25 มกราคม2553  - 25 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href=
"calendar_detail.php?event_id=14&filename=test_bbb1" accesskey=
"15">กีฬาภายใน 99(28 มกราคม2553  - 28 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><a href=
"calendar_detail.php?event_id=11&filename=test_bbb1" accesskey=
"16">jjj(29 มกราคม2553  - 31 มกราคม2553 )</a></li>
</ul>
</td>
</tr>
<tr>
<td><a href="calendar_all.php?filename=test_bbb1" accesskey=
"17">ดูปฏิทินทั้งหมด</a></td>
</tr>
</table>
</div>
<div><script language="javascript" type="text/javascript" src=
"../swfobject.js">
</script>
<table width="100%" border="0" align="center" cellpadding="0"
cellspacing="0">
<tr>
<td class="tp-3" align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="left">
<h1>วิดิทัศน์คณะกรรมาธิการ</h1>
<hr></td>
</tr>
<tr>
<td align="left"><script language="javascript" type=
"text/javascript">

var urlname = document.URL.split("/");
var urlen = (urlname.length - 2);
var myurl = "";
for(i=0;i<urlen;i++){
myurl = myurl + urlname[i] + "/";
}
//alert(myurl);
                    function play4043(vdoFile,id) {
                                var s4043 = new SWFObject("../media/mediaplayer.swf","single4043","192","150","1");
                                s4043.addParam("allowfullscreen","true");
                                s4043.addVariable("file",myurl + vdoFile);
                                s4043.addVariable("width","192");
                                s4043.addVariable("height","150");
                                s4043.addVariable("autostart","true");
                                s4043.write("player4043");      
                                vdo_count4043.location.href = "../vdo_count.php?v="+id;
                        }
</script>
<p id="player4043"><a href=
"http://www.macromedia.com/go/getflashplayer">ภาพบรรยากาศภายในรัฐสภา</a></p>
<script language="javascript" type="text/javascript">
                                var s4043 = new SWFObject("../media/mediaplayer.swf","single4043","192","150","1");
                                s4043.addParam("allowfullscreen","true");
                                s4043.addVariable("file",myurl + "../download/media/Movie1.swf");
                                s4043.addVariable("image","");
                                s4043.addVariable("width","192");
                                s4043.addVariable("height","150");
                 s4043.addVariable("autostart","true");                                 s4043.write("player4043");
</script></td>
</tr>
<tr>
<td align="left">
<ul>
<li><a href="#view" onclick=
"play4043('download/media/Movie1.swf','9'); " title=
"ภาพบรรยากาศภายในรัฐสภา,จำนวนผู้เข้าชม 18 คน" accesskey=
"18">ภาพบรรยากาศภายในรัฐสภา</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<table width="100%" border="0">
<tr>
<td align="left"><a href=
"more_video.php?gid=8&filename=test_bbb1&BID=Wlk0MDQz"
accesskey="19">ดูทั้งหมด</a></td>
</tr>
</table>
</td>
</tr>
</table>
<script language="javascript" type="text/javascript">
var str = '<iframe name="vdo_count4043" src=""  frameborder="0"  width="0" height="0" scrolling="no" ></iframe>';
 document.write(str);
</script></td>
</tr>
</table>
</div>
<div>
<hr>
<form name="search4044" method="post" action="search_result.php">
<table cellpadding="0" cellspacing="0">
<tr>
<td>
<h1><span class="text_head">ค้นหา</span></h1>
</td>
<td></td>
</tr>
<tr>
<td><input name="keyword" type="text" id="keyword" size="10" alt=
"กรุณาใส่คำค้น"> <input name="filename" type="hidden" id="filename"
value="test_bbb1" alt="test_bbb1"> <input name="oper" type="hidden"
id="oper" value="OR" alt="oper"></td>
<td><input type="button" name="Submit" onclick="
                                        if(document.search4044.searchby.value==2){
                                                //location.href='http://www.google.co.th/search?q='+document.search4044.keyword.value;
                                                window.open ('http://www.google.co.th/search?q='+document.search4044.keyword.value,'mygoogle'); 
                                        }else{
                                                document.search4044.submit();
                                        }" value="ค้นหา.." alt=
"ค้นหา"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="searchby" value="1" alt=
"searchby"> <input type="radio" name="chk" alt="ค้นหาจากในเว็บ"
checked="checked" value="1" onclick=
"if(this.checked==true){document.search4044.searchby.value=this.value;} ">
 ค้นหาจากในเว็บ<br>
<input type="radio" name="chk" alt="ค้นหาจาก google " value="2"
onclick=
"if(this.checked==true){document.search4044.searchby.value=this.value;} ">
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
<img src="../ewt_c.php?n=Mg==" alt="000002"></td>
</tr>
</table>
</div>
<div>zczczcxcx</div>
</td>
<td id="ewt_main_structure_body" width="522" class="tp-5">
<div>
<p>ทดสอบ</p>
<p>ทดสอบ</p>
<p>ทดสอบ</p>
<p>ทดสอบ</p>
<p>ทดสอบ</p>
<p>ทดสอบ</p>
</div>
<script language="javascript" type="text/javascript">
document.write("<img src="../ewt_stat.php?t=page&filename=test_bbb1&load=1&res="+screen.width+"x"+screen.height+"" width="1" height="1" style="display:none">");        
</script></td>
<td id="ewt_main_structure_right" width="199" class="tp-6">
<div>
<h1>ข่าวประชาสัมพันธ์</h1>
<hr>
<br>
<br>
<a href="more_news.php?cid=1057" accesskey="20">อ่านทั้งหมด</a><br>
<br></div>
<div>
<h1>คณะกรรมาธิการ</h1>
<hr>
<ul>
<li><img src=
"../phpThumb.php?w=90&h=90&src=images/article/news2031/n20080818_2031.jpg"
alt="นายสมัย เจริญช่าง" align="middle"> <a href=
"ewt_news.php?nid=2031" target="_self" accesskey="21">นายสมัย
เจริญช่าง</a></li>
<li><img src=
"../phpThumb.php?w=90&h=90&src=images/article/news2019/n20081007_2019.jpg"
alt="นายสิริพงศ์ อังคสกุลเกียรติ" align="middle"> <a href=
"ewt_news.php?nid=2019" target="_self" accesskey="22">นายสิริพงศ์
อังคสกุลเกียรติ</a></li>
<li><img src=
"../phpThumb.php?w=90&h=90&src=images/article/news2030/n20080818_2030.jpg"
alt="นายพิเชษฐ์ ตันเจริญ" align="middle"> <a href=
"ewt_news.php?nid=2030" target="_self" accesskey="23">นายพิเชษฐ์
ตันเจริญ</a></li>
<li><img src=
"../phpThumb.php?w=90&h=90&src=images/article/news2029/n20080818_2029.jpg"
alt="นายพีระเพชร ศิริกุล" align="middle"> <a href=
"ewt_news.php?nid=2029" target="_self" accesskey="24">นายพีระเพชร
ศิริกุล</a></li>
<li><img src=
"../phpThumb.php?w=90&h=90&src=images/article/news2028/n20080818_2028.jpg"
alt="นายอิสมาแอล เบญอิบรอฮีม" align="middle"> <a href=
"ewt_news.php?nid=2028" target="_self" accesskey="25">นายอิสมาแอล
เบญอิบรอฮีม</a></li>
</ul>
<br>
<br>
<a href="more_news.php?cid=1048" accesskey="26">อ่านทั้งหมด</a><br>
<br></div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="tp-12" colspan="3">
<div class="tp-11">
<table cellspacing="0" cellpadding="0" width="100%" align="center"
border="0">
<tbody>
<tr>
<td width="23" height="56"><img height="56" src=
"../images/design/committee/bottom_03.jpg" width="23" alt=
"no insert title on tag images"></td>
<td background="../images/design/committee/bottom_05.jpg" height=
"56">
<div class="tp-10">
<table class="tp-9">
<tbody>
<tr>
<td><span class="tp-7">คณะกรรมาธิการการสวัสดิการสังคม<br>
สำนักกรรมาธิการ  3 สำนักงานเลขาธิการสภาผู้แทนราษฎร <br>
email : -</span></td>
<td>
<div class="tp-8"><span class="tp-7">สำนักกรรมาธิการ 3
สำนักงานเลขาธิการสภาผู้แทนราษฎร<br>
โทร 02-244-2596 ,02-244-2601</span></div>
</td>
</tr>
</tbody>
</table>
</div>
</td>
<td width="17" height="56"><img height="56" src=
"../images/design/committee/bottom_07.jpg" width="17" alt=
"no insert title on tag images"></td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
<tr>
<td colspan="3" align="center"><span id=
"formtextchangelang"></span></td>
</tr>
</table>
</body>
</html>
		