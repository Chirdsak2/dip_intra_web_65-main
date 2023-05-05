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

<title><?php echo $proj_title;?> - โหลด Content</title>
<link href="css/style1.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript1.2" src="js/AjaxRequest.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/functions.js"></script>
<script type="text/javascript" language="javascript1.2">
function chkInput() {
	/*	if(frm.w3c_description.value == '') {
			 alert('กรุณากรอกคำอธิบายรายละเอียดเว็บเพจ');
			 frm.w3c_description.focus();
			 return false;
		}*/
		frm.run_edit.value=1; 	 
		frm.submit();
}
</script>
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

//$dir1 = "w3c\\checked\\" ; //"checked/";												
		if(!file_exists($dir1)) {  // ถ้าไม่มี   folder checked ให้สร้างก่อน
				mkdir($dir1,0777);
				echo "make directory : $dir1<br>";
		}
		if(!file_exists($dir2)) {  // ถ้าไม่มี   folder template ให้สร้างก่อน
				mkdir($dir2,0777);
				echo "make directory : $dir2<br>";
		}		
	/* ยกเลิกการรวมหน้าแล้ว	
		if(!file_exists($dir3)) {   // ถ้าไม่มี   folder mainbkup ให้สร้างก่อน  สำหรับ backup หน้าเว็บหลักที่ยังไม่ได้ ครอบ Template
				mkdir($dir3,0777);  
		}
	*/	
if($_GET["page_type"]==2) {  // Template 
		
	$urladdr = $phpMainTemplate.$_GET["filename"];
	
	//echo "$urladdr === http://202.122.40.25/ewtadmin/ewt/parliament_parcy/ewt_preview_template.php?filename=constitution_and_acts <br>";
	
	$savename = $_GET["filename"];
	$contents = file_get_contents($urladdr);
	
	$phpcontents = $contents;
	//echo htmlspecialchars($contents);
	//echo "<br>";	
	//exit;
	
} else {   // Body 
		//$Website = "http://localhost/ewtadmin/ewt/parliament_parcy/";
	$urladdr = $phpMainBody.$_GET["filename"];
		//echo "$urladdr<br>";
		//exit;		
																					
			 ////////////// ส่วนดึง tag จาก url มาแยกเก็บ ลงตาราง web_tag			
			$savename = $_GET["filename"];
			
			$head_contents = file_get_contents("style.html");  // head section
									
			$COMPTOP = file_get_contents("comptop.html");  
			$COMPBOTTOM = file_get_contents("compbottom.html");
								
			$contents = file_get_contents($urladdr);
					// อ่าน tag html จาก internet	ทั้งหน้ามาเก็บไว้
			//echo "<br>urladdr: $urladdr<br>";		
			//echo htmlspecialchars($contents);  			
			//echo "<br>";			
			//echo "ชื่อไฟล์ (ที่อ่านหน้าเวบมาเก็บไว้แล้ว) : $dir1<strong>$newfile</strong><br>";
			
			// 	 ท่าทางจะต้องใช้ $dtd_charset  = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\"><html lang=\"th\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
			//$dtd_charset = "";
			
			//$phpcontents = $dtd_html_head_charset_top.$head_contents.$dtd_html_head_charset_bottom." <body ".$body_attr.">".$COMPTOP.$contents.$COMPBOTTOM."</body>".$END_PAGE;
			$phpcontents = $contents;
						
} // end else 

