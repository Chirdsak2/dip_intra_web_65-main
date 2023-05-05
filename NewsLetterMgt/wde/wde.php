<?php

global $HTTP_SERVER_VARS;
global $HTTP_POST_VARS;
global $HTTP_GET_VARS;
global $HTTP_SESSION_VARS;
global $docRoot;
global $ImageDir;
global $maximagesize;
global $Website;
global $user_name;
session_register("ImageDir");
session_register("Website");
// required to store system errors in php_errormsg
ini_set("track_errors","1");

$CurrentImageDirectory = $HTTP_SESSION_VARS["ImageDir"];
$WebsiteURL = $HTTP_SESSION_VARS["Website"];
$scriptName = $HTTP_SERVER_VARS["SCRIPT_NAME"];
$URL = $HTTP_SERVER_VARS["SERVER_NAME"];
$docRoot = $HTTP_SERVER_VARS["DOCUMENT_ROOT"];
$maximagesize = "1200000";

//echo "W: $WebsiteURL";
//echo "I: $CurrentImageDirectory";
//echo "U: $user_name";
?>
<link rel="stylesheet" href="wde/style.css" type="text/css">
<?php 
$ToDo = $HTTP_GET_VARS["wde"];
if ($ToDo != "UploadPage") {
	$ToDo = $HTTP_POST_VARS["wde"];
	if ($ToDo == "") {
		$ToDo = $HTTP_GET_VARS["wde"];
	}
}

if ($ToDo == "InsertImage") {
	PrintImageDir();
	die();
} else if ($ToDo == "Upload Image") {
	ShowUploadPage();
	die();
} else if ($ToDo == "UploadPage") {
	UploadPage();
	die();
}

global $str_message;
global $icon;

function UploadPage()
	{
		ob_start();
		
		global $icon, $str_message, $success, $toDofilesize;
		global $maximagesize, $CurrentImageDirectory;
		global $sourcefile, $scriptName;
		global $sourcefile_name;
		global $sourcefile_type;
		global $sourcefile_size;
		global $docRoot;
		global $php_errormsg;
		global $user_name;
		$pathToFile = "";
		$msgExists = "";
		$fileUploaded = false;
		
		$toDofilesize = $maximagesize;
		
		if (!file_exists($CurrentImageDirectory)){ @mkdir($CurrentImageDirectory,"0777"); }
			
		if (($sourcefile_size > $toDofilesize) || ($sourcefile_size == 0))
		{
			$str_message = "Please select a file to upload. (No Greater than " . $toDofilesize . "bytes)";
			$icon = "error.gif";
		}
		else
		{
				$pathToFile = $CurrentImageDirectory . $sourcefile_name;
//echo $pathToFile;
			if (file_exists($pathToFile)) {
				$msgExists = "Could not upload file. A file or folder with that name already exists ";
			}
			else
			{		
				// Uploading file data
				$fileUploaded = @move_uploaded_file($sourcefile, $pathToFile);
			}
			
			if ($fileUploaded)
			{
				$icon = "info.gif";
				$str_message = $sourcefile_name . " uploaded successfully.";
				$success = 1;
				echo "<center>"; ?>
				<br>
				<br>
				<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#3399FF">
  <tr>
    <td><div align="center"><b><font color="#FFFFFF" size="2" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $str_message; ?></font></b></div></td>
  </tr>
  <tr>
    <td><div align="center">
        <input type="button" name="Button" value="Back to Image Manager" onClick="javascript:window.location.href='temp_add.php?wde=InsertImage';">
      </div></td>
  </tr>
</table>

<?php echo "</center>";
@include("../protect.php");
@include($includepath);
$db = @new DB;
$pdate = date("Y-m-d");
/********************** Replace existing Picture in DB **********************/
$DelPic = "DELETE FROM picture WHERE p_filename='$sourcefile_name' AND Usr='$user_name' AND P_MaincatID =1 ";
$ExecDelPic = $db->query($DelPic);
/********************** End Replace existing Picture in DB **********************/
/********************** Keep Picture to DB **********************/
$KeepPic = "INSERT INTO picture (p_filename,Usr,P_MaincatID,P_SubcatID, p_name,p_status,p_date)
					   VALUES('$sourcefile_name', '$user_name', 1,1, '$sourcefile_name', '$pstatus', '$pdate' ) ";
$ExecKeepPic = $db->query($KeepPic);
/********************** End Keep Picture to DB **********************/

			}
			else
			{
				$icon = "error.gif";
				
				if($msgExists == "")
					$str_message = $sourcefile_name . " could not be uploaded: $php_errormsg";
				else
					$str_message = $msgExists;
				
				$success = 0;
			}
		}

		PrintInfoMessage("Upload File / Image");
?> 
<input type=hidden name=wde value=InsertImage>

	<?php
		
		if($success == 1) {
	?>
			<input type="submit" name="Submit" value="OK" class="Text50">
	<?php
		} else {
	?>
			<input type="button" name="Submit" value="OK" class="Text50" onClick="javascript:history.back()">
	<?php
		}
	?>
					</form>
					</td>
				  </tr>  
			</table>
	<?php
}

	function PrintInfoMessage($title)
	{
		global $str_message;
		global $icon;
		global $URL;
		global $scriptName;
	?>
                <br>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                        <td width="15"><img src="wde/1x1.gif" width="15" height="1"></td>
                        <td class="heading1"><?php echo $title?></td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td class="body">
                          <table width="98%" border="0" cellspacing="0" cellpadding="0" class="bevel2">
                                <tr>
                                  <td width="18"><img src="wde/<?php echo $icon?>" width="18" height="18" hspace="10" vspace="5" align="middle"></td>
                                  <td class="bodybold"><?php echo $str_message?></td>
                                </tr>
                          </table>
                        </td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td><form method=post action=http://<?php echo $URL?><?php echo $scriptName?>>
	<?php
	} // PrintInfoMessage


