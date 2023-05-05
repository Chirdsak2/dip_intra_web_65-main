<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$path_cal = "";
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../../css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
  <tr> 
    <td valign="top"  >
	<table width="100%" border="0">
  <tr>
    <td height="30" background="../../images/../images/m_bg.gif"><STRONG><IMG height="7" src="../../images/arrow_r.gif" width="7" align="absMiddle"> Sitemap</STRONG> </td>
    </tr>
</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<?
	$sql = "select * from menu_list where m_show = 'Y'";
	$query = $db->query($sql);
	while($rec = $db->db_fetch_array($query)){
	$name = $rec[m_realname];
	if(empty($rec[m_realname])){
	$name = $rec[m_name];
	}
	?>
  <tr>
    <td height="20"><strong> <?=$name?></strong>     </td>
  </tr>
  <?
  $sql_prop = "select * from menu_properties where m_id = '".$rec[m_id]."' and mp_show = 'Y'";
  $query_prop = $db->query($sql_prop);
   while($rec_prop = $db->db_fetch_array($query_prop)){
   $name_prop = $rec_prop[mp_realname];
   	if(empty($rec_prop[mp_realname])){
	$name_prop = $rec_prop[mp_name];
	}
  ?>
  <tr>
    <td height="20" ><a href="<?php echo $rec_prop["Glink"]?>" target="<?php $rec_prop["Gtarget"]?>"><?=$name_prop?>
    </a></td>
    </tr>
  <? } } ?>
</table>
</td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