if($_GET["page_type"]==2) {  // Template
		if(file_exists($dir2)) {
						
						   $result1 = $disp->testvar_infile($phpcontents, $dir2.$savename.".php", "w");
		}	
} else {
		if(file_exists($dir1)) {
							//echo "$UserPath$dir1<br>"; //  เราลองแล้ว path $dir1 นี้มีแยู่จริง
						   $result1 = $disp->testvar_infile($phpcontents, $dir1.$savename.".php", "w");// จึงต้อง write file แืืทน 
							//echo "write file : ".$dir1.$savename.".php<br>";
		}	
	 /*	  ยกเลิกการรวมหน้าแล้ว จึงไม่ต้องใช้ $dir3
		if(file_exists($dir3)) {
			@unlink($dir3.$savename.".php");  // ลบไฟล์หน้าหลักอันเก่า ทิ้งก่อน
		}
	*/
}
			
			$sql_fetch_del = " SELECT 
										 `web_attr_html`.`text_id`,
										  `web_tag_html`.`filename`,
										  `web_tag_html`.`db_name`
										FROM
										  `web_tag_html`
										  INNER JOIN `web_attr_html` ON (`web_tag_html`.`text_id` = `web_attr_html`.`text_id`)															
									WHERE `web_tag_html`.`filename` = '$savename' AND `web_tag_html`.`db_name` = '$main_db' AND page_type = '".$_GET["page_type"]."' ";
			$exec_fetch_del = $db2->query($sql_fetch_del);
			while($rec_fetch_del=$db2->fetch_array($exec_fetch_del)) {																				
					$DELETE2 = " DELETE FROM web_attr_html WHERE text_id = '".$rec_fetch_del[text_id]."'  ";
					$db2->query($DELETE2);
			}
			$DELETE = " DELETE FROM web_tag_html WHERE filename = '$savename' AND db_name = '".$main_db."' AND page_type = '".$_GET["page_type"]."' ";
			
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
									WHERE `web_tag`.`filename` = '$savename' AND `web_tag`.`db_name` = '$main_db' AND page_type = '".$_GET["page_type"]."' ";
			$exec_fetch_del = $db2->query($sql_fetch_del);
			while($rec_fetch_del=$db2->fetch_array($exec_fetch_del)) {																				
					$DELETE2 = " DELETE FROM web_attr WHERE text_id = '".$rec_fetch_del[text_id]."'  ";
					$db2->query($DELETE2);
			}
			$DELETE = " DELETE FROM web_tag WHERE filename = '$savename' AND db_name = '".$main_db."' AND page_type = '".$_GET["page_type"]."' ";
			$db2->query($DELETE); // ลบข้อมูล  web_tag เฉพาะ หน้าเว็บเดิมของ EWT ที่เคยนำเข้ามา ก่อนหน้านี้ไปก่อน แล้วค่อย import ใหม่
			
			$DELETE = " DELETE  FROM webpage_info  WHERE filename = '$savename' AND db_name = '".$main_db."'  AND page_type = '".$_GET["page_type"]."'    ";								
			$db2->query($DELETE);
			
											
			$sql_check = " SELECT  filename FROM  webpage_info  WHERE filename = '$savename' AND db_name = '".$main_db."'  AND page_type = '".$_GET["page_type"]."' ";
			
			$exec_check = $db2->query($sql_check);
			
			$num_check = $db2->num_rows($exec_check);
			if($num_check==0) {													
					$INSERT = " INSERT INTO webpage_info (filename, main_group_id, page_type, db_name, modify_time ) 
													VALUES ('$savename', '0', '".$_GET["page_type"]."', '".$main_db."', NOW() )";
					$db2->query($INSERT);																								
			} 
																												
										
					$use_contents = trim($contents);
					//echo $htmlcode;
					//echo "<br>";
					// ================= ส่วนแก้ไข Tag เปิด-ปิด  ด้วย tidy  PHP  Class  ===============
					//exit;
					$tidy = new tidy;   //  ต้องเปิด extension   php_tidy.dll  ใน php.ini ก่อน
					if($_GET["page_type"]==2) {  // Template
					$opts = array("clean" => true, "output-html" => true, "quote-ampersand" => false, "quote-nbsp" => false, "lower-literals" => false, "css-prefix" => "c", "literal-attributes" => true   );  
					}else{//body
						$opts = array("clean" => true, "output-html" => true, "quote-ampersand" => false, "quote-nbsp" => false, "lower-literals" => false, "css-prefix" => "b", "literal-attributes" => true   );  
					}
					// , "wrap-jste" => true , "wrap" => 200 , "wrap-attributes" => true
					// "vertical-space" => true
					
					$tidy->parseString($use_contents,$opts,"latin1"); // "latin1"
					
					$tidy->cleanRepair();
					
					//$htmlcode =  trim($contents);
					
					$htmlcode = $tidy->html();  // จริงๆแล้ว ต้องใช้ content ที่แก้ tag เปิด-ปิดแล้ว  แต่เอาออกชั่วคราว  เพราะมันชอบแก้โค้ด javascript  ทำให้ javascript Error	 แต่ล่าสุดเรา set option แก้ปัญหานี้ได้แล้ว คือ 	"literal-attributes" => true 	
					
					//echo $htmlcode;
					// ==================================================================
					
						$htmlcode = eregi_replace("/>",">",$htmlcode); // แก้ /> ไปก่อนเลย
						
						//$htmlcode = eregi_replace("<!--","<!--  ",$htmlcode); // แก้ <!-- ไปก่อนเลย
						
						$arr_tag = array();
						$attribute_pack = array();
						$text_value = array();
						
						$arr_words = array();								
						$arr_words = explode("<",$htmlcode);
						$text_js = "";
						$rank = 0;
						for($i=0;$i<count($arr_words);$i++) {
								
								$arr_temp = array();
								$arr_temp_attr = array();
								
								if(eregi("<",$htmlcode)) {
									$tempword = eregi_replace(">"," ",$arr_words[$i]);
									$arr_temp = explode(" ",$tempword,2);									 
									$arr_tag[$i] = strtolower($arr_temp[0]);
									 // เก็บชื่อ tag เป็นตัวพิมพ์เล็ก โดย เอา > ออกด้วย			
									
									$arr_temp2 = $arr_temp3 = array();										
									$arr_temp2 = explode(">",$arr_words[$i],2); // $arr_temp[1]
									$arr_temp3 = explode(" ",$arr_temp2[0],2);
									$attribute_pack[$i] = $arr_temp3[1];  // เก็บ attribute แบบไม่ค่อยดี  ( เอาไปก่อน )
									$text_value[$i] = $arr_temp2[1];
									
										////////////  ส่วนแยก attribute ที่ work สุดแล้ว /////////////////////////
										$word1 = trim($attribute_pack[$i]);
										$cnt_qoute = 0;
										$cnt_sqoute = 0;
										$attr_no = 0;												
						
										
										for($pos=0;$pos<strlen($word1);$pos++){
												
												//if($arr_tag[$i]=='marquee' ) {
													//	echo $word1[$pos]." (word1[$pos]) == $charac2<br>";
												//}
												if( $cnt_sqoute == 0 && $word1[$pos]=='"' ) { // ถ้า เจอ " โดยไม่มี ' มาก่อน  ( ใช้ &quot; ไม่ได้ เพราะ เราตรวจทีละตัวอักษร )
													$cnt_qoute++; // นับจำนวน "
													
													//if($arr_tag[$i]=='marquee' ) {
													//	echo "cnt_qoute : $cnt_qoute<br>";
													//}
												} else if( $cnt_qoute == 0 && $word1[$pos]=="'") { 
														// ถ้าไม่เจอ " จึงจะ check ถ้า เจอ ' โดยไม่มี " มาก่อน ( ใช้ &#039; ไม่ได้ เพราะ เราตรวจทีละตัวอักษร ) 
													$cnt_sqoute++; // นับจำนวน '
												
												}
												
												$arr_temp_attr[$attr_no] .= $word1[$pos];
												
												if($pos>0) {
												
													
													
													//if($arr_tag[$i]=='marquee' ) {
													//	echo "$cnt_qoute==0 && ".$word1[$pos]."==\" \" ) || $cnt_qoute==2<br>";
													//}												
													$wrap_status=false;
													
												
													if($cnt_qoute==0 && $word1[$pos]==" " ) {
													
														$wrap_status=true;		
																									
													}  else if( $cnt_qoute==2  ) {
														// ถ้าเจอ " 2 ตัวแล้ว แสดงว่าจบ attribute 1 อย่าง
														$wrap_status=true;
														
													} else if( $cnt_sqoute==2  ) {
														 //  หรือ ถ้าเจอ ' 2 ตัวแล้ว แสดงว่าจบ attribute 1 อย่าง
														$wrap_status=true;													
														
													}
													
													if($wrap_status==true) {
															$attr_no++;
															$cnt_qoute = 0;
															$cnt_sqoute = 0;														
													}
												}
												
										} // end for pos
										
										//print_r($arr_temp_attr);
										//echo "=============<br>";
																			
								} else {
									$arr_tag[$i] = "";
									$attribute_pack[$i] = "";
									$text_value[$i] = $arr_words[$i];
								}
								
								if(trim($arr_tag[$i])=="script" ) {  // ถ้าเจอ tag  script
										$text_js = "";									
										//$in_script = true;
										$text_js .= $text_value[$i];	
								}
								if( trim($arr_tag[$i])=="style" ) {  // ถ้าเจอ tag  style
										 
										$text_css = "";
										//$in_script = true;									
										$text_css .= $text_value[$i];	
								}
								if(trim($arr_tag[$i])=="/script" || trim($arr_tag[$i])=="/style" ) {
										 $in_script1 = false;
										 $in_script2 = false;
								}
								
								if($in_script1) {   // ถ้าอยู่ในช่วง tag script เปิด - ปิด
								
										if(trim($arr_tag[$i])=="script" || trim($arr_tag[$i])=="/script" ) {
												//$text_js .= $text_value[$i];							
										} else {
												// record ที่อ่านข้อมูลมาปัจจุบัน ไม่ใช่ tag script  หรือ /script   ให้สะสม code java ใน $text_js
																								
												if($arr_words[$i]) {
													$text_js .= "<".$arr_words[$i];
												}										
										}
								} 
								if($in_script2) {   // ถ้าอยู่ในช่วง tag style เปิด - ปิด
								
										if(trim($arr_tag[$i])=="style" || trim($arr_tag[$i])=="/style" ) {
												//$text_js .= $text_value[$i];							
										} else {
												// record ที่อ่านข้อมูลมาปัจจุบัน ไม่ใช่ tag style  หรือ /style   ให้สะสม code css ใน $text_css
																			
												if($arr_words[$i]) {
													$text_css .= "<".$arr_words[$i];
												}										
										}
								} 
							
							
								if( strlen($arr_tag[$i]) <= 50 && trim($arr_tag[$i]) != "!doctype" && trim($arr_tag[$i])!="?php"  ) { // เอาเฉพาะ ชื่อ tag จริงๆ มันต้องมี เว้นวรรค แล้วความยาวชื่อไม่เกิน 50 และไม่เอา DOCTYPE 
										
										if($in_script1==false && $in_script2==false ) { // ถ้า code แต่ละ record ที่ผ่านมาไม่ใช่  code ในช่วงของ tag script จึงจะ insert
											$tagInfo = $app->tag_info(trim($arr_tag[$i]));
											
											//if(!$tagInfo[section_id]) {
											//		$tagInfo = $app->tag_info(trim(eregi_replace("/","",$arr_tag[$i])));
											//}
											
											if(trim($arr_tag[$i])=="meta" && eregi("charset", $attribute_pack[$i]) ) {  // charset=iso
													//  ไม่เอา meta ที่ charset=iso 
													
											} else {
											
													$INSERT = " INSERT INTO web_tag (filename, original_url, db_name, page_type, text_tag, text_value, text_attr, text_rank, section_edit) 
																					VALUES ('$savename', '', '".$main_db."', '".$_GET["page_type"]."', '".$disp->convert_qoute_to_db(trim($arr_tag[$i]))."', '".$disp->convert_qoute_to_db($text_value[$i])."', '".$disp->convert_qoute_to_db($attribute_pack[$i])."', '$rank', '".$tagInfo[section_id]."' )";
													$db2->query($INSERT);
																																										
													$text_id = mysql_insert_id();
													
													//echo $INSERT."<br>text_id : $text_id<br>";
													
													for($ci=0;$ci<count($arr_temp_attr);$ci++) {  // เก็บ Attribute ลง ตาราง web_attr											
														$piece_attr[$ci] = array();																						
														$piece_attr[$ci] = explode("=",$arr_temp_attr[$ci],2);											
														
														if(trim($piece_attr[$ci][0])) {  // ถ้า attribute_name มีค่า จึง insert
																
																$attb_info = $app->attr_info(trim($piece_attr[$ci][0]));  //  ดึงข้อมูลของ attribute ไว้ check													
															
																if( !eregi("=",$arr_temp_attr[$ci]) ) {  //  ถ้าไม่เจอ = ใน statement ของ attribute $arr_temp_attr[$ci] นี้
															
																		if($attb_info[no_assign_value]) {   // แล้วถ้าเป็น attribute ที่ ไม่ต้อง assign ค่าของมัน  
																
																			// insert ได้เลย
																			$INSERT2 = " INSERT INTO web_attr (text_attr_name, text_attr_value, text_id) 
																								VALUES ('".$disp->convert_qoute_to_db(trim($piece_attr[$ci][0]))."', '".$disp->convert_qoute_to_db(trim($piece_attr[$ci][1]))."', '$text_id' ) ";
																			$db2->query($INSERT2);																										
																			//echo "attribute ที่ ไม่ต้อง assign ค่าของมัน ".$INSERT2."<br>";
																			   
																		} else {    // แต่ถ้าไม่ใช่ attribute ที่ ไม่ต้อง assign ค่าของมัน ( attribute ทั่วไป )
																					$rebuild_attribute = "";
																					$found_equal=false;
																					
																					// วน loop สะสม statement ของ attribute คือ $rebuild_attribute ใหม่  อีกรอบ
																					
																					for($dc=$ci;$dc<count($arr_temp_attr);$dc++) { 																				
																							
																							if( $found_equal==true && trim($arr_temp_attr[$dc])) {
																								 // ถ้าเจอ = ใน $rebuild_attribute ที่สะสมไว้ ก่อนหน้า $arr_temp_attr[$dc] 
																								 // และ trim($arr_temp_attr[$dc]  ไม่ว่างเปล่า 
																								 
																								 //echo "$dc -> ".trim($arr_temp_attr[$dc])."<br>";
																								$rebuild_attribute.=trim($arr_temp_attr[$dc]);	
																								//  ก็ สะสม $rebuild_attribute อีกที แล้ว insert ได้เลย
																								
																								//echo "ตัวที่มีปัญหาเว้นวรรค ($rebuild_attribute):<br>";																
																								$arr_rebuild_attribute = array();
																								$arr_rebuild_attribute = explode("=",$rebuild_attribute,2);
																								
																								$INSERT2 = " INSERT INTO web_attr (text_attr_name, text_attr_value, text_id) 
																								VALUES ('".$disp->convert_qoute_to_db(trim($arr_rebuild_attribute[0]))."', '".$disp->convert_qoute_to_db(trim($arr_rebuild_attribute[1]))."', '$text_id' ) ";
																								$db2->query($INSERT2);																										
																								//echo $INSERT2."<br>";
																								
																								$ci=$dc; 
																								// insert แล้ว ให้ค่า $ci กระโดดข้าม index ของ $arr_temp_attr ที่มีปัญหา ไปเลย
																								// โดยกระโดดไป ให้เท่ากับ $dc ล่าสุด
																								
																								$dc=count($arr_temp_attr);   // insert แล้ว  ออกจาก loop for($dc) 																					
																								
																							} else {																				
																								
																								//echo "$dc -> ".trim($arr_temp_attr[$dc])."<br>";
																								
																								$rebuild_attribute.=trim($arr_temp_attr[$dc]);		
																							
																								if(eregi("=",$rebuild_attribute)) {
																									$found_equal=true;
																								}		
																								
																							}																																						
																					} // end for($dc)
																		
																		} // end else if
																
																} // end if  !eregi
																else {
																		// ถ้า $arr_temp_attr[$ci] ไม่มีปัญหาเว้นวรรค ( คือมี = เป็นปกติ )
																		$INSERT2 = " INSERT INTO web_attr (text_attr_name, text_attr_value, text_id) 
																								VALUES ('".$disp->convert_qoute_to_db(trim($piece_attr[$ci][0]))."', '".$disp->convert_qoute_to_db(trim($piece_attr[$ci][1]))."', '$text_id' ) ";
																		$db2->query($INSERT2);																										
																		//echo  "ไม่มีปัญหาเว้นวรรค ".$INSERT2."<br>";
																		
																}
														}// end if trim
													} // end for
												
													if(trim($arr_tag[$i])=="script") {
															$js_id = $text_id;  // ถ้ามี tag script ให้เก็บ id ไว้ update ทีหลังด้วย $text_js ที่สะสม code java เสร็จแล้ว
													
															$in_script1 = true;
													} 
													if(trim($arr_tag[$i])=="style") {
															$css_id = $text_id;  // ถ้ามี tag style ให้เก็บ id ไว้ update ทีหลังด้วย $text_css ที่สะสม code css เสร็จแล้ว
													
															$in_script2 = true;
													} 
													
													$rank++;
																			
										       } // end else  trim($arr_tag[$i])=="meta" 
									} // end if $in_script1
																													 		
												if(trim($arr_tag[$i])=="/script") {											 
														 
														 $UPDATE = " UPDATE web_tag  SET  text_value = '".addslashes($disp->convert_qoute_to_db($text_js))."'  WHERE  text_id = '$js_id' AND text_tag = 'script' ";
														// echo $UPDATE."<br>";
														 $db2->query($UPDATE);	 		
														 
														 $js_id = 0; // พอ update javascript ไปแล้ว ก็เคลียร์ค่า id ของเก่า = 0											 									 
												}
												if(trim($arr_tag[$i])=="/style") {											 
														 
														 $UPDATE = " UPDATE web_tag  SET  text_value = '".$disp->convert_qoute_to_db($text_css)."'  WHERE  text_id = '$css_id' AND text_tag = 'style' ";
														// echo $UPDATE."<br>";
														 $db2->query($UPDATE);	 		
														 
														 $css_id = 0; // พอ update css ไปแล้ว ก็เคลียร์ค่า id ของเก่า = 0											 									 
												}
																			
							} // end if( strlen($arr_tag[$i]) <= 50 && trim($arr_tag[$i]) != "!doctype" ) 																			
								
								//echo "<hr width='65%'>";
				}	// end for ใหญ่	for($i=0;$i<count($arr_words);$i++)
				
		//echo "<br>urladdr: $urladdr<br>";																	  					
		//echo "dir1: $dir1<br>";
		
				if($text_id) {
					echo "<h2 style='color:green'>โหลด Content เก็บเข้าฐานข้อมูล เรียบร้อยแล้ว</h2>";
					echo "<input name=\"close\" type=\"button\" value=\"       ปิดหน้าต่าง       \" onclick=\"window.close();\">";
					?>
					<script type="text/javascript">
					opener.location.reload();
					</script>
					<?php 
				}
				
		$db2->close_db();
		$db->db_close();			
	
	?>  
</body>
</html>
