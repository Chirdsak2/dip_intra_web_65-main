<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title>Stat</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript"  type="text/javascript" src="lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="lib_carendar/calendar-th.js"></script>
<link href="lib_carendar/style_calendar.css" rel="stylesheet" type="text/css">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >

<table width="96%" border="0" align="center" cellpadding="5" cellspacing="0">
  <form name="form1" method="get" action="site_index_view2.php">
    <tr> 
      <td valign="top"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">สถิติการข่าว/บทความ(Article Stat)ย้อนหลัง</span> </td>
  </tr>
</table></td>
    </tr>
  </form>
</table>

<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp;&nbsp;<a href="add_article.php" ><img src="../theme/main_theme/g_add.gif" alt="<?php echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_general_add;?></a> &nbsp;
        <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td >รายการ</td>
  </tr>
  <?php
  $db->query("USE db_00_stat_visitor");
  $sql = "select * from list_name where list_type ='news_view' and list_site = '".$EWT_FOLDER_USER."' order by list_id ASC";
  $query = $db->query($sql);
  while($R = $db->db_fetch_array($query)){
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><nobr><a href="article_admin_stat3.php?db=<?php echo base64_encode ( $R["list_id"]."EX".$R["list_dbname"]."EX"); ?>"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" align="absmiddle" alt="ดูข้อมูล"></a> </nobr></td>
    <td><?php echo $R["list_name"];?></td>
  </tr>
  <?php } ?> 
  <tr align="right" bgcolor="#FFFFFF"> 
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
