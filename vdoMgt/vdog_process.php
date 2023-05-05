<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");


$vdog_name=stripslashes(htmlspecialchars($_POST["vdog_name"],ENT_QUOTES));
$vdog_creator=stripslashes(htmlspecialchars($_POST["vdog_creator"],ENT_QUOTES));
$vdog_info=stripslashes(htmlspecialchars($_POST["vdog_info"],ENT_QUOTES));
$vdog_downloadable=$_POST['vdog_downloadable'];

$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/file_vdo";

if($_POST["flag"] =='add'){

/*
	 if(getenv(HTTP_X_FORWARDED_FOR)) {
		$IPn = getenv(HTTP_X_FORWARDED_FOR);
	}else{
		$IPn = getenv("REMOTE_ADDR");
	}
$sql_insert = "insert into banner_group  (banner_parentgid,banner_name,banner_timestamp,banner_uid,banner_uname,banner_ip) values ('0','".$_POST["banner_gname"]."','".date('YmdHis')."','" .$_SESSION["EWT_SUID"]."','".$_SESSION["EWT_SUSER"]."','$IPn')";
*/
 
$sql_insert = "insert into vdo_group (vdog_name,vdog_creator,vdog_info,vdog_downloadable) values ('$vdog_name','$vdog_creator','$vdog_info','$vdog_downloadable')";
$db->query($sql_insert);
$db->write_log("create","vdo","ÊÃéÒ§ËÁÇ´ vdo   ".$_POST["vdog_name"]);
 ?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete1;?>');
          location.href='main_vdo_group.php';
     </script>
   <?php
}





if($_POST["flag"] =='edit'){
$sql_update = "update vdo_group set vdog_name = '$vdog_name', vdog_creator = '$vdog_creator', vdog_info = '$vdog_info', vdog_downloadable='$vdog_downloadable' where vdog_id = '$_POST[vdog_id]' ";
$db->query($sql_update);
$db->write_log("update","vdo","á¡éä¢ËÁÇ´ vdo   ".$_POST["vdog_name"]);
 ?>
      <script language="JavaScript">
		 alert('<?php echo $text_genbanner_complete2;?>');
          location.href='main_vdo_group.php';
     </script>
   <?php
}



if($_POST[flag] == 'del'){
	for($i=0;$i<$_POST[all];$i++){
		$del="del$i";
        if($$del){
		   $db->query("DELETE FROM vdo_group WHERE vdog_id = '".$$del."' "); 
		    $sql= "SELECT * FROM vdo_list  WHERE vdo_group= '".$$del."'  " ;
			$query=$db->query($sql);
			while($data=$db->db_fetch_array($query)){
					$filename = $Current_Dir.'/'.$data[vdo_filename]; 
					@unlink($filename);
			}
			$db->query("DELETE FROM vdo_list WHERE vdo_group = '".$$del."' ");
		}
	} 
		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='main_vdo_group.php';
     </script>
   <?php 
} 
$db->db_close(); ?>
