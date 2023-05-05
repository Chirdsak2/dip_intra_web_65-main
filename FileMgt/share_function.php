<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/share_config.php");
$db->query("USE ".$EWT_DB_USER);
			if($_POST["Flag"] == "Remove"){

				if($_POST["r_type"] == "Fi"){
					$file_del = base64_decode($_POST["r_name"]);
					$Current_Del = $Globals_Dir."/".$file_del;
					@unlink($Current_Del);
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$db->write_log("delete","file","ลบ file   ".$file_del);
					$db->query("USE ".$EWT_DB_USER);
				}elseif($_POST["r_type"] == "Fo"){

		function LooPDel($p){
			$dir=@opendir($p);
			while($data=@readdir($dir))
			{
				if(($data!=".")and($data!="..")and($data!="")){
					if(!@unlink($p."/".$data))
						{
							LooPDel($p."/".$data);
						}	
				}
			}
		@closedir($dir);
		@rmdir($p);
		}

			


					$file_del = base64_decode($_POST["r_name"]);
					$Current_Del = $Globals_Dir."/".$file_del;
					LooPDel($Current_Del);
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$db->write_log("delete","file","ลบ folder   ".$file_del);
					$db->query("USE ".$EWT_DB_USER);
				}
				?>
			<script language="javascript">
					<?php if($_POST["r_type"] == "Fo"){ ?>
		//		self.parent.share_left.topFrame.location.reload();
					<?php } ?>
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
		<?php
			}
		if($_POST["Flag"] == "Rename"){
					$file_r = base64_decode($_POST["r_name"]);
					$dir = dirname($file_r);
				
					rename($Globals_Dir."/".$file_r, $Globals_Dir."/".$dir."/".$_POST["nname"]);
					if($dir == "" OR $dir == "./" OR $dir == "."){
					
						$folder = $_POST["nname"];
					}else{
						$folder = $dir."/".$_POST["nname"];
				
					}
					$sql_chk = $db->query("UPDATE file_mgr SET file_name = '$folder'  WHERE file_name = '$file_r' ");
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$db->write_log("rename","file","rename ชื่อ file จากเดิม:  ".$file_r."   เป็น ".$_POST["nname"]);
					$db->query("USE ".$EWT_DB_USER);
				?>
			<script language="javascript">
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
		<?php
			}
			if($_POST["Flag"] == "Hidden"){
					$file_r = base64_decode($_POST["r_name"]);
					$sql_chk = $db->query("UPDATE file_mgr SET file_status = 'N'  WHERE file_name = '$file_r' ");
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$db->write_log("hidden","file","ซ่อน file name  ".$file_r);
					$db->query("USE ".$EWT_DB_USER);
				?>
			<script language="javascript">
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
		<?php
			}
			if($_POST["Flag"] == "ShowFile"){
					$file_r = base64_decode($_POST["r_name"]);
					$sql_chk = $db->query("UPDATE file_mgr SET file_status = 'Y'  WHERE file_name = '$file_r' ");
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$db->write_log("showfile","file","ยกเลิกการซ่อน file name  ".$file_r);
					$db->query("USE ".$EWT_DB_USER);
				?>
			<script language="javascript">
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
		<?php
			}
			if($_POST["Flag"] == "Access"){
					$file_r = base64_decode($_POST["r_name"]);
					$sql_chk = $db->query("DELETE FROM file_access  WHERE file_name = '$file_r' ");
					for($i=0;$i<$_POST["alli"];$i++){
						$chk = $_POST["chk".$i];
						if($chk != ""){
							$db->query("INSERT INTO file_access (file_name,user_info) VALUES ('$file_r','$chk') ");
							$db->query("USE ".$_SESSION["EWT_SDB"]."");
							$db->write_log("Access","file","กำหนดสิทธิ์ให้  ".$chk."   เข้าใช้ folder  ".$file_r);
							$db->query("USE ".$EWT_DB_USER);
						}
					}
				?>
			<script language="javascript">
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
		<?php
			}
						if($_POST["Flag"] == "Email"){
						include('../lib/libmail.php');
$m = new Mail();
$m->From($sname."<".$semail.">");
$m->Subject($subject);
$m->To($tname."<".$temail.">");
$m->Body($body,"text/html");

					$file_r = base64_decode($_POST["r_name"]);

$m->Attach($Globals_Dir."/".$file_r,"application/x-www-form-urlencoded");
$m->Send();
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$db->write_log("email","file","ส่ง email  ถึง   ".$temail."    เรื่อง  ".$subject."   มีเอกสารแนบ :   ".$file_r);
					$db->query("USE ".$EWT_DB_USER);
				?>
			<script language="javascript">
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
		<?php
			}
			if($_POST["Flag"] == "CreateFolder"){

					$file_create = base64_decode($_POST["Folder_now"]);
					$Current_C = $Globals_Dir."/".$file_create."/".$_POST["gname"];
					if(!@mkdir ($Current_C, 0777)){
						?>
									<script language="javascript">
alert("Can not create folder \"<?php  echo $_POST["gname"]; ?>\"");
						self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
						<?php
				exit;
					}
					if($file_create == ""){
						$folder = $_POST["gname"];
					}else{
						$folder = $file_create."/".$_POST["gname"];
					}
					$db->query("INSERT INTO file_mgr (file_name,file_owner,file_status) VALUES ('".$folder."','".$_SESSION["EWT_SUSER"]."','Y')");
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$db->write_log("create","file","สร้าง folder   ".$_POST["gname"]);
					$db->query("USE ".$EWT_DB_USER);
				?>
			<script language="javascript">
			//	self.parent.share_left.topFrame.location.reload();
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
		<?php
			}	
						if($_POST["Flag"] == "UploadFile001" AND $_POST["current"] != ""){


$Current_Dir = $Globals_Dir;
if($_POST["current"] == "BizPotential"){
$Current_Dir = $Globals_Dir;
$goto = "";
}else{
$folder = base64_decode($_POST["current"]);
$Current_Dir = $Globals_Dir."/".$folder;
$goto = $_POST["current"];
	if (!(file_exists($Current_Dir))) {
	?>
		<script language="JavaScript">
			alert("Not found folder \"<?php echo $folder; ?>\"");
			self.location.href = "share_index.php";
		</script>
	<?php
	exit;
	}
}

$rowsfile = count($_FILES["file"]["tmp_name"]);
for($i=0;$i<$rowsfile;$i++){
	if($_FILES['file']['size'][$i] > 0){
		if($_FILES['file']['size'][$i] > 999999999999){
			?>
			<script language="JavaScript">
				alert("Can not upload \"<?php echo $_FILES["file"]["name"][$i]; ?>\"!! File size over 999999999999 B.");
			</script>
		<?php
		}else{
			if (file_exists($Current_Dir."/".$_FILES["file"]["name"][$i]) AND $_POST["Replace"] != "Y") {
				?>
			<script language="JavaScript">
				alert("Can not upload \"<?php echo $_FILES["file"]["name"][$i]; ?>\"!!File exists. ");
			</script>
		<?php
			}else{
			copy($_FILES["file"]["tmp_name"][$i],$Current_Dir."/".$_FILES["file"]["name"][$i]);
			@chmod ($Current_Dir."/".$_FILES["file"]["name"][$i], 0777);
				
					if($folder == ""){
					$fname = $_FILES["file"]["name"][$i];
					}else{
					$fname = $folder."/".$_FILES["file"]["name"][$i];
					}	
					$db->query("INSERT INTO file_mgr (file_name,file_owner,file_status) VALUES ('".$fname."','".$_SESSION["EWT_SUSER"]."','Y')");
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$db->write_log("create","file","สร้าง file   ".$_FILES["file"]["name"][$i]);
					$db->query("USE ".$EWT_DB_USER);
			}
		}
	}
}
				?>
			<script language="javascript">
				self.location.href = "share_index.php?myfolder=<?php echo $goto; ?>";
			</script>
		<?php
			}	
 ?>
