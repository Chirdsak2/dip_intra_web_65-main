
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
 background-color: #BB1010;
 }
 td.c-7 { background-color:#FFFFFF;}
 td.c-6 { background-color:#FFFFFF;}
 td.c-5 { height:160px;}
 td.c-4 { background-color:#FFFFFF}
 td.c-3 { background:url(images/design/national_assembly/national_assembly_02.jpg); height:257px; }
 td.c-2 {COLOR: #555555; FONT-FAMILY: Tahoma; FONT-SIZE: 11px; FONT-WEIGHT: bold; TEXT-DECORATION: none; background-color: #FFFFFF}
 span.c-1 {FONT-SIZE: 36pt}
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
<td id="ewt_main_structure_top" class="c-3" colspan="3">
<div>
<p><span class="c-1">123.com</span></p>
</div>
<div>
<table cellspacing="1" cellpadding="6" width="120" border="0">
<tbody>
<tr>
<td class="c-2">FONTSIZE <a onclick="changeStyle('small');" href="#size"><img height="10" src="../mainpic/s.gif" width="10" border="0" alt="small"></a> <a onclick="changeStyle('normal');" href="#size"><img height="10" src="../mainpic/n.gif" width="10" border="0" alt="normal"></a> <a onclick="changeStyle('big');" href="#size"><img height="10" src="../mainpic/b.gif" width="10" border="0" alt="big"></a></td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="208" class="c-4">
<div>
<hr>
<form name="search2344" method="post" action="search_result.php" id="search2344">
<table cellpadding="0" cellspacing="0">
<tr>
<td>
<h1><span class="text_head">ค้นหา</span></h1>
</td>
<td></td>
</tr>
<tr>
<td><input name="keyword" type="text" id="keyword" size="10" alt="กรุณาใส่คำค้น"> <input name="filename" type="hidden" id="filename" value="tw3c01" alt="tw3c01"> <input name="oper" type="hidden" id="oper" value="OR" alt="oper"></td>
<td><input type="button" name="Submit" onclick="
          if(document.search2344.searchby.value==2){
            //location.href='http://www.google.co.th/search?q='+document.search2344.keyword.value;
            window.open ('http://www.google.co.th/search?q='+document.search2344.keyword.value,'mygoogle'); 
          }else{
            document.search2344.submit();
          }" value="ค้นหา.." alt="ค้นหา"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="searchby" value="1" alt="searchby"> <input type="radio" name="chk" alt="ค้นหาจากในเว็บ" checked value="1" onclick="if(this.checked==true){document.search2344.searchby.value=this.value;} ">
ค้นหาจากในเว็บ<br>
<input type="radio" name="chk" alt="ค้นหาจาก google " value="2" onclick="if(this.checked==true){document.search2344.searchby.value=this.value;} ">
 ค้นหาจากGoogle</td>
</tr>
</table>
</form>
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
<td><a href="calendar_all.php?filename=tw3c01" accesskey="1">ดูปฏิทินทั้งหมด</a></td>
</tr>
</table>
</div>
<div>
<hr>
<form name="NewsLetterForm2343" method="post" action="newsletter_function.php?filename=tw3c01" onsubmit="return ChkValueNewsLetter2343();" id="NewsLetterForm2343">
<table id="tball" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td> 
<h1>สมัครรับข่าวสาร</h1>
</td>
</tr>
<tr>
<td align="center"><label><input name="newsletteremail" type="text" id="newsletteremail" value="ใส่ email ของคุณที่นี่" onfocus="this.value='';" alt="กรุณาใส่อีเมล์"></label></td>
</tr>
<tr>
<td height="10" align="center"><input name="applynewsletter" type="radio" value="Y" checked alt="สมัคร">สมัคร <input type="radio" name="applynewsletter" value="N" alt="ยกเลิก">ยกเลิก</td>
</tr>
<tr>
<td align="center"><input type="hidden" name="t" value="0" alt="0">
<input name="Button01" type="submit" id="Button01" value="ตกลง" alt="ตกลง"><br>
<br></td>
</tr>
</table>
</form>
<script language="JavaScript" type="text/javascript">

function ChkValueNewsLetter2343(){
  if(document.NewsLetterForm2343.newsletteremail.value == ""){
    alert('กรุณาระบุอีเมล์ของท่าน');
    document.NewsLetterForm2343.newsletteremail.focus();
    return false;
  }else if(!validEMail(document.NewsLetterForm2343.newsletteremail)){
    alert('รูปแบบของอีเมล์ไม่ถูกต้อง');
    document.NewsLetterForm2343.newsletteremail.select();
    return false;
  }
  if(document.NewsLetterForm2343.applynewsletter[1].checked){
    r = confirm("คุณต้องการยกเลิกการรับข้อมูลจากทางเรา ?");
    if(r==true){
      return true;
    }else{
      return false;
    }
  }
}
</script></div>
</td>
<td id="ewt_main_structure_body" width="748" class="c-5"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="0" class="c-6"></td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-7" colspan="3">
<div><img border="0" alt="alt alt alt" src="../images/king_bg.jpg" width="624" height="46"></div>
</td>
</tr>
<tr>
<td colspan="3" align="center"><span id="formtextchangelang"></span><a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><a href="http://www.w3.org/WAI/WCAG1A-Conformance" title="Explanation of Level A Conformance"><img height="32" width="88" src="http://www.w3.org/WAI/wcag1A" alt="Level A conformance icon, W3C-WAI Web Content Accessibility Guidelines 1.0" border="0"></a><a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" border="0"></a></td>
</tr>
</table>
</body></HTML>