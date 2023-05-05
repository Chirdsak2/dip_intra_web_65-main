<?php
session_start();
 if(eregi('http://',$_GET[url]) || eregi('mailto:',$_GET[url])){
 ?>
<script language="javascript1.2">
window.location.href = "<?php echo $_GET[url];?>";
</script>
<?php
} else {

//$linesz= filesize("../".$_GET[path]."/".$_GET[url]);
$linesz= filesize("../".$_GET[path]."/".$_GET[url]);
	$FID = explode('/',$_GET[url]);
	$FID2 = count($FID)-1;
		header( 'Content-type: application/x-www-form-urlencoded' );
		header( 'Content-Length: ' . $linesz );
		header( 'Content-Disposition: filename="' . $FID[$FID2]. '"' );
		header( 'Content-Description: Download Data' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
	/*header("Content-Type: application/x-www-form-urlencoded");
	header("Content-Disposition: attachment; filename=$FID");
	header("Pragma: no-cache");
	header("Expires: 0");*/
	$fp = fopen ("../".$_GET[path]."/".$_GET[url], 'rb');
	
	$ata = fread( $fp, $linesz);
	echo $ata;
	@fclose($fp);

}
?>