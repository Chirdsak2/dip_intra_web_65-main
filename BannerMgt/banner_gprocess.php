<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");

if($_POST["flag"] =='add'){

	 if(getenv(HTTP_X_FORWARDED_FOR)) {
		$IPn = getenv(HTTP_X_FORWARDED_FOR);
	}else{
		$IPn = getenv("REMOTE_ADDR");
	}

$sql_insert = "insert into banner_group  (banner_parentgid,banner_name,banner_timestamp,banner_uid,banner_uname,banner_ip) values ('0','".$_POST["banner_gname"]."','".date('YmdHis')."','" .$_SESSION["EWT_SUID"]."','".$_SESSION["EWT_SUSER"]."','$IPn')";
$db->query($sql_insert);
$db->write_log("create","banner","สร้างหมวด banner   ".$_POST["banner_gname"]);
 ?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete1;?>');
          location.href='main_group_banner.php';
     </script>
   <?php
}
if($_POST["flag"] =='edit'){
$sql_update = "update banner_group set banner_name = '".$_POST["banner_gname"]."' where banner_gid = '".$_POST["banner_id"]."'";
$db->query($sql_update);
$db->write_log("update","banner","แก้ไขหมวด banner   ".$_POST["banner_gname"]);
 ?>
      <script language="JavaScript">
		 alert('<?php echo $text_genbanner_complete2;?>');
          location.href='main_group_banner.php';
     </script>
   <?php
}
if($_GET[flag] == 'del'){
	$rec=$db->db_fetch_array($db->query("select * from banner_group WHERE banner_gid = '".$_GET[banner_id]."' "));
	$db->write_log("delete","banner","ลบหมวด banner   ".$rec[banner_name]);
	$sql_del1 = "DELETE FROM banner_group WHERE banner_gid = '".$_GET[banner_id]."' ";
	$db->query($sql_del1);
	$sql = "select * from banner where banner_gid = '".$_GET[banner_id]."'";
	$query = $db->query($sql);
	while($rec=$db->db_fetch_array($query)){
		$sql2 = $db->query("select * from lang_config");
		while($rec2 = $db->db_fetch_array($sql2)){
			$namefolder = 'banner_'.$rec2[lang_config_suffix].'_'.$rec[banner_id];
			$Current_Dir1 = "../ewt/".$_SESSION["EWT_SUSER"]."/language/".$namefolder.".php";
			@unlink($Current_Dir1);
		}
		$sql_del2 = "DELETE FROM banner WHERE banner_gid = '".$rec[banner_id]."' ";
		$db->query($sql_del2);
	}
	//$sql_del2 = "DELETE FROM banner WHERE banner_gid = '".$_GET[banner_id]."' ";
	//$db->query($sql_del2);
		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='main_group_banner.php';
     </script>
   <?php
	
}
$db->db_close(); ?>
