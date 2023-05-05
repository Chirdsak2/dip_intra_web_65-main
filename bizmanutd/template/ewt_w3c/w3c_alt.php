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
<title><?php echo $proj_title;?> - กรอกคำบรรยายภาพ</title>
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
<style> 
      html {font:normal 76% verdana, arial, san serif;} 
      body {padding:2em;} 
      h2 {font-size:1.8em; padding:0.5em; background:#44aaff;} 
      textarea {font-size:100%;} 
      #editContent{ 
          margin-left:30px; 
          padding-left:3px; 
          width:600px; 
          height:200px; 
          border:1px solid #666; 
      } 
     .textAreaWithLines{ 
         display:block; 
         margin:0; 
         border:1px solid #666; 
         border-right:none; 
         background:#aaa; 
      } 
    </style> 
</head>
<?php 
if($_POST["filecheck"]) {
		$_GET["filename"] = $_POST["filecheck"];
}

if(!$_GET["filename"]) {
	echo "<H2>ไม่ได้ระบุชื่อเว็บเพจ</H2>";
	exit;
}

if($_POST["page_type"]) {
	$_GET["page_type"]=$_POST["page_type"];
}

if(!$_GET["page_type"]) {
	echo "ไม่ได้ระบุชนิดเว็บเพจ";
	exit;
}

//$dir1 = "w3c/checked/";												
$filecheck = $_GET["filename"];

if($_GET["page_type"]==2) {  // Template
	$url_source = $dir2.$filecheck.".php";  // $Website.$dir2.$filecheck.".php";
} else {
	$url_source = $dir1.$filecheck.".php";  // $Website.$dir1.$filecheck.".php";
}

if(!file_get_contents($url_source)) {
	echo "<H2>ไม่พบเว็บเพจ</H2>";
	exit;
}

if($_GET["delFirst"]==1 && !$_POST["run_edit"] ) {

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
		$DELETE = " DELETE FROM web_tag_html WHERE filename = '$filecheck' AND db_name = '".$main_db."' AND page_type = '".$_GET["page_type"]."'  ";
		
		//echo "$DELETE<br>";
		$db2->query($DELETE); // ลบข้อมูล  web_tag_html ไปก่อน แล้วค่อย import ใหม่
	
		if($_GET["page_type"]==2) {  // Template
			if(file_get_contents($dir2.$filecheck."_bkupALT.php")) {
					$url_source =  $dir2.$filecheck."_bkupALT.php";
			}		
		} else {				
			if(file_get_contents($dir1.$filecheck."_bkupALT.php")) {
					$url_source =  $dir1.$filecheck."_bkupALT.php";
			}				
		}
}

$logo_401 = file_get_contents("bottom_401.html");
$logo_wcag = file_get_contents("bottom_wcag.html");
$logo_css = file_get_contents("bottom_css.html");
			
$sqlCheck = " SELECT  text_id  FROM  web_tag_html  WHERE  filename = '$filecheck' AND db_name = '$main_db' AND page_type = '".$_GET["page_type"]."' ";
$execCheck = $db2->query($sqlCheck);		
$numCheck = $db2->num_rows($execCheck);					

