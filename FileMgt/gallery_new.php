<?php
$IMG_PATH = "../EWT_ADMIN/";
include("../EWT_ADMIN/comtop_pop.php");

$Globals_Dir1 = "../ewt/".$_SESSION["EWT_SUSER"]."/";
if($_POST["Flag"] == "UploadFile007"){
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";

if($_POST["direct"] == "BizPotential"){

}else{
$folder = base64_decode($_POST["direct"]);

$Current_Dir = $Globals_Dir."/".$folder;

if (!(file_exists($Current_Dir))) {
?>
<script language="JavaScript">
alert("Not found folder \"<?php echo $folder; ?>\"");
self.location.href = "gallery_index.php";
</script>
<?php
exit;
}
}
 
$sql_Imsize1 = "SELECT site_info_max_img,site_type_img_file FROM site_info";
$query_Imsize1 = $db->query($sql_Imsize1);
$rec_Imsize1 = $db->db_fetch_array($query_Imsize1);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet"> 

<link rel="shortcut icon" type="image/icon" href="../EWT_ADMIN/images/logo_biz.png"/>

<!-- bootstrap 3.3.7 -->
<link href="../EWT_ADMIN/css/bootstrap.css" rel="stylesheet"/>
<!-- END -->

<!-- Main Style -->
<link href="../EWT_ADMIN/style.css" rel="stylesheet"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/backend_style.css"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/icons.css"/>
<!-- END -->
<link rel="stylesheet" type="text/css" href="../js/jquery-confirm-master/css/jquery-confirm.css"/>


<script language="javascript" type="text/javascript" src="../js/function.js"></script>
<script language="JavaScript">
function changePic(c){
if(c.value != ""){
self.parent.gallery_left.gallery_preview.document.all.imgpreview.src = c.value;
}
}
	
</script>

</head>
<body leftmargin="0" topmargin="0">
<!--<object name="ftp" id="ftp" classid="CLSID:63337170-F789-11CE-86F8-0020AFD8C6DB">
	<param name="RemoteHost" value="<?php echo $rec[site_info_host]; ?>">
	<param name="User" value="<?php echo $rec[site_info_user]; ?>">
	<param name="Password" value="<?php echo $rec[site_info_pass]; ?>">
</object>-->
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<form name="form1" enctype="multipart/form-data" method="post" action="gallery_function.php">
<tr>
<td height="30" bgcolor="#F3F3EE">&nbsp;&nbsp;&nbsp;<a href="<?php if($_SERVER["HTTP_REFERER"] != ""){ echo $_SERVER["HTTP_REFERER"]; }else{ echo "gallery_index.php"; } ?>" >
<img src="../images/content_back.gif" width="24" height="24" border="0" align="absmiddle"> 
Back</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--<a href="#add" onClick="AddRoom('myTable');">
<img src="../images/document_add.gif" width="24" height="24" border="0" align="absmiddle"> 
Upload more file...</a>-->
		<!--<font color="#FF0000">(</font></a>
		<font color="#FF0000">File 
        Size must not exceed <?//=$rec[site_info_max_img];?> MB.)</font>-->
<br>
<span color="#FF0000" class="text-danger">
<code>
<?php echo $rec_Imsize1['site_type_img_file'];?>
</code>
</span>
<br>
<span color="#FF0000" class="text-danger"><code>
ขนาดไฟล์ไม่เกิน <?php echo $rec_Imsize1['site_info_max_img']; ?> MB.
</code></span>
</td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#F3F3EE" style="font-size:12px;" >
	<img src="../images/folder_upload.gif" width="24" height="24" border="0" align="absmiddle"> 
      Upload New File to  
	<input name="textfield" value="My Gallery/<?php echo $folder; ?>" type="text" size="40" readonly="true">
    <input name="current" type="hidden" id="current" value="<?php echo $_POST["direct"]; ?>">
    <input name="Flag" type="hidden" id="Flag" value="UploadFile001">
	</td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr> 
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0" id="myTable">
  <tr>
    <td width="35%" height="30" bgcolor="#F7F7F7" style="font-size:12px;" >Upload File:</td>
    <td width="23%" style="font-size:12px;">
	<input name="file[]"  id="file" type="file" onchange="JSCheck_Img(this.id,this.value);" class="form-control" >
    </td>
    <td><img src="../images/error1.gif" width="16" height="16"></td>
  </tr>
  <tr>
    <td width="35%" bgcolor="F7F7F7"></td>
          <td width="23%" valign="top" style="font-size:12px;">
		  <input name="Replace" type="checkbox" id="Replace" value="Y">
              Replace all if exists.<br>
			  	<!-- <input type="checkbox" name="filesize_more" value="checkbox"></font></a><font color="#FF0000">File 
        Size must  exceed <?php//php echo $rec[site_info_max_img];?> KB-->
			<br>
              <input type="submit" name="Submit" value="Upload...">
             </td>      
          <td valign="top"></td>
  </tr>
</table></td>
  </tr></form>
</table>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-confirm-master/js/jquery-confirm.js"></script> 
<script >
self.parent.gallery_left.gallery_preview.location.href='gallery_left_preview.php';



<?php 
$sql_file = "SELECT site_info_max_file,site_type_file FROM site_info";
$query_file = $db->query($sql_file);
$rec_file = $db->db_fetch_array($query_file);
?>
function JSCheck_file(id,fileInput) {
		var fileTypes = '<?php echo $rec_file['site_type_file'];?>';
		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = <?php echo sizeMB2byte($rec_file['site_info_max_file']); ?>;
		var name = $('#'+id).val();
		
		var n = name.split('.').pop().toLowerCase();
		var m = 0;
		//alert(fileTypes);
	    if(parseInt(fileTypes.indexOf(n)) < 0){
		$('#'+id).val("");
			$.alert({
						title: 'รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง ',
						content: 'กรุณาเลือกรูปแบบใหม่',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
				//alert('กรุณาเลือกชนิดไฟล์ '+fileTypes);
				return false;
		}	
	if(size > maxsize){
		//var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 5000 KB.</div>";
		//document.getElementById("warning1").innerHTML = sms1;
		//alert(sms1);
			$('#'+id).val("");
			$.alert({
						title: 'ขนาดไฟล์ใหญ่เกินไป ',
						content: 'กรุณาเลือกไฟล์ใหม่',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
	return false;
		}else{
		  //document.getElementById("warning1").innerHTML = "";
	  }							
}
<?php 
$sql_Imsize = "SELECT site_info_max_img,site_type_img_file FROM site_info";
$query_Imsize = $db->query($sql_Imsize);
$rec_Imsize = $db->db_fetch_array($query_Imsize);
?>
function JSCheck_Img(id,fileInput) {
		var fileTypes = '<?php echo $rec_Imsize['site_type_img_file'];?>';
		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = <?php echo sizeMB2byte($rec_Imsize['site_info_max_img']); ?>;
		var name = $('#'+id).val();
		
		var n = name.split('.').pop().toLowerCase();
		var m = 0;
		
		//alert(fileTypes);
		
	    if(parseInt(fileTypes.indexOf(n)) < 0){
		$('#'+id).val("");
			$.alert({
						title: 'รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง ',
						content: 'กรุณาเลือกรูปแบบใหม่',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
				//alert('กรุณาเลือกชนิดไฟล์ '+fileTypes);
				return false;
		}	
	if(size > maxsize){
		//var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 5000 KB.</div>";
		//document.getElementById("warning1").innerHTML = sms1;
		//alert(sms1);
			$('#'+id).val("");
			$.alert({
						title: 'ขนาดไฟล์ใหญ่เกินไป ',
						content: 'กรุณาเลือกไฟล์ใหม่',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
	return false;
		}else{
		  //document.getElementById("warning1").innerHTML = "";
	  }							
}


function JSCheck_Vdo(id,fileInput) {
		var fileTypes=["jpg","jpeg","gif","png","bmp"];
		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = 5000000;
		var name = $('#'+id).val();
		var n = name.split('.');
		var m = 0;
						
        for(var i = 0; i < n.length; i++) { 	
			var v = n[1];
		}
			for(var x = 0; x < fileTypes.length; x++) {
				var f = fileTypes[x];
				if(v.match(f)) {
					var m = 1;
					document.getElementById("warning").innerHTML = "";
				}
			}
			if(m == '0'){
				var sms = "<div class=\"login col-md-12 col-sm-12 alert alert-warning\"><strong>Warning!</strong> รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง\nกรุณาเลือกรูปแบบใหม่  เช่น :\n"+fileTypes.join(", ")+"</div>";
				document.getElementById("warning").innerHTML = sms;				
				//alert(sms);
				$('#'+id).val("");
				//$('#'+id).focus(); 
				scrollTo(body, 0, 100);	
			}
			
	if(size > maxsize){
		var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 5000 KB.</div>";
		document.getElementById("warning1").innerHTML = sms1;
			$('#'+id).val("");
	
		}else{
		  document.getElementById("warning1").innerHTML = "";
	  }
		
							
}
</script>
<?php }
$db->db_close(); 
?>