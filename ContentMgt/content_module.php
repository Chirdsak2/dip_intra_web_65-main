<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function choose(c){
document.form1.stype.value = c;
form1.submit();
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="160"  border="0" cellpadding="2" cellspacing="1" bgcolor="FB8233">
  <form name="form1" method="post" action="content_function.php"><tr> 
      <td height="24" background="../images/bg.gif" bgcolor="666666">
        <table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td width="56%"><strong>: 
        : Choose Module</strong></td>
            <td width="44%" align="right"><strong><a href="content_properties.php?filename=<?php echo $_GET["filename"]; ?>">&lt;&lt; 
      Back</a></strong></td>
          </tr>
        </table></td>
  </tr></form>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="33%"><img src="../images/windows.gif" width="24" height="24" border="0" align="absmiddle"> 
            <strong> Popup Page</strong></td>
          <td width="33%"><a href="../FileMgt/file_css.php?filename=<?php echo $_GET["filename"]; ?>" target="iframe_data"><img src="../images/font.gif" width="24" height="24" border="0" align="absmiddle"> 
            <strong>Cascadind Style Sheet File</strong></a></td>
          <td width="33%"><img src="../images/mail_write.gif" width="24" height="24" border="0" align="absmiddle"> 
            <strong>Send to friend</strong></td>
        </tr>
        <tr> 
          <td><img src="../images/text_loudspeaker.gif" width="24" height="24" align="absmiddle"> 
            <strong>Sound on Page</strong></td>
          <td><img src="../images/document_lock.gif" width="24" height="24" align="absmiddle"> 
            <strong>Permission on this page</strong></td>
          <td><strong><img src="../images/star_yellow_preferences.gif" width="24" height="24" border="0" align="absmiddle"> Add 
            to Favorites</strong></td>
        </tr>
        <tr> 
          <td><img src="../images/selection_replace.gif" width="24" height="24" align="absmiddle"> 
            <strong>Change Design</strong></td>
          <td><img src="../images/question_and_answer.gif" width="24" height="24" align="absmiddle"> 
            <strong>Webboard on page</strong></td>
          <td><strong><img src="../images/preferences.gif" width="24" height="24" border="0" align="absmiddle"> Vote 
            this page</strong></td>
        </tr>
        <tr> 
          <td><img src="../images/pie-chart.gif" width="24" height="24" border="0" align="absmiddle"> 
            <strong>Poll </strong></td>
          <td><strong><img src="../images/form_red.gif" width="24" height="24" border="0" align="absmiddle"> Inquiry 
            Form</strong></td>
          <td><strong><img src="../images/magic-wand2.gif" width="24" height="24" border="0" align="absmiddle"> Javascript 
            Effect</strong></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
