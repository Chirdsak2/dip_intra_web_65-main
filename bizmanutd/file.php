<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
?>
<html>
<head>
<title>Document Management System</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="content-type" content="text/html;charset=UTF-8">
</head>
<script>
function hidestatus(){
window.status=''
return true
}
if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)
document.onmouseover=hidestatus
document.onmouseout=hidestatus
</script>
<script language="JavaScript">
function UseIMG(c,d){
document.all.myname.innerHTML = "Preview : "+d;
document.all.page.src = c;
}
</script>
<script language="javascript" type="text/javascript" src="function.js"></script>
<?php
$txt = "";
if($Submit=="Upload"){

if($sfolder != ""){
$sfolder .= "/";
$sfolder1 = $sfolder."/";
}
$rowsfile = count($file);
for($i=0;$i<$rowsfile;$i++){
if($file_size[$i] > 0){

if(@copy($file[$i], "template/".$sfolder."".$file_name[$i])){
$txt .= "copy $file_name[$i] to myweb1<br>";
}else{
$txt .= "<font color=red>cannot copy $file_name[$i] to myweb1</font><br>";
}

$sql = $db->query("SELECT EWT_User FROM user_info WHERE EWT_Status = 'Y'");
while($R=mysql_fetch_row($sql)){
$path1 = "../ewt/".$R[0]."/".$sfolder.$file_name[$i];
if(@copy($file[$i], $path1)){
$txt .= "copy $file_name[$i] to $path1<br>";
}else{
$txt .= "<font color=red>cannot copy $file_name[$i] to $path1</font><br>";
}
}


}
}
}
if($Submit2=="Create")
{
if($nfolder!=""){
if(!@mkdir($path."/".$nfolder,0700)){
	?>
	<SCRIPT Language="JavaScript">
    alert("Can not create '<?php echo $nfolder;?>' . Folder already exist !."); 
</SCRIPT>
	<?php
	}
}
}
?>

<body bgcolor="#FFFFFF"  leftmargin="0" topmargin="0">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td height="10" >
	<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#0066CC">
  <form action="file.php" method="post" enctype="multipart/form-data" name="form1">
          <tr> 
            <td colspan="2"><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Update 
              EWT </strong></font></td>
          </tr>

          <tr style="display:none"> 
            <td width="29%"><div align="right"><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Create 
                new folder</strong></font></div></td>
            <td width="71%"><input name="nfolder" type="text" id="nfolder" size="36" > 
              <input type="submit" name="Submit2" value="Create" onClick="return check();"></td>
          </tr>

          <tr align="center"> 
            <td height="10" colspan="2"> <strong><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif">Upload 
              folder : </font></strong> 
              <input name="sfolder" type="text" id="sfolder">
              <table width="100%" border="0" cellspacing="0" cellpadding="3" id="myTable">
  
  <tr>
    <td width="35%" align="right"><div align="right"><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Upload 
                      file </strong></font></div></td>
    <td width="23%"><input type="file" name="file[]"></td>
    <td><img src="images/delete1.gif" width="16" height="16"></td>
  </tr>
  <tr>
    <td width="35%" align="right">&nbsp;</td>
    <td width="23%"><input type="submit" name="Submit" value="Upload"></td>
    <td><a href='#' onClick="AddRoom('myTable');"><img src="images/add.gif" width="16" height="16" border="0"></a></td>
  </tr>
</table></td>
          </tr>
		  </form>
</table>
	</td>
  </tr>
  <tr>
    <td valign="top" ><font size="2" face="Tahoma"><strong><?php echo $txt; ?></strong></font></td>
  </tr>
</table>
</body>
</html>
<script language="JavaScript">
function check(){
if(document.form1.nfolder.value==''){
alert(" Please insert New Folder Name ");
document.form1.nfolder.focus();
return false;
}
}
</script>

