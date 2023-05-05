<?php include("../../protect2.php"); ?>
<?php include("../../lang_config.php"); ?>
<?php include($LangLookMgt_Detail); ?>
<?php
function imageShow($data){
$data = strtolower($data);
if($data=="doc"){  echo "<img src='doc.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif(($data=="zip")or($data=="rar")){  echo "<img src='zip.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif(($data=="xls")or($data=="csv")){  echo "<img src='xls.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="txt"){  echo "<img src='txt.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="ppt"){  echo "<img src='ppt.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="png"){  echo "<img src='png.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="pdf"){  echo "<img src='pdf.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif(($data=="jpg")or($data=="jpeg")){  echo "<img src='jpg.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="gif"){  echo "<img src='gif.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="exe"){  echo "<img src='exe.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="bmp"){  echo "<img src='bmp.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif(($data=="avi")or($data=="wav")or($data=="mp3")or($data=="dat")or($data=="mpeg")or($data=="mpg")or($data=="asf")or($data=="wmv")){  echo "<img src='avi.gif' width='22' height='22' border='0' alt='Choose file' >";  }
else{  echo "<img src='all.gif' width='22' height='22' border='0' alt='Choose file' >";  }
}
?>
<html>
<head>
<title>ADMINISTRATIVE ZONE</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="content-type" content="text/html;charset=UTF-8">
<SCRIPT Language="JavaScript">
function click(){
if (event.button==2)
  {
    alert("EasyWebTime a BizPotential Company \n\n Copyright 2001, All Rigths Reserved"); 
  }
}
document.onmousedown=click;
</SCRIPT>
</head>
<?php
include($includepath);
$CurrentImageDirectory =  $UserPath."\download";
?>
<SCRIPT Language="JavaScript">
function Close(){
window.close("look_action.php")
}
function ViewFile(fileName) {

		var leftPos = (screen.availWidth-700) / 2
		var topPos = (screen.availHeight-500) / 2 
	 	fileWin = window.open(fileName,'fileWindow','width=500,height=400,scrollbars=yes,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
		fileWin.focus()
		fileWin.location.reload(true);
	}
function WebDataUrl(c){
window.opener.document.linkForm.link.value = c;
window.close();
}
</SCRIPT>
<body bgcolor="#FFFFFF">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#6699FF">
  <tr>
    <td><div align="center"><font color="#6699ff"><b><font face="MS Sans Serif" size="2"><br>
        <font color="#FFFFFF">Link To File Download</font></font></b></font> </div>
      <br></td>
  </tr>
</table>
<div align="center">
<div align="center"><br>
<?php
  $y=0;
    @$objFolder = opendir($CurrentImageDirectory) or PrintError("Image Directory", "<B>Cannot open directory for reading: " . $CurrentImageDirectory."</b>", "$php_errormsg");
 if($objFolder){
 
 ?><table border="0" cellspacing="0" cellpadding="0" width="98%" class="bevel2"> 
<tr>
  <td ><div align="center"><table width=98% border=0 cellspacing=0 cellpadding=10>
    <tr>
  <?php  
  $x = 0;
  rewinddir($objFolder);
			
			while($file = readdir($objFolder))
			{
				echo $CurrentDirectory;
				$arrExt = explode(".", $CurrentDirectory . "/" . $file);
				$extension = $arrExt[sizeof($arrExt)-1];
					
				if(!(($file == ".") or ($file == "..") ))
				{
				?>
					<td width=25%>
						<table border=0 cellspacing=0 cellpadding=0 width=100%>
							<tr>
								
            <td colspan=2 class=body></td>
							</tr>
							<tr>
								<td width=60><a href="#" onClick="WebDataUrl('<?php echo $Website;?>/download/<?php echo $file;?>');" ><?php imageShow($extension); ?></a></td>
								
            <td width=876><a href='javascript:WebDataUrl("<?php echo $Website;?>/download/<?php echo $file;?>");' class=bodylink title="Insert file: '<?php echo $file; ?>' into your link"><font size="2" face="Microsoft Sans Serif, MS Sans Serif, sans-serif"><?php echo $file; ?></font></a>
              </td>
          </tr><tr>
            <td colspan=2 class=body><font size="1" face="Microsoft Sans Serif, MS Sans Serif, sans-serif"><?php echo filesize($CurrentImageDirectory . "/" . $file); ?> 
              bytes</font><br>
			<font size="1" face="Microsoft Sans Serif, MS Sans Serif, sans-serif"><?php // $ssize = @getimagesize($Website."/download/$file");  echo $ssize[3];?> 
              </font>
			</td>
							</tr>
						</table></td>
				<?php
					$y++;
					$x++;
					if($x == 3)
					{
						echo "</tr><tr>";
						$x = 0;
					}
				}
			}
  ?>
  
  
</td><tr></table>
  <?php }else{ ?>
  <div align="center"><b><font face="MS Sans Serif" size="2" color="#003399">[ 
    No picture available ] </font></b>
    <?php }?>
    <br>
    <br>
    <font face="MS Sans Serif" size="2"><a href="javascript:Close()"><img src="../../images/new_b_general_close.gif" width="32" height="31" border="0" align="absmiddle" alt="Close Window"></a></font> 
  </div>
</body>
</html>
