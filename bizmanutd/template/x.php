<?php
exit;
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
$id_language = "6";

	$sql = $db->query("SELECT c_id FROM lang_article_list WHERE lang_field = 'n_topic' AND lang_name = '".$id_language."' ");
		while($R = $db->db_fetch_row($sql)){

			$sql2 = $db->query("SELECT * FROM lang_article_list  WHERE lang_field = 'd_id' AND lang_name = '".$id_language."' AND c_id = '$R[0]' ");
			if($db->db_num_rows($sql2) == 0){
			
				$db->query("INSERT INTO lang_article_list (c_id,lang_field,lang_name) VALUES ('$R[0]','d_id','".$id_language."')");

			}
		}
 $db->db_close(); 
?>