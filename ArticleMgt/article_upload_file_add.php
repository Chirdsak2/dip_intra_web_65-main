<?php
include("../EWT_ADMIN/comtop.php");
$cid = (int)(!isset($_GET['cid']) ? '' : $_GET['cid']);
$nid = (int)(!isset($_GET['nid']) ? '' : $_GET['nid']);



if ($_POST['flag'] == 'add') {

	if (!file_exists("../ewt/" . $_SESSION['EWT_SUSER'] . "/article_attach")) {
		@mkdir("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_attach", 0700);
	}

	if ($_FILES['file']['size'] > 0) {
		$myname = $_FILES['file']['name'];
		$mysize = $_FILES['file']['size'];
		$mytype = $_FILES['file']['type'];
		//find type File
		$F = explode(".", $_FILES["file"]["name"]);
		$C = count($F);
		$CT = $C - 1;
		$dir = strtolower($F[$CT]);
		$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
		$query_type_file = $db->query($sql_type_file);
		$R_type_file = $db->db_fetch_array($query_type_file);
		$type_file = $R_type_file['site_type_file'];
		$pos = strpos($type_file, $dir);
		if ($pos === FALSE) {
?>
			<script>
				alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด   <?php echo $type_file; ?>   ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
				self.location.href = "article_upload_file.php?nid=<?php echo $_POST['n_id']; ?>&cid=<?php echo $_POST['cid']; ?>";
			</script>
	<?php
		} else {
			@copy($_FILES['file']['tmp_name'], "../ewt/" . $_SESSION['EWT_SUSER'] . "/article_attach/" . $myname);
			@chmod("../ewt/" . $_SESSION['EWT_SUSER'] . "/article_attach/" . $myname, 0777);
		}
		//INSERT INTO
		$db->query("INSERT INTO article_attach (n_id,fileattach_name,fileattach_path) VALUES ('{$_POST['nid']}','{$_POST['filename']}','{$myname}')");
	}
	?>
	<script>
		alert("บันทึกเรียบร้อย");
		self.location.href = "article_upload_file.php?nid=<?php echo $_POST['nid']; ?>&cid=<?php echo $_POST['cid']; ?>";
	</script>
<?php
}

if ($_POST['flag'] == 'edit') {

	if ($_FILES['file']['size'] > 0) {
		$myname = $_FILES['file']['name'];
		$mysize = $_FILES['file']['size'];
		$mytype = $_FILES['file']['type'];
		//find type File
		$F = explode(".", $_FILES['file']['name']);
		$C = count($F);
		$CT = $C - 1;
		$dir = strtolower($F[$CT]);
		/*$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
			$query_type_file = $db->query($sql_type_file);
			$R_type_file = $db->db_fetch_array($query_type_file);
			$type_file = $R_type_file[site_type_file];
			$pos = strpos($type_file,$dir);
			if($pos === FALSE){
				?>
				<script language="javascript1.2">
				alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด   <?php echo $type_file;?>   ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
				self.location.href = "article_upload_file.php?n_id=<?php echo $_POST["n_id"]; ?>&cid=<?php echo $_POST[cid];?>";
				</script>
				<?php
				}else{*/
		if (file_exists("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_attach/" . $_POST['hdd_attach_file'])) {
			unlink("../ewt/" . $_SESSION["EWT_SUSER"] . "/article_attach/" . $_POST['hdd_attach_file']);
		}
		@copy($_FILES['file']['tmp_name'], "../ewt/" . $_SESSION['EWT_SUSER'] . "/article_attach/" . $myname);
		@chmod("../ewt/" . $_SESSION['EWT_SUSER'] . "/article_attach/" . $myname, 0777);
		//}

		$db->query("UPDATE article_attach SET fileattach_path='{$myname}' WHERE fileattact_id = '{$_POST['at_id']}' AND n_id = '{$_POST['nid']}' ");
	}

	$db->query("UPDATE article_attach SET fileattach_name = '{$_POST['filename']}' WHERE fileattact_id = '{$_POST['at_id']}' AND n_id = '{$_POST['nid']}' ");
?>
	<script>
		alert("บันทึกการแก้ไขเรียบร้อย");
		self.location.href = "article_upload_file.php?nid=<?php echo $_POST['nid']; ?>&cid=<?php echo $_POST['cid']; ?>";
	</script>
<?php
}
?>
<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	?>

	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<div class="card">
				<div class="card-header">

					<div class="container" style="width:98%;">
						<h4><?php if ($_GET['flag'] == 'add') {
								echo "เพิ่ม";
							} else {
								echo "แก้ไข";
							} ?>เอกสารแนบ</h42>
							<p></p>

							<!--<ol class="breadcrumb">
