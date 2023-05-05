<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML lang="th">
<head>
<title>คณะกรรมาธิการการกฎหมาย การยุติธรรมและสิทธิมนุษยชน</title>
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
 body {
  background-color: #FFFFFF;
 }
 td.tp-9 {  background-color:#FFFFFF;}
 span.tp-8 {FONT-FAMILY: Tahoma}
 div.tp-7 {text-align: center}
 span.tp-6 {COLOR: #505050; FONT-FAMILY: Tahoma; FONT-SIZE: 8pt}
 span.tp-5 {FONT-SIZE: 8pt; FONT-FAMILY: Tahoma}
 td.tp-4 { background-color:#FFFFFF;}
 td.tp-3 {  background-color:#FFFFFF; height:160px;}
 td.tp-2 {  background-color:#FFFFFF}
 td.tp-1 {  background-color:#FFFFFF;   }
</style>
</head>
<body>
<table id="ewt_main_structure" width="920" border="0" cellpadding=
"0" cellspacing="0" align="center">
<tr valign="top">
<td id="ewt_main_structure_top" class="tp-1" colspan="3">
<div><a href="main.php?filename=Commitees_of_the_Senate_01"
accesskey="1">หน้าแรก</a> | <a href="ewt_news.php?nid=2253"
accesskey="2">อำนาจหน้าที่</a> | <a href="more_news.php?cid=1088"
accesskey="3">รายนามในคณะกรรมาธิการ</a> | <a href=
"more_news.php?cid=1097" accesskey="4">การประชุม</a> | <a href=
"more_news.php?cid=1098" accesskey="5">กิจกรรม</a> | <a href=
"more_news.php?cid=1107" accesskey="6">รายชื่อคณะอนุกรรมาธิการ</a>
| <a href="more_news.php?cid=1121" accesskey="7">ข้อคิดเห็น</a> |
<a href="more_news.php?cid=1122" accesskey=
"8">ฝ่ายเลขานุการ</a></div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="199" class="tp-2"></td>
<td id="ewt_main_structure_body" width="522" class="tp-3">
<script language="javascript" type="text/javascript">
document.write("<img src="../ewt_stat.php?t=page&filename=committee_01___EN&load=0&res="+screen.width+"x"+screen.height+"" width="1" height="1" style="display:none">");        
</script>
ทดสอบ test </td>
<td id="ewt_main_structure_right" width="199" class="tp-4"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="tp-9" colspan="3">
<div class="tp-7">
<table cellspacing="0" cellpadding="0" width="100%" align="center"
border="0">
<tbody>
<tr>
<td width="23" height="56"><img height="56" src=
"../images/design/committee/bottom_03.jpg" width="23" alt=
"no insert title on tag images"></td>
<td background="../images/design/committee/bottom_05.jpg" height=
"56">
<div class="tp-7"><span class="tp-6" color:=""><span class=
"tp-5">ติดต่อ: สำนักงานเลขาธิการวุฒิสภา ถนนอู่ทองใน เขตดุสิต
กรุงเทพฯ 10300<br>
โทร 0-2244-1777-8 อาคารสุขประพฤติ ถนนประชาชื่น เขตบางซื่อ กรุงเทพฯ
10800<br>
eMail:</span> <span class=
"tp-5">committee1@senate.go.th</span></span></div>
</td>
<td width="17" height="56"><span class="tp-8"><img height="56" src=
"../images/design/committee/bottom_07.jpg" width="17" alt=
"no insert title on tag images"></span></td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
<tr>
<td colspan="3" align="center"><span id=
"formtextchangelang"></span> <a href=
"http://validator.w3.org/check?uri=referer"><img src=
"http://www.w3.org/Icons/valid-html401" alt=
"Valid HTML 4.01 Transitional" height="31" width="88" border=
"0"></a><a href=
"http://jigsaw.w3.org/css-validator/check/referer"><img src=
"http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"
border="0"></a></td>
</tr>
</table>
</body>
</html>
		