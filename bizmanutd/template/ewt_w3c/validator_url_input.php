 <? 
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
	
	$main_db = $EWT_DB_NAME; //"db_163_ictweb";  อาจไม่ต้องใช้ ฐานข้อมูลลูกค้าเลย  เพราะเราอ่านข้อมูลจากหน้าเวบ url โดยตรง
	
	
	if(!$main_db) { // ถ้าไม่รู้ว่า จะดึงข้อมูลหน้าเว็บจาก db_name อันไหน  ให้ดีดออก
		echo "UnKnown Client Database";
		exit;
	}
	
	
	////////////////////////   connection สำหรับ W3C //////////////////////
    $path = "./";
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
<title>Import data and W3C Validator</title>
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
<?
		if(!$_GET["url_check"]) {
		
			$_GET["url_check"] = 'http://192.168.0.250/ewtadmin/ewt/ictweb/main.php?filename=index'; // $_POST["url_check"];			
        } 
	   
?>
<body>
 <form name="frm" method="post" action="validator.php" >	
 <? if(!$_POST["run_edit"]) { ?>
 <fieldset> 
	   <label for="url_check">URL input</label> <input name="url_check" type="text" size="50" value="<?=$_GET["url_check"];?>">
	   <!--ภาษาหลัก
	   <select name="main_lang" size="1">
	   <option value="en" <? if($_POST["main_lang"]=="en") echo "selected"; ?>>อังกฤษ</option>
	   <option value="th" <? if($_POST["main_lang"]=="th") echo "selected"; ?>>ไทย</option>
	   </select>-->   
	   <input name="validate" type="submit" value="Import HTML and Validate" >
</fieldset>
<? } ?>
<?  				
/*
$sql_test = " SELECT  filename FROM  temp_index  ORDER BY filename ";
$exec_test = $db->query($sql_test);
while($rec = $db->db_fetch_row($exec_test)) {
	?><li><?=$rec[0];?></li><?
}
*/

//echo "$UserPath<br>".$_POST["run_edit"].",".$_POST["ewt_path"];

$total_err = 0;
$total_warn = 0;

