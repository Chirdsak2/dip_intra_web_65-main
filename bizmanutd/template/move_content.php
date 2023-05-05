<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$url = "http://localhost/ewtadmin/ewt/dmr_web/";

if($_GET["mid"] != ""){
$sql = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$_GET["mid"]."' ORDER BY mp_id ");
	if($db->db_num_rows($sql) > 0){
		$db->query("INSERT INTO article_group (c_name,c_parent) VALUES ('Menu','0') ");
		$id = mysql_insert_id();

		while($R=$db->db_fetch_array($sql)){
		$rest = substr($R["mp_id"], 0, -5);		
			if($_GET["mid"] == $rest){
				$parentid = $id;
			}else{
				$sql_g = $db->query("SELECT c_id FROM article_group WHERE c_name LIKE '".$rest."NSNSNS%' ");
				$G = $db->db_fetch_row($sql_g);
				$parentid = $G[0];
			}
				$menu = $R["mp_name"];	
				if($R["Glink"] == ""){
					$db->query("INSERT INTO article_group (c_name,c_parent) VALUES ('".$R["mp_id"]."NSNSNS".$menu."','".$parentid."') ");
				}else{
					if(eregi("main.php\?filename=",$R["Glink"])){
						$s = explode("main.php?filename=",$R["Glink"]);
						$s1 = explode("&",$s[1]);
						$source = $s1[0];
						$sourcelink = $R["Glink"];
						$link = "";
						$type = "2";
					}else{
						$source = "";
						$link = $R["Glink"];
						$sourcelink = $R["Glink"];
						$type = "1";
					}
					$db->query("INSERT INTO article_list (n_topic,n_date,c_id,source,sourceLink,news_use,link_html,target,at_id,d_id,n_approve) VALUES ('".trim($menu)."','2551-06-20','".$parentid."','".$source."','".$sourcelink."','".$type."','".$link."','_self','10','65','Y') ");
						if($type == "2"){
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
	$sql_update = $db->query("SELECT c_id,c_name FROM article_group ");
	while($A = $db->db_fetch_array($sql_update)){
		$name = explode("NSNSNS",$A[c_name]);
		$topic = "";
		if($name[1] == ""){
			$topic = $name[0];
		}else{
			$topic = $name[1];
		}
		$db->query("UPDATE article_group SET c_name = '".trim($topic)."' WHERE c_id = '".$A[c_id]."' ");
	}

}
echo "Level 0 => Finish.";
$db->db_close();
?>
