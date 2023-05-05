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
<title><?php echo $proj_title;?> - W3C Editor</title>
<script type="text/javascript" language="javascript1.2" src="js/AjaxRequest.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/functions.js"></script>
<script type="text/javascript" language="javascript1.2">
function chkInput() {	
	
	if(confirm('ยืนยันการบันทึกหรือไม่')) {
		frm.accept.value = 'save';
		frm.submit();
	}
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
    <script type="text/javascript"> 
       var move = false; 
      function createTextAreaWithLines(id) 
      { 
        var el = document.createElement('TEXTAREA'); 
        var ta = document.getElementById(id); 
        
        var string = ''; 
        for(var no=1;no<300;no++){ 
          if(string.length>0)string += '\n'; 
          string += no; 
        } 
        
        el.className      = 'textAreaWithLines'; 
        el.style.height   = (ta.offsetHeight-3) + "px"; 
        el.style.width    = "25px"; 
        el.style.position = "absolute"; 
        el.style.overflow = 'hidden'; 
        el.style.textAlign = 'right'; 
        el.style.paddingRight = '0.2em'; 
        el.innerHTML      = string;  //Firefox renders \n linebreak 
        el.innerText      = string; //IE6 renders \n line break 
        el.style.zIndex   = 0; 
        ta.style.zIndex   = 1; 
        ta.style.position = "relative"; 
        ta.parentNode.insertBefore(el, ta.nextSibling); 
        setLine(); 
        ta.focus(); 
        
        ta.onkeydown    = function() { setLine(); } 
        ta.onmousedown  = function() { setLine(); move=true; } 
        ta.onmouseup    = function() { setLine(); move=false; } 
        ta.onmousemove  = function() { if(move){setLine();} } 
		ta.onscroll = function() { setLine(); }
              
        function setLine(){ 
          el.scrollTop   = ta.scrollTop; 
          el.style.top   = (ta.offsetTop) + "px"; 
          el.style.left  = (ta.offsetLeft - 27) + "px"; 
        } 
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
$filepathname = $UserPath."w3c\\checked\\".$filecheck.".php";

if(eregi("_bkup",$filecheck)) {
		$file_recover = $filecheck;
		
		$arr_temp = split("_bkup",$filecheck,2);
		$filecheck = $arr_temp[0];
} 

$sql_info = " SELECT  cms_description, w3c_html, mode_edit FROM  webpage_info  WHERE filename = '$filecheck' AND db_name = '".$main_db."'   ";
												
		$exec_info = $db2->query($sql_info);
		$rec_info = $db2->fetch_array($exec_info);
										
		$w3c_description = $rec_info["cms_description"]; 
		
	
	if($_POST["accept"]) {
					
											
						$phpcontents = stripslashes($_POST["htmlcode"]);
							//  บันทึกส่วน div content ที่แก้ไข ทับไฟล์ เดิม
						//testvar_infile($templete_checked_top.$htmlcode.$templete_checked_bottom, $filepathname, 'w'); 
						//echo "$htmlcode<br>";
						//exit;
						
					//////////////////   ส่วน encode & เฉพาะใน attribute ที่เป็น url /////////////////////////
					$edited_phpcontents="";
					$htmlcode = trim($phpcontents);
				//echo $htmlcode;
				//echo "<br>";
				
					$htmlcode = eregi_replace("/>",">",$htmlcode); // แก้ /> ไปก่อนเลย
					
					//$htmlcode = eregi_replace("<!--","<!--  ",$htmlcode); // แก้ <!-- ไปก่อนเลย
					
					$arr_tag = array();
					$attribute_pack = array();
					$text_value = array();
					
					$arr_words = array();								
					$arr_words = explode("<",$htmlcode);
					$text_js = "";
					$text_css = "";	
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
											
										
											if( $cnt_sqoute == 0 && $word1[$pos]=='"' ) { // ถ้า เจอ " โดยไม่มี ' มาก่อน  ( ใช้ &quot; ไม่ได้ เพราะ เราตรวจทีละตัวอักษร )
												$cnt_qoute++; // นับจำนวน "												
												
											} else if( $cnt_qoute == 0 && $word1[$pos]=="'") { 
													// ถ้าไม่เจอ " จึงจะ check ถ้า เจอ ' โดยไม่มี " มาก่อน ( ใช้ &#039; ไม่ได้ เพราะ เราตรวจทีละตัวอักษร ) 
												$cnt_sqoute++; // นับจำนวน '
											
											}
											
											$arr_temp_attr[$attr_no] .= $word1[$pos];
											
											if($pos>0) {
																																			
												if( ( $cnt_qoute==0 && $word1[$pos]==" " ) || $cnt_qoute==2  ) {
												
													$attr_no++;
													$cnt_qoute = 0;
													$cnt_sqoute = 0;
													
												
												} else if( $cnt_sqoute==2  ) {
													 //  หรือ ถ้าเจอ ' 2 ตัวแล้ว แสดงว่าจบ attribute 1 อย่าง
												
													$attr_no++;
													$cnt_qoute = 0;
													$cnt_sqoute = 0;
													
												}
											}
											
									} // end for pos
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
						
							if( strlen($arr_tag[$i]) <= 50 && trim($arr_tag[$i]) != "!doctype" ) { // เอาเฉพาะ ชื่อ tag จริงๆ มันต้องมี เว้นวรรค แล้วความยาวชื่อไม่เกิน 50 และไม่เอา DOCTYPE 
									
									if($in_script1==false && $in_script2==false ) { // ถ้า code แต่ละ record ที่ผ่านมาไม่ใช่  code ในช่วงของ tag script จึงจะ insert
																			
										
										for($ci=0;$ci<count($arr_temp_attr);$ci++) {  // เก็บ Attribute ลง ตาราง web_attr
											$piece_attr[$ci] = array();
											$piece_attr[$ci] = explode("=",$arr_temp_attr[$ci],2);
											
											if(trim($piece_attr[$ci][0])) {  // ถ้า attribute_name มีค่า 
												
												$rec_attr_info = $app->attr_info($piece_attr[$ci][0]);  
												if($rec_attr_info[attribute_type]=='url') {  // ถ้า attribute_name คือชนิด url  ให้ encode & เป็น &amp;
														$piece_attr[$ci][1] = eregi_replace("[&]","&amp;",trim($piece_attr[$ci][1]));
														 
												}
											}
											$piece_attr[$ci][0]=trim($piece_attr[$ci][0]);
											
											$arr_temp_attr[$ci]=implode("=",$piece_attr[$ci]);
										}
									
										if(trim($arr_tag[$i])=="script") {
												$js_id = $text_id;  // ถ้ามี tag script ให้เก็บ id ไว้ update ทีหลังด้วย $text_js ที่สะสม code java เสร็จแล้ว
										
												$in_script1 = true;
										} 
										if(trim($arr_tag[$i])=="style") {
												$css_id = $text_id;  // ถ้ามี tag style ให้เก็บ id ไว้ update ทีหลังด้วย $text_css ที่สะสม code css เสร็จแล้ว
										
												$in_script2 = true;
										} 
										
										$rank++;
																
									}
																		
									if(trim($arr_tag[$i])=="/script") {											 											 										
											 
											 $js_id = 0; // พอ update javascript ไปแล้ว ก็เคลียร์ค่า id ของเก่า = 0											 									 
									}
									if(trim($arr_tag[$i])=="/style") {											 
											 											
											 $css_id = 0; // พอ update css ไปแล้ว ก็เคลียร์ค่า id ของเก่า = 0											 									 
									}
																		
							}	// end เอาเฉพาะ ชื่อ tag จริงๆ 			
							
							$attribute_pack[$i] = implode(" ",$arr_temp_attr);
					
						if(trim($arr_tag[$i])) {		
								if( trim($arr_tag[$i])=="/script" && $in_script1==false) {  	//  ถ้าจะปิด script แล้วค่อย	เก็บค่าทีเดียว
										$edited_phpcontents.= $text_js; 
										
										$edited_phpcontents.= "<".$arr_tag[$i].">".$app->convert_text_chars($text_value[$i]);
								} else if( trim($arr_tag[$i])=="/style" && $in_script2 ==false) { // ถ้าจะปิด style แล้วค่อย  เก็บค่าทีเดียว
										$edited_phpcontents.= $text_css;
										
										$edited_phpcontents.= "<".$arr_tag[$i].">".$app->convert_text_chars($text_value[$i]);
								} else if( ($in_script1==false && $in_script2==false) || trim($arr_tag[$i])=="script" || trim($arr_tag[$i])=="style" ) {																
										
											if(!eregi("/",$arr_tag[$i])) {
											
												if(trim($arr_tag[$i])=="script" || trim($arr_tag[$i])=="style") {												
													$edited_phpcontents.= "<".$arr_tag[$i]." ".trim($attribute_pack[$i]).">";
												} else {
													$edited_phpcontents.= "<".$arr_tag[$i]." ".trim($attribute_pack[$i]).">".$app->convert_text_chars($text_value[$i]);
												}
											} else {
												$edited_phpcontents.= "<".$arr_tag[$i].">".$app->convert_text_chars($text_value[$i]);
											}
										
								}
						} else {
											$edited_phpcontents.= $app->convert_text_chars($text_value[$i]);
						}
																				
				}	// end for($i=0;$i<count($arr_words);$i++)		
				//////////////////  end ส่วน encode & เฉพาะใน attribute ที่เป็น url /////////////////////////
						
					
						if(file_exists($UserPath.$dir1.$filecheck.".php")) {
						
							$passbackup = rename($UserPath.$dir1.$filecheck.".php", $UserPath.$dir1.$filecheck."_bkup".date("YmdHis").".php");
					
						
							//echo " $UserPath$dir1$filecheck : ".file_exists($UserPath.$dir1.$filecheck.".php")."<br>";
							//echo " passbackup : $passbackup<br>";
							if($passbackup) { 
								// ต้อง backup file เก่าให้สำเร็จก่อน แล้วจึงเขียนไฟล์ php ที่แก้ w3c แล้ว ทับ								
							
									// $disp->testvar_infile($phpcontents, $UserPath.$dir1.$filecheck.".php", "w");															
									  $result1 = $disp->testvar_infile($edited_phpcontents, $UserPath.$dir1.$filecheck.".php", "w");																
														
							} // end passbackup
					 } // end file_exists
						
								
			
			$UPDATE = " UPDATE webpage_info SET  w3c_html = 'rep', w3c_wcag = 'rep', w3c_css = 'rep', mode_edit = '2', modify_time  = NOW()  WHERE  filename = '$filecheck' AND db_name = '".$main_db."'  ";
			//echo "$UPDATE<br>";
			$db2->query($UPDATE);
			
			//exit;
											
			?><script language="javascript1.2">
				alert("แก้ไขหน้าเว็บเรียบร้อยแล้ว");
				opener.location.reload();
				window.close();
			
				</script>		
			<?php											
		
	}
