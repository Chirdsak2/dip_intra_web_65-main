<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");

if ( ! function_exists('symbolic_permissions'))
{
    function symbolic_permissions($perms)
    {    
        if (($perms & 0xC000) == 0xC000)
        {
            $symbolic = 's'; // Socket
        }
        elseif (($perms & 0xA000) == 0xA000)
        {
            $symbolic = 'l'; // Symbolic Link
        }
        elseif (($perms & 0x8000) == 0x8000)
        {
            $symbolic = '-'; // Regular
        }
        elseif (($perms & 0x6000) == 0x6000)
        {
            $symbolic = 'b'; // Block special
        }
        elseif (($perms & 0x4000) == 0x4000)
        {
            $symbolic = 'd'; // Directory
        }
        elseif (($perms & 0x2000) == 0x2000)
        {
            $symbolic = 'c'; // Character special
        }
        elseif (($perms & 0x1000) == 0x1000)
        {
            $symbolic = 'p'; // FIFO pipe
        }
        else
        {
            $symbolic = 'u'; // Unknown
        }

        // Owner
        $symbolic .= (($perms & 0x0100) ? 'r' : '-');
        $symbolic .= (($perms & 0x0080) ? 'w' : '-');
        $symbolic .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));

        // Group
        $symbolic .= (($perms & 0x0020) ? 'r' : '-');
        $symbolic .= (($perms & 0x0010) ? 'w' : '-');
        $symbolic .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));

        // World
        $symbolic .= (($perms & 0x0004) ? 'r' : '-');
        $symbolic .= (($perms & 0x0002) ? 'w' : '-');
        $symbolic .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));

        return $symbolic;        
    }
}
if ( ! function_exists('octal_permissions'))
{
    function octal_permissions($perms)
    {
        return substr(sprintf('%o', $perms), -3);
    }
}

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
			  if(!(($file == ".") or ($file == "..") or ($file == "Thumbs.db") )){
			  $FT= filetype($Current_Dir."/".$file);
			  if($FT == "dir"){
				echo "<tr><td>".GenPic($pos)."<img src=\"../images/folder_closed.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;".$file." </td><td>".symbolic_permissions(fileperms($Current_Dir."/".$file))."</td><td>".octal_permissions(fileperms($Current_Dir."/".$file))."</td></tr>";
				if(!($Current_Dir."/".$file == "../../ewtadmin/ewt/dmr_web/images" OR $Current_Dir."/".$file == "../../ewtadmin/ewt/dmr_intranet/images")){
				LooPDir($Current_Dir."/".$file,$obj_pos,$mdir.$file."/");
				}
				
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
	<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
          <td><img src="../images/folder_dl.gif" width="20" height="20" border="0" align="absmiddle"> 
            <strong><a href="download_index.php" target="download_main" >ewtadmin</a></strong></td>
  </tr>
  <?php
  //$Current_Dir = "../../ewtadmin/ewt/";
  //$Current_Dir = "../../ewtadmin/";
  $Current_Dir = "../../ewtadmin";
LooPDir($Current_Dir,0,"");
	 ?>

</table>
</td>
  </tr>
</table>
</body>
</html>