if($numCheck==0 &&  !$_POST["run_edit"] ) {   // ถ้ายังไม่มีการโหลด content จากหน้าที่แปลง W3C แล้ว  และยังไม่ได้กด บันทึก alt

			// ให้โหลด content มา INSERT ลง web_tag_html  และ web_attr_html ก่อน  ไว้ check / กรอก alt 
			$contents = file_get_contents($url_source);
			
			if($_GET["page_type"]==2) {  // Template
						$htmlcode = $contents;  // Template เอาทั้งหน้า html
			
			} else {
						// หน้าหลัก เอาแต่ข้างใน BODY
			
						$arr_temp = split("<body",$contents,2);
						$arr_temp2 = split(">",$arr_temp[1],2);
						$arr_contents = split("</body>",$arr_temp2[1]);
					
						/*
						array_pop($arr_contents);
						
						//print_r($arr_contents);
						//echo "<br>";
						
						$bodycontents = "";
						
						
						for($i=0;$i<=count($arr_contents);$i++) {				
								$bodycontents.=$arr_contents[$i]."</body>";
						}
						//echo $bodycontents;
						//if($bodycontents) {
							//	$bodycontents = substr($bodycontents,0,-7);  // ลบ </body> อันสุดท้ายทิ้ง
						//}
						$bodycontents = eregi_replace("</body>","",$bodycontents);
						*/
						$htmlcode = $arr_contents[0];
			}
							
			/*
			$htmlcode = str_replace($logo_401,"",$bodycontents);  //$temp_html; // $temp_code2[0];
			$htmlcode = eregi_replace($logo_wcag,"",$htmlcode); 
			$htmlcode = eregi_replace($logo_css,"",$htmlcode); 
			*/
			
			if($_GET["page_type"]==2) {  // ถ้ากำลัง save หน้า template
					$htmlcode = str_replace($SPLITTER,'',$htmlcode);	
					//	เอา <input name="w3c_spliter" type="hidden" value="##" alt=""> ออกก่อน  เพราะมันเป็นตัว $SPLITTER ไม่เกี่ยว
		     } // end  ถ้ากำลัง save หน้า template
			 
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
									
								//if($arr_tag[$i]=='marquee' ) {
										//echo "attribute_pack => $word1<br>";
								//		echo "len : ".strlen($word1)."<br>";
								//}	
								
									
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
											
											/*
											if(trim($arr_tag[$i])) {
												$text_js .= "<".trim($arr_tag[$i]);	
												
												//if( $app->is_tag($arr_tag[$i]) && eregi("/",$arr_tag[$i]) ) {
												//		$text_js .= ">";
												//}
											}
											$text_js .= " ".$attribute_pack[$i];
											
											if( $app->is_tag($arr_tag[$i]) ) {   // trim($attribute_pack[$i]) &&
											    $text_js .= ">";  // && !eregi("/",$arr_tag[$i]) 
											}
											if(trim($text_value[$i]) ) {
												$text_js .= " ".$text_value[$i];	
											}
											*/
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
						
							//echo "arr_words : ".$arr_words[$i]." <br><br>";
							//echo "arr_temp3[1]: ".$arr_temp3[1]." <br>";
							//echo "arr_temp2[1] : ".$arr_temp2[1]." <br>";
													
							if( strlen($arr_tag[$i]) <= 50 && trim($arr_tag[$i]) != "!doctype" && trim($arr_tag[$i])!="?php" ) { // เอาเฉพาะ ชื่อ tag จริงๆ มันต้องมี เว้นวรรค แล้วความยาวชื่อไม่เกิน 50 และไม่เอา DOCTYPE 
									
									if($in_script1==false && $in_script2==false ) { // ถ้า code แต่ละ record ที่ผ่านมาไม่ใช่  code ในช่วงของ tag script จึงจะ insert									
											$tagInfo = $app->tag_info(trim($arr_tag[$i]));
												
											//if(!$tagInfo[section_id]) {
											//		$tagInfo = $app->tag_info(trim(eregi_replace("/","",$arr_tag[$i])));
											//}
										
											if( trim($arr_tag[$i])=="meta" && eregi("charset", $attribute_pack[$i]) ) {  // charset=iso
													//  ไม่เอา meta ที่ charset=iso 
													
											} else {
											
													$INSERT = " INSERT INTO web_tag_html (filename, original_url, db_name, page_type, text_tag, text_value, text_attr, text_rank, section_edit) 
																					VALUES ('$filecheck', '', '".$main_db."', '".$_GET["page_type"]."', '".$disp->convert_qoute_to_db(trim($arr_tag[$i]))."', '".$disp->convert_qoute_to_db($text_value[$i])."', '".$disp->convert_qoute_to_db($attribute_pack[$i])."', '$rank', '".$tagInfo[section_id]."' )";
													$db2->query($INSERT);
																				
													//echo $INSERT."<br>";
													
													$text_id = mysql_insert_id();
													
													for($ci=0;$ci<count($arr_temp_attr);$ci++) {  // เก็บ Attribute ลง ตาราง web_attr											
														$piece_attr[$ci] = array();																						
														$piece_attr[$ci] = explode("=",$arr_temp_attr[$ci],2);											
														
														if(trim($piece_attr[$ci][0])) {  // ถ้า attribute_name มีค่า จึง insert
																
																$attb_info = $app->attr_info(trim($piece_attr[$ci][0]));  //  ดึงข้อมูลของ attribute ไว้ check													
															
																if( !eregi("=",$arr_temp_attr[$ci]) ) {  //  ถ้าไม่เจอ = ใน statement ของ attribute $arr_temp_attr[$ci] นี้
															
																		if($attb_info[no_assign_value]) {   // แล้วถ้าเป็น attribute ที่ ไม่ต้อง assign ค่าของมัน  
																
																			// insert ได้เลย
																			$INSERT2 = " INSERT INTO web_attr_html (text_attr_name, text_attr_value, text_id) 
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
																								
																								$attribute_info = $app->attr_info($arr_rebuild_attribute[0]);
																								if($attribute_info[attribute_type]!="url") {
																										$attribute_value = $disp->convert_qoute_to_db(trim($arr_rebuild_attribute[1]));
																								} else {
																										//$attribute_value =trim($arr_rebuild_attribute[1]);
																										$attribute_value =eregi_replace('"',$charac2,trim($arr_rebuild_attribute[1]));
																										$attribute_value =eregi_replace("'",$charac1,$attribute_value);
																								}
																								$INSERT2 = " INSERT INTO web_attr_html (text_attr_name, text_attr_value, text_id) 
																								VALUES ('".$disp->convert_qoute_to_db(trim($arr_rebuild_attribute[0]))."', '".$attribute_value."', '$text_id' ) ";
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
																		
																		$attribute_info = $app->attr_info($piece_attr[$ci][0]);
																		if($attribute_info[attribute_type]!="url") {
																				$attribute_value = $disp->convert_qoute_to_db(trim($piece_attr[$ci][1]));
																		} else {
																				//$attribute_value =trim($piece_attr[$ci][1]);
																				$attribute_value =eregi_replace('"',$charac2,trim($piece_attr[$ci][1]));
																				$attribute_value =eregi_replace("'",$charac1,$attribute_value);
																		}
																								
																		$INSERT2 = " INSERT INTO web_attr_html (text_attr_name, text_attr_value, text_id) 
																								VALUES ('".$disp->convert_qoute_to_db(trim($piece_attr[$ci][0]))."', '".$attribute_value."', '$text_id' ) ";
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
											 
											 $UPDATE = " UPDATE web_tag_html  SET  text_value = '".addslashes($disp->convert_qoute_to_db($text_js))."'  WHERE  text_id = '$js_id' AND text_tag = 'script' ";
											 //echo $UPDATE."<br>";
											 $db2->query($UPDATE);	 		
											 
											 $js_id = 0; // พอ update javascript ไปแล้ว ก็เคลียร์ค่า id ของเก่า = 0											 									 
									}
									if(trim($arr_tag[$i])=="/style") {											 
											 
											 $UPDATE = " UPDATE web_tag_html  SET  text_value = '".$disp->convert_qoute_to_db($text_css)."'  WHERE  text_id = '$css_id' AND text_tag = 'style' ";
											 //echo $UPDATE."<br>";
											 $db2->query($UPDATE);	 		
											 
											 $css_id = 0; // พอ update css ไปแล้ว ก็เคลียร์ค่า id ของเก่า = 0											 									 
									}
																		
							}																				
							
							//echo "<hr width='65%'>";
			}	// end for ใหญ่		
			
			$sql_chk_add = " SELECT  text_id, text_tag, text_rank  FROM  web_tag_html  WHERE filename = '$filecheck' AND db_name = '$main_db' AND page_type = '".$_GET["page_type"]."' AND text_tag = 'title' AND  ( text_status <> 'del'  OR text_status is null )  ";										
			$exec_chk_add = $db2->query($sql_chk_add);											
			$num_chk_add = $db2->num_rows($exec_chk_add);
			
			if($num_chk_add==0) {  // ถ้ายังไม่มี title  ให้ insert title document ด้วย
					
					$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '$filecheck' ");
					$F = $db->db_fetch_array($sql_index);											
					
					if($F["title"]){
						$ewt_mytitle = addslashes($F["title"]);
					}else{
						$sql_website = $db->query("SELECT site_info_title,site_info_keyword,site_info_description FROM site_info  ");
						$SF = $db->db_fetch_array($sql_website);
						$ewt_mytitle = addslashes($SF["site_info_title"]);
					}
			
					$title_info = $app->tag_info("title");
						
					$UPDATE = " UPDATE web_tag_html SET  text_rank = text_rank+1 WHERE   filename = '$filecheck' AND db_name = '$main_db' AND page_type = '".$_GET["page_type"]."'  ";
					$db2->query($UPDATE);
						// update rank ของ tag  ทั้งหมด ก่อนเพิ่ม tag ใหม่ จะง่ายกว่า  update rank ทีหลัง								
																																		
					$INSERT = " INSERT INTO web_tag_html(filename, db_name, page_type, text_tag, text_value, text_attr, text_rank, section_edit) VALUES ('$filecheck', '$main_db', '".$_GET["page_type"]."', 'title', '$ewt_mytitle', '', '0', '".$title_info[section_id]."' ) ";   
					$db2->query($INSERT);											
					
					$sql_chk_add = " SELECT  text_id, text_tag, text_rank  FROM  web_tag_html  WHERE filename = '$filecheck' AND db_name = '$main_db' AND page_type = '".$_GET["page_type"]."' AND text_tag = '/title' AND  ( text_status <> 'del'  OR text_status is null ) ";										
					$exec_chk_add = $db2->query($sql_chk_add);											
					$num_chk_add = $db2->num_rows($exec_chk_add);
					
					if($num_chk_add==0) { // ถ้ายังไม่มี /title  ให้ insert  ด้วย
						
						$UPDATE = " UPDATE web_tag_html SET  text_rank = text_rank+1 WHERE   filename = '$filecheck' AND db_name = '$main_db' AND page_type = '".$_GET["page_type"]."' AND  text_tag  <> 'title' ";
						$db2->query($UPDATE);
														
						$INSERT = " INSERT INTO web_tag_html(filename, db_name, page_type, text_tag, text_value, text_attr, text_rank, section_edit) VALUES ('$filecheck', '$main_db', '".$_GET["page_type"]."', '/title', '', '', '1', '".$title_info[section_id]."' ) ";   
						$db2->query($INSERT);
					
					}
			}

} // end  if ถ้ายังไม่มีการโหลด content จากหน้าที่แปลง W3C แล้ว


 if($_POST["run_edit"]) {
 			
			// ถ้ามีไฟล์หน้าเว็บ แต่ยังไม่มี ไฟล์ backup
			
			if($_GET["page_type"]==2) {  // Template
					if(file_exists($dir2.$filecheck.".php") &&  !file_exists($dir2.$filecheck."_bkupALT.php")) { 
							
								
							$passbackup = rename($dir2.$filecheck.".php", $dir2.$filecheck."_bkupALT.php");
							
							if(!$passbackup) {
									echo "ระบบ สำรองไฟล์เดิมไม่สำเร็จ  จึงไม่อนุญาตให้แก้ไข";
									exit;
							}
					 } // end file_exists
			} else {
					if(file_exists($dir1.$filecheck.".php") &&  !file_exists($dir1.$filecheck."_bkupALT.php")) { 
							
								
							$passbackup = rename($dir1.$filecheck.".php", $dir1.$filecheck."_bkupALT.php");
							
							if(!$passbackup) {
									echo "ระบบ สำรองไฟล์เดิมไม่สำเร็จ  จึงไม่อนุญาตให้แก้ไข";
									exit;
							}
					 } // end file_exists
			}
																
			for($ii=1;$ii<=$_POST["total_id"];$ii++) {			
																			
						$UPDATE = " UPDATE web_attr_html SET  text_edit_value = '".$charac2.$disp->convert_qoute_to_db($_POST["text_alt".$ii]).$charac2."'  WHERE  text_attr_id = '".$_POST["text_edit_id".$ii]."' AND text_attr_name = '".$_POST["text_attr_name".$ii]."' ";
						//echo "$UPDATE<br>";
						$result = $db2->query($UPDATE);																								
			
			}
			
			// ============= qeury ดึง tag ใน database มารวมเป็นหน้าเว็บอีกรอบ ============== //						
			
			if($_GET["page_type"]==2) {   // Template 
						
						$sql_w3c = " SELECT  *  FROM  web_tag_html  WHERE filename = '$filecheck' AND db_name = '$main_db' AND page_type = '".$_GET["page_type"]."' AND text_tag NOT IN ('!doctype', 'html', 'head', 'body', '/html', '/head', '/body') 
														ORDER BY section_edit, text_rank, text_id ";
						$exec_w3c = $db2->query($sql_w3c);	
						
						$head_contents = "";
						
						$sql_body = " SELECT  *  FROM  web_tag_html  WHERE filename = '$filecheck' AND db_name = '$main_db' AND page_type = '".$_GET["page_type"]."' AND text_tag = 'body' 
														ORDER BY section_edit, text_rank, text_id ";
						$exec_body = $db2->query($sql_body);	
						$rec_body = $db2->fetch_array($exec_body);
						
						$close_comment_text = $close_comment_attr = "";
								
						if(eregi("--$",$rec_body[text_attr])) {
							$close_comment_attr = "--";
						}					
						
						$sql_atb = " SELECT  *  FROM  web_attr_html  WHERE text_id = '".$rec_body[text_id]."' 
																							ORDER BY text_attr_id ";
																$exec_atb = $db2->query($sql_atb);
																$text_up_attr = "";
																while($rec_atb=$db2->fetch_array($exec_atb)) {
																		if($rec_atb[text_edit_value]) {
																				$edit_attr = $rec_atb[text_edit_value];
																		} else {
																				$edit_attr = $rec_atb[text_attr_value];
																		}
																		
																		$rec_attr_info = $app->attr_info($rec_atb[text_attr_name]);
																		
																		if(trim($rec_atb[text_attr_name])) {
																			if($rec_attr_info[no_assign_value]) {	// ถ้าเป็น attribute ที่ ไม่ต้อง assign ค่าของมัน
																				$text_up_attr .= $rec_atb[text_attr_name]." ";
																			} else {																						
																				$text_up_attr .= $rec_atb[text_attr_name]."=".$edit_attr." ";
																			}
																		}
																}
										
						$new_contents = "<".$disp->convert_specials_char($rec_body[text_tag])." ".$disp->convert_specials_char($text_up_attr).$close_comment_attr.">".$disp->convert_specials_char($rec_body[text_value]).$close_comment_text;
											
						// ดึง BODY เริ่มต้นของ template มาเก็บไว้ใน $new_contents ก่อน tag อื่น 	
									
						// ส่วน $sql_w3c มันไม่ดึง BODY อยู่แล้ว  จึงไม่ต้องกลัวซ้ำ
						
			} else {   // BODY
						$sql_w3c = " SELECT  *  FROM  web_tag_html  WHERE filename = '$filecheck' AND db_name = '$main_db' AND page_type = '".$_GET["page_type"]."' AND text_tag NOT IN ('!doctype', 'html', 'head', 'body', '/html', '/head', '/body') 
														ORDER BY section_edit, text_rank, text_id ";
								$exec_w3c = $db2->query($sql_w3c);																
								
																
								$head_contents = file_get_contents("style.html");  // head section
								
								$COMPTOP = file_get_contents("comptop.html");  
								$COMPBOTTOM = file_get_contents("compbottom.html");
								
								$new_contents = ""; // body section
								
								//  ********ไว้ค่อยมา query  ดึง content ใน Template จาก webpage_info ที่ field ชื่อ use_template_name 
								
			}	//  end else 
															
				//echo "$sql_w3c<br>";
								
								$body_attr = ""; // อันนี้ไว้กำหนดทีหลัง อาจไม่มี ก็ได้
								
								while($rec_w3c=$db2->fetch_array($exec_w3c)) {
										
										$close_comment_text = $close_comment_attr = "";
										
										if(eregi("--$",$rec_w3c[text_attr])) {
											$close_comment_attr = "--";
										}
										/*
										if(eregi("--$",$rec_w3c[text_value])) {
											$close_comment_text = "--";
										}
										*/
										
										if($rec_w3c[text_tag]=="script" || $rec_w3c[text_tag]=="style" ) {  // ถ้าเจอ tag  script หรือ style
											 
												$in_script = true;
												
												$sql_atb = " SELECT  *  FROM  web_attr_html  WHERE text_id = '".$rec_w3c[text_id]."' 
																									ORDER BY text_attr_id ";
																		$exec_atb = $db2->query($sql_atb);
																		$text_up_attr = "";
																		while($rec_atb=$db2->fetch_array($exec_atb)) {
																				if($rec_atb[text_edit_value]) {
																						$edit_attr = $rec_atb[text_edit_value];
																				} else {
																						$edit_attr = $rec_atb[text_attr_value];
																				}
																				
																				$rec_attr_info = $app->attr_info($rec_atb[text_attr_name]);
																				
																				if(trim($rec_atb[text_attr_name])) {
																					if($rec_attr_info[no_assign_value]) {	// ถ้าเป็น attribute ที่ ไม่ต้อง assign ค่าของมัน
																						$text_up_attr .= $rec_atb[text_attr_name]." ";
																					} else {																						
																						$text_up_attr .= $rec_atb[text_attr_name]."=".$edit_attr." ";
																					}
																				}
																		}
												if($rec_w3c[section_edit]==3) {  //  head 
												
													$head_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag])." ".$disp->convert_specials_char($text_up_attr).$close_comment_attr.">".$disp->convert_specials_char($rec_w3c[text_value]).$close_comment_text;
													
												} else {	// ถ้าเป็น section 4 body  หรือ ไม่รู้ section ไหน ให้เก็บไว้ในตัวแปร body $new_contents ไว้ก่อน
												
													$new_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag])." ".$disp->convert_specials_char($text_up_attr).$close_comment_attr.">".$disp->convert_specials_char($rec_w3c[text_value]).$close_comment_text;
													
												}
																		
										}
										if( $rec_w3c[text_tag]=="/script" || $rec_w3c[text_tag]=="/style") {  // ถ้าเจอ tag  /script หรือ /style
												 
												$in_script = false;
										}
										
										if($in_script) {   // ถ้าอยู่ในช่วง tag script เปิด - ปิด
												// ไม่ให้ เขียน tag ลงไฟล์แบบปกติ
										} else {
										
												if($rec_w3c[text_status] == 'del') {			
														if($rec_w3c[text_tag]!='title') { // ถ้า tag ที่ลบไปแล้วไม่ใช่ title 																												 
															$new_contents .= $rec_w3c[text_value].$close_comment_text;	// จึงจะเก็บเข้าตัวแปร body											
														}
												} else {
														// ถ้าไม่มี สถานะ ลบ del
														if($rec_w3c[text_tag]) {
								
																	if(!eregi("^/",$rec_w3c[text_tag])) { // ถ้าไม่ใช่ tag ปิด
																		
																		/*if($rec_w3c[text_edit_attr]) {
																				$edit_attr = $rec_w3c[text_edit_attr];
																		} else {
																				$edit_attr = $rec_w3c[text_attr];
																		}*/
																		$sql_atb = " SELECT  *  FROM  web_attr_html  WHERE text_id = '".$rec_w3c[text_id]."' 
																									ORDER BY text_attr_id ";
																		$exec_atb = $db2->query($sql_atb);
																		$text_up_attr = "";
																		while($rec_atb=$db2->fetch_array($exec_atb)) {
																				if($rec_atb[text_edit_value]) {
																						$edit_attr = $rec_atb[text_edit_value];
																				} else {
																						$edit_attr = $rec_atb[text_attr_value];
																				}
																				
																				//////  code ตรงนี้ไม่เหมือนกับตอนสะสม javascript นะ อย่า copy ไปทับ สะสม script
																				$rec_attr_info = $app->attr_info($rec_atb[text_attr_name]);
																				
																				if(trim($rec_atb[text_attr_name])) {			
																					if($rec_attr_info[no_assign_value]) {	// ถ้าเป็น attribute ที่ ไม่ต้อง assign ค่าของมัน  															
																						$text_up_attr .= $disp->convert_specials_char($rec_atb[text_attr_name])." ";
																					} else {																						
																						$text_up_attr .= $disp->convert_specials_char($rec_atb[text_attr_name])."=".$disp->convert_specials_char($edit_attr,$rec_attr_info[attribute_type])." ";
																					}
																				}
																		}
																		if($rec_w3c[section_edit]==3) {  //  head 
												
																			$head_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag])." ".$text_up_attr.$close_comment_attr.">".ereg_replace("&amp;",'&',$rec_w3c[text_value]).$close_comment_text;
																			
																		} else {	// ถ้าเป็น section 4 body  หรือ ไม่รู้ section ไหน ให้เก็บไว้ในตัวแปร body $new_contents ไว้ก่อน																			
																			$new_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag])." ".$text_up_attr.$close_comment_attr.">".ereg_replace("&amp;",'&',$rec_w3c[text_value]).$close_comment_text;  
																			
																		}
																		
																	} else { // ถ้าเป็น tag ปิด
																	
																			if($rec_w3c[section_edit]==3) {  //  head 
													
																				$head_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag]).$close_comment_attr.">".ereg_replace("&amp;",'&',$rec_w3c[text_value]).$close_comment_text;
																				
																			} else {	// ถ้าเป็น section 4 body  หรือ ไม่รู้ section ไหน ให้เก็บไว้ในตัวแปร body $new_contents ไว้ก่อน
																				$new_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag]).$close_comment_attr.">".ereg_replace("&amp;",'&',$rec_w3c[text_value]).$close_comment_text;
																			}
																	}			
														} else {  // แม้ ไม่มี tag อะไร ก็ต้องเก็บเนื้อหาเว็บด้วย
																// ไม่มี tag ก็ไม่รู้ section ไหน ดังนั้นเก็บเข้า body เท่านั้น ไปเลย
																																														
																$new_contents .= $rec_w3c[text_value];
														}				
												
												}	// end ถ้าไม่มี สถานะ ลบ del						
									 } // end else $in_script
							} // while tag 
					
				  $new_contents = eregi_replace("  "," ",$new_contents); // แก้เว้นวรรคเกิน 1 
				  $new_contents = eregi_replace(" >",">",$new_contents);
					
					/*	
						// ===========  Check Add Logo =========	
						$sql_check = " SELECT  * FROM  webpage_info  WHERE filename = '$filecheck' AND db_name = '".$main_db."' AND page_type = '".$_GET["page_type"]."'    ";
		
						$exec_check = $db2->query($sql_check);
						$num_check = $db2->num_rows($exec_check);
						$rec_check = $db2->fetch_array($exec_check);	
						
						if($rec_check["w3c_html"]=="w3c") {
								$COMPBOTTOM.=$logo_401;								
						}
						if($rec_check["w3c_wcag"]=="w3c") {
								$COMPBOTTOM.=$logo_wcag;								
						}
						if($rec_check["w3c_css"]=="w3c") {
								$COMPBOTTOM.=$logo_css;								
						}
				*/
			if($_GET["page_type"]==2) {	  // Template 	
			
						if(eregi("id=\"ewt_main_structure_body\"" ,$new_contents)) {
									$arr_check = split("id=\"ewt_main_structure_body\"",$new_contents,2);
									$arr_check2 = split(">",$arr_check[1],2);
									if($arr_check2[1] ) {																								
																					
											$clear_spliter = str_replace($SPLITTER,'',$arr_check2[1]);										
											$arr_check2[1] = $SPLITTER.$clear_spliter;
											
											//echo htmlspecialchars($spliter);
											//echo "<BR>";
											$new_contents = $arr_check[0]."id=\"ewt_main_structure_body\"".$arr_check2[0].">".$arr_check2[1];																							
											
									} else {
											$arr_check2[1] = $SPLITTER;
											$new_contents = $arr_check[0]."id=\"ewt_main_structure_body\"".$arr_check2[0].">".$arr_check2[1];
									}																														
							// เอา <input name="w3c_spliter" type="hidden" value="##" alt=""> แทรกกลับเข้าไป หลังจากรวม tag เป็นหน้าเว็บอีกครั้ง
						}		
						
						$phpcontents = $dtd_html_head_charset_top.$head_contents.$dtd_html_head_charset_bottom.$new_contents."</body>".$END_PAGE;		
								
						$phpcontents = eregi_replace("  "," ",$phpcontents);  // แก้เว้นวรรคเกิน 1 
						$phpcontents = eregi_replace(" >",">",$phpcontents); // แก้เว้นวรรคเกิน 1 
											
						if(file_exists($dir2)) {									
								$result1 = $disp->testvar_infile($phpcontents, $dir2.$filecheck.".php", "w");// จึงต้อง write file แืืทน 
						}
			} else {	// BODY
						
						$phpcontents = $dtd_html_head_charset_top.$head_contents.$dtd_html_head_charset_bottom." <body>".$COMPTOP.$new_contents.$COMPBOTTOM."</body>".$END_PAGE;
								
						$phpcontents = eregi_replace("  "," ",$phpcontents);  // แก้เว้นวรรคเกิน 1 
						$phpcontents = eregi_replace(" >",">",$phpcontents); // แก้เว้นวรรคเกิน 1
						
						if(file_exists($dir1)) {									
								$result1 = $disp->testvar_infile($phpcontents, $dir1.$filecheck.".php", "w");// จึงต้อง write file แืืทน 
						}
			}
								//echo $UserPath.$dir1." : ".file_exists($UserPath.$dir1)."<br>";  //  เราลองแล้ว path $dir1 นี้มีแยู่จริง
						
			// ============= qeury ดึง tag ใน database มารวมเป็นหน้าเว็บอีกรอบ ============== //					
			
			?><script language="javascript1.2">
				alert("บันทึกคำบรรยายภาพ เรียบร้อยแล้ว");
				opener.location.reload();
				//window.close();			
				</script>		
			<?php					
}									


	 /////////////////////////  Validating W3C ทีละหน้าเว็บ  //////////////////////////////////////
