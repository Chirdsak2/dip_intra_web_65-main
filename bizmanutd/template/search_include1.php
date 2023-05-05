<?php
	//header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	//=============================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($offset){ $offset = checkNumeric($offset); }
	if($_GET["offset"]){ $_GET["offset"] = checkNumeric($_GET["offset"]); }
	if($_POST["offset"]){ $_POST["offset"] = checkNumeric($_POST["offset"]); }
	
	$keyword=checkPttSearch($keyword);
	$_GET["keyword"]=checkPttSearch($_GET["keyword"]);
	$_POST["keyword"]=checkPttSearch($_POST["keyword"]);
	//=============================================================
	include("../../ewt_article_preview.php");
	
			if($_SERVER["REMOTE_ADDR"]){
						$ip_address = $_SERVER["REMOTE_ADDR"];
					}else{
						$ip_address = $_SERVER["REMOTE_HOST"];
					}
	$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
	if($_GET["filename"] != "") {
		$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);
		$_GET["d_id"] = $F["template_id"];
	} else {
		$_GET["filename"] = "index";
		$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
		$FF = $db->db_fetch_array($sql_index);
		$_GET["d_id"] = $FF[d_id];
	}

	if($_REQUEST["keyword"] != "") {
		$_REQUEST["keyword"] = stripslashes(htmlspecialchars(trim($_REQUEST["keyword"]),ENT_QUOTES));
	}
	if($_REQUEST["date_s"] != "") {
		$_REQUEST["date_s"] = stripslashes(htmlspecialchars(trim($_REQUEST["date_s"]),ENT_QUOTES));
	}
	if($_REQUEST["date_e"] != "") {
		$_REQUEST["date_e"] = stripslashes(htmlspecialchars(trim($_REQUEST["date_e"]),ENT_QUOTES));
	}
	if($_REQUEST["date_s"] != "") {
		$sh_date = "date_s=".$_REQUEST["date_s"]."&";
	}
	if($_REQUEST["date_e"] != "") {
	$sh_date .= "date_e=".$_REQUEST["date_e"]."&";
	}
	if($_REQUEST["g"] != "") {
	$sh_date .= "g=".$_REQUEST["g"]."&";
	}
			$lang_sh1 = explode('___',$F[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
	$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
	$sql_temp= $db->query($temp);
	$RR = $db->db_fetch_array($sql_temp);

	$global_theme = $RR["d_bottom_content"];
	$mainwidth = "0";

	if($oper == "") { $oper = "OR"; }
	if($search_mode == "") { $search_mode = "1"; }
	function like_word($w) {
		global $db;
		global $EWT_DB_NAME,$EWT_DB_USER;
		if(trim($w) != "") {
			$like = "";
			$w = stripslashes(htmlspecialchars(trim($w),ENT_QUOTES));
			$db->query("USE ".$EWT_DB_USER);
			$sql_dict = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD = '".trim($w)."' ");
			if($db->db_num_rows($sql_dict) == 0) {
				$sql_dict1 = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '".trim($w)."%' ORDER BY DICT_WORD LIMIT 0,1");
				if($db->db_num_rows($sql_dict1) > 0) {
					$D = $db->db_fetch_row($sql_dict1);
					$like = $D[0];
				} else {
					$sql_dict2 = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '%".trim($w)."' ORDER BY DICT_WORD  LIMIT 0,1");
					if($db->db_num_rows($sql_dict2) > 0) {
						$D = $db->db_fetch_row($sql_dict2);
						$like = $D[0];
					} else {
						$countw = strlen($w);
						//if($countw > 2){
						for($x=1; $x<($countw); $x++) {
							$newword = substr($w, 0,-$x);
							$sql_dict3 = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '".$newword."%' ORDER BY DICT_WORD LIMIT 0,1");
							if($db->db_num_rows($sql_dict3) > 0) {
								$D = $db->db_fetch_row($sql_dict3);
								$like = $D[0];
								$x = $countw;
							}
							//}
						}
					}
				}
			}
		}
		$db->query("USE ".$EWT_DB_NAME);
		return $like;
	}
	
	function next_word($w) {
		global $db;
		global $EWT_DB_NAME,$EWT_DB_USER;
		if(trim($w) != "") {
			$w = stripslashes(htmlspecialchars(trim($w),ENT_QUOTES));
			$db->query("USE ".$EWT_DB_USER);
			$like = "";
			$sql_dict1 = $db->query("SELECT DICT_SEARCH FROM dictionary WHERE DICT_WORD = '".trim($w)."' ");
			if($db->db_num_rows($sql_dict1) > 0) {
				$D = $db->db_fetch_row($sql_dict1);
				$like = trim($D[0]);
			}
			$db->query("USE ".$EWT_DB_NAME);
		}
		return $like;
	}
	
	function diff_word($w){
		global $db;
		global $EWT_DB_NAME,$EWT_DB_USER;
		if(trim($w) != "") {
			$w = stripslashes(htmlspecialchars(trim($w),ENT_QUOTES));
			$db->query("USE ".$EWT_DB_USER);
			$like = "";
			$sql_dict1 = $db->query("SELECT DICT_SYNONYM FROM dictionary WHERE DICT_WORD = '".trim($w)."' ");
			if($db->db_num_rows($sql_dict1) > 0) {
				$D = $db->db_fetch_row($sql_dict1);
				$like = trim($D[0]);
			}
			$db->query("USE ".$EWT_DB_NAME);
		}
		return $like;
	}
	
	function cuttag($tag) {
		$search = array (
			"'<script[^>]*?>.*?</script>'si",  // Strip out javascript
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
		
		$RReplace = array (
			"",
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
		
		$detail = preg_replace ($search, $RReplace, $tag);
		return $detail;
	}
	
	if(trim($_REQUEST["keyword"]) != ""  || ( $search_mode =='2' and $_REQUEST["date_s"] != '' and $_REQUEST["date_e"] != '')){
	
		$data_default = stripslashes(htmlspecialchars(trim($_REQUEST["keyword"]),ENT_QUOTES));
		$data = $data_default;
		$data = str_replace('+',' ',$data);
		$data = str_replace('*',' ',$data);
		if(trim($data) != "" || ( $search_mode =='2' and $_REQUEST["date_s"] != '' and $_REQUEST["date_e"] != '')){
		$dt = explode(" ",$data);
		$num = count($dt);
		$word_b = "";
		$word_a = "";
		$word_ah = "";
		$word_n = "";
		$word_d = "";
		for($i=0;$i<$num;$i++){
		
			if(trim($dt[$i]) == "(" OR trim($dt[$i]) == ")"){
			$dt[$i] = "";
			}
			if(trim($dt[$i]) != ""){
				$check = like_word($dt[$i]);
				$word_n .= ",".next_word($dt[$i]);
				$word_d .= ",".diff_word($dt[$i]);
				$word_b .= $check." ";
						if($check != ""){
							$word_a .= "<font color=red>".$check."</font> ";
							$word_ah .= $check." ";
						}else{
							$word_a .= $dt[$i]." ";
							$word_ah .= $dt[$i]." ";
						}
						
						if($_GET["p"] != "1"){
							$db->query("insert into search_stat (search_word,search_date,search_time,search_ip,search_module)  values ('$dt[$i]','".date("Y-m-d")."','".date("H:i:s")."','$ip_address','$search_mode') ");
						}
					if($search_mode == "1"){
						$seld .= " ( temp_index.cms_keyword REGEXP  '$dt[$i]' OR temp_index.filename REGEXP  '$dt[$i]' )".$oper;
					}elseif($search_mode == "2"){
						$seld .= " ( article_list.n_topic REGEXP  '$dt[$i]' OR article_list.n_des REGEXP  '$dt[$i]' OR article_list.keyword REGEXP  '$dt[$i]')".$oper;
					}elseif($search_mode == "3"){
						$seld .= " ( gallery_image.img_name REGEXP  '$dt[$i]' OR gallery_image.img_detail REGEXP  '$dt[$i]'  )".$oper;
					}elseif($search_mode == "4"){
						$seld .= " ( t_name REGEXP  '$dt[$i]' OR t_detail REGEXP  '$dt[$i]'  OR  a_detail REGEXP  '$dt[$i]' )".$oper;
					}elseif($search_mode == "5"){
						$seld .= " ( faq.fa_name REGEXP  '$dt[$i]' OR faq.fa_detail  REGEXP  '$dt[$i]' OR faq.fa_ans  REGEXP  '$dt[$i]' )".$oper;
					}
				}
		}
		//echo $seld;
		$word_b = trim($word_b);
		$summ = strlen($oper);
		$seld = substr($seld,0,-$summ);
		

$limit = "20";
	if($search_mode == "1"){
		$sql_search = "SELECT  temp_index.filename,temp_index.cms_keyword,title FROM  temp_index  WHERE ".$seld." ORDER BY temp_index.Last_HTML DESC  ";
	}elseif($search_mode == "2"){
	$date_now = (date("Y")+543).'-'.date('m-d H:i:s');
	if($lang_shw != ''){
		$sql_search = "SELECT article_list.n_id,article_list.c_id,article_list.n_topic,lang_article_list.lang_detail,article_list.n_des,article_list.n_date,article_list.news_use,article_list.link_html,article_list.picture,article_group.c_name,article_group.c_id  FROM
						 article_list INNER JOIN article_group ON article_list.c_id = article_group.c_id 
						INNER JOIN  lang_article_list ON article_list.n_id = lang_article_list.c_id
						INNER JOIN  lang_config ON lang_config.lang_config_id = lang_article_list.lang_name
						WHERE article_list.n_approve = 'Y' AND lang_config.lang_config_suffix = '".$lang_shw."' AND lang_article_list.lang_field = 'n_topic' and (('$date_now' between n_date_start  and n_date_end) or (n_date_start = '' and n_date_end = '')) ";
	}else{
		$sql_search = "SELECT article_list.n_id,article_list.c_id,article_list.n_topic,article_list.n_des,article_list.n_date,article_list.news_use,article_list.link_html,article_list.picture,article_group.c_name FROM article_list INNER JOIN article_group ON article_list.c_id = article_group.c_id WHERE article_list.n_approve = 'Y' and (('$date_now' between n_date_start  and n_date_end) or (n_date_start = '' and n_date_end = ''))";
	}
		if($_GET["g"] != ""){
		$sql_search .= " AND article_group.c_id = '".$_GET["g"]."' ";
		}
			if(!empty($_REQUEST["date_s"]) || !empty($_REQUEST["date_e"])){
				$date_st = explode("/",$_REQUEST["date_s"]);
				$date_en = explode("/",$_REQUEST["date_e"]);
				$date_1 = ($date_st[2])."-".$date_st[1]."-".$date_st[0];
				$date_2 = ($date_en[2])."-".$date_en[1]."-".$date_en[0];
				if(!empty($_REQUEST["date_s"]) && !empty($_REQUEST["date_e"])){
				$sql_search .= "  AND (n_date  between   '".$date_1."' and '".$date_2."' ) ";
				}else if(!empty($_REQUEST["date_s"]) && empty($_REQUEST["date_e"])){
				$sql_search .= "  AND (n_date  between   '".$date_1."' and '".$date_1."' ) ";
				}else if(empty($_REQUEST["date_s"]) && !empty($_REQUEST["date_e"])){
				$sql_search .= "  AND (n_date  between   '".$date_2."' and '".$date_2."' ) ";
				}
			}
		if($seld == ''){
		$seld = '1=1';
		}	
		$sql_search .= "and ".$seld." ORDER BY article_list.n_date DESC,article_list.n_timestamp DESC ";
		
	}elseif($search_mode == "3"){
		$sql_search = "SELECT gallery_category.category_id,gallery_category.category_name,gallery_image.img_id,gallery_image.img_name,gallery_image.img_detail,gallery_image.img_path_s FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id INNER JOIN gallery_category ON gallery_cat_img.category_id = gallery_category.category_id WHERE ".$seld." ORDER BY gallery_image.img_update DESC ";
	}elseif($search_mode == "4"){
		$sql_search = "SELECT DISTINCT(w_question.t_id),w_question.t_name, w_question.t_detail,w_cate.c_id,w_cate.c_name, w_question.keyword, w_question.q_name, w_question.t_date FROM w_question INNER JOIN w_cate ON w_question.c_id = w_cate.c_id LEFT JOIN w_answer ON w_question.t_id = w_answer.t_id AND w_answer.s_id = '1' WHERE w_cate.c_use = 'Y' AND w_question.s_id = '1' AND ( ".$seld." ) ORDER BY w_question.t_id DESC  ";
	}elseif($search_mode == "5"){
		$sql_search = "SELECT f_subcat.f_subcate,faq.fa_id,faq.fa_name,faq.fa_detail,faq.fa_ans FROM faq INNER JOIN f_subcat ON f_subcat.f_sub_id = faq.f_sub_id AND f_subcat.f_use = 'Y' WHERE  faq.faq_use='Y' AND ( ".$seld." ) ORDER BY faq.faq_top DESC,faq.faq_date DESC  ";
	}
 $query_search = $db->query($sql_search);
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    	
	 $totalrows = $db->db_num_rows($query_search);

	// Set $begin and $end to record range of the current page 
 $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
	 $sql_search .= " LIMIT $offset, $limit ";
	 
	 //echo  $sql_search;
	$query_search = $db->query($sql_search);
	
  ?>
            
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td align="left" > <hr width="100%">
      <?php
		if($word_b != ""){
			echo "คำใกล้เคียง : <a href=\"javascript:ajax_search_word('".trim($word_ah)."')\">".$word_a."</a>";
		}
		if($word_n != ""){
			$txtn = "";
			$countnext = explode(",",$word_n);
			$cn = count($countnext);
			for($n=0;$n<$cn;$n++){
				if(trim($countnext[$n]) != ""){
					$txtn .= " <a href=\"javascript:ajax_search_word('".trim($countnext[$n])."')\">".trim($countnext[$n])."</a> ";
				}
			}
			if($txtn != ""){
				echo "<div>คำคล้าย : ".$txtn."</div>";
			}
		}
		if($word_d != ""){
			$txtd = "";
			$countnext = explode(",",$word_d);
			$cn = count($countnext);
			for($n=0;$n<$cn;$n++){
				if(trim($countnext[$n]) != ""){
					$txtd .= " <a href=\"search_result.php?oper=".$oper."&search_mode=".$search_mode."&filename=".$filename."&keyword=".trim($countnext[$n])."\">".trim($countnext[$n])."</a> ";
				}
			}
			if($txtd != ""){
				echo "<div>คำตรงข้าม : ".$txtd."</div>";
			}
		}
				?>
    </td>
  </tr>
<?php if($totalrows > 0){ ?>
  <tr> 
    <td align="left" >รายการที่ <strong><?php echo $offset + 1; ?> 
      - <?php if($totalrows < ($offset + $limit)  ){ echo number_format($totalrows,0); }else{ echo $offset + $limit; } ?></strong> จากผลการค้นหาทั้งหมด <strong><?php echo number_format($totalrows,0); ?></strong> 
      รายการของคำค้น <strong><?php echo $data_default; ?> <?php if(!empty($_REQUEST["date_s"]) && !empty($_REQUEST["date_e"])){ echo '[ตั้งแต่วันที่  '.$_REQUEST["date_s"].'  ถึงวันที่'.$_REQUEST["date_e"].']';}?><hr width="100%"></td>
  </tr>
  <?php 
				}
			  if($db->db_num_rows($query_search)){ 
			  if($search_mode == "1"){ //web
			  while($R=$db->db_fetch_array($query_search)){ 
			  
					$filename1 = $R[filename];
					$filename2 = $R[filename];
					for($q = 0;$q<$num;$q++){
					$pos1 = @strpos($R[cms_keyword], $dt[$q]);
						if (!($pos1 === false)) {
							$pos = $pos1;
						}
					}
					
							if (!($pos === false)) { // note: three equal signs
							$pos1 = $pos - 100;
							if($pos1 < 0){
							$pos1 = 0;
							}
								 $rest = substr($R[cms_keyword], $pos1, 200);
								 $rest = htmlspecialchars($rest,ENT_QUOTES);
										for($q = 0;$q<$num;$q++){
																		if($dt[$q] != ""){
																		$rest = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $rest);
																		$filename1 = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $filename1);
																		}
										}
					}
	?>
  <tr> 
    <td bgcolor="#F3F3F3"></td>
  </tr>
  <tr> 
    <td><a href="search_open.php?filename=<?php echo $filename2; ?>&keyword=<?php echo $keyword; ?>" target="_blank"><b><?php if($R[title] != ""){ echo $R[title]; }else{ echo $filename1; } ?></b></a></td>
  </tr>
  <tr> 
    <td>...<?php echo stripslashes($rest); ?>...</td>
  </tr>
  <tr> 
    <td height="15">&nbsp;</td>
  </tr>
  <?php }}elseif($search_mode == "2"){ //article
			  while($R=$db->db_fetch_array($query_search)){ 
			  if(chk_permission_article($R["c_id"]) == true){
			  $topic = $R[n_topic];
			  $date = explode("-",$R["n_date"]);  
			  $date =  number_format($date[2],0)." ".$monthname[number_format($date[1],0)]." ".$date[0];
			  if($lang_shw != ''){
			  $topic = $R[lang_detail];
			  $date = explode("-",$R["n_date"]);  
			  $date =  number_format($date[2],0)."/ ".number_format($date[1],0)." /".($date[0]-543);
			  $R["link_html"] = select_lang_detail($R["n_id"],$lang_shw,'link_html','article_list');
			  }
					for($q = 0;$q<$num;$q++){
					$pos1 = @strpos($R[n_des], $dt[$q]);
						if (!($pos1 === false)) {
							$pos = $pos1;
						}
					}
					
							if ($pos != false) { // note: three equal signs
							$pos1 = $pos - 100;
							if($pos1 < 0){
							$pos1 = 0;
							}
								 $rest = substr($R[n_des], $pos1, 200);
								 $rest = htmlspecialchars($rest,ENT_QUOTES);
										for($q = 0;$q<$num;$q++){
																		if($dt[$q] != ""){
																		$rest = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $rest);
																		$topic = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $topic);
																		}
										}
					}else{
					$rest = htmlspecialchars($R[n_des],ENT_QUOTES);
					}
	?>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr> 
    <td width="80" valign="top"><?php
	if(($R[picture] != "") AND (file_exists("images/article/news".$R[n_id]."/t".$R[picture]))){
	?><table width="80" height="80" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">
												<tr>
												  <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="phpThumb.php?src=<?php echo "images/article/news".$R[n_id]."/t".$R[picture]; ?>&h=80&w=80" border="0" hspace="0" vspace="0" >
												  </td>
												</tr>
											  </table><?php } ?></td>
    <td valign="top"><b><?php if($R["news_use"] == "2"){
								echo "<a href=\"ewt_news.php?nid=".$R["n_id"]."&filename=".$_GET["filename"]."\" target=\"_blank\">";
							}elseif($R["news_use"] == "4"){
								echo "<a href=\"ewt_dl.php?nid=".$R["n_id"]."\" target=\"_blank\">";
							}else{
								//echo "<a href=\"".$R["link_html"]."\" target=\"_blank\">";
								echo "<a href=\"ewt_dl_link.php?nid=".$R["n_id"]."\" target=\"".$R["target"]."\"><b>";
							}
						$keyword=$_REQUEST['keyword'];
						$exKeyword=explode(' ', $keyword);
						$sizeKeyword=sizeof($exKeyword);
						for($i=0; $i<$sizeKeyword; $i++) {
							$totalMatch=substr_count($topic, $exKeyword[$i]);
							for($o=0; $o<$totalMatch; $o++) {
								$kwSPos=strpos($topic, $_REQUEST['keyword']);
								$kwEPos=strlen($_REQUEST['keyword']);
								$lTopic=substr($topic,0,$kwSPos);
								$cTopic=substr($topic,$kwSPos,$kwEPos);
								$rTopic=substr($topic,$kwSPos+$kwEPos);
								//echo $totalMatch;
								echo $lTopic.'<span style="color:red; font-style:italic; font-weight:600;">'.$cTopic.'</span>';
								$topic=$rTopic;
							}
						}
						echo $topic;
						echo "</a>"; ?></b>
						<div>หมวด : <?php 
						if($lang_shw != ''){
						echo select_lang_detail($R["c_id"],$lang_shw,'c_name','article_group');
						}else{
						echo $R[c_name]; 
						} ?></div>
						<div><span style="FONT: 11px 'Tahoma';color:#888888"><?php echo $date; ?></span></div>
						<div><?php if($rest != ""){ echo "...".stripslashes($rest)."..."; } ?></div></td>
  </tr>
</table></td>
  </tr>
  <?php }}}elseif($search_mode == "3"){ //img
			  while($R=$db->db_fetch_array($query_search)){ 
			  $topic = $R[img_name];
					for($q = 0;$q<$num;$q++){
					$pos1 = @strpos($R[img_detail], $dt[$q]);
						if (!($pos1 === false)) {
							$pos = $pos1;
						}
					}
					
							if ($pos != false) { // note: three equal signs
							$pos1 = $pos - 100;
							if($pos1 < 0){
							$pos1 = 0;
							}
								 $rest = substr($R[img_detail], $pos1, 200);
					//			 $rest = htmlspecialchars($rest,ENT_QUOTES);
										for($q = 0;$q<$num;$q++){
																		if($dt[$q] != ""){
																		$rest = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $rest);
																		$topic = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $topic);
																		}
										}
					}else{
					$rest = htmlspecialchars($R[img_detail],ENT_QUOTES);
					}
	?>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr> 
    <td width="100" valign="top">
	<table width="100" height="100" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">
												<tr>
												  <td align="center" valign="middle" bgcolor="#FFFFFF"><a href="gallery_view_img_comment.php?category_id=<?php echo $R[category_id]; ?>&filename=index&img_id=<?php echo $R[img_id]; ?>"   target="_blank"><img src="phpThumb.php?src=<?php echo $R[img_path_s]; ?>&h=100&w=100" border="0" hspace="0" vspace="0" ></a>
												  </td>
												</tr>
											  </table></td>
    <td valign="top"><b><a href="gallery_view_img_comment.php?category_id=<?php echo $R[category_id]; ?>&filename=index&img_id=<?php echo $R[img_id]; ?>"   target="_blank"><?php echo $topic; ?></a></b>
						<div>หมวด : <?php echo $R[category_name]; ?></div>
						<div><?php if($rest != ""){ echo "...".stripslashes($rest)."..."; } ?></div></td>
  </tr>
</table></td>
  </tr>
  <?php }}elseif($search_mode == "4"){ //webboard
			  while($R=$db->db_fetch_array($query_search)){ 
			  $topic = $R[t_name];
					for($q = 0;$q<$num;$q++){
					$pos1 = @strpos(cuttag($R[t_detail]), $dt[$q]);
						if (!($pos1 === false)) {
							$pos = $pos1;
						}
					}
			
							if ($pos != false) { // note: three equal signs
							$pos1 = $pos - 100;
							if($pos1 < 0){
							$pos1 = 0;
							}
								 $rest = substr(cuttag($R[t_detail]), $pos1, 200);
								 $rest = ereg_replace("<br>"," ",$rest);
								// $rest = htmlspecialchars($rest,ENT_QUOTES);
										for($q = 0;$q<$num;$q++){
																		if($dt[$q] != ""){
																		$rest = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $rest);
																		$topic = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $topic);
																		}
										}
					}else{
					$sql_ans = $db->query("SELECT a_detail FROM w_answer WHERE s_id = '1' AND t_id = '$R[t_id]' ORDER BY a_id ASC ");
					$tag = "";
						while($A=$db->db_fetch_row($sql_ans)){
							$tag .= cuttag($A[0])." ... ";
						}
					for($q = 0;$q<$num;$q++){
					$pos1 = @strpos($tag, $dt[$q]);
						if (!($pos1 === false)) {
							$pos = $pos1;
						}
					}
							$pos1 = $pos - 100;
							if($pos1 < 0){
							$pos1 = 0;
							}
								$rest = substr($tag, $pos1, 200);
								 $rest = htmlspecialchars($rest,ENT_QUOTES);
										for($q = 0;$q<$num;$q++){
																		if($dt[$q] != ""){
																		$rest = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $rest);
																		$topic = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $topic);
																		}
										}
					}
	?>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr> 
    <td width="1" valign="top">
	<?php if($R[keyword] == "x"){ 
	if((eregi(".jpg", $R[keyword])) OR (eregi(".jpeg", $R[keyword])) OR (eregi(".gif", $R[keyword])) OR (eregi(".png", $R[keyword]))) {
	?>
	<table width="100" height="100" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">
												<tr>
												  <td align="center" valign="middle" bgcolor="#FFFFFF"><a href="index_answer.php?wcad=<?php echo $R[c_id]; ?>&wtid=<?php echo $R[t_id]; ?>"   target="_blank"><img src="phpThumb.php?src=userpic/<?php echo $R[keyword]; ?>&h=100&w=100" border="0" hspace="0" vspace="0" ></a>
												  </td>
												</tr>
											  </table><?php }} ?></td>
    <td valign="top"><b><a href="index_answer.php?wcad=<?php echo $R[c_id]; ?>&wtid=<?php echo $R[t_id]; ?>"   target="_blank"><?php echo $topic; ?></a></b>
						<div><?php if($rest != ""){ echo "...".stripslashes($rest)."..."; } ?></div>
						<div>โดย : <?php echo $R["q_name"]; ?> (<?php $date = explode("-",$R["t_date"]); echo $date[2]."/".$date[1]."/".$date[0]; ?>)</div>
						<div>หมวด : <?php echo $R[c_name]; ?></div>
						</td>
  </tr>
