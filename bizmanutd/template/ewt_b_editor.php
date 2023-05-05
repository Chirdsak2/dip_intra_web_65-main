<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("wde/wde.php");
$sql_file = $db->query("SELECT * FROM block WHERE BID = '".$_GET["blockname"]."' ");
$R = $db->db_fetch_array($sql_file);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript">
function chkToggle(){
if(toggle == "off" ){
toggleBorders()
}
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666">
<tr>
      
    <td height="20" bgcolor="#FFFFFF"><font size="2" face="Tahoma"><strong>WebBlock 
      Name : <font color="#FF3300"><?php echo $R["block_name"]; ?></font></strong> 
      </font></td>
    </tr>
  <tr> 
    <td align="center" bgcolor="#F7F7F7">
      <?php
$HtmlCode = ereg_replace("\n","",$R["block_file"]);
$HtmlCode = ereg_replace("\r","",$HtmlCode);
$HTMLContent = addslashes($HtmlCode);
$imageDir = "images/";
$width = "100%";
$height = "100%";
$mode = "0";
showWDE($HTMLContent,$width,$height,$imageDir,$mode,"../ewt/".$_SESSION["EWT_SUSER"]);
?>
    </td>
  </tr>
  <form name="frmSaveContents" method="post" action="../../BlockMgt/block_function.php"  onSubmit="document.frmSaveContents.contentHtml.value=document.frames('foo').document.body.innerHTML;">
    <tr> 
      <td height="20" align="right" bgcolor="#FFFFFF"><a href="#back" onClick="self.location.href='ewt_b_preview.php?blockname=<?php echo $_GET["blockname"]; ?>';"><img src="../../images/nav_left_green.gif" width="32" height="32" border="0" align="absmiddle"></a><strong><font size="2" face="Tahoma"> 
        Back</font></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input name="imageField" type="image" onClick="chkToggle();" src="../../images/disk_blue.gif" align="middle" width="32" height="32" border="0"> 
        <strong><font size="2" face="Tahoma">Save</font></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="blockname" type="hidden" id="blockname" value="<?php echo $_GET["blockname"]; ?>">
        <input type="hidden" name="contentHtml" value="<?php echo $HTTP_POST_VARS["wdeOutput"]?>"> 
        <input name="Flag" type="hidden" id="Flag" value="SaveEditor"></td>
    </tr>
    
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
