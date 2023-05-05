<?php 
 	session_start();
	$start_time_counter = date("YmdHis");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	
	
	$main_db = $EWT_DB_NAME; //"db_163_ictweb";   ใช้ ฐานข้อมูลลูกค้า เพื่ออ่านชื่อไฟล์มาให้เลือก 
	
	
	if(!$main_db) { // ถ้าไม่รู้ว่า จะดึงข้อมูลหน้าเว็บจาก db_name อันไหน  ให้ดีดออก
		echo "UnKnown Client Database";
		exit;
	}
	
	
	////////////////////////   connection สำหรับ W3C //////////////////////
    $path = "";
	include ($path.'include/config.inc.php');
	include ($path.'include/class_db.php');
	include ($path.'include/class_display.php');	
	$CLASS['db']   = new db2();
    $CLASS['db']->connect ();   
	$CLASS['disp'] = new display();
    //$CLASS['app'] = new application();   
		   
	$db2   = $CLASS['db'];
    $disp = $CLASS['disp'];
	//$app = $CLASS['app'];		
	
	$charac1 = $disp->convert_qoute_to_db("'");
	$charac2 = $disp->convert_qoute_to_db('"');
	
	
	$invalid = false;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $proj_title;?> - อนุมัติ W3C</title>
</head>

<body>
<center>
		<?php
if(!$_GET["filename"]) {
	echo "<H2>ไม่ได้ระบุชื่อเว็บเพจ</H2>";
	exit;
}
if(!$_GET["w3c_type"]) {
	exit;
}
switch ($_GET["w3c_type"]) {
	case 1: $field_name = "w3c_html";  $label_type = "- HTML 4.01";  $logo = file_get_contents("bottom_401.html"); break;
	case 2: $field_name = "w3c_wcag"; $label_type = "- WCAG 1.0 ระดับ A"; $logo = file_get_contents("bottom_wcag.html"); break;
	case 3: $field_name = "w3c_css"; $label_type = "- CSS"; $logo = file_get_contents("bottom_css.html"); break;
}

$dir1 = "w3c\\checked\\";	
if(!file_exists($UserPath.$dir1)) {  // ถ้าไม่มี   folder checked ให้สร้างก่อน
		mkdir($UserPath.$dir1,0777);
}
$source_file = $UserPath.$dir1.$_GET["filename"].".php";
$filecheck = $_GET["filename"];
		/*
		$dir2 = $UserPath."w3c".$sign;												
		if(!file_exists($dir2)) {  // ถ้าไม่มี   folder w3c ให้สร้างก่อน
				mkdir($dir2,0777);
		}
		
		$destination_file = $dir2.$_GET["filename"].".html";
		*/
		//echo "$source_file<br>";
		
		if(file_exists($source_file)) {
				//if(copy($source_file,$destination_file)) {			
				
				$contents = file_get_contents($source_file);				
				
				$arr_html = split("</body>",$contents,2);
				
				$newcontents = $arr_html[0].$logo."</body>".$arr_html[1];
															
				$result1 = $disp->testvar_infile($newcontents, $source_file, "w");				
												
				echo "<H3 style='color:green'>อนุมัติ W3C $label_type สำเร็จแล้ว</H3>";
						// หน้าเว็บชื่อ <strong>".$_GET["filename"].".php</strong> ใช้งานในโหมด W3C ได้แล้ว
						
						$UPDATE = " UPDATE webpage_info SET  $field_name = 'w3c', modify_time  = NOW() WHERE  filename = '$filecheck' AND db_name = '".$main_db."'  ";
						$db2->query($UPDATE);
						?><script language="javascript">
								opener.location.reload();
							</script>
											
				<?php
			 // }
		} else {		
				echo "<H4 style='color:red'>ไม่พบไฟล์ที่ต้องการอนุมัติ W3C $label_type </H4>";
		}
		
$db2->close_db();
$db->db_close();

		?>
		<br><br>
		<input name="bt_close" type="button" value=" ปิดหน้าต่าง " onClick=" window.close();">
</center>
</body>
</html>
