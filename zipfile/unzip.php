<?php
set_time_limit(0);
echo '<h1>PHP4+5 Unzip by pure88 :) [<a href="http://www.charinnawaritloha.net/" target="_blank">web</a>]</h1>';

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function show_time() {
	global $time_start;
	$time_end = microtime_float();
	$time = $time_end - $time_start;

	echo "<p><b>Process $time seconds</b></p>\n";
}


$time_start = microtime_float();

$zipfile_name="sample.zip";


//if(!isset($_GET['zipfile'])) {
if(!isset($zipfile_name)) {
	die("Invalid paramenter <br>Usage...<br><pre>unzip.php?zipfile=<i>$zipfile_name</i></pre>");
}

if(class_exists('ZipArchive')) {
	$zip = new ZipArchive;
	if ($zip->open($_GET['zipfile']) === TRUE) {
			$zip->extractTo('./');
			$zip->close();
			show_time();
			die('ZipArchive - ok');
	} else {
			die('ZipArchive - failed');
	}
}

$zip = zip_open($_GET['zipfile']);
if ($zip) {
		echo '<pre><h2>Scan Zipfile ' . $_GET['zipfile'] . ' ...</h2>';
    while ($zip_entry = zip_read($zip)) {
				$sFileName = zip_entry_name($zip_entry);
				$nFileSize = zip_entry_filesize($zip_entry);
				printf("%s \t(%s KB)\n", $sFileName, number_format($nFileSize/1024, 2));

				$sDir = substr($sFileName,-1);
				if(nFileSize==0 && ($sDir=='\\' || $sDir=='/')) {
					echo "<font color=green>\tDirectory: Yes</font>\n";
					if(!file_exists('./' . substr($sFileName, 0, -1))) {
						mkdir('./' . $sFileName, 0755);
					}
				}
				else {
					if (zip_entry_open($zip, $zip_entry, 'r')) {						
						$fp = fopen('./' . $sFileName,'wb');
						if($fp) {
							$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
							fwrite($fp, $buf);
							fclose($fp);
							unset($fp, $buf);
						}
						else {
							echo '<font color=red> Error extract file: ' . $sFileName . "</font>\n";
						}
						zip_entry_close($zip_entry);
					}
				}
				echo "<hr>";
    }
    zip_close($zip);
		echo '</pre>';
		show_time();
}
else {
	die('Invalid or zip file not found.');
}
?> 
