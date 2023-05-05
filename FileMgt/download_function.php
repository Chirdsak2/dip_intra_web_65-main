<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download";

			if($_POST["Flag"] == "Remove"){

				if($_POST["r_type"] == "Fi"){
					$file_del = base64_decode($_POST["r_name"]);
					$Current_Del = $Globals_Dir."/".$file_del;
					@unlink($Current_Del);
					$db->write_log("delete","uploadfile","ลบ file   ".$file_del);
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
					$db->write_log("delete","uploadfile","ลบ folder   ".$file_del);
				}
				?>
			<script>
					<?php if($_POST["r_type"] == "Fo"){ ?>
			//	self.parent.download_left.topFrame.location.reload();
					<?php } ?>
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
		<?php
			}
			if($_POST["Flag"] == "CreateFolder"){

					$file_create = base64_decode($_POST["Folder_now"]);
					$Current_C = $Globals_Dir."/".$file_create."/".$_POST["gname"];
					if(!@mkdir ($Current_C, 0755)){
						?>
									<script language="javascript">
alert("Can not create folder \"<?php  echo $_POST["gname"]; ?>\"");
			</script>
						<?php
					}
					$db->write_log("create","uploadfile","สร้าง Folder   ".$_POST["gname"]);
				?>
			<script language="javascript">
	//			self.parent.download_left.topFrame.location.reload();
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
<?php
}	
			
if($_POST["Flag"] == "UploadFile001" AND $_POST["current"] != ""){

$sql = "select * from site_info";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$size_max = $rec['site_info_max_file'] * 1024 * 1024; 
$size_max_img = $rec['site_info_max_img'] * 1024 * 1024;
$file_allowed = explode(',',$rec['site_type_file']);
$img_allowed = explode(',',$rec['site_type_img_file']);



$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download";
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
			self.location.href = "download_index.php";
		</script>
	<?php
	exit;
	}
}

$rowsfile = count($_FILES["file"]["tmp_name"]);
$n = 0;
$nfile = "";
$nf0 = $folder;
if($nf0 != ""){
$nf0 .= "/";
}
for($i=0;$i<$rowsfile;$i++){
	if($_FILES['file']['size'][$i] > 0){	// check file added
		$fileExt=explode('.',$_FILES['file']['name'][$i]);
		if(in_array($fileExt[1], $file_allowed)) {	// check file type == file
			if($_FILES['file']['size'][$i] > $size_max){	// check file size
			?>
			<script language="JavaScript">
				alert("Can not upload \"<?php echo $_FILES["file"]["name"][$i]; ?>\"!! File size over <?php echo $rec[site_info_max_file]; ?> KB.");
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
					@chmod ($Current_Dir."/".$_FILES["file"]["name"][$i], 0755);
							$nfile = $nf0.$_FILES["file"]["name"][$i];
							$n++;
					$db->write_log("create","uplodefile","สร้าง File   ".$_FILES["file"]["name"][$i]);
				}
			}	// end file size
		} else if(in_array($fileExt[1], $img_allowed)) {	// else img type
			if($_FILES['file']['size'][$i] > $size_max_img){	// check img size
			?>
			<script language="JavaScript">
				alert("Can not upload \"<?php echo $_FILES["file"]["name"][$i]; ?>\"!! Image size over <?php echo $rec[site_info_max_img]; ?> KB.");
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
					@chmod ($Current_Dir."/".$_FILES["file"]["name"][$i], 0755);
							$nfile = $nf0.$_FILES["file"]["name"][$i];
							$n++;
					$db->write_log("create","uplodefile","สร้าง Image   ".$_FILES["file"]["name"][$i]);
				}
			}	// end file size
		}	else {
			?>
			<script language="JavaScript">
				alert("File type not allowed!");
				self.location.href="download_index.php?myfolder=<?php echo $goto; ?>";
			</script>
<?php
			exit;
		}// end file type
	}
}
				?>
			<script language="javascript">
			if(self.top.module_obj){

				<?php if($n == "1"){ ?>
				function sendfile(c){
					self.top.module_obj.document.formTodo.objfile.value = "download/" + c;
					self.top.module_obj.document.formTodo.target = "_top";
					self.top.module_obj.document.formTodo.action = "module_confirm.php";
					self.top.module_obj.document.formTodo.submit();
				}
				var c = "<?php echo $nfile; ?>";
				if(self.top.module_obj.document.formTodo.Flag.value == "LinkReturn"){

					if(confirm("Are you sure to use this file?")){
									if(navigator.appName.indexOf('Microsoft')!=-1){
									 window.returnValue = "download/" + c;
									}else{
									window.opener.setAssetValue("download/" + c);
									}
								 self.close();
					}else{
					self.location.href = "download_index.php?myfolder=<?php echo $goto; ?>";
					}
				}else if(self.top.module_obj.document.formTodo.Flag.value == "Link"){
					if(confirm("Are you sure to use this file?")){
					sendfile(c);
					}else{
					self.location.href = "download_index.php?myfolder=<?php echo $goto; ?>";
					}
				}else{
				self.location.href = "download_index.php?myfolder=<?php echo $goto; ?>";
				}
				<?php }else{  ?>
				self.location.href = "download_index.php?myfolder=<?php echo $goto; ?>";
				<?php } ?>
				}else{
				self.location.href = "download_index.php?myfolder=<?php echo $goto; ?>";
				}
			</script>
		<?php
			}	
			$db->db_close();
 ?>
