<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->write_log("view","Site Design","เข้าสู่ Module Site Design");
//$sql_menu = $db->query("SELECT * FROM design_list  ORDER BY d_name ASC ");
$sql_menu = $db->query("
SELECT d_id,d_name,tm_id,tm_module 
FROM design_list LEFT OUTER JOIN  template_module ON  d_id = tm_did AND tm_module = '$_GET[mod]'
WHERE tm_id IS NULL
ORDER BY d_name ASC");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
		function add_template(mod,did){
			self.opener.document.all.Flag.value='Add';
			self.opener.document.all.did.value=did;
			self.opener.document.all.mod.value=mod;
			self.opener.document.form.submit();
		}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr bgcolor="#E6E6E6" > 
    <td width="10%" align="center"><strong>Add</strong></td>
    <td width="90%"><strong>Template name</strong></td>
  </tr>
  <?php
		if($db->db_num_rows($sql_menu) > 0){
		while($R=$db->db_fetch_array($sql_menu)){
		?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td align="center"><a href="#edit" onClick="add_template('<?php echo $_GET[mod];?>','<?php echo $R["d_id"]; ?>')"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle" alt="เพิ่ม Template"></a></td>
    <td><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> <?php echo $R["d_name"]; ?> </td>
  </tr>
  <?php
		}
		}else{
		?>
  <tr align="center" bgcolor="#FFFFFF" > 
    <td colspan="5"><strong><font color="#FF0000">Design not found.</font></strong></td>
  </tr>
  <?php } ?>
</table>

</body>
</html>
<?php $db->db_close(); ?>
