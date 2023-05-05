<?php  
 	session_start();
	set_time_limit(300);
	
	$start_time_counter = date("YmdHis");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");

	
	$main_db = $EWT_DB_NAME; 
	
	
	if(!$main_db) { // ถ้าไม่รู้ว่า จะดึงข้อมูลหน้าเว็บจาก db_name อันไหน  ให้ดีดออก
		echo "UnKnown Client Database";
		exit;
	}
	
	
	////////////////////////   connection สำหรับ W3C //////////////////////
    $path = "";
	include ($path.'include/config.inc.php');
	include ($path.'include/class_db.php');
	include ($path.'include/class_display.php');	
	include ($path.'include/class_application.php');	
	$CLASS['db']   = new db2();
    $CLASS['db']->connect ();   
	$CLASS['disp'] = new display();
    $CLASS['app'] = new application();   
		   
	$db2   = $CLASS['db'];
    $disp = $CLASS['disp'];
	$app = $CLASS['app'];		
	
	$charac1 = $disp->convert_qoute_to_db("'");
	$charac2 = $disp->convert_qoute_to_db('"');
	
	
	$invalid = false;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title><?php echo $proj_title;?> - ยกเลิกการแปลง W3C</title>
<link href="css/style1.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript1.2" src="js/AjaxRequest.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/functions.js"></script>
</head>
<body>
<?php 
if(!$_GET["filename"]) {
	echo "<H2>ไม่ได้ระบุชื่อเว็บเพจ</H2>";
	exit;
}
if(!$_GET["page_type"]) {
	echo "ไม่ได้ระบุชนิดเว็บเพจ";
	exit;
}
										
		if(!file_exists($dir1)) {  // ถ้าไม่มี   folder checked ให้สร้างก่อน
				mkdir($dir1,0777);
				echo "make directory : $dir1<br>";
		}
		if(!file_exists($dir2)) {  // ถ้าไม่มี   folder template ให้สร้างก่อน
				mkdir($dir2,0777);
				echo "make directory : $dir2<br>";
		}		
$filecheck = $_GET["filename"];	

if($_GET["page_type"]==2) {  // Template

		if(file_exists($dir2) && $filecheck ) {
				@unlink($dir2.$filecheck.".php");
		}	
} else {
		if(file_exists($dir1) && $filecheck) {
				@unlink($dir1.$filecheck.".php");
		}		
}
			
			$sql_fetch_del = " SELECT 
										 `web_attr_html`.`text_id`,
										  `web_tag_html`.`filename`,
										  `web_tag_html`.`db_name`
										FROM
										  `web_tag_html`
										  INNER JOIN `web_attr_html` ON (`web_tag_html`.`text_id` = `web_attr_html`.`text_id`)															
									WHERE `web_tag_html`.`filename` = '$filecheck' AND `web_tag_html`.`db_name` = '$main_db' AND page_type = '".$_GET["page_type"]."' ";
			$exec_fetch_del = $db2->query($sql_fetch_del);
			while($rec_fetch_del=$db2->fetch_array($exec_fetch_del)) {																				
					$DELETE2 = " DELETE FROM web_attr_html WHERE text_id = '".$rec_fetch_del[text_id]."'  ";
					$db2->query($DELETE2);
			}
			$DELETE = " DELETE FROM web_tag_html WHERE filename = '$filecheck' AND db_name = '".$main_db."' AND page_type = '".$_GET["page_type"]."' ";
			
			//echo "$DELETE<br>";
			$db2->query($DELETE); // ลบข้อมูล  web_tag_html ไปก่อน แล้วค่อย import ใหม่
	
			///////////////////////////////////////////////////////////////////////////////////////
				
			$sql_fetch_del = " SELECT 
										 `web_attr`.`text_id`,
										  `web_tag`.`filename`,
										  `web_tag`.`db_name`
										FROM
										  `web_tag`
										  INNER JOIN `web_attr` ON (`web_tag`.`text_id` = `web_attr`.`text_id`)															
									WHERE `web_tag`.`filename` = '$filecheck' AND `web_tag`.`db_name` = '$main_db' AND page_type = '".$_GET["page_type"]."' ";
			$exec_fetch_del = $db2->query($sql_fetch_del);
			while($rec_fetch_del=$db2->fetch_array($exec_fetch_del)) {																				
					$DELETE2 = " DELETE FROM web_attr WHERE text_id = '".$rec_fetch_del[text_id]."'  ";
					$db2->query($DELETE2);
			}
			$DELETE = " DELETE FROM web_tag WHERE filename = '$filecheck' AND db_name = '".$main_db."' AND page_type = '".$_GET["page_type"]."' ";
			$db2->query($DELETE); // ลบข้อมูล  web_tag เฉพาะ หน้าเว็บเดิมของ EWT ที่เคยนำเข้ามา ก่อนหน้านี้ไปก่อน แล้วค่อย import ใหม่
			
			$DELETE = " DELETE  FROM webpage_info  WHERE filename = '$filecheck' AND db_name = '".$main_db."'  AND page_type = '".$_GET["page_type"]."'    ";								
			$db2->query($DELETE);
			
			
		
			echo "<h4 style='color:green'>ยกเลิกการแปลง W3C  ของเว็บเพจ <u>$filecheck</u> เรียบร้อยแล้ว</h4>";
			echo "<input name=\"close\" type=\"button\" value=\"       ปิดหน้าต่าง       \" onclick=\"window.close();\">";
			?>
			<script type="text/javascript">
			opener.location.reload();
			</script>
			<?php 			
				
		$db2->close_db();
		$db->db_close();			
	
	?>  
</body>
</html>
