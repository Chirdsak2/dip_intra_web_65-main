<?php
$sign = "\\";
$DDir = "../../../";
$NowD = $_GET["NowD"];
$FID = $_GET["FID"];
$CDir = $DDir.$NowD;
//echo $CDir.$sign.$FID;
$linesz= filesize($CDir.$sign.$FID);

	header( 'Content-type: application/x-www-form-urlencoded' );
	header( 'Content-Length: ' . $linesz );
	header( 'Content-Disposition: filename="' . $FID . '"' );
	header( 'Content-Description: Download Data' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );
/*header("Content-Type: application/x-www-form-urlencoded");
header("Content-Disposition: attachment; filename=$FID");
header("Pragma: no-cache");
header("Expires: 0");*/
$fp = fopen ($CDir."/".$FID, 'rb');

$ata = fread( $fp, $linesz);
echo $ata;
@fclose($fp);
?>
