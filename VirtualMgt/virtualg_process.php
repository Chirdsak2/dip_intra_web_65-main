<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");


$vg_name=stripslashes(htmlspecialchars($_POST["vg_name"],ENT_QUOTES));
$vg_parent=stripslashes(htmlspecialchars($_POST["vg_parent"],ENT_QUOTES));

//$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/file_vdo";

if($_POST["flag"] =='add'){

/*
	 if(getenv(HTTP_X_FORWARDED_FOR)) {
		$IPn = getenv(HTTP_X_FORWARDED_FOR);
	}else{
		$IPn = getenv("REMOTE_ADDR");
	}
$sql_insert = "insert into banner_group  (banner_parentgid,banner_name,banner_timestamp,banner_uid,banner_uname,banner_ip) values ('0','".$_POST["banner_gname"]."','".date('YmdHis')."','" .$_SESSION["EWT_SUID"]."','".$_SESSION["EWT_SUSER"]."','$IPn')";
*/
 
$sql_insert = "insert into virtual_group (vg_name,vg_parent) values ('$vg_name','$vg_parent')";
$db->query($sql_insert);
$db->write_log("create","virtual","สร้างหมวด virtual  ".$_POST["vg_name"]);

$sql_insert = "select max(vg_id) as maxid from virtual_group";
$query=$db->query($sql_insert);
$dat=$db->db_fetch_array($query);

 ?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete1;?>');
          location.href='virtual_list.php?gid=<?php echo $dat[maxid]?>';
     </script>
   <?php
}

if($_POST["flag"] =='edit'){
$sql_update = "update virtual_group set vg_name = '$vg_name',vg_parent = '$vg_parent'    where vg_id = '$_POST[vg_id]' ";
$db->query($sql_update);
$db->write_log("update","virtual","แก้ไขหมวด virtual   ".$_POST["vg_name"]);
 ?>
      <script language="JavaScript">
		 alert('<?php echo $text_genbanner_complete2;?>');
          location.href='virtual_list.php?gid=<?php echo $_POST[vg_id]?>';
     </script>
   <?php
}



if($_POST[flag] == 'del'){
	for($i=0;$i<$_POST[all];$i++){
		$del="del$i";
        if($$del){
		    $db->query("DELETE FROM virtual_group WHERE vg_id = '".$$del."' "); 
			$db->query("DELETE FROM virtual_list WHERE vg_id = '".$$del."' ");
		}
	} 
		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='virtual_list.php';
     </script>
   <?php 
} 
$db->db_close(); ?>
