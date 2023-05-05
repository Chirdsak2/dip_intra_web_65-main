<script>
function showMsg() {
	document.getElementById("popupMsg").style.visibility='visible'
}
</script>

<form ENCTYPE="multipart/form-data" method="post" action="$SCRIPTNAME?wde=UploadPage">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="15"><img src="wde/1x1.gif" width="15" height="1"></td>
	<td class="heading1">Upload</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">Click 'Browse' and locate the file you wish to add. Click 'OK' to upload your file. This may take a minute or two, depending on the size of the file and your internet connection. Click 'Cancel' to return to the previous screen.</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">
	  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="bevel1">
  		<tr>
		    <td>&nbsp;&nbsp;Add File from Local HardDrive</td>
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
	    <table border="0" cellspacing="0" cellpadding="5" width="98%" class="bevel2">
		  <tr>
		    <td class="body" width="20%">
			  <input type=file name="sourcefile" class="Text220" size="100">
			</td>
		  </tr>
	    </table>
	</td>
  </tr>
  <tr>
	<td colspan="2"><img src="wde/1x1.gif" width="1" height="10"></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>
	    <input type="submit" name="Submit" value="OK" class="Text50" onClick="javascript:showMsg()">
	    <input type="button" name="cancel" value="Cancel" class="Text50" onClick="javascript:history.back()">
	</td>
  </tr>
  
</table>
		<input type=hidden name="destn_filename">
</form>
<div name="pop" id="popupMsg" style="position:absolute; width:100%; height:31px; top:110px; z-index:1; visibility: hidden">
<center>
  <table width="200" border="0" cellspacing="0" cellpadding="5" class=bevel2>
	<tr>
	  <td valign=top><img src="wde/info.gif" width="18" height="18"></td>
	  <td class=body><b>Your file is being uploaded.<br>Please wait...</b></td>
	</tr>
  </table>
</center>
</div>
<img src="wde/info.gif" width="0" height="0">