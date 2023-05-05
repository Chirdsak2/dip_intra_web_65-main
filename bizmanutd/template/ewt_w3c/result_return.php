<?php 
 	session_start();
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


if(!$_GET["page_type"]) {
	echo "ไม่ได้ระบุชนิดเว็บเพจ";
	exit;
}

//$url_check = $Website."w3c/".$dir1.$_GET["filename"].".php";		// ต้องใช้ url เต็ม เพราะต้องส่งให้ website อื่น

  if($_GET["page_type"]==2) {  // Template 
  		$url_check = $Website.$folder."/main_template.php?filename=".$_GET["filename"];	
  } else {
		$url_check = $Website.$folder."/main_page.php?filename=".$_GET["filename"];	
  }

$_POST["valid"] = false;
				
switch ($_GET["w3c_type"]) {
	case 1:  $vendor_contents = file_get_contents("http://validator.w3.org/check?uri=".$url_check);
						if(eregi("congratulation", $vendor_contents)) {
			  	  				$_POST["valid"] = "pass";
						}
					$field_name = "w3c_html";  
					$label_type = "- HTML 4.01";  
					$logo = file_get_contents("bottom_401.html"); 
					
					?><!--script language="javascript">
										//window.open("http://validator.w3.org/check?uri=<?php //echo $url_check;?>");
						 </script-->	
                         <iframe width="100%" height="500"  frameborder="1" scrolling="yes" src="http://validator.w3.org/check?uri=<?php echo $url_check;?>">
                         </iframe>												
					<?php
					break;
	case 2:   
						//$ch = curl_init();
						
						
						if($_GET["page_type"]==2) {  // Template 
								$url_check = $Website.$folder."/".$dir2.$_GET["filename"].".php";	
						  } else {
								$url_check = $Website.$folder."/".$dir1.$_GET["filename"].".php";	
						  }
						  
						$query_str = urlencode("rptmode")."=".urlencode("0")."&".urlencode("warnp2n3e")."=".urlencode("1")."&".urlencode("BROWSE_EMUL")."=".urlencode("MS Internet Explorer 6.0")."&".urlencode("RunJob")."=".urlencode("Test your site")."&".urlencode("url1")."=".urlencode($url_check);
						
						//$query_str = urlencode("rptmode=0&warnp2n3e=1&BROWSE_EMUL=MS Internet Explorer 6.0&RunJob=Test your site&url1=".$url_check);
												
						 //echo "$query_str<br>";
						
						/* curl_setopt($ch, CURLOPT_HEADER, 0);  											
						
						 curl_setopt($ch, CURLOPT_POST, true);
        				 curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);
						 curl_setopt($ch, CURLOPT_URL, "http://www.cynthiasays.com/mynewtester/cynthia.exe");
						 
						
					//	curl_setopt($ch, CURLOPT_URL, "http://www.cynthiasays.com/mynewtester/cynthia.exe?rptmode=0&warnp2n3e=1&BROWSE_EMUL=MS Internet Explorer 7.0&RunJob=Test your site&url1=".$url_check);
						
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);						
						
						//echo "AGENT :".$_SERVER['HTTP_USER_AGENT']."<br>";																		
						curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
											
						$vendor_contents = curl_exec($ch);
						curl_close($ch);*/
						 $fp = fopen ("http://www.cynthiasays.com/mynewtester/cynthia.exe?".$query_str, 'rb');
		
						$ata = stream_get_contents (  $fp);
						$vendor_contents = $ata;
						@fclose($fp);
					
					//  โหลดค่าจาก cynthia.exe ใช้ file_get_contents ไม่ได้
					//  $vendor_contents = file_get_contents("http://www.cynthiasays.com/mynewtester/cynthia.exe?rptmode=0&warnp2n3e=1&BROWSE_EMUL=MS Internet Explorer 6.0&RunJob=Test your site&url1=".$url_check);
					// echo "http://www.cynthiasays.com/mynewtester/cynthia.exe?rptmode=0&warnp2n3e=1&BROWSE_EMUL=MS Internet Explorer 6.0&RunJob=Test your site&url1=".$url_check."<br>";
					 
						if(eregi("<strong>Passed", $vendor_contents)) {
			  	  				$_POST["valid"] = "pass";
						}
						/* $fp = fopen ("http://www.cynthiasays.com/mynewtester/cynthia.exe?".$query_str, 'rb');
		
						$ata = stream_get_contents (  $fp);
						//echo $ata;
						@fclose($fp);*/
						$vendor_contents = eregi_replace("src=\"../../hi-logo","src=\"http://www.cynthiasays.com/hi-logo",$vendor_contents); // แก้ /> ไปก่อนเลย
					$vendor_contents = eregi_replace("src=\"images/Ctested","src=\"http://www.cynthiasays.com/images/Ctested",$vendor_contents); // แก้ /> ไปก่อนเลย
					$vendor_contents = str_replace("<meta name=\"subject\" content=\"Computers:Internet:WWW\">
<meta name=\"description\" content=\"Cynthia, The Accessibility Agent\">
<meta name=\"robots\" content=\"ALL\">
<meta name=\"distribution\" content=\"GLOBAL\">
<meta name=\"classification\" content=\"Online Resource\">
<meta name=\"copyright\" content=\"2003 - HiSoftware Inc\">
<meta name=\"author\" content=\"HiSoftware Inc - Unless otherwise noted\">","",$vendor_contents);
						?>
                        <fieldset style="padding:10px;" ><div style="scrollbar-face-color: # ff6699; left: 306px;overflow-x: hidden; overflow: scroll;  scrollbar-3dlight-color: #000000; scrollbar-arrow-color: #ffffff; scrollbar-base-color: #ffffff; HEIGHT: 440px"><?php echo $vendor_contents;?></div></fieldset>
                        <!--textarea rows="3" cols="50"><?php // echo $vendor_contents;?></textarea-->
                        <?php
					$field_name = "w3c_wcag"; 
					$label_type = "- WCAG 1.0 ระดับ A"; 
					$logo = file_get_contents("bottom_wcag.html"); 		
					//echo "valid:".$_POST["valid"]."<br>";
					?>
                    <!--form name="frmW3C" method="post" action="http://www.cynthiasays.com/mynewtester/cynthia.exe" target="_blank">
                    	<input name="rptmode" type="hidden" value="0">
                        <input name="warnp2n3e" type="hidden" value="1">
                        <input name="BROWSE_EMUL" type="hidden" value="MS Internet Explorer 6.0">
                        <input name="RunJob" type="hidden" value="Test your site">
                        <input name="url1" type="hidden" value="<?php echo $url_check;?>">
                    </form-->
                    <script language="javascript">
//				frmW3C.submit();	 // window.open("http://www.cynthiasays.com/mynewtester/cynthia.exe?rptmode=0&warnp2n3e=1&BROWSE_EMUL=MS Internet Explorer 7.0&RunJob=Test your site&url1=<?php // echo $url_check;?>");
						 </script>							
                         <iframe width="100%" height="500"  frameborder="1" scrolling="yes" src="http://www.cynthiasays.com/mynewtester/cynthia.exe?rptmode=0&warnp2n3e=1&BROWSE_EMUL=MS Internet Explorer 6.0&RunJob=Test your site&url1=<?php echo $url_check;?>">
                         </iframe>
					<?php
														
					break;
	case 3: $vendor_contents = file_get_contents("http://jigsaw.w3.org/css-validator/validator?uri=".$url_check);
						if(eregi("congratulation", $vendor_contents)) {
			  	  				$_POST["valid"] = "pass";
						}
					$field_name = "w3c_css"; 
					$label_type = "- CSS"; 
					$logo = file_get_contents("bottom_css.html"); 
					?><!--script language="javascript">
										//window.open("http://jigsaw.w3.org/css-validator/validator?uri=<?php echo $url_check;?>");
						 </script-->
                          <iframe width="100%" height="500"  frameborder="1" scrolling="yes" src="http://jigsaw.w3.org/css-validator/validator?uri=<?php echo $url_check;?>">
                         </iframe>																				
					<?php
					break;
}


