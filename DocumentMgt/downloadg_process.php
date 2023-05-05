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
$dlg_private=stripslashes(htmlspecialchars($_POST["dlg_private"],ENT_QUOTES));

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
 
$sql_insert = "insert into docload_group (dlg_name,dlg_detail,dlg_private,dlg_parent) values ('$dlg_name','$dlg_detail','$dlg_private','".$_REQUEST[pid]."')";
$db->query($sql_insert);
$db->write_log("create","download","สร้างหมวด download   ".$_POST["dlg_name"]);
 ?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete1;?>');
          location.href='download_list.php?gid=<?php echo $_REQUEST[pid];?>';
     </script>
   <?php
}


if($_POST["flag"] =='edit'){
$sql_update = "update docload_group set dlg_name = '$dlg_name',dlg_detail = '$dlg_detail' ,dlg_private = '$dlg_private' 
                                where dlg_id = '$_POST[dlg_id]' ";
$db->query($sql_update);
$db->write_log("update","download","แก้ไขหมวด Download    ".$_POST["dlg_name"]);
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
		$Current_UploadDir = "../ewt/".$_SESSION["EWT_SUSER"]."/download_doc/dl_$del";
        if($$del){
		    $sql= "SELECT * FROM docload_group  WHERE dlg_id= '".$$del."'  " ;
			$query=$db->query($sql);
			$data=$db->db_fetch_array($query);
			$dlg_name=$data[dlg_name];

		    $db->query("DELETE FROM docload_group WHERE dlg_id = '".$$del."' "); 
		    $sql= "SELECT * FROM docload_list  WHERE dl_dlgid= '".$$del."'  " ;
			$query=$db->query($sql);
			while($data=$db->db_fetch_array($query)){
					$filename = $Current_UploadDir.'/'.$data[dl_name]; 
					@unlink($filename);
			}
			$db->query("DELETE FROM download_list WHERE dl_gid = '".$$del."' ");
		}
       $db->write_log("delete","download","แก้ไขหมวดDownload    ".$dlg_name);
	} 
		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          //location.href='main_download_group.php';
		  location.href='download_list.php?gid=<?php echo $_REQUEST[pid];?>';
     </script>
   <?php 
} 
$db->db_close(); ?>
