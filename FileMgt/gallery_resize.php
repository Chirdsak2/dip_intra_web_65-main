<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_thumbnail.php");
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";

$folder = base64_decode($_REQUEST["myfolder"]);
$file_name = base64_decode($_GET["fname"]);
$ftype = images;

$Current_Dir = $Globals_Dir.'/'.$file_name;
//echo $Current_Dir;
if (!(file_exists($Current_Dir))) {

$Current_Dir = $Globals_Dir;
}


$file = explode('/',$file_name);
$num_path = count($file);
$size = @getimagesize($Current_Dir);
$file_name1 = $file[$num_path-1];
$file1= explode('.',$file_name1);
$height = $size[1];
$width = $size[0];


	if($flag== "gallery"){
	$folder = base64_decode($_REQUEST["myfolder"]);
	$flie_name = $hdd_file_name;
	$flie_lname = $hdd_file_lname;
	$path_name = $Globals_Dir.'/'.$folder.'/'.$flie_name;
	$target = $Globals_Dir.'/'.$folder.'/'.$txt_file_name.'.'.$hdd_file_lname;
		if($flie_lname == 'jpg' || $flie_lname == 'JPG' || $flie_lname == 'Jpg'){
		  thumb_jpg($path_name,$target, $txt_w, $txt_h);
		}else if($flie_lname == 'gif' || $flie_lname == 'GIF' || $flie_lname == 'Gif'){
			thumb_gif($path_name,$target, $txt_w, $txt_h);
		}else if($flie_lname == 'png' || $flie_lname == 'PNG' || $flie_lname == 'Png'){
			thumb_png($path_name,$target, $txt_w, $txt_h);
		}
	$db->write_log("update","Images","resize images :  ".$flie_name. "ได้ file ใหม่ ชื่อ :".$txt_file_name.'.'.$hdd_file_lname);
		?>
			<script language="javascript">
				self.location.href = "gallery_index.php?myfolder=<?php echo $_REQUEST["myfolder"]; ?>";
			</script>
		<?php
		exit;
	}
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript" type="text/javascript" src="../js/function.js"></script>
<script language="JavaScript">
function changePic(c){
if(c.value != ""){
self.parent.gallery_left.gallery_preview.document.all.imgpreview.src = c.value;
}
}
function resize_image(t,flag){
if(flag == 'w'){
window.document.getElementById("image_size").width=t;
}
if(flag == 'h'){
window.document.getElementById('image_size').height=t;
}
}
</script>
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <form name="form1" enctype="multipart/form-data" method="post" action="?">
    <tr> 
      <td align="center" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0" id="myTable">
          <tr bgcolor="F3F3EE"> 
            <td width="35%" height="15"  >Image File:</td>
            <td>
              <?php echo $file_name1?>
              <input name="hdd_file_name" type="hidden" value="<?php echo $file_name1?>"></td>
          </tr>
          <tr bgcolor="F3F3EE"> 
            <td height="15"  >Image File name: </td>
            <td><input name="txt_file_name" type="text" id="txt_file_name" value="<?php echo $file1[0]?>_thumb" size="40">
              .
              <?php echo $file1[1]?>
              <input name="hdd_file_lname" type="hidden" value="<?php echo $file1[1]?>"></td>
          </tr>
          <tr bgcolor="F3F3EE"> 
            <td width="35%" height="7">Resize to : </td>
            <td valign="top">กว้าง : 
              <input name="txt_w" type="text" size="10" id="txt_w" value="<?php echo $width ?>" onBlur="prview.document.all.ppreview.width=this.value">
              X ยาว : 
              <input name="txt_h" type="text" size="10" id="txt_h"  value="<?php echo $height?>" onBlur="prview.document.all.ppreview.height=this.value">
              pixels </td>
          </tr>
          <tr bgcolor="F3F3EE"> 
            <td height="4"></td>
            <td height="30" valign="bottom"><input type="submit" name="Submit" value="Save"> 
              <input type="hidden" name="flag" value="gallery"> <input type="hidden" name="myfolder" value="<?php echo $myfolder?>"></td>
          </tr>
          <tr> 
            <td height="1" colspan="2" bgcolor="D8D2BD"></td>
          </tr>
        </table>
        <iframe name="prview" src="gallery_preview.php?ftype=<?php echo $ftype;?>&fname=<?php echo $_GET["fname"]; ?>" frameborder="0" width="100%" height="100%" scrolling="yes"></iframe></td>
    </tr>
  </form>
</table>
</body>
<script language="JavaScript">
self.parent.gallery_left.gallery_preview.location.href='gallery_left_preview.php';
</script>
