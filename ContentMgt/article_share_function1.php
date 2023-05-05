<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$u = explode("@",$_POST["txtuse"]);
$allu = count($u);

	for($y=0;$y<=$allu;$y++){
		$chk = $u[$y];
		if($chk != ""){
			$ex = explode("_",$chk);
				$UID_t = $ex[0];
				$CID = $ex[1];
				$check = $db->query("SELECT n_id FROM share_article WHERE n_id = '".$_POST["nid"]."' AND UID_s = '".$_POST["UID"]."' AND user_s = '".$_POST["USER"]."' AND UID_t = '$UID_t' AND c_id = '$CID' ");
				$sql = $db->query("SELECT EWT_User FROM user_info WHERE UID = '".$UID_t."' ");
				$S = $db->db_fetch_row($sql);
				$User_t = $S[0];
				$sgid = $S[0];
				if($db->db_num_rows($check) == 0){
					
					$db->query("INSERT INTO share_article ( n_id , UID_s , user_s , UID_t , user_t , c_id , s_date , s_status , a_date ) VALUES ('".$_POST["nid"]."', '$_POST[UID]', 	'$_POST[USER]', '$UID_t', '$User_t', '$CID', '".date("Y-m-d")."', 'W', '' )");
					//select max id
						$sql_max = $db->query("SELECT MAX(sg_id) FROM share_article  ");//WHERE c_id = '".$N[c_id]."' AND n_topic = '".$N[n_topic]."'
						$M = $db->db_fetch_row($sql_max);
						$sgid = $M[0];
				}
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '".$_POST["nid"]."' ");
					$R = $db->db_fetch_array($sql_edit);
					$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '$CID' ");
					$Rgroup = $db->db_fetch_array($sql_group);
					$db->write_log("share","article","share article     " .$R[n_topic]." ให้ website ".$User_t." group article ".$Rgroup[c_name]);
					$db->query("USE ".$EWT_DB_USER);
				//select tb for user_info and update article auto
					$sql_tb = $db->query("select * from user_info where UID ='".$UID_t."'");
					$T = $db->db_fetch_array($sql_tb);
					$db_main = $T[db_db];
					$db->query("USE ".$db_main."");
					$sql_uid = $db->query("select * from article_auto where UID='".$_POST[UID]."' and c_id = '".$CID."'");
					$num = mysql_num_rows($sql_uid);
					if($num>0){
					$db->query("USE ".$EWT_DB_USER);
					
							$snews = $db->query("SELECT * FROM article_list INNER JOIN share_article ON article_list.n_id = share_article.n_id AND article_list.UID = share_article.UID_s   AND article_list.user_share = share_article.user_s WHERE share_article.sg_id = '".$sgid."' ");
							$N = $db->db_fetch_array($snews);
					
							$db->query("USE ".$db_main);
							$db->query("INSERT INTO article_list ( c_id , n_date , n_timestamp , n_topic , n_des , source , sourceLink , keyword , picture , news_use , at_id , link_html , target , expire , logo , access , n_share , n_shareuse , n_sharename , n_shareid,n_approve,n_approvedate ,n_owner) VALUES ( '$N[c_id]', '$N[n_date]', '$_N[n_timestamp]', '$N[n_topic]', '$N[n_des]', '$N[source]', '$N[sourceLink]', '$N[keyword]', '$N[picture]', '1', '', '$N[link_html]', '$N[target]', '$N[expire]', '$N[logo]', '', NULL , 'Y', '$N[user_s]', '$nid','Y','".date("Y-m-d")."', '$N[n_owner]')");
							
							$sql_max = $db->query("SELECT MAX(n_id) FROM article_list WHERE c_id = '".$N[c_id]."' AND n_topic = '".$N[n_topic]."' ");
							$M = $db->db_fetch_row($sql_max);
							$snid = $M[0];
							$db->query("USE ".$EWT_DB_USER);
							$db->query("UPDATE share_article SET s_status = 'Y',n_id_t = '$snid' WHERE sg_id = '".$sgid."' ");
					}
					$db->query("USE ".$EWT_DB_USER);
		}
	}

$u = "";

$u = explode("@",$_POST["txtnouse"]);
$allu = count($u);

	for($y=0;$y<=$allu;$y++){
		$chk = $u[$y];
		if($chk != ""){
			$ex = explode("_",$chk);
				$UID_t = $ex[0];
				$CID = $ex[1];
				$check = $db->query("SELECT sg_id,n_id_t,s_status FROM share_article WHERE n_id = '".$_POST["nid"]."' AND UID_s = '".$_POST["UID"]."' AND user_s = '".$_POST["USER"]."' AND UID_t = '$UID_t' AND c_id = '$CID' ");
				if($db->db_num_rows($check) > 0){
					$R = $db->db_fetch_array($check);
					
					if($R["s_status"] == "Y"){
						$sql = $db->query("SELECT db_db FROM user_info WHERE UID = '".$UID_t."' ");
						$S = $db->db_fetch_row($sql);
						$db->query("USE ".$S[0]);
						$db->query("DELETE FROM article_list WHERE n_id = '$R[n_id_t]' AND n_shareuse = 'Y' ");
						$db->query("USE ".$EWT_DB_USER);
					}
					

						$db->query("DELETE FROM share_article WHERE sg_id = '".$R["sg_id"]."' ");

				}
		}
	}
	
	//chk article share for  chang logo show
	$sql_chk = "select  count(*) as num from share_article where n_id = '".$_POST["nid"]."' and user_s = '".$_SESSION["EWT_SUSER"]."'";
	$query = $db->query($sql_chk);
	$rec_chk = $db->db_fetch_array($query);
	if($rec_chk[num] == '0' ){
		$db->query("DELETE FROM article_list WHERE n_id = '".$_POST["nid"]."'");
		$db->query("USE ".$_SESSION["EWT_SDB"]."");
		$db->query("UPDATE article_list SET n_share = '',n_shareuse='',n_sharename='',n_shareid='' where n_id ='".$_POST["nid"]."'");
		$db->query("USE ".$EWT_DB_USER);
	}
?>
<script language="javascript">
alert("Update Share article complete");
self.parent.opener.location.reload();
self.close();
</script>
<?php
			$db->db_close(); ?>
