function load_divForm(url,divId,popup){ 
//var url="../ajax/getlist2.php"
if(divId != "" ){
	if(popup) {
	   var objDiv = opener.document.getElementById(divId);
	} else {
	   var objDiv = document.getElementById(divId);
	}
}

//url=url+"?mode="+mode+"&ref1="+ref1+"&ref2="+ref2+"&xid="+xid

AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() {  }
			,'onLoaded':function() {  }
			,'onInteractive':function() {  }
			,'onComplete':function() {  }
			,'onSuccess':function(req) { if(divId != ""){objDiv.innerHTML = req.responseText;}  }
		}
	);
}