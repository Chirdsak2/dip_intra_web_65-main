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
$sql = "select * from stat_visitor order by sv_id ASC limit 0,500 ";
$query = $db->query($sql);
$numrows = $db->db_num_rows($query);
if($numrows>0){
while($R = $db->db_fetch_array($query)){
	$sv_id = $R["sv_id"];
	$sv_url = $R["sv_url"];
	$sv_visitor = $R["sv_visitor"];
	$sv_menu = $R["sv_menu"];
	$sv_ip = $R["sv_ip"];
	$sv_timestamp = $R["sv_timestamp"];
	$sv_date = $R["sv_date"];
	$sv_time = $R["sv_time"];
	$sv_country = $R["sv_country"];
	$sv_language = $R["sv_language"];
	$sv_new = $R["sv_new"];
	$sv_browser = $R["sv_browser"];
	$sv_resolution = $R["sv_resolution"];
	$sv_domain = $R["sv_domain"];
	$sv_isp = $R["sv_isp"];
	$sv_region = $R["sv_region"];
	$sv_city = $R["sv_city"];
	$sv_latitude = $R["sv_latitude"];
	$sv_longitude = $R["sv_longitude"];
	$sv_referer = $R["sv_referer"];
	$sv_search = $R["sv_search"];
	$sv_keyword = $R["sv_keyword"];
	$sv_os = $R["sv_os"];
	$sv_load = $R["sv_load"];
	$db->query("USE db_00_stat_visitor");
	
	$db->query("INSERT INTO ".$tb." (sv_id,
														sv_url,
														sv_visitor,
														sv_menu,
														sv_ip,
														sv_timestamp,
														sv_date,
														sv_time,
														sv_country,
														sv_language,
														sv_new,
														sv_browser,
														sv_resolution,
														sv_domain,
														sv_isp,
														sv_region,
														sv_city,
														sv_latitude,
														sv_referer,
														sv_search,
														sv_keyword,
														sv_os,
														sv_load
															) VALUES (
															'".$R["sv_id"]."',
														'".$R["sv_url"]."',
														'".$R["sv_visitor"]."',
														'".$R["sv_menu"]."',
														'".$R["sv_ip"]."',
														'".$R["sv_timestamp"]."',
														'".$R["sv_date"]."',
														'".$R["sv_time"]."',
														'".$R["sv_country"]."',
														'".$R["sv_language"]."',
														'".$R["sv_new"]."',
														'".$R["sv_browser"]."',
														'".$R["sv_resolution"]."',
														'".$R["sv_domain"]."',
														'".$R["sv_isp"]."',
														'".$R["sv_region"]."',
														'".$R["sv_city"]."',
														'".$R["sv_latitude"]."',
														'".$R["sv_referer"]."',
														'".$R["sv_search"]."',
														'".$R["sv_keyword"]."',
														'".$R["sv_os"]."',
														'".$R["sv_load"]."'
															)");
	$db->query("USE ".$EWT_DB_NAME);
	//ลบต้นทางออก
	$db->query("DELETE FROM stat_visitor WHERE sv_id = '".$R["sv_id"]."' ");
	$i++;
	if($i=='500'){	DUMP_DB($tb);	}
	
}//end while
?><script language="javascript">  
		alert('เรียบร้อยแล้ว');
		location.href="site_index_main.php"; 
	</script><?php
}


}
if($_POST["flag"]=='DUMP'){
//add data
$i = 0;
$sql = "select * from stat_visitor order by sv_id ASC limit 0,500 ";
$query = $db->query($sql);
$numrows = $db->db_num_rows($query);
	if($numrows>0){
	$db->query("USE db_00_stat_visitor");
//add table listname
$list_name = $_POST["name_list"];
$list_dbname =  "stat_visitor_".date('YmdHis');
$list_site = $EWT_FOLDER_USER;
$list_type = "stat_visitor";
$db->query("INSERT list_name (list_name,list_dbname,list_site,list_type) VALUES ('".$list_name."','".$list_dbname."','".$list_site."','".$list_type."')");
//สร้าง table ใหม่
$db->query("CREATE TABLE `".$list_dbname."` (                                  
                `sv_id` int(10) NOT NULL AUTO_INCREMENT,                     
                `sv_url` varchar(5) DEFAULT NULL,                            
                `sv_visitor` char(1) DEFAULT NULL,                           
                `sv_menu` varchar(50) NOT NULL DEFAULT '',                   
                `sv_ip` varchar(15) NOT NULL DEFAULT '',                     
                `sv_timestamp` varchar(14) NOT NULL DEFAULT '0',             
                `sv_date` date NOT NULL DEFAULT '0000-00-00',                
                `sv_time` time NOT NULL DEFAULT '00:00:00',                  
                `sv_country` varchar(64) NOT NULL DEFAULT '',                
                `sv_language` varchar(8) DEFAULT NULL,                       
                `sv_new` char(1) DEFAULT NULL,                               
                `sv_browser` varchar(20) DEFAULT NULL,                       
                `sv_resolution` varchar(10) DEFAULT NULL,                    
                `sv_domain` varchar(128) DEFAULT NULL,                       
                `sv_isp` text,                                               
                `sv_region` varchar(128) DEFAULT NULL,                       
                `sv_city` varchar(128) DEFAULT NULL,                         
                `sv_latitude` double DEFAULT NULL,                           
                `sv_longitude` double DEFAULT NULL,                          
                `sv_referer` text,                                           
                `sv_search` varchar(50) DEFAULT NULL,                        
                `sv_keyword` varchar(255) DEFAULT NULL,                      
                `sv_os` varchar(15) DEFAULT NULL,                            
                `sv_load` int(3) DEFAULT NULL,                               
                PRIMARY KEY (`sv_id`),                                       
                KEY `sv_id` (`sv_id`,`sv_url`,`sv_visitor`),                 
                KEY `sv_date` (`sv_date`,`sv_time`)                          
              ) ENGINE=MyISAM AUTO_INCREMENT=1252582 DEFAULT CHARSET=latin1");
			$db->query("USE ".$EWT_DB_NAME);
	DUMP_DB($list_dbname);
	}else{
	?><script language="javascript">  
		alert('ไม่มีข้อมูลกรุณาตรวจสอบ');
		location.href="site_index_main.php"; 
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
    <td align="right">&nbsp;&nbsp;&nbsp;<a href="add.php" ><img src="../theme/main_theme/g_add.gif" alt="<?php echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_general_add;?></a> &nbsp;
        <hr>
    </td>
  </tr>
</table>
<form name="form1" method="POST" action="add.php">
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" >
    <td height="30" colspan="2" class="ewttablehead">บริหารสถติการเยี่ยมชมเว็บไต์(stat visitor)</td>
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