function ShowUploadPage()
	{
		// print the upload file page

		global $fileContent;
		global $scriptName;
		global $docRoot;

		$includeFile = "wde/upload_page.inc";

		if(file_exists($includeFile))
		{
			@$fp = fopen($includeFile, "r");
			$fileContent = "";
			
			while($data = fgets($fp, 1024))
			{
				$fileContent .= $data;
			}
			$scriptName = "temp_add.php";
			$fileContent = str_replace("\$SCRIPTNAME", $scriptName, $fileContent);

			echo $fileContent;
		}
		else
		{
			PrintError("Template", "<B>Cannot open Upload Page file:</B> wde/upload_page.inc", "File not Found");
		}
	}

function PrintError($str_error_header, $str_error_message, $str_system_message)
	{
		if($str_error_header == "")
			$str_error_header = "Error";
		
		if($str_error_message == "")
			$str_error_message = "A system error has occured. Could not continue.";

		?>
		<br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 		 <tr>
				<td width="15"><img src="wde/1x1.gif" width="15" height="1"></td>
				
			<td class="heading1"><?php echo $str_error_header; ?></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td class="body">&nbsp;</td>
			  </tr>  
			  <tr>
				<td>&nbsp;</td>
				<td class="body">
				  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="bevel2">
					<tr>	  
					  <td width="18"><img src="wde/error.gif" width="18" height="18" hspace="10" vspace="5" align="middle"></td>
					  
			  <td class="body"><?php echo $str_error_message?>&nbsp;<?php echo $str_system_message; ?></td>
					</tr>
				  </table>
				</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
						<td><input type="button" name="Cancel" value="OK" class="Text50" onClick="Javascript:history.back()">
				</td>
			  </tr>  
		</table>
		<?php
			// exit the script after printing the error message
			die();
	}

