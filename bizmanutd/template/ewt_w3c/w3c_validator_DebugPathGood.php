<?php  
 	session_start();
	$start_time_counter = date("YmdHis");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	/*
	include("../../../ewt_block_function.php");
	include("../../../ewt_menu_preview.php");
	include("../../../ewt_article_preview.php");
	include("../../../ewt_public_function.php");
	*/ 	
	//$UserPath = "\\\\192.168.0.250\\ictweb\\";  ย้ายไปไว้ใน config.inc.php ของเราแล้ว
	//$Website = "http://192.168.0.250/ewtadmin/ewt/ictweb/";
	//$UserPath = "\\\\".$EWT_ROOT_HOST."\\".$EWT_FOLDER_USER."\\";
	//$Website = "http://".$EWT_ROOT_HOST."/ewtadmin/ewt/".$EWT_FOLDER_USER."/";  // ictweb
	
	$main_db = $EWT_DB_NAME; //"db_163_ictweb";  อาจไม่ต้องใช้ ฐานข้อมูลลูกค้าเลย  เพราะเราอ่านข้อมูลจากหน้าเวบ url โดยตรง
	
	
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
<title><?php echo $proj_title;?> - BIZ Validator</title>
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
<?php 
if($_POST["filecheck"]) {
		$_GET["filename"] = $_POST["filecheck"];
}

if(!$_GET["filename"]) {
	echo "<H2>ไม่ได้ระบุชื่อเว็บเพจ</H2>";
	exit;
}
$urladdr = $Website."main_body.php?filename=".$_GET["filename"];

$dir1 = "w3c\\checked\\";												
if(!file_exists($UserPath.$dir1)) {  // ถ้าไม่มี   folder checked ให้สร้างก่อน
		mkdir($UserPath.$dir1,0777);
}

$filecheck = $_GET["filename"];



	 /////////////////////////  Validating W3C ทีละหน้าเว็บ  //////////////////////////////////////
