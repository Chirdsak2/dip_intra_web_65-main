<?php
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
include("wde/wde.php");
if($_GET["s"] == "1"){
$sql_file = $db->query("SELECT d_top_content FROM design_list WHERE d_id = '".$_GET["d_id"]."'  ");
$R = $db->db_fetch_row($sql_file);
}
if($_GET["s"] == "2"){
$sql_file = $db->query("SELECT d_bottom_content FROM design_list WHERE d_id = '".$_GET["d_id"]."'  ");
$R = $db->db_fetch_row($sql_file);
}
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function chkToggle(){
if(toggle == "off" ){
toggleBorders()
}
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#666666">
<tr>
      
    <td height="20" align="left" bgcolor="F3F3EE"> <img src="../../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> Design Editor
    </td>
  </tr>
  <tr>
    <td height="1" bgcolor="AAAAAA"></td>
  </tr>
      <tr>
    <td height="1" bgcolor="716F64"></td>
  </tr>
<tr> 
    <td align="center" bgcolor="#F7F7F7"><?php
$HtmlCode = ereg_replace("\n","",$R[0]);
$HtmlCode = ereg_replace("\r","",$HtmlCode);
$HTMLContent = addslashes($HtmlCode);
$imageDir = "images/";
$width = "100%";
$height = "100%";
$mode = "0";
showWDE($HTMLContent,$width,$height,$imageDir,$mode,"../ewt/".$_SESSION["EWT_SUSER"]);
?></td>
  </tr>
<form name="frmSaveContents" method="post" action="../../LookMgt/look_function.php"  onSubmit="document.frmSaveContents.contentHtml.value=document.frames('foo').document.body.innerHTML;">    
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
      <td height="20" align="left" bgcolor="#FFFFFF">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5" background="../../images/content_bg_line.gif"></td>
            <td align="right">
        <input name="imageField" type="image" onClick="chkToggle();" src="../../images/disk_blue.gif" align="top" width="32" height="32" border="0">
 <strong><font size="2" face="Tahoma">Save</font></strong> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="d_id" type="hidden" id="d_id" value="<?php echo $_GET["d_id"]; ?>"><input name="s" type="hidden" id="s" value="<?php echo $_GET["s"]; ?>"><input type="hidden" name="contentHtml" value="<?php echo $HTTP_POST_VARS["wdeOutput"]?>">
        <input name="Flag" type="hidden" id="Flag" value="SaveEditor"></td>
          </tr>
        </table></td>
  </tr>
    </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
