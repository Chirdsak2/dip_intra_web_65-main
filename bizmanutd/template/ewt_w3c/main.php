<?php
	session_start();
$path = "../";
			if(file_exists("checked/".$_GET["filename"].".php")) {  
			
			$start_time_counter = date("YmdHis");
			include($path."lib/function.php");
			include($path."lib/user_config.php");
			include($path."lib/connect.php");
			include("include/ewt_block_function.php");
			include("include/ewt_menu_preview.php");
			include("include/ewt_article_preview.php");
			include("ewt_template.php");
			/*$page_html = showiconw3c($_GET["filename"],'1','1');
			$page_wai= showiconw3c($_GET["filename"],'2','1');
			$page_css = showiconw3c($_GET["filename"],'3','1');*/
			
				//include("checked/".$_GET["filename"].".php");//กรณีมีการแปลง page ไว้
				$fp = fopen ("checked/".$_GET["filename"].".php", 'rb');
				$ata = fread( $fp, filesize("checked/".$_GET["filename"].".php"));
				$explo = explode('<body>',$ata);
				$head = explode('</head>',$template_design[0]);
				 echo $head[0].$explo[0].'</head>'.$head[1].$explo[1];
				 	if(!session_is_registered("EWT_VISITOR_STAT")){
						session_register("EWT_REFERER");
						$_SESSION["EWT_REFERER"] = $HTTP_REFERER;
						}
						$end_time_counter = date("YmdHis");
						$gap = $end_time_counter - $start_time_counter;
						?>
					<script language="javascript" type="text/javascript">
					document.write("<img src=\"../ewt_stat.php?t=page&filename=<?php echo $_GET["filename"]; ?>&load=<?php echo $gap; ?>&res="+screen.width+"x"+screen.height+"\" width=\"1\" height=\"1\" style=\"display:none\">");	
					</script>
					<?php
						/*if($temp_html == 'w3c' && $page_html == 'w3c'){
						$logo = file_get_contents("bottom_401.html"); 
						}
						if($temp_wai == 'w3c' && $page_wai == 'w3c'){
						$logo .= file_get_contents("bottom_wcag.html"); 
						}
						if($temp_css == 'w3c' && $page_css == 'w3c'){
						$logo .= file_get_contents("bottom_css.html"); 
						}*/
						//echo $logo;
						$template_b = explode("#htmlw3c_spliter#",$template_design[1]); 
						echo $template_b[0].$logo.$template_b[1];
						//$template_design[1] =ereg_replace("#htmlw3c_spliter#","",$template_design[1]);
						//echo $template_design[1];
			}else if(file_exists("page_html/page_".$_GET["filename"].".php")){//ใช้ไฟล์ แก้ไขแบบที่ 2
			include($path."lib/function.php");
			include($path."lib/user_config.php");
			include($path."lib/connect.php");
				$fp = fopen ("page_html/page_".$_GET["filename"].".php", 'rb');
				$ata = fread( $fp, filesize("page_html/page_".$_GET["filename"].".php"));
				$logo1 = "<a href=
\"http://validator.w3.org/check?uri=referer\"><img src=
\"http://www.w3.org/Icons/valid-html401\" alt=
\"Valid HTML 4.01 Transitional\" height=\"31\" width=\"88\" border=
\"0\"></a>";
				$logo2 = "<a href=
\"http://www.w3.org/WAI/WCAG1A-Conformance\" title=
\"Explanation of Level A Conformance\"><img height=\"32\" width=\"88\"
src=\"http://www.w3.org/WAI/wcag1A\" alt=
\"Level A conformance icon, W3C-WAI Web Content Accessibility Guidelines 1.0\"
border=\"0\"></a>"; 		
				$logo3 = "<a href=
\"http://jigsaw.w3.org/css-validator/check/referer\"><img src=
\"http://jigsaw.w3.org/css-validator/images/vcss\" alt=\"Valid CSS!\"
border=\"0\"></a>"; 
				$stat_code = '<script language="javascript" type="text/javascript">
document.write("<img src="../ewt_stat.php';
$stat_code2 = 'style="display:none">");     
</script>';
				$contents = str_replace($logo1,"",$ata);
				$contents = str_replace($logo2,"",$contents);
				$contents = str_replace($logo3,"",$contents);
				$contents = str_replace($stat_code,"#stat_page#",$contents);
				$contents = str_replace($stat_code2,"#stat_page2#",$contents);
				$sql_page = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."'");
				$RR= $db->db_fetch_array($sql_page);
				$logo_used = '';
					if($RR["html"] == 'Y'){
					$logo_used .= file_get_contents("bottom_401.html"); 
					}
					if($RR["wcag"] == 'Y'){
					$logo_used .= file_get_contents("bottom_wcag.html"); 
					}
					if($RR["css"] == 'Y'){
					$logo_used .= file_get_contents("bottom_css.html"); 
					}
				$arr_html = split("</td>
</tr>
</table>
</body>",$contents,2);
								
								$newcontents = $arr_html[0].$logo_used."</td>
</tr>
</table>
</body>".$arr_html[1];
			//เกี่ยวกับ stat
			$explo = explode("#stat_page#",$newcontents);
echo $explo[0] ;
if(!session_is_registered("EWT_VISITOR_STAT")){
						session_register("EWT_REFERER");
						$_SESSION["EWT_REFERER"] = $HTTP_REFERER;
						}
						$end_time_counter = date("YmdHis");
						$gap = $end_time_counter - $start_time_counter;
?>
					<script language="javascript" type="text/javascript">
					document.write("<img src=\"ewt_stat.php?t=page&filename=<?php echo $_GET["filename"]; ?>&load=<?php echo $gap; ?>&res="+screen.width+"x"+screen.height+"\" width=\"1\" height=\"1\" style=\"display:none\">");	
					</script>
					<?php
		$ex_bottom = explode("#stat_page2#",$explo[1]);
	echo $ex_bottom[1];
			}else{
				$path = "../";
				include($path."lib/user_config.php");
				include("include/config.inc.php");
				if(isset($_GET['org_id'])) {
				$forg = "&org_id=".$_GET['org_id'];
				} 
			
$file_template =$Website.$folder .'/main_auto.php?filename='.$_GET["filename"].'&SSMID='.$_SESSION["EWT_MID"].'&SSMAIL='.$_SESSION["EWT_MAIL"].'&SSorg='.$_SESSION["EWT_ORG"].$forg;
$contents = file_get_contents($file_template);
$use_contents = trim($contents);
					//echo $htmlcode;
					//echo "<br>";
					// ================= ส่วนแก้ไข Tag เปิด-ปิด  ด้วย tidy  PHP  Class  ===============
					//exit;
					$tidy = new tidy;   //  ต้องเปิด extension   php_tidy.dll  ใน php.ini ก่อน
					
								$opts = array("clean" => true,'output-html' => TRUE, "quote-ampersand" => false, "quote-nbsp" => false, "lower-literals" => false, "css-prefix" => "mp", "literal-attributes" => true,"enclose-block-text"=>true,"alt-text"=>'not insert alt on tag images');  

					// , "wrap-jste" => true , "wrap" => 200 , "wrap-attributes" => true
					// "vertical-space" => true
					
					$tidy->parseString($use_contents,$opts,'latin1'); // "latin1"
					
					$tidy->cleanRepair();
					
					//$htmlcode =  trim($contents);
					
					$htmlcode = $tidy->html();  // จริงๆแล้ว ต้องใช้ content ที่แก้ tag เปิด-ปิดแล้ว  แต่เอาออกชั่วคราว  เพราะมันชอบแก้โค้ด javascript  ทำให้ javascript Error	 แต่ล่าสุดเรา set option แก้ปัญหานี้ได้แล้ว คือ 	"literal-attributes" => true 	
					
					//echo $htmlcode;
					// ==================================================================
						$headerw3c = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
	<HTML lang=\"th\">";
						$htmlcode = eregi_replace("/>",">",$htmlcode); // แก้ /> ไปก่อนเลย
						$htmlcode = eregi_replace("iso-8859-1","UTF-8",$htmlcode); // แก้ so-8859-1 ไปก่อนเลย
						$htmlcode = eregi_replace("<html lang=\"th\">",$headerw3c,$htmlcode); // แก้ so-8859-1 ไปก่อนเลย
						//แก้ไข link ไปก่อน ทำไปก่อน พี่ม่อนยังไม่คิดทางออกให้ดีกว่านี้
						$htmlcode = eregi_replace("\"images/","\"../images/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"images","src=\"../images",$htmlcode); 
						$htmlcode = eregi_replace("\"download/","\"../download/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"download","src=\"../download",$htmlcode); 
						$htmlcode = eregi_replace("\"mainpic/","\"../mainpic/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"mainpic","src=\"../mainpic",$htmlcode); 
						$htmlcode = eregi_replace("\"icon/","\"../icon/",$htmlcode); 
						$htmlcode = str_replace("(images","(../images",$htmlcode); 
						echo $htmlcode = eregi_replace("src=\"icon","src=\"../icon",$htmlcode); 
						
			}//end if file_existe ?>
		<?php

?>