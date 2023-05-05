<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");


$dlg_name=stripslashes(htmlspecialchars($_POST["dlg_name"],ENT_QUOTES));
$dlg_detail=stripslashes(htmlspecialchars($_POST["dlg_detail"],ENT_QUOTES));
$dlg_type=stripslashes(htmlspecialchars($_POST["dlg_type"],ENT_QUOTES));

$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/downloadMgt";

if($_POST["flag"] =='add'){

/*
	 if(getenv(HTTP_X_FORWARDED_FOR)) {
		$IPn = getenv(HTTP_X_FORWARDED_FOR);
	}else{
		$IPn = getenv("REMOTE_ADDR");
	}
$sql_insert = "insert into banner_group  (banner_parentgid,banner_name,banner_timestamp,banner_uid,banner_uname,banner_ip) values ('0','".$_POST["banner_gname"]."','".date('YmdHis')."','" .$_SESSION["EWT_SUID"]."','".$_SESSION["EWT_SUSER"]."','$IPn')";
*/
 
$sql_insert = "insert into download_group (dlg_name,dlg_detail,dlg_type) values ('$dlg_name','$dlg_detail','$dlg_type')";
$db->query($sql_insert);
$db->write_log("create","download","สร้างหมวด download   ".$_POST["dlg_name"]);
 ?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete1;?>');
          location.href='main_download_group.php';
     </script>
   <?php
}


if($_POST["flag"] =='edit'){
$sql_update = "update download_group set dlg_name = '$dlg_name',dlg_detail = '$dlg_detail' ,dlg_type = '$dlg_type' 
                                where dlg_id = '$_POST[dlg_id]' ";
$db->query($sql_update);
$db->write_log("update","download","แก้ไขหมวดDownload    ".$_POST["dlg_name"]);
 ?>
      <script language="JavaScript">
		 alert('<?php echo $text_genbanner_complete2;?>');
          location.href='main_download_group.php';
     </script>
   <?php
}


if($_POST[flag] == 'del'){
	for($i=0;$i<$_POST[all];$i++){
		$del="del$i";
        if($$del){
		    $sql= "SELECT * FROM download_group  WHERE dlg_id= '".$$del."'  " ;
			$query=$db->query($sql);
			$data=$db->db_fetch_array($query);
			$dlg_name=$data[dlg_name];

		    $db->query("DELETE FROM download_group WHERE dlg_id = '".$$del."' "); 
		    $sql= "SELECT * FROM download_list  WHERE dl_gid= '".$$del."'  " ;
			$query=$db->query($sql);
			while($data=$db->db_fetch_array($query)){
					$filename = $Current_Dir.'/'.$data[dl_sysfile]; 
					@unlink($filename);
			}
			$db->query("DELETE FROM download_list WHERE dl_gid = '".$$del."' ");
		}
       $db->write_log("delete","download","แก้ไขหมวดDownload    ".$dlg_name);
	} 
		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='main_download_group.php';
     </script>
   <?php 
} 
$db->db_close(); ?>
