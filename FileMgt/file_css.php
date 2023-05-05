<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/css";
$numfolder = 0;
$numfile = 0;
$size = 0;

function ShowSize($data){
if($data > 1024000){ echo number_format($data/1024000,2)." MB."; }
elseif($data > 1024){ echo number_format($data/1024,2)." KB."; }
elseif($data > 1){ echo number_format($data)." bytes."; }
elseif($data >= 0){ echo number_format($data)." byte."; }
}

	if($_POST["Flag"] == "Upload" ){
		copy($_FILES["file"]["tmp_name"],$Current_Dir."/".$_FILES["file"]["name"]);
		@chmod ($Current_Dir."/".$_FILES["file"]["name"], 0755);
	}
	if($_POST["Flag"] == "Delfile" ){
		$all = count($_POST["chk"]);
		for($i=0;$i<$all;$i++){
			if($_POST["chk"][$i] != ""){
				@unlink($Current_Dir."/".$_POST["chk"][$i]);
			}
		}
	}	
	if($_POST["Flag"] == "select_file" ){
		$db->query("UPDATE temp_index SET css_file = '".$_POST["cssname"]."' WHERE filename = '".$_POST["filename"]."'");
		?>
		<script language="JavaScript">
		self.location.href = "../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_preview.php?filename=<?php echo $_POST["filename"]; ?>";	
		</script>
		<?php
			exit;
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function preview(c){
document.all.preview.innerHTML = "<br>file : " + c;
img_preview.location.href = "<?php echo $Current_Dir;?>/" + c;
}
function select_f(c){
document.write("<form name=\"selectform\" method=\"post\" action=\"file_css.php\">");
document.write("<input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"select_file\">");
document.write("<input name=\"filename\" type=\"hidden\" id=\"filename\" value=\"<?php echo $_REQUEST["filename"];?>\">");
document.write("<input name=\"cssname\" type=\"hidden\" id=\"cssname\" value=\""+ c +"\">");
document.write("<br><br><br><br><br><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div>");
document.write("</form>");
selectform.submit();
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="AFA9B4">
  <tr> 
    <td height="30" bgcolor="F1EFF4">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="69%">&nbsp;&nbsp;<strong><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> 
      Cascadind Style Sheet File for <?php echo $_REQUEST["filename"]; ?></strong>&nbsp;</td>
          <td width="31%" align="right"><a href="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_preview.php?filename=<?php echo $_REQUEST["filename"]; ?>"><strong>&lt;&lt; 
            Back&nbsp;&nbsp;</strong></a></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="50" valign="top" bgcolor="F1EFF4"><table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
        <!-- <tr> 
          <td colspan="2" ><strong>Current path:</strong></td>
        </tr>
        <form name="form1" method="post" action="">
          <tr> 
            <td width="32%"  ><strong>Create New Folder</strong></td>
            <td width="68%"  ><input type="text" name="textfield"> <input type="submit" name="Submit" value="Create"> 
            </td>
          </tr>
        </form> -->
        <form name="form2" enctype="multipart/form-data" method="post" action="file_css.php">
          <tr> 
            <td><strong>Upload File</strong></td>
            <td> <input type="file" name="file"> </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit2" value="Upload">
              <input name="Flag" type="hidden" id="Flag" value="Upload">
              <input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>"></td>
          </tr>
        </form>
      </table></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr bgcolor="#FBFBFB"> 
          <td height="30" colspan="2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><a href="#del" onClick="if(confirm('Are you sure you want to delete selected file(s)?')){ form3.submit(); }"><img src="../images/delete.gif" width="24" height="24" border="0" align="absmiddle"> 
                  <strong>Delete selected</strong></a> 
                  <!--<img src="../images/house.gif" width="24" height="24" border="0" align="absmiddle"> 
            <strong>Home</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/folder_up.gif" width="24" height="24" border="0" align="absmiddle"> 
            <strong>Up </strong>-->
                </td>
              </tr>
            </table></td>
        </tr>
		<?php
		$objFolder = opendir($Current_Dir);
		?>
        <tr bgcolor="#FFFFFF"> 
          <td valign="top">
		  <DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <form name="form3" method="post" action="file_css.php">
                  <input name="Flag" type="hidden" id="Flag" value="Delfile">
                  <input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>">
                  <?php
			rewinddir($objFolder);
			  while($file = readdir($objFolder)){
			  if(!(($file == ".") or ($file == "..") or ($file == "Thrumb.db") )){
			  $FT= filetype($Current_Dir."/".$file);
			  if($FT == "dir"){
			  $numfolder++;
			  ?>
                  <tr> 
                    <td width="20"> <img src="../images/i_folder_off.jpg" width="16" height="16" border="0" align="absmiddle"> 
                    </td>
                    <td colspan="3"><?php echo $file; ?> </td>
                  </tr>
                  <?php
			  }else{
			  $numfile++;
			  ?>
                  <tr> 
                    <td width="20"> <input type="checkbox" name="chk[]" value="<?php echo $file; ?>"> 
                    </td>
                    <td width="60%"><?php echo $file; ?></td>
                    <td width="20%" align="center"><a href="#select" onClick="select_f('<?php echo $file; ?>');">Select</a></td>
                    <td width="20%" align="right">
                      <?php 
					$file_size = filesize($Current_Dir."/".$file);
					ShowSize($file_size);
					$size += $file_size;
					 ?>
                    </td>
                  </tr>
                  <?php }}} ?>
                </form>
              </table>
			</DIV>
			</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="65%"><strong>&nbsp;Total <?php echo $numfolder; ?> 
            Folder<?php if($numfolder >1){ echo"s"; } ?>
            and <?php echo $numfile; ?> file<?php if($numfile >1){ echo"s"; } ?>
            &nbsp;</strong></td>
                <td width="35%" align="right"><strong><?php ShowSize($size);?></strong></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
closedir($objFolder);
$db->db_close(); ?>
