<?php
include("../lib/permission1.php");
include("../lib/include.php");
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
if($_POST["Flag"] == "SetBg"){ ?>
<script language="javascript">
	<?php echo $_POST["o_value"]; ?> = "<?php echo $_POST["objfile"]; ?>";
	<?php echo $_POST["o_preview"]; ?>.style.background = "url(<?php echo $Globals_Dir.$_POST["objfile"]; ?>)";
	self.close();
</script>
<?php }elseif($_POST["Flag"] == "SetPic"){ ?>
<script language="javascript">
	<?php echo $_POST["o_value"]; ?> = "<?php echo $_POST["objfile"]; ?>";
	<?php echo $_POST["o_preview"]; ?>.src = "<?php echo $Globals_Dir.$_POST["objfile"]; ?>";
	self.close();
</script>
<?php }elseif($_POST["Flag"] == "Link"){ ?>
<script language="javascript">
	<?php echo $_POST["o_value"]; ?> = "<?php echo $_POST["objfile"]; ?>";
	self.close();
</script>
<?php }else{
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<form name="formTodo" method="post" target="save_function" action="../ContentMgt/content_function.php">
<?php
if($_POST["stype"] == "images"){
$CurrentFile = $Globals_Dir.$_POST["objfile"];
$size = @getimagesize($CurrentFile);
?>
  <table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1">
    <tr> 
      <td height="30" bgcolor="#E7E7E7"><strong>Images Properties : <?php echo $_POST["objfile"]; ?></strong></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#F7F7F7">width : 
        <input name="width" type="text" id="width" value="<?php echo $size[0]; ?>" size="5" onBlur="prview.document.all.ppreview.width=this.value">
        Height : 
        <input name="height" type="text" id="height" value="<?php echo $size[1]; ?>" size="5" onBlur="prview.document.all.ppreview.height=this.value">
        Align : 
        <select name="align" onChange="prview.document.all.dpreview.style.textAlign = this.value;">
          <option value="left">Left</option>
          <option value="center" selected>Center</option>
          <option value="right">Right</option>
        </select>
		Boder : <input name="border" type="text" size="5">
        <input type="button" name="Button" value="  OK  " onClick="formTodo.submit();self.close();"> </td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><iframe name="prview" src="module_preview.php?ftype=<?php echo $_POST["stype"]; ?>&fname=<?php echo $_POST["objfile"]; ?>" frameborder="0" width="100%" height="100%" scrolling="yes"></iframe></td>
    </tr>
  </table>
<?php 
}elseif($_POST["stype"] == "flash"){
$CurrentFile = $Globals_Dir.$_POST["objfile"];
$size = @getimagesize($CurrentFile);
?>
  <table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1">
    <tr> 
      <td height="30" bgcolor="#E7E7E7"><strong>Flash Properties : <?php echo $_POST["objfile"]; ?></strong></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#F7F7F7">width : 
        <input name="width" type="text" id="width" value="<?php echo $size[0]; ?>" size="5" onBlur="prview.document.all.ppreview.width=this.value">
        Height : 
        <input name="height" type="text" id="height" value="<?php echo $size[1]; ?>" size="5" onBlur="prview.document.all.ppreview.height=this.value">
        Align : 
        <select name="align" onChange="prview.document.all.dpreview.style.textAlign = this.value;">
          <option value="left">Left</option>
          <option value="center" selected>Center</option>
          <option value="right">Right</option>
        </select>
        <input type="button" name="Button" value="  OK  " onClick="formTodo.submit();self.close();"> </td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><iframe name="prview" src="module_preview.php?ftype=<?php echo $_POST["stype"]; ?>&fname=<?php echo $_POST["objfile"]; ?>" frameborder="0" width="100%" height="100%" scrolling="yes"></iframe></td>
    </tr>
  </table>
<?php }elseif($_POST["stype"] == "media"){
$CurrentFile = $Globals_Dir.$_POST["objfile"];
?>
  <table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1">
    <tr> 
      <td height="30" bgcolor="#E7E7E7"><strong>Media Properties : <?php echo $_POST["objfile"]; ?></strong></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#F7F7F7">width : 
        <input name="width" type="text" id="width" value="330" size="5" onBlur="document.all.ppreview.width=this.value">
        Height : 
        <input name="height" type="text" id="height" value="180" size="5" onBlur="document.all.ppreview.height=this.value">
        Align : 
        <select name="align" onChange="document.all.dpreview.style.textAlign = this.value;">
          <option value="left">Left</option>
          <option value="center" selected>Center</option>
          <option value="right">Right</option>
        </select>
        
        <input name="auto" type="checkbox" id="auto" value="1" checked>
        Auto Play  <input name="repeat" type="checkbox" id="repeat" value="1" checked>
        Auto Repeat 
        <input name="hide" type="checkbox" id="hide" value="Y">
        Hide this media <input type="button" name="Button" value="  OK  " onClick="formTodo.submit();self.close();"></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><div id="dpreview" align="center">
          <OBJECT id=ppreview height=180 width=330 classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95">
            <PARAM NAME="Filename" VALUE="<?php echo $CurrentFile; ?>">
            <param name="playCount" value="10">
            <param name="autoStart"  value="0">
			<embed type="application/x-mplayer2"
pluginspage="http://www.microsoft.com/Windows/Downloads/Contents/MediaPlayer/"
width="330" height="180" src="<?php echo $CurrentFile; ?>"
filename="<?php echo $CurrentFile; ?>" autostart="0" ></embed>
          </OBJECT>
        </div></td>
    </tr>
  </table>
<?php } ?>
        	
		<input name="stype" type="hidden" id="stype" value="<?php echo $_POST["stype"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="<?php echo $_POST["Flag"]; ?>">
        <input name="filename" type="hidden" id="filename" value="<?php echo $_POST["filename"]; ?>">
  <input type="hidden" name="objfile" value="<?php echo $_POST["objfile"]; ?>">
</form>
</body>
<?php } ?>
</html>
