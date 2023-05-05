<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
set_time_limit (-1);
function DUMP_DB($tb){
global $db,$EWT_DB_NAME;
$i=0;
$sql = "select * from news_view order by id_view ASC limit 0,500 ";
$query = $db->query($sql);
$numrows = $db->db_num_rows($query);
if($numrows>0){
while($R = $db->db_fetch_array($query)){
	$id_view = $R["id_view"];
	$news_id = $R["news_id"];
	$ip_view = $R["ip_view"];
	$date_view = $R["date_view"];
	$time_view = $R["time_view"];
	$id_member = $R["id_member"];
	
	$db->query("USE db_00_stat_visitor");
	
	$db->query("INSERT INTO ".$tb." (id_view,
														news_id,
														ip_view,
														date_view,
														time_view,
														id_member
															) VALUES (
															'".$R["id_view"]."',
														'".$R["news_id"]."',
														'".$R["ip_view"]."',
														'".$R["date_view"]."',
														'".$R["time_view"]."',
														'".$R["id_member"]."'
															)");
	$db->query("USE ".$EWT_DB_NAME);
	//ลบต้นทางออก
	$db->query("DELETE FROM news_view WHERE id_view = '".$R["id_view"]."' ");
	$i++;
	if($i=='500'){	DUMP_DB($tb);	}
	
}//end while
?><script language="javascript">  
		alert('เรียบร้อยแล้ว');
		location.href="site_index_article.php"; 
	</script><?php
}


}
if($_POST["flag"]=='DUMP'){
//add data
$i = 0;
$sql = "select * from news_view order by id_view ASC limit 0,500 ";
$query = $db->query($sql);
$numrows = $db->db_num_rows($query);
	if($numrows>0){
	$db->query("USE db_00_stat_visitor");
//add table listname
$list_name = $_POST["name_list"];
$list_dbname =  "news_view_".date('YmdHis');
$list_site = $EWT_FOLDER_USER;
$list_type = "news_view";
$db->query("INSERT list_name (list_name,list_dbname,list_site,list_type) VALUES ('".$list_name."','".$list_dbname."','".$list_site."','".$list_type."')");
//สร้าง table ใหม่
$db->query("CREATE TABLE `".$list_dbname."` (                                                                 
             `id_view` int(11) NOT NULL AUTO_INCREMENT,                                               
             `news_id` int(11) DEFAULT NULL,                                                          
             `ip_view` varchar(255) DEFAULT NULL,                                                     
             `date_view` date DEFAULT NULL,                                                           
             `time_view` time DEFAULT NULL,                                                           
             `id_member` int(8) NOT NULL DEFAULT '0',                                                 
             PRIMARY KEY (`id_view`)                                                                  
           ) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 11264 kB'");
			$db->query("USE ".$EWT_DB_NAME);
	DUMP_DB($list_dbname);
	}else{
	?><script language="javascript">  
		alert('ไม่มีข้อมูลกรุณาตรวจสอบ');
		location.href="site_index_article.php"; 
	</script><?php
	}
}
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
  
    <tr> 
      <td valign="top"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">สถิติการเข้าเว็บไซต์ย้อนหลัง</span> </td>
  </tr>
</table></td>
    </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp;&nbsp;&nbsp;<a href="add_article.php" ><img src="../theme/main_theme/g_add.gif" alt="<?php echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_general_add;?></a> &nbsp;
        <hr>
    </td>
  </tr>
</table>
<form name="form1" method="POST" action="add_article.php">
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" >
    <td height="30" colspan="2" class="ewttablehead">บริหารสถิติการข่าว/บทความ(Article Stat) </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="38%">ชื่อปีที่จัดเก็บ : </td>
    <td width="62%"><input name="name_list" type="text" size="40"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="Submit">
        <input type="reset" name="Submit3" value="Reset">
        <input type="hidden" name="flag" value="DUMP"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>
