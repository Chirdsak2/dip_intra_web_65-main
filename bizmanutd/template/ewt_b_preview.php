<?php
session_start();
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

$sql_file = $db->query("SELECT * FROM block WHERE BID = '".$_GET["blockname"]."' ");
$R = $db->db_fetch_array($sql_file);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript">
		function edit_d(c){
		win2 = window.open('../../ContentMgt/block_update.php?B=' + c + '','BlockEdit','top=20,left=80,width=640,height=550,resizable=1,status=0,scrollbars=1');
		win2.focus();
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#D9D9CA">
  <tr> 
    <td height="30" bgcolor="F3F3EE"> <img src="<?php echo icon_block($R["block_type"]); ?>" width="20" height="20" align="absmiddle"> 
      <strong><font size="2" face="Tahoma">WebBlock Name : <font color="#FF3300"><?php echo $R["block_name"]; ?></font></font></strong> 
      &nbsp;&nbsp;<img src="../../images/bar_edit.gif" width="20" height="20" align="absmiddle" onClick="edit_d('<?php echo base64_encode("z".$R[BID]."z00"); ?>')"></td>
  </tr>
  <tr>
    <td align="center" valign="top" bgcolor="#FFFFFF" id="td<?php echo $R[BID]; ?>" >
<?php echo show_block($R[BID]); ?>
	</td>
  </tr>
</table>

</body>
</html>
<?php $db->db_close(); ?>
