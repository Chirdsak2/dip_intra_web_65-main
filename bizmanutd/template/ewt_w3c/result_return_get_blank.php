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
<title><?php echo $proj_title;?> - ตรวจผลอนุมัติ W3C</title>
</head>

<body>
<center>
		<?php
if(!$_GET["filename"]) {
	echo "<H2>ไม่ได้ระบุชื่อเว็บเพจ</H2>";
	exit;
}
if(!$_GET["w3c_type"]) {  
	echo "<H2>ไม่ได้ระบุประเภทของมาตรฐาน W3C</H2>";
	exit;
}

$url_check = $Website.$folder."/checked/".$_GET["filename"].".php";		
	
$_POST["valid"] = false;
				
switch ($_GET["w3c_type"]) {
	case 1:  $vendor_contents = file_get_contents("http://validator.w3.org/check?uri=".$url_check);
						if(eregi("congratulation", $vendor_contents)) {
			  	  				$_POST["valid"] = "pass";
						}
					$field_name = "w3c_html";  
					$label_type = "- HTML 4.01";  
					$logo = file_get_contents("bottom_401.html"); 
					
					?><script language="javascript">
										window.open("http://validator.w3.org/check?uri=<?php echo $url_check;?>");
						 </script>													
					<?php
					break;
	case 2:   
						$ch = curl_init();
						
						$query_str = urlencode("rptmode")."=".urlencode("0")."&".urlencode("warnp2n3e")."=".urlencode("1")."&".urlencode("BROWSE_EMUL")."=".urlencode("MS Internet Explorer 7.0")."&".urlencode("RunJob")."=".urlencode("Test your site")."&".urlencode("url1")."=".urlencode($url_check);
												
						
						 curl_setopt($ch, CURLOPT_HEADER, 0);  											
						
						 curl_setopt($ch, CURLOPT_POST, true);
        				 curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);
						 curl_setopt($ch, CURLOPT_URL, "http://www.cynthiasays.com/mynewtester/cynthia.exe");
						 
						
					//	curl_setopt($ch, CURLOPT_URL, "http://www.cynthiasays.com/mynewtester/cynthia.exe?rptmode=0&warnp2n3e=1&BROWSE_EMUL=MS Internet Explorer 7.0&RunJob=Test your site&url1=".$url_check);
						
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);						
						
						//echo "AGENT :".$_SERVER['HTTP_USER_AGENT']."<br>";																		
						curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
											
						$vendor_contents = curl_exec($ch);
						curl_close($ch);

					//  โหลดค่าจาก cynthia.exe ใช้ file_get_contents ไม่ได้
					//  $vendor_contents = file_get_contents("http://www.cynthiasays.com/mynewtester/cynthia.exe?rptmode=0&warnp2n3e=1&BROWSE_EMUL=MS Internet Explorer 7.0&RunJob=Test your site&url1=".$url_check);
						if(eregi("<strong>Passed&nbsp;Automated Verification</strong>", $vendor_contents)) {
			  	  				$_POST["valid"] = "pass";
						}
					$field_name = "w3c_wcag"; 
					$label_type = "- WCAG 1.0 ระดับ A"; 
					$logo = file_get_contents("bottom_wcag.html"); 		
					
					?><script language="javascript">
										window.open("http://www.cynthiasays.com/mynewtester/cynthia.exe?rptmode=0&warnp2n3e=1&BROWSE_EMUL=MS Internet Explorer 7.0&RunJob=Test your site&url1=<?php echo $url_check;?>");
						 </script>													
					<?php
														
					break;
	case 3: $vendor_contents = file_get_contents("http://jigsaw.w3.org/css-validator/validator?uri=".$url_check);
						if(eregi("congratulation", $vendor_contents)) {
			  	  				$_POST["valid"] = "pass";
						}
					$field_name = "w3c_css"; 
					$label_type = "- CSS"; 
					$logo = file_get_contents("bottom_css.html"); 
					?><script language="javascript">
										window.open("http://jigsaw.w3.org/css-validator/validator?uri=<?php echo $url_check;?>");
						 </script>													
					<?php
					break;
}



$dir1 = $folder."\\checked\\";	
if(!file_exists($UserPath.$dir1)) {  // ถ้าไม่มี   folder checked ให้สร้างก่อน
		mkdir($UserPath.$dir1,0777);
}
$source_file = $UserPath.$dir1.$_GET["filename"].".php";
$filecheck = $_GET["filename"];
	
		
		if(file_exists($source_file)) {
			
				if($_POST["valid"] == "pass" ) {  // ถ้าได้ผลการตรวจ W3C ผ่านแล้ว
				
						$contents = file_get_contents($source_file);				
						
						$contents = str_replace($logo,"",$contents);
						
						$arr_html = split("</body>",$contents,2);
						
						$newcontents = $arr_html[0].$logo."</body>".$arr_html[1];
																	
						$result1 = $disp->testvar_infile($newcontents, $source_file, "w");				
														
						echo "<H3 style='color:green'>อนุมัติ W3C $label_type สำเร็จแล้ว</H3>";
							
								
								$UPDATE = " UPDATE webpage_info SET  $field_name = 'w3c', modify_time  = NOW() WHERE  filename = '$filecheck' AND db_name = '".$main_db."'  ";
								$db2->query($UPDATE);
								?><script language="javascript">
										opener.location.reload();
									</script>
													
						<?php
				} else {
						
						echo "<H3 style='color:red'>ไม่ผ่านมาตรฐาน W3C $label_type </H3>";
						
							$UPDATE = " UPDATE webpage_info SET  $field_name = 'chk', modify_time  = NOW() WHERE  filename = '$filecheck' AND db_name = '".$main_db."'  ";
								$db2->query($UPDATE);
								?><script language="javascript">
										opener.location.reload();
									</script>
                        <?php
				}			
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
