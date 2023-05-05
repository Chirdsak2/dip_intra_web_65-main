<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST[Flag] == "add"){
	$date = date("Y-m-d H:m:s");
	$mto=count($chksend);
	for($i=0;$i<count($chkid);$i++){
		if($chksend[$i]){
             $db->query("delete from n_temp_user where tempcode = ' ' ");
			 $chksave=$db->db_num_rows($db->query("SELECT tempid FROM n_temp_user WHERE temp_gen_user_id ='".$chksend[$i]."' AND tempcode = '".$code."'"));
				if($chksave==0){
				$db->query("INSERT INTO n_temp_user (tempcode, temp_gen_user_id, temp_date) 
						VALUES ('$code','$chksend[$i]','$date')");
				}
				
		}
	}
?>
		<script language="JavaScript">
				window.opener.top.personal_list.location.reload();
				self.close();
		</script>
<?php
		exit;
}
if($Flag == "del"){
$db->query("DELETE FROM n_temp_user WHERE tempid = '$temp'");
	?>
		<script language="JavaScript">
				self.location.href='message_list_show.php?code=<?php echo $code; ?>';
		</script>
<?php
		exit;
}
$db->db_close(); ?>
