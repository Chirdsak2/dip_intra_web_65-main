<?php
$path = base64_decode($_GET["p"]);
	if(file_exists($path)){
		$path_pic= $path;
	}else{
		$path_pic = "../../images/ImageFile.gif";
	}

$linesz= filesize($path_pic);
$fp = fopen ($path_pic, 'rb');
$ata = fread( $fp, $linesz);
echo $ata;
?>
