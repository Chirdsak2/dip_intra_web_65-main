<?php
$_GET["filename"] = $_REQUEST["filename"];
function showiconw3c($filename,$type,$page_type){
			global $db,$EWT_DB_NAME;
			$db->query("USE w3c_ictweb");
			$sql = "select * from webpage_info where filename = '".$filename."' and page_type ='".$page_type."' and db_name = '".$EWT_DB_NAME."'";
			$query = $db->query($sql);
			$R = $db->db_fetch_array($query);
			$db->query("USE ".$EWT_DB_NAME);
			if($type == '1'){
			return $html = $R["w3c_html"];
			}else if($type == '2'){
			return $wai = $R["w3c_wcag"];
			}else if($type == '3'){
			return $css = $R["w3c_css"];
			}
			
	}
if($d_idtemp == ''){
$_SESSION["EWT_TYPE_ID"];
	if($_SESSION["EWT_TYPE_ID"] != ""){
	$sql_person = $db->query("SELECT * FROM personal_map WHERE p_group = '".$_SESSION["EWT_TYPE_ID"]."' ");
		if($db->db_num_rows($sql_person) > 0){
			$PW = $db->db_fetch_array($sql_person);
				if($PW["p_template"] != "" AND $PW["p_template"] != "0" ){
					if($page != 'news'){
						if($_GET["filename"] == 'index'){
							$tp_default = 'I';
						}else if($_GET["filename"] != 'index'){
							$tp_default = 'G';
						}else{
							$tp_default = 'D';
						}
					}else{
						$tp_default = 'A';
					}
					//echo "SELECT design_series.ds_id,ds_name,design_series_function.d_id FROM design_series,design_series_function where design_series_function.ds_id = design_series.ds_id and design_series_function.dsf_type = '$tp_default' ";
					$sql_temp = $db->query("SELECT design_series.ds_id,ds_name,design_series_function.d_id FROM design_series,design_series_function where design_series_function.ds_id = design_series.ds_id and design_series_function.dsf_type = '$tp_default' and design_series_function.ds_id = '".$PW["p_template"]."'");
					$TP = $db->db_fetch_array($sql_temp);
					$d_idtemp = $TP["d_id"];
				}
		}else{
			
			$lang_sh = explode('___',$_GET["filename"]);
			if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
			if($_GET["cid"] != ""){
				$sql_index = $db->query("select d_id_w3c,d_id from  article_group where c_id = '".$_GET["cid"]."'");
				$XX = $db->db_fetch_array($sql_index);
					if($XX[d_id_w3c] == '0' || $XX[d_id_w3c] == ' '){
					//$XX[0] = $XX[1];
						$sql_index_def = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
						$FF_df = $db->db_fetch_array($sql_index_def);
						$XX["d_id_w3c"] = $FF_df["d_id"];
					}
					if($XX[d_id_w3c] != '0'){
					$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '$XX[d_id_w3c]'  ");
					}else{
						if($_GET["filename"] != ""){
							$sql_index = $db->query("SELECT template_id_w3c,template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
							$XX = $db->db_fetch_array($sql_index);
									if($XX["template_id_w3c"] == '0' || $XX["template_id_w3c"] == ' '){
										//$XX["template_id_w3c"] = $XX["template_id"];
										$sql_index_def = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
										$FF_df = $db->db_fetch_array($sql_index_def);
										$XX["template_id_w3c"] = $FF_df["d_id"];
										}
									$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '".$XX["template_id_w3c"]."'  ");
						}else{
							$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
						}
					}
				}
			$FF = $db->db_fetch_array($sql_index);
			$d_idtemp = $FF[d_id];
		}
	}else{
		$lang_sh = explode('___',$_GET["filename"]);
			if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
				if($_GET["cid"] != ""){
				$sql_index = $db->query("select d_id_w3c,d_id from  article_group where c_id = '".$_GET["cid"]."'");
				$XX = $db->db_fetch_array($sql_index);
					if($XX[d_id_w3c] == '0' || $XX[d_id_w3c] == ' '){
					//$XX[0] = $XX[1];
						$sql_index_def = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
						$FF_df = $db->db_fetch_array($sql_index_def);
						$XX["d_id_w3c"] = $FF_df["d_id"];
					}
					if($XX[d_id_w3c] != '0' || $XX[d_id_w3c] != ' '){
					$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '$XX[d_id_w3c]'  ");
					}else{
						if($_GET["filename"] != ""){
							$sql_index = $db->query("SELECT template_id_w3c,template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
							$XX = $db->db_fetch_array($sql_index);
							if($XX["template_id_w3c"] == '0' || $XX["template_id_w3c"] == ' '){
										//$XX["template_id_w3c"] = $XX["template_id"];
										$sql_index_def = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
										$FF_df = $db->db_fetch_array($sql_index_def);
										$XX["template_id_w3c"] = $FF_df["d_id"];
										}
									$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '".$XX["template_id_w3c"]."'  ");
						}else{
							$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
						}
					}
				}
		$FF = $db->db_fetch_array($sql_index);
		$d_idtemp = $FF[d_id];
	}
}else{
$_GET["filename"] = $_REQUEST["filename"];
$lang_sh = explode('___',$_GET["filename"]);
	if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
	if($_GET["cid"] != ""){
$sql_index = $db->query("select d_id_w3c,d_id from  article_group where c_id = '".$_GET["cid"]."'");
$XX = $db->db_fetch_array($sql_index);
	if($XX[d_id_w3c] == '0' || $XX[d_id_w3c] == ' '){
	//$XX[0] = $XX[1];
						$sql_index_def = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
						$FF_df = $db->db_fetch_array($sql_index_def);
						$XX["d_id_w3c"] = $FF_df["d_id"];
	}
	if($XX[d_id_w3c] != '0'  || $XX[d_id_w3c] == ' '){
	$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '$XX[d_id_w3c]'  ");
	}else{
		if($_GET["filename"] != ""){
			$sql_index = $db->query("SELECT template_id_w3c,template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
			$XX = $db->db_fetch_array($sql_index);
			if($XX["template_id_w3c"] == '0' || $XX["template_id_w3c"] == ' '){
						//$XX["template_id_w3c"] = $XX["template_id"];
						$sql_index_def = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
										$FF_df = $db->db_fetch_array($sql_index_def);
										$XX["template_id_w3c"] = $FF_df["d_id"];
						}
					$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '".$XX["template_id_w3c"]."'  ");
		}else{
			$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
		}
	}
}
		
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
if($lang_sh != ''){
$lang_shxxx = explode('___',$_GET["filename"]);
$d_idtemp =select_lang_detail($_GET[cid],$lang_shxxx[1],'d_id_w3c','article_group');
}
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$F = $db->db_fetch_array($sql_temp);
$design_id = $F["d_id"];
$global_theme = $F["d_bottom_content"];
$mainwidth = "0";
$template_w3c = $F[d_name];
$file_template ='template/'.$template_w3c.'.php';
if (file_exists($file_template)) {
		$fw = @fopen($file_template, "r");
			$temp_html = showiconw3c($template_w3c,'1','2');
	$temp_wai= showiconw3c($template_w3c,'2','2');
	$temp_css = showiconw3c($template_w3c,'3','2');
				 if($fw){ 
					while($html = @fgets($fw, 1024)){
					$line .= $html;
					}
				}
				$template_design = explode('<?#w3c_spliter#?>',$line);
				
				// echo ereg_replace ("href=\"phpThumb.php?src=../".$URL."/", " href=\"ewt_dl_file.php?url=", $line);//$line;
		  @fclose($fw);
}else{
if($template_w3c == ''){
	$sql_index = $db->query("SELECT d_name FROM design_list WHERE d_default_w3c = 'Y' ");
	$FF = $db->db_fetch_array($sql_index);
	$template_w3c = $FF[d_name];
}
$lang_sh = explode('___',$_GET["filename"]);
if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
	$temp_html = 'w3c';
	$temp_wai=  'w3c';
	$temp_css =  'w3c';
include("include/config.inc.php");
$file_template =$Website.$folder .'/ewt_preview_template_view.php?filename='.$_GET[filename].'&c_id='.$_GET["cid"].'&filenametemplate='.$template_w3c;
$contents = file_get_contents($file_template);
$use_contents = trim($contents);
					//echo $htmlcode;
					//echo "<br>";
					// ================= ส่วนแก้ไข Tag เปิด-ปิด  ด้วย tidy  PHP  Class  ===============
					//exit;
					$tidy = new tidy;   //  ต้องเปิด extension   php_tidy.dll  ใน php.ini ก่อน
					
					$opts = array("clean" => true,'output-html' => TRUE, "quote-ampersand" => false, "quote-nbsp" => false, "lower-literals" => false, "css-prefix" => "tp", "literal-attributes" => true,"enclose-block-text"=>true,"alt-text"=>'no insert title on tag images');  

					// , "wrap-jste" => true , "wrap" => 200 , "wrap-attributes" => true
					// "vertical-space" => true
					
					$tidy->parseString(trim($use_contents),$opts,'latin1'); // "latin1"
					
					$tidy->cleanRepair();
					
					//$htmlcode =  trim($contents);
					$htmlcode = $tidy->html();  // จริงๆแล้ว ต้องใช้ content ที่แก้ tag เปิด-ปิดแล้ว  แต่เอาออกชั่วคราว  เพราะมันชอบแก้โค้ด javascript  ทำให้ javascript Error	 แต่ล่าสุดเรา set option แก้ปัญหานี้ได้แล้ว คือ 	"literal-attributes" => true 	
					
					//echo $htmlcode;
					// ==================================================================
						$headerw3c = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
	<HTML lang=\"th\">";
						$htmlcode = eregi_replace("/>",">",$htmlcode); // แก้ /> ไปก่อนเลย
						$htmlcode = eregi_replace("iso-8859-1","UTF-8",$htmlcode); // แก้ so-8859-1 ไปก่อนเลย
						$htmlcode = eregi_replace("<HTML>",$headerw3c,$htmlcode); // แก้ so-8859-1 ไปก่อนเลย
						//แก้ไข link ไปก่อน ทำไปก่อน พี่ม่อนยังไม่คิดทางออกให้ดีกว่านี้
						$htmlcode = eregi_replace("href=\"css/","href=\"../css/",$htmlcode); 
						$htmlcode = eregi_replace("\"images/","\"../images/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"images","src=\"../images",$htmlcode); 
						$htmlcode = eregi_replace("\"download/","\"../download/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"download","src=\"../download",$htmlcode); 
						$htmlcode = eregi_replace("\"mainpic/","\"../mainpic/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"mainpic","src=\"../mainpic",$htmlcode); 
						$htmlcode = eregi_replace("\"icon/","\"../icon/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"icon","src=\"../icon",$htmlcode); 
						//ตัดไปเลย
						$template_design = explode('#w3c_spliter#',$htmlcode);
						

}