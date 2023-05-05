<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);

	$sql = $db->query("SELECT * FROM user_info WHERE UID = '".$_GET["UID"]."' ");
	 $R = $db->db_fetch_array($sql);
	 echo "Choose Version to Restore <hr><ul>";
	$CDir = "backupdb/".$R["EWT_User"];
	$objFolder = opendir($CDir);
				while($file = readdir($objFolder)){
					$FT= filetype($CDir."/".$file);
					if($FT == "dir"){
						if(!(($file == ".") or ($file == "..") )){
							echo "<li>".$file."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"site_restore_func.php?UID=".$_GET["UID"]."&f=".$file."\">[Choose]</a></li>";
						}
					}
				}
				echo "</ul>";
$db->db_close();
?>
