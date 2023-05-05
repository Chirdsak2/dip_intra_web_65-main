function change_calendar124(date,BID) {
		var objDiv = document.getElementById("divCalendar124");
		url='calendar.php?date='+date+'&BID='+BID;
		AjaxRequest.get(
			{
				'url':url
				,'onLoading':function() { 
						objDiv.innerHTML = '<table cellspacing="0" cellpadding="0" width="100%" border="0" height="180"><tbody><tr><td height="20" align="center" ></td></tr><tr><td width="100%" align="center"><img src="mainpic/loading.gif" /></td></tr></tbody></table>'; 
				}
				,'onLoaded':function() { }
				,'onInteractive':function() { }
				,'onComplete':function() { }
				,'onSuccess':function(req) { 
						objDiv.innerHTML = req.responseText; 
						$('span.tips').cluetip({
							splitTitle: '|', 
							width: '370px',
							arrows: true, 
							dropShadow: false, 
							cluetipClass: 'jtip'}
						);
				}
			}
		);
}