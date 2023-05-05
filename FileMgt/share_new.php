<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/share_config.php");
if($_POST["Flag"] == "UploadFile007"){

if($_POST["direct"] == "BizPotential"){

}else{
$folder = base64_decode($_POST["direct"]);

$Current_Dir = $Globals_Dir."/".$folder;

if (!(file_exists($Current_Dir))) {
?>
<script language="JavaScript">
alert("Not found folder \"<?php echo $folder; ?>\"");
self.location.href = "share_index.php";
</script>
<?php
exit;
}
}
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript" type="text/javascript" src="../js/function.js"></script>
<script language="JavaScript">
function changePic(c){
if(c.value != ""){
//self.parent.share_left.share_preview.document.all.imgpreview.src = c.value;
}
}
</script>
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><form name="form1" enctype="multipart/form-data" method="post" action="share_function.php">
<tr>
    <td height="30" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<a href="<?php if($_SERVER["HTTP_REFERER"] != ""){ echo $_SERVER["HTTP_REFERER"]; }else{ echo "share_index.php"; } ?>" ><img src="../images/content_back.gif" width="24" height="24" border="0" align="absmiddle"> 
      Back</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#add" onClick="AddRoom('myTable');"><img src="../images/document_add.gif" width="24" height="24" border="0" align="absmiddle"> Upload more file...</a></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td height="20" bgcolor="F3F3EE"><img src="../images/folder_upload.gif" width="24" height="24" border="0" align="absmiddle"> 
      Upload New File to  <input name="textfield" value="My share/<?php echo $folder; ?>" type="text" size="40" readonly="true">
        <input name="current" type="hidden" id="current" value="<?php echo $_POST["direct"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="UploadFile001"></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0" id="myTable">
  <tr>
          <td width="35%" height="30" bgcolor="F7F7F7"  >Upload File:</td>
    <td width="23%">
<input name="file[]" type="file" onchange = "changePic(this);" onClick="changePic(this);">
            </td>
    <td><img src="../images/error1.gif" width="16" height="16"></td>
  </tr>
  <tr>
    <td width="35%" bgcolor="F7F7F7"></td>
          <td width="23%" valign="top">
		  <input name="Replace" type="checkbox" id="Replace" value="Y">
              Replace all if exists.<br>

              <input type="submit" name="Submit" value="Upload...">
             </td>      
          <td valign="top"></td>
  </tr>
</table></td>
  </tr></form>
</table>
</body>
<?php } ?>