</table></td>
  </tr>
  <?php }}elseif($search_mode == "5"){ //article
			  while($R=$db->db_fetch_array($query_search)){ 
			  $topic = $R[fa_name];
			  $detail = $R[fa_detail];
					for($q = 0;$q<$num;$q++){
					$pos1 = @strpos($R[fa_ans], $dt[$q]);
						if (!($pos1 === false)) {
							$pos = $pos1;
						}
					}
					
							if ($pos != false) { // note: three equal signs
							$pos1 = $pos - 100;
							if($pos1 < 0){
							$pos1 = 0;
							}
								 $rest = substr($R[fa_ans], $pos1, 200);
								// $rest = htmlspecialchars($rest,ENT_QUOTES);
										for($q = 0;$q<$num;$q++){
																		if($dt[$q] != ""){
																		$rest = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $rest);
																		$topic = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $topic);
																		$detail = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $detail);
																		}
										}
					}else{
					$rest = htmlspecialchars($R[fa_ans],ENT_QUOTES);
					}
	?>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr> 
    <td valign="top"><b><a href="#view" onClick="c=window.open('faq_open_word.php?fa_id=<?php echo $R[fa_id]; ?>','showass','scrollbars=yes,width=650,height=450');c.focus();"><?php echo $topic;  ?></a></b>
						<div><?php echo $detail; ?></div>
						
            <div>หมวด : <?php echo $R[f_cate]; ?>  &gt;&gt; <?php echo $R[f_subcate]; ?></div>
						<div><?php if($rest != ""){ echo "...".stripslashes($rest)."..."; } ?></div></td>
  </tr>
