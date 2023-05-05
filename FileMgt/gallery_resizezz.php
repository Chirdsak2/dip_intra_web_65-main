<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";

$folder = base64_decode($_REQUEST["myfolder"]);

$Current_Dir = $Globals_Dir."/".$folder;
//echo $Current_Dir;
if (!(file_exists($Current_Dir))) {

$Current_Dir = $Globals_Dir;
}

$f_array = explode("/",$folder);
$ar = count($f_array);
$CurrentFolder = trim($f_array[($ar -1)]);
$TopFolder = trim($f_array[($ar -2)]);

$PathTopFolder = "";

for($i=0;$i<($ar -1);$i++){
$PathTopFolder .= "/".$f_array[$i];
}
$PathTopFolder = substr($PathTopFolder, 1);
$PathTopFolderEn = base64_encode($PathTopFolder);

if($CurrentFolder != ""){
$text_f = "<img src=\"../images/folder_closed.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"> ".$CurrentFolder;
}else{
$text_f = "<img src=\"../images/folder_img.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> My Gallery";
}

$numfolder = 0;
$numfile = 0;
$size = 0;

function ShowSize($data){
if($data > 1024000){ echo number_format($data/1024000,2)." MB."; }
elseif($data > 1024){ echo number_format($data/1024,2)." KB."; }
elseif($data > 1){ echo number_format($data)." bytes."; }
elseif($data >= 0){ echo number_format($data)." byte."; }
}

function imageShow($data){
$data = strtolower($data);
if($data=="jpg" OR $data=="jpeg"){  return "../images/document_pic.gif";  }
elseif(($data=="gif")or($data=="png")or($data=="bmp")){  return "../images/document_plain.gif";  }
elseif($data=="swf"){  return "../images/document_flash.gif";  }
else{  return "../images/document_blank.gif";  }
}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
			function hlah(c,cc,e,f){
				var d = document.form1.num.value;
				document.Removeform.r_id.value = cc;
				document.Removeform.r_name.value = e;
				document.Removeform.r_type.value = f;
				document.all.r_img.src = "../images/content_delete.gif"
				if(f == "Fi"){
				document.all.re_img.src = "../images/photo_resize.gif";
				}else{
				document.all.re_img.src = "../images/photo_resize_off.gif";
				}
					document.getElementById('ah'+d).removeAttribute("style");
					document.getElementById('ah'+c).style.backgroundColor = "#D5D6DB";
					document.form1.num.value = c;
					self.parent.gallery_left.gallery_preview.location.href='gallery_left_preview.php?fname=' + e;
					
			}
						function del_file(){
				if(document.Removeform.r_name.value == "" || document.Removeform.r_type.value == ""){
					alert("Please selected file or folder to delete!!!");
					return false;
				}else{
					if(document.Removeform.r_type.value =="Fo"){
					 c  = "Are you sure you want to remove the folder \"" + document.Removeform.r_id.value + "\" and move all its conents?";
					 }else if(document.Removeform.r_type.value =="Fi"){
					c  = "Are you sure you want to delete \"" + document.Removeform.r_id.value + "\" ?";
					}
					var r = confirm(c);
					if(r == true){
						Removeform.submit();
					}else{
						return false;
					}
				}
			
			}
				function resize_file(){
				if(document.Removeform.r_name.value == "" || document.Removeform.r_type.value == ""){
					alert("Please selected file to resize!!!");
					return false;
				}else{
					if(document.Removeform.r_type.value =="Fo"){
							alert("Please selected file to resize!!!");
							return false;
					 }else if(document.Removeform.r_type.value =="Fi"){
					c  = "Are you sure you want to delete \"" + document.Removeform.r_id.value + "\" ?";
					}
				}
			
			}
			function create_folder(){
				document.all.new_fo.style.display = '';
				document.all.tbemp.style.display = 'none';
				document.form1.new_folder.focus();
			}
			function create_fo(c){
				if(c.value == ""){
					document.all.new_fo.style.display = 'none';
					document.all.tbemp.style.display = '';
				}else if (c.value.search("^[A-Za-z0-9_]+$")){
					alert("Folder name is limited to English character  (upper and lower case), number, and underscore only!");
					c.select();
				}else{
					var gname = c.value;
					document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"gallery_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateFolder\"><input name=\"direct\" type=\"hidden\" id=\"direct\" value=\"gallery_index.php?myfolder=<?php echo $_REQUEST["myfolder"]; ?>\"><input name=\"Folder_now\" type=\"hidden\" id=\"Folder_now\" value=\"<?php echo $_REQUEST["myfolder"]; ?>\"><input name=\"gname\" type=\"hidden\" id=\"gname\" value=\""+ gname + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
					createform.submit();

				}
			}
						 function chkKeyFo(c){
			 		if(event.keyCode == 13){
						create_fo(c);
					}
			 }
			 	function newPage(){
				win2 = window.open('gallery_new.php','GalleryNew','top=110,left=420,width=250,height=470,resizable=1,status=0');
				win2.focus();
	}
				function upload_file(){
						<?php 
							if($_REQUEST["myfolder"] != ""){
								$send_folder = $_REQUEST["myfolder"];
							}else{
								$send_folder = "BizPotential";
							}
						?>
					document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"gallery_new.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"UploadFile007\"><input name=\"direct\" type=\"hidden\" id=\"direct\" value=\"<?php echo $send_folder; ?>\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
					createform.submit();
			}
			function Editfile(c,d){
			
				if(self.top.module_obj.document.formTodo.Flag.value == "Choose" || self.top.module_obj.document.formTodo.Flag.value == "SetBg" || self.top.module_obj.document.formTodo.Flag.value == "EditChoose"  || self.top.module_obj.document.formTodo.Flag.value == "Link"  || self.top.module_obj.document.formTodo.Flag.value == "SetPic" ){
					if(self.top.module_obj.document.formTodo.stype.value =="images" ){
						if(d == "gif" || d == "jpeg" || d == "jpg" || d == "bmp" || d == "png"){
								sendfile(c);
						}else{
							alert("File type is not correct!!!");
							return false;
						}
					}
						if(self.top.module_obj.document.formTodo.stype.value =="flash" ){
							if(d == "swf"){
								sendfile(c);
							}else{
							alert("File type is not correct!!!");
							return false;
							}
						}
						if(self.top.module_obj.document.formTodo.stype.value =="link" ){
							sendfile(c);
						}
					
				}else{
					return false;
				}
			}
			function sendfile(c){
					self.top.module_obj.document.formTodo.objfile.value = "images/" + c;
					self.top.module_obj.document.formTodo.target = "_top";
					self.top.module_obj.document.formTodo.action = "module_confirm.php";
					self.top.module_obj.document.formTodo.submit();
			}
