<?php
session_start();
//include("../lib/permission1.php");
/*include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");*/

include("../EWT_ADMIN/comtop_pop.php");
include("../language/banner_language.php");

/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
exit();*/

if($_POST[flag] == "add"){

	if(getenv(HTTP_X_FORWARDED_FOR)) {
		$IPn = getenv(HTTP_X_FORWARDED_FOR);
	}else{
		$IPn = getenv("REMOTE_ADDR");
	}
	if($_POST[start_date] != ''){
	$date_s = explode('/',$_POST[start_date]);
	$start_date = $date_s[2].'-'.$date_s[1].'-'.$date_s[0];
	}
	if($_POST[start_date] != ''){
	$date_e = explode('/',$_POST[end_date]);
	$end_date = $date_e[2].'-'.$date_e[1].'-'.$date_e[0];
	}
	$sql_add = "INSERT INTO banner (banner_name,banner_detail,banner_pic,banner_link,banner_show,banner_update,banner_create,banner_traget,banner_alt,banner_gid,banner_timestamp,banner_uid,banner_uname,banner_ip,banner_show_start,banner_show_end) VALUES ('".$_POST[banner_name]."','".$_POST[banner_detail]."','".$_POST[banner_pic]."','".$_POST[banner_link]."','no',NOW(),NOW(),'".$_POST["target_link"]."','".$_POST["txt_alt"]."','".$_POST["banner_gid"]."','".date('YmdHis')."','" .$_SESSION["EWT_SUID"]."','".$_SESSION["EWT_SUSER"]."','$IPn','".$start_date."','".$end_date."')";
	$db->query($sql_add);
	$db->write_log("create","banner","สร้าง banner   ".$_POST["banner_name"]);
	/*print "<script>";
	print "window.opener.frm1.submit();";
	print "alert('บันทึกข้อมูลแล้ว');";
	print "window.close();";
	print "</script>";*/
   ?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete1;?>');
          location.href='main_banner.php?banner_gid=<?php echo $_POST["banner_gid"];?>';
     </script>
   <?php
}

if($_POST[flag] == "edit"){	
	if($_POST[start_date] != ''){
	$date_s = explode('/',$_POST[start_date]);
	$start_date = $date_s[2].'-'.$date_s[1].'-'.$date_s[0];
	}
	if($_POST[start_date] != ''){
	$date_e = explode('/',$_POST[end_date]);
	$end_date = $date_e[2].'-'.$date_e[1].'-'.$date_e[0];
	}
	$sql_edit = "UPDATE banner SET banner_name='".$_POST[banner_name]."',banner_detail ='".$_POST[banner_detail]."', banner_pic= '".$_POST[banner_pic]."',banner_link='".$_POST[banner_link]."',banner_update=NOW(),banner_traget = '".$_POST["target_link"]."',banner_alt = '".$_POST["txt_alt"]."',banner_gid = '".$_POST["banner_gid"]."',banner_show_end = '".$end_date."',banner_show_start = '".$start_date."' WHERE banner_id = '".$_POST[banner_id]."' ";
	$db->query($sql_edit);
	$db->write_log("update","banner","แก้ไข banner   ".$_POST["banner_name"]);
	/*print "<script>";
	print "window.opener.frm1.submit();";
	print "alert('แก้ไขข้อมูลแล้ว');";
	print "window.close();";
	print "</script>";
	*/
	?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete2;?>');
          location.href='main_banner.php?banner_gid=<?php echo $_POST["banner_gid"];?>';
     </script>
   <?php

}

if($_GET[flag] == 'del'){
	$rec=$db->db_fetch_array($db->query("select * from banner WHERE banner_id = '".$_GET[banner_id]."' "));
	$db->write_log("delete","banner","ลบ banner   ".$rec[banner_name]);
	$sql_del1 = "DELETE FROM banner WHERE banner_id = '".$_GET[banner_id]."' ";
	$db->query($sql_del1);
	//del file detail
	$sql = $db->query("select * from lang_config");
	while($rec = $db->db_fetch_array($sql)){
		$namefolder = 'banner_'.$rec[lang_config_suffix].'_'.$_GET[banner_id];
		$Current_Dir1 = HTTP_HOST."language/".$namefolder.".php"; //"../ewt/".$_SESSION["EWT_SUSER"]."/language/".$namefolder.".php";
		@unlink($Current_Dir1);
	}
	/*print "<script>";
	print "alert('ลบข้อมูลแล้ว');";
	print "location.href = 'main_banner.php' ;";
	print "</script>";*/
		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='main_banner.php?banner_gid=<?php echo $_GET["banner_gid"];?>';
     </script>
   <?php
	
}

if($_POST[flag] == "tool"){	
	/*$sql_edit = "UPDATE banner SET banner_show='no',banner_update=NOW()   ";
	$db->query($sql_edit);
	for($i=0;$i<count($_POST[show]);$i++){
		$sql_edit = "UPDATE banner SET banner_show='yes',banner_update=NOW(),banner_position='".$_POST[ban_pos][$i]."'  WHERE banner_id = '".$_POST[show][$i]."' ";
		$db->query($sql_edit);
	}*/
	for($i=0;$i<count($_POST[ban_id]);$i++){
		$sql_edit = "UPDATE banner SET banner_position='".$_POST[ban_pos][$i]."'  WHERE banner_id = '".$_POST[ban_id][$i]."' ";
		$db->query($sql_edit);
			$rec=$db->db_fetch_array($db->query("select * from banner WHERE banner_id = '".$_POST[ban_id][$i]."' "));
			$db->write_log("update","banner","ปรับปรุง tools  ใน banner  ".$rec[banner_name]);
	}

	/*$width=trim($_POST[rand_width]);
	$height=trim($_POST[rand_height]);
     $sql_edit = "UPDATE banner_setting SET 
                               banner_type='".$_POST[banner_type]."',
                               banner_view='".$_POST[banner_view]."',
                               banner_rand_max='".$_POST[rand_max]."',
                               banner_rand_row='".$_POST[rand_row]."',
                               banner_width='$width',
                               banner_height='$height'";
	 $db->query($sql_edit);
	$db->write_log("update","banner","ตั้งค่าการแสดงผล banner   ");
	/*print "<script>";
	print "alert('แก้ไขข้อมูลแล้ว');";
	print "location.href = 'banner_tool.php';";
	print "</script>";
	*/
	?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete2;?>');
          //location.href='main_banner.php?banner_gid=<?php //echo $_POST["banner_gid"];?>';
		  location.href='banner_search.php?keyword=&banner_gid=20&proc=CU';
		  //
     </script>
   <?php
}


$db->db_close(); ?>
