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
$sql = "select * from log_user order by log_id  ASC limit 0,500 ";
$query = $db->query($sql);
$numrows = $db->db_num_rows($query);
if($numrows>0){
while($R = $db->db_fetch_array($query)){
	$log_id = $R["log_id"];
	$log_date = $R["log_date"];
	$log_time = $R["log_time"];
	$log_mid = $R["log_mid"];
	$log_user = $R["log_user"];
	$log_date_text = $R["log_date_text"];
	$log_ip = $R["log_ip"];
	$log_module = $R["log_module"];
	$log_module_detail = $R["log_module_detail"];
	$log_detail = $R["log_detail"];
	$db->query("USE db_00_stat_visitor");
	
	$db->query("INSERT INTO ".$tb." (log_id,
														log_date,
														log_time,
														log_mid,
														log_user,
														log_date_text,
														log_ip,
														log_module,
														log_module_detail,
														log_detail
															) VALUES (
															'".$R["log_id"]."',
														'".$R["log_date"]."',
														'".$R["log_time"]."',
														'".$R["log_mid"]."',
														'".$R["log_user"]."',
														'".$R["log_date_text"]."',
														'".$R["log_ip"]."',
														'".$R["log_module"]."',
														'".$R["log_module_detail"]."',
														'".$R["log_detail"]."'
															)");
	$db->query("USE ".$EWT_DB_NAME);
	//ลบต้นทางออก
	$db->query("DELETE FROM log_user WHERE log_id = '".$R["log_id"]."' ");
	$i++;
	if($i=='500'){	DUMP_DB($tb);	}
	
}//end while
?><script language="javascript">  
		alert('เรียบร้อยแล้ว');
		location.href="site_index_loguser.php"; 
	</script><?php
}


}
if($_POST["flag"]=='DUMP'){
//add data
$i = 0;
$sql = "select * from log_user order by log_id  ASC limit 0,500 ";
$query = $db->query($sql);
$numrows = $db->db_num_rows($query);
	if($numrows>0){
	$db->query("USE db_00_stat_visitor");
//add table listname
$list_name = $_POST["name_list"];
$list_dbname =  "log_user_".date('YmdHis');
$list_site = $EWT_FOLDER_USER;
$list_type = "log_user";
$db->query("INSERT list_name (list_name,list_dbname,list_site,list_type) VALUES ('".$list_name."','".$list_dbname."','".$list_site."','".$list_type."')");
//สร้าง table ใหม่
$db->query("CREATE TABLE `".$list_dbname."` (                                 
            `log_id` int(15) NOT NULL AUTO_INCREMENT,               
            `log_date` date DEFAULT NULL,                           
            `log_time` time DEFAULT NULL,                           
            `log_mid` int(6) DEFAULT NULL,                          
            `log_user` varchar(100) DEFAULT NULL,                   
            `log_date_text` varchar(20) DEFAULT NULL,               
            `log_ip` varchar(15) DEFAULT NULL,                      
            `log_module` varchar(10) DEFAULT NULL,                  
            `log_module_detail` varchar(50) DEFAULT NULL,           
            `log_detail` text,                                      
            PRIMARY KEY (`log_id`)                                  
          ) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1");
			$db->query("USE ".$EWT_DB_NAME);
	DUMP_DB($list_dbname);
	}else{
	?><script language="javascript">  
		alert('ไม่มีข้อมูลกรุณาตรวจสอบ');
		location.href="site_index_loguser.php"; 
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
    <td align="right">&nbsp;<a href="add_loguser.php" ><img src="../theme/main_theme/g_add.gif" alt="<?php echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_general_add;?></a> &nbsp;
        <hr>
    </td>
  </tr>
</table>
<form name="form1" method="POST" action="add_loguser.php">
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" >
    <td height="30" colspan="2" class="ewttablehead">สถิติการใช้งานระบบบริหาร(Log User)</td>
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
