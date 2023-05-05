<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");

$file_type = array('jpg','swf','flv','mp3','wmv','rar','zip');
$file_type2 = array('jpg','gif','png','bmp');
$Current_Dir= "../ewt/".$_SESSION["EWT_SUSER"]."/downloadMgt";

$dl_name=stripslashes(htmlspecialchars($_POST["dl_name"],ENT_QUOTES));
$dl_detail=stripslashes(htmlspecialchars($_POST["dl_detail"],ENT_QUOTES));  
$dl_date=stripslashes(htmlspecialchars($_POST["dl_date"],ENT_QUOTES));

$gid = $_POST[gid];
$flag = $_POST["flag"];
$vdo_id = $_POST[vdo_id];

$fail_type=0;

if($_POST["flag"] =='add'){
		if($_FILES["dl_file"]['size']>0){
				@mkdir ($Current_Dir, 0777);
				$file_type_server = explode(".",$_FILES["dl_file"]["name"]);
				$C = count($file_type_server);
				$CT = $C-1;
				$dir = strtolower($file_type_server[$CT]);
				for($x=0;$x<count($file_type);$x++){
						if($dir == $file_type[$x] ){
							$fail_type = 1;
						}
				}
		}

		if($fail_type==1 and $_FILES[dl_file][size]>0){
			    $real_filename=$_FILES[dl_file][name];
			    $real_filetype=$_FILES[dl_file][type];
			    $real_filesize=$_FILES[dl_file][size];

				$F = explode(".",$_FILES["dl_file"]["name"]);
				$C = count($F);
				$CT = $C-1;
				//$dir = strtolower($F[$CT]);
				$dir="tmp";
				$nfile = "file_".rand(0,9).rand(0,9).'_'.date("YmdHis");
				$filename = $nfile.".".$dir;
				copy($_FILES["dl_file"]["tmp_name"],$Current_Dir."/".$filename);
				@chmod ($Current_Dir."/".$filename, 0777);

				$d=explode('/',$_POST[dl_date]);
				$createdate=($d[2]-543).$d[1].$d[0];

				$sql_insert = "insert into download_list (dl_name,dl_detail,dl_userfile,dl_sysfile,dl_filetype,dl_filesize,dl_createdate,dl_update,dl_gid)  
									  values ('$dl_name','$dl_detail','$real_filename','$filename','$real_filetype','$real_filesize','$createdate','".date('Ymdhis')."','$_POST[dl_group]')";
				$db->query($sql_insert);
				$db->write_log("create","download","เพิ่ม File download   ".$_POST["dl_name"]);

			    ?>  <script language="JavaScript">
					  alert('<?php echo $text_genbanner_complete1;?>');
					  location.href='download_list.php?gid=<?php echo $_POST[gid];?>';
		         </script> <?php
				exit;
		}else{
				?>  <script language="JavaScript">
					  alert('ประเภทไฟล์ไม่ถูกต้อง');
					  location.href='download_list.php?gid=<?php echo $_POST[gid];?>';
		         </script> <?php
				exit;
		}
}else if($_POST["flag"] =='edit'){
		$d=explode('/',$_POST[dl_date]);
		$createdate=($d[2]-543).$d[1].$d[0];

		$sql_update="UPDATE download_list SET  dl_name='$dl_name', dl_detail='$dl_detail', dl_update='".date('Ymdhis')."', dl_gid='$_POST[dl_group]' 
		WHERE dl_id='$_POST[dl_id]' ";
		$db->query($sql_update);
		$db->write_log("create","download","เพิ่ม File download   ".$_POST["dl_name"]);

		$sql_update = "select * from download_list where dl_id = '$_POST[dl_id]' ";
		$query=$db->query($sql_update);
		$data=$db->db_fetch_array($query);

		$old_file_name=$Current_Dir."/".$data[dl_sysfile];

		if($_FILES[dl_file][size]>0){
				@mkdir ($Current_Dir, 0777);
				$file_type_server = explode(".",$_FILES[dl_file][name]);
				$C = count($file_type_server);
				$CT = $C-1;
				$dir = strtolower($file_type_server[$CT]);
				for($x=0;$x<count($file_type);$x++){
						if($dir == $file_type[$x] ){
							$fail_type = 1;
						}
				}
		}

		if($fail_type==1 and $_FILES[dl_file][size]>0){
				@unlink($old_file_name);
			    $real_filename=$_FILES[dl_file][name];
			    $real_filetype=$_FILES[dl_file][type];
			    $real_filesize=$_FILES[dl_file][size];

				$F = explode(",",$_FILES["dl_file"]["name"]);
				$C = count($F);
				$CT = $C-1;
				//$dir = strtolower($F[$CT]);
				$dir="tmp";
				$nfile = "file_".rand(0,9).rand(0,9).'_'.date("YmdHis");
				$filename = $nfile.".".$dir;
				copy($_FILES["dl_file"]["tmp_name"],$Current_Dir."/".$filename);
				@chmod ($Current_Dir."/".$filename, 0777);

				$sql_update="UPDATE download_list SET  dl_userfile='$real_filename', dl_sysfile='$filename', dl_filetype='$real_filetype', dl_filesize='$real_filesize' WHERE dl_id='$_POST[dl_id]'";
				$db->query($sql_update);
		}

		?>  <script language="JavaScript">
					  alert('<?php echo $text_genbanner_complete2;?>');
					  location.href='download_list.php?gid=<?php echo $_POST[gid];?>';
		</script> <?php
		exit;
}


if($_POST[flag] == 'del'){
		for($i=0;$i<$_POST[all];$i++){
			$del="del$i";
			if($$del){
				$sql= "SELECT * FROM download_list  WHERE dl_id= '".$$del."'  " ;
				$query=$db->query($sql);
				$data=$db->db_fetch_array($query);

				$old_file_name=$Current_Dir."/".$data[dl_sysfile];
				@unlink($old_file_name);
               $db->query("DELETE FROM download_list WHERE dl_id = '".$$del."' ");
			}
		}

		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='download_list.php?gid=<?php echo $_POST[gid];?>';
     </script>
   <?php
	exit;
}

$db->db_close(); 

?>