function PrintImageDir()
	{
		// Print the contents of the directory
		// First, load the javascript functions
		
		global $CurrentImageDirectory;
		global $WebsiteURL;
		global $ImageDirectory;
		global $objFolder;
		global $scriptName;

		global $ImageFileType;
		global $URL;
		global $docRoot;
		global $php_errormsg;
		if($CurrentImageDirectory == "")
			$CurrentImageDirectory = $NewImageDirectory;
		
		if($CurrentImageDirectory == "")
		{
			$CurrentImageDirectory = "/";
			$ImageDirectory = "/";
		}

		@$objFolder = opendir($CurrentImageDirectory) or PrintError("Image Directory", "<B>Cannot open directory for reading: " . $CurrentImageDirectory."</b>", "$php_errormsg");
		
	?>
<script>
	var fileWin

	function SelectImage(image) {
			window.opener.foo.document.execCommand("InsertImage",false,image);
			self.close()
	}

	function ViewFile(fileName) {
		
		if (fileWin) { fileWin.close() }

		var leftPos = (screen.availWidth-700) / 2
		var topPos = (screen.availHeight-500) / 2 
	 	fileWin = window.open(fileName,'fileWindow','width=500,height=400,scrollbars=yes,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
		fileWin.focus()
		fileWin.location.reload(true);
	}
</script>
	<FORM METHOD=POST>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="15"><img src="wde/1x1.gif" width="15" height="1"></td>
		<td class="heading1">Image Manager</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td class="body">Images - View, Insert or Upload</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td class="body">&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td class="body">
		Current Working Directory: <?php echo "User Directory"; ?><br><br>
		  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="bevel1">
	  		<tr>
			  <td>&nbsp;&nbsp;Editable Content</td>
			</tr>
		  </table>
		</td>
	  </tr>
	  <tr>
		<td colspan="2"><img src="wde/1x1.gif" width="1" height="10"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td class="body">
		<table border="0" cellspacing="0" cellpadding="0" width="98%" class="bevel2">
		<tr><td colspan=8 align=center><table width=98% border=0 cellspacing=0 cellpadding=10><tr><br>
		
		<?php
		
		// Display image files 
		$x = 0;

			// Display Files here
			rewinddir($objFolder);
			
			while($file = readdir($objFolder))
			{
				echo $CurrentDirectory;
				$arrExt = explode(".", $CurrentDirectory . "/" . $file);
				$extension = $arrExt[sizeof($arrExt)-1];
					
				if(($extension == "gif") || ($extension == "GIF") || ($extension == "jpg") || ($extension == "JPG") || ($extension == "jpeg") || ($extension == "JPEG") || ($extension == "png") || ($extension == "PNG"))
				{
				?>
					<td width=25%>
						<table border=0 cellspacing=0 cellpadding=0 width=100%>
							<tr>
								<td colspan=2 class=body><?php echo $file; ?></td>
							</tr>
							<tr>
								<td width=50><img border=1 src="<?php echo $WebsiteURL."/images/$file"; ?>" width=50 height=50>&nbsp;</td>
								<td width=200><a href="javascript:ViewFile('<?php echo $WebsiteURL."/images/".$file; ?>')" class=bodylink title="View image: '<?php echo $file; ?>'">View</a><br><a href='javascript:SelectImage("<?php echo $WebsiteURL."/images/".$file; ?>")' class=bodylink title="Insert image: '<?php echo $file; ?>' into your page">Insert</a></td></tr><tr><td colspan=2 class=body><?php echo filesize($CurrentImageDirectory . "/" . $file); ?> bytes</td>
							</tr>
						</table></td>
				<?php
					
					$x++;
					if($x == 4)
					{
						echo "</tr><tr>";
						$x = 0;
					}
				}
			}
		?>
		
			</tr></table></td></tr>
		</table>
		</td>
		</tr>
		<tr>
			<td colspan="2"><img src="wde/1x1.gif" width="1" height="10"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<table width=98% cellpadding=0 cellspacing=0 border=0>
				<tr>
				<td width=100><input type=submit name="wde" value="Upload Image" class="Text90"></td>
				<td><input type=button name="cancel" value="Cancel" class="Text70" onClick=javascript:window.close()></td>
				</tr>
			</td>
	  	</tr>
		</table>
		</form>
	<?php
	}

function showWDE($HTMLCode, $width, $height, $imageDir, $mode, $Website) {
global $HTTP_SESSION_VARS;

$height = $height - 85;
$GLOBALS['ImageDir'] = $imageDir;
$GLOBALS['Website'] = $Website;
?>
<script>
<?php include("wde/script.inc"); ?>
</script>
<?php include("wde/toolbar.inc"); ?>
<!-- align menu -->
<DIV ID="alignMenu" STYLE="display:none;">
<input type="image" src=wde/1x1.gif width=1 height=1 HIDEFOCUS><input unselectable="on" type="image" border="0" src="wde/button_align_left.gif" width="21" height="20" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" onClick='parent.doCommand("JustifyLeft");parent.foo.focus()' title="Align Left" style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;"><input unselectable="on" type="image" border="0" src="wde/button_align_center.gif" width="21" height="20" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" onClick='parent.doCommand("JustifyCenter");parent.foo.focus();' title="Align Center" style="BORDER-LEFT: threedface 1px solid;	BORDER-RIGHT: threedface 1px solid;	BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;"><input unselectable="on" type="image" border="0" src="wde/button_align_right.gif" width="21" height="20" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" onClick='parent.doCommand("JustifyRight");parent.foo.focus();' title="Align Right" style="BORDER-LEFT: threedface 1px solid;	BORDER-RIGHT: threedface 1px solid;	BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;">
</DIV>
<!-- end align menu -->
<!-- color menu -->
<DIV ID="colorMenu" STYLE="display:none;">
<table cellpadding="3" cellspacing="1" border="1" bordercolor="#333333" style="cursor: hand;font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 4px">
  <tr>
    <td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF0000">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFFF00">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#00FF00">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#00FFFF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#0000FF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF00FF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFFFFF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F5F5F5">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#DCDCDC">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFFAFA">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#D3D3D3">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#C0C0C0">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#A9A9A9">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#808080">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#696969">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#000000">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#2F4F4F">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#708090">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#778899">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#4682B4">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#4169E1">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#6495ED">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#B0C4DE">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#7B68EE">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#6A5ACD">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#483D8B">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#191970">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#000080">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#00008B">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#0000CD">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#1E90FF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#00BFFF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#87CEFA">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#87CEEB">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#ADD8E6">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#B0E0E6">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F0FFFF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#E0FFFF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#AFEEEE">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#00CED1">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#5F9EA0">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#48D1CC">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#00FFFF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#40E0D0">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#20B2AA">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#008B8B">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#008080">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#7FFFD4">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#66CDAA">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#8FBC8F">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#3CB371">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#2E8B57">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#006400">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#008000">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#228B22">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#32CD32">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#00FF00">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#7FFF00">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#7CFC00">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#ADFF2F">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#98FB98">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#90EE90">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#00FF7F">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#00FA9A">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#556B2F">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#6B8E23">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#808000">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#BDB76B">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#B8860B">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#DAA520">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFD700">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F0E68C">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#EEE8AA">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFEBCD">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFE4B5">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F5DEB3">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFDEAD">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#DEB887">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#D2B48C">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#BC8F8F">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#A0522D">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#8B4513">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#D2691E">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#CD853F">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F4A460">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#8B0000">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#800000">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#A52A2A">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#B22222">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#CD5C5C">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F08080">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FA8072">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#E9967A">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFA07A">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF7F50">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF6347">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF8C00">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFA500">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF4500">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#DC143C">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF0000">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF1493">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF00FF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FF69B4">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFB6C1">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFC0CB">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#DB7093">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#C71585">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#800080">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#8B008B">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#9370DB">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#8A2BE2">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#4B0082">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#9400D3">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#9932CC">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#BA55D3">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#DA70D6">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#EE82EE">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#DDA0DD">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#D8BFD8">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#E6E6FA">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F8F8FF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F0F8FF">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F5FFFA">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#F0FFF0">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FAFAD2">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFFACD">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFF8DC">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFFFE0">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFFFF0">&nbsp;</td>
  </tr>
  <tr>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFFAF0">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FAF0E6">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FDF5E6">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FAEBD7">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFE4C4">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFDAB9">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFEFD5">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFF5EE">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFF0F5">&nbsp;</td>
	<td onClick="color.value=this.style.backgroundColor.toUpperCase(); color.style.backgroundColor = this.style.backgroundColor" style="background-color:#FFE4E1">&nbsp;</td>
  </tr>
  <tr>
	<td style="background-color:#FFFAF0" colspan="10">
	  <input type="text" name="color" style="font-family: verdana; font-size:9px; width=60px">&nbsp;<input type="button" value="Go" style="font-family: verdana; font-size:9px; width=40px; cursor:hand" onClick="parent.foo.document.execCommand('ForeColor',false,color.value);">
	</td>
  </tr>
</table>
</DIV>
<!-- end color menu -->
<!-- table menu -->
<DIV ID="tableMenu" STYLE="display:none;">
  <table border="0" cellspacing="1" cellpadding="0" bordercolor="#999999" bgcolor="#999999">
    <tr>
	  <td bgcolor="#CCCCCC">
<input id=insertTable1 unselectable="on" type="image" border="0" src="wde/button_table.gif" width="21" height="20" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" onClick="parent.ShowInsertTable()" title="Insert Table" style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;"></td>
	  <td bgcolor="#CCCCCC">
<input id=modifyTable onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Modify Table Properties" onClick=parent.ModifyTable() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_modify_table.gif" border=0 unselectable="on" style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;"></td>
	  <td bgcolor="#CCCCCC">
<input id=modifyCell onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Modify Cell Properties" onClick=parent.ModifyCell() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_modify_cell.gif" border=0 unselectable="on" style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;"></td></tr>
    <tr bgcolor="#CCCCCC">
	  <td height="23">
<input id=rowAbove style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert Row Above" onClick=parent.InsertRowAbove() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_insert_row_above.gif" border=0 unselectable="on"></td>
	  <td height="23">
<input id=rowBelow style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert Row Below" onClick=parent.InsertRowBelow() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_insert_row_below.gif" border=0 unselectable="on"></td>
	  <td height="23">
<input id=deleteRow style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Delete Row" onClick=parent.DeleteRow() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_delete_row.gif" border=0 unselectable="on"></td></tr>
    <tr bgcolor="#CCCCCC">
	  <td>
<input id=colAfter style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert Column After" onClick=parent.InsertColAfter() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_insert_col_after.gif" border=0 unselectable="on"></td>
	  <td>
<input id=colBefore style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert Column Before" onClick=parent.InsertColBefore() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_insert_col_before.gif" border=0 unselectable="on"></td>
	  <td>
<input id=deleteCol style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Delete Column" onClick=parent.DeleteCol() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_delete_col.gif" border=0 unselectable="on"></td></tr>
    <tr>
	  <td bgcolor="#CCCCCC">
<input id=increaseSpan style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Increase Column Span" onClick=parent.IncreaseColspan() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_increase_colspan.gif" border=0 unselectable="on"></td>
	  <td bgcolor="#CCCCCC">
<input id=decreaseSpan style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Decrease Column Span" onClick=parent.DecreaseColspan() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_decrease_colspan.gif" border=0 unselectable="on"></td>
	  <td bgcolor="D4D0C8"><input type="image" src=wde/1x1.gif width=1 height=1 tabindex=1 HIDEFOCUS></td></tr>
  </table>
</div>
<!-- end table menu -->
<!-- form menu -->
<DIV ID="formMenu" STYLE="display:none;">
  <table border="0" cellspacing="1" cellpadding="0" bordercolor="#999999" bgcolor="#999999">
	<tr><td bgcolor="#CCCCCC"><input style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert Form" onClick=parent.insertForm() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_form.gif" border=0 unselectable="on"></td>
	  <td bgcolor="#CCCCCC"><input id="modifyForm1" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Modify Form Properties" onClick=parent.modifyForm() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_modify_form.gif" border=0 unselectable="on" style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;"></td>
	  <td bgcolor="D4D0C8"><input type="image" src=wde/1x1.gif width=1 height=1 tabindex=1 HIDEFOCUS></td></tr>
	<tr bgcolor="#CCCCCC"><td><input id=textfield style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert / Modify Text field" onClick=parent.doTextField() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_textfield.gif" border=0 unselectable="on"></td>
	  <td><input id=textarea style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert / Modify Text Area" onClick=parent.doTextArea() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_textarea.gif" border=0 unselectable="on"></td>
	  <td><input id=hidden style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert / Modify Hidden Field" onClick=parent.doHidden() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_hidden.gif" border=0 unselectable="on"></td></tr>
	<tr bgcolor="#CCCCCC"><td><input id-button style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert / Modify Button" onClick=parent.doButton() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_button.gif" border=0 unselectable="on"></td>
	  <td><input id=checkbox style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert / Modify Checkbox" onClick=parent.doCheckbox() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_checkbox.gif" border=0 unselectable="on"></td>
	  <td><input id=radio style="BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseDown=parent.button_down(this); onMouseOver=parent.button_over(this); title="Insert / Modify Radio Button" onClick=parent.doRadio() onMouseOut=parent.button_out(this); type=image width="21" height="20" src="wde/button_radio.gif" border=0 unselectable="on"></td>
	</tr>
  </table>
</div>
<!-- formMenu -->
<form name=wdeForm method=post>
<input name=wdeOutput type=hidden>
</form>
<?php
}
?>
