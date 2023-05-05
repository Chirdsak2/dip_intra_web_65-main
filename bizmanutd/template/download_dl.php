<?php 
   $filepath=$_GET[filepath];
   $filename=$_GET[filename];
   $linesz= filesize($filepath);
	header( 'Content-type: application/x-www-form-urlencoded' );
	header( 'Content-Length: ' . $linesz );
	header( 'Content-Disposition: filename="'.$filename.'"' );
	header( 'Content-Description: Download Data' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' ); 
	
	$fp = fopen ($filepath, 'rb');
	
	$ata = fread( $fp, $linesz);
	echo $ata;
	@fclose($fp);
?>
