
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
 background-color: #339900;
 }
 td.c-9 { background-color:#FFFFFF;}
 td.c-8 { background-color:#FFFFFF;}
 td.c-7 { height:160px;}
 td.c-6 { background-color:#FFFF99}
 td.c-5 { background-color:#CCCC33; height:257px; }
 td.c-4 {COLOR: #555555; FONT-FAMILY: Tahoma; FONT-SIZE: 11px; FONT-WEIGHT: bold; TEXT-DECORATION: none; background-color: #FFFFFF}
 table.c-3 {WIDTH: 100%; BORDER-COLLAPSE: collapse}
 td.c-2 {BACKGROUND: url(images/rainbow.jpg) left top}
 img.c-1 {WIDTH: 245px; HEIGHT: 114px}
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
<td id="ewt_main_structure_top" class="c-5" colspan="3">
<div>
<table class="c-3">
<tbody>
<tr>
<td class="c-2"><img class="c-1" border="0" alt="รูปที่ 1" src="../images/Garden.jpg" width="1023" height="767"></td>
</tr>
</tbody>
</table>
</div>
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="main.php?filename=index01" accesskey="1">รัฐสภา</a></td>
<td>  |  </td>
<td><a href="main.php?filename=index02" accesskey="2">สภาผู้แทนราษฎร</a></td>
<td>  |  </td>
<td><a href="main.php?filename=index_03" accesskey="3">วุฒิสภา</a></td>
<td>  |  </td>
<td>คณะกรรมาธิการ
<ul>
<li><a href="more_news.php?cid=88" accesskey="4">คณะกรรมาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="more_news.php?cid=88" accesskey="5">คณะกรรมาธิการวุฒิสภา</a></li>
</ul>
</td>
<td>  |  </td>
<td>สำนักงานเลขาธิการ
<ul>
<li><a href="main.php?filename=index_05" accesskey="6">สำนักงานเลขาธิการสภาผู้แทนราษฎร</a></li>
<li><a href="main.php?filename=index_06" accesskey="7">สำนักงานเลขาธิการวุฒิสภา</a></li>
</ul>
</td>
<td>  |  </td>
<td><a href="main.php?filename=index_07" accesskey="8">รัฐสภาระหว่างประเทศ</a></td>
<td>  |  </td>
<td><a href="main.php?filename=index08" accesskey="9">รัฐธรรมนูญและพระราชบัญญัติ</a></td>
<td>  |  </td>
<td><a href="main.php?filename=index09" accesskey="10">รัฐสภาคู่ประชาชน</a></td>
<td>  |  </td>
<td><a href="parliament.php" accesskey="11">สมาชิกรัฐสภา</a></td>
</tr>
</table>
</div>
<div>
<table cellspacing="1" cellpadding="6" width="120" border="0">
<tbody>
<tr>
<td class="c-4">FONTSIZE <a onclick="changeStyle('small');" href="#size"><img height="10" src="../mainpic/s.gif" width="10" border="0" alt="small"></a> <a onclick="changeStyle('normal');" href="#size"><img height="10" src="../mainpic/n.gif" width="10" border="0" alt="normal"></a> <a onclick="changeStyle('big');" href="#size"><img height="10" src="../mainpic/b.gif" width="10" border="0" alt="big"></a></td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_left" width="0%" class="c-6"></td>
<td id="ewt_main_structure_body" width="748" class="c-7"><?#w3c_spliter#?></td>
<td id="ewt_main_structure_right" width="208" class="c-8">
<div>
<table width="100%" border="0">
<tr valign="top">
<td><a href="main.php?filename=index01" accesskey="12">หน้าแรก</a></td>
</tr>
<tr valign="top">
<td>เกี่ยวกับรัฐสภา
<ul>
<li><a href="ewt_news.php?nid=10827" accesskey="13">บทบาท</a></li>
<li><a href="ewt_news.php?nid=10834" accesskey="14">อำนาจหน้าที่</a></li>
<li><a href="ewt_news.php?nid=10836" accesskey="15">ภารกิจ</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=7240" accesskey="16">ระบบงานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=8663" accesskey="17">ข้อบังคับการประชุมรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=2352" accesskey="18">ประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td><a href="ewt_news.php?nid=2356" accesskey="19">รองประธานรัฐสภา</a></td>
</tr>
<tr valign="top">
<td>ทำเนียบ
<ul>
<li><a href="more_news.php?cid=1803" accesskey="20">ประธานรัฐสภา</a></li>
<li><a href="ewt_news.php?nid=7242" accesskey="21">รองประธานรัฐสภา</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="../download/parliament_law/13-20070827163114_1.pdf" accesskey="22">รัฐธรรมนูญฉบับปัจจุบัน</a></td>
</tr>
<tr valign="top">
<td>ร่าง พรบ.
<ul>
<li><a href="more_news.php?cid=1822" accesskey="23">ร่างพรบ.ที่อยู่ระหว่างการพิจารณา</a></li>
<li><a href="more_news.php?cid=2292" accesskey="24">ร่างพรบ.ที่ผ่านความเห็นชอบแล้ว</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="more_news.php?cid=2926&amp;amp;filename=index" accesskey="25">กฎหมายและระเบียบ</a></td>
</tr>
<tr valign="top">
<td>เครือข่ายในวงงานรัฐสภา
<ul>
<li><a href="ewt_news.php?nid=7243" accesskey="26">เครือข่ายรัฐสภาทั่วโลก</a></li>
<li><a href="ewt_news.php?nid=7244" accesskey="27">ฐานข้อมูลหน่วยงานภาครัฐ</a></li>
<li><a href="more_news.php?cid=1809" accesskey="28">เครือข่ายนิติบัญญัติ</a></li>
<li><a href="ewt_news.php?nid=3183" accesskey="29">เครือข่ายพรรคการเมือง</a></li>
<li><a href="more_news.php?cid=1812" accesskey="30">เครือข่ายองค์กรตรวจสอบตามรัฐธรรมนูญ</a></li>
<li><a href="more_news.php?cid=1815" accesskey="31">เครือข่ายห้องสมุดกฎหมาย</a></li>
</ul>
</td>
</tr>
<tr valign="top">
<td><a href="main.php?filename=sitemap" accesskey="32">แผนผังเว็บไซต์</a></td>
</tr>
</table>
</div>
<div>
<hr>
<table width="100%" border="0">
<tr>
<td>
<h1>ปฏิทินกิจกรรม พฤศจิกายน  2552</h1>
</td>
</tr>
<tr>
<td>ไม่พบข้อมูล</td>
</tr>
</table>
</div>
<div>
<hr>
<form name="search2286" method="post" action="search_result.php" id="search2286">
<table cellpadding="0" cellspacing="0">
<tr>
<td>
<h1><span class="text_head">ค้นหา</span></h1>
</td>
<td></td>
</tr>
<tr>
<td><input name="keyword" type="text" id="keyword" size="10" alt="กรุณาใส่คำค้น"> <input name="filename" type="hidden" id="filename" value="test_template_w01" alt="test_template_w01"> <input name="oper" type="hidden" id="oper" value="OR" alt="oper"></td>
<td><input type="button" name="Submit" onclick="
          if(document.search2286.searchby.value==2){
            //location.href='http://www.google.co.th/search?q='+document.search2286.keyword.value;
            window.open ('http://www.google.co.th/search?q='+document.search2286.keyword.value,'mygoogle'); 
          }else{
            document.search2286.submit();
          }" value="ค้นหา.." alt="ค้นหา"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="searchby" value="1" alt="searchby"> <input type="radio" name="chk" alt="ค้นหาจากในเว็บ" checked value="1" onclick="if(this.checked==true){document.search2286.searchby.value=this.value;} ">
ค้นหาจากในเว็บ<br>
<input type="radio" name="chk" alt="ค้นหาจาก google " value="2" onclick="if(this.checked==true){document.search2286.searchby.value=this.value;} ">
 ค้นหาจากGoogle</td>
</tr>
</table>
</form>
</div>
<div>
<table width="100%" border="0">
<tr>
<td><a href="more_news.php?cid=1936" target="_self" accesskey="33"><img src="../images/design/national_assembly/banner1.jpg" border="0" alt="ข่าวการประชุม"></a></td>
</tr>
</table>
</div>
</td>
</tr>
<tr valign="top">
<td id="ewt_main_structure_bottom" class="c-9" colspan="3"></td>
</tr>
</table>
<span id="formtextchangelang"></span>
</body></HTML>