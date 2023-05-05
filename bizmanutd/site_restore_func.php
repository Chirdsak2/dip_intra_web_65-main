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
	$CDir = "backupdb/".$R["EWT_User"]."/".$_GET["f"];
	$db->query("drop database `".$R[db_db]."`");
	$db->query("create database `".$R[db_db]."`");
	$db->query("USE ".$R[db_db]);
	$sc = "";
	$objFolder = opendir($CDir);
				while($file = readdir($objFolder)){
					$FT= filetype($CDir."/".$file);
					if($FT == "file"){
						$e = explode(".",$file);
						if($e[1] == "MYD"){
							$sc .= ", `".$e[0]."`";
						}
					}
				}
			$schema = substr($sc, 1);
			$path = $_SERVER["SCRIPT_FILENAME"];
			$file2 = dirname ($path)."/".$CDir;
			$sql_query = "restore table ".$schema." from '".$file2."'";
			mysql_query($sql_query);
$db->db_close();
echo "Restore Version : ".$_GET["f"]."<br>Done.";
?>
