<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$text_status = "Search File & Folder.";

function imageShow($data){
$data = strtolower($data);
if($data=="jpg" OR $data=="jpeg"){  return "../images/document_pic.gif";  }
elseif(($data=="gif")or($data=="png")or($data=="bmp")){  return "../images/document_plain.gif";  }
else{  return "../images/document_blank.gif";  }
}

	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
		function Editfile(c,d){
			if(self.top.module_obj.document.formTodo.Flag.value == "Choose" || self.top.module_obj.document.formTodo.Flag.value == "SetBg" || self.top.module_obj.document.formTodo.Flag.value == "EditChoose"  || self.top.module_obj.document.formTodo.Flag.value == "Link"  || self.top.module_obj.document.formTodo.Flag.value == "SetPic" || self.top.module_obj.document.formTodo.Flag.value == "LinkReturn" ){
					if(self.top.module_obj.document.formTodo.stype.value =="images" ){
						var dcompare = d.toLowerCase();
						if(dcompare == "gif" || dcompare == "jpeg" || dcompare == "jpg" || dcompare == "bmp" || dcompare == "png"){
							if(self.top.module_obj.document.formTodo.Flag.value == "LinkReturn"){
								  if(navigator.appName.indexOf('Microsoft')!=-1)
									 window.returnValue = "images/" + c;
								else
									window.opener.setAssetValue("images/" + c);
	
								 self.close();
							}else{
								sendfile(c);
							}
						}else{
							alert("File type is not correct!!!");
							return false;
						}
					}
						if(self.top.module_obj.document.formTodo.stype.value =="flash" ){
							if(d == "swf" || d == "SWF"){
								if(self.top.module_obj.document.formTodo.Flag.value == "LinkReturn"){
								  if(navigator.appName.indexOf('Microsoft')!=-1)
									 window.returnValue = "images/" + c;
								else
									window.opener.setAssetValue("images/" + c);
	
								 self.close();
							}else{
								sendfile(c);
							}
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
			function PrevP(c){
				self.parent.gallery_left.gallery_preview.location.href='gallery_left_preview.php?fname=' + c;
			}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <form name="formSearch" method="post" action="gallery_search.php"><tr>
    <td height="40" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<a href="<?php echo "gallery_index.php?skip=Y";  ?>" ><img src="../images/content_back.gif" width="24" height="24" border="0" align="absmiddle"> 
      Back</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/folder_search.gif" width="24" height="24" border="0" align="absmiddle"> 
      Search 
      
        <input name="c_search" type="text" id="c_search" value="<?php echo $_POST["c_search"]; ?>" size="30">
        <input type="submit" name="Submit" value="Search">
        <input name="Flag" type="hidden" id="Flag" value="Search">
        </td>
  </tr></form>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
<tr>
    <td height="20" bgcolor="F9FAFD"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="60%" align="center">Name</td>
          <td width="1"><font color="#9D9EB7" size="2">|</font></td>
          <td align="center">Location</td>
        </tr>
      </table></td>
  </tr>
    <tr>
    <td height="1" bgcolor="B5B6C8"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td valign="top"> 
      <?php
	if($_POST["Flag"] == "Search"){
		$array_folder = array();
		$array_file = array();
		$search = $_POST["c_search"];
	function LooPDir($Current_Dir,$pos,$mdir){
	global $array_folder;
	global $array_file;
	global $search;
$obj_pos = $pos+1;
			$objFolder = opendir($Current_Dir);
			rewinddir($objFolder);
			  while($file = readdir($objFolder)){
			  if(!(($file == ".") or ($file == "..") or ($file == "Thrumb.db") )){
			  $FT= filetype($Current_Dir."/".$file);
			  if($FT == "dir"){
			  		if (@eregi($search,$file) OR $search =="") {
				
echo "<tr> 
              <td width=\"65%\" height=\"30\" bgcolor=\"F7F7F7\">&nbsp;&nbsp;<a onDblClick=\"self.location.href='gallery_index.php?myfolder=".base64_encode($mdir.$file)."';\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"> ".$file."</a> </td>
              <td width=\"35%\" nowrap>";
			  if($mdir == ""){
			  echo "<a onDblClick=\"self.location.href='gallery_index.php';\"><img src=\"../images/folder_img.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"> My Gallery";
			  }else{
			  echo "<a onDblClick=\"self.location.href='gallery_index.php?myfolder=".base64_encode(substr($mdir,0,-1))."';\"><img src=\"../images/folder_closed.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"> ".substr($mdir,0,-1);
			  }
echo "</a></td>
            </tr>";
					}
				LooPDir($Current_Dir."/".$file,$obj_pos,$mdir.$file."/");
			}else{
					if (@eregi($search,$file) OR $search =="") {
					$ftype = explode(".",$file);
echo "<tr> 
              <td width=\"65%\" height=\"30\" bgcolor=\"F7F7F7\">&nbsp;&nbsp;<a onClick=\"PrevP('".base64_encode($mdir.$file)."')\" onDblClick=\"Editfile('".$mdir.$file."','".$ftype[1]."')\"><img src=\"".imageShow($ftype[1])."\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"> ".$file."</a> 
</td>
              <td width=\"35%\" nowrap>";
			  if($mdir == ""){
			  echo "<a onDblClick=\"self.location.href='gallery_index.php';\"><img src=\"../images/folder_img.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"> My Gallery";
			  }else{ 
			  echo "<a onDblClick=\"self.location.href='gallery_index.php?myfolder=".base64_encode(substr($mdir,0,-1))."';\"><img src=\"../images/folder_closed.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\"> ".substr($mdir,0,-1);
			  }
echo "</a></td>
            </tr>";
					}
			}
			}
 
}
closedir($objFolder);
}
	$i = 0;
	$count_folder = 0;
   	$count_file = 0;
	  $Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";
	$db->write_log("search","Images","ค้นหา Images name :   ".$search);
	?>
      <DIV align="center"  style="OVERFLOW-Y:scroll;HEIGHT: 100%;WIDTH: 100%">
		  
        <table width="100%" height="100%" border="0" align="center" cellpadding="3" cellspacing="0">
          <form name="form1" method="post" action="">
           <?php LooPDir($Current_Dir,0,""); ?>
            <tr> 
              <td  bgcolor="F7F7F7">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <input name="num" type="hidden" id="num" value="0">
          </form>
        </table>
</DIV>
<?php $text_status = "Found : ".$count_folder." Folder";
				if($count_folder >1){
				$text_status .= "s"; 
				} 
            	$text_status .= " and ".$count_file." file";
				if($count_file >1){
				$text_status .= "s"; 
				}
				$text_status .= "."; 
  ?>
<?php } ?>
</td>
  </tr>
</table>
<script language="JavaScript">
document.formSearch.c_search.focus();
</script>
</body>
</html>
<?php $db->db_close(); ?>