</script>
</head>
<body leftmargin="0" topmargin="0">
<span id="formtext"></span>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="A3C7E2">
<tr>
    <td height="40" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;
      <?php if($CurrentFolder != ""){ ?>
      <a href="gallery_index.php?myfolder=<?php echo $PathTopFolderEn; ?>" title="<?php echo $TopFolder; ?>"><img src="../images/content_folder_up.gif" width="24" height="24" border="0" align="absmiddle"> 
      Up</a>
      <?php }else{ ?>
      <img src="../images/content_folder_up_off.gif" width="24" height="24" border="0" align="absmiddle"> 
      <font color="#999999">Up</font>
      <?php } ?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="gallery_index.php"><img src="../images/content_home.gif" width="24" height="24" border="0" align="absmiddle"> 
      Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="gallery_search.php"><img src="../images/folder_search.gif" width="24" height="24" border="0" align="absmiddle"> 
      Search</a></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
    <tr>
    <td height="40" bgcolor="F3F3EE">&nbsp;&nbsp;<a href="#new" onClick="create_folder();"><img src="../images/content_new_folder.gif" width="24" height="24" border="0" align="absmiddle"> 
      New Folder</a> &nbsp;&nbsp;&nbsp;<a href="#new" onClick="upload_file();"><img src="../images/folder_upload.gif" width="24" height="24" border="0" align="absmiddle"> 
      Upload New File</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="#del" onClick="del_file();"><img src="../images/content_delete_off.gif" name="r_img" width="24" height="24" border="0" align="absmiddle" id="r_img"> 
      Delete</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#del" onClick="resize_file();"><img src="../images/photo_resize_off.gif" name="re_img" width="24" height="24" border="0" align="absmiddle" id="re_img"> 
      Resize Image</a></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr><form name="Removeform" method="post" action="gallery_function.php"><input name="direct" type="hidden" id="direct" value="gallery_index.php?myfolder=<?php echo $_REQUEST["myfolder"]; ?>"> 
              <input name="r_id" type="hidden" id="r_id">
              	<input name="r_name" type="hidden" id="r_name">
              	<input name="r_type" type="hidden" id="r_type">
              	<input name="Flag" type="hidden" value="Remove">
  <tr> 
    <td height="20" bgcolor="F3F3EE"><table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td width="10%" nowrap>Address :
              </td>
          <td width="90%"><table width="90%" border="0" cellpadding="2" cellspacing="1" bgcolor="66667E">
              <tr>
                <td height="20" bgcolor="#FFFFFF">
                  <?php echo $text_f; ?></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr></form>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
	 <form name="form1" method="post" action="">
        <?php
		$array_folder = array();
		$array_file = array();
		
		$objFolder = opendir($Current_Dir);
			rewinddir($objFolder);
			$f = 0;
			  while($file = readdir($objFolder)){
			  if(!(($file == ".") or ($file == "..") or ($file == "Thumbs.db") )){
			  $FT= filetype($Current_Dir."/".$file);
			  if($FT == "dir"){
			  array_push ($array_folder,$file);
			  }else{
			  $file_size = filesize($Current_Dir."/".$file);
			  $array_file[$f][0] = $file;
			  $array_file[$f][1] = $file_size;		
				//	ShowSize($file_size);
					$size += $file_size;
			$f++;
			  }
			  }
			  }
			  closedir($objFolder);
			  
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td align="center" valign="top"><DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: scroll;WIDTH: 100%"><br>
          <table width="98%" border="0" align="center" cellpadding="1" cellspacing="1" >
  <?php
  $i=0;
				  $numfolder = count($array_folder);
				for($y=0;$y<$numfolder;$y++){
		if($i%4 == 0){
			echo "<tr bgcolor=\"#FFFFFF\"  align=center height=\"55\">";
		}
		if($folder != ""){
			$preview_path = $folder."/".$array_folder[$y];
			}else{
			$preview_path = $array_folder[$y];
			}
			$preview_path_en = base64_encode($preview_path);
  ?>
         
         <td width="25%" valign="top" align="center" id="ah<?php echo $i; ?>" onClick="hlah('<?php echo $i; ?>','<?php echo $array_folder[$y]; ?>','<?php echo $preview_path_en; ?>','Fo')" onDblClick="self.location.href='gallery_index.php?myfolder=<?php echo $preview_path_en; ?>';" <?php if($_GET["select"] == "Fo".$R["Main_Group_ID"]){ echo "style=\"background-Color:#EEEEEE\""; } $select_num = $i; ?>><img src="../images/content_folder.gif" width="24" height="24" border="0" align="absmiddle"><div ><?php echo $array_folder[$y]; ?></div> 
            </a> </td>
  <?php
  		if($i%4 == 3){
			echo "</tr>";
		}
   $i++; } ?>
    <?php
  $numfile = count($array_file);
				for($y=0;$y<$numfile;$y++){
			if($i%4 == 0){
				echo "<tr bgcolor=\"#FFFFFF\"  align=center height=\"55\">";
			}
			$ftype = explode(".",$array_file[$y][0]);
			if($folder != ""){
			$preview_path = $folder."/".$array_file[$y][0];
			}else{
			$preview_path = $array_file[$y][0];
			}
			$preview_path_en = base64_encode($preview_path);
			
  ?>
            <td width="25%" valign="top" align="center"  id="ah<?php echo $i; ?>"  onClick="hlah('<?php echo $i; ?>','<?php echo $array_file[$y][0]; ?>','<?php echo $preview_path_en; ?>','Fi')" onDblClick="Editfile('<?php echo $preview_path; ?>','<?php echo $ftype[1]; ?>')"><img src="<?php echo imageShow($ftype[1]); ?>" width="24" height="24" border="0" align="absmiddle" title="<?php echo ShowSize($array_file[$y][1]); ?>"><div><?php echo $array_file[$y][0]; ?></div>
            </td>
  <?php 
    		if($i%4 == 3){
				echo "</tr>";
			}
  $i++; } ?>
  <?php 
 			  if($i%4 == 0){
				echo "<tr align=center height=\"55\"><td width=25% valign=top>
				<span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				
				</td>
				<td width=25%></td><td width=25%></td><td width=25%></td></tr>";
			}elseif($i%4 == 1){
				echo "<td width=25% align=center valign=top><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\"  onKeyDown=\"chkKeyFo(this)\"></div></span>
				</td>
				<td width=25% ></td><td width=25%></td></tr>";
			}elseif($i%4 == 2){
				echo "<td width=25% align=center valign=top><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				</td>
				<td width=25% </td></tr>";
			}elseif($i%4 == 3){
				echo "<td width=25% align=center valign=top><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				</td></tr>";
			}
  ?>
</table>
<?php 
if($i == 0){
?>
<table id="tbemp" width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr> 
              <td height="50" align="center">This folder is empty.</td>
  </tr>
</table>
<?php
  }else{
?>
<table id="tbemp" width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
              <td height="1" align="center"></td>
  </tr>
</table>
<?php
}
  ?>
</DIV>
</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr> 
                <td width="65%"><strong>&nbsp;Total <?php echo $numfolder; ?> 
                  Folder<?php if($numfolder >1){ echo"s"; } ?>
                  and <?php echo $numfile; ?> file<?php if($numfile >1){ echo"s"; } ?>
                  &nbsp;</strong></td>
                <td width="35%" align="right"><strong> 
                  <?php ShowSize($size);?>
                  </strong></td>
              </tr>
            </table></td>
        </tr>
		<input name="num" type="hidden" id="num" value="0">
  </form>
      </table></td>
  </tr>
</table>
<?php if($_GET["skip"] != "Y"){ ?>
<script language="JavaScript">
self.parent.gallery_left.gallery_preview.location.href='gallery_left_preview.php';
</script>
<?php }  ?>
</body>
</html>
<?php
$db->db_close(); ?>
