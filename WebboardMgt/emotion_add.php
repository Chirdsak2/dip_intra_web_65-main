<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
function random_code($len){
srand((double)microtime()*10000000);
$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
$ret_str = "";
$num = strlen($chars);
for($i=0;$i<$len;$i++){
$ret_str .= $chars[rand()%$num];
}
return $ret_str;
}
include("../ewt_thumbnail.php");
$file=$_FILES['file']['tmp_name'];
$file_name=$_FILES['file']['name'];
$file_size=$_FILES['file']['size'];
if($_POST["flag"]=='add'){
if($file_size>0){
	$size = @getimagesize($file);
	$hi = $size[1];
	$wi = $size[0];
	$ftype = explode(".",$file_name);
	$picname = random_code(20);
	$picname = "wb".$picname.".".$ftype[1];
	$img_path = "pic/".$picname;
	/*	if($hi > 30 || $wi > 30){
	
						if($ftype[1] == "jpg"){
							thumb_jpg($file,'../ewt/'.$EWT_FOLDER_USER.'/pic/'.$picname, "30", "30");
							thumb_jpg($file,'pic/'.$picname, "30", "30");
						} // if jpg
						if($ftype[1] == "gif"){
							thumb_gif($file,'../ewt/'.$EWT_FOLDER_USER.'/pic/'.$picname, "30", "30");
							thumb_gif($file,'pic/'.$picname, "30", "30");
						} // if gif
						if($ftype[1] == "png"){
							thumb_png($file,'../ewt/'.$EWT_FOLDER_USER.'/pic/'.$picname, "30", "30");
							thumb_png($file,'pic/'.$picname, "30", "30");
						} // if png
	}else{*/
	@copy($file,'pic/'.$picname);
	@copy($file,'../ewt/'.$EWT_FOLDER_USER.'/pic/'.$picname);
	//}
}
$Execsql = $db->query("INSERT INTO emotion (emotion_name,emotion_character,emotion_img) values ('".$_POST["name"]."','".$_POST["type_keyb"]."','".$img_path."')");
?>
<script language="JavaScript">
alert("บันทึกเรียบร้อย");
window.location.href = "emotion_list.php";
//window.opener.location.reload();
//window.close();
</script>
<?php
}else if($_POST["flag"]=='edit'){
	if($file_size>0){
		@unlink($_POST["hdd_file"]);
		@unlink('../ewt/'.$EWT_FOLDER_USER.'/'.$_POST["hdd_file"]);
		$size = @getimagesize($file);
		$hi = $size[1];
		$wi = $size[0];
		$ftype = explode(".",$file_name);
		$picname = random_code(20);
		$picname = "wb".$picname.".".$ftype[1];
		$img_path = "pic/".$picname;
		/*	if($hi > 30 || $wi > 30){
	
						if($ftype[1] == "jpg"){
							thumb_jpg($file,'../ewt/'.$EWT_FOLDER_USER.'/'.$img_path, "30", "30");
							thumb_jpg($file,$img_path, "30", "30");
						} // if jpg
						if($ftype[1] == "gif"){
							thumb_gif($file,'../ewt/'.$EWT_FOLDER_USER.'/'.$img_path, "30", "30");
							thumb_gif($file,$img_path, "30", "30");
						} // if gif
						if($ftype[1] == "png"){
							thumb_png($file,'../ewt/'.$EWT_FOLDER_USER.'/'.$img_path, "30", "30");
							thumb_png($file,$img_path, "30", "30");
						} // if png
	}else{*/
		@copy($file,$img_path);
		@copy($file,'../ewt/'.$EWT_FOLDER_USER.'/'.$img_path);
	//}
	}else{
		$img_path = $_POST["hdd_file"];
	}
	$sql_update =$db->query("update emotion set emotion_name = '".$_POST["name"]."',emotion_character='".$_POST["type_keyb"]."',emotion_img='".$img_path."' where emotion_id = '".$_POST["id"]."'  ");

?>
<script language="JavaScript">
alert("แก้ไขเรียบร้อย");
window.location.href = "emotion_list.php";
//window.opener.location.reload();
//window.close();
</script>
<?php
}else if($_GET["flag"]=='del' && !empty($_GET["id"])){
$sql = "select *  from emotion where emotion_id = '".$_GET["id"]."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$path_name = $rec[emotion_img];
@unlink($path_name);
@unlink('../ewt/'.$EWT_FOLDER_USER.'/'.$path_name);
$sql_delete = $db->query("delete FROM emotion where emotion_id = '".$_GET["id"]."'");
?>
<script language="JavaScript">
alert("ลบเรียบร้อย");
window.location.href = "emotion_list.php";
</script>
<?php
exit;
}
if(!empty($_GET["id"])){
$sql = "select *  from emotion where emotion_id = '".$_GET["id"]."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$path_name = $rec[emotion_img];
$name = $rec[emotion_name];
$type_keyb = $rec[emotion_character];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
.style3 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form action="?" method="post" enctype="multipart/form-data" name="form1" onSubmit="return CHK(this);">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">รูปภาพแสดงอารมณ์</span> </td>
  </tr>
</table>
<?php 
if($_GET["flag"]=='add'){
$title = "เพิ่ม";
}else{
$title = "แก้ไข";
}
?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($title."รูปภาพแสดงอารมณ์ ");?>&module=webboard&url=<?php echo urlencode("emotion_add.php?flag=".$_GET["flag"]."&id=".$_GET["id"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="emotion_list.php">&nbsp;&nbsp;&nbsp;<img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> กลับ</a>&nbsp;
      <hr>
    </td>
  </tr>
</table>

  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
   <tr>
      <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">รูปภาพแสดงอารมณ์</td>
    </tr>
    <tr>
      <td width="27%" bgcolor="#FFFFFF" class="MemberHead">รูปภาพแสดงอารมณ์ :<span style="color:#FF0000">* </span></td>
      <td width="73%" bgcolor="#FFFFFF"><input type="file" name="file"> 
        <br>
        <span class="style3">*กรุณาใช้รูปภาพที่มีขนาดเท่ากัน</span>
      <input type="hidden" name="hdd_file" value="<?php echo $path_name;?>"> <input type="hidden" name="id" value="<?php echo $_GET["id"];?>"></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" class="MemberHead">Code :<span style="color:#FF0000">*</span></td>
      <td bgcolor="#FFFFFF"><input type="text" name="type_keyb"  value="<?php echo $type_keyb;?>"></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" class="MemberHead">คำอธิบาย : </td>
      <td bgcolor="#FFFFFF"><input type="text" name="name" value="<?php echo $name;?>"></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="บันทึก">
      <input type="hidden" name="flag" value="<?php echo $_GET["flag"];?>"></td>
    </tr>
  </table>
</form>
</body>
</html>
<script language="javascript1.2">
function CHK(t){
	if(t.file.value == '' && t.hdd_file.value == ''){
	alert("กรุณาใส่ file รูปภาพ emotion");
	return false;
	}
	if(t.type_keyb.value == ''){
	alert("กรุณาใส่ Type Keyboard");
	return false;
	}
	//if(t.name.value==''){
	//alert("กรุณาใส่ชื่อ emotion");
	//return false;
	//}
}
</script>
<?php @$db->db_close(); ?>