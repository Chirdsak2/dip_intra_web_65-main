<html lang="th">
<HEAD>
<title>ยินดีต้อนรับเข้าสู่ เว็บไซต์รัฐสภาไทย</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="ยินดีต้อนรับสู่ รัฐสภาไทย" >
<meta name="Description" content="ยินดีต้อนรับสู่ รัฐสภาไทย">

<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<link id="stext" href="../css/normal_w3c.css" rel="stylesheet" type="text/css">
<link href="../css/style_w3c.css" rel="stylesheet" type="text/css">
<link href="../css/w3c.css" rel="stylesheet" type="text/css" >
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script type="text/javascript"  language="javascript" src="../js/AjaxRequest.js"></script>
<script type="text/javascript"  language="javascript" src="../js/excute.js"></script>
<script type="text/javascript"  language="javascript" src="../js/lang.js"></script>
<script type="text/javascript"  language="javascript"  src="../js/jquery/jquery-1.2.3.pack.js"></script>
<script src="../js/jquery/jquery.cluetip.js"  type="text/javascript"  language="javascript" ></script>
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
			return (item.length >= min) && (item.length<=max)
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
</HEAD><body   bgcolor="#FFFFFF"  >
<table id="ewt_main_structure" width="956" border="0" cellpadding="0" cellspacing="0"  align="center" >
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" style="  background-color:#FFFFFF;  height:257px; "  colspan="3" >
		  		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left"  width="208"   style="  background-color:#FFFFFF" >
		  <DIV><table width="100%" border="0"> <tr valign="top">
				<td ><b>เมนูหลัก</b></td>
			   </tr>
			 <tr valign="top">
				<td ><a href="ewt_news.php?nid=10837"  title="ประธานรัฐสภา(accesskey=1)"  accesskey=1 >ประธานรัฐสภา</a></td>
			   </tr>
			 <tr valign="top">
				<td ><a href="ewt_news.php?nid=10838"  title="รองประธานรัฐสภา(accesskey=2)"  accesskey=2 >รองประธานรัฐสภา</a></td>
			   </tr>
			 <tr valign="top">
				<td ><a href="ewt_news.php?nid=326&amp;amp;filename=index"  title="ประธานสภาผู้แทนราษฎร (accesskey=3)"  accesskey=3 >ประธานสภาผู้แทนราษฎร</a></td>
			   </tr>
			 <tr valign="top">
				<td >รองประธานสภาผู้แทนราษฎร    &nbsp;<p><a href="ewt_news.php?nid=329&amp;amp;filename=index" title="รองประธาน คนที่ 1(accesskey=4)" accesskey=4 >รองประธาน คนที่ 1</a></p>			<p><a href="ewt_news.php?nid=332&amp;amp;filename=index" title="รองประธาน คนที่ 2(accesskey=5)" accesskey=5 >รองประธาน คนที่ 2</a></p>			</td>
			   </tr>
			 <tr valign="top">
				<td ><a href="ewt_news.php?nid=335&amp;amp;filename=index"  title="ผู้นำฝ่ายค้าน(accesskey=6)"  accesskey=6 >ผู้นำฝ่ายค้าน</a></td>
			   </tr>
			 <tr valign="top">
				<td ><a href="ewt_news.php?nid=1057&amp;amp;filename=index"  title="ประธานวุฒิสภา(accesskey=7)"  accesskey=7 >ประธานวุฒิสภา</a><p><a href="ewt_news.php?nid=1059&amp;amp;filename=index" title="รองประธานวุฒิสภาคนที่ 1(accesskey=8)" accesskey=8 >รองประธานวุฒิสภาคนที่ 1</a></p>			<p><a href="ewt_news.php?nid=1061&amp;amp;filename=index" title="รองประธานวุฒิสภาคนที่ 2(accesskey=9)" accesskey=9 >รองประธานวุฒิสภาคนที่ 2</a></p>			</td>
			   </tr>
			 <tr valign="top">
				<td >ทำเนียบสมาชิกรัฐสภา<p><a href="more_news.php?cid=66&amp;amp;filename=index012" title="สมาชิกสภาผู้แทนราษฎร (accesskey=10)" accesskey=10 >สมาชิกสภาผู้แทนราษฎร </a></p>			<p><a href="more_news.php?cid=83&amp;amp;filename=index" title="สมาชิกวุฒิสภา (accesskey=11)" accesskey=11 >สมาชิกวุฒิสภา </a></p>			</td>
			   </tr>
			</table></DIV>
				  </td>
          
    <td id="ewt_main_structure_body"  width="748"  style="  background-color:#FFFFFF; height:160px;">	        
	</td>
          <td id="ewt_main_structure_right"  width="0"style=" background-color:#FFFFFF;"  >
		  <DIV >	<hr>
	<table width="100%" border="0">
	  <tr>
		<td><h1>ปฏิทินกิจกรรม  พฤษภาคม&nbsp;&nbsp;2553</h1></td>
	  </tr>
	  	  <tr>
		<td>ไม่พบข้อมูล</td>
	  </tr>
	  	  <tr>
	    <td><a href="calendar_all.php?filename=tt_w3c" accesskey=12>ดูปฏิทินทั้งหมด</a></td>
      </tr>
	</table>

	</DIV>
				  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom"  style="  background-color:#FFFFFF;"  colspan="3">
		  </td>
        </tr>
		<tr><td colspan="3" align="center"><span id="formtextchangelang"></span>
</td></tr></table></body>
</html>
