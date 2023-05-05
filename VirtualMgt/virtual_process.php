<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");

//$file_type = array('jpg','swf','flv','mp3','wmv');
//$file_type2 = array('jpg','gif','png','bmp');

$v_id=stripslashes(htmlspecialchars($_POST["v_id"],ENT_QUOTES));
$v_name=stripslashes(htmlspecialchars($_POST["v_name"],ENT_QUOTES));
$vg_id=stripslashes(htmlspecialchars($_POST["vg_id"],ENT_QUOTES));

//$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download/file_vdo";
//$Current_Dir3= "../ewt/".$_SESSION["EWT_SUSER"]."/download";
//$Current_Dir2 = "file_vdo";

if($_POST["flag"] =='add'){

//add data
$sql_insert = "insert into virtual_list (v_name,vg_id)    values ('$v_name','$vg_id')";
$db->query($sql_insert);
$db->write_log("create","virtual","เพิ่ม virtual   ".$_POST["v_name"]);

?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete1;?>');
          location.href='virtual_list.php?gid=<?php echo $_POST[gid];?>';
     </script>
   <?php

}else if($_POST["flag"] =='edit'){

$sql_update = "update virtual_list set v_name = '$v_name', vg_id='$vg_id' where v_id = '$_POST[v_id]' ";

$db->query($sql_update);
$db->write_log("update","Virtual","แก้ไข Virtual   ".$_POST["v_name"]);

 ?>
      <script language="JavaScript">
		 alert('<?php echo $text_genbanner_complete2;?>');
          location.href='virtual_list.php?gid=<?php echo $_POST[gid];?>';
     </script>
   <?php
}


if($_POST[flag] == 'del'){
	for($i=0;$i<$_POST[all];$i++){
		$del="del$i";
        if($$del){
           $db->query("DELETE FROM virtual_list WHERE v_id = '".$$del."' "); 
		}
	}

		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='virtual_list.php?gid=<?php echo $_POST[gid];?>';
     </script>
   <?php
}
exit;

$db->db_close(); ?>
