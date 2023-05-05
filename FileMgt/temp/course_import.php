<?php
$datamfile ="temp/zxczxczx/ssss.zip"
	$command='WinRAR.exe x -o+ -df -ep1 '.$datamfile;
	$output = shell_exec($command);
	unlink($datamfile);
?>