?>
<?php				
		//echo "$filepathname<br>";
		$handle = fopen($filepathname, "r");  
							   							  
		if($handle) {
			while ($buffer = fgets($handle, 4096)) {  // while (!feof($handle))		
				//echo $buffer;
				$text  .= $buffer;
				
			}
			fclose($handle);
		}
		//echo $text;
		
		$temp_html = trim($text); 				
		
		//$temp_code = split("<div id=\"content\"><div class=\"story\"><table width=\"99%\"><tr><td valign=\"top\">",$temp_html,2);
		
		//$temp_code2 = split("</td></tr></table></div></div><!--end content -->", $temp_code[1],2);
		$logo_401 = file_get_contents("bottom_401.html");
		$logo_wcag = file_get_contents("bottom_wcag.html");
		$logo_css = file_get_contents("bottom_css.html");
				
		
		$htmlcode = str_replace($logo_401,"",$temp_html);  //$temp_html; // $temp_code2[0];
		$htmlcode = eregi_replace($logo_wcag,"",$htmlcode); 
		$htmlcode = eregi_replace($logo_css,"",$htmlcode); 
		
		//$htmlcode = $temp_html;
		
		if(eregi("href=\"../".$folder."/emx_nav_left.css\"", $temp_html)) {
			$temp_text = split("<div id=\"content\"><div class=\"story\"><table width=\"99%\"><tr><td valign=\"top\">",$temp_html,2);
			$temp_text2 = split("</td></tr></table></div></div><!--end content -->", $temp_text[1],2);
		
			$input_bodytag = $temp_text2[0];
		} else {				
				/* $temp_text = $temp_text2 = array();
				$temp_text = split("<body", strtolower($temp_html));
				$temp_text2 = split("</body", $temp_text[1],2);
				$temp_text3 = split("</body", $temp_text[2],2);
				
				if( strlen($temp_text2[0]) > strlen($temp_text3[0]) ) {
					$input_bodytag = $temp_text2[0];
				} else {
					$input_bodytag = $temp_text3[0];
				} */
				$input_bodytag = $temp_html;
		}
		$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

		$replace = array ("",
						  "",
						  "\\1",
						  "\"",
						  "&",
						  "<",
						  ">",
						  " ",
						  chr(161),
						  chr(162),
						  chr(163),
						  chr(169),
						  "chr(\\1)");

		$body_text  = preg_replace ($search, $replace, $input_bodytag);
				
