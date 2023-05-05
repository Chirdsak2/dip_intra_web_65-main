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
	 $file_bk = date("YmdHis");
	 if(!file_exists("backupdb")){ mkdir("backupdb", "0777"); }
	 if(!file_exists("backupdb/".$R["EWT_User"])){ mkdir("backupdb/".$R["EWT_User"], "0777"); }
	 if(!file_exists("backupdb/".$R["EWT_User"]."/".$file_bk)){ mkdir("backupdb/".$R["EWT_User"]."/".$file_bk, "0777"); }
	 
	 mysql_query("USE ".$R["db_db"]) or die(mysql_error());
	 $schema ="";
           $result = mysql_list_tables($R["db_db"]);
		       for ($i = 0; $i < mysql_num_rows($result); $i++){
					$tb = mysql_tablename($result, $i);	
						$schema .= ",`".$R["db_db"]."`.`".$tb."`";
						mysql_query("alter table `".$R["db_db"]."`.`".$tb."` Engine = MYISAM") or die(mysql_error());
			   }
			$schema = substr($schema, 1);
			echo $path = $_SERVER["SCRIPT_FILENAME"];
			echo '<BR>';
			echo $file = dirname ($path)."/backupdb/".$R["EWT_User"]."/".$file_bk;
			echo '<BR>';
			echo $sql_query = "backup table ".$schema." to '".$file."'";
			mysql_query($sql_query);

$db->db_close();
echo "Timestamp : ".$file_bk."<br>Done.";
?>
