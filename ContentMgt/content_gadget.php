<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name,block_link,block_type FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_array($sql_file);
$sql_text = $db->query("SELECT * FROM block_text WHERE BID = '".$BID."' AND text_id = '".$R["block_link"]."'");
$T = $db->db_fetch_array($sql_text);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<SCRIPT language=JavaScript>
function Editor(form, Ashish)
{
var Insert="";
var value="";
	if(Ashish==8) 
	{ 
	value=prompt("Enter text here","Edit Text here");    
	size=prompt("Enter size of the font 0 - 7","1");
	color=prompt("Enter color code or name","BLACK");
	style=prompt("Enter font style ( eg. Arial, CordiaUPC, Courier New, MS Sans Serif, Times New Roman, Verdana )","MS Sans Serif");
		if((value!="")&&(value!=null))
		{	Insert="<font size="+size+" color="+color+" face="+style+">"+value+"</font>\r\n";}
		if(value=="")
		{	alert("Please do not leave pop up window blank");}
	}

	if(Ashish==9) 
	{  
	value=prompt("Enter Text to be BOLD.","Editor");
		if((value!="")&&(value!=null))
		{	Insert="<b>"+value+"</b>\r\n";}
		if(value=="")
		{	alert("Please do not leave pop up window blank");}
	}
	if(Ashish==10) 
	{  
	value=prompt("Text to be italicized","Editor");  
		if((value!="")&&(value!=null))
		{	Insert="<i>"+value+"</i>\r\n";}
		if(value=="")
		{	alert("Please do not leave pop up window blank");}
	}
	if(Ashish==11) 
	{  
	value=prompt("Text to be underlined","Editor");  
		if((value!="")&&(value!=null))
		{	Insert="<u>"+value+"</u>\r\n";}
		if(value=="")
		{	alert("Please do not leave pop up window blank");}
	}

        if(Ashish==12) Insert="\r\n<p>\r\n";

	if(Ashish==13) 
	{ 	
	value=prompt("Enter text to be aligned center","Editor");   
		if((value!="")&&(value!=null))
		{	Insert="<center>"+value+"</center>\r\n";}
		if(value=="")
		{	alert("Please do not leave pop up window blank");}
	}

	if(Ashish==14) 
	{ 
	value=prompt("Enter text to be aligned left","Editor"); 
		if((value!="")&&(value!=null))
		{	Insert="<left>"+value+"</left>\r\n";}
		if(value=="")
		{	alert("Please do not leave pop up window blank");}
	}

	if(Ashish==30) 
	{ 
	value=prompt("Enter text to be aligned right","Editor"); 
		if((value!="")&&(value!=null))
		{	Insert="<div align=right>"+value+"</div>\r\n";}
		if(value=="")
		{	alert("Please do not leave pop up window blank");}
	}

	if(Ashish==15) Insert="<BR>\r\n";
	if(Ashish==16) Insert="<HR>\r\n";

	if(Ashish==17) 
	{  
	value=prompt("Enter HTML file or URL for the link.","yourfile.html or http://www.yourname.com"); 
	value1=prompt("Enter description for the link","Edit Text Link here");
	if((value!="")&&(value!=null))
	{	Insert="<a href='"+value+"'>" +value1+"</a>\r\n";}
	if(value=="")
	{	alert("Please do not leave pop up window blank");}
	}
		if(Ashish==31) 
	{  
	value=prompt("Enter your downloaded files","yourfile.zip"); 
	value1=prompt("Enter description for the link","Edit Text Link here");
	if((value!="")&&(value!=null))
	{	Insert="<a href='download/"+value+"'>" +value1+"</a>\r\n";}
	if(value=="")
	{	alert("Please do not leave pop up window blank");}
	}
	if(Ashish==21) 
	{ 
	value=prompt("Enter email address","info@easywebtime.com");
	linkto=prompt("Enter text description for email","Editor");
		if((value!="")&&(value!=null))
		{	Insert="<a href=mailto:"+value+">"+linkto+"</a>\r\n";}
		if(value=="")
		{	alert("Please do not leave pop up window blank");}
	}
	if(Ashish==33)
	{
	value=prompt("Enter the lists here","list text");
	if((value!="")&&(value!=null)){ Insert="<li>" + value + "</li>\r\n";}
	if(value==""){ alert("Please do not leave pop up window blank");}
	}
form.contentHtml.value+=Insert;
}

function ResetPage(){ 
	if(confirm("Reset the page, Are you sure?")){ htmlform.reset(); }
}
</SCRIPT>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <form name="htmlform" method="post" action="content_function.php" onSubmit="return false">
    <tr> 
      <td height="20" align="left" bgcolor="F3F3EE"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
        Block name : <?php echo $R["block_name"]; ?> </td>
    </tr>
    <tr> 
      <td height="1" bgcolor="AAAAAA"></td>
    </tr>
    <tr> 
      <td height="1" bgcolor="716F64"></td>
    </tr>
    <tr> 
      <td valign="top"><textarea name="contentHtml"  wrap="PHYSICAL" style="width:100%;height:80%"><?php echo stripslashes(htmlspecialchars($T["text_html"])); ?></textarea></td>
    </tr>
    <tr> 
      <td height="80" valign="top"><hr size="1"> <div align="right">Module name : 
          <input name="bname" type="text" id="bname" value="<?php echo $R["block_name"]; ?>" size="40" maxlength="40">
          <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
          <input name="Flag" type="hidden" id="Flag" value="SaveEditor"><input name="ctype" type="hidden" id="ctype" value="gadget">
          <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <a href="#submit" onClick="htmlform.submit();"><img src="../images/disk_blue.gif" width="32" height="32" border="0" align="absmiddle"> 
          <strong>Save</strong></a><strong> &nbsp;&nbsp;&nbsp;&nbsp;</strong> 
          <a href="#reset" onClick="ResetPage()"><img src="../images/undo.gif" width="32" height="32" border="0" align="absmiddle"> 
          <strong>Reset</strong></a>&nbsp;&nbsp;&nbsp;</div></td>
    </tr>
  </form>
</table>
</body>
</html>
<?php } ?>
<?php $db->db_close(); ?>
