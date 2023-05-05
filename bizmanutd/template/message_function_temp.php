<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($Flag == "add"){
		$Current_Dir = "../mail_att_file";
		if (!file_exists($Current_Dir)){  mkdir($Current_Dir,0777);  }
		if($_FILES["file"]['size'] > 0 ){
				function random($len){
						srand((double)microtime()*10000000);
						$chars = "ABCDEFGHJKMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz1234567890";
						$ret_str = "";
						$num = strlen($chars);
							for($i=0;$i<$len;$i++){
								$ret_str .= $chars[rand()%$num];
							}
						return $ret_str;
					}
				$filename=$_FILES["file"]["name"];
				$F = explode(".",$_FILES["file"]["name"]);
				$C = count($F); $CT = $C-1; $dir = strtolower($F[$CT]);
				$nfile =random(40);
				$file_name1 = $nfile.".".$dir;
				$date = date("Y-m-d H:i:s");
				copy($_FILES["file"]["tmp_name"],$Current_Dir."/".$file_name1);
				@chmod ($Current_Dir."/".$file_name1, 0777);
				$db->query("INSERT INTO n_temp (temp_code,filenamegiven,filenametemp,file_type,file_size,file_date) VALUES ('$code','$filename','$file_name1','$file_type','$file_size','$date')");
/*
				$F = explode(".",$_FILES["file"]["name"]);
				$C = count($F);
				$CT = $C-1;
				$dir = strtolower($F[$CT]);
				$nfile =random(40);
				$picname = $nfile.".".$dir;
				copy($_FILES["file"]["tmp_name"],$Current_Dir."/".$picname);
				@chmod ($Current_Dir."/".$picname, 0777);
				$link = "calendar/".$picname;*/
		}
/*
	if($file_size > 0){
		$attachid = random(40);
		$data = explode(".",$file_name);
		$file_name1 = $attachid.".".$data[1];
		copy($file,"temp/".$file_name1);
		$date = date("Y-m-d H:i:s");
		if($filename == ""){
			$filename = $file_name;
		}
		$db->query("INSERT INTO n_temp (temp_code,filenamegiven,filenametemp,file_type,file_size,file_date) VALUES ('$code','$filename','$file_name1','$file_type','$file_size','$date')");
}*/
	?>
		<script language="JavaScript">
				self.parent.top.attach_list.location.reload();
				self.location.href='message_file_temp.php?code=<?php echo $code; ?>';
		</script>
<?php
		exit;
}
if($Flag == "del"){
$recdel=$db->db_fetch_array($db->query("SELECT filenametemp FROM n_temp where id='$temp'"));
//@unlink("temp/".$recdel['filenametemp']);// ลบ file ที่แนบมา
$db->query("DELETE FROM n_temp WHERE id = '$temp'");
	?>
		<script language="JavaScript">
				self.location.href='message_list_temp.php?code=<?php echo $code; ?>';
		</script>
<?php
		exit;
}

 $db->db_close(); ?>
