<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML lang="th">
<head>
<title>ยินดีต้อนรับเข้าสู่ เว็บไซต์รัฐสภาไทย</title>
<meta http-equiv="Content-Type" content=
"text/html; charset=UTF-8">
<meta name="Keywords" content="ยินดีต้อนรับสู่ รัฐสภาไทย">
<meta name="Description" content="ยินดีต้อนรับสู่ รัฐสภาไทย">
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
 td.tp-4 {  background-color:#FFFFFF;}
 div.tp-3 {text-align: center}
 td.tp-2 {  height:160px;}
 td.tp-1 {   height:257px; }
</style>
 
<style type="text/css"> 
 table.mp-3 {WIDTH: 95%; BORDER-COLLAPSE: collapse}
 div.mp-2 {text-align: center}
 span.mp-1 {FONT-SIZE: 10pt; FONT-FAMILY: Tahoma}
</style>
</head>
<body>
<table id="ewt_main_structure" width="980" border="0" cellpadding=
"0" cellspacing="0" align="center">
<tr valign="top">
<td id="ewt_main_structure_top" class="tp-1" colspan="3">
<div>
<div id="content_main">
<div id="top-nav">
<p>ข้ามไปสู่ <a href="#skip" accesskey="C" title=
"ไปสู่เนื้อหา - accesskey C">เนื้อหา</a> หรือ <a href="#mainnav"
accesskey="M" title="ไปสู่เมนูหลัก - accesskey M">เมนูหลัก</a></p>
</div>
<div id="header" class="clearfix"><a title=
"กลับไปยังหน้าหลักรัฐสภาไทย" href="index.php"><img alt=
"โลโก้รัฐสภาไทย" src="../images/logo01.jpg"></a>
<h1>รัฐสภาไทย</h1>
<h1>Thai National Assembly</h1>
<h2>เว็บไซต์ www.parliament.go.th ยินดีต้อนรับ</h2>
</div>
<hr>
<a name="mainnav" id="mainnav"></a>
<div id="menu">
<ul>
<li><a href="index.php" title="หน้าหลัก">หน้าหลัก</a></li>
<li><a href="main.php?filename=index01" title=
"รัฐสภา">รัฐสภา</a></li>
<li><a href="main.php?filename=index02" title=
"สภาผู้แทนราษฎร">สภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/main/senate/" title="วุฒิสภา"
target="_blank">วุฒิสภา</a></li>
<li><a href="http://www.parliament.go.th/parcy/committee_index.php"
title="คณะกรรมาธิการสภาผู้แทนราษฎร" target=
"_blank">คณะกรรมาธิการสภาผู้แทนราษฎร</a></li>
<li><a href=
"http://www.senate.go.th/committee2551/main/committee.php" title=
"คณะกรรมาธิการวุฒิสภา" target=
"_blank">คณะกรรมาธิการวุฒิสภา</a></li>
<li><a href="main.php?filename=index_05" title=
"สำนักงานเลขาธิการสภาผู้แทนราษฎร">สำนักงานเลขาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="http://www.senate.go.th/2009/" title=
"สำนักงานเลขาธิการวุฒิสภา" target=
"_blank">สำนักงานเลขาธิการวุฒิสภา</a></li>
<li><a href="main.php?filename=index_07" title=
"รัฐสภาระหว่างประเทศ">รัฐสภาระหว่างประเทศ</a></li>
<li><a href="main.php?filename=index08" title=
"รัฐธรรมนูญและพระราชบัญญัติ">รัฐธรรมนูญและพระราชบัญญัติ</a></li>
<li><a href="main.php?filename=index09" title=
"รัฐสภาคู่ประชาชน">รัฐสภาคู่ประชาชน</a></li>
</ul>
</div>
<hr class="clearfix"></div>
<a name="skip" id="skip"></a></div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="40"></td>
<td id="ewt_main_structure_body" width="900" class="tp-2">
<table width="99%" border="0" cellpadding="5" cellspacing="0">
<tr>
<td class="text_head"><br></td>
</tr>
</table>
<table width="99%" border="0" align="center" cellpadding="4"
cellspacing="0">
<tr>
<td width="99%">
<table class="mp-3" cellspacing="3" cellpadding="2" align="center">
<tbody>
<tr>
<td>
<div class="mp-2"><strong><span class=
"mp-1">กลุ่มมิตรภาพสมาชิกรัฐสภาไทยระหว่างประเทศ</span></strong></div>
<div class="mp-2"><strong><span class=
"mp-1"> </span></strong></div>
<div class="mp-2">
<table cellspacing="2" cellpadding="2" width="90%" align="center"
border="0">
<tbody>
<tr>
<td><strong><span class=
"mp-1">กลุ่มมิตรภาพสมาชิกรัฐสภาไทย-สวีเดนให้การรับรองคณะกรรมาธิการสาธารณสุขและสวัสดิการแห่งรัฐสภาสวีเดน<br>
</span></strong></td>
</tr>
<tr>
<td class="ssmthai_darkgray">
กลุ่มมิตรภาพสมาชิกรัฐสภาไทย-สวีเดนให้การรับรองคณะกรรมาธิการสาธารณสุขและสวัสดิการแห่งรัฐสภาสวีเดน
วันจันทร์ที่ ๗ มกราคม ๒๕๕๑ เวลา ๑๕.๓๐ นาฬิกา ณ ห้องรับรองหมายเลข ๑
ชั้น ๒ อาคารรัฐสภา ๑</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</table>
<script language="javascript1.2" type="text/javascript"> 
document.write("<img src="ewt_stat.php?filename=16&t=news&load=0&res="+screen.width+"x"+screen.height+"" width="1" height="1" style="display:none">");  
</script></td>
<td id="ewt_main_structure_right" width="40"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="tp-4" colspan="3">
<div class="tp-3"><img border="0" alt="parlaiment" src=
"../images/design/parliament_and_people/b4.jpg" width="529" height=
"55"></div>
</td>
</tr>
<tr>
<td colspan="3" align="center"><span id=
"formtextchangelang"></span> <a href=
"http://jigsaw.w3.org/css-validator/check/referer"><img src=
"http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"
border="0"></a></td>
</tr>
</table>
</body>
</html>