$dir1 = "checked/";												
if(!file_exists($dir1)) {  // ถ้าไม่มี   folder checked ให้สร้างก่อน
		mkdir($dir1,0777);
}

		if($_POST["validate"] || $_POST["run_edit"] ) {
			    
				$filecheck = $_POST["filecheck"];
				
				
				$arr_name = explode("?filename=",$_POST["url_check"],2);				
				$filename = $arr_name[1];
						
				//if(!$filename) {
					//$newfile = $disp->newfilename($dir1.$newfile).".html";
					//$savename = $newfile;
				//} else {
					//$savename = $filename;
				//}	
				
				if($filename || $filecheck) {  // ถ้ามีชื่อหน้าเว็บ จึงจะทำการ validate ได้
						
			 					    						
					 if(!$_POST["run_edit"]) {								 																												
											 ////////////// ส่วนดึง tag จาก url มาแยกเก็บ ลงตาราง web_tag			
							$savename = $filename;
							if(!eregi(".htm",$savename)) {
								$savename = $savename.".html";
							} 
							
							$contents = file_get_contents($_POST["url_check"]);
									// อ่าน tag html จาก internet	ทั้งหน้ามาเก็บไว้  แล้วเขียนไฟล์ ลง folder ในเครื่องเราทีหลัง  ( แทนการ copy )
									//echo $contents;  			
										
							//echo "ชื่อไฟล์ (ที่อ่านหน้าเวบมาเก็บไว้แล้ว) : $dir1<strong>$newfile</strong><br>";
						    $result1 = $disp->testvar_infile($contents, $dir1.$savename, "w");// จึงต้อง write file แืืทน 
						
									/*
										$sql_fetch_del = " SELECT 
																	 `web_attr_html`.`text_id`,
																	  `web_tag_html`.`filename`,
																	  `web_tag_html`.`db_name`
																	FROM
																	  `web_tag_html`
																	  INNER JOIN `web_attr_html` ON (`web_tag_html`.`text_id` = `web_attr_html`.`text_id`)															
																WHERE `web_tag_html`.`filename` = '$savename' AND `web_tag_html`.`db_name` = '$main_db' ";
										$exec_fetch_del = $db2->query($sql_fetch_del);
										while($rec_fetch_del=$db2->fetch_array($exec_fetch_del)) {																				
												$DELETE2 = " DELETE FROM web_attr_html WHERE text_id = '".$rec_fetch_del[text_id]."'  ";
												$db2->query($DELETE2);
										}
										$DELETE = " DELETE FROM web_tag_html WHERE filename = '$savename' AND db_name = '".$main_db."'  ";
										
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
																WHERE `web_tag`.`filename` = '$savename' AND `web_tag`.`db_name` = '$main_db' ";
										$exec_fetch_del = $db2->query($sql_fetch_del);
										while($rec_fetch_del=$db2->fetch_array($exec_fetch_del)) {																				
												$DELETE2 = " DELETE FROM web_attr WHERE text_id = '".$rec_fetch_del[text_id]."'  ";
												$db2->query($DELETE2);
										}
										$DELETE = " DELETE FROM web_tag WHERE filename = '$savename' AND db_name = '".$main_db."'  ";
										$db2->query($DELETE); // ลบข้อมูล  web_tag เฉพาะ หน้าเว็บเดิมของ EWT ที่เคยนำเข้ามา ก่อนหน้านี้ไปก่อน แล้วค่อย import ใหม่
										
										$DELETE = " DELETE  FROM webpage_info  WHERE filename = '$savename' AND db_name = '".$main_db."'     ";								
										$db2->query($DELETE);
							  */
							  			
									$sql_check = " SELECT  filename FROM  webpage_info  WHERE filename = '$savename' AND db_name = '".$main_db."'   ";
									
									$exec_check = $db2->query($sql_check);
									
									$num_check = $db2->num_rows($exec_check);
									if($num_check==0) {													
											$INSERT = " INSERT INTO webpage_info (filename, main_group_id, db_name, modify_time ) 
																			VALUES ('$savename', '0', '".$main_db."', NOW() )";
											$db2->query($INSERT);																								
									} 
																											
									
									$htmlcode = trim($contents);
									//echo $htmlcode;
									//echo "<br>";
									
										$htmlcode = eregi_replace("/>",">",$htmlcode); // แก้ /> ไปก่อนเลย
										
										//$htmlcode = eregi_replace("<!--","<!--  ",$htmlcode); // แก้ <!-- ไปก่อนเลย
										
										$arr_tag = array();
										$attribute_pack = array();
										$text_value = array();
										
										$arr_words = array();								
										$arr_words = explode("<",$htmlcode);
											
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
																
														}
												} else {
													$arr_tag[$i] = "";
													$attribute_pack[$i] = "";
													$text_value[$i] = $arr_words[$i];
												}
												
												//echo "arr_words : ".$arr_words[$i]." <br><br>";
												//echo "arr_temp3[1]: ".$arr_temp3[1]." <br>";
												//echo "arr_temp2[1] : ".$arr_temp2[1]." <br>";
												
												//if($arr_tag[$i]=='marquee' ) {
												//	echo $arr_tag[$i]."<br>";
												//	print_r($arr_temp_attr);
												//	echo "<hr width='65%'>";
												//}
												if( strlen($arr_tag[$i]) <= 50 ) { // เอาเฉพาะ ชื่อ tag จริงๆ มันต้องมี เว้นวรรค แล้วความยาวชื่อไม่เกิน 50
														
														$INSERT = " INSERT INTO web_tag (filename, original_url, db_name, text_tag, text_value, text_attr, text_rank) 
																					VALUES ('$savename', '', '".$main_db."', '".$disp->convert_qoute_to_db(trim($arr_tag[$i]))."', '".$disp->convert_qoute_to_db($text_value[$i])."', '".$disp->convert_qoute_to_db($attribute_pack[$i])."', '$i' )";
														$db2->query($INSERT);
														
														//echo $INSERT."<br>";
														
														$text_id = mysql_insert_id();
														
														for($ci=0;$ci<count($arr_temp_attr);$ci++) {
																$piece_attr[$ci] = array();
																$piece_attr[$ci] = explode("=",$arr_temp_attr[$ci],2);
																
																$INSERT2 = " INSERT INTO web_attr (text_attr_name, text_attr_value, text_id) 
																					VALUES ('".$disp->convert_qoute_to_db(trim($piece_attr[$ci][0]))."', '".$disp->convert_qoute_to_db(trim($piece_attr[$ci][1]))."', '$text_id' ) ";
																$db2->query($INSERT2);
																
																//echo $INSERT2."<br>";
														}
												}																				
												
												//echo "<hr width='65%'>";
										}	// end for ใหญ่																		  					
								
								$filecheck = $savename;
						} // !$_POST["run_edit"]	end ถ้ายังไม่กด Convert   จึงจะดึงข้อมูลมาเก็บ
				
							
								 /////////////////////////  Validating W3C ทีละหน้าเว็บ  //////////////////////////////////////
						
									?>
									<H2>ผลการตรวจสอบเว็บเพจ : <span style="font-size:small; color:#FF0000"><?=$filecheck;?></span></H2> 
								<!--fieldset >	</fieldset-->
								<? if(!$_POST["run_edit"]) { ?>
									<strong>คำอธิบายรายละเอียดเว็บเพจ</strong> <br>
									<textarea name="w3c_description" rows="3" cols="30" ><?=$_POST["w3c_description"];?></textarea>
								<br><br>
								<? } ?>
									<?			  // $w3c_title  ไว้ทำในหน้า Editor
							
							if($_POST["run_edit"]) {
								$UPDATE = " UPDATE webpage_info  SET  cms_description = '".$disp->convert_qoute_to_db($_POST["w3c_description"])."',  modify_time  = NOW() WHERE filename = '$savename' AND db_name = '".$main_db."'     ";
								
								$db2->query($UPDATE);
							
							}
							
								//echo " filecheck : $filecheck <br>";						
								//exit;		
							
							$sql_arrange = " SELECT  * FROM  web_tag  WHERE  filename = '$filecheck' AND db_name = '".$main_db."'  AND  ( text_status <> 'del'  OR text_status is null ) AND ( text_tag <> 'marquee' ) ORDER BY text_rank, text_id ";
							//echo "$sql_arrange<br>"; 
							
							$exec_arrange = $db2->query($sql_arrange);
							
							$total_tag = $db2->num_rows($exec_arrange);
							
							$pass1 = 0;
							
							if($total_tag) {
							?>
							<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse"><caption align="left"><!--an attribute value must be a literal unless it contains only name characters.-->ตรวจสอบการเรียง tag และค่า attribute ที่เป็นไปได้<br></caption>
											<tr valign="top">
											<td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>
											<td width="600"><strong>รายการ / คำอธิบาย</strong></td>
											<? if($_POST["run_edit"]) { ?>
												<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
												<td width="100" align="center"><strong>ตำแหน่ง Tag<br>หลังแก้ไข</strong></td>
											<? } ?></tr>
										<?
										while($rec_arrange = $db2->fetch_array($exec_arrange)) {
													
												   $text_id1 = $rec_arrange[text_id];
												   $text_rank1 = $rec_arrange[text_rank];
												   $tag_name = $rec_arrange[text_tag];
												   
												   if($pass1) {
												   		$offset_rank = "-1";
												   } else {
												   		$offset_rank = "";												   
												  }
												  // echo "$tag_name : ".eregi("^/", trim($tag_name))."<br>";
												   
												   if(eregi("^/", $tag_name)) {  // check tag ปิด												   																	    
														  $chk_name = eregi_replace("/","",$tag_name);
														  
														  $sql_chk1 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE    filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_tag = '$chk_name'  AND  text_rank$offset_rank < '$text_rank1'  AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_rank DESC, text_id DESC  LIMIT 0,1  ";
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
																		<td align="center"><?=$text_rank1;?></td>
																		<td>ไม่พบ tag เปิดของ <strong><?=strtoupper($tag_name);?></strong></td>
																
																	<? if($_POST["run_edit"]) { 
																				$result = 0;
																				
																				if($pass1) {
																				
																				$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_id = '$text_id1'  ";
																									
																				$exec_newrank  = $db2->query($sql_newrank);
																				$rec_newrank = $db2->fetch_array($exec_newrank);
																				
																				} else {
																				
																						$rec_newrank[text_rank] = "&nbsp;";
																				}
																				
																				
																				?><td align="center"> &nbsp;<? show_icon_pass($result); ?></td>
																					<td align="center"><?=$rec_newrank[text_rank];?></td><?
																					
																					if($result) {
																							$total_err--;
																					}
																	
																		  } ?>
																</tr>
																<?																														  
														  }				  
														   																														
												   } else {  // check  tag เปิด
												   
														   $sql_tag = " SELECT  *  FROM  tag_info  WHERE  tag_name = '$tag_name'  ";
														   //echo " $sql_tag<br>";
														   $exec_tag = $db2->query($sql_tag);
														   
														   $rec_tag = $db2->fetch_array($exec_tag);
														   
														   if($rec_tag[need_close]) { //  check tag ที่ต้องปิด ว่ามีปิดมั้ย
														   
																  $sql_chk1 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE    filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_tag = '/$tag_name'  AND  text_rank > '$text_rank1'  AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_rank, text_id LIMIT 0,1 ";
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
																				<td align="center"><?=$text_rank1;?></td>
																				<td>ไม่พบ tag ปิดของ <strong><?=strtoupper($tag_name);?></strong></td>
																		
																			<? if($_POST["run_edit"]) { 
																						$result = 0;
																				
																						if($pass1) {
																						
																						$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_id = '$text_id1'  ";
																											
																						$exec_newrank  = $db2->query($sql_newrank);
																						$rec_newrank = $db2->fetch_array($exec_newrank);
																						
																						} else {
																						
																								$rec_newrank[text_rank] = "&nbsp;";
																						}
																						
																						
																						?><td align="center"> &nbsp;<? show_icon_pass($result); ?></td>
																							<td align="center"><?=$rec_newrank[text_rank];?></td><?
																						
																						if($result) {
																							$total_err--;
																						}
																				  } ?>
																		</tr>
																		<?																														  
																  }				  
														  } // end if($rec_tag[need_close])
														  
														  if(strtoupper($rec_tag[tag_grand]) != "TABLE") { 
														  			 // ถ้า tag ที่ตรวจปัจจุบัน ไม่ได้มี tag_grand  เป็น table
														  			
																	 ////////// ส่วนใหญ่แล้ว code ล่างนี้ไว้ ตรวจสอบ tag ทั่วไป  (ที่ไม่ใช่ ลูกของ table)
																	 
																  $sql_chk3 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_rank$offset_rank < '$text_rank1' AND  text_tag IS NOT NULL  AND text_tag <> '' AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_rank DESC, text_id DESC  LIMIT 0,1  ";    // หา tag ก่อนหน้านี้  1 tag																  
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
																							<td align="center"><?=$text_rank1;?></td>
																							<td>tag <strong><?=strtoupper($tag_name);?></strong> ต้องไม่อยู่ต่อจาก tag <strong><?=strtoupper($prev_tag);?> </strong></td>
																					
																						<? if($_POST["run_edit"]) { 
																						
																									$result = 0;
																									if(strtoupper($tag_name)=="FORM") {
																									
																											$sql_form = " SELECT  text_id, text_tag, text_rank  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_tag = '$tag_name'  AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_rank, text_id   ";
																											$exec_form = $db2->query($sql_form);
																											
																											$num_form = $db2->num_rows($exec_form);		
																											
																											if($num_form == 1 ) {
																											
																													/////// แก้ tag FORM  โดยให้ ทุก tag เพิ่ม rank แล้ว 
																													// ให้ tag FORM อยู่ที่ rank 0
																																																										
																													$update_rank = " UPDATE web_tag  SET  text_rank = text_rank+1  WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  ";
																													$pass1 = $db2->query($update_rank);
																													
																													$update_rank = " UPDATE web_tag  SET  text_rank = '0' WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_tag = '$tag_name'  AND  text_id = '$text_id1'   ";
																													$pass2 = $db2->query($update_rank);
																																				
																																				
																																																										
																													/////// แก้ tag /FORM  โดยหาค่า max rank ไว้ insert ตอนท้าย และก่อน insert ต้อง update text_status = del ที่ /FORM ให้ไม่ใช้งานก่อน
																													
																													$sql_max = " SELECT  MAX(text_rank)  AS max_rank  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '".$main_db."' ";
																													
																													$exec_max = $db2->query($sql_max);
																													$rec_max = $db2->fetch_array($exec_max);
																													
																													if($rec_max[max_rank] > 0) {
																													
																													$next_rank = $rec_max[max_rank]+1;
																											
																											$UPDATE = " UPDATE  web_tag  SET   text_status = 'del'  WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_tag = '/$tag_name'   ";
																		
																											$pass3 = $db2->query($UPDATE);
																						
																											$INSERT = " INSERT  INTO  web_tag  (filename, db_name, text_tag, text_rank )  VALUES ('$filecheck',  '".$main_db."',  '/$tag_name' , '$next_rank' )  ";
																											$pass4 = $db2->query($INSERT);
																																																						
																															
																													} // end $rec_max
																													
																											} // end if num_form ==1 จึงจะ แก้ไข <form> ได้ทันที
																											
																											if($pass1 && $pass2 && $pass3 && $pass4) {
																													$result = 1;
																											}
																									}
																									
																									$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_id = '$text_id1'  ";
																									
																									$exec_newrank  = $db2->query($sql_newrank);
																									$rec_newrank = $db2->fetch_array($exec_newrank);
																									
																								?><td align="center"> &nbsp;<? show_icon_pass($result); ?></td>
																								<td align="center"><? echo $rec_newrank[text_rank];?> </td><?
																									if($result) {
																											$total_err--;
																									}
																							  } // end run_edit  ?>
																					</tr>
																					<?																									  
																		  }
																  } // end if(strtoupper($prev_tag) != "TD")
														  
														  } // end  if(strtoupper($rec_tag[tag_grand]) != "TABLE") 
														  														  
														/*  if($rec_tag[tag_grand] && strtoupper($rec_tag[tag_grand]) != "BODY" && strtoupper($rec_tag[tag_grand]) != "HTML" && strtoupper($rec_tag[tag_grand]) != "HEAD" &&  strtoupper($rec_tag[tag_grand]) != "!DOCTYPE" )  */
														if(strtoupper($rec_tag[tag_grand]) == 'TABLE' || strtoupper($rec_tag[tag_grand]) == 'OBJECT' )
														{ // check การเรียง tag ภายใน เฉพาะ tag แม่ ที่เป็น table หรือ object
														  			
																   $sql_chk2 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND text_tag = '".$rec_tag[tag_grand]."'  AND  text_rank$offset_rank < '$text_rank1'  AND  ( text_status <> 'del'  OR text_status is null ) ORDER BY text_rank, text_id LIMIT 0,1 ";
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
																				<td align="center"><?=$text_rank1;?></td>
																				<td>tag <strong><?=strtoupper($tag_name);?></strong> ต้องอยู่ภายใน tag <strong><?=strtoupper($rec_tag[tag_grand]);?> </strong></td>
																		
																			<? if($_POST["run_edit"]) { 
																			
																						$result = 0;
																				
																						if($pass1) {
																						
																						$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_id = '$text_id1'  ";
																											
																						$exec_newrank  = $db2->query($sql_newrank);
																						$rec_newrank = $db2->fetch_array($exec_newrank);
																						
																						} else {
																						
																								$rec_newrank[text_rank] = "&nbsp;";
																						}
																						
																						
																						?><td align="center"> &nbsp;<? show_icon_pass($result); ?></td>
																							<td align="center"><?=$rec_newrank[text_rank];?></td><?
																						
																						if($result) {
																							$total_err--;
																						}
																				  } ?>
																		</tr>
																		<?																														  
																  }				
																  
																  ////////// ส่วนใหญ่แล้ว code ล่างนี้ไว้ ตรวจสอบลูกของ table
																  $sql_chk3 = " SELECT  text_id, text_tag  FROM  web_tag  WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_rank$offset_rank < '$text_rank1' AND  text_tag IS NOT NULL  AND text_tag <> ''  AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_rank DESC, text_id DESC  LIMIT 0,1  ";    // หา tag ก่อนหน้านี้  1 tag																  
																 
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
																					<td align="center"><?=$text_rank1;?></td>
																					<td>tag <strong><?=strtoupper($tag_name);?></strong> ต้องไม่อยู่ต่อจาก tag <strong><?=strtoupper($prev_tag);?> </strong></td>
																			
																				<? if($_POST["run_edit"]) { 
																						
																							$result = 0;
																							
																							if($pass1) {
																							
																							$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_id = '$text_id1'  ";
																												
																							$exec_newrank  = $db2->query($sql_newrank);
																							$rec_newrank = $db2->fetch_array($exec_newrank);
																							
																							} else {
																							
																									$rec_newrank[text_rank] = "&nbsp;";
																							}
																							
																							
																							?><td align="center"> &nbsp;<? show_icon_pass($result); ?></td>
																								<td align="center"><?=$rec_newrank[text_rank];?></td><?
																								if($result) {
																										$total_err--;
																								}																				
																					} ?>
																			</tr>
																			<?																														
																 }  
														  }	 // end if($rec_tag[tag_grand] && strtoupper($rec_tag[tag_grand]) != "BODY" && strtoupper($rec_tag[tag_grand]) != "HTML" && strtoupper($rec_tag[tag_grand]) != "HEAD" )													  														 														  
												 } // end  check  tag เปิด
												
												
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
																		 
																		 if(strtolower($attribute_name)!="id" && strtolower($attribute_name)!="name" && strtolower($attribute_name)!="class" && strtolower($attribute_name)!="style" ) {
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
																											<td align="center"><?=$text_rank1;?></td>
																											<td>tag <strong><?=strtoupper($tag_name);?></strong> มีค่า attribute  <strong><?=strtolower($attribute_name);?> </strong> <span style="color:red"> เป็น <strong><?=strtolower($attribute_value);?> </strong> ไม่ได้ </span></td>
																									
																										<? if($_POST["run_edit"]) { 
																												
																													$result = 0;	
																													
																													$sqlEdit = " SELECT  *  FROM  value_edit_attr_tag  WHERE  tag_name = '$tag_name'  AND attribute_name = '$attribute_name'  AND  wrong_value = '$attribute_value'   ORDER BY  tag_name, attribute_name ";
									
																													$execEdit = $db2->query($sqlEdit);				
																													$recEdit  = $db2->fetch_array($execEdit);																																																																																																																											
																													
																													?><td align="center"> &nbsp;<? 
																													if($recEdit[correct_value] == "*M*" ) {																											
																															//echo "ต้องแก้โดย Editor";
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
																													show_icon_pass($result); 
																													?></td>
																														<td align="center"  >
																														<? if($pass1) {
																									
																															$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_id = '$text_id1'  ";
																																				
																															$exec_newrank  = $db2->query($sql_newrank);
																															$rec_newrank = $db2->fetch_array($exec_newrank);
																															
																															} else {
																															
																																	$rec_newrank[text_rank] = "&nbsp;";
																															} ?>          
																														<? echo $rec_newrank[text_rank];?></td><?	
																														
																														if($result) {
																																$total_err--;
																														}																			
																											} ?>
																									</tr>
																									<?		
																						}
																				  } // end if($num_attr_chk)
																				  else {
																							// ถ้า tag ปัจจุบัน มี attribute นี้ไม่ได้
																							
																							$invalid=true;  
																							$total_err++;
																									?>
																									<tr>
																											<td align="center"><?=$text_rank1;?></td>
																											<td>tag <strong><?=strtoupper($tag_name);?></strong> <span style="color:red">ไม่มีค่า attribute ชื่อ <strong><?=strtolower($attribute_name);?> </strong></span></td>
																									
																										<? if($_POST["run_edit"]) { 
																												
																													$result = 0;	
																													
																													$sqlEdit = " SELECT  *  FROM  value_edit_attr_tag  WHERE  tag_name = '$tag_name'  AND  wrong_attribute = '$attribute_name'   ORDER BY  tag_name, attribute_name ";
									
																													$execEdit = $db2->query($sqlEdit);				
																													$recEdit  = $db2->fetch_array($execEdit);																																																																																																																											
																													
																													?><td align="center"> &nbsp;<? 
																													 if($recEdit[correct_value] == "*background*" ) {																																																									
																														
																														 $edit_attr_name = "style";
																														 
																														 $edit_value = "background:url($attribute_value)";
																		
																														if(!eregi("^".$charac2, $edit_value)) {
																																$edit_value = $charac2.$edit_value;
																														}
																														if(!eregi($charac2."$", $edit_value)) {
																																$edit_value = $edit_value.$charac2;
																														}
																																														
																														$UPDATE = " UPDATE web_attr SET  text_attr_name = '$edit_attr_name' ,  text_edit_value = '".$edit_value."'  WHERE  text_attr_id = '".$rec_attr_data[text_attr_id]."' ";
																														 $result = $db2->query($UPDATE);	
																															
																														  //show_icon_pass($result); 
																													} // end แก้ "*background*" 
																													else if($recEdit[correct_value] == "*del*" ) {			
																														// ถ้า วิธีแก้ เป็น *del* ให้เคลียร์ค่า attribute นั้นไปเลย
																														$UPDATE = " UPDATE web_attr SET  text_attr_name = '' ,  text_attr_value = '', text_edit_value = ''  WHERE  text_attr_id = '".$rec_attr_data[text_attr_id]."' ";
																														 $result = $db2->query($UPDATE);	
																															
																														  //show_icon_pass($result); 
																													} // end แก้ "*del*" 
																													//else {
																														//	echo "ต้องแก้โดย Editor";
																													//}
																													
																													show_icon_pass($result); 
																													?></td>
																														<td align="center"  >
																														<? if($pass1) {
																									
																															$sql_newrank = " SELECT  text_rank  FROM  web_tag WHERE   filename = '$filecheck' AND db_name = '".$main_db."'  AND  text_id = '$text_id1'  ";
																																				
																															$exec_newrank  = $db2->query($sql_newrank);
																															$rec_newrank = $db2->fetch_array($exec_newrank);
																															
																															} else {
																															
																																	$rec_newrank[text_rank] = "&nbsp;";
																															} ?>          
																														<? echo $rec_newrank[text_rank];?></td><?																																
																														if($result) {
																																$total_err--;
																														}																		
																											} ?>
																									</tr>
																									<?		
																				  
																				  }
																	 	 } // end strtolower($attribute_name)!="id" && strtolower($attribute_name)!="name" && strtolower($attribute_name)!="class" และ "style"
																} // end while
															 
														  } // end if($num_attr_data) 
												 } // end if($num_tag_chk) 
												 
										} // end while $rec_arrange
								} //  end if $total_tag
								?>
							</table>
							<br>							
							<?
									///////  check ว่า tag ที่ไม่ใช่ tag ลูกของ Body เช่น  META หรือ TITLE  มีปรากฏอยู่ใน BODY web_tag มั้ย
										
									$sqlNotBody 	= " SELECT  tag_id, tag_name FROM  tag_info  WHERE tag_grand IN ('html', 'head', '!doctype') OR ( tag_name = 'marquee' OR tag_name = 'embed' ) ORDER BY tag_id ";  // OR tag_name = 'object' OR tag_name = 'param'
									
									$execNotBody = $db2->query($sqlNotBody);	
									while($recNotBody = $db2->fetch_array($execNotBody)) {
											$tag_name = $recNotBody[tag_name];
											
											$sqlChkMeta = " SELECT  text_id, text_tag, text_value, text_attr, text_rank  FROM  web_tag  WHERE  filename = '$filecheck' AND db_name = '".$main_db."' AND ( text_tag  = '$tag_name' ) AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY text_id ";
											
											//echo "$sqlChkMeta<br>";							
											$execChkMeta = $db2->query($sqlChkMeta);														
											$numChkMeta = $db2->num_rows($execChkMeta);
											
											if($numChkMeta) {
													$invalid=true;
													$total_err+=$numChkMeta;													;
													
													$j = 0;
													?>
													<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse"><caption align="left"><strong><?=strtoupper($tag_name);?></strong> ต้องไม่อยู่ใน BODY ของ WEB<br></caption>
															<tr>
															<td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>															
															<td width="700"><strong>รายการ / คำอธิบาย</strong></td>										
																	<? if($_POST["run_edit"]) { ?>
																	<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
																	<? } ?>
															</tr>
													<?
													while($recChkMeta = $db2->fetch_array($execChkMeta)) {
															$result = 0;
															
															?><tr>
																<td align="center"><? echo $recChkMeta[text_rank]; ?></td>
																<td><? echo "&bull; &lt;".$recChkMeta[text_tag]." ".$recChkMeta[text_attr]."&gt; <br>"; ?></td><?											
																
																if($_POST["run_edit"]) {  
																// แก้ไข tag ที่ไม่ควรมีใน body ด้วยการ เคลียร์ ค่า tag และ attrbute เก็บไว้ใน field แก้  แล้ว ใส่ text_status = del
																		
																		$UPDATE = " UPDATE  web_tag  SET  text_edit_tag = '', text_edit_attr = '', text_status = 'del'  WHERE text_id = '".$recChkMeta[text_id]."'  ";
																		
																		$result = $db2->query($UPDATE);
																		
																		?> <td align="center"><? show_icon_pass($result); ?></td><?				
																		
																		if($result) {
																				$total_err--;
																		}								
																}
															
															?></tr><?
													}
													
													if($_POST["run_edit"]) {  
																// แก้ไข tag ปิด ที่ไม่ควรมีใน body ด้วยการ เคลียร์ ค่า tag และ attrbute เก็บไว้ใน field แก้  แล้ว ใส่ text_status = del
														
																$UPDATE = " UPDATE  web_tag  SET  text_edit_tag = '', text_edit_attr = '', text_status = 'del'  WHERE  filename = '$filecheck' AND db_name = '".$main_db."' AND ( text_tag  = '/$tag_name' ) ";
																
																$db2->query($UPDATE);																																														
													}
													?>
														</table>								
													<?
											
											}
										
									}
								
								?><br><?
				
									$sqlChkQoute = " SELECT  web_tag.text_id, text_tag, web_tag.text_rank, web_attr.* 
									FROM web_tag INNER JOIN web_attr 
										ON  web_tag.text_id = web_attr.text_id 
									 WHERE  filename = '$filecheck' AND db_name = '".$main_db."'  AND ( text_edit_value LIKE '#%' OR ( ( text_edit_value IS NULL OR  text_edit_value = '') AND text_attr_value  LIKE '#%' ) )  AND  ( text_status <> 'del'  OR text_status is null )  ORDER BY web_tag.text_rank, web_tag.text_id ";
									//echo "$sqlChkQoute<br>";	
									// AND ( text_edit_value = '$charac2' OR text_attr_value = '$charac2' OR text_edit_value = '$charac1' OR text_attr_value = '$charac1' OR ( text_edit_value IS NOT NULL AND text_edit_value <> '' AND ( ( text_edit_value NOT LIKE '".$charac2."%' ) AND ( text_edit_value NOT LIKE '".$charac1."%' ) ) ) OR ( ( text_edit_value IS NULL OR  text_edit_value = '') AND ( text_attr_value NOT LIKE '".$charac2."%') AND ( text_attr_value NOT LIKE '".$charac1."%') ) ) 
									// AND ( text_edit_value LIKE '#%' OR ( ( text_edit_value IS NULL OR  text_edit_value = '') AND text_attr_value  LIKE '#%' ) )  AND  ( text_status <> 'del'  OR text_status is null )  						
									$execChkQoute = $db2->query($sqlChkQoute);														
									$numChkQoute = $db2->num_rows($execChkQoute);
									$ic=0;																		
						if($numChkQoute) {
									$invalid = true;	
									$total_err+=$numChkQoute;									
													?>
									<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse"><caption align="left"><!--an attribute value must be a literal unless it contains only name characters.-->พบปัญหาไวยากรณ์ ค่า attribute ที่มีอักขระพิเศษนำหน้าต้องคลุมด้วยเครื่องหมาย " ( double qoute ) <br></caption>
										<tr>
											 <td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>					
											 <td width="100"><strong>ชื่อ Tag</strong></td><td width="600"><strong>รายการ / คำอธิบาย</strong></td>
										<? if($_POST["run_edit"]) { ?>
											<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
										<? } ?></tr>
									<?										
									
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
														<td align="center"><? echo $recChkQoute[text_rank]; ?></td>
														<td>	<? echo "&bull; ".$recChkQoute[text_tag]; ?></td><td>	<? echo " $alert_attr"; ?></td>
													<? if($_POST["run_edit"]) {
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
																
																?><td align="center"> <? show_icon_pass($result); ?></td>
													<?					if($result) {
																				$total_err--;
																		}	
															}	
											  ?></tr>	<?																																														
											//print_r($arr_temp_attr);
											//echo "<br><br>";											
									} // end while $recChkQoute
								
								?><table><br><?
						}												
																										
							?>
							
							<table  border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="3" style="border-collapse:collapse">
							<tr> <td width="100" align="center"><strong>ตำแหน่ง Tag ที่</strong></td>
									<td width="700"><strong>รายการ / คำอธิบาย</strong></td>
									<? if($_POST["run_edit"]) { ?>
										<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
									<? } ?></tr>
							<?
							$sqlAttr1 = " SELECT  *  FROM  value_edit_attr_tag  WHERE ( attribute_name IS NOT NULL AND attribute_name <> '') AND ( wrong_value IS NULL  OR  wrong_value = '' ) AND ( correct_value IS NOT NULL AND correct_value <> '' AND correct_value <> '*del*' AND correct_value <> '*M*')  ORDER BY  tag_name, attribute_name ";
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
																		filename = '$filecheck' AND db_name = '".$main_db."'  AND
																		 text_tag = '$tag_name'  AND  ( text_status <> 'del'  OR text_status is null )
																	ORDER BY  text_rank, text_id";
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
												
												$numChkAttr1 = $db2->num_rows($execChkAttr1); 
												// จำนวน tag ที่มี $attribute_name
												
												
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
												
												$execChkAttr2 = $db2->query($sqlChkAttr2);		
												
												$numChkAttr2 = $db2->num_rows($execChkAttr2);
												
												if($numChkAttr1==0 || $numChkAttr2 > 0) {																																																					
														
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
																			//$src_preview= "http://www.google.co.th";
																			
																			
																			$show_pic = "<img src='$src_preview' border='0' > ";
																			
						
											 				?><tr>
															<td  align="center"><?=$rec_webtag[text_rank];?> </td>
															<td><?=strtoupper($rec_webtag[tag_name]);?> <?=$recommend;?><br><? if(strtoupper($tag_name)=="IMG" ) { echo $show_pic; } ?></td>
											 				<? if($_POST["run_edit"]) {
																																																																																																																																											
																		
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
																		
																		?><td align="center"> <? show_icon_pass($result); ?></td><?
																		
																		if($result) {
																				$total_err--;
																		}	
																}
																
																?></tr><?														 																		
																
														// }  // end ถ้าเป็น IMG เท่านั้น จึงจะ error
														 
														//} // end while																										
												
												} // if($numChkAttr1==0 || $numChkAttr2 > 0)
									} // while  $rec_webtag
					
					} // while $recAttr1
									
				  ?></table><br>
				  
				  
				  <?
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
														WHERE filename = '$filecheck' AND db_name = '".$main_db."' AND  ( text_status <> 'del'  OR text_status is null )  AND
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
											<? if($_POST["run_edit"]) { ?>
												<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
											<? } ?></tr>									
									<?
										while($recChkColor  = $db2->fetch_array($execChkColor)) {
											 		$result = 0;
													
													$text_id = $recChkColor[text_id];	
													$attribute_name = $recChkColor[text_attr_name];			
													
													$field_attr = ($recChkColor[text_edit_value])? $recChkColor[text_edit_value]:$recChkColor[text_attr_value];
													$alert_attr = $attribute_name."=".$field_attr;									 	
													?>							
													<tr>
														<td  align="center"><?=$recChkColor[text_rank];?> </td>
														<td width="700">&bull; <? echo $alert_attr; // $recChkColor[text_attr];?>
														<?
															if($_POST["run_edit"]) {  // ส่วนแก้ สีอักษร ให้เป็นดำ
																
																 $UPDATE = " UPDATE web_attr SET  text_edit_value = '".$charac2."#000000".$charac2."'  WHERE text_attr_name = '$attribute_name' AND text_id = '$text_id'   ";
																 $result = $db2->query($UPDATE);								
																 
																 ?><td width="150" align="center" > <? show_icon_pass($result); ?></td><?
																 
																 		if($result) {
																				$total_warn--;
																		}	
															} // end if run edit
														?></td>
													</tr>							
													<?
												
										 } // end while $recChkColor
							 ?></table><?
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
														WHERE filename = '$filecheck' AND db_name = '".$main_db."' AND  ( text_status <> 'del'  OR text_status is null ) AND
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
											<? if($_POST["run_edit"]) { ?>
												<td width="150" align="center"><strong>สถานะการแก้ไข</strong></td>
											<? } ?></tr>
									<?
										while($recChkColor  = $db2->fetch_array($execChkColor)) {
											 		$result = 0;
													
													$text_id = $recChkColor[text_id];	
													$attribute_name = $recChkColor[text_attr_name];			
													
													$field_attr = ($recChkColor[text_edit_value])? $recChkColor[text_edit_value]:$recChkColor[text_attr_value];
													$alert_attr = $attribute_name."=".$field_attr;								 	
													?>							
													<tr>
														<td  align="center"><? echo $recChkColor[text_rank];?>  </td>
														<td width="700">&bull; <? echo $alert_attr; //$recChkColor[text_attr];?>
														<?
															if($_POST["run_edit"]) {  // ส่วนแก้ สีอักษร ให้เป็นดำ
																
																 $UPDATE = " UPDATE web_attr SET  text_edit_value = '".$charac2."#FFFFFF".$charac2."'  WHERE text_attr_name = '$attribute_name' AND text_id = '$text_id'   ";
																 $result = $db2->query($UPDATE);								
																 
																 ?><td width="150" align="center" > <? show_icon_pass($result); ?></td><?
																 
																		if($result) {
																				$total_warn--;
																		}	
															} // end if run edit
														?></td>
													</tr>							
													<?
												
										 } // end while $recChkColor
							 ?></table><?
						}  // end if $numChkColor												
																												
						
						if($_POST["run_edit"]  ||  $total_err == 0 ) { // แก้ไขเสร็จ ก็รวม tag กลับเป็นหน้าเว็บเพจ w3c
								/////////////////  ส่วนแก้ path รูปที่ไม่ได้ ขึ้นต้นด้วย path internet								
								// และ  แก้ path Link  href ด้วย
								
									$sql_edit_path = " SELECT web_tag.text_id, text_attr_name, REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS   text_attr_value1 FROM web_attr  INNER JOIN web_tag ON  web_attr.text_id = web_tag.text_id WHERE filename = '$filecheck' AND db_name = '".$main_db."' AND web_attr.text_attr_name IN ('src', 'href') AND ( REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT LIKE 'http:%' AND REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  NOT LIKE 'www.%' )  OR ( ( REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') LIKE '%www.mwa.co.th%' OR REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') LIKE 'localhost/%' )  AND REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT LIKE '%/w3c%' )  ORDER BY text_rank, web_tag.text_id   ";										
									$exec_edit_path = $db2->query($sql_edit_path);		
									// echo "$sql_edit_path<br>";
									while($rec_edit_path = $db2->fetch_array($exec_edit_path))	{
											$arr_path = array();
											$arr_path = explode("/",$rec_edit_path[text_attr_value1],2);
											
											 // $rec_edit_path[text_attr_name] ในที่นี้ คือ src, href
											
											//print_r($arr_path);
											//echo "<br>";
											if($rec_edit_path[text_attr_name]=='href') {
														$linkfile = strrchr($rec_edit_path[text_attr_value1], "/");
														$linkfile = str_replace("/","",$linkfile);
																												
														$edit_value = $charac2.$linkfile.$charac2;
														$UPDATE = " UPDATE web_attr SET  text_edit_value = '$edit_value' WHERE text_attr_name = '".$rec_edit_path[text_attr_name]."' AND text_id = '".$rec_edit_path[text_id]."'   ";
														 //echo "$UPDATE<br>";
														 $db2->query($UPDATE);
											} else {
													if( $arr_path[0] && (substr_count($arr_path[0], '.') < 3) ) { 
															//  ถ้าค่าของ $arr_path[0]  มี . น้อยกว่า 3 อัน แปลว่าไม่ใช่ขึ้นต้นด้วย IP  แล้วจึงจะแก้ path โดยเติม ../
															// !eregi("^[0-9]", $arr_path[0])
															
														$edit_value = $charac2."../".$rec_edit_path[text_attr_value1].$charac2;
														$UPDATE = " UPDATE web_attr SET  text_edit_value = '$edit_value' WHERE text_attr_name = '".$rec_edit_path[text_attr_name]."' AND text_id = '".$rec_edit_path[text_id]."'   ";
														 //echo "$UPDATE<br>";
														 $db2->query($UPDATE);	
													}
											}
									}
									
									// แก้ path ของ <param name="movie" value="images/flash/xxxxx.swf">
									$sql_movie = " SELECT web_tag.text_id, text_attr_name, REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS   text_attr_value1 FROM web_attr  INNER JOIN web_tag ON  web_attr.text_id = web_tag.text_id WHERE filename = '$filecheck' AND db_name = '".$main_db."' AND web_tag.text_tag = 'param' AND  web_attr.text_attr_name = 'name' AND  web_attr.text_attr_value = 'movie'  ORDER BY text_rank, web_tag.text_id   ";										
									$exec_movie = $db2->query($sql_movie);		
									// echo "<br>$sql_movie<br>";
									while($rec_movie = $db2->fetch_array($exec_movie))	{
											
											$sql_edit_path = " SELECT web_tag.text_id, text_attr_name, REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS   text_attr_value1
												 FROM web_attr  WHERE  filename = '$filecheck' AND db_name = '".$main_db."' AND web_tag.text_id = '".$rec_movie[text_id]."' AND  web_attr.text_attr_name = 'value' AND 
												 ( REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT LIKE 'http:%' AND REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  NOT LIKE 'www.%' )  OR ( ( REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') LIKE '%www.mwa.co.th%' OR REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') LIKE 'localhost/%' )  AND REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '') NOT LIKE '%/w3c%' )  
												 ORDER BY text_rank, web_tag.text_id   ";										
											$exec_edit_path = $db2->query($sql_edit_path);	
											//echo "<br>$sql_edit_path<br>";
											$arr_path = array();
											
											if($rec_edit_path[text_attr_name]=='value') {
											
													
													$arr_path = explode("/",$rec_edit_path[text_attr_value1],2);
																
													if( $arr_path[0] && (substr_count($arr_path[0], '.') < 3) ) { 
															//  ถ้าค่าของ $arr_path[0]  มี . น้อยกว่า 3 อัน แปลว่าไม่ใช่ขึ้นต้นด้วย IP  แล้วจึงจะแก้ path โดยเติม ../
															// !eregi("^[0-9]", $arr_path[0])
															
														$edit_value = $charac2."../".$rec_edit_path[text_attr_value1].$charac2;
														$UPDATE = " UPDATE web_attr SET  text_edit_value = '$edit_value' WHERE text_attr_name = 'value' AND text_id = '".$rec_movie[text_id]."'   ";
														 //echo "$UPDATE<br>";
														 $db2->query($UPDATE);	
													}
											}
									}
									
									// แก้ path ที่อยู่ใน style 
									$sql_edit_path = " SELECT web_tag.text_id, text_attr_name, REPLACE( REPLACE(`web_attr`.`text_attr_value`, '$charac2', ''), '$charac1', '')  AS   text_attr_value1, REPLACE( REPLACE(`web_attr`.`text_edit_value`, '$charac2', ''), '$charac1', '')  AS   text_edit_value1 FROM web_attr  INNER JOIN web_tag ON  web_attr.text_id = web_tag.text_id WHERE filename = '$filecheck' AND db_name = '".$main_db."' AND web_attr.text_attr_name = 'style' AND text_edit_value LIKE '%url(%' ORDER BY text_rank, web_tag.text_id   ";										
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
										
											
												$arr_tail = split(")", $str_temp,2);
												
												// &&  !eregi("^[0-9]", $arr_tail[0]) 
												if( $arr_tail[0]  && ((substr_count($arr_tail[0], '.') < 3) && ( !eregi("^http:", $arr_tail[0]) ) && !eregi("^www.", $arr_tail[0])) || (eregi("www.mwa.co.th", $arr_tail[0]) &&  !eregi("/w3c", $arr_tail[0]) )  ) {
												    //  ถ้าค่าของ $arr_tail[0]  มี . น้อยกว่า 3 อัน แปลว่าไม่ใช่ขึ้นต้นด้วย IP  แล้วจึงจะแก้ path โดยเติม ../
													
													$edit_value = $charac2.$arr_path[0].":url(../".$arr_tail[0].")".$arr_tail[1].$charac2;
													
													$UPDATE = " UPDATE web_attr SET  text_edit_value = '$edit_value' WHERE text_attr_name = 'style' AND text_id = '".$rec_edit_path[text_id]."'   ";
													//echo "$UPDATE<br>";
													$db2->query($UPDATE);	
												}
									 	} // end if($arr_path[1]) 
									} // แก้ path รูป ใน style
																	
						
								$sql_w3c = " SELECT  *  FROM  web_tag  WHERE filename = '$filecheck' AND db_name = '".$main_db."' 
														ORDER BY text_rank, text_id ";
								$exec_w3c = $db2->query($sql_w3c);
								$new_contents = "";
								while($rec_w3c=$db2->fetch_array($exec_w3c)) {
								
										if($rec_w3c[text_status] == 'del') {																															
												$new_contents .= $rec_w3c[text_value];												
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
																		if(trim($rec_atb[text_attr_name])) {
																			$text_up_attr .= $rec_atb[text_attr_name]."=".$edit_attr." ";
																		}
																}
												
																$new_contents.="<".convert_specials_char($rec_w3c[text_tag])." ".convert_specials_char($text_up_attr).">".$rec_w3c[text_value];
															} else { // ถ้าเป็น tag ปิด
																$new_contents.="<".convert_specials_char($rec_w3c[text_tag]).">".$rec_w3c[text_value];
															}			
												} else {  // แม้ ไม่มี tag อะไร ก็ต้องเก็บเนื้อหาเว็บด้วย
														$new_contents .= $rec_w3c[text_value];
												}				
										
										}	// end ถ้าไม่มี สถานะ ลบ del						
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
								$new_contents = ereg_replace("&amp;",'&',$new_contents);
								
								testvar_infile($templete_checked_top.$new_contents.$templete_checked_bottom, $dir1.$filecheck, 'w'); // เขียน tag เป็นไฟล์ html ที่ convert เบื้องต้นแล้ว ใส่ checked folder
							
						}
				//echo "run edit ".$_POST["run_edit"]."<br>";
				
				echo "<br>จำนวนความผิดพลาด : <span style='color:red'>".number_format($total_err)."</span> <br>";
				echo "จำนวนการเตือน (แต่ไม่ผิด) : ".number_format($total_warn)." <br><br>";		
						
				if($total_err==0 && $_POST["run_edit"] ) {
						$last_status = "w3c";
						$label_status = "<span style=\"color:green\"><strong>หน้านี้ได้รับการแปลงให้ได้มาตรฐาน W3C เรียบร้อยแล้ว</strong></span>";
				} else if($total_err > 0 && $_POST["run_edit"] ) {
						$last_status = "chk";
						$label_status = "<span style=\"color:green\"><strong>หน้านี้ได้รับการแปลงให้ได้มาตรฐาน W3C ในเบื้องต้นแล้ว.</strong></span><br><br>ท่านสามารถใช้ Editor ในการทำให้หน้าเว็บ W3C สมบูรณ์ยิ่งขึ้น"; 
				} 
				
				if($total_err==0 && !$_POST["run_edit"] ) {
						$last_status = "w3c";
						$label_status = "<span style=\"color:green\"><strong>ไม่พบความผิดพลาด ตามมาตรฐาน W3C ระดับ A</strong></span>";
				} 
				
								
				?><H2 style="background-color:#F3F3F3"><? echo $label_status; ?></H2>
				<script language="javascript">
					//opener.location.reload();
				</script>
				<?								
				
				$UPDATE = " UPDATE webpage_info SET  w3c_status = '$last_status', modify_time  = NOW() WHERE  filename = '$filecheck' AND db_name = '".$main_db."'  ";
				$db2->query($UPDATE);
					
					if(!$_POST["run_edit"]) { //  ถ้ายังไม่กดปุ่ม Convert
												
						if( $total_err > 0 ) {	 // $invalid==true
							 // Convert to W3C page
							?><br>
							<input name="bt_edit" type="button" value=" แปลงหน้าเว็บเบื้องต้น " onClick="return chkInput()">
							<?
						} 
					} // end !$_POST["run_edit"] // ถ้ายังไม่กดปุ่ม Convert
			} // end if($filename || $filecheck )  // ถ้ามีชื่อหน้าเว็บ จึงจะทำการ validate ได้	
			else {
					echo "<br>ไม่พบไฟล์หน้าเว็บ ชื่อ <span style='color:red'>".$_POST["url_check"]."</span>";
			}					
			
			/*			
								$arr_file_name = explode("/",$_POST["url_check"]);					
								$num_elements = count($arr_file_name);
								$filename = $arr_file_name[$num_elements-1];	
								$new_path = "checked/".$filename;
																
								 testvar_infile($newcode, $new_path, "w");						
								 // function นี้ ไว้เขียนไฟล์ ใหม่ ก็ได้ หรือ ทดสอบตัวแปร ใน ไฟล์ที่เขียน ก็ได้
						 */
	mysql_close();	
} // end if($_POST["validate"] )  ถ้ากดปุ่ม Import Validate จึงจะทำงาน
//mysql_close();			?>
<input name="filecheck" type="hidden" value="<?=$filecheck;?>"><input name="run_edit" type="hidden"></form>
</body>
</html>
