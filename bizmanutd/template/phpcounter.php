<?
$style="image";
$height="20";
$width="15";
$hitsfile="counter.dat";
$dir_images="images";

if(file_exists($hitsfile)){
		$hits=file($hitsfile);
		$hits=$hits[0]+1;
		$fp=fopen($hitsfile,"w");
		fwrite($fp,$hits);
		fclose($fp);
}else{
		$fp=fopen($hitsfile,"w");
		fwrite($fp,"1");
		fclose($fp);
		$hits=1;
}
if($style=="text"){
		echo $hits."&nbsp;";
}else{
		$digit="0000000".strval($hits);
		$digit=substr($digit,-7);
		for($i=0;$i<strlen($digit);$i++){
				echo "<img src=".$dir_images."/".$digit[$i].".gif height=$height width=$width alt=$hits align=absmiddle>";
		}
}
?>