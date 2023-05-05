<?php
$path = "../mail_att_file/";
$linesz= filesize($path.$_GET["file1"]);
	header( 'Content-type: application/x-www-form-urlencoded' );
	header( 'Content-Length: ' . $linesz );
	header( 'Content-Disposition: filename="'.$_GET["file2"].'"' );
	header( 'Content-Description: Download Data' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );
$fp = fopen ($path.$_GET["file1"], 'rb');
$ata = fread( $fp, $linesz);
echo $ata;
@fclose($fp);
?>