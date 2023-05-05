<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


$sql = $db->query("SELECT m_id,m_name FROM menu_list ");

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

</head>
<body>
  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <form name="form1" method="post" action="menu_sitemap_function.php">
	<tr bgcolor="#FFFFFF" > 
      <td ><strong>เลือกชุดเมนูเพื่อแสดง</strong> 
        <input type="submit" name="Submit" value="  บันทึก  ">
        <hr size="1" noshade>
        </td>
    </tr>
    <?php
	$i=1;
	$txt = "";
  while($U = $db->db_fetch_array($sql)){
  $sql_check = $db->query("SELECT s_id FROM menu_sitemap_list WHERE s_id ='".$_GET["sid"]."' and m_id = '".$U["m_id"]."' and sm_active ='Y'");

  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><input type="checkbox" name="chk[]" value="<?php echo $U["m_id"]; ?>"    <?php if($db->db_num_rows($sql_check)){ echo "checked"; } ?>><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; 
	  <?php echo $U["m_name"]; ?>
        </td>
    </tr>
    <?php 
	$i++;

  }
  ?><input type="hidden" name="numrow" value="<?php echo $i; ?>">
  <tr bgcolor="#FFFFFF" > 
      <td ><hr size="1" noshade>
        <strong>เลือกชุดเมนูเพื่อแสดง</strong> 
        <input type="submit" name="Submit" value="  บันทึก  ">
        <input name="sid" type="hidden" id="sid" value="<?php echo $_GET["sid"]; ?>">
		<input type="hidden" name="Flag" value="Save">
</td>
    </tr>
  </form>
  </table>
</body>
</html>
<?php $db->db_close(); ?>