$filecheck = $_GET["filename"];

if(!file_exists($dir1)) {  // ถ้าไม่มี   folder checked ให้สร้างก่อน
		mkdir($dir1,0777);
}
if(!file_exists($dir2)) {  // ถ้าไม่มี   folder template ให้สร้างก่อน
		mkdir($dir2,0777);
}

 if($_GET["page_type"]==2) {  // Template 
 		$source_file = $dir2.$filecheck.".php";
 } else {
		$source_file = $dir1.$filecheck.".php";
 }	

		if(file_exists($source_file)) {
			
				if($_POST["valid"] == "pass" ) {  // ถ้าได้ผลการตรวจ W3C ผ่านแล้ว
						
						if($_GET["page_type"]==2) {  // เฉพาะหน้า Template ค่อยใส่ logo
								$contents = file_get_contents($source_file);				
								$logo = "#htmlw3c_spliter#";
								$contents = str_replace($logo,"",$contents);
								$contents = str_replace("<span id=\"formtextchangelang\"></span>","<?#split#?>",$contents);
								$arr_html = explode("<?#split#?>",$contents);
								$newcontents = $arr_html[0]."<span id=\"formtextchangelang\"></span>".$logo.$arr_html[1];
																			
								$result1 = $disp->testvar_infile($newcontents, $source_file, "w");		
						}		
														
						echo "<H3 style='color:green'>อนุมัติ W3C $label_type สำเร็จแล้ว</H3>";
							
								
								$UPDATE = " UPDATE webpage_info SET  $field_name = 'w3c', modify_time  = NOW() WHERE  filename = '$filecheck' AND db_name = '".$main_db."' AND page_type = '".$_GET["page_type"]."' ";
								
								
								$db2->query($UPDATE);
								?><script language="javascript">
										opener.location.reload();
									</script>
													
						<?php
				} else {
						
						echo "<H3 style='color:red'>ไม่ผ่านมาตรฐาน W3C $label_type </H3>";
						
							$UPDATE = " UPDATE webpage_info SET  $field_name = 'chk', modify_time  = NOW() WHERE  filename = '$filecheck' AND db_name = '".$main_db."' AND page_type = '".$_GET["page_type"]."' ";
								$db2->query($UPDATE);
								?><script language="javascript">
										opener.location.reload();
									</script>
                        <?php
				}		
				
				//echo "$UPDATE<br>";		
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
