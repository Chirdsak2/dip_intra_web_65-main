<script src="../js/AjaxRequest.js"></script>
<script language="JavaScript">
function close_div(divID) {
	var objDiv = document.getElementById(divID);
	
	objDiv.innerHTML = '' ; 
	objDiv.style.visibility = 'hidden';
	objDiv.style.width = 1;
	objDiv.style.height = 1;
	objDiv.style.top = 0;
	objDiv.style.left = 0;
}
function load_divForm(url, divId, divWidth, divHeight, divTop, divLeft, drag) {
win2 = window.open(url,'Favorite','top=100,left=150,width=400,height=150,resizable=0,status=0');
win2.focus();
}
/*function load_divForm(url, divId, divWidth, divHeight, divTop, divLeft, drag) {
	var x_cursor = window.event.clientX;
	var y_cursor = window.event.clientY;
	var x_center = (screen.width) ? (screen.width)/2 : 0;
	var y_center = (screen.height) ? (screen.height)/2 : 0;
	var screen_width = screen.width;
	var screen_height = screen.height;
	var objDiv = document.getElementById(divId);
	
	objDiv.style.visibility = 'visible';
	if(divTop < 0) { objDiv.style.top = y_cursor; } else { objDiv.style.top = divTop; }
	if(divLeft < 0) { objDiv.style.left = x_cursor - 180; } 
	else if(divLeft == '0') { objDiv.style.left = x_cursor; }
	else { objDiv.style.left = divLeft; }
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() {	if(objDiv.style.position == 'absolute') {
											objDiv.style.width = 180;
											objDiv.style.height = 50;
			}
										objDiv.innerHTML = '<table width="180" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><img src="../images/loading.gif" border="0" align="absmiddle"></td></tr></table>';
								    }
			,'onLoaded':function() {  }
			,'onInteractive':function() {  }
			,'onComplete':function() {  }
			,'onSuccess':function(req) {	if(divTop < 0) { objDiv.style.top = y_cursor; } else { objDiv.style.top = divTop; }
											if(divLeft < 0) { objDiv.style.left = x_cursor - Math.abs(divLeft); } 
											else if(divLeft == '0') { objDiv.style.left = x_cursor; }
											else { objDiv.style.left = divLeft; }
											if(divWidth != '') { objDiv.style.width = eval(divWidth); }
											if(divHeight != '') { objDiv.style.height = eval(divHeight); }
											objDiv.innerHTML = req.responseText;
											
									   }
		}
	);
}*/
</script>
<div id="divForm" style="position:absolute; border-right:1px solid; border-top:1px solid; border-left:1px solid; border-bottom:1px solid; background-color:#FFFFFF; visibility:hidden; width:1px; height:1px;"></div>