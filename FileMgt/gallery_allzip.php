<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$Current_Dir = "temp/".date('YmdHis').$_SESSION["EWT_SUSER"];
$FileNameZip=$_FILES["file"]["name"];
$date_temp = date('Ymd');
$file_exp = explode('.',$FileNameZip); 
$FileNameZipNew = $date_temp.'.'.$file_exp[1];
if (!(file_exists($Current_Dir))) {
	if(!@mkdir ($Current_Dir, 0777)){
	   echo "Can not create floder!. $Current_Dir ";
	}
}

//copy($_FILES["file"]["tmp_name"],$Current_Dir."/".$FileNameZip);
copy($_FILES["file"]["tmp_name"],$Current_Dir."/".$FileNameZipNew);
//$datamfile =$Current_Dir."/".$FileNameZip;
$datamfile =$Current_Dir."/".$FileNameZipNew;
if (file_exists($datamfile)) {
		$command='WinRAR.exe x -o+ -df -ep1 '.$datamfile.' '.$Current_Dir ;
		$output = shell_exec($command);
		unlink($datamfile);
}
/*
echo  $datamfile;
exit;
<br>
*/
function GenPic($data){
/*
$pic = "";
	for($i=0;$i<$data;$i++){
		$pic .= "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
	$pic .= "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	return $pic;*/
}

function LooPDir($Current_Dir,$pos,$mdir){

$obj_pos = $pos+1;
			$objFolder = opendir($Current_Dir);
			rewinddir($objFolder);
			  while($file = readdir($objFolder)){
			  if(!(($file == ".") or ($file == "..") or ($file == "Thumbs.db") )){
			      $FT= filetype($Current_Dir."/".$file);
			      if($FT == "dir"){
				        LooPDir($Current_Dir."/".$file,$obj_pos,$mdir.$file."/");
						 echo "<tr><td>".GenPic($pos)."<img src=\"../images/folder_closed.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;<a href=\"gallery_index.php?myfolder=".base64_encode($mdir.$file)."\" target=\"gallery_main\">".$file."</a></td></tr>";
			      }else{
			          echo "<tr><td valign=\"top\"><input type=\"checkbox\" value=\"".$file."\" name=\"ziplist[]\"><img src=\"".$Current_Dir."/".$file."\" width=\"50\" height=\"50\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;<a href=\"gallery_index.php?myfolder=".base64_encode($mdir.$file)."\" target=\"gallery_main\">".$file."</a></td><td> ".number_format(filesize($Current_Dir."/".$file)/1024,2)." Kb.</td></tr>";
				
			      }
			}
			  }
closedir($objFolder);
}
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>

				function hlah(c){
				var n = top.website_bar.document.form1.num.value;
							document.getElementById('ah'+n).removeAttribute("style");
							document.getElementById('ah'+c).style.backgroundColor = "#B2B4BF";
							top.website_bar.document.form1.num.value = c;
			}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<DIV id="divheight" align="center"  style="HEIGHT: 100%;OVERFLOW-Y: scroll;WIDTH: 100%;">
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="9D9DA1">
  <tr> 
    <td valign="top" bgcolor="#FFFFFF">
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
          <td><img src="../images/folder_img.gif" width="20" height="20" border="0" align="absmiddle"> <strong>Select Zip File</strong></td>
			<td><strong>File Size</strong></td>
  </tr>
  <form name="frmzip"  action="gallery_function.php" method="post">
  <?php
 //$_SESSION["EWT_SUSER"]="dmr_web";
 //$_SESSION["EWT_SDB"]="db_56_dmr_web";
  LooPDir($Current_Dir,0,"");
	 ?>
	   <tr>  <td align="right" colspan="2"><input type="submit" name="subzip" value="Save"></td></tr>
	   
        <input name="Flag" type="hidden" id="Flag" value="UploadZipFile"></td>
	<input name="current" type="hidden" id="current" value="<?php echo $_POST["current"]; ?>">
	<input name="currentzip" type="hidden" id="currentzip" value="<?php echo $Current_Dir; ?>">
	
	
	</form>
	
</table>
</td>
  </tr>
</table>
</DIV>
</body>
</html>
<?php $db->db_close(); ?>
