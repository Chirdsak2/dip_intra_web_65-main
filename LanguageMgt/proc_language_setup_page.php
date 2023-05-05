<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		$sql = "select * from temp_index order by filename ASC";
		 $query = $db->query($sql);
		 while($rec=$db->db_fetch_array($query)){
			echo $web_name = ${"web_name1".$rec[filename]};
			if($web_name != ''){
				$db->write_log("update","lang_setting","บริหารหน้า  ".$web_name);
			}
				$sql_2 = "select * from lang_page where temp_index_filename = '".$rec[filename]."' and lang_setting_id ='$select_web'";
				  if($db->db_num_rows($db->query($sql_2))==0){
					$sql_insert =" insert into lang_page (lang_setting_id,temp_index_filename,temp_index_filename_website,lang_page_lang) values('".$select_web."','".$rec[filename]."','".$web_name."','".$hdd_lang."')";
					$db->query($sql_insert);
				}else{
				$sql_update ="update lang_page set 
																			lang_setting_id = '$select_web',
																			temp_index_filename = '$rec[filename]',
																			temp_index_filename_website='$web_name',
																			lang_page_lang = '$hdd_lang'
												where temp_index_filename = '".$rec[filename]."' and lang_setting_id ='$select_web'";
					$db->query($sql_update);
					
				}
		  }
	
$db->db_close(); ?>
<script language="javascript1.2">
self.location.href = "language_setup_page.php";
</script>
