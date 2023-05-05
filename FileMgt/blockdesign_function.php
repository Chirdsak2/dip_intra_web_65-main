<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/templates";

if($_POST["Flag"] == "Remove"){
		if($_POST["r_type"] == "Fi"){
					$file_del = base64_decode($_POST["r_name"]);
					$Current_Del = $Globals_Dir."/".$file_del;
					@unlink($Current_Del);
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
				}
				if($_POST["r_type"] == "Fo"){ 
				$db->write_log("delete","Images","ลบ Folder   ".base64_decode($_POST["r_name"]));
				}else{
				$db->write_log("delete","Images","ลบ File   ".base64_decode($_POST["r_name"]));
				}
				?>
			<script language="javascript">
				self.location.href = "<?php echo $_POST["direct"]; ?>";
			</script>
		<?php
			}
			
			
			
if($_POST["Flag"] == "UploadZipFile" AND $_POST["current"] != ""){
     $folder = base64_decode($_POST["current"]);
	 $Current_Dir = $Globals_Dir."/".$folder;
	 $goto = $_POST["current"];

	for($i=0;$i<count($_POST["ziplist"]);$i++){
	    $filename=$_POST["currentzip"]."/".$_POST["ziplist"][$i];
		copy($filename,$Current_Dir."/".$_POST["ziplist"][$i]);
	}
	
		function LooPDel($p){
			$dir=@opendir($p);
			while($data=@readdir($dir)){
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

		LooPDel($_POST["currentzip"]);

	?>
			<script language="javascript">
				self.location.href = "blockdesign_index.php?myfolder=<?php echo $goto; ?>";
			</script>
	<?php
	exit;
}
			
			
if($_POST["Flag"] == "UploadFile001" AND $_POST["current"] != ""){

$sql = "select * from site_info";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$size_max = $rec[site_info_max_img] * 1024;

$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/templates";
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
			self.location.href = "blockdesign_index.php";
		</script>
	<?php
	exit;
	}
}

$rowsfile = count($_FILES["file"]["tmp_name"]);
for($i=0;$i<$rowsfile;$i++){
	if($_FILES['file']['size'][$i] > 0){
		if($_FILES['file']['size'][$i] > $size_max){
		?>
		<script language="JavaScript">
			alert("Can not upload \"<?php echo $_FILES["file"]["name"][$i]; ?>\"!! File size over <?php echo $rec[site_info_max_img]; ?> KB.");
		</script>
		<?php
		}else{
			if (file_exists($Current_Dir."/".$_FILES["file"]["name"][$i]) AND $_POST["Replace"] != "Y") {
			?>
		<script language="JavaScript">
			alert("Can not upload \"<?php echo $_FILES["file"]["name"][$i]; ?>\"!! File exists.");
		</script>
	<?php
			}else{
		copy($_FILES["file"]["tmp_name"][$i],$Current_Dir."/".$_FILES["file"]["name"][$i]);
		@chmod ($Current_Dir."/".$_FILES["file"]["name"][$i], 0755);
		$db->write_log("create","Images","สร้าง File   ".$_FILES["file"]["name"][$i]);
			}
		}	
	}
}
				?>
			<script language="javascript">
				self.location.href = "blockdesign_index.php?myfolder=<?php echo $goto; ?>";
			</script>
		<?php
			}	

$db->db_close();  ?>
