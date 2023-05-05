<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="9" height="100%" border="0" cellpadding="0" cellspacing="0"><form name="form1" method="post" action="">
  <tr valign="top"> 
      <td height="1" valign="middle" background="../images/l_bg.gif"><a href="#on"><img src="../images/l_on.gif" width="9" height="50" border="0" style="cursor:hand" onClick="change(this)"></a></td>
  </tr>
  <input type="hidden" name="flag" value="0">
</form>
</table>

</body>
</html>
<script language="JavaScript">
function change(c){
if(document.form1.flag.value =="0"){
c.src = "../images/l_off.gif";
document.form1.flag.value ="1";
self.top.content_frame.cols = "0,9,*";
}else{
c.src = "../images/l_on.gif";
document.form1.flag.value ="0";
self.top.content_frame.cols = "400,9,*";
}
}
</script>
