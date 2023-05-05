<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

		//$sql_del = "delete from lang_setting";
		//$db->query($sql_del);
		$sql_status = "select * from lang_setting";
		$query=$db->query($sql_status);
		while($rec_status = $db->db_fetch_array($query)){
			$sql_update ="update lang_setting set 
																			lang_setting_status = 'N'
												where lang_setting_id = '".$rec_status[lang_setting_id]."'";
			$db->query($sql_update);
		}
		for($i=0;$i<count($chk_select);$i++){
			$txt_lang = ${"txt_lang".$chk_select[$i]};
			$db->query("USE ".$EWT_DB_USER);
			$sql="select * from user_info where UID = '".$chk_select[$i]."'";
			 $query = $db->query($sql);
			 while($rec = $db->db_fetch_array($query)){
			 $url =$EWT_PATH."".$rec[EWT_User]."/";
			 	 $db->query("USE ".$_SESSION["EWT_SDB"]);
				 $sql_chk ="select * from lang_setting where lang_setting_id = '".$rec[UID]."'";
				 if($db->db_num_rows($db->query($sql_chk))==0){
					$sql_insert =" insert into lang_setting (lang_setting_id,user_info_website,user_info_db,lang_setting_lang,user_info_EWT_user,user_info_url,lang_setting_status) values('".$rec[UID]."','".$rec[WebsiteName]."','".$rec[db_db]."','".$txt_lang."','".$rec[EWT_User]."','".$url."','Y')";
					$db->query($sql_insert);
				}else{
					$sql_update ="update lang_setting set 
																			user_info_website = '$rec[WebsiteName]',
																			user_info_db = '$rec[db_db]',
																			lang_setting_lang='$txt_lang',
																			user_info_EWT_user ='$rec[EWT_User]',
																			user_info_url = '$url',
																			lang_setting_status = 'Y'
												where lang_setting_id = '".$rec[UID]."'";
					$db->query($sql_update);
				}
				 $db->write_log("update","lang_setting","ตั้งค่าภาษา  ".$rec[WebsiteName]);
			 }
		}
		
$db->db_close(); ?>
<script language="javascript1.2">
self.location.href = "language_setup_db.php";
</script>