<li><a href="index.php">ข่าว/บทความ</a></li>
<li class=""></li>       
</ol>-->

					</div>

					<div class="row m-b-sm">
						<div class="col-md-6 col-sm-6 col-xs-12">
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right hidden-xs">
							<!--<a href="article_upload_file_add.php?flag=add&n_id=<?php echo $n_id; ?>&cid=<?php echo $cid; ?>" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo "เพิ่มเอกสารแนบ"; ?>
</button>
</a>  -->
							<a href="article_upload_file.php?nid=<?php echo $_GET['nid']; ?>&cid=<?php echo $_GET['cid']; ?>" target="_self">
								<button type="button" class="btn btn-info  btn-ml ">
									<i class="fas fa-undo-alt"></i>&nbsp;<?php echo "ย้อนกลับ"; ?>
								</button>
							</a>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
							<div class="btn-group ">
								<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action <span class="caret"></span></button>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="article_upload_file_add.php?flag=add&nid=<?php echo $nid; ?>&cid=<?php echo $cid; ?>"><i class="fas fa-plus-circle"></i>&nbsp;<?php echo " เพิ่มเอกสารแนบ"; ?></a></li>
									<li><a href="article_upload_file.php?nid=<?php echo $nid; ?>&cid=<?php echo $cid; ?>"><i class="fas fa-undo-alt"></i>&nbsp;<?php echo " ย้อนกลับ"; ?></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!--END card-header -->
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php
							$sql_attach = "SELECT * FROM article_attach WHERE fileattact_id = '{$_GET['at_id']}' ";
							$query_attach = $db->query($sql_attach);
							$R = $db->db_fetch_array($query_attach);
							?>

							<form name="form1" method="post" enctype="multipart/form-data" action="article_upload_file_add.php" onSubmit="return chk_form(this);">
								<div class="form-group row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label for="filename"><?php echo "ชื่อเอกสารแนบ"; ?><span class="text-danger">*</span> : </label>
										<input name="filename" type="text" id="filename" class="form-control" value="<?php echo $R['fileattach_name']; ?>" />
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label for="filename">ไฟล์ปัจจุบัน : </label>
										<a href="../ewt/<?php echo $_SESSION['EWT_SUSER']; ?>/article_attach/<?php echo $R['fileattach_path']; ?>" rel="noopener noreferrer" target="_blank">
											<?php echo $R['fileattach_path']; ?>
										</a>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label for="filename"><?php echo "ไฟล์เอกสารแนบ"; ?><span class="text-danger">*</span> : </label>
										<input class="form-control" type="file" name="file" id="file" onchange="JSCheck_file(this.id,this.value);JSCheck_filenameTH(this.id,this.value);">
										<input type="hidden" name="hdd_attach_file" id="hdd_attach_file" value="<?php echo $R['fileattach_path']; ?>" />
										<?php
										$sql_Imsize = "SELECT site_info_max_file,site_type_file FROM site_info";
										$query_Imsize = $db->query($sql_Imsize);
										$rec_Imsize = $db->db_fetch_array($query_Imsize);
										?>
										<span class="text-danger"><code><?php echo $rec_Imsize['site_type_file']; ?></code></span>
										<br>
										<span class="text-danger"><code>
												ขนาดไฟล์ไม่เกิน <?php echo $rec_Imsize['site_info_max_file']; ?> MB.
											</code></span>
									</div>
								</div>

								<div class="clearfix">&nbsp;</div>
								<div class="form-group row ">
									<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
										<button type="submit" class="btn btn-success  btn-ml ">
											<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;<?php echo "บันทึก"; ?>
										</button>
										<input type="hidden" name="flag" value="<?php echo $_GET['flag']; ?>" />
										<input type="hidden" name="nid" value="<?php echo $_GET['nid']; ?>" />
										<input type="hidden" name="at_id" value="<?php echo $_GET['at_id']; ?>" />
										<input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>" />
									</div>
								</div>
							</form>

						</div>
					</div>

				</div>
			</div>
			<!--END card-->
		</div>
	</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script>
	function chk_form(obj) {
		if (obj.filename.value == '') {
			alert("กรุณาใส่ชื่อเอกสารแนบ!!");
			return false;
		}
		<?php if ($_GET['flag'] == 'add') { ?>
			if (obj.file.value == '') {
				alert("กรุณาใส่ไฟล์เอกสารแนบ!!");
				return false;
			}
		<?php } ?>

	}
</script>