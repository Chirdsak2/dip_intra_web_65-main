<?php
include("../lib/permission1.php");
include("../lib/include.php");

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php
$CurrentFile = $Globals_Dir.$_GET["fname"];
$size = @getimagesize($CurrentFile);
if($_GET["ftype"] == "images"){
?>
<div id="dpreview" align="center"><img src="<?php echo $CurrentFile; ?>" name="ppreview" border="1" id="ppreview" <?php echo $size[3]; ?>></div>
<?php
}elseif($_GET["ftype"] == "flash"){
?>
<div id="dpreview" align="center" ><object  name="ppreview" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <?php echo $size[3]; ?>>
  <param name="movie" value="<?php echo $CurrentFile; ?>">
  <param name="quality" value="high">
  <embed src="<?php echo $CurrentFile; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" <?php echo $size[3]; ?>></embed></object></div>
<?php
}
?>
</body>
