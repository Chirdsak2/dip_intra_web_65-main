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
$size = (filesize($Current_Dir)/1024);
 

//echo $Current_Dir;
if (!(file_exists($Current_Dir))) {
$Current_Dir = $Globals_Dir;
}


$file = explode('/',$file_name);
$num_path = count($file);
$dimen = @getimagesize($Current_Dir);
$file_name1 = $file[$num_path-1];
$file1= explode('.',$file_name1);
$height = $dimen[1];
$width = $dimen[0];
$sur = strtolower($file1[1]);
$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '1' ")); 
$maxSize = $recValue['ebook_value'];

if (($sur!='jpeg' || $sur!='jpg' || $sur!='gif' || $sur!='swf' || $sur!='png') && ($size > $maxSize)) {
	  print "<script> alert ('ไฟล์ที่เลือกไม่สามารถนำไปสร้าง E-Book ได้ \\n * ต้องเป็นไฟล์นามสกุล GIF,PNG,JPG,JPEG,SWF(Flash 8 up) / ขนาดไฟล์ไม่เกิน ".$maxSize." K');self.location.href='gallery_index.php?flag=gallery&myfolder=".$myfolder."';</script>";
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
function CHK(obj){
if(obj.ebookCode.value == ''){
alert("กรุณาเลือกหมวด!!");
return false;
}
}
</script>
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <form name="form1" enctype="multipart/form-data" method="post"  action="../EbookMgt/proc_ebook.php" onSubmit="return CHK(this);">
    <tr> 
      <td align="center" valign="middle"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td><a href="gallery_index.php?flag=gallery&myfolder=<?php echo $myfolder;?>"><img src="../images/article_back.gif" alt="ย้อนกลับ" width="20" height="20" border="0" align="absmiddle"> ย้อนกลับ </a></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="3" cellspacing="1" id="myTable">
          <tr bgcolor="F3F3EE"> 
            <td width="35%" height="8"  >Image File:</td>
            <td>
              <?php echo $file_name1?>
              <input name="hdd_file_name" type="hidden" value="<?php echo $file_name1?>">
[              
              <?php echo $width ?>
X 
<?php echo $height?> 
pixels | ขนาดไฟล์ <?php echo number_format($size,2);?> K] </td>
          </tr>
          <tr bgcolor="F3F3EE">
            <td width="35%" height="7"  >Send to E-Book Name :* </td>
            <td>
			<select name="ebookCode">
			<option value="">Send to E-Book Name </option>
			  <?php
			       $queryEbook = $db->query ("select * from ebook_info order by ebook_code");
			       while ($recEbook=$db->db_fetch_array ($queryEbook)) {
				        print "<option value='".$recEbook['ebook_code']."'> [".$recEbook['ebook_code']."] ".$recEbook['ebook_name']."</option>";
				   }
			  ?>
            </select>
            </td>
          </tr>
          <tr bgcolor="F3F3EE"> 
            <td height="4"></td>
            <td height="30" valign="bottom">
			   <input type="submit" name="Submit" value=" Confirm send to E-book">
		      <input type="hidden" name="flag" value="gallery">
			   <input type="hidden" name="myfolder" value="<?php echo $myfolder?>">
			   <input type="hidden" name="fname" value="<?php echo $file_name1;?>">
			    <input type="hidden" name="src" value="<?php echo $Current_Dir;?>">
			   <input type="hidden" name="proc" value="sendPage"></td>
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
