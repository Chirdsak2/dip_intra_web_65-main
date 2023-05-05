var xmlHttp

function showList(mode,ref1,ref2)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
{
alert ("Browser does not support HTTP Request")
return
} 

var url="../ajax/getlist.php"
url=url+"?mode="+mode+"&ref1="+ref1+"&ref2="+ref2
//self.location.href=url;
if (mode=='amphur')
	{
	   xmlHttp.onreadystatechange=stateChangedAmphur
	}else {
      xmlHttp.onreadystatechange=stateChangedTambon
	}

xmlHttp.open("GET",url,true)
xmlHttp.send(null)

}

function stateChangedAmphur () 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
{ 
		  document.getElementById("input_amphur").innerHTML=xmlHttp.responseText 
} 
} 

function stateChangedTambon () 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
{ 
		  document.getElementById("input_tambon").innerHTML=xmlHttp.responseText 
} 
} 


function GetXmlHttpObject()
{ 
var objXMLHttp=null
if (window.XMLHttpRequest)
{
objXMLHttp=new XMLHttpRequest()
}
else if (window.ActiveXObject)
{
objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
}
return objXMLHttp
}
