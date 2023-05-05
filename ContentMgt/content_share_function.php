<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$user = $_SESSION["EWT_SUSER"];
$d = date("Y-m-d H:i:s");
if($_POST["Flag"] == "UpdateP"){
$b = explode("@",$_POST["buse"]);
$bn = explode("##@@##",$_POST["busename"]);
	for($i=0;$i<count($b);$i++){
		if($b[$i] != ""){
			$sql = $db->query("SELECT COUNT(s_id) AS CT FROM share_content WHERE s_user = '".$user."' AND s_bid = '".$b[$i]."' ");
			$c = $db->db_fetch_row($sql);
			if($c[0] > 0){
			$db->query("UPDATE share_content SET s_html = '".$bn[$i]."', s_update =  '".$d."' WHERE s_user = '".$user."' AND s_bid = '".$b[$i]."' ");
			}else{
			$db->query("INSERT INTO share_content (s_user,s_bid,s_html,s_update) VALUES ('".$user."','".$b[$i]."','".$bn[$i]."','".$d."')");
			}
		}
	}
}
?>
<script language="JavaScript">
self.close();
</script>
<?php
$db->db_close(); ?>
