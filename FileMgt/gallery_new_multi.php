<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$Globals_Dir1 = "../ewt/".$_SESSION["EWT_SUSER"]."/";
if($_POST["Flag"] == "UploadFile007"){
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";

if($_POST["direct"] == "BizPotential"){

}else{
$folder = base64_decode($_POST["direct"]);

$Current_Dir = $Globals_Dir."/".$folder;

if (!(file_exists($Current_Dir))) {
?>
<script language="JavaScript">
alert("Not found folder \"<?php echo $folder; ?>\"");
self.location.href = "gallery_index.php";
</script>
<?php
exit;
}
}

session_unregister("SS_DIRECTORY");
session_register("SS_DIRECTORY");
$_SESSION["SS_DIRECTORY"]=$_POST["direct"];

//echo "direct : ".$_POST["direct"]."<br>";

$sql = "select * from site_info";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="styles.css">
<script language="javascript" type="text/javascript" src="../js/function.js"></script>
<script language="JavaScript">
function changePic(c){
if(c.value != ""){
self.parent.gallery_left.gallery_preview.document.all.imgpreview.src = c.value;
}
}
	
</script>
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<!--<object name="ftp" id="ftp" classid="CLSID:63337170-F789-11CE-86F8-0020AFD8C6DB">
	<param name="RemoteHost" value="<?php echo $rec[site_info_host]; ?>">
	<param name="User" value="<?php echo $rec[site_info_user]; ?>">
	<param name="Password" value="<?php echo $rec[site_info_pass]; ?>">
</object>-->
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
      <td height="30" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<a href="<?php if($_SERVER["HTTP_REFERER"] != ""){ echo $_SERVER["HTTP_REFERER"]; }else{ echo "gallery_index.php"; } ?>" ><img src="../images/content_back.gif" width="24" height="24" border="0" align="absmiddle"> 
        Back</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000">( File 
        Size must not exceed <?php echo $rec[site_info_max_img];?> KB)</font></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td height="20" bgcolor="F3F3EE"><img src="../images/folder_upload.gif" width="24" height="24" border="0" align="absmiddle"> 
      Upload New File to  <input name="textfield" value="My Gallery/<?php echo $folder; ?>" type="text" size="40" readonly="true">
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
    <td valign="top"><?php // เราเพิ่ม current : "php echo $_POST["direct"];"  เพื่อส่งค่า folder ปลายทางที่จะวางไฟล์ upload ให้ Flash ?>
	<div id="MultiPowUpload_holder">You need at least 9 version of Flash player. Download last version 
				<a target="_blank" href="http://www.adobe.com/shockwave/download/alternates/">here</a>!
			</div>
<!-- SWFObject home page: http://code.google.com/p/swfobject/ -->
<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript">
	var params = {  
		BGColor: "#F8F6E6",
		current : "<?php echo $_POST["direct"]; ?>"
	};
	
	var attributes = {  
		id: "MultiPowUpload",  
		name: "MultiPowUpload"
	};
	
	var flashvars = {
	  uploadUrl: "uploadfiles.php"
	};

	swfobject.embedSWF("ElementITMultiPowUpload2_1.swf", "MultiPowUpload_holder", "450", "350", "9.0.0", "expressInstall.swf", flashvars, params, attributes);
</script>
	</td>
  </tr>
</table>
</body>
<script language="JavaScript">
self.parent.gallery_left.gallery_preview.location.href='gallery_left_preview.php';
</script>
<?php }
$db->db_close(); 
 ?>
