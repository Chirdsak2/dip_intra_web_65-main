<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
for($i=0;$i<$_POST["allx"];$i++){
		$nid = $_POST["news".$i];
		if($nid != ""){
		$snews = $db->query("SELECT * FROM article_list INNER JOIN share_article ON article_list.n_id = share_article.n_id AND article_list.UID = share_article.UID_s   AND article_list.user_share = share_article.user_s WHERE share_article.sg_id = '".$nid."' ");
		$N = $db->db_fetch_array($snews);
				$db->query("USE ".$_SESSION["EWT_SDB"]);
			$db->query("INSERT INTO article_list ( c_id , n_date , n_timestamp , n_topic , n_des , source , sourceLink , keyword , picture , news_use , at_id , link_html , target , expire , logo , access , n_share , n_shareuse , n_sharename , n_shareid , n_owner) VALUES ( '$N[c_id]', '$N[n_date]', '$_N[n_timestamp]', '$N[n_topic]', '$N[n_des]', '$N[source]', '$N[sourceLink]', '$N[keyword]', '$N[picture]', '$N[news_use]', '', '$N[link_html]', '$N[target]', '$N[expire]', '$N[logo]', '', NULL , 'Y', '$N[user_s]', '$nid', '$N[n_owner]')");
			$db->write_log("approve","article","อนุมัติการ share article     " .$N[n_topic]);
			$sql_max = $db->query("SELECT MAX(n_id) FROM article_list WHERE c_id = '".$N[c_id]."' AND n_topic = '".$N[n_topic]."' ");
			$M = $db->db_fetch_row($sql_max);
			$snid = $M[0];
				$db->query("USE ".$EWT_DB_USER);
			$db->query("UPDATE share_article SET s_status = 'Y',n_id_t = '$snid' WHERE sg_id = '".$nid."' ");
		}
}

?>
<script language="javascript">
alert("Accept Share Article Complete");
self.location.href = 'article_request.php';
</script>
<?php
			$db->db_close(); ?>