?>
<body>
<form name="frm" method="post" action="w3c_editor.php" enctype="multipart/form-data">

<H2>W3C Editor </H2>
<H3>ชื่อไฟล์เว็บเพจ : <span style=" font-size:small; color:#FF0000"><?php echo $filecheck; ?></span>  <span style=" font-size:small"><?php if($file_recover) echo " ( กู้มาจากไฟล์ $file_recover ) "; ?></span></H3>
<?php
 //echo htmlspecialchars($temp_html); echo "<hr>";
 echo htmlspecialchars($logo_401); ?>
<br>
<table border="1" bordercolor="#000000" cellpadding="2" cellspacing="0">
<tr valign="top" ><td width="600">
<span id="sp_mode2" style=" font-family:MS Sans Serif; font-size:10pt">
	<textarea name="htmlcode" cols="100" rows="25" wrap="off" ><?php 
		if($rec_info["w3c_html"]) {
			echo $htmlcode;
		}
	?></textarea>
</span>
</td>
<td width="240">
	 <table border="0" cellpadding="2" cellspacing="1">
	  <caption align="center"><strong>รายชื่อเว็บ php ที่สำรองไว้</strong><br><br></caption>
		<?php 
		//echo $dir1." : ".is_dir($dir1);
		 if (is_dir($UserPath.$dir1)) {
					if ($dh = opendir($UserPath.$dir1)) {

						$fb=0;
						while (($file = readdir($dh)) !== false) {  // list รายชื่อไฟล์ php ใน  w3c/checked  มาให้เลือก ถ้าต้องการกับไปใช้ไฟล์เก่า
																									// ที่อาจถูกต้องกว่า ไฟล์ใหม่
							//echo "$file<br>";
							if(is_file($UserPath.$dir1.$file) &&  eregi(".php$", $file) && eregi("^".$filecheck."_bkup", $file) ) {
									//$file_list[$i] = $file;
									?>
									<tr><td align="left">
									<a href="w3c_editor.php?filename=<?php echo eregi_replace(".php","",$file);?>"><?php echo eregi_replace(".php","",$file);?></a>              </td>
									 <td align="center"><img src="images/delete_16.gif" border="0" align="middle" alt="ลบไฟล์" style="cursor:pointer" onClick="if(confirm('ต้องการลบไฟล์ <?php echo $file;?> หรือไม่?')) {  parent.location = 'del_file.php?filepathname=<?php echo $file;?>&prev_url=<?php echo $PHP_SELF;?>&filename=<?php echo $filecheck;?>'; }"></td>
									 </tr><?php
									$fb++;
							}
						}
						closedir($dh);
					}
				}	 ?>
		</table>
	</td>
</tr>
</table>
<br>
<input name="filecheck" type="hidden" value="<?php echo $filecheck;?>">

	<input name="bt_accept" type="button" value=" Save " onClick="return chkInput()"> 

	<input name="accept" type="hidden">
</form>
<script type="text/javascript">createTextAreaWithLines('htmlcode');</script> 
<?php 
$db2->close_db();
$db->db_close();		
 ?>

</body>
</html>
