<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql_group = $db->query("SELECT * FROM share_content WHERE s_user = '".$_GET["site"]."' ORDER BY s_user ASC");
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function preview(c){
		self.top.SbottomFrame.location.href = "../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_share.php?inc="+c;
	}
	function choose(c){
		document.form1.inc.value = c;
		form1.submit();
		top.close();
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="9D9DA1">
<form name="form1" method="post" action="content_function.php" target="save_function">
<input type="hidden" name="Flag" value="SetShare">
<input type="hidden" name = "filename" value = "<?php echo $_GET["filename"]; ?>">
<input type="hidden" name = "inc" >
</form>
  <tr align="center" bgcolor="#E7E7E7"> 
    <td width="50%" height="25"><strong>Block Name</strong></td>
    <td width="30%"><strong>Last Update</strong></td>
    <td width="10%"><strong>View</strong></td>
    <td width="10%"><strong>Choose</strong></td>
  </tr>
  <?php 
    	while($R = $db->db_fetch_array($sql_group)){
   ?>
  <tr> 
    <td valign="top" bgcolor="#FFFFFF"><?php echo $R["s_html"]; ?></td>
    <td valign="top" bgcolor="#FFFFFF"><?php echo $R["s_update"]; ?></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><a href="#preview" onClick="preview('<?php echo $R["s_user"]; ?>_ewt_<?php echo $R["s_bid"]; ?>')"><img src="../images/document_view.gif" width="24" height="24" border="0"></a></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><a href="#choose" onClick="choose('<?php echo $R["s_user"]; ?>_ewt_<?php echo $R["s_bid"]; ?>')"><img src="../images/article_back.gif" width="20" height="20" border="0"></a></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php $db->db_close(); ?>
