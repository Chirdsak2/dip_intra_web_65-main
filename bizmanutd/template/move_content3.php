<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$url = "http://localhost/ewtadmin/ewt/dmr_eng/";

if($_GET["mid"] == "en"){
$sql_art = $db->query("SELECT n_id,source FROM article_list WHERE source != '' ");
	while($N = $db->db_fetch_row($sql_art)){
		$db->query("USE db_58_dmr_eng");
		$link = "main.php?filename=".$N[1];
		echo "SELECT mp_name FROM menu_properties WHERE Glink = '$link' <br>";
		$sql_chk = $db->query("SELECT mp_name FROM menu_properties WHERE Glink = '$link' ");
		if($db->db_num_rows($sql_chk) > 0){
			$M = $db->db_fetch_row($sql_chk);
			$mname = $M[0];
			$db->query("USE db_56_dmr_web");
			$sql_detail = $db->query("SELECT ad_id FROM article_detail WHERE n_id = '$N[0]' ");
			$D = $db->db_fetch_row($sql_detail);
			
			$db->query("INSERT INTO lang_article_list (c_id,lang_name,lang_field,lang_detail) VALUES ('$N[0]','2','n_topic','".addslashes($mname)."')");
			$field = "ad_des".$D[0];
								$fp = fopen ($url."main_body.php?filename=".$N[1], "r");
									$line = "";
									while($html = @fgets($fp, 1024)){
									$line .= $html;
									}
									fclose ($fp);

			$db->query("INSERT INTO lang_article_list (c_id,lang_name,lang_field,lang_detail) VALUES ('$N[0]','2','$field','".addslashes($line)."')");
			echo $N[1]."<br>";
		}
	}
}
echo "Level 2 => Finish.";
$db->db_close();
?>
