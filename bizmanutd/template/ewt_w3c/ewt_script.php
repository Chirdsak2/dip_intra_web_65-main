<?php
if($filename == ""){
$filename = "index";
}
?>
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