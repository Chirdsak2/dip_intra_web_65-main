<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql_group = $db->query("SELECT DISTINCT(s_user) FROM share_content ORDER BY s_user ASC");
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
				function hlah(c){
				var n = document.form1.num.value;
							document.getElementById('ah'+n).removeAttribute("style");
							document.getElementById('ah'+c).style.backgroundColor = "#B2B4BF";
							document.form1.num.value = c;
			}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="9D9DA1">
  <tr> 
    <td valign="top" bgcolor="#FFFFFF">
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
          <td><img src="../images/workplace.gif" width="20" height="20" border="0" align="absmiddle"> 
            <strong><a id="ah0" href="#"  onClick="hlah('0')">My Website</a></strong></td>
  </tr>
  <?php
  $i = 1;
  	while($R = $db->db_fetch_array($sql_group)){
  ?>
        <tr> 
          <td>
		<img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><img src="../images/share.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;&nbsp;<a id="ah<?php echo $i; ?>" href="share_view.php?site=<?php echo $R[0]; ?>&filename=<?php echo $_GET["filename"]; ?>" onClick="hlah('<?php echo $i; ?>')" target="SmainFrame"><?php echo $R[0]; ?></a>  
          </td>
  </tr>
  <?php $i++; } ?>
<form name="form1"><input type="hidden" name="num" value="0"></form>
</table>
</td>
  </tr>
</table>

</body>
</html>
<?php $db->db_close(); ?>