?>
<body>
 <form name="frm" method="post" action="w3c_validator.php" >														
					<H2>ผลการตรวจสอบเว็บเพจ : <span style="font-size:small; color:#FF0000"><?php echo $filecheck;?></span></H2> 
			<?php 							
							$sql_notbe = " SELECT * FROM  tag_notbe_inside  ORDER BY tag_name, donot_be_inside ";									
							$exec_notbe = $db2->query($sql_notbe);
			
							$t=1;		
				
							while($rec_notbe=$db2->fetch_array($exec_notbe)) {
											
											$sql_tag_allow = " SELECT  *  FROM  tag_canbe_inside  WHERE  tag_name = '".$rec_notbe[tag_name]."' ";
											$exec_tag_allow = $db2->query($sql_tag_allow);
											
											$tag_allows = $filter_allows = "";
											while($rec_tag_allow = $db2->fetch_array($exec_tag_allow)) {
													$tag_allows .= "'".$rec_tag_allow[start_tag]."', ";
											}
											
											if($tag_allows) {
												$tag_allows = substr($tag_allows,0,-2);
												
												$filter_allows = " AND (  ( ( SELECT text_tag FROM web_tag WHERE  filename = '$filecheck' AND db_name = '$main_db'  AND ( text_status <> 'del' OR text_status is null ) AND text_rank = (x1 - 1) ) NOT IN ($tag_allows) ) OR  ( ( SELECT text_tag FROM web_tag WHERE  filename = '$filecheck' AND db_name = '$main_db'  AND ( text_status <> 'del' OR text_status is null ) AND text_rank = (x1 - 1) ) is null ) ) ";
												$tag_allows = eregi_replace("'","",$tag_allows);
											}
														
														
											// check ว่า tag_name ที่ห้ามอยู่ภายใน donot_be_inside (ภายใน tag เปิด-ปิด)	มีอยู่ในหน้าเว็บที่อ่านเข้ามาในตาราง web_tag รึป่าว
											
											$sql_chk1 = " 
											SELECT *, text_rank AS x1 FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_notbe[tag_name]."' AND
 ( text_rank > ( SELECT MAX(text_rank) AS max_open FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_notbe[donot_be_inside]."'  AND text_rank < x1 HAVING  max_open > ( SELECT MAX(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '/".$rec_notbe[donot_be_inside]."' AND text_rank < x1 )  OR ( SELECT MAX(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND  text_tag = '/".$rec_notbe[donot_be_inside]."'  AND text_rank < x1 ) IS NULL ) ) AND
 ( text_rank < ( SELECT MIN(text_rank) AS min_close  FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '/".$rec_notbe[donot_be_inside]."'  AND text_rank > x1  HAVING  min_close < ( SELECT MIN(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_notbe[donot_be_inside]."'  AND text_rank > x1 )  OR ( SELECT MIN(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_notbe[donot_be_inside]."'  AND text_rank > x1 ) IS NULL ) )  $filter_allows
ORDER BY text_rank, text_id 
										
											";  // query นี้ทดลอง แก้ไข อยู่นานมาก กว่าจะทำให้ work โดยไม่มี bug เลย
																						
											/*
												SELECT *, text_rank AS x1 FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db'  AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_notbe[tag_name]."'  AND
 ( text_rank > ( SELECT MAX(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db'  AND text_tag = '".$rec_notbe[donot_be_inside]."'  AND text_rank < x1 ) ) AND
 ( text_rank < ( SELECT MIN(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db'  AND text_tag = '/".$rec_notbe[donot_be_inside]."'  AND text_rank > x1 ) )  ORDER BY text_rank, text_id  */
							
											$exec_chk1 = $db2->query($sql_chk1);			
											
											$notbein_err = $db2->num_rows($exec_chk1);	
											
											if($notbein_err) {
														//echo "$sql_chk1<br><br>";   //เคยใช้ echo ตรงนี้แล้ว work ดี
														$invalid=true;
														$total_err+=$notbein_err;
											?>
											<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse">
															<tr valign="top">
															<td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>
															<td width="550"><strong>รายการ / คำอธิบาย</strong></td>
															<?php  if(!$_POST["run_edit"]) { ?>
															<td width="300"><strong>ทางแก้ปัญหา</strong></td>
															<?php  } ?>
															<?php  if($_POST["run_edit"]) { ?>
																<td width="200" align="center"><strong>สถานะการแก้ไข</strong></td>
																<td width="100" align="center"><strong>ตำแหน่ง Tag<br>หลังแก้ไข</strong></td>
															<?php  } ?></tr>
												<?php 				
												$u=1;						
												while($rec_chk1 = $db2->fetch_array($exec_chk1)) {
														
														/*
														$sql_tag_allow = " SELECT  *  FROM  tag_canbe_inside  WHERE  tag_name = '".$rec_chk1[text_tag]."' ";
														$exec_tag_allow = $db2->query($sql_tag_allow);
														
														$tag_allows = "";
														while($rec_tag_allow = $db2->fetch_array($exec_tag_allow)) {
																$tag_allows .= $rec_tag_allow[start_tag].", ";
														}
														if($tag_allows) {
															$tag_allows = substr($tag_allows,0,-2);
														}
														*/
														$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '".$rec_chk1[text_id]."'  ";
																									
														$exec_newrank  = $db2->query($sql_newrank);
														$rec_newrank = $db2->fetch_array($exec_newrank);																												
																												
														$text_rank_open = $rec_newrank[text_rank];	// text_rank_open ของ tag ที่มีปัญหา
																	
														$filter_solution = "";
														
														$rec_tag_info = $app->tag_info($rec_chk1[text_tag]);
														
														if($rec_tag_info[tag_set]=='N') { // ถ้า tag_set = N ไม่ให้ย้าย tag
																$filter_solution = " WHERE solution_id <> '2' ";
																
														} else if($rec_tag_info[tag_set]=='1') { // ถ้า tag ที่มีปัญหานี้ เป็น tag ที่ต้องย้ายทั้งชุด เช่น table, select
														 //  **************** ล่าสุดไม่ให้ย้ายทั้งชุด ************
														
																// หา text_rank ของ tag ปิดที่ใกล้ที่สุดของ  $rec_chk1[text_tag] ที่มีปัญหาก่อน																																		
																$sql_rec_chk1 = " SELECT  MIN(text_rank) AS min_close  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$rec_chk1[text_tag]."'  AND  text_rank > '$text_rank_open'   ";
																					
																$exec_rec_chk1  = $db2->query($sql_rec_chk1);
																$rec_rec_chk1 = $db2->fetch_array($exec_rec_chk1);
																
																$text_rank_close = $rec_rec_chk1[min_close];
																
																$sql_id = " SELECT text_id, text_tag  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND  text_rank = '$text_rank_close' AND  text_tag = '/".$rec_chk1[text_tag]."' ";																				
																$exec_id  = $db2->query($sql_id);
																$rec_id = $db2->fetch_array($exec_id);
																$text_id_close = $rec_id[text_id];		
																
																//if(!$text_id_close)  { // ถ้าไม่พบ tag ปิด ของ tag ที่ต้องย้ายทั้งชุด
																		$filter_solution = " WHERE solution_id <> '2' ";	// ไม่ให้ ย้าย tag
																//}
														}
														?>
														<tr valign="top">
															<td align="center" width="100"><?php echo $rec_chk1[text_rank];?></td>
															<td  width="550"><span style="color:red">ไม่อนุญาตให้</span> tag <strong><?php echo strtoupper($rec_chk1[text_tag]);?></strong> อยู่ภายใน tag <?php echo strtoupper($rec_notbe[donot_be_inside]);?> โดยปราศจาก Start-Tag ดังนี้ <br><?php echo strtoupper($tag_allows);?>  <?php  if(trim($app->show_tag_attribute($rec_chk1[text_id]))) { 
																 // show รายละเอียด tag ที่อยู่ภายใน tag ต้องห้าม และ attribute ของมัน
																 echo "<fieldset><legend>รายละเอียด tag</legend>".$disp->convert_qoute_to_db($app->show_tag_attribute($rec_chk1[text_id]))."</fieldset>";
															 }
															 ?> </td>
															<?php  if(!$_POST["run_edit"]) { ?>
															<td width="300" >
															<?php 
																$sql_options = " SELECT * FROM solution  $filter_solution ORDER BY solution_id ";
																
																// ให้เลือกทางแก้ปัญหา และ AJAX  solve_detail.php จะแสดงรายละเอียด ให้ระบุเพิ่มเติม
															?>
																<select name="solution_id<?php echo $t;?>_<?php echo $u;?>" onChange="
																 url='ajax/solve_detail.php?filecheck=<?php echo $filecheck;?>&main_db=<?php echo $main_db;?>&text_tag=<?php echo $rec_chk1[text_tag];?>&runvar=<?php echo $t;?>_<?php echo $u;?>&solution_id='+this.value;
																 load_divForm(url,'div<?php echo $t;?>_<?php echo $u;?>'); ">
																<option value="">==เลือก==</option>
																<?php  $disp->ddw_list_selected($sql_options,"solution_name", "solution_id"); ?>
																</select>
																<div id="div<?php echo $t;?>_<?php echo $u;?>"></div>
																<?php  echo " solution_id".$t."_".$u." : ".$_POST["solution_id".$t."_".$u]."<br>"; ?>
															</td>
															<?php  } ?>
															<?php 
															 if($_POST["run_edit"]) {
																	$result = 0;
																	
												// ลองใช้ตัวแปร $t กับ $u ในการระบุ ตัวแปรไปก่อน ถ้าเกิดมัน อ้างถึงตัวแปรมั่วเพราะ มีการ insert/update record
												// ค่อยลองใช้ $text_id ในการเข้าถึงตัวแปรแทน 
																	
																	$sql0 = " SELECT * FROM solution WHERE solution_id = '".$_POST["solution_id".$t."_".$u]."' ";
																	$exec0 = $db2->query($sql0);																	
																	$rec0 = $db2->fetch_array($exec0);
																	
																	if($_POST["solution_id".$t."_".$u]==1) {  // ถ้าเลือกทางแก้เป็น การครอบด้วย Start-Tag
																				$sql1 = " SELECT * FROM tag_canbe_inside  WHERE tag_name = '".$rec_chk1[text_tag]."' AND start_tag = '".$_POST["start_tag".$t."_".$u]."' ";
																				$exec1 = $db2->query($sql1);
																				$rec1 = $db2->fetch_array($exec1);
																				
																				$start_tag_info = $app->tag_info($_POST["start_tag".$t."_".$u]);
																				
																			// text_rank_open ของ Start Tag ที่ครอบ	( ย้ายไป query ข้างบนทีเดียวแล้ว )																																				
																				// คือ ตำแหน่ง rank เดียวกับ tag ที่มีปัญหา  และเดี๋ยว rank+1 ตั้งแต่ tag ที่มีปัญหา ลงไป
																				
																				//////////////// INSERT tag เปิดของ start_tag 																																				
																				$INSERT = " INSERT INTO web_tag(filename, db_name, text_tag, text_value, text_attr, text_rank, section_edit) VALUES ('$filecheck', '$main_db', '".$_POST["start_tag".$t."_".$u]."', ' ', '".$rec1[need_attr]."', '$text_rank_open', '".$start_tag_info[section_id]."' ) ";  //   
																				//echo "$INSERT<br>";
																				$cpass1 = $db2->query($INSERT);
																				
																				$add_text_id = mysql_insert_id();
																				
										////////////  ส่วนแยก attribute จาก $rec1[need_attr]  ซึ่งเก็บมาจาก ค่า default ในตาราง tag_canbe_inside
									 
									$arr_temp_attr = array();
									
									$word1 = trim($rec1[need_attr]);
									$cnt_qoute = 0;
									$cnt_sqoute = 0;
									$attr_no = 0;																												
								
									for($pos=0;$pos<strlen($word1);$pos++){
																						
											if( $cnt_sqoute == 0 && $word1[$pos]=='"' ) { // ถ้า เจอ " โดยไม่มี ' มาก่อน  ( ใช้ &quot; ไม่ได้ เพราะ เราตรวจทีละตัวอักษร )
												$cnt_qoute++; // นับจำนวน "
												
											} else if( $cnt_qoute == 0 && $word1[$pos]=="'") { 
													// ถ้าไม่เจอ " จึงจะ check ถ้า เจอ ' โดยไม่มี " มาก่อน ( ใช้ &#039; ไม่ได้ เพราะ เราตรวจทีละตัวอักษร ) 
												$cnt_sqoute++; // นับจำนวน '
											
											}
											
											$arr_temp_attr[$attr_no] .= $word1[$pos];
											
											if($pos>0) {
																																			
												//if($arr_tag[$i]=='marquee' ) {
												//	echo "$cnt_qoute==0 && ".$word1[$pos]."==\" \" ) || $cnt_qoute==2<br>";
												//}
											
												if( ( $cnt_qoute==0 && $word1[$pos]==" " ) || $cnt_qoute==2  ) {
													 // ถ้าไม่มี " แล้วเจอ space หรือ ถ้าเจอ " 2 ตัวแล้ว แสดงว่าจบ attribute 1 อย่าง
													// if($arr_tag[$i]=='marquee' ) {
													// 	echo "attr_no ปัจจุบัน : $attr_no<br>";
													// 	echo $arr_temp_attr[$attr_no]."<br>";
													// }
													$attr_no++;
													$cnt_qoute = 0;
													$cnt_sqoute = 0;
													
													//if($arr_tag[$i]=='marquee' ) {
													//	echo "attr_no : $attr_no<br>";
													//}
												} else if( $cnt_sqoute==2  ) {
													 //  หรือ ถ้าเจอ ' 2 ตัวแล้ว แสดงว่าจบ attribute 1 อย่าง
												
													$attr_no++;
													$cnt_qoute = 0;
													$cnt_sqoute = 0;
													
												}
											}
											
									} // end for pos									
									/////// end ส่วนแยก attribute จาก $rec1[need_attr]  ซึ่งเก็บมาจาก ค่า default ในตาราง tag_canbe_inside
									
									for($ci=0;$ci<count($arr_temp_attr);$ci++) {  // เก็บ Attribute ลง ตาราง web_attr
											$piece_attr[$ci] = array();
											$piece_attr[$ci] = explode("=",$arr_temp_attr[$ci],2);
											
											if(trim($piece_attr[$ci][0])) {  // ถ้า attribute_name มีค่า จึง insert
											
												$INSERT2 = " INSERT INTO web_attr (text_attr_name, text_attr_value, text_id) 
																	VALUES ('".trim($piece_attr[$ci][0])."', '".trim($piece_attr[$ci][1])."', '$add_text_id' ) ";
											   $cpass3 = $db2->query($INSERT2);  // ไม่ต้อง convert " '  แล้ว เพราะค่า default  ( need_attr ) มันใส่เป็น &quot; แล้ว
												
												//echo $INSERT2."<br>";
											}
								  }
														/*						
																				$INSERT = " INSERT INTO web_attr(text_attr_name, text_attr_value, text_id) VALUES ('name', '$charac2$charac2', '$add_text_id') 	 ";
																				$cpass3 = $db2->query($INSERT);
														*/					
																				$UPDATE = " UPDATE web_tag SET  text_rank = text_rank+1 WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank >= '$text_rank_open' AND text_id <> '$add_text_id' ";
																				$cpass2 = $db2->query($UPDATE);
																				// update rank ของ tag ถัดไปทั้งหมด ยกเว้นตัวที่เราเพิ่ง insert ( start tag )
																				
																				// =======================================
																				
																				////////////// INSERT tag ปิดของ start_tag			
																				
																				// หา text_rank ของ tag ปิดที่ใกล้ที่สุดของ  $rec_chk1[text_tag] ที่มีปัญหาก่อน																																		 
																				$sql_rec_chk1 = " SELECT  MIN(text_rank) AS min_close  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$rec_chk1[text_tag]."'  AND  text_rank > '$text_rank_open'   ";
																									
																				$exec_rec_chk1  = $db2->query($sql_rec_chk1);
																				$rec_rec_chk1 = $db2->fetch_array($exec_rec_chk1);
																				
																$text_rank_close = $rec_rec_chk1[min_close];	 // tag_rank_close ของ tag ที่มีปัญหา
																
																$sql_id = " SELECT text_id, text_tag  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND  text_rank = '$text_rank_close' AND  text_tag = '/".$rec_chk1[text_tag]."' ";																				$exec_id  = $db2->query($sql_id);
																$rec_id = $db2->fetch_array($exec_id);
																$text_id_close = $rec_id[text_id];			
																				
																if($text_id_close > 0 ) { // ถ้า tag ที่มีปัญหา มี tag ปิด 
																		$rank_close_insert = $text_rank_close+1; 
																		//  ให้กำหนดตำแหน่งของ  start_tag ปิด ด้วย tag ปิด ของตัวปัญหา +1
																} else {
																			// ถ้า tag ที่มีปัญหา ไม่มี tag ปิด
																		 $sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '".$rec_chk1[text_id]."'  ";
																		//echo "$sql_newrank<br>";
																									
																		$exec_newrank  = $db2->query($sql_newrank);
																		$rec_newrank = $db2->fetch_array($exec_newrank);	
																		
																		$rank_close_insert = $rec_newrank[text_rank]+1;
																}
																
																		$INSERT = " INSERT INTO web_tag(filename, db_name, text_tag,  text_rank, section_edit) VALUES ('$filecheck', '$main_db', '/".$_POST["start_tag".$t."_".$u]."', '$rank_close_insert' , '".$start_tag_info[section_id]."' ) "; 
																		//echo "$INSERT<br>";
																		$cpass4 = $db2->query($INSERT); // ตำแหน่ง rank ของตัวครอบ Start-Tag ต้องอยู่ต่อจาก tag ที่มีปัญหา จึงต้อง +1 
																				
																				$add_text_id = mysql_insert_id();		
																					
																				$UPDATE = " UPDATE web_tag SET  text_rank = text_rank+1 WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank >= '$rank_close_insert' AND text_id <> '$add_text_id' ";
																				$cpass5 = $db2->query($UPDATE);
																				// update rank ของ tag ถัดไปทั้งหมด ยกเว้นตัวที่เราเพิ่ง insert ( start tag )
																				
																				// ========================================
																				
																				if($cpass1 && $cpass2 && $cpass4 && $cpass5 ) {
																					$result = 1;
																				}
																																																																											
																	
																	} else if($_POST["solution_id".$t."_".$u]==2) {																																								
																				//echo $_POST["move_status".$t."_".$u]."<br>";
																				if($_POST["move_status".$t."_".$u]=="before") {
																				
																						$sql_moverank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '".$_POST["b_tag".$t."_".$u]."'  ";
																									
																						$exec_moverank  = $db2->query($sql_moverank);
																						$rec_moverank = $db2->fetch_array($exec_moverank);
																						
																			$rank_edit_open = $rec_moverank[text_rank];	
																				//  ตำแหน่ง rank ที่จะย้ายไปของ tag ที่มีปัญหา   
																						
																				// หา text_rank ของ tag ปิดที่ใกล้ที่สุดของ  $rec_chk1[text_tag] ที่มีปัญหาก่อน																																		 
																				$sql_rec_chk1 = " SELECT  MIN(text_rank) AS min_close  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$rec_chk1[text_tag]."'  AND  text_rank > '$text_rank_open'   ";
																									
																				$exec_rec_chk1  = $db2->query($sql_rec_chk1);
																				$rec_rec_chk1 = $db2->fetch_array($exec_rec_chk1);
																																								
																$text_rank_close = $rec_rec_chk1[min_close];	 // tag_rank_close ของ tag ที่มีปัญหา
																				
																				$sql_id = " SELECT text_id, text_tag  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND  text_rank = '$text_rank_close' AND  text_tag = '/".$rec_chk1[text_tag]."' ";																				$exec_id  = $db2->query($sql_id);
																				$rec_id = $db2->fetch_array($exec_id);
																				$text_id_close = $rec_id[text_id];						
																				
																				$up_rank = 1;
																						//////////////// update rank ของ tag เปิดที่มีปัญหา																																			
																						$UPDATE = " UPDATE web_tag SET  text_rank = '$rank_edit_open'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '".$rec_chk1[text_id]."' ";
																						$cpass1 = $db2->query($UPDATE);
																				
																				if($text_id_close>0) {																								
																						//////////////// update rank ของ tag ปิดที่มีปัญหา	
																						$UPDATE = " UPDATE web_tag SET  text_rank = '".($rank_edit_open+$up_rank)."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id_close'  ";
																						$cpass2 = $db2->query($UPDATE);				
																						$up_rank++;																																								 
																				}	
																						$UPDATE = " UPDATE web_tag SET  text_rank = text_rank+$up_rank WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank >= '$rank_edit_open' AND text_id <> '".$rec_chk1[text_id]."' AND  text_id <> '$text_id_close'   ";
																						$cpass3 = $db2->query($UPDATE);
																						// update rank ของ tag ถัดไปทั้งหมด ยกเว้นตัวที่เราเพิ่ง update 
																						
																						if($cpass1 && $cpass3 ) {
																							$result = 1;
																						}
																				
																				}  // end ย้าย tag ไปวางก่อน tag อื่น
																				else if($_POST["move_status".$t."_".$u]=="inside") {
																				
																				/* ยังไม่ work ถ้าย้าย tag ทั้งชุด 2 รอบขึ้นไป  ดังนั้นยังไม่ให้ย้ายทั้งชุดดีกว่า
																				if($rec_tag_info[tag_set]=='1') {   // ถ้า tag ที่มีปัญหา เป็น tag ที่ต้องย้ายทั้งชุด เช่น table
																				
																				
																				$sql_set = " SELECT  text_id, text_tag, text_rank  FROM web_tag  WHERE  filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank >= '$text_rank_open'  ORDER BY  text_rank ";
																				$exec_set  = $db2->query($sql_set);
																				$up_rank = 1;
																				$filter_rank = $text_rank_open;
																				
																				$filter_notin = "";
																				$not_edit_ids = "";			
																				
																				//$filter_close = "";
																				while($rec_set=$db2->fetch_array($exec_set)) {
																						
																						$sql_moverank = " SELECT  text_tag, text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '".$_POST["in_tag".$t."_".$u]."'  ";
																									
																						$exec_moverank  = $db2->query($sql_moverank);
																						$rec_moverank = $db2->fetch_array($exec_moverank);
																						
																						$in_tag_name = $rec_moverank[text_tag];		
																						$rank_edit_open = $rec_moverank[text_rank];	
													//  ตำแหน่ง rank ที่จะย้ายไปข้างใน tag ($_POST["in_tag".$t."_".$u])   
																						
																						$sql_id = " SELECT text_id, text_tag  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND  text_rank = '$filter_rank' ";																					$exec_id  = $db2->query($sql_id);
																						$rec_id = $db2->fetch_array($exec_id);
																						$not_edit_ids .= "'".$rec_id[text_id]."', ";							
																				
																						//////////////// update rank ของ tag เปิดที่มีปัญหา ทีละ tag 
																						// ( จะวน loop ทั้งชุด เช่น <tr><td></td></tr> )																																			
																						$UPDATE = " UPDATE web_tag SET  text_rank = '".($rank_edit_open + $up_rank)."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank = '$filter_rank' ";
																						
																						echo "$UPDATE<br>";
																						
																						$cpass1 = $db2->query($UPDATE);
																						
																						echo $rec_set[text_tag]."<br>";
																						
																						if($rec_set[text_tag] ==  "/".$rec_chk1[text_tag] ) {
																								echo "==End==<br>";
																								$text_rank_close = $rec_set[text_rank];
																								break 1;
																								
																						}
																						
																						$up_rank++;
																						$filter_rank++;
																				}
																				
																					if($not_edit_ids) {
																							$not_edit_ids = substr($not_edit_ids ,0,-2);
																							$filter_notin = " AND  text_id NOT IN ($not_edit_ids) ";
																					}
																					
																				//	if($text_rank_close>0) {
																				//			$filter_close = " AND text_rank <= '$text_rank_close' ";
																				//	}
																					
						//$limit_rank = $rank_edit_open+$up_rank;  AND text_rank <= '$limit_rank'  ไม่ work เวลาย้ายลงไป tag ที่ล่างกว่า
																					
																					$UPDATE = " UPDATE web_tag SET  text_rank = text_rank + $up_rank  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank > '$rank_edit_open'  $filter_notin ";
																					echo "$UPDATE<br><br>";
																					$cpass4 = $db2->query($UPDATE);
																					// update rank ของ tag ถัดไปทั้งหมด ยกเว้นตัวที่เราเพิ่ง update
																					
																					if($cpass1 && $cpass4) {
																							$result = 1	;
																					}
																					
																				} else {  */
																				
																								// ย้าย  แค่ tag เดียว  ไปเข้าข้างใน tag อื่น
																						$sql_moverank = " SELECT  text_tag, text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '".$_POST["in_tag".$t."_".$u]."'  ";
																									
																						$exec_moverank  = $db2->query($sql_moverank);
																						$rec_moverank = $db2->fetch_array($exec_moverank);
																			$in_tag_name = $rec_moverank[text_tag];		
																			$rank_edit_open = $rec_moverank[text_rank];	
													//  ตำแหน่ง rank ที่จะย้ายไปข้างใน tag ($_POST["in_tag".$t."_".$u])   
																						
																				// หา text_rank ของ tag ปิดที่ใกล้ที่สุดของ  $rec_chk1[text_tag] ที่มีปัญหาก่อน																																		 
																				$sql_rec_chk1 = " SELECT  MIN(text_rank) AS min_close  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$rec_chk1[text_tag]."'  AND  text_rank > '$text_rank_open'   ";
																									
																				$exec_rec_chk1  = $db2->query($sql_rec_chk1);
																				$rec_rec_chk1 = $db2->fetch_array($exec_rec_chk1);
																				
																$text_rank_close = $rec_rec_chk1[min_close];	 // tag_rank_close ของ tag ที่มีปัญหา
																				
																				$sql_id = " SELECT text_id, text_tag  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND  text_rank = '$text_rank_close' AND  text_tag = '/".$rec_chk1[text_tag]."' ";																				$exec_id  = $db2->query($sql_id);
																				$rec_id = $db2->fetch_array($exec_id);
																				$text_id_close = $rec_id[text_id];																				
																
																			// หา text_rank ของ tag ปิดที่ใกล้ที่สุดของ $_POST["in_tag".$t."_".$u]
																$sql_rec_chk1 = " SELECT  MIN(text_rank) AS min_close  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$in_tag_name."'  AND  text_rank > '$rank_edit_open'   ";
																									
																				$exec_rec_chk1  = $db2->query($sql_rec_chk1);
																				$rec_rec_chk1 = $db2->fetch_array($exec_rec_chk1);
																				
																$rank_edit_close = $rec_rec_chk1[min_close];	 
																// rank_edit_close ของ tag $_POST["in_tag".$t."_".$u]
																				
																				$sql_id = " SELECT text_id, text_tag  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND  text_rank = '$rank_edit_close' AND  text_tag = '/".$in_tag_name."' ";																				$exec_id  = $db2->query($sql_id);
																				$rec_id = $db2->fetch_array($exec_id);
																				$in_tag_id_close = $rec_id[text_id];				
																
																		$up_rank = 1;
																						//////////////// update rank ของ tag เปิดที่มีปัญหา																																			
																						$UPDATE = " UPDATE web_tag SET  text_rank = '".($rank_edit_open + $up_rank)."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '".$rec_chk1[text_id]."' ";
																						$cpass1 = $db2->query($UPDATE);
																			
																			if($text_id_close>0) {							
																						$up_rank++;																		
																						//////////////// update rank ของ tag ปิดที่มีปัญหา	
																						$UPDATE = " UPDATE web_tag SET  text_rank = '".($rank_edit_open + $up_rank)."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id_close'  ";
																						$cpass2 = $db2->query($UPDATE);																																												 
																			}	
																			
																			if($in_tag_id_close>0) {																																															
																				//////////////// update rank ของ tag ปิด $_POST["in_tag".$t."_".$u]
																						$UPDATE = " UPDATE web_tag SET  text_rank = text_rank + $up_rank WHERE   filename = '$filecheck' AND db_name = '$main_db'   AND  text_id = '$in_tag_id_close' ";
																						$cpass3 = $db2->query($UPDATE);																																												 
																			}																					
																						$UPDATE = " UPDATE web_tag SET  text_rank = text_rank + $up_rank  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank > '$rank_edit_open' AND text_id <> '".$rec_chk1[text_id]."' AND text_id <> '$text_id_close'  AND  text_id <> '$in_tag_id_close' ";
																						$cpass4 = $db2->query($UPDATE);
																						// update rank ของ tag ถัดไปทั้งหมด ยกเว้นตัวที่เราเพิ่ง update
																						
																						if($cpass1 && $cpass4  ) {
																							$result = 1;
																						}
																					/*
																					} // end ย้าย แค่ tag เดียว ( ไม่ใช่ย้ายทั้งชุด )
																					*/
																				} // end ย้าย tag ไปข้างใน tag อื่น
																				else if($_POST["move_status".$t."_".$u]=="last") {
																			$sql_max = " SELECT MAX(text_rank)  AS max_rank FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  ";
																			$exec_max  = $db2->query($sql_max);
																			$rec_max = $db2->fetch_array($exec_max);
																				
																			$last_rank  = $rec_max[max_rank]+1;
																			
																						// หา text_rank ของ tag ปิดที่ใกล้ที่สุดของ  $rec_chk1[text_tag] ที่มีปัญหาก่อน																																		 
																						$sql_rec_chk1 = " SELECT  MIN(text_rank) AS min_close  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$rec_chk1[text_tag]."'  AND  text_rank > '$text_rank_open'   ";
																											
																						$exec_rec_chk1  = $db2->query($sql_rec_chk1);
																						$rec_rec_chk1 = $db2->fetch_array($exec_rec_chk1);
																																										
																		$text_rank_close = $rec_rec_chk1[min_close];	 // tag_rank_close ของ tag ที่มีปัญหา
																						
																						$sql_id = " SELECT text_id, text_tag  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND  text_rank = '$text_rank_close' AND  text_tag = '/".$rec_chk1[text_tag]."' ";																				$exec_id  = $db2->query($sql_id);
																						$rec_id = $db2->fetch_array($exec_id);
																						$text_id_close = $rec_id[text_id];			
																																										 
																				//////////////// update rank ของ tag เปิดที่มีปัญหา																																			
																				$UPDATE = " UPDATE web_tag SET  text_rank = '$last_rank'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '".$rec_chk1[text_id]."' ";
																				$cpass1 = $db2->query($UPDATE);
																			
																				if($text_id_close>0) {							
																						 													
																							//////////////// update rank ของ tag ปิดที่มีปัญหา	
																							$UPDATE = " UPDATE web_tag SET  text_rank = '".($last_rank+1)."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id_close'  ";
																							$cpass2 = $db2->query($UPDATE);																																												 
																				}	
																				
																				if($cpass1 ) {
																					$result = 1;
																				}
																																							
																		  } // end ย้าย tag ไปไว้ท้ายสุด
																				
																	} else if($_POST["solution_id".$t."_".$u]==3) {  //  ถ้าเลือกลบ tag ทิ้ง																																								
																			
																			// หา text_rank ของ tag ปิดที่ใกล้ที่สุดของ  $rec_chk1[text_tag] ที่มีปัญหาก่อน	
																				
																				$sql_rec_chk1 = " SELECT  MIN(text_rank) AS min_close  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$rec_chk1[text_tag]."'  AND  text_rank > '$text_rank_open'   ";
																									
																				$exec_rec_chk1  = $db2->query($sql_rec_chk1);
																				$rec_rec_chk1 = $db2->fetch_array($exec_rec_chk1);
																				
																		$text_rank_close = $rec_rec_chk1[min_close];	 // tag_rank_close ของ tag ที่มีปัญหา
																																				
																			if($rec_tag_info[tag_set]=='1' && $text_rank_close > 0) {   
																					// ถ้า tag ที่มีปัญหา เป็น tag ที่ต้องลบทั้งชุด เช่น <table>, <select> แล้วมี tag ปิด ของมัน
																				
																				$sql_set = " SELECT  text_id, text_tag, text_rank  FROM web_tag  WHERE  filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank >= '$text_rank_open'  ORDER BY  text_rank ";
																				$exec_set  = $db2->query($sql_set);
																				
																				$filter_rank = $text_rank_open;
																																							
																				while($rec_set=$db2->fetch_array($exec_set)) {
																						
																																																							
																						$UPDATE = " UPDATE web_tag SET  text_status = 'del'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank = '$filter_rank' ";
																						
																						//echo "$UPDATE<br>";
																						
																						$cpass1 = $db2->query($UPDATE);
																						
																						//echo $rec_set[text_tag]."<br>";
																						
																						if($rec_set[text_tag] ==  "/".$rec_chk1[text_tag] ) {
																								//echo "==End==<br>";
																								$text_rank_close = $rec_set[text_rank];
																								break 1;
																								
																						}
																																												
																						$filter_rank++;
																				}
																				
																				if($cpass1 ) {
																					$result = 1;
																				}
																		  } // end if ลบ tag เป็น ชุด แล้ว tag ที่มีปัญหา มี tag ปิด ของมัน
																			else {		// ถ้า tag ทั่วไปที่ไม่มีเป็นชุด เช่น table กับ select  ให้ ลบ tag คู่เดียว ( เปิด-ปิด )
																
																				$UPDATE = " UPDATE  web_tag  SET  text_status = 'del'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND text_id = '".$rec_chk1[text_id]."'  ";
																				$result = $db2->query($UPDATE);
																				
																				$UPDATE = " UPDATE  web_tag  SET  text_status = 'del'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$rec_chk1[text_tag]."'  AND text_rank = '$text_rank_close'  ";
																				$result = $db2->query($UPDATE);																
																		 }	
																		 
																	} // end if  แก้ปัญหาโดยการ ลบ tag
																	
																	
																	$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '".$rec_chk1[text_id]."'  ";
																									
																	$exec_newrank  = $db2->query($sql_newrank);
																	$rec_newrank = $db2->fetch_array($exec_newrank);					
																	?>
															<td align="center" width="200"><?php  echo $rec0[solution_name]."<br>"; //" solution_id".$t."_".$u." : ".$_POST["solution_id".$t."_".$u]."<br>"; ?> &nbsp;<?php  $disp->show_icon_pass($result); ?></td>
															<td align="center" width="100"><?php echo $rec_newrank[text_rank];?></td>
															<?php  
																  		if($result) {
																			$total_err--;
																		}
															 } ?>
														</tr>
														<?php 
														$u++;
												}																					
										?>
										</table><br>
										<?php 
											$t++;
										}
							}
							
							$sql_arrange = " SELECT  * FROM  web_tag  WHERE  filename = '$filecheck' AND db_name = '$main_db'  AND  ( text_status <> 'del'  OR text_status is null ) ORDER BY text_rank, text_id ";
							//echo "$sql_arrange<br>"; 
							
							$exec_arrange = $db2->query($sql_arrange);
							
							$total_tag = $db2->num_rows($exec_arrange);
							
							$pass1 = 0;
							
							if($total_tag) {
							?>
							<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse"><caption align="left">ตรวจสอบตำแหน่งการวาง tag ภายใน tag หลัก และค่า attribute ที่เป็นไปได้<br></caption>
											<tr valign="top">
											<td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>
											<td width="600"><strong>รายการ / คำอธิบาย</strong></td>
											<?php  if($_POST["run_edit"]) { ?>
												<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
												<td width="100" align="center"><strong>ตำแหน่ง Tag<br>หลังแก้ไข</strong></td>
											<?php  } ?></tr>
										<?php 
										$limit_edit = 0;
										
										while($rec_arrange = $db2->fetch_array($exec_arrange)) {
													
												   $skip = false;
													
												   $text_id1 = $rec_arrange[text_id];
												   $text_rank1 = $rec_arrange[text_rank];
												   $tag_name = $rec_arrange[text_tag];
												   $section_edited = $rec_arrange[section_edit];											
												  // echo "$tag_name : ".eregi("^/", trim($tag_name))."<br>";
												
										   if(!eregi("^/", $tag_name)) {    // ไม่ต้องพิจารณา tag ปิด
										   			
												   $sql_section = " SELECT  section_id FROM tag_info WHERE  tag_name = '$tag_name' ";
												   $exec_section = $db2->query($sql_section);												   
												   $rec_section = $db2->fetch_array($exec_section);
										   
												   $sql_notallow = " SELECT tag_name, w3c_notallow FROM tag_info WHERE w3c_notallow = 'N' AND tag_name = '$tag_name' ";
												   $exec_notallow = $db2->query($sql_notallow);
												   
												   $num_notallow = $db2->num_rows($exec_notallow);
												   
												    if($num_notallow) {
												   				$invalid=true;
																$total_err++;
																
																?>
																<tr>
																		<td align="center"><?php echo $text_rank1;?></td>
																		<td><span style="color:red">ไม่อนุญาต</span>ให้มี tag <strong><?php echo strtoupper($tag_name);?></strong></td>
																
																	<?php  if($_POST["run_edit"]) { 
																				$result = 0;
																				
																				$UPDATE = " UPDATE  web_tag  SET  text_status = 'del'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'   ";
																				$result = $db2->query($UPDATE);
																				
																				$UPDATE = " UPDATE  web_tag  SET  text_status = 'del'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name'   ";
																				$result = $db2->query($UPDATE);
																				
																				if($pass1) {
																				
																				$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																									
																				$exec_newrank  = $db2->query($sql_newrank);
																				$rec_newrank = $db2->fetch_array($exec_newrank);
																				
																				} else {
																				
																						$rec_newrank[text_rank] = "&nbsp;";
																				}
																																								
																				?><td align="center"> &nbsp;<?php  $disp->show_icon_pass($result); ?></td>
																					<td align="center"><?php echo $rec_newrank[text_rank];?></td><?php 
																					
																					if($result) {
																							$total_err--;
																					}
																	
																		  } ?>
																</tr>
																<?php 																														  
													  } // end if($num_notallow)  ถ้าเจอ tag ที่ w3c ไม่อนุญาต																									   
												   
												   $sql_tag_group = " SELECT  *  FROM tag_section  WHERE  section_id NOT IN ('1','2','".$rec_section[section_id]."') ";
												   
												   //echo "$sql_tag_group<br>";
												   $exec_tag_group = $db2->query($sql_tag_group);				
												   
												   while($rec_tag_group = $db2->fetch_array($exec_tag_group)) {
												     
															$sql_chk_section = " 
													SELECT  text_id,  text_rank AS x1 FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '$tag_name' AND text_id = '$text_id1' AND  section_edit  is null  AND
		( ( text_rank > ( SELECT MAX(text_rank) AS max_open FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_tag_group[section_name]."'  AND text_rank < x1 HAVING  max_open > ( SELECT MAX(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '/".$rec_tag_group[section_name]."' AND text_rank < x1 )  OR ( SELECT MAX(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '/".$rec_tag_group[section_name]."'  AND text_rank < x1 ) IS NULL ) )   )   ORDER BY text_rank, text_id 												
															";  // tag_name ของ text_id อันเดียวนี้  อยู่ภายใน tag section ที่ผิด หรือป่าว
			/* AND  ไม่จำเป็นต้องมี tag ปิด ก็ถือว่าผิดแล้ว ถ้า tag ปัจจุบันมีการวาง tag ผิด section 
		 ( text_rank < ( SELECT MIN(text_rank) AS min_close  FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '/".$rec_tag_group[section_name]."'  AND text_rank > x1  HAVING  min_close < ( SELECT MIN(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_tag_group[section_name]."'  AND text_rank > x1 )  OR ( SELECT MIN(text_rank) FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_tag_group[section_name]."'  AND text_rank > x1 ) IS NULL ) )   */
		 
		 /* not work OR  ( text_rank > ( SELECT MAX(text_rank) AS max_end FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '/".$rec_tag_group[section_name]."'  AND text_rank < x1) AND text_rank < ( SELECT MIN(text_rank) AS min_start FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_tag_group[section_name]."'  AND text_rank > x1 HAVING min_start ) )  */ 
														//if($tag_name=='meta') {
														// echo "$sql_chk_section<br>";
							// เจอ bug  tag ที่เป็นลูก Head แต่มาอยู่นอด <body></body>  เรา check ไม่ได้ว่ามันผิด เพราะมันไม่ได้อยู่ใน body
													//	}
															$exec_chk_section = $db2->query($sql_chk_section);
												   
												 		    $num_chk_section = $db2->num_rows($exec_chk_section);
												   
												 		   if($num_chk_section) {
																	$invalid=true;
																	$total_err++;
																
																?>
																<tr>
																		<td align="center"><?php echo $text_rank1;?></td>
																		<td><span style="color:red">ไม่อนุญาต</span>ให้ tag <strong><?php echo strtoupper($tag_name);?></strong> อยู่ภายใน tag หลักชื่อ <strong><?php echo strtoupper($rec_tag_group[section_name]);?></strong> </td>
																
																	<?php  if($_POST["run_edit"]) { 
																				$result = 0;
																				
																				$UPDATE = " UPDATE  web_tag  SET  section_edit = '".$rec_section[section_id]."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'   ";
																				$result = $db2->query($UPDATE);
																				// update section_id ที่ถูกต้อง เมื่อกด convert w3c แล้ว
																				
																				if($pass1) {
																				
																				$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																									
																				$exec_newrank  = $db2->query($sql_newrank);
																				$rec_newrank = $db2->fetch_array($exec_newrank);
																				
																				} else {
																				
																						$rec_newrank[text_rank] = "&nbsp;";
																				}
																																								
																				?><td align="center"> &nbsp;<?php  $disp->show_icon_pass($result); ?></td>
																					<td align="center"><?php echo $rec_newrank[text_rank];?></td><?php 
																					
																					if($result) {
																							$total_err--;
																					}
																	
																		  } ?>
																</tr>
																<?php 																														  
													 		 } // end if($num_chk_section)  ถ้าเจอ tag ที่ w3c ไม่อนุญาตให้อยู่ภายใน tag section ที่ผิด
													}
													
													if($_POST["run_edit"]) { 
																	
																	$UPDATE = " UPDATE  web_tag  SET  section_edit = '".$rec_section[section_id]."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'   ";
																	$result = $db2->query($UPDATE);
																	// update section_id ที่ถูกต้อง เมื่อกด convert w3c แล้ว แม้เป็น record ที่ไม่ผิด ก็ต้อง update เพื่อให้เวลา ดึงข้อมูลกลับมาเป็นหน้าเว็บ สามารถแยกดึงออกมาเป็น section ( HEAD , BODY )  ได้ 
																	
																	$UPDATE = " UPDATE  web_tag  SET  section_edit = '".$rec_section[section_id]."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name' ";
																	$result = $db2->query($UPDATE); //  update section ที่ tag ปิดของมันด้วย 
																	// ถึงแม้จะได้เกิน 1 record ก็ช่างมัน   เพราะยากที่จะหาว่าอันไหนคู่ของมัน
													}
													
												if($rec_section[section_id]=='3' || $rec_section[section_id]=='4') { 
													//   check $tag_name record ปัจจุบัน ว่าอยู่นอก tag section ที่ถูก หรือป่าว
														
													$sql_tag_group = " SELECT  *  FROM tag_section  WHERE  section_id = '".$rec_section[section_id]."' ";
												   
												   //echo "$sql_tag_group<br>";
												   $exec_tag_group = $db2->query($sql_tag_group);				
												   
												   while($rec_tag_group = $db2->fetch_array($exec_tag_group)) {
												        
															$sql_chk_section = " 
												SELECT  text_id,  text_rank AS x1 FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '$tag_name' AND text_id = '$text_id1' AND 
	 ( text_rank > ( SELECT MAX(text_rank) AS max_open FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_tag_group[section_name]."'  AND text_rank < x1 ) )  AND ( ( text_rank < ( SELECT MIN(text_rank) AS min_close FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '/".$rec_tag_group[section_name]."'  AND text_rank > x1 )  )	)	
												 ORDER BY text_rank, text_id 												
															";  // tag_name ของ text_id อันเดียวนี้  อยู่ภายนอด tag section ที่ถูก หรือป่าว
	/* SELECT  text_id,  text_rank AS x1 FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '$tag_name' AND text_id = '$text_id1' AND
	 ( text_rank < ( SELECT MIN(text_rank) AS min_open FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '".$rec_tag_group[section_name]."'  AND text_rank > x1 ) )  AND ( ( text_rank > ( SELECT MAX(text_rank) AS max_close FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '/".$rec_tag_group[section_name]."'  AND text_rank < x1 ) OR ( SELECT MAX(text_rank) AS max_close FROM web_tag WHERE filename = '$filecheck' AND db_name = '$main_db' AND ( text_status <> 'del' OR text_status is null ) AND text_tag = '/".$rec_tag_group[section_name]."'  AND text_rank < x1 )  is null )	)	
												 ORDER BY text_rank, text_id 				 */
														//if($tag_name=='meta') {
														//	echo "$sql_chk_section<br>";
														//}
															$exec_chk_section = $db2->query($sql_chk_section);
												   
												 		    $num_chk_section = $db2->num_rows($exec_chk_section);
												   
												 		   if(!$num_chk_section && $section_edited===NULL ) {
																	$invalid=true;
																	$total_err++;
																
																?>
																<tr>
																		<td align="center"><?php echo $text_rank1;?></td>
																		<td><span style="color:red">ไม่อนุญาต</span>ให้ tag <strong><?php echo strtoupper($tag_name);?></strong> อยู่ภายนอก tag หลักชื่อ <strong><?php echo strtoupper($rec_tag_group[section_name]);?></strong> </td>
																
																	<?php  if($_POST["run_edit"]) { 
																				$result = 0;
																				
																				$UPDATE = " UPDATE  web_tag  SET  section_edit = '".$rec_section[section_id]."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'   ";
																				$result = $db2->query($UPDATE);
																				// update section_id ที่ถูกต้อง เมื่อกด convert w3c แล้ว
																				
																				if($pass1) {
																				
																				$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																									
																				$exec_newrank  = $db2->query($sql_newrank);
																				$rec_newrank = $db2->fetch_array($exec_newrank);
																				
																				} else {
																				
																						$rec_newrank[text_rank] = "&nbsp;";
																				}
																																								
																				?><td align="center"> &nbsp;<?php  $disp->show_icon_pass($result); ?></td>
																					<td align="center"><?php echo $rec_newrank[text_rank];?></td><?php 
																					
																					if($result) {
																							$total_err--;
																					}
																	
																		  } ?>
																</tr>
																<?php 																														  
													 		 } // end if($num_chk_section)  ถ้าเจอ tag ที่ w3c ไม่อนุญาตให้อยู่ภายนอก tag section ที่ถูก
													
													  } // end while
												  } // 3 || 4
													
													
											}		
											
													
													
												   if(eregi("^/", $tag_name)) {  // check tag ปิด												   																	    
														  $chk_name = eregi_replace("/","",$tag_name);
														  
														  $sql_chk1 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE    filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '$chk_name'  AND  text_rank < '$text_rank1'  AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_rank DESC, text_id DESC  LIMIT 0,1  ";
														  $exec_chk1= $db2->query($sql_chk1);
														  
														  $num_chk1 = $db2->num_rows($exec_chk1);				
														  
														  if($num_chk1) {
																$rec_chk1 = $db2->fetch_array($exec_chk1);
																$text_id_open = $rec_chk1[text_id];	
														  }	 else {
														  
														  		$invalid=true;
																$total_err++;
																?>
																<tr>
																		<td align="center"><?php echo $text_rank1;?></td>
																		<td>ไม่พบ tag เปิดของ <strong><?php echo strtoupper($tag_name);?></strong></td>
																
																	<?php  if($_POST["run_edit"]) { 
																				$result = 0;
																				
																				if($pass1) {
																				
																				$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																									
																				$exec_newrank  = $db2->query($sql_newrank);
																				$rec_newrank = $db2->fetch_array($exec_newrank);
																				
																				} else {
																				
																						$rec_newrank[text_rank] = "&nbsp;";
																				}
																				
																				
																				?><td align="center"> &nbsp;<?php  $disp->show_icon_pass($result); ?></td>
																					<td align="center"><?php echo $rec_newrank[text_rank];?></td><?php 
																					
																					if($result) {
																							$total_err--;
																					}
																	
																		  } ?>
																</tr>
																<?php 																														  
														  }				  
														   																														
												   } else {  // check  tag เปิด
												   
														   $sql_tag = " SELECT  *  FROM  tag_info  WHERE  tag_name = '$tag_name'  ";
														   //echo " $sql_tag<br>";
														   $exec_tag = $db2->query($sql_tag);
														   
														   $rec_tag = $db2->fetch_array($exec_tag);
														   
														   if($rec_tag[need_close]) { //  check tag ที่ต้องปิด ว่ามีปิดมั้ย
														   
																  $sql_chk1 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE    filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name'  AND  text_rank > '$text_rank1'  AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_rank, text_id LIMIT 0,1 ";
																  $exec_chk1= $db2->query($sql_chk1);
																  
																  $num_chk1 = $db2->num_rows($exec_chk1);				
																  
																  if($num_chk1) {
																		$rec_chk1 = $db2->fetch_array($exec_chk1);
																		$text_id_close = $rec_chk1[text_id];	
																  }	 else {
																  		$invalid=true;
																		$total_err++;
																		?>
																		<tr>
																				<td align="center"><?php echo $text_rank1;?></td>
																				<td>ไม่พบ tag ปิดของ <strong><?php echo strtoupper($tag_name);?></strong></td>
																		
																			<?php  if($_POST["run_edit"]) { 
																						$result = 0;
																				
																						if($pass1) {
																						
																						$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																											
																						$exec_newrank  = $db2->query($sql_newrank);
																						$rec_newrank = $db2->fetch_array($exec_newrank);
																						
																						} else {
																						
																								$rec_newrank[text_rank] = "&nbsp;";
																						}
																						
																						
																						?><td align="center"> &nbsp;<?php  $disp->show_icon_pass($result); ?></td>
																							<td align="center"><?php echo $rec_newrank[text_rank];?></td><?php 
																						
																						if($result) {
																							$total_err--;
																						}
																				  } ?>
																		</tr>
																		<?php 																														  
																  }				  
														  } // end if($rec_tag[need_close])
														  
														  if(strtoupper($rec_tag[tag_grand]) != "TABLE") { 
														  			 // ถ้า tag ที่ตรวจปัจจุบัน ไม่ได้มี tag_grand  เป็น table
														  			
																	 ////////// ส่วนใหญ่แล้ว code ล่างนี้ไว้ ตรวจสอบ tag ทั่วไป  (ที่ไม่ใช่ ลูกของ table)
																	 
																  $sql_chk3 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank < '$text_rank1' AND  text_tag IS NOT NULL  AND text_tag <> '' AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_rank DESC, text_id DESC  LIMIT 0,1  ";    // หา tag ก่อนหน้านี้  1 tag																  
																  //echo "$sql_chk3<br>";
																  
																  $exec_chk3 = $db2->query($sql_chk3);																  												
																  $rec_chk3 = $db2->fetch_array($exec_chk3);
																  $text_id_grand = $rec_chk3[text_id];	
																  $prev_tag = $rec_chk3[text_tag];	
																  
																  // แล้ว tag ก่อนหน้า ก็ไม่ใช่ td และ th
																  if(strtoupper($prev_tag) != "TD" && strtoupper($prev_tag) != "TH") {
																  		
																		// แต่ดันเป็น tag ลูกของ table
																  		$sql_chk4 = " SELECT  tag_id, tag_name, tag_grand FROM  tag_info
																  							 WHERE  tag_name = '$prev_tag'  AND tag_grand = 'table'  ";
																							 
																  		 $exec_chk4= $db2->query($sql_chk4);
																  
																		  $num_chk4 = $db2->num_rows($exec_chk4);		
																  
																		  if($num_chk4 || strtoupper($prev_tag) == "TABLE") {  
																		  			// ถ้า tag ก่อนหน้า เป็นลูกของ table หรือ เป็น table
																		  
																		  			$invalid=true;  // แสดงว่าวาง tag ปัจจุบันนั้นผิดที่
																					$total_err++;
																					?>
																					<tr>
																							<td align="center"><?php echo $text_rank1;?></td>
																							<td>tag <strong><?php echo strtoupper($tag_name);?></strong> ต้องไม่อยู่ต่อจาก tag <strong><?php echo strtoupper($prev_tag);?> </strong></td>
																					
																						<?php  if($_POST["run_edit"]) { 
																									$pass1 = $pass2 = $pass_close1 = $pass_close2 = 0;
																									
																									$result = 0;
																									if(strtoupper($tag_name)!="A" || strtoupper($tag_name)!="FONT" || strtoupper($tag_name)!="SPAN" ) {  //  FORM or DIV
																									
																				$sql_table_at = " SELECT text_id, text_tag, text_rank FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = 'table'  AND  ( text_status <> 'del'  OR text_status is null ) AND  text_rank = ( SELECT  MAX(text_rank) AS max_rank  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = 'table'  AND  ( text_status <> 'del'  OR text_status is null )  AND text_rank < '$text_rank1' )  ";							
																				$exec_table_at = $db2->query($sql_table_at);																				
																				$rec_table_at = $db2->fetch_array($exec_table_at);
																				
																				$update_rank = " UPDATE web_tag  SET  text_rank = '".$rec_table_at[text_rank]."' WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '$tag_name'  AND  text_id = '$text_id1'   ";
																				$pass1 = $db2->query($update_rank);
																				
																				if($pass1) {
																							
																							$update_rank = " UPDATE web_tag  SET  text_rank = text_rank+1  WHERE   filename = '$filecheck' AND db_name = '$main_db' AND text_rank >= '".$rec_table_at[text_rank]."' AND  text_id <> '$text_id1'    ";
																							$pass2 = $db2->query($update_rank);
																				
																				}
																																								
																				
																				$sql_form_close = " SELECT text_id, text_tag, text_rank FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name'  AND  ( text_status <> 'del'  OR text_status is null ) AND  text_rank = ( SELECT  MIN(text_rank) AS min_rank  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name'  AND  ( text_status <> 'del'  OR text_status is null )  AND text_rank > '$text_rank1' ) ";
																				$exec_form_close = $db2->query($sql_form_close);																				
																				$rec_form_close = $db2->fetch_array($exec_form_close);
																				
																				////  tag ปิด table ที่ใกล้ที่สุด ตัวแรก
																				$sql_table_close = " SELECT text_id, text_tag, text_rank FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/table'  AND  ( text_status <> 'del'  OR text_status is null ) AND  text_rank = ( SELECT  MIN(text_rank) AS min_rank  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/table'  AND  ( text_status <> 'del'  OR text_status is null )  AND text_rank > '".$rec_table_at[text_rank]."' ) ";
																				
																				$exec_table_close = $db2->query($sql_table_close);																				
																				$rec_table_close = $db2->fetch_array($exec_table_close);
																				
																				// หาว่ามี tag table ซ้อนอยู่อีกกี่ตัว จนกว่าจะเจอ tag ปิดที่ใกล้สุด 
																				$sql_table_inside = " SELECT text_id, text_tag, text_rank FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = 'table'  AND  ( text_status <> 'del'  OR text_status is null )  AND text_rank > '".$rec_table_at[text_rank]."' AND text_rank < '".$rec_table_close[text_rank]."'  ";
																				
																				$exec_table_inside = $db2->query($sql_table_inside);																				
																				$num_table_inside = $db2->num_rows($exec_table_inside)*1;
																				// ได้จำนวน table ที่ซ้อนอยู่
																				
																				$num_table_formclose = $num_table_inside+1; 
																				// คิดจำนวน tag ปิด ที่เราจะเอา </form> ไปวาง ต้อง +1
																				
																				if($num_table_inside>0) {  // ถ้ามี table ซ้อนข้างใน table ที่อยู่ต่อจาก <form>
																				
																						////   tag ปิด table ที่ใกล้ที่สุด ตัวที่จะเอา </form> ไปวางต่อจริง
																						$sql_table_rclose = " SELECT text_id, text_tag, text_rank FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/table'  AND  ( text_status <> 'del'  OR text_status is null ) AND text_rank > '".$rec_table_at[text_rank]."' ORDER BY  text_rank  DESC  LIMIT 0, $num_table_formclose ";
																						
																						$exec_table_rclose = $db2->query($sql_table_rclose);																				
																						$rec_table_rclose = $db2->fetch_array($exec_table_rclose);
																								
																						if($rec_form_close[text_id] > 0 && $rec_table_rclose[text_rank] > 0 ) {
																						
																							$update_rank = " UPDATE web_tag  SET  text_rank = '".($rec_table_rclose[text_rank]+1)."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name'  AND  text_id = '".$rec_form_close[text_id]."'   ";
																							
																							$pass_close1 = $db2->query($update_rank);				
																							
																							if($pass_close1) {
																									$update_rank = " UPDATE web_tag  SET  text_rank = text_rank+1  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank >  '".$rec_table_rclose[text_rank]."'  AND text_id <> '".$rec_form_close[text_id]."' ";
																							
																									$pass_close2 = $db2->query($update_rank);					
																							}																
																						}			
																				} else {
																						// ถ้าไม่มี  table ซ้อนข้างใน ให้ วาง </form> ต่อจาก </table> ตัวแรกที่ใกล้ <table> ที่สุด																						
																								
																						if($rec_form_close[text_id] > 0 && $rec_table_close[text_rank] > 0 ) {
																						
																							$update_rank = " UPDATE web_tag  SET  text_rank = '".($rec_table_close[text_rank]+1)."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name'  AND  text_id = '".$rec_form_close[text_id]."'   ";
																							
																							$pass_close1 = $db2->query($update_rank);				
																							
																							if($pass_close1) {
																									$update_rank = " UPDATE web_tag  SET  text_rank = text_rank+1  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank >  '".$rec_table_close[text_rank]."'  AND text_id <> '".$rec_form_close[text_id]."' ";
																							
																									$pass_close2 = $db2->query($update_rank);					
																							}																
																						}			
																				
																				
																				}																																	
																							
																							if($pass1 && $pass2 && $pass_close1 && $pass_close2 ) {
																									$result = 1;
																																																		
																							}
																							
																																																		
																					} // if(strtoupper($tag_name)!="A")   //  FORM or DIV
																					else {
																					   //  not  be FORM or DIV
																					  	 	
																							$sql_table_at = " SELECT text_id, text_tag, text_rank FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = 'table'  AND  ( text_status <> 'del'  OR text_status is null ) AND  text_rank = ( SELECT  MAX(text_rank) AS max_rank  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = 'table'  AND  ( text_status <> 'del'  OR text_status is null )  AND text_rank < '$text_rank1' )  ";							
																							$exec_table_at = $db2->query($sql_table_at);																				
																							$rec_table_at = $db2->fetch_array($exec_table_at);
																							
																							$update_rank = " UPDATE web_tag  SET  text_rank = '".$rec_table_at[text_rank]."' WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '$tag_name'  AND  text_id = '$text_id1'   ";
																							$pass1 = $db2->query($update_rank);
																							
																							if($pass1) {
																										
																										$update_rank = " UPDATE web_tag  SET  text_rank = text_rank+1  WHERE   filename = '$filecheck' AND db_name = '$main_db' AND text_rank >= '".$rec_table_at[text_rank]."' AND  text_id <> '$text_id1'    ";
																										$pass2 = $db2->query($update_rank);
																							
																							}
																							
																							$sql_a_close = " SELECT text_id, text_tag, text_rank FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name'  AND  ( text_status <> 'del'  OR text_status is null ) AND  text_rank = ( SELECT  MIN(text_rank) AS min_rank  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name'  AND  ( text_status <> 'del'  OR text_status is null )  AND text_rank > '$text_rank1' ) ";
																							$exec_a_close = $db2->query($sql_a_close);																				
																							$rec_a_close = $db2->fetch_array($exec_a_close);
																							
																							if($rec_a_close[text_id] > 0 ) {
																								$update_rank = " UPDATE web_tag  SET  text_rank = '".($rec_table_at[text_rank]+1)."'  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/$tag_name'  AND  text_id = '".$rec_a_close[text_id]."'   ";
																								
																								$pass_close1 = $db2->query($update_rank);				
																								
																								if($pass_close1) {
																										$update_rank = " UPDATE web_tag  SET  text_rank = text_rank+1  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank >  '".$rec_table_at[text_rank]."'  AND text_id <> '".$rec_a_close[text_id]."' ";
																								
																										$pass_close2 = $db2->query($update_rank);					
																								}																
																							}													
																							
																							if($pass1 && $pass2 && $pass_close1 && $pass_close2 ) {
																									$result = 1;
																							}
																					} // end if //  not  be FORM or DIV  ( as A or FONT or SPAN )
																					
																									
																									$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																									
																									$exec_newrank  = $db2->query($sql_newrank);
																									$rec_newrank = $db2->fetch_array($exec_newrank);
																									
																								?><td align="center"> &nbsp;<?php  $disp->show_icon_pass($result); ?></td>
																								<td align="center"><?php  echo $rec_newrank[text_rank];?> </td><?php 
																									if($result) {
																											$total_err--;																											
																									}
																							
																							
																							if($pass2 || $pass_close2 ) {   // ถ้ามีการ update rank แบบ +1 หลาย record
																									
																									// ต้อง query loop ใหม่อีกรอบ เพื่อให้ได้ text_rank ปัจจุบัน
																									
																											$sql_arrange = " SELECT  * FROM  web_tag  WHERE  filename = '$filecheck' AND db_name = '$main_db'  AND  ( text_status <> 'del'  OR text_status is null ) ORDER BY text_rank, text_id ";
																											//echo "$sql_arrange<br>"; 
							
																											$exec_arrange = $db2->query($sql_arrange);
																																																						
																											//break 5;   ปีกกาล่าง มี แต่ if ใช้ไม่ได้
																											//  ข้ามไป วน loop while($rec_arrange = $db2->fetch_array($exec_arrange)) ใหม่ เพราะต้องใช้ text_rank ณ ปัจจุบัน ที่แก้แล้ว  ( ที่ break 5 นั้นคือ ไม่นับ ปิด  if แรก นอกนั้น นับ ปีกกาปิด ที่ไม่เปิดใหม่ ทั้งหมด  เราลองใช้ concept นี้ แต่ไม่รู้ว่า break 5 มันถูกต้องจริงหรือป่าว ต้องลองดู )  
																											// ล่าสุดลองใช้ break ดูแล้ว มัน นับการออกจาก loop 
																											// เฉพาะ for, foreach, while, do while เท่านั้น  if ไม่นับ
																											
																											$skip = true; 
																										// ถ้า query loop ใหม่ ต้องสั่งข้าม การ check เพื่อไม่ให้ text_rank เก่าถูกนำไปใช้แสดง หรือ query ใน code ด้านล่าง แล้วค่อยไป เคลียร์ค่า $skip = false ตอนต้น loop อีกครั้ง
																							}																											
																	 		   } // end run_edit  ?>
																					</tr>
																					<?php 																									  
																		  }
																  } // end if(strtoupper($prev_tag) != "TD")
														  
														  } // end  if(strtoupper($rec_tag[tag_grand]) != "TABLE") 
														  														  
														/*  if($rec_tag[tag_grand] && strtoupper($rec_tag[tag_grand]) != "BODY" && strtoupper($rec_tag[tag_grand]) != "HTML" && strtoupper($rec_tag[tag_grand]) != "HEAD" &&  strtoupper($rec_tag[tag_grand]) != "!DOCTYPE" )  */
														
												if($skip==false) {
												
														if(strtoupper($rec_tag[tag_grand]) == 'TABLE' || strtoupper($rec_tag[tag_grand]) == 'OBJECT' )
														{ // check การเรียง tag ภายใน เฉพาะ tag แม่ ที่เป็น table หรือ object
														  			
																   $sql_chk2 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND text_tag = '".$rec_tag[tag_grand]."'  AND  text_rank < '$text_rank1'  AND  ( text_status <> 'del'  OR text_status is null ) ORDER BY text_rank, text_id LIMIT 0,1 ";
																  $exec_chk2= $db2->query($sql_chk2);
																  
																  $num_chk2 = $db2->num_rows($exec_chk2);		
														  
														  		  if($num_chk2) {
																		$rec_chk2 = $db2->fetch_array($exec_chk2);
																		$text_id_grand = $rec_chk2[text_id];	
																																				
																  }	 else {
																  			$invalid=true;
																			$total_err++;
																		?>
																		<tr>
																				<td align="center"><?php echo $text_rank1;?></td>
																				<td>tag <strong><?php echo strtoupper($tag_name);?></strong> ต้องอยู่ภายใน tag <strong><?php echo strtoupper($rec_tag[tag_grand]);?> </strong></td>
																		
																			<?php  if($_POST["run_edit"]) { 
																			
																						$result = 0;
																				
																						if($pass1) {
																						
																						$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																											
																						$exec_newrank  = $db2->query($sql_newrank);
																						$rec_newrank = $db2->fetch_array($exec_newrank);
																						
																						} else {
																						
																								$rec_newrank[text_rank] = "&nbsp;";
																						}
																						
																						
																						?><td align="center"> &nbsp;<?php  $disp->show_icon_pass($result); ?></td>
																							<td align="center"><?php echo $rec_newrank[text_rank];?></td><?php 
																						
																						if($result) {
																							$total_err--;
																						}
																				  } ?>
																		</tr>
																		<?php 																														  
																  }				
																  
																  ////////// ส่วนใหญ่แล้ว code ล่างนี้ไว้ ตรวจสอบลูกของ table
																  $sql_chk3 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_rank < '$text_rank1' AND  text_tag IS NOT NULL  AND text_tag <> ''  AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_rank DESC, text_id DESC  LIMIT 0,1  ";    // หา tag ก่อนหน้านี้  1 tag																  
																 
																  $exec_chk3 = $db2->query($sql_chk3);																  												
																  $rec_chk3 = $db2->fetch_array($exec_chk3);
																  $text_id_grand = $rec_chk3[text_id];	
																  $prev_tag = $rec_chk3[text_tag];	
																  
																  // ถ้า tag ก่อนหน้านี้ 1 tag ไม่ใช่ tag_parent ของ tag ปัจจุบัน
																  if( $prev_tag != $rec_tag[tag_grand]  && $prev_tag != $rec_tag[tag_parent] &&  $prev_tag != $rec_tag[tag_parent2]  &&  $prev_tag != $rec_tag[tag_parent3]  ) {  	
																			$invalid=true;  // แสดงว่าวาง tag ปัจจุบันนั้นผิดที่
																			$total_err++;
																			?>
																			<tr>
																					<td align="center"><?php echo $text_rank1;?></td>
																					<td>tag <strong><?php echo strtoupper($tag_name);?></strong> ต้องไม่อยู่ต่อจาก tag <strong><?php echo strtoupper($prev_tag);?> </strong></td>
																			
																				<?php  if($_POST["run_edit"]) { 
																						
																							$result = 0;
																							
																							if($pass1) {
																							
																							$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																												
																							$exec_newrank  = $db2->query($sql_newrank);
																							$rec_newrank = $db2->fetch_array($exec_newrank);
																							
																							} else {
																							
																									$rec_newrank[text_rank] = "&nbsp;";
																							}
																							
																							
																							?><td align="center"> &nbsp;<?php  $disp->show_icon_pass($result); ?></td>
																								<td align="center"><?php echo $rec_newrank[text_rank];?></td><?php 
																								if($result) {
																										$total_err--;
																								}																				
																					} ?>
																			</tr>
																			<?php 																														
																 }  
														  }	 // end if($rec_tag[tag_grand] && strtoupper($rec_tag[tag_grand]) != "BODY" && strtoupper($rec_tag[tag_grand]) != "HTML" && strtoupper($rec_tag[tag_grand]) != "HEAD" )													  														 														
													 } // end skip==false
													  
												 } // end  check  tag เปิด
												
										if($skip==false) {
												
												// ตรวจสอบค่า attribute ที่เป็นไปได้ ***********************************
												
												 $sql_tag_chk = " SELECT  *  FROM  value_attrbute_tag  WHERE  tag_name = '$tag_name'  "; 
												 
												 $exec_tag_chk = $db2->query($sql_tag_chk);
												 
												 $num_tag_chk = $db2->num_rows($exec_tag_chk);
												 
												 if($num_tag_chk) {  // ถ้ามีการ ใส่ข้อมูล ตรวจสอบ tag  ที่มี attribute ถูก จึงจะเข้ามา query
												 
												 			$sql_attr_data = " SELECT  `web_attr`.`text_attr_id`,
																									  `web_attr`.`text_attr_name`,
																									  `web_attr`.`text_attr_value`,
																									  `web_attr`.`text_id`, REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS text_attr_value1 ,  
																										REPLACE( REPLACE(`web_attr`.`text_edit_value`, '$charac2', ''), '$charac1', '')  AS text_edit_value1
																								FROM web_attr  WHERE  text_id = '$text_id1' AND  text_attr_name is not  null  AND  text_attr_name  <> ''  ORDER BY  text_attr_id, text_id ";
															
															$exec_attr_data  = $db2->query($sql_attr_data);
												 
															$num_attr_data  = $db2->num_rows($exec_attr_data );
															 
															if($num_attr_data) {  // ถ้า tag ปัจจุบัน มีค่า attribute ใดๆ
															 	
																	while($rec_attr_data = $db2->fetch_array($exec_attr_data)) {
																		 
																		 $attribute_name = $rec_attr_data[text_attr_name];
																		 
																		 if(strtolower($attribute_name)!="id" && strtolower($attribute_name)!="name" && strtolower($attribute_name)!="class" && strtolower($attribute_name)!="style"  && !eregi("^on",$attribute_name) ) {
																				 $attribute_value = ($rec_attr_data[text_edit_value1])? $rec_attr_data[text_edit_value1]:$rec_attr_data[text_attr_value1];
																				 
																				 $sql_attr_chk = " SELECT  *  FROM  value_attrbute_tag  WHERE  tag_name = '$tag_name'  AND attribute_name = '$attribute_name' ";
																				
																				 $exec_attr_chk = $db2->query($sql_attr_chk);
																	 
																				 $num_attr_chk = $db2->num_rows($exec_attr_chk);
																				 
																				 if($num_attr_chk) {  
																					// ถ้ามีการอ้าง attribute ที่มีใน ฐานข้อมูล จึงจะมา ตรวจ error  ใน value ของมัน
																						
																						  $sql_chk_right = " SELECT  *  FROM  value_attrbute_tag  WHERE  tag_name = '$tag_name'  AND attribute_name = '$attribute_name'  AND  ( possible_value = '$attribute_value'  OR  possible_value = '***' ) ";
																						
																						 $exec_chk_right = $db2->query($sql_chk_right);
																			 
																						 $num_chk_right = $db2->num_rows($exec_chk_right);
																						 
																						 if($num_chk_right==0) {
																								
																									$invalid=true;  // แสดงว่าวาง tag ปัจจุบันนั้น มี attibute ผิดค่า
																									$total_err++;
																									?>
																									<tr>
																											<td align="center"><?php echo $text_rank1;?></td>
																											<td>tag <strong><?php echo strtoupper($tag_name);?></strong> มีค่า attribute  <strong><?php echo strtolower($attribute_name);?> </strong> <span style="color:red"> เป็น <strong><?php echo strtolower($attribute_value);?> </strong> ไม่ได้ </span></td>
																									
																										<?php  if($_POST["run_edit"]) { 
																												
																													$result = 0;	
																													
																													$sqlEdit = " SELECT  *  FROM  value_edit_attr_tag  WHERE  tag_name = '$tag_name'  AND attribute_name = '$attribute_name'  AND  wrong_value = '$attribute_value'   ORDER BY  tag_name, attribute_name ";
									
																													$execEdit = $db2->query($sqlEdit);				
																													$recEdit  = $db2->fetch_array($execEdit);																																																																																																																											
																													
																													?><td align="center"> &nbsp;<?php  
																													if($recEdit[correct_value] == "*delTag*" ) {																											
																															$UPDATE = " UPDATE web_tag SET text_status = 'del'  WHERE  text_id = '$text_id1' ";
																														   $result = $db2->query($UPDATE);	
																													} else {
																													
																														$edit_value = $recEdit[correct_value];
																		
																														if(!eregi("^".$charac2, $edit_value)) {
																																$edit_value = $charac2.$edit_value;
																														}
																														if(!eregi($charac2."$", $edit_value)) {
																																$edit_value = $edit_value.$charac2;
																														}
																																														
																														$UPDATE = " UPDATE web_attr SET text_edit_value = '".$edit_value."'  WHERE  text_attr_id = '".$rec_attr_data[text_attr_id]."' ";
																														 $result = $db2->query($UPDATE);	
																															
																														  
																													} 
																													$disp->show_icon_pass($result); 
																													?></td>
																														<td align="center"  >
																														<?php  if($pass1) {
																									
																															$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																																				
																															$exec_newrank  = $db2->query($sql_newrank);
																															$rec_newrank = $db2->fetch_array($exec_newrank);
																															
																															} else {
																															
																																	$rec_newrank[text_rank] = "&nbsp;";
																															} ?>          
																														<?php  echo $rec_newrank[text_rank];?></td><?php 	
																														
																														if($result) {
																																$total_err--;
																														}																			
																											} ?>
																									</tr>
																									<?php 		
																						}
																				  } // end if($num_attr_chk)
																				  else {
																							// ถ้า tag ปัจจุบัน มี attribute นี้ไม่ได้
																							
																							$invalid=true;  
																							$total_err++;
																									?>
																									<tr>
																											<td align="center"><?php echo $text_rank1;?></td>
																											<td> <span style="color:red">ไม่อนุญาต</span>ให้ tag <strong><?php echo strtoupper($tag_name);?></strong> มี attribute ชื่อ  <span style="color:red"><strong><?php echo strtolower($attribute_name);?> </strong></span></td>
																									
																										<?php  if($_POST["run_edit"]) { 
																												
																													$result = 0;	
																													
																													$sqlEdit = " SELECT  *  FROM  value_edit_attr_tag  WHERE  tag_name = '$tag_name'  AND  wrong_attribute = '$attribute_name'   ORDER BY  tag_name, attribute_name ";
									
																													$execEdit = $db2->query($sqlEdit);				
																													$recEdit  = $db2->fetch_array($execEdit);																																																																																																																											
																													
																													?><td align="center"> &nbsp;<?php  
																													 if($recEdit[correct_value] == "*background*" ) {																																																									
																																																																																									 																														 $style_add = $edit_value = "background:url($attribute_value)";
																														 																														 																																																
																														
																															$sql_chkdup = " SELECT text_attr_id  FROM  web_attr WHERE text_id = '$text_id1' AND text_attr_name = 'style' ";
																															$exec_chkdup = $db2->query($sql_chkdup);
																															$num_chkdup = $db2->num_rows($exec_chkdup);
																														
																														  //echo "$sql_chkdup<br>";
																														  if($num_chkdup) {  // ถ้า tag $text_id1 มี attribute style อยู่แล้ว  
																														
																															// $UPDATE = " UPDATE web_attr SET  text_edit_value = CONCAT(												'$charac2', REPLACE(text_edit_value, '$charac2', ''), '$style_add', '$charac2')  WHERE  text_id = '$text_id1' AND text_attr_name = 'style' ";
																															//  ใช้ CONCAT กับ query UPDATE แล้ว ไม่ work
																																$sql_test = " SELECT  REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS text_attr_value1 ,  
																										REPLACE( REPLACE(`web_attr`.`text_edit_value`, '$charac2', ''), '$charac1', '')  AS text_edit_value1  FROM  web_attr  WHERE text_id = '$text_id1' AND text_attr_name = 'style' ";
																																$exec_test = $db2->query($sql_test);
																																$rec_test = $db2->fetch_array($exec_test);
																																																																
																																$old_value = ($rec_test[text_edit_value1])? $rec_test[text_edit_value1]:$rec_test[text_attr_value1];
																																if(!eregi(";$",trim($old_value))) {
																																	$style_add = ";".$style_add;
																																}
																																
																																$edit_value = $charac2.$old_value.$style_add.$charac2;
																																
																																$UPDATE = " UPDATE web_attr SET  text_edit_value = '$edit_value'  WHERE  text_id = '$text_id1' AND text_attr_name = 'style' ";
																															
																															  $db2->query($UPDATE);	 //  ต่อ string เข้าไปที่ style เดิม																															  																															    																															  																															    																															   
																															    $DELETE = " DELETE FROM  web_attr WHERE text_id = '$text_id1' AND text_attr_name = 'background' ";
																															    $result = $db2->query($DELETE);
																																
																														} else {														
																																
																																if(!eregi("^".$charac2, $edit_value)) {
																																		$edit_value = $charac2.$edit_value;
																																}
																																if(!eregi($charac2."$", $edit_value)) {
																																		$edit_value = $edit_value.$charac2;
																																}
																														
																														 	 $UPDATE = " UPDATE web_attr SET  text_attr_name = 'style' ,  text_edit_value = '".$edit_value."'  WHERE  text_attr_id = '".$rec_attr_data[text_attr_id]."' ";
																															  $result = $db2->query($UPDATE);	// update  attribute ที่เป็น background ด้วย style ไปเลย
																														}
																														
																														//echo "<br>$UPDATE<br>";
																														
																														//echo "text_edit_value : ".$rec_test[text_edit_value]."<br>";
																														
																														  //$disp->show_icon_pass($result); 
																													} // end แก้ "*background*" 
																													else if($recEdit[correct_value] == "*del*" ) {			
																														// ถ้า วิธีแก้ เป็น *del* ให้เคลียร์ค่า attribute นั้นไปเลย
																														$UPDATE = " UPDATE web_attr SET  text_attr_name = '' ,  text_attr_value = '', text_edit_value = ''  WHERE  text_attr_id = '".$rec_attr_data[text_attr_id]."' ";
																														 $result = $db2->query($UPDATE);	
																															
																														  //$disp->show_icon_pass($result); 
																													} // end แก้ "*del*" 
																													//else {
																														//	echo "ต้องแก้โดย Editor";
																													//}
																													
																													$disp->show_icon_pass($result); 
																													?></td>
																														<td align="center"  >
																														<?php  if($pass1) {
																									
																															$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_id = '$text_id1'  ";
																																				
																															$exec_newrank  = $db2->query($sql_newrank);
																															$rec_newrank = $db2->fetch_array($exec_newrank);
																															
																															} else {
																															
																																	$rec_newrank[text_rank] = "&nbsp;";
																															} ?>          
																														<?php  echo $rec_newrank[text_rank];?></td><?php 																																
																														if($result) {
																																$total_err--;
																														}																		
																											} ?>
																									</tr>
																									<?php 		
																				  
																				  }
																	 	 } // end strtolower($attribute_name)!="id" && strtolower($attribute_name)!="name" && strtolower($attribute_name)!="class" และ "style"
																} // end while
															 
														  } // end if($num_attr_data) 
												 } // end if($num_tag_chk) 
											} // end $skip==false
											 
										} // end while $rec_arrange
								} //  end if $total_tag
								?>
							</table>
							<br>
							
							<?php 
						 if($_POST["run_edit"]) { 		// ส่วนการบันทึก การลบ tag ซ้ำ	
								for($ct=1;$ct<=$_POST["totaltag"];$ct++) {
										for($cu=1;$cu<=$_POST["totaldup".$ct];$cu++) {
														if($_POST["chkdup_del".$ct."_".$cu]) {
																
																// หา text_rank ของ tag เปิด ที่จะลบก่อน
																
															  $sql_id = " SELECT text_id, text_tag, text_rank  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND   text_id = '".$_POST["chkdup_del".$ct."_".$cu]."' ";																				
																$exec_id  = $db2->query($sql_id);
																$rec_id = $db2->fetch_array($exec_id);
																$text_rank_open = $rec_id[text_rank];																																																																	
																
																
																$UPDATE = " UPDATE web_tag SET text_status = 'del'  WHERE  text_id = '".$_POST["chkdup_del".$ct."_".$cu]."' ";
																$db2->query($UPDATE);	
																
																$sql_close = " SELECT text_id, text_tag, text_rank FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$rec_id[text_tag]."'  AND  ( text_status <> 'del'  OR text_status is null ) AND  text_rank = ( SELECT  MIN(text_rank) AS min_rank  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag = '/".$rec_id[text_tag]."' AND  ( text_status <> 'del'  OR text_status is null )  AND text_rank > '$text_rank_open' ) ";
																$exec_close = $db2->query($sql_close);																				
																$rec_close = $db2->fetch_array($exec_close);
																
																if( $rec_close[text_id] && $rec_close[text_tag]=="/".$rec_id[text_tag])  {  // ถ้ามี tag ปิดของ tag ที่จะลบ
																		
																		$UPDATE = " UPDATE web_tag SET text_status = 'del'  WHERE  text_id = '".$rec_close[text_id]."' ";
																		$db2->query($UPDATE);	
																
																}
																
														}
										}
								}		
						}
							?>
							<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse">
										<tr valign="top">
										<td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>
										<td width="550"><strong>รายการ / คำอธิบาย</strong></td>
										<?php  if(!$_POST["run_edit"]) { ?>
											<td width="100" align="center"><strong>ลบทิ้ง</strong></td>
										<?php  } ?>
										<?php  if($_POST["run_edit"]) { ?>
											<td width="100" align="center"><strong>สถานะการแก้ไข</strong></td>											
										<?php  } ?></tr>
							<?php 							
												
							$sql_over = " SELECT  tag_name  FROM  tag_info  WHERE  limit_qty = '1' ";
							$exec_over = $db2->query($sql_over);
							$t=1;
							
							while($rec_over = $db2->fetch_array($exec_over)) {
																																																			
									
									$sql_chk = " SELECT  COUNT(text_id) AS tag_qty  FROM web_tag  WHERE  filename = '$filecheck' AND db_name = '$main_db'  AND  ( text_status <> 'del'  OR text_status is null )  AND  text_tag = '".$rec_over[tag_name]."' ";
									
									$exec_chk = $db2->query($sql_chk);
									$rec_chk = $db2->fetch_array($exec_chk);
									$tag_qty = $rec_chk[tag_qty];
									
									if($tag_qty > 1) {  // ถ้ามี tag ที่จำกัด ไม่ให้เกิน 1 ซ้ำ
											
											$invalid=true;  
											$total_err = $total_err+($tag_qty-1);
											
											$sql_arrange = " SELECT  * FROM  web_tag  WHERE  filename = '$filecheck' AND db_name = '$main_db'  AND  ( text_status <> 'del'  OR text_status is null )  AND  text_tag = '".$rec_over[tag_name]."'   ORDER BY text_rank, text_id ";
							//echo "$sql_arrange<br>"; 							
											$exec_arrange = $db2->query($sql_arrange);
											
											$total_tag = $db2->num_rows($exec_arrange);
											$u=1;
											while($rec_arrange = $db2->fetch_array($exec_arrange)) {
											
													   $skip = false;													
													   $text_id1 = $rec_arrange[text_id];
													   $text_rank1 = $rec_arrange[text_rank];
													   $tag_name = $rec_arrange[text_tag];
													   
													?>
													<tr valign="top">
													<td align="center"><?php echo $text_rank1;?></td>
													<td><span style="color:red">ไม่อนุญาตให้</span> tag <strong><?php echo strtoupper($rec_over[tag_name]);?></strong> มีมากกว่า 1 แห่ง <?php  if(trim($app->show_tag_attribute($text_id1))) { 
																 
																 echo "<fieldset><legend>รายละเอียด tag</legend>".$disp->convert_qoute_to_db($app->show_tag_attribute($text_id1))."</fieldset>";
															 }
															 ?></td>
													<?php  if(!$_POST["run_edit"]) { ?>
														<td align="center"  ><input name="chkdup_del<?php echo $t;?>_<?php echo $u;?>" type="checkbox" value="<?php echo $text_id1;?>"></td>
													    <?php  } ?>
													<?php  if($_POST["run_edit"]) { 	
																?><td align="center"><?php 																											
																	$disp->show_icon_pass(0); 	
																	?></td><?php 																																									
																																									  
															} 
													?></tr><?php 				
													$u++;						
											} // end while
									} // end $tag_qty > 1
									else if($tag_qty>0) {
											
											//$total_err = $total_err-($tag_qty-1);
											if($_POST["run_edit"]) { 
											?>
													<tr valign="top">
													<td align="center"><?php echo $text_rank1;?></td>
													<td colspan="2"> <?php echo $disp->show_icon_pass(1); ?> แก้ไข tag <strong><?php echo strtoupper($rec_over[tag_name]);?></strong> ซ้ำเรียบร้อยแล้ว </td>
													</tr><?php 												
											}
									}
									?><input name="totaldup<?php echo $t;?>" type="hidden" value="<?php echo --$u;?>"><?php 
									
									$t++;
							}
							
							?>
							</table><input name="totaltag" type="hidden" value="<?php echo --$t;?>">
							<br>							
							<?php 
									///////  check ว่า tag ที่ไม่ใช่ tag ลูกของ Body เช่น  META หรือ TITLE  มีปรากฏอยู่ใน BODY web_tag มั้ย
									//  ย้ายไปรวมกับข้างบน  check ทีละ tag ไปเลยว่าวางผิด section หรือป่าว   
									// ส่วน tag ที่ไม่อนุญาตให้มี เช่น marquee /  embed   ก็ check อีกแบบนึง
										
								
				
									$sqlChkQoute = " SELECT  web_tag.text_id, text_tag, web_tag.text_rank, web_attr.* 
									FROM web_tag INNER JOIN web_attr 
										ON  web_tag.text_id = web_attr.text_id 
									 WHERE  filename = '$filecheck' AND db_name = '$main_db'  AND  text_tag <> '!doctype' AND ( text_attr_name IS NOT NULL AND  text_attr_name <> '' AND text_attr_name <> 'checked'  AND text_attr_name <> 'readonly' AND text_attr_name <> 'disabled' AND text_attr_name <> 'selected') AND ( text_edit_value = '$charac2' OR text_attr_value = '$charac2' OR text_edit_value = '$charac1' OR text_attr_value = '$charac1' OR ( text_edit_value IS NOT NULL AND text_edit_value <> '' AND ( ( text_edit_value NOT LIKE '".$charac2."%' ) AND ( text_edit_value NOT LIKE '".$charac1."%' ) ) ) OR ( ( text_edit_value IS NULL OR  text_edit_value = '') AND ( text_attr_value NOT LIKE '".$charac2."%') AND ( text_attr_value NOT LIKE '".$charac1."%') ) )  AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY web_tag.text_rank, web_tag.text_id ";
									//echo "$sqlChkQoute<br>";	
									// 
									// AND ( text_edit_value LIKE '#%' OR ( ( text_edit_value IS NULL OR  text_edit_value = '') AND text_attr_value  LIKE '#%' ) )  AND  ( text_status <> 'del'  OR text_status is null )  						
									$execChkQoute = $db2->query($sqlChkQoute);														
									$numChkQoute = $db2->num_rows($execChkQoute);
									$ic=0;																		
						if($numChkQoute) {
									$invalid = true;	
									$total_err+=$numChkQoute;									
													?>
									<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse"><caption align="left"><!--an attribute value must be a literal unless it contains only name characters.-->พบปัญหาไวยากรณ์ ค่า attribute ต้องมีการคลุมด้วยเครื่องหมาย " ( double qoute ) <br></caption>
										<tr>
											 <td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>					
											 <td width="100"><strong>ชื่อ Tag</strong></td><td width="600"><strong>รายการ / คำอธิบาย</strong></td>
										<?php  if($_POST["run_edit"]) { ?>
											<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
										<?php  } ?></tr>
									<?php 										
									
									while($recChkQoute = $db2->fetch_array($execChkQoute)) {						
											$result = 0;
											
											$alert_attr = $recChkQoute[text_attr_name]."=".$recChkQoute[text_attr_value];
											//$alert_attr = eregi_replace("#","<span style='color:red'>#</span>",$alert_attr);	
											//$alert_attr = eregi_replace("[$]","<span style='color:red'>$</span>",$alert_attr);	
											//$alert_attr = eregi_replace("%","<span style='color:red'>%</span>",$alert_attr);	
											//$alert_attr = eregi_replace("/","<span style='color:red'>/</span>",$alert_attr);	
											//$alert_attr = eregi_replace(";","<span style='color:red'>;</span>",$alert_attr);		
											//$alert_attr = eregi_replace("[","<span style='color:red'>[</span>",$alert_attr);	
											//$alert_attr = eregi_replace("]","<span style='color:red'>]</span>",$alert_attr);		
											//$alert_attr = eregi_replace("+","<span style='color:red'>+</span>",$alert_attr);		
											//$alert_attr = eregi_replace("-","<span style='color:red'>-</span>",$alert_attr);			
											//$alert_attr = eregi_replace("*","<span style='color:red'>*</span>",$alert_attr);			
												?>
												<tr>
														<td align="center"><?php  echo $recChkQoute[text_rank]; ?></td>
														<td>	<?php  echo "&bull; ".$recChkQoute[text_tag]; ?></td><td>	<?php  echo " $alert_attr"; ?></td>
													<?php  if($_POST["run_edit"]) {
																//$pack_attr = 'NULL'
																
																$edit_value = $recChkQoute[text_attr_value];
																
																if( trim($edit_value) == "'" || trim($edit_value) == $charac1) {
																		$edit_value = $charac1.$charac1;
																} else if( trim($edit_value) == '"' || trim($edit_value) == $charac2) {
																		$edit_value = $charac2.$charac2;
																} else {
																	if(!eregi("^".$charac2, $edit_value)) {
																			$edit_value = $charac2.$edit_value;
																	}
																	if(!eregi($charac2."$", $edit_value)) {
																			$edit_value = $edit_value.$charac2;
																	}
																}																
																$UPDATE = " UPDATE web_attr SET text_edit_value = '".$edit_value."' WHERE  text_attr_id = '".$recChkQoute[text_attr_id]."' ";
																$result = $db2->query($UPDATE);	
																
																?><td align="center"> <?php  $disp->show_icon_pass($result); ?></td>
													<?php 					if($result) {
																				$total_err--;
																		}	
															}	
											  ?></tr>	<?php 																																														
											//print_r($arr_temp_attr);
											//echo "<br><br>";											
									} // end while $recChkQoute
								
								?><table><br><?php 
						}												
						
						$sqlChar = " SELECT  *  FROM convert_special_char  ";																				
						$execChar = $db2->query($sqlChar);
						while($recChar = $db2->fetch_array($execChar)) {		
						
								$sql_chk = " SELECT  text_id  FROM web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND  text_value  LIKE '%".$recChar[special_char]."%' ";
								$exec_chk = $db2->query($sql_chk);
								
								$num_chk = $db2->num_rows($exec_chk);
								
								if($num_chk) {
										
									$invalid = true;	
									$total_err+=$num_chk;									
													?>
									<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse"> 
										<tr>													
											 <td width="600"><strong>รายการ / คำอธิบาย</strong></td>
										<?php  if($_POST["run_edit"]) { ?>
											<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
										<?php  } ?>
										</tr>
										<tr>													
											 <td>พบการใช้อักขระพิเศษ <?php echo $recChar[special_char];?> ที่ยังไม่ได้แปลงเป็นรหัส <?php  echo number_format($num_chk,0); ?> จุด</td>											 
											<?php 			
										
											if($_POST["run_edit"]) {
													$UPDATE = " UPDATE  web_tag  SET  text_value = REPLACE(text_value, '".$recChar[special_char]."', '".$recChar[w3c_char]."' )  
													 WHERE filename = '$filecheck' AND db_name = '$main_db' ";
													 
													 $result = $db2->query($UPDATE);	
													 
													 ?><td align="center"> <?php  $disp->show_icon_pass($result); ?></td>
														<?php 			
														if($result) {
																$total_err -= $num_chk;
														}	
											}
											?>
										</tr>
									</table><br>
										<?php 
								}
						}
							?>
							
							<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse">
							<tr> <td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>
									<td width="700"><strong>รายการ / คำอธิบาย</strong></td>
									<?php  if($_POST["run_edit"]) { ?>
										<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
									<?php  } ?></tr>
							<?php 
							$sqlAttr1 = " SELECT  DISTINCT tag_name, attribute_name, recommend, correct_value  FROM  value_edit_attr_tag  WHERE  notnull = '1' ORDER BY  tag_name, attribute_name ";
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
									
									$sql_webtag = " SELECT  `web_tag`.`text_id`,
																	  text_tag,
																	  `web_tag`.`text_status` ,
																	  text_rank
																	FROM  web_tag  
																	WHERE
																		filename = '$filecheck' AND db_name = '$main_db'  AND
																		 text_tag = '$tag_name'  AND  ( text_status <> 'del'  OR text_status is null )
																	ORDER BY  text_rank, text_id";
									//echo "$sql_webtag<br><br>";
									$exec_webtag = $db2->query($sql_webtag);		
									
									while($rec_webtag =  $db2->fetch_array($exec_webtag)) {
												
												$text_id = $rec_webtag[text_id];
												
												$sqlChkAttr1 = " SELECT 																	
																	  `web_attr`.`text_attr_id`,
																	  `web_attr`.`text_attr_name`,
																	  `web_attr`.`text_attr_value`,
																	  `web_attr`.`text_edit_value`
																	FROM
																	`web_attr` 
																	WHERE																																																
																	text_id = '$text_id'  AND `web_attr`.`text_attr_name` = '$attribute_name'  ";
												
												$execChkAttr1 = $db2->query($sqlChkAttr1);		
												//echo "$sqlChkAttr1<br><br>";
												
												$numChkAttr1 = $db2->num_rows($execChkAttr1); 
												// จำนวน tag ที่มี $attribute_name
												
												/*
												$sqlChkAttr2 = " SELECT 																	
																	  `web_attr`.`text_attr_id`,
																	  `web_attr`.`text_attr_name`,
																	  `web_attr`.`text_attr_value`,
																	  `web_attr`.`text_edit_value`
																	FROM
																	`web_attr` 
																	WHERE		text_id = '$text_id'  AND 																																														
																	 ( `web_attr`.`text_attr_name` = '$attribute_name' AND 																		
																		( REPLACE( REPLACE( `text_edit_value`, '$charac2', ''), '$charac1', '') = '' OR text_edit_value IS NULL ) AND
																		( REPLACE( REPLACE( `text_attr_value`, '$charac2', ''), '$charac1', '') = '' OR text_attr_value IS NULL )
																	) "; // REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') = '' 
												//echo "$sqlChkAttr2<br><br>";
												$execChkAttr2 = $db2->query($sqlChkAttr2);		
												
												$numChkAttr2 = $db2->num_rows($execChkAttr2); */
												
												if($numChkAttr1==0 ) {			//   || $numChkAttr2 > 0		 เปลี่ยนใหม่เป็น แค่มีการ set ค่า = "" ก็ผ่านแล้ว																																																
														
														//$total_warn++;
														 //while($recChkAttr1  = $db2->fetch_array($execChkAttr1)) {		
														 $show_pic  = "";
														 
														// if(strtoupper($tag_name)=="IMG" ) {
														 		
																$invalid = true;		
																$total_err++;
																
																$result  = 0;
																
																			$sqlChk2 = " SELECT 
																				  `web_attr`.`text_attr_id`,
																				  `web_attr`.`text_attr_name` AS text_attr_name,
																				  `web_attr`.`text_attr_value`,
																				  `web_attr`.`text_id`,
																				  `web_attr`.`text_edit_value`
																				FROM
																				  `web_attr`
																				  WHERE text_attr_name = 'src' AND text_id = '".$text_id."' ";
																				  
																			$execChk2 = $db2->query($sqlChk2);
																			$recChk2 = $db2->fetch_array($execChk2);								
																			
																		$src_current = ($recChk2[text_edit_value])? $recChk2[text_edit_value]:$recChk2[text_attr_value];
																			
																			$src_preview = eregi_replace("(".$charac2.")|(".$charac1.")","",$src_current);
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
																			//echo "$src_preview <br>";
																			// เนื่อง w3c_validator.php ที่ใช้งานอยู่นี้ ต้องย้อน path รูป แค่ครั้งเดียว ซึ่งต่างจาก web ที่ convert เป็น output ไปวางใน checked แล้ว จึงจะย่้อน path 2 ครั้ง
																			//$src_preview= "http://www.google.co.th";
																			
																			
																			$show_pic = "<img src='$src_preview' border='0' > ";
																			
						
											 				?><tr>
															<td  align="center"><?php echo $rec_webtag[text_rank];?> </td>
															<td><?php echo strtoupper($rec_webtag[tag_name]);?> <?php echo $recommend;?><br><?php  if(strtoupper($tag_name)=="IMG" ) { echo $show_pic; } ?></td>
											 				<?php  if($_POST["run_edit"]) {
																																																																																																																																											
																		
																		//$sqlChkAlt = " SELECT web_attr.text_attr_id FROM web_attr  WHERE text_attr_name = '$attribute_name' AND text_id = '$text_id' ";
																		
																		//$execChkAlt = $db2->query($sqlChkAlt);
																		//$numChkAlt = $db2->num_rows($execChkAlt);
																		
																		if($numChkAttr1==0) { //if($numChkAlt==0) 
																			$INSERT = " INSERT INTO web_attr(text_attr_name, text_attr_value, text_id, text_edit_value) VALUES ('$attribute_name', '', '$text_id', '".$charac2.$correct_value.$charac2."' ) 	 ";
																			$result = $db2->query($INSERT);
																		} else {
																			//$recChkAlt = $db2->fetch_array($execChkAlt);
																			
																			$UPDATE = " UPDATE web_attr SET  text_edit_value = '".$charac2.$correct_value.$charac2."'  WHERE text_attr_name = '$attribute_name' AND text_id = '$text_id'   ";
																			$result = $db2->query($UPDATE);																								
																		}
																		
																		?><td align="center"> <?php  $disp->show_icon_pass($result); ?></td><?php 
																		
																		if($result) {
																				$total_err--;
																		}	
																}
																
																?></tr><?php 														 																		
																
														// }  // end ถ้าเป็น IMG เท่านั้น จึงจะ error
														 
														//} // end while																										
												
												} // if($numChkAttr1==0 || $numChkAttr2 > 0)
									} // while  $rec_webtag
					
					} // while $recAttr1
									
				  ?></table><br>
				  <?php 
				  //$sql_attr_url = "";
				  
				  ?>
				  
				  <?php 
					/////////////// ตรวจสอบสีตัวอักษร ถ้าไม่ใช่สีดำ ( จาก <font>  )  style ยังไม่ได้่
														
					$sqlChkColor = "  SELECT 
														  `web_tag`.`text_id`,
														  text_tag,
														  text_rank,
														  	web_tag.text_attr,
														  `web_attr`.`text_attr_id`,
														  `web_attr`.`text_attr_name`,
														  `web_attr`.`text_attr_value`,
														  `web_attr`.`text_edit_value`
														FROM
														  `web_tag`
														  INNER JOIN `web_attr` ON (`web_tag`.`text_id` = `web_attr`.`text_id`)
														WHERE filename = '$filecheck' AND db_name = '$main_db' AND  ( text_status <> 'del'  OR text_status is null )  AND
															text_attr_name = 'color' AND 
															( ( (text_edit_value IS NULL OR text_edit_value = '' ) AND text_attr_value IS NOT NULL AND REPLACE( REPLACE(`text_attr_value`, '$charac2', ''), '$charac1', '') NOT IN ('#000000','black') ) OR ( text_edit_value IS NOT NULL AND REPLACE( REPLACE(`text_edit_value`, '$charac2', ''), '$charac1', '') NOT IN ('#000000','black') ) ) 
															
														ORDER BY web_tag.text_id    ";
														// REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT IN ('#000000','black') 
						$execChkColor = $db2->query($sqlChkColor);
						$numChkColor = $db2->num_rows($execChkColor);
						
						if($numChkColor) {
								$invalid = true;	
								//$total_err++;
								$total_warn+=$numChkColor;
								?><table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse"><caption align="left"><span style="color:blue">สีตัวอักษรไม่เหมาะสม..</span></caption>					<tr>
											<td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>
											<td width="700"><strong>รายการ / คำอธิบาย</strong></td>
											<?php  if($_POST["run_edit"]) { ?>
												<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
											<?php  } ?></tr>									
									<?php 
										while($recChkColor  = $db2->fetch_array($execChkColor)) {
											 		$result = 0;
													
													$text_id = $recChkColor[text_id];	
													$attribute_name = $recChkColor[text_attr_name];			
													
													$field_attr = ($recChkColor[text_edit_value])? $recChkColor[text_edit_value]:$recChkColor[text_attr_value];
													$alert_attr = $attribute_name."=".$field_attr;									 	
													?>							
													<tr>
														<td  align="center"><?php echo $recChkColor[text_rank];?> </td>
														<td width="700">&bull; <?php  echo $alert_attr; // $recChkColor[text_attr];?>
														<?php 
															if($_POST["run_edit"]) {  // ส่วนแก้ สีอักษร ให้เป็นดำ
																
																 $UPDATE = " UPDATE web_attr SET  text_edit_value = '".$charac2."#000000".$charac2."'  WHERE text_attr_name = '$attribute_name' AND text_id = '$text_id'   ";
																 $result = $db2->query($UPDATE);								
																 
																 ?><td width="150" align="center" > <?php  $disp->show_icon_pass($result); ?></td><?php 
																 
																 		if($result) {
																				$total_warn--;
																		}	
															} // end if run edit
														?></td>
													</tr>							
													<?php 
												
										 } // end while $recChkColor
							 ?></table><?php 
						}  // end if $numChkColor
									
						/////////////// ตรวจสอบสีพื้นหลัง ถ้าไม่ใช่สีขาว ( จาก bgcolor  )   background-color ยังไม่ได้
									
						$sqlChkColor = "  SELECT 
														  `web_tag`.`text_id`,
														  text_tag,
														  text_rank,
														  	web_tag.text_attr,
														  `web_attr`.`text_attr_id`,
														  `web_attr`.`text_attr_name`,
														  `web_attr`.`text_attr_value`,
														  `web_attr`.`text_edit_value`
														FROM
														  `web_tag`
														  INNER JOIN `web_attr` ON (`web_tag`.`text_id` = `web_attr`.`text_id`)
														WHERE filename = '$filecheck' AND db_name = '$main_db' AND  ( text_status <> 'del'  OR text_status is null ) AND
															text_attr_name = 'bgcolor' AND 
															( ( (text_edit_value IS NULL OR text_edit_value = '' ) AND text_attr_value IS NOT NULL AND REPLACE( REPLACE(`text_attr_value`, '$charac2', ''), '$charac1', '') NOT IN ('#FFFFFF','white')  ) OR ( text_edit_value IS NOT NULL AND REPLACE( REPLACE(`text_edit_value`, '$charac2', ''), '$charac1', '') NOT IN ('#FFFFFF','white') ) )																
														ORDER BY web_tag.text_id    ";
												// REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT IN ('#FFFFFF','white') 
						//echo "$sqlChkColor<br>";
						$execChkColor = $db2->query($sqlChkColor);
						$numChkColor = $db2->num_rows($execChkColor);
						
						if($numChkColor) {
								$invalid = true;	
								//$total_err++;
								$total_warn+=$numChkColor;
								?><br><table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse"><caption align="left"><span style="color:blue">สีพื้นหลังไม่เหมาะสม...</span></caption>			<tr>
											<td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>
											<td width="700"><strong>รายการ / คำอธิบาย</strong></td>
											<?php  if($_POST["run_edit"]) { ?>
												<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
											<?php  } ?></tr>
									<?php 
										while($recChkColor  = $db2->fetch_array($execChkColor)) {
											 		$result = 0;
													
													$text_id = $recChkColor[text_id];	
													$attribute_name = $recChkColor[text_attr_name];			
													
													$field_attr = ($recChkColor[text_edit_value])? $recChkColor[text_edit_value]:$recChkColor[text_attr_value];
													$alert_attr = $attribute_name."=".$field_attr;								 	
													?>							
													<tr>
														<td  align="center"><?php  echo $recChkColor[text_rank];?>  </td>
														<td width="700">&bull; <?php  echo $alert_attr; //$recChkColor[text_attr];?>
														<?php 
															if($_POST["run_edit"]) {  // ส่วนแก้ สีอักษร ให้เป็นดำ
																
																 $UPDATE = " UPDATE web_attr SET  text_edit_value = '".$charac2."#FFFFFF".$charac2."'  WHERE text_attr_name = '$attribute_name' AND text_id = '$text_id'   ";
																 $result = $db2->query($UPDATE);								
																 
																 ?><td width="150" align="center" > <?php  $disp->show_icon_pass($result); ?></td><?php 
																 
																		if($result) {
																				$total_warn--;
																		}	
															} // end if run edit
														?></td>
													</tr>							
													<?php 
												
										 } // end while $recChkColor
							 ?></table><?php 
					}  // end if $numChkColor												
																												
						
						if($_POST["run_edit"]  ||  $total_err == 0 ) { // แก้ไขเสร็จ ก็รวม tag กลับเป็นหน้าเว็บเพจ w3c																	
	
									$sql_chk_add = " SELECT  text_id, text_tag, text_rank  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND text_tag = 'title' AND  ( text_status <> 'del'  OR text_status is null )  ";										
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
												
											$UPDATE = " UPDATE web_tag SET  text_rank = text_rank+1 WHERE   filename = '$filecheck' AND db_name = '$main_db'  ";
											$db2->query($UPDATE);
												// update rank ของ tag  ทั้งหมด ก่อนเพิ่ม tag ใหม่ จะง่ายกว่า  update rank ทีหลัง								
																																								
											$INSERT = " INSERT INTO web_tag(filename, db_name, text_tag, text_value, text_attr, text_rank, section_edit) VALUES ('$filecheck', '$main_db', 'title', '$ewt_mytitle', '', '0', '".$title_info[section_id]."' ) ";   
											$db2->query($INSERT);											
											
											$sql_chk_add = " SELECT  text_id, text_tag, text_rank  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND text_tag = '/title' AND  ( text_status <> 'del'  OR text_status is null ) ";										
											$exec_chk_add = $db2->query($sql_chk_add);											
											$num_chk_add = $db2->num_rows($exec_chk_add);
											
											if($num_chk_add==0) { // ถ้ายังไม่มี /title  ให้ insert  ด้วย
												
												$UPDATE = " UPDATE web_tag SET  text_rank = text_rank+1 WHERE   filename = '$filecheck' AND db_name = '$main_db' AND  text_tag  <> 'title' ";
												$db2->query($UPDATE);
																				
												$INSERT = " INSERT INTO web_tag(filename, db_name, text_tag, text_value, text_attr, text_rank, section_edit) VALUES ('$filecheck', '$main_db', '/title', '', '', '1', '".$title_info[section_id]."' ) ";   
												$db2->query($INSERT);
											
											}
									}
									
									/////////////////  ส่วนแก้ path รูปที่ไม่ได้ ขึ้นต้นด้วย path internet							
									// และ  แก้ path Link  href ด้วย								
									$sql_edit_path = " SELECT web_tag.text_id, text_attr_name, REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS   text_attr_value1 FROM web_attr  INNER JOIN web_tag ON  web_attr.text_id = web_tag.text_id WHERE filename = '$filecheck' AND db_name = '$main_db' AND web_attr.text_attr_name IN ('src', 'href') AND ( REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT LIKE 'http:%' AND REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  NOT LIKE 'www.%' )  OR ( ( REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') LIKE '%$CS_WWW%' OR REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') LIKE 'localhost/%' )  AND REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT LIKE '%/w3c%' )  ORDER BY text_rank, web_tag.text_id   ";										
									$exec_edit_path = $db2->query($sql_edit_path);		
									//echo "$sql_edit_path<br>";
									//exit;
									while($rec_edit_path = $db2->fetch_array($exec_edit_path))	{
											$arr_path = array();
											$arr_path = explode("/",$rec_edit_path[text_attr_value1],2);  
											//  แยก ส่วนแรกของ url ไว้ check ว่าเป็น IP รึป่าว
											
											 // $rec_edit_path[text_attr_name] ในที่นี้ คือ src, href
											
											//print_r($arr_path);
											//echo "<br>";
											/*
											if($rec_edit_path[text_attr_name]=='href') {
														$linkfile = strrchr($rec_edit_path[text_attr_value1], "/");
														$linkfile = str_replace("/","",$linkfile);
																												
														$edit_value = $charac2.$linkfile.$charac2;
														$UPDATE = " UPDATE web_attr SET  text_edit_value = '$edit_value' WHERE text_attr_name = '".$rec_edit_path[text_attr_name]."' AND text_id = '".$rec_edit_path[text_id]."'   ";
														 //echo "$UPDATE<br>";
														 $db2->query($UPDATE);
											} else {
											*/
													if( $arr_path[0] && (substr_count($arr_path[0], '.') < 3) ) { 
															//  ถ้าค่าของ $arr_path[0]  มี . น้อยกว่า 3 อัน แปลว่าไม่ใช่ขึ้นต้นด้วย IP  แล้วจึงจะแก้ path โดยเติม ../../
															// !eregi("^[0-9]", $arr_path[0])
															
														$edit_value = $charac2."../../".$rec_edit_path[text_attr_value1].$charac2;
														$UPDATE = " UPDATE web_attr SET  text_edit_value = '$edit_value' WHERE text_attr_name = '".$rec_edit_path[text_attr_name]."' AND text_id = '".$rec_edit_path[text_id]."'   ";
														 //echo "$UPDATE<br>";
														 $db2->query($UPDATE);	
													}
											//}
									}
									
									// แก้ path ของ <param name="movie" value="images/flash/xxxxx.swf">
									$sql_movie = " SELECT web_tag.text_id, text_attr_name, REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS   text_attr_value1 FROM web_attr  INNER JOIN web_tag ON  web_attr.text_id = web_tag.text_id WHERE filename = '$filecheck' AND db_name = '$main_db' AND web_tag.text_tag = 'param' AND  web_attr.text_attr_name = 'name' AND  web_attr.text_attr_value = 'movie'  ORDER BY text_rank, web_tag.text_id   ";										
									$exec_movie = $db2->query($sql_movie);		
									// echo "<br>$sql_movie<br>";
									while($rec_movie = $db2->fetch_array($exec_movie))	{
											
											$sql_edit_path = " SELECT web_tag.text_id, text_attr_name, REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS   text_attr_value1
												 FROM web_attr  WHERE  filename = '$filecheck' AND db_name = '$main_db' AND web_tag.text_id = '".$rec_movie[text_id]."' AND  web_attr.text_attr_name = 'value' AND 
												 ( REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT LIKE 'http:%' AND REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  NOT LIKE 'www.%' )  OR ( ( REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') LIKE '%$CS_WWW%' OR REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') LIKE 'localhost/%' )  AND REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT LIKE '%/w3c%' )  
												 ORDER BY text_rank, web_tag.text_id   ";										
											$exec_edit_path = $db2->query($sql_edit_path);	
											//echo "<br>$sql_edit_path<br>";
											$arr_path = array();
											
											if($rec_edit_path[text_attr_name]=='value') {
											
													
													$arr_path = explode("/",$rec_edit_path[text_attr_value1],2);
													//  แยก ส่วนแรกของ url ไว้ check ว่าเป็น IP รึป่าว
																
													if( $arr_path[0] && (substr_count($arr_path[0], '.') < 3) ) { 
															//  ถ้าค่าของ $arr_path[0]  มี . น้อยกว่า 3 อัน แปลว่าไม่ใช่ขึ้นต้นด้วย IP  แล้วจึงจะแก้ path โดยเติม ../../
															// !eregi("^[0-9]", $arr_path[0])
															
														$edit_value = $charac2."../../".$rec_edit_path[text_attr_value1].$charac2;
														$UPDATE = " UPDATE web_attr SET  text_edit_value = '$edit_value' WHERE text_attr_name = 'value' AND text_id = '".$rec_movie[text_id]."'   ";
														 //echo "$UPDATE<br>";
														 $db2->query($UPDATE);	
													}
											}
									}
									
									// แก้ path ที่อยู่ใน style 
									$sql_edit_path = " SELECT web_tag.text_id, text_attr_name, REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS   text_attr_value1, REPLACE( REPLACE(`web_attr`.`text_edit_value`, '$charac2', ''), '$charac1', '')  AS   text_edit_value1 FROM web_attr  INNER JOIN web_tag ON  web_attr.text_id = web_tag.text_id WHERE filename = '$filecheck' AND db_name = '$main_db' AND web_attr.text_attr_name = 'style' AND text_edit_value LIKE '%url(%' OR text_attr_value LIKE '%url(%' ORDER BY text_rank, web_tag.text_id   ";										
									$exec_edit_path = $db2->query($sql_edit_path);		
									//echo "<br>$sql_edit_path<br>";
									while($rec_edit_path = $db2->fetch_array($exec_edit_path))	{
									
											$attribute_val = ($rec_edit_path[text_edit_value1])? $rec_edit_path[text_edit_value1]:$rec_edit_path[text_attr_value1];
											$arr_path = $arr_tail = array();
											//$arr_path = explode("/",$rec_edit_path[text_edit_value1],2);
											//background:url(
											
											$arr_path = split(":url",str_replace(" ", "",$attribute_val),2);
											
											//print_r($arr_path);
											//echo "<br>";
										if($arr_path[1]) {
												$str_temp = substr($arr_path[1],1);
										
											
												$arr_tail = split("[)]", $str_temp,2);
												
												// &&  !eregi("^[0-9]", $arr_tail[0]) 
												if( $arr_tail[0]  && ((substr_count($arr_tail[0], '.') < 3) && ( !eregi("^http:", $arr_tail[0]) ) && !eregi("^www.", $arr_tail[0])) || (eregi($CS_WWW, $arr_tail[0]) &&  !eregi("/w3c", $arr_tail[0]) )  ) {
												    //  ถ้าค่าของ $arr_tail[0]  มี . น้อยกว่า 3 อัน แปลว่าไม่ใช่ขึ้นต้นด้วย IP  แล้วจึงจะแก้ path โดยเติม ../../
													
													$edit_value = $charac2.$arr_path[0].":url(../../".$arr_tail[0].")".$arr_tail[1].$charac2;
													
													$UPDATE = " UPDATE web_attr SET  text_edit_value = '$edit_value' WHERE text_attr_name = 'style' AND text_id = '".$rec_edit_path[text_id]."'   ";
													
													//echo "<br>$UPDATE<br>";
													$db2->query($UPDATE);	
												}
									 	} // end if($arr_path[1]) 
									} // แก้ path รูป ใน style
																	
						
								$sql_w3c = " SELECT  *  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '$main_db' AND text_tag NOT IN ('!doctype', 'html', 'head', 'body', '/html', '/head', '/body') 
														ORDER BY section_edit, text_rank, text_id ";
								$exec_w3c = $db2->query($sql_w3c);																
								
																
								$head_contents = file_get_contents("style.html");  // head section
								
								$COMPTOP = file_get_contents("comptop.html");  
								$COMPBOTTOM = file_get_contents("compbottom.html");
								
								$new_contents = ""; // body section
								
								$body_attr = ""; // อันนี้ไว้กำหนดทีหลัง อาจไม่มี ก็ได้
								
								while($rec_w3c=$db2->fetch_array($exec_w3c)) {
										
										if($rec_w3c[text_tag]=="script" || $rec_w3c[text_tag]=="style" ) {  // ถ้าเจอ tag  script หรือ style
											 
												$in_script = true;
												
												$sql_atb = " SELECT  *  FROM  web_attr  WHERE text_id = '".$rec_w3c[text_id]."' 
																									ORDER BY text_attr_id ";
																		$exec_atb = $db2->query($sql_atb);
																		$text_up_attr = "";
																		while($rec_atb=$db2->fetch_array($exec_atb)) {
																				if($rec_atb[text_edit_value]) {
																						$edit_attr = $rec_atb[text_edit_value];
																				} else {
																						$edit_attr = $rec_atb[text_attr_value];
																				}
																				if(trim($rec_atb[text_attr_name])) {
																					$text_up_attr .= $rec_atb[text_attr_name]."=".$edit_attr." ";
																				}
																		}
												if($rec_w3c[section_edit]==3) {  //  head 
												
													$head_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag])." ".$disp->convert_specials_char($text_up_attr).">".$disp->convert_specials_char($rec_w3c[text_value]);
													
												} else {	// ถ้าเป็น section 4 body  หรือ ไม่รู้ section ไหน ให้เก็บไว้ในตัวแปร body $new_contents ไว้ก่อน
												
													$new_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag])." ".$disp->convert_specials_char($text_up_attr).">".$disp->convert_specials_char($rec_w3c[text_value]);
													
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
															$new_contents .= $rec_w3c[text_value];	// จึงจะเก็บเข้าตัวแปร body											
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
																		$sql_atb = " SELECT  *  FROM  web_attr  WHERE text_id = '".$rec_w3c[text_id]."' 
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
																					$text_up_attr .= $disp->convert_specials_char($rec_atb[text_attr_name])."=".$disp->convert_specials_char($edit_attr,$rec_attr_info[attribute_type])." ";
																				}
																		}
																		if($rec_w3c[section_edit]==3) {  //  head 
												
																			$head_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag])." ".$text_up_attr.">".ereg_replace("&amp;",'&',$rec_w3c[text_value]);
																			
																		} else {	// ถ้าเป็น section 4 body  หรือ ไม่รู้ section ไหน ให้เก็บไว้ในตัวแปร body $new_contents ไว้ก่อน
																			$new_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag])." ".$text_up_attr.">".ereg_replace("&amp;",'&',$rec_w3c[text_value]);  //  ereg_replace("&amp;",'&',$new_contents)
																			
																		}
																		
																	} else { // ถ้าเป็น tag ปิด
																	
																			if($rec_w3c[section_edit]==3) {  //  head 
													
																				$head_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag]).">".ereg_replace("&amp;",'&',$rec_w3c[text_value]);
																				
																			} else {	// ถ้าเป็น section 4 body  หรือ ไม่รู้ section ไหน ให้เก็บไว้ในตัวแปร body $new_contents ไว้ก่อน
																				$new_contents.="<".$disp->convert_specials_char($rec_w3c[text_tag]).">".ereg_replace("&amp;",'&',$rec_w3c[text_value]);
																			}
																	}			
														} else {  // แม้ ไม่มี tag อะไร ก็ต้องเก็บเนื้อหาเว็บด้วย
																// ไม่มี tag ก็ไม่รู้ section ไหน ดังนั้นเก็บเข้า body เท่านั้น ไปเลย
																																														
																$new_contents .= $rec_w3c[text_value];
														}				
												
												}	// end ถ้าไม่มี สถานะ ลบ del						
									 } // end else $in_script
							} // while tag 
								
								//$new_contents = html_entity_decode($new_contents); // PHP >= 4.3
								//$new_contents = htmlspecialchars_decode($new_contents); // PHP >= 5.1.0RC1
								/*  ไม่ต้องแปลง character กลับ เป็น " ทั้งหมด  
								  คือไม่ให้แปลง เนื้อหา (text_value) 
								$new_contents = ereg_replace("&quot;",'"',$new_contents);
								$new_contents = ereg_replace("&#039;","'",$new_contents);
								$new_contents = ereg_replace("&amp;",'&',$new_contents);
								$new_contents = ereg_replace("&lt;",'<',$new_contents);
								$new_contents = ereg_replace("&gt;",'>',$new_contents);
								
								*/
								//$head_contents = ereg_replace("&amp;",'&',$head_contents);
								//$new_contents = ereg_replace("&amp;",'&',$new_contents);
								
								//testvar_infile($templete_checked_top.$new_contents.$templete_checked_bottom, $dir1.$filecheck, 'w'); // เขียน tag เป็นไฟล์ html ที่ convert เบื้องต้นแล้ว ใส่ checked folder
								
								
								$phpcontents = "<?php  //include session or connect ?>".$dtd_html_head_charset_top.$head_contents.$dtd_html_head_charset_bottom." <body ".$body_attr.">".$COMPTOP.$new_contents.$COMPBOTTOM."</body>".$END_PAGE;
								
								//echo $UserPath.$dir1." : ".file_exists($UserPath.$dir1)."<br>";  //  เราลองแล้ว path $dir1 นี้มีแยู่จริง
							if(file_exists($UserPath.$dir1)) {									
									$result1 = $disp->testvar_infile($phpcontents, $UserPath.$dir1.$filecheck.".php", "w");// จึงต้อง write file แืืทน 
							}
					}// end if($_POST["run_edit"]  ||  $total_err == 0 )  // แก้ไขเสร็จ ก็รวม tag กลับเป็นหน้าเว็บเพจ w3c
				
				//echo "run edit ".$_POST["run_edit"]."<br>";
			
						
				if($total_err > 0 && $_POST["run_edit"] ) {
						$last_status = "chk";
						$label_status = "<span style=\"color:green\"><strong>หน้านี้ได้รับการแปลงให้ได้มาตรฐาน W3C ในเบื้องต้นแล้ว.</strong></span><br><br>ท่านสามารถใช้ Editor ในการทำให้หน้าเว็บ W3C สมบูรณ์ยิ่งขึ้น"; 
				} 
				
				if($total_err==0 ) {
						$last_status = "w3c";
						
						if($_GET["recheck"]) {
						
								$label_status = "<span style=\"color:green\"><strong>หน้านี้ได้รับการแปลงให้ได้มาตรฐาน W3C เรียบร้อยแล้ว</strong></span>";								
								
						} else {						
						
								$label_status = "<span style=\"color:green\"><strong>ไม่พบความผิดพลาด ตามมาตรฐาน W3C ระดับ A</strong></span>";
						}
										
				} 
				
				//if($_POST["run_edit"]) {     //  update status ทุกครั้งที่ check ไปเลย  ไม่จำเป็นต้องกด convert ก่อน
					$UPDATE = " UPDATE webpage_info SET  w3c_status = '$last_status', modify_time  = NOW() WHERE  filename = '$filecheck' AND db_name = '$main_db'  ";
					$db2->query($UPDATE);
				//	}
				
				if($_POST["run_edit"] ) { //     convert เสร็จรอบนึง ให้ ตรวจอีกรอบ  จึงจะได้จำนวน error ที่เหลือ อันน่าเชื่อถือ
							//  $total_err > 0 &&   เหลือ error เท่าไร ก็ควร ตรวจอีกรอบอยู่ดี
							
						?><script language="javascript">
								//  window.location = "w3c_validator.php?filename=<?php echo $filecheck;?>&recheck=1";
							 </script>
                         <?
						// exit;
				}			
				
				echo "<br>จำนวนความผิดพลาด : <span style='color:red'>".number_format($total_err)."</span> <br>";
				echo "จำนวนการเตือน (แต่ไม่ผิด) : ".number_format($total_warn)." <br><br>";		
				
								
				?><H2 style="background-color:#F3F3F3"><?php  echo $label_status; ?></H2>
				<script language="javascript">
					opener.location.reload();
				</script>
				<?php 												
					
					if(!$_POST["run_edit"]) { //  ถ้ายังไม่กดปุ่ม Convert
												
						if( $total_err > 0 ) {	 // $invalid==true
							 // Convert to W3C page
							?><br>
							<input name="bt_edit" type="button" value=" แปลงหน้าเว็บเบื้องต้น " onClick="return chkInput()">
							<?php 
						} 
					} // end !$_POST["run_edit"] // ถ้ายังไม่กดปุ่ม Convert
										
$db2->close_db();
$db->db_close();			
?>
<input name="filecheck" type="hidden" value="<?php echo $filecheck;?>"><input name="run_edit" type="hidden"></form>
</body>
</html>