?>
<body>
<h2>กรอกคำบรรยายภาพ</h2>
 <table cellspacing="0" cellpadding="2">
 <tr><td >
 <img src="images/photo_portrait.gif" alt="กรอกคำบรรยายภาพ" border="0"  align="absmiddle" onClick="
                    window.location = 'w3c_editor.php?filename=<?php echo $filecheck;?>&page_type=<?php echo $_GET["page_type"];?>';
					 "  style="cursor:pointer">กลับหน้า W3C Editor 
 </td></tr></table>
 <form name="frm" method="post" action="w3c_alt.php" >														
<table id="tb_check_alt"  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse">
							<tr> <td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>
									<td width="700"><strong>รายการ / คำอธิบาย</strong></td>
									</tr>
							<?php 
							
							$ii=1;
							
							$sqlAttr1 = " SELECT  DISTINCT tag_name, attribute_name, recommend, correct_value  FROM  value_edit_attr_tag  WHERE  notnull = '1' AND ( attribute_name IN ('alt','title') ) ORDER BY  tag_name, attribute_name ";
							// ตรวจสอบ attribute ที่ไม่มีการ set ค่าเลยไม่ได้
							
							/*$sqlAttr1 = " SELECT  *  FROM  value_edit_attr_tag  WHERE ( attribute_name = 'alt' OR attribute_name = 'title' ) AND ( wrong_value IS NULL  OR  wrong_value = '' ) AND (  correct_value <> '*del*' AND correct_value <> '*M*')  ORDER BY  tag_name, attribute_name ";*/
							//echo "$sqlAttr1<br><br>";
							// WHERE  ( wrong_value IS NULL  OR  wrong_value = '' ) AND  correct_value = '***' 
							$execAttr1 = $db2->query($sqlAttr1);
							while($recAttr1 = $db2->fetch_array($execAttr1)) {		
									
									$tag_name = $recAttr1[tag_name];
									$attribute_name = $recAttr1[attribute_name];
									
									$recommend = $recAttr1[recommend];
									
									$correct_value = $recAttr1[correct_value];
									
									$sql_webtag = " SELECT  `web_tag_html`.`text_id`,
																	  text_tag,
																	  `web_tag_html`.`text_status` ,
																	  text_rank
																	FROM  web_tag_html  
																	WHERE
																		filename = '$filecheck' AND db_name = '$main_db'  AND 
																		page_type = '".$_GET["page_type"]."'  AND text_tag = '$tag_name'  AND  ( text_status <> 'del'  OR text_status is null )
																	ORDER BY  text_rank, text_id";
									//echo "$sql_webtag<br><br>";
									$exec_webtag = $db2->query($sql_webtag);		
									
									while($rec_webtag =  $db2->fetch_array($exec_webtag)) {
												
												$text_id = $rec_webtag[text_id];
												
												$sqlChkAttr1 = " SELECT 																	
																	  `web_attr_html`.`text_attr_id`,
																	  `web_attr_html`.`text_attr_name`,
																	  `web_attr_html`.`text_attr_value`,
																	  `web_attr_html`.`text_edit_value`
																	FROM
																	`web_attr_html` 
																	WHERE																																																
																	text_id = '$text_id'  AND `web_attr_html`.`text_attr_name` = '$attribute_name'  ";
												
												$execChkAttr1 = $db2->query($sqlChkAttr1);		
												//echo "$sqlChkAttr1<br><br>";
												
												$numChkAttr1 = $db2->num_rows($execChkAttr1); 
												// จำนวน tag ที่มี $attribute_name																								
												
												if($numChkAttr1>0 ) {		 //  ถ้ามี alt อย่างน้อย == "" แล้ว
														
														$rec_alt =  $db2->fetch_array($execChkAttr1);
														$text_attr_id = $rec_alt[text_attr_id];
														$text_attr_name = $rec_alt[text_attr_name];
														
														$value_alt = ($rec_alt[text_edit_value])? $rec_alt[text_edit_value]:$rec_alt[text_attr_value];
														
														$show_alt  = eregi_replace("(".$charac2.")|(".$charac1.")","",$value_alt);
														
														$show_pic  = "";														 																												 														
														$result  = 0;
																
														$sqlChk2 = " SELECT 
															  `web_attr_html`.`text_attr_id`,
															  `web_attr_html`.`text_attr_name` AS text_attr_name,
															  `web_attr_html`.`text_attr_value`,
															  `web_attr_html`.`text_id`,
															  `web_attr_html`.`text_edit_value`
															FROM
															  `web_attr_html`
															  WHERE text_attr_name = 'src' AND text_id = '".$text_id."' ";
															  
														$execChk2 = $db2->query($sqlChk2);
														$recChk2 = $db2->fetch_array($execChk2);								
														
													$src_current = ($recChk2[text_edit_value])? $recChk2[text_edit_value]:$recChk2[text_attr_value];
														//echo "src_current : $src_current<br>(".$charac2.")|(".$charac1.")<br>";
														$src_preview = eregi_replace("(".$charac2.")|(".$charac1.")","",$src_current);
														$src_preview  = eregi_replace("(&amp;)","&",$src_preview); 
														$src_preview = eregi_replace('http:/','http://',eregi_replace("//","/",$src_preview));
														//echo "$src_preview => ";
														$src_preview  = eregi_replace("../../","../",$src_preview); 
																												
														
														//echo "$src_preview <br>";
														//$src_preview = "../".$src_preview;
														//echo "cc: ".strpos($src_preview,"../")." => ";
														//echo "cc : ".eregi("^../", $src_preview);
														
														if( $src_preview  &&  (  ( !eregi("^../", $src_preview) && (substr_count($src_preview, '.') < 3) &&  !eregi("^http:", $src_preview)  && !eregi("^www.", $src_preview) ) || (eregi($CS_WWW, $src_preview) &&  !eregi("/w3c", $src_preview) ) ) ) {
														  //  ถ้าค่าของ $arr_tail[0]  มี . น้อยกว่า 3 อัน แปลว่าไม่ใช่ขึ้นต้นด้วย IP  แล้วจึงจะแก้ path โดยเติม ../../																			
														  $src_preview = "../".$src_preview;
																
														}
														
														//if(!eregi("phpThumb.php",$src_preview)) {
														//		$src_preview = "../phpThumb.php?w=120&h=120&src=".str_replace("../","",$src_preview);
														//}
														
														//echo "$src_preview <br>";
														// เนื่อง w3c_validator.php ที่ใช้งานอยู่นี้ ต้องย้อน path รูป แค่ครั้งเดียว ซึ่งต่างจาก web ที่ convert เป็น output ไปวางใน checked แล้ว จึงจะย่้อน path 2 ครั้ง
														//$src_preview= "http://www.google.co.th";
														
														
														$show_pic = "<img src=\"$src_preview\" alt=\"$show_alt\" border=\"0\" > ";
														
	
											 				?><tr>
															<td  align="center"><?php echo $rec_webtag[text_rank];?> </td>
															<td><?php echo strtoupper($rec_webtag[tag_name]);?> <?php echo $recommend;?><br><?php  if(strtoupper($tag_name)=="IMG" ) { echo $show_pic; } ?><br>
                                                            <input name="text_edit_id<?php echo $ii;?>" type="hidden" value="<?php echo $text_attr_id;?>"><input name="text_attr_name<?php echo $ii;?>" type="hidden" value="<?php echo $text_attr_name;?>"><input name="text_alt<?php echo $ii;?>" type="text" size="30" value="<?php echo $show_alt;?>">
                                                            </td>											 				                                                            
                                                         </tr><?php 														 																		
																																																					
														$ii++;
												} // if($numChkAttr1>0 )
									} // while  $rec_webtag
					
					} // while $recAttr1
									
				  ?></table><br>		
				<br>
            <input name="total_id" type="hidden" value="<?php echo --$ii;?>">
			<input name="bt_edit" type="button" value=" บันทึก " onClick="return chkInput()">
<?php 									
$db2->close_db();
$db->db_close();			
?>
<input name="page_type" type="hidden" value="<?php echo $_GET["page_type"];?>">
<input name="filecheck" type="hidden" value="<?php echo $filecheck;?>"><input name="run_edit" type="hidden">
<input name="close" type="button" value="       ปิดหน้าต่าง      " onclick="window.close();">
</form>
</body>
</html>
