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
<table width="100%" height="160"  border="0" cellpadding="3" cellspacing="1" bgcolor="FB8233">
  <form name="form1" method="post" action="content_function.php"><tr> 
    <td height="25" background="../images/content_bg.gif" bgcolor="666666"><strong>: 
      : Choose Content Style on Position : </strong>
      
        <select name="position" id="position">
          <option value="first">First position</option>
          <option value="last">Last position</option>
        </select>
        <input name="stype" type="hidden" id="stype" value="">
        <input name="Flag" type="hidden" id="Flag" value="Choose">
        <input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>"></td>
  </tr></form>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td width="50%"><a href="#editor" onClick="choose('editor')"><img src="../images/text_rich.gif" width="24" height="24" border="0" align="absmiddle"> 
            <strong>Editor (Free Style)</strong></a></td>
          <td width="50%"><a href="#coding" onClick="choose('coding')"><img src="../images/text.gif" width="24" height="24" border="0" align="absmiddle"> 
            <strong>Coding</strong></a><strong> </strong></td>
        </tr>
        <tr>
          <td><img src="../images/column-chart.gif" width="24" height="24" align="absmiddle"> 
            <strong>Graph</strong> </td>
          <td><img src="../images/contract1.gif" width="24" height="24" align="absmiddle"> 
            <strong>Article Management</strong></td>
        </tr>
        <tr>
          <td><img src="../images/flash.gif" width="24" height="24" align="absmiddle"> 
            <strong>Flash file</strong></td>
          <td><img src="../images/document_music.gif" width="24" height="24" align="absmiddle"> 
            <strong>Multimedia file</strong></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="25" background="../images/bg.gif" bgcolor="#FEDFCB"><strong><a href="content_properties.php?filename=<?php echo $_GET["filename"]; ?>">&lt;&lt; 
      Back</a></strong></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
