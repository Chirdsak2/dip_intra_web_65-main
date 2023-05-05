<?php
$sign = "\\";
$NDir = $_GET["NDir"];
$DDir = "../../../";
$dbs = $sign;
$ss = $sign;
$CDir = $DDir.$NDir;
$max_upload = "10000000";
$Upk = $max_upload/1000;
$Submit=$_REQUEST["Submit"];
$Submit2=$_REQUEST["Submit2"];
$nfolder=$_REQUEST["nfolder"];
$path = $_REQUEST["path"];
$Falg = $_REQUEST["Falg"];
$file_name = $_REQUEST["file_name"];
?>
<html>
<head>
<title>Document Management System</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="content-type" content="text/html;charset=UTF-8">
</head>
<script>
function hidestatus(){
window.status=''
return true
}
if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)
document.onmouseover=hidestatus
document.onmouseout=hidestatus
</script>
<script language="JavaScript">
function UseIMG(c,d){
document.all.myname.innerHTML = "Preview : "+d;
document.all.page.src = c;
}
</script>
<script language="javascript" type="text/javascript" src="function.js"></script>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function imageShow($data){
$data = strtolower($data);
if($data=="doc"){  echo "<img src='images/doc.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif(($data=="zip")or($data=="rar")){  echo "<img src='images/zip.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif(($data=="xls")or($data=="csv")){  echo "<img src='images/xls.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="txt"){  echo "<img src='images/txt.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="php"){  echo "<img src='images/php.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="ppt"){  echo "<img src='images/ppt.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="png"){  echo "<img src='images/png.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="pdf"){  echo "<img src='images/pdf.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif(($data=="jpg")or($data=="jpeg")){  echo "<img src='images/jpg.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif(($data=="htm")or($data=="html")){  echo "<img src='images/htm.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="gif"){  echo "<img src='images/gif.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="exe"){  echo "<img src='images/exe.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif($data=="bmp"){  echo "<img src='images/bmp.gif' width='22' height='22' border='0' alt='Choose file' >";  }
elseif(($data=="avi")or($data=="wav")or($data=="mp3")or($data=="dat")or($data=="mpeg")or($data=="mpg")or($data=="asf")or($data=="wmv")){  echo "<img src='images/avi.gif' width='22' height='22' border='0' alt='Choose file' >";  }
else{  echo "<img src='images/all.gif' width='22' height='22' border='0' alt='Choose file' >";  }
}
function ShowSize($data){
if($data > 1024000){ echo number_format($data/1024000,2)." MB."; }
elseif($data > 1024){ echo number_format($data/1024,2)." KB."; }
elseif($data > 1){ echo number_format($data)." bytes."; }
elseif($data >= 0){ echo number_format($data)." byte."; }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($Submit=="Upload"){
$rowsfile = count($_FILES["file"]["tmp_name"]);
for($i=0;$i<$rowsfile;$i++){
if($_FILES['file']['size'][$i] > 0){
if($_FILES['file']['size'][$i] > $max_upload){
?>
	<SCRIPT Language="JavaScript">
    alert("Size of '<?php echo $_FILES["file"]["name"][$i]; ?>' is over <?php echo $Upk; ?> k"); 
</SCRIPT>
<?php
}
else
{
$path1 = $path."/".$_FILES["file"]["name"][$i]; 
if (file_exists($path1)) {
?>
	<SCRIPT Language="JavaScript">
    alert(" '<?php echo $file_name[$i];?>' . File already exist !."); 
</SCRIPT>
<?php
}

copy($_FILES["file"]["tmp_name"][$i], $path1);
@chmod($path1,0777);
@unlink($file[$i]);

}
}
}
}
if($Submit2=="Create")
{
if($nfolder!=""){
if(!mkdir($path."/".$nfolder,0777)){
	?>
	<SCRIPT Language="JavaScript">
    alert("Can not create '<?php echo $nfolder;?>' . Folder already exist !."); 
</SCRIPT>
	<?php
	}else{
chmod($path."/".$nfolder,0777) or die("xxxxx");
}
}
}
if($Falg=="delete")
{
@unlink($CDir.$dbs.$file_name);
}
if($Falg=="Fdelete")
{

function LooPDel($p){
$dir=@opendir($p);
//echo $p;
while($data=@readdir($dir))
{
if(($data!=".")and($data!="..")and($data!="")){
if(!@unlink($p."/".$data))
{
LooPDel($p."/".$data);
}
}
}
@closedir($dir);
@rmdir($p);
}
if(!@rmdir($path."/".$file_name)){

}
LooPDel($path."/".$file_name);
}
?>

<?php 
//$NDir = substr($NDir,1);
@$objFolder = opendir($CDir);
$ADir = explode($ss,$NDir);
$ca = count($ADir);
for($i=0;$i<$ca;$i++){
if($ADir[$i]!=""){  $NowD .= $ADir[$i]."/";}
}
$NowD=$FolderUse.$NowD;
if($objFolder){ 
?>
<body bgcolor="#FFFFFF"  leftmargin="0" topmargin="0">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td height="10" >
	<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#0066CC">
  <form action="download.php?NDir=<?php echo $NDir; ?>" method="post" enctype="multipart/form-data" name="form1">
          <tr> 
            <td colspan="2"><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Path 
              : <?php echo "Root directory/".$NowD;?></strong></font></td>
          </tr>

          <tr> 
            <td width="29%"><div align="right"><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Create 
                new folder</strong></font></div></td>
            <td width="71%"><input name="nfolder" type="text" id="nfolder" size="36" > 
              <input type="submit" name="Submit2" value="Create" onClick="return check();"></td>
          </tr>

          <tr> 
            <td height="10" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="3" id="myTable">
  <tr>
    <td width="35%" align="right"><div align="right"><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Upload 
                      file </strong></font></div></td>
    <td width="23%"><input type="file" name="file[]"></td>
    <td><img src="images/delete1.gif" width="16" height="16"></td>
  </tr>
  <tr>
    <td width="35%" align="right">&nbsp;</td>
    <td width="23%"><input type="submit" name="Submit" value="Upload">
      <input name="path" type="hidden" id="path" value="<?php echo $CDir; ?>"></td>
    <td><a href='#' onClick="AddRoom('myTable');"><img src="images/add.gif" width="16" height="16" border="0"></a></td>
  </tr>
</table></td>
          </tr>
		  </form>
</table>
	</td>
  </tr>
  <tr>
    <td ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr bgcolor="#EEEEEE"> 
      <td width="4%" valign="top"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"> <a href="download.php"><img src="images/home.gif" alt="Home" width="22" height="22" border="0"></a> 
      </font></td>
      <td width="55%" height="30" valign="top"><font color="#0000FF" size="1" face="MS Sans Serif, Tahoma, sans-serif">&nbsp; 
        <?php
	   if($CDir != $DDir){ 
//  $e = explode($dbs,$NDir);
 // $num = strlen($e[count($e)-1]);
//  $num=$num+2;
//	$UDir = substr($NDir,0,$num);
$UDir = dirname($NDir);
$c = strlen($UDir);
if($UDir==$ss){ $UDir=""; }
  ?>
        <a href="download.php?NDir=<?php  echo $UDir; ?>"><img src="images/upf.gif" alt="Up" width="20" height="22" border="0"></a> 
        <?php } ?>
        </font>      <div align="center"></div>
      </td>
      <td width="17%" align="center" valign="middle"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Size</strong></font></td>
      <td width="24%" align="right" valign="middle"><font color="#FF0000" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Delete</strong></font></td>
    </tr>
    <tr align="center" valign="top" bgcolor="#FFFFFF">
      <td colspan="4" align="left">
	<DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%">
	  <table width="100%" cellpadding="0" cellspacing="0">
    <?php 
  rewinddir($objFolder);
		$numfolder = 0;	
			while($file = readdir($objFolder))
			{
				$arrExt = explode(".", $CDir . "/" . $file);
				$extension = $arrExt[sizeof($arrExt)-1];
			$FT= filetype($CDir."/".$file);
			if($FT == "dir"){
			$pass = "0";
				if(!(($file == ".") or ($file == "..") ))
				{
   ?>
    <tr bgcolor="#FFFFFF"  onmouseover="this.style.backgroundColor='#FFFFCC';" 
  onmouseout="this.style.backgroundColor='#FFFFFF';" > 
      <td width="4%" valign="top"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><img src="images/folder.gif" width="22" height="22"></font></td>
      <td width="51%" valign="middle"><a href="download.php?NDir=<?php echo $NDir; ?>/<?php echo $file; ?>" ><font color="#660000" size="1" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $file; ?> # <?php echo fileperms($CDir."/".$file); ?></font></a></td>
      <td width="16%" align="right" valign="middle"><font size="1" face="MS Sans Serif, Tahoma, sans-serif">&nbsp;</font></td>
      <td width="29%" align="right" valign="middle"><?php if($ADMINL == "Y" AND $NDir == ""){ echo "&nbsp;"; }else{ ?><a href="download.php?Falg=Fdelete&NDir=<?php echo $NDir; ?>&file_name=<?php echo $file ?>&path=<?php echo $CDir; ?>" onClick="javascript: return confirm('Are you sure you want to remove the folder &quot;<?php echo $file; ?>&quot; and all its contents?');"><font color="#FF0000" size="1" face="MS Sans Serif, Tahoma, sans-serif">Delete 
        Folder</font></a><?php } ?></td>
    </tr>
    <?php $numfolder++; }}} ?>
    <?php 
 @$objFolder = opendir($CDir);
			$numfile = 0;
			$sizeall = 0;
			while($file = readdir($objFolder))
			{
				$arrExt = explode(".", $CDir . "/" . $file);
				$extension = $arrExt[sizeof($arrExt)-1];
			$FT= filetype($CDir."/".$file);
			$EXPLO = explode(".",$file);
			if(($FT == "file") /*and(($EXPLO[1]=="htm")or($EXPLO[1]=="html"))*/){
				if(!(($file == ".") or ($file == "..") ))
				{
   ?>
    <tr bgcolor="#FFFFFF"  onmouseover="this.style.backgroundColor='#FFFFCC';" 
  onmouseout="this.style.backgroundColor='#FFFFFF';"> 
      <td width="4%" valign="top"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"> 
        <?php imageShow($extension); ?>
      </font></td>
      <td valign="middle"><a href="dl.php?NowD=<?php echo $NDir; ?>&FID=<?php echo $file; ?>" target="_blank" title="Click to download this file"><font color="#000033" size="1" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $file; ?>  # <?php echo fileperms($CDir."/".$file); ?></font></a></td>
      <td align="right" valign="middle"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"> 
          <strong><?php ShowSize(filesize($CDir."/".$file)); ?></strong></font></td>
      <td width="29%" align="right" valign="middle"><?php if($ADMINL == "Y" && $CmsID == "" && $sd23 != "Y"){ echo "&nbsp;"; }else{ ?><a href="download.php?Falg=delete&NDir=<?php echo $NDir; ?>&file_name=<?php echo $file ?>&path=<?php echo $CDir; ?>" onClick="javascript: return confirm('Are you sure you want to delete &quot;<?php echo $file; ?>&quot; ?');"><font color="#FF0000" size="1" face="MS Sans Serif, Tahoma, sans-serif">Delete 
        File</font></a><?php } ?></td>
    </tr>
    <?php $numfile++;   $sizeall = $sizeall+filesize($CDir."/".$file); }}}
	 ?>
    </table></DIV>
    </td>
      </tr>
    <tr align="center" bgcolor="#0066CC"> 
      <td height="25" colspan="2" align="left"><font size="1">&nbsp;</font><strong><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif">Total 
        <?php echo $numfolder; ?> Folder 
        <?php if($numfolder >1){ echo"s"; } ?>
        and <?php echo $numfile; ?> file<?php if($numfile >1){ echo"s"; } ?>
        </font></strong><strong><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"> 
        </font></strong><font size="1" face="MS Sans Serif, Tahoma, sans-serif">&nbsp;</font></td>
      <td align="center"><font color="#FFFFFF" size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php ShowSize($sizeall); ?></strong></font></td>
      <td align="left">&nbsp;</td>
    </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
<?php } ?>
<script language="JavaScript">
function check(){
if(document.form1.nfolder.value==''){
alert(" Please insert New Folder Name ");
document.form1.nfolder.focus();
return false;
}
}
function check1(){
if(document.form1.file.value==''){
alert(" Please Browse New File to Upload ");
document.form1.file.focus();
return false;
}
}
</script>

