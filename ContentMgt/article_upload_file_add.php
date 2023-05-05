<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
if($_POST[flag]=='add'){
		if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach")) {
						@mkdir("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach",0700);
		}
		if($_FILES['file']['size'] > 0 ){
		$myname = $_FILES['file']['name'];
		$mysize = $_FILES['file']['size'];
		$mytype = $_FILES['file']['type'];
			//find type File
			$F = explode(".",$_FILES["file"]["name"]);
			$C = count($F);
			$CT = $C-1;
			$dir = strtolower($F[$CT]);
			$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
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
				}else{
				@copy($_FILES["file"]["tmp_name"],"../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$myname);
				@chmod ("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$myname, 0777);
				}
				//INSERT INTO
				$db->query("INSERT INTO article_attach (n_id,fileattach_name,fileattach_path) VALUES ('".$_POST["n_id"]."','".$_POST[filename]."','".$myname."')");
		}
		?>
						<script language="javascript">
							alert("บันทึกเรียบร้อย");
							self.location.href = "article_upload_file.php?n_id=<?php echo $_POST["n_id"]; ?>&cid=<?php echo $_POST[cid];?>";
						</script>
		<?php
}
if($_POST[flag]=='edit'){

	if($_FILES['file']['size'] > 0 ){
			$myname = $_FILES['file']['name'];
			$mysize = $_FILES['file']['size'];
			$mytype = $_FILES['file']['type'];
			//find type File
			$F = explode(".",$_FILES["file"]["name"]);
			$C = count($F);
			$CT = $C-1;
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
				if (file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$_POST[hdd_attach_file])) {
				unlink("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$_POST[hdd_attach_file]);
				}
				@copy($_FILES["file"]["tmp_name"],"../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$myname);
				@chmod ("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$myname, 0777);
				//}
		}
$db->query("UPDATE article_attach SET fileattach_name = '".$_POST[filename]."' ,fileattach_path='".$myname."' where fileattact_id = '".$_POST[at_id]."' and n_id = '".$_POST["n_id"]."'");
		?>
						<script language="javascript">
							alert("บันทึกการแก้ไขเรียบร้อย");
							self.location.href = "article_upload_file.php?n_id=<?php echo $_POST["n_id"]; ?>&cid=<?php echo $_POST[cid];?>";
						</script>
		<?php
}
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chk_form(obj){
	if(obj.filename.value == ''){
	alert("กรุณาใส่ชื่อเอกสารแนบ!!");
	return false;
	}
	<?php if($_GET[flag]=='add'){ ?>
	if(obj.file.value == ''){
	alert("กรุณาใส่ไฟล์เอกสารแนบ!!");
	return false;
	}
	<?php } ?>
	
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">Article Attach  File</span></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
	<a href="article_upload_file.php?n_id=<?php echo $_GET[n_id];?>&cid=<?php echo $_GET[cid];?>"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0"> กลับ</a>&nbsp;
      <hr>
    </td>
  </tr>
</table>
<?php
$sql="select * from article_attach where fileattact_id ='".$_GET[at_id]."'"; 
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
?>
<form name="form1" method="post" enctype="multipart/form-data" action="article_upload_file_add.php" onSubmit="return chk_form(this);">
  <table width="90%" border="0" align="center" class="table table-bordered">
    <tr bgcolor="#E7E7E7" >
      <td height="30" colspan="2" class="ewttablehead"><?php if($_GET[flag]=='add'){ echo "เพิ่ม";}else{echo "แก้ไข";}?></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="38%">ชื่อเอกสารแนบ</td>
      <td width="62%"><input class="form-control" style="width:50%;" name="filename" type="text" size="40" value="<?php echo $R[fileattach_name];?>"></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>เอกสารแนบ</td>
      <td><input class="form-control" style="width:50%;" type="file" name="file" ><input name="hdd_attach_file" type="hidden" value="<?php echo $R[fileattach_path];?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Submit" class="btn btn-success">
      <input type="hidden" name="flag" value="<?php echo $_GET[flag];?>">
	  <input type="hidden" name="n_id" value="<?php echo $_GET[n_id];?>">
	  <input type="hidden" name="at_id" value="<?php echo $_GET[at_id];?>">
	  <input type="hidden" name="cid" value="<?php echo $_GET[cid];?>"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php $db->db_close(); ?>
