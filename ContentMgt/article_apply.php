<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$sql_design = $db->query("SELECT text_id FROM article_apply WHERE a_id = '".$_GET["aid"]."' ");
$R = $db->db_fetch_row($sql_design);
$sql_list = $db->query("SELECT article_apply.a_id,article_group.c_name FROM article_group INNER JOIN article_apply ON article_group.c_id = article_apply.c_id  WHERE article_apply.text_id = '".$R[0]."' AND article_apply.a_id != '".$_GET["aid"]."'  AND article_apply.a_active = 'Y' ORDER BY article_apply.a_pos ASC");
	?>
<html>
<head>
<title>Article Management [<?php echo $_GET["filename"]; ?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" ><br>

<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1">
  <form name="form1" method="post" action="article_function.php"><tr>
      <td><hr size="1"><strong>Apply design to other group &gt;&gt;</strong> 
        <hr size="1">
      </td>
  </tr>
  <?php
  $i = 0;
   while($C = $db->db_fetch_row($sql_list)){ ?>
  <tr>
    <td>
        <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $C[0]; ?>"> <?php echo $C[1]; ?>
      </td>
  </tr>
  <?php $i++; } ?>
  <tr>
    <td><hr size="1"><input type="submit" name="Submit" value="Apply">
        <input type="button" name="Submit2" value="Cancel" onClick="self.close()">
        <input name="Flag" type="hidden" id="Flag" value="Apply">
        <input name="aid" type="hidden" id="aid" value="<?php echo $_GET["aid"]; ?>">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
        <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</form></table>
</body>
</html>
<?php $db->db_close(); ?>
