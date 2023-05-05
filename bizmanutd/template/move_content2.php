<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$url = "http://localhost/ewtadmin/ewt/dmr_web/";

if($_GET["mid"] != ""){
$sql = $db->query("SELECT DISTINCT(Glink) , mp_name FROM menu_properties WHERE Glink LIKE 'main.php?filename=%' AND Glink NOT LIKE '%__EN' AND mp_name != '' ");
	while($R=$db->db_fetch_row($sql)){

						$s = explode("main.php?filename=",$R[0]);
						$s1 = explode("&",$s[1]);
						$filename = $s1[0];

		$sql_art = $db->query("SELECT n_id FROM article_list WHERE source = '".$filename."' ");
		if($db->db_num_rows($sql_art) == 0){
			$sql_chk = $db->query("SELECT temp_main_group.Main_Group_Name FROM temp_main_group INNER JOIN temp_index ON temp_index.Main_Group_ID = temp_main_group.Main_Group_ID WHERE temp_index.filename = '".$filename."' ");
			if($db->db_num_rows($sql_chk) > 0){
				$G = $db->db_fetch_row($sql_chk);
				$sql_g = $db->query("SELECT c_id FROM article_group WHERE c_name = '".$G[0]."' AND c_parent = '".$_GET["mid"]."' ");
					$cid = "";
					if($db->db_num_rows($sql_g) > 0){
						$C = $db->db_fetch_row($sql_g);
						$cid = $C[0];
					}else{
						$db->query("INSERT INTO article_group (c_name,c_parent) VALUES ('".$G[0]."','".$_GET["mid"]."') ");
						$cid = mysql_insert_id();
					}
						$source = $filename;
						$sourcelink = $R[0];
						$link = "";
						$type = "2";
						$db->query("INSERT INTO article_list (n_topic,n_date,c_id,source,sourceLink,news_use,link_html,target,at_id,d_id,n_approve) VALUES ('".trim($R[1])."','2551-06-20','".$cid."','".$source."','".$sourcelink."','".$type."','".$link."','_self','10','65','Y') ");
						$nid = mysql_insert_id();
								$fp = fopen ($url."main_body.php?filename=".$source, "r");
									$line = "";
									while($html = @fgets($fp, 1024)){
									$line .= $html;
									}
									fclose ($fp);
									$txt = addslashes($line);
									$db->query("INSERT INTO article_detail ( n_id , at_type_col , at_type_row , ad_pic_s , ad_pic_h , ad_pic_w , ad_pic_b , ad_des , ad_font , ad_size , ad_bold , ad_italic , ad_color, ad_align ) VALUES ( '$nid', '1', '1', '', '0', '0', '', '".$txt."' , '', '', NULL , NULL , '', '')");
			}
		}
	}
}
echo "Level 1 => Finish.";
$db->db_close();
?>
