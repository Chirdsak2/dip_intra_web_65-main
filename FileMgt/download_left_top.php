<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

function GenPic($data){
$pic = "";
	for($i=0;$i<$data;$i++){
		$pic .= "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
	$pic .= "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	return $pic;
}

function LooPDir($Current_Dir,$pos,$mdir){
$obj_pos = $pos+1;
			$objFolder = opendir($Current_Dir);
			rewinddir($objFolder);
			  while($file = readdir($objFolder)){
			  if(!(($file == ".") or ($file == "..") or ($file == "Thrumb.db") )){
			  $FT= filetype($Current_Dir."/".$file);
			  if($FT == "dir"){
				echo "<tr><td>".GenPic($pos)."<img src=\"../images/folder_closed.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;<a href=\"download_index.php?myfolder=".base64_encode($mdir.$file)."\" target=\"download_main\">".$file."</a></td></tr>";
				LooPDir($Current_Dir."/".$file,$obj_pos,$mdir.$file."/");
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
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="9D9DA1">
  <tr> 
    <td valign="top" bgcolor="#FFFFFF">
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
          <td><img src="../images/folder_dl.gif" width="20" height="20" border="0" align="absmiddle"> 
            <strong><a href="download_index.php" target="download_main" >My 
            download</a></strong></td>
  </tr>
  <?php
  $Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download";
LooPDir($Current_Dir,0,"");
	 ?>

</table>
</td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
