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
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<script language="javascript1.2">
function select_web_mep(lang_setting_id, filename, filename_map) {
	window.opener.document.all.<?php echo $web?>.innerHTML=filename_map;
	window.opener.document.form1.<?php echo $web1?>.value = filename_map;
	window.close();
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000">
  <tr>
    <td width="20" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
 <?php
 $sql = "select * from lang_setting where lang_setting_id = '$select'";
 $query = $db->query($sql);
 $rec = $db->db_fetch_array($query);
 $db_name =$rec[user_info_db];
  $db->query("USE ".$db_name."");
  $sql2 = "select * from temp_index";
  $query = $db->query($sql2);
  while($rec2 = $db->db_fetch_array($query)){
 ?>
  <tr>
    <td bgcolor="#FFFFFF"><a href="##" onClick="select_web_mep('<?php echo $select?>','<?php echo $filename?>','<?php echo $rec2[filename]?>');">เลือก</a></td>
    <td bgcolor="#FFFFFF"><?php echo $rec2[filename]?></td>
  </tr>
  <?php }  $db->query("USE ".$_SESSION["EWT_SDB"]); ?>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>

</body>
</html>