</table></td>
  </tr>
  <?php }} ?>
  <tr> 
    <td align="center"> <table  border="0" cellpadding="1" cellspacing="0">
        <tr valign="bottom"> 
          <td width="120" align="right"><font size="2" face="MS Sans Serif"><strong>ผลการค้นหาหน้าที่:</strong></font></td>
          <td align="center" ><font size="2" face="MS Sans Serif"> 
            <?php if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='search_result.php?offset=$prevoffset&keyword=$keyword&".$sh_date."oper=$oper&search_mode=$search_mode&filename=$filename&p=".(($offset/$limit)-1)."&g=$g'>
ย้อนกลับ</a> ";
}
     ?>
            </font></td>
          <?php

    // Calculate total number of pages in result 
   $pages = intval($totalrows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($totalrows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     $current = ($offset/$limit) - 1;
	 $start = $current - 10;
	 if($start < 1){
	 $start = 1;
	 }
	 $end = $current + 10;
	 	 if($end > $pages){
	 $end = $pages;
	 }
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=$start;$i<=$end;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<td align=\"center\" width=16><font size=\"2\" face=\"MS Sans Serif\"><b>$i</b></font></td>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<td align=\"center\" width=16><a href='search_result.php?offset=$newoffset&keyword=$keyword&".$sh_date."oper=$oper&search_mode=$search_mode&filename=$filename&p=".$i."&g=$g'><font size=\"2\" face=\"MS Sans Serif\">$i</font></a></td>"; 
        } 
    } 

?></font>
          <td width="65" align="center"><font size="2" face="MS Sans Serif"> 
            <?php 
			if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='search_result.php?offset=$newoffset&keyword=$keyword&".$sh_date."oper=$oper&search_mode=$search_mode&filename=$filename&p=".(($offset/$limit)+1)."&g=$g'>ถัดไป</a>"; 
    } 
			  }//if?>
            </font></td>
        </tr>
      </table></td>
  </tr>
  <?php
	}else{
	?>
  <tr> 
    <td><br> <font size="2" face="MS Sans Serif">ผลการค้นหา - <?php echo $keyword; ?> 
      - ไม่ตรงกับเอกสารใดเลย <br>
      คำแนะนำ:<br>

      - ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br>
      - ลองคำหลักที่ต่างจากนี้<br>
      - ลองใช้คำหลักทั่วๆไป<br>
      - ลองใช้คำให้น้อยลง</font><br> <br> </td>
  </tr>
  <?php
	} ?>
  <tr> 
    <td bgcolor="#666666" height="1"></td>
  </tr>
</table>
            <?php }} ?>
			<?php $db->db_close(); ?>