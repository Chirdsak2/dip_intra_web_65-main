<?php
include("../lib/permission1.php");
include("../lib/include.php");

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";
$folder = base64_decode($_GET["fname"]);
$Current_Dir = $Globals_Dir."/".$folder;

if (!(file_exists($Current_Dir))) {
$nopreview = "Y";
}
if($folder == ""){
$nopreview = "Y";
}
$FT= filetype($Current_Dir);
			  if($FT == "dir"){
			  $nopreview = "Y";
			  }
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet"> 

<link rel="shortcut icon" type="image/icon" href="../EWT_ADMIN/images/logo_biz.png"/>

<!-- bootstrap 3.3.7 -->
<link href="../EWT_ADMIN/css/bootstrap.css" rel="stylesheet"/>
<!-- END -->

<!-- Main Style -->
<link href="../EWT_ADMIN/style.css" rel="stylesheet"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/backend_style.css"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/icons.css"/>
<!-- END -->
</head>
<body leftmargin="0" topmargin="0">
<?php 
if($nopreview != "Y"){
$f_array = explode("/",$folder);
$ar = count($f_array);
$CurrentFile = trim($f_array[($ar -1)]);
$size = @getimagesize($Current_Dir);
		$height = $size[1];
		$width = $size[0];
		
	$file_type = explode(".",$CurrentFile);
	$c = count($file_type);
	$c = $c-1;
	$file_type[1] = strtolower($file_type[$c]);
?>
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="9D9DA1">
  <tr> 
    <td height="20" valign="middle" bgcolor="#EBEBEB"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
      Preview : <?php echo $CurrentFile; ?> </td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#FFFFFF">
	<?php
	if($file_type[1] == "swf"){
	?>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <?php if($width != ""){ echo " width = \"".$width."\""; } if($height != ""){ echo " height = \"".$height."\""; } ?>>
  <param name="movie" value="<?php echo $Current_Dir; ?>">
  <param name="quality" value="high">
  <embed src="<?php echo $Current_Dir; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" <?php if($width != ""){ echo " width = \"".$width."\""; } if($height != ""){ echo " height = \"".$height."\""; } ?>></embed></object>
  <div align="center">(<?php echo $size[0]; ?> X <?php echo $size[1]; ?>)
	<?php
	}elseif(($file_type[1] == "gif") OR ($file_type[1] == "jpg") OR ($file_type[1] == "png") OR ($file_type == "jpeg")){
	?>
	<img src="phpThumb2.php?src=<?php echo $Current_Dir; ?>&h=200&w=240" hspace="0" vspace="0" border="2" style="border-color:EEEEEE" > 
      <div align="center">(<?php echo $size[0]; ?> X <?php echo $size[1]; ?>)</div>
	  <?php } ?>
	  </td>
  </tr>
</table>
<?php }else{ ?>
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="9D9DA1">
  <tr> 
    <td height="20" valign="top" bgcolor="#F7F7F7"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
        Preview : -<br><div align="center"><br>
        <img src="../images/o.gif" name="imgpreview" width="240" height="200" hspace="0" vspace="0" border="0" id="imgpreview" style="border-color:EEEEEE" ></div></td>
  </tr>
</table>
<?php } ?>
</body>
