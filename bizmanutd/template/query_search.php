<?php
//query_search.php

				if($_SERVER["REMOTE_ADDR"]){
						$ip_address = $_SERVER["REMOTE_ADDR"];
					}else{
						$ip_address = $_SERVER["REMOTE_HOST"];
					}
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
		$db->query("USE datawarehouse");
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
			$db->query("USE datawarehouse");
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
			$db->query("USE datawarehouse");
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
	///=======================================================/
function phrase($key){
//case phrase
$data = explode('&quot;',$key);
return $data[1];
}
function allword($key){
//case all word
$data = explode(' ',$key);
	for($i=0;$i<count($data);$i++){
		$pos = strpos($data[$i], "&quot;");
		$pos2 = strpos($data[$i], "-");
		$pos3 = strpos($data[$i], "government:");
		$pos4 = strpos($data[$i], "year:");
		$pos5 = strpos($data[$i], "time:");
		$pos6 = strpos($data[$i], "session:");
		$pos7 = strpos($data[$i], "filetype:");
		$pos8 = strpos($data[$i], "doctype:");
		if ($pos === false and $pos2 === false and  $pos3 === false and  $pos4 === false and $pos5 === false and $pos6 === false and  $pos7 === false and  $pos8 === false) {
		$word .= ' '.$data[$i];
		}
	}
	return $word;
}
function orword($key){
//case or word
}
function noword($key){
//case no word
$data = explode(' ',$key);
	for($i=0;$i<count($data);$i++){
		$pos = strpos($data[$i], "-");
		if (!($pos === false)) {
		$word .= ' '.$data[$i];
		}
	}
	return $word;

}
function gover($key){
//case ชุดที่
$data = explode(' ',$key);
	for($i=0;$i<count($data);$i++){
		$pos = strpos($data[$i], "government:");
		if (!($pos === false)) {
		$word .= ' '.$data[$i];
		}
	}
	return $word;
}
function year($key){
//case ปีที่
$data = explode(' ',$key);
	for($i=0;$i<count($data);$i++){
		$pos = strpos($data[$i], "year:");
		if (!($pos === false)) {
		$word .= ' '.$data[$i];
		}
	}
	return $word;
}
function stime($key){
//case ครั้งที่
$data = explode(' ',$key);
	for($i=0;$i<count($data);$i++){
		$pos = strpos($data[$i], "time:");
		if (!($pos === false)) {
		$word .= ' '.$data[$i];
		}
	}
	return $word;
}
function session($key){
//case สมัยที่
$data = explode(' ',$key);
	for($i=0;$i<count($data);$i++){
		$pos = strpos($data[$i], "session:");
		if (!($pos === false)) {
		$word .= ' '.$data[$i];
		}
	}
	return $word;
}
function sfiletype($key){
//case ประเภทไฟล์เอกสาร
$data = explode(' ',$key);
	for($i=0;$i<count($data);$i++){
		$pos = strpos($data[$i], "filetype:");
		if (!($pos === false)) {
		$word .= ' '.$data[$i];
		}
	}
	return $word;
}
function type($key){
//case ประเภทไฟล์เอกสาร
$data = explode(' ',$key);
	for($i=0;$i<count($data);$i++){
		$pos = strpos($data[$i], "doctype:");
		if (!($pos === false)) {
		$word .= ' '.$data[$i];
		}
	}
	return $word;
}
if(trim($_REQUEST["keyword"]) != ''){
$type_p = array();//วลี
$type_a = array();//ทุกๆคำ
$type_o = array();//อย่างน้อย
$type_n = array();//เก็บ keyword ต่างๆ

$data_default = stripslashes(htmlspecialchars(trim($_REQUEST["keyword"]),ENT_QUOTES));

$data_phrase = phrase($data_default);//หาคำที่เป็นวลี
$data_allword = allword($data_default);//หาทุกคำ
$data_noword = noword($data_default);//คำที่ไม่มี
$data_gover = gover($data_default);//ชุดที่
$data_year = year($data_default);//ปีที่
$data_time = stime($data_default);//ครั้งที่
$data_session = session($data_default);//สมัยที่
$data_filetype = sfiletype($data_default);//ประเภทไฟล์เอกสาร
$data_type = type($data_default);//ประเภทไฟล์เอกสาร
//เริ่มเขียน query
//หาทุกคำ และ บางคำ==================================================================
	if($data_allword != ''){
		//ตัดที่เป็น OR ออกไปก่อน
		//echo $data_allword;
		$word = explode('OR',$data_allword);
		//print_r($word);
		$wordall = $word[0];//กลุ่มคำที่เป็นเงื่อนไข all
		for($o=1;$o<count($word);$o++){$wordor .= $word[$o];}//กลุ่มคำที่เป็นเงื่อนไข OR
		//หาทุกคำ========================================================================
		if($wordall != ''){//เริ่มเขียน query แล้ว
			$wordall = str_replace('+',' ',$wordall);//ทำให้ + เป็นค่าว่างซะ
			$wordall = str_replace('*',' ',$wordall);//ทำให้ * เป็นค่าว่างซะ
			$dt = explode(" ",$wordall);//แบ่งเป็นคำๆแล้ว
			for($i=0;$i<count($dt);$i++){
			$WA = trim($dt[$i]);
			array_push($type_n,$WA);
				if($WA != ""){
					$check = like_word($WA);
					$word_n .= ",".next_word($WA);
					$word_d .= ",".diff_word($WA);
					$word_b .= $check." ";
					if($check != ""){
						$word_a .= $check;
						$word_ah .= $check." ";
					}else{
						$word_a .= $WA." ";
						$word_ah .= $WA." ";
					}
				
				$oper_wordall = ' AND';
				$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$WA','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
				$seld_wordall .= " ( data_wh.name REGEXP  '$WA'  OR data_wh.detail REGEXP  '$WA'  OR data_wh.fulltextt REGEXP  '$WA' )".$oper_wordall;
				}
			}
		$summ_wordall = strlen($oper_wordall);
		$seld_wordall = substr($seld_wordall,0,-$summ_wordall);
		}
		//ENDหาทุกคำ========================================================================
		//หาบางคำ========================================================================
		if($wordor != ''){//เริ่มเขียน query แล้ว
			$wordor = str_replace('+',' ',$wordor);//ทำให้ + เป็นค่าว่างซะ
			$wordor = str_replace('*',' ',$wordor);//ทำให้ * เป็นค่าว่างซะ
			$dor = explode(" ",$wordor);//แบ่งเป็นคำๆแล้ว
			for($i=0;$i<count($dor);$i++){
			$WOR = trim($dor[$i]);
			array_push($type_n,$WOR);
				if($WOR != ""){
					$check = like_word($WOR);
					$word_n .= ",".next_word($WOR);
					$word_d .= ",".diff_word($WOR);
					$word_b .= $check." ";
					if($check != ""){
						$word_a .= $check;
						$word_ah .= $check." ";
					}else{
						$word_a .= $WOR." ";
						$word_ah .= $WOR." ";
					}
				
				$oper_wordor = ' OR';
				$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$WOR','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
				$seld_wordor .= " ( data_wh.name REGEXP  '$WOR'  OR data_wh.detail REGEXP  '$WOR'  OR data_wh.fulltextt REGEXP  '$WOR' )".$oper_wordor;
				}
			}
		$summ_wordor = strlen($oper_wordor);
		$seld_wordor = substr($seld_wordor,0,-$summ_wordor);
		}
		//ENDหาบางคำ========================================================================
		//นำทั้ง 2 query มาต่อกันให้เป็นรูปประโยคที่สมบูรณ์
		if($seld_wordall != ''){
		$seldwordA .= "(".$seld_wordall.') AND ';
		}
		if($seld_wordor != ''){
		$seldwordA .= '('.$seld_wordor.') OR ';
		}
		$summ_wordor = strlen(' OR ');
		$seldwordA = substr($seldwordA,0,-$summ_wordor);
	}
//ENDหาทุกคำ และ บางคำ========================================================================
//เริ่มหาวลี===================================================================================
if($data_phrase != ''){
//เริ่มต้นแล้วนะ
			$wordphrase = str_replace('+',' ',$data_phrase);//ทำให้ + เป็นค่าว่างซะ
			$wordphrase = str_replace('*',' ',$wordphrase);//ทำให้ * เป็นค่าว่างซะ
			$wordphrase = str_replace('-',' ',$wordphrase);//ทำให้ - เป็นค่าว่างซะ
			
			if($wordphrase != ''){
				/*$dp = explode(' ',$wordphrase);
				for($i=0;$i<count($dp);$i++){
					$WOP = trim($dp[$i]);
					array_push($type_n,$WOP);
						if($WOP != ""){
							$check = like_word($WOP);
							$word_n .= ",".next_word($WOP);
							$word_d .= ",".diff_word($WOP);
							$word_b .= $check." ";
								if($check != ""){
									$word_a .= $check;
									$word_ah .= $check." ";
								}else{
									$word_a .= $WOP." ";
									$word_ah .= $WOP." ";
								}
					
					$oper_wordp = ' AND';
					$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$WOR','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
					$seld_wordp .= " ( data_wh.name LIKE  '$WOP'  OR data_wh.detail LIKE  '$WOP'  OR data_wh.fulltextt LIKE  '$WOP' )".$oper_wordp;
					}
				}*/
				array_push($type_n,$wordphrase);
				
				$oper_wordp = ' AND';
				$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$wordphrase','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
				$seld_wordp .= " ( data_wh.name LIKE  '%$wordphrase%'  OR data_wh.detail LIKE  '%$wordphrase%'  OR data_wh.fulltextt LIKE  '%$wordphrase%' )".$oper_wordp;
				$summ_wordp= strlen($oper_wordp);
				$seld_wordB = " (".substr($seld_wordp,0,-$summ_wordp).")";
			}
}
//ENDจบการหาวลี==============================================================================

//เริ่มหาคำที่ไม่มี==============================================================================
if($data_noword != ''){
//เริ่มต้นแล้วนะ
			$wordnoword = str_replace('+',' ',$data_noword);//ทำให้ + เป็นค่าว่างซะ
			$wordnoword = str_replace('*',' ',$wordnoword);//ทำให้ * เป็นค่าว่างซะ
			$wordnoword = str_replace('-',' ',$wordnoword);//ทำให้ - เป็นค่าว่างซะ
			
			if($wordnoword != ''){
				$dn = explode(' ',$wordnoword);
				for($i=0;$i<count($dn);$i++){
					$WON = trim($dn[$i]);
					array_push($type_n,$WON);
						if($WON != ""){
							$check = like_word($WON);
							$word_n .= ",".next_word($WON);
							$word_d .= ",".diff_word($WON);
							$word_b .= $check." ";
								if($check != ""){
									$word_a .= $check;
									$word_ah .= $check." ";
								}else{
									$word_a .= $WON." ";
									$word_ah .= $WON." ";
								}
					
					$oper_wordn = ' AND';
					$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$WON','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
					$seld_wordn .= " ( data_wh.name NOT LIKE  '%$WON%'  AND data_wh.detail NOT LIKE  '%$WON%'  AND data_wh.fulltextt NOT LIKE  '%$WON%' )".$oper_wordn;
					}
				}
				$summ_wordn= strlen($oper_wordn);
				$seld_wordC = "(".substr($seld_wordn,0,-$summ_wordn).")";
			}
}
//ENDจบการหาคำที่ไม่มี==========================================================================
//หาชุดรัฐบาล========================================================
if($data_gover != ''){
$dg = explode(':',$data_gover);
$nameW = "ชุดที่".$data_gover;
array_push($type_n,'government:'.$dg[1]);
$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$nameW','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
					$seld_wordD .= " ( data_wh.yearno LIKE  '$dg[1]' )";
}
//END การหาชุดรัฐบาล=================================================
//หาปีที่ของรัฐบาล========================================================
if($data_year != ''){
$dy = explode(':',$data_year);
$nameW = "ปีที่".data_year;
array_push($type_n,'year:'.$dy[1]);
$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$nameW','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
					$seld_wordE .= " ( data_wh.year LIKE  '$dy[1]' )";
}
//END การหาปีที่ของรัฐบาล=================================================
//หาครั้งที่ประชุม========================================================
if($data_time != ''){
$dti = explode(':',$data_time);
$nameW = "ครั้งที่".$data_time;
array_push($type_n,'time:'.$dti[1]);
$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$nameW','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
					$seld_wordF .= " ( data_wh.num LIKE '$dti[1]' )";
}
//END การหาครั้งที่ประชุม=================================================
//หาสมัยการประชุม========================================================
if($data_session != ''){
$ds = explode(':',$data_session);
$nameW = "สมัยที่".$data_time;
array_push($type_n,'session:'.$ds[1]);
$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$nameW','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
					$seld_wordG .= " ( data_wh.session_name LIKE  '$ds[1]' )";
}
//END การหาสมัยการประชุม=================================================
//ถึงอันที่ยากที่สุดแล้ว
//เริ่มเลยนะหาประเภทไฟล์===========================================================
if($data_filetype != ''){
$dfi = explode(':',$data_filetype);

$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$dfi[1]','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");
if($dfi[1] == 'pdf'){
$dfi[1] = 'application/pdf';
}else if($dfi[1] == 'xls'){
$dfi[1] = 'application/vnd.ms-excel';
}else if($dfi[1] == 'ppt'){
$dfi[1] = 'application/vnd.ms-powerpoint';
}else if($dfi[1] == 'doc'){
$dfi[1] = 'application/msword';
}else if($dfi[1] == 'html'){
$dfi[1] = 'text/html';
}else if($dfi[1] == 'mht'){
$dfi[1] = 'message/rfc822';
}else if($dfi[1] == 'txt'){
$dfi[1] = 'text/plain';
}
array_push($type_n,'filetype:'.$dfi[1]);

					$whH = "inner join attach_file on attach_file.attach_file_id = data_wh.path_file";
					$seld_wordH .= " ( attach_file.attach_filetype LIKE  '$dfi[1]' )";
}
//ENDหาประเภทไฟล์=====================================================
//เพิ่มมาใหม่ด้วยความคิดสร้างสรรค์ของ NS
//เริ่มเลยนะหาประเภทเอกสาร===========================================================
if($data_type != ''){
$dfi = explode(':',$data_type);

if($dfi[1] =='รายงานการประชุม'){
$dfi_used = '0';
}else if($dfi[1] =='บันทึกการประชุม'){
$dfi_used = '1';
}else if($dfi[1] =='บันทึกการออกเสียงลงคะแนน'){
$dfi_used = '2';
}else if($dfi[1] =='สรุปเหตุการณ์'){
$dfi_used = '3';
}
array_push($type_n,'doctype:'.$dfi_used);
$db->query("insert into stat_search (search_word,search_date,search_time,search_ip)  values ('$dfi[1]','".date("Y-m-d")."','".date("H:i:s")."','$ip_address') ");


					$whJ= "inner join attach_file on attach_file.attach_file_id = data_wh.path_file";
					$seld_wordJ.= " ( attach_file.status LIKE  '$dfi_used' )";
}
//ENDหาประเภทเอกสาร=====================================================
//print_r($type_n);
$oper_word = ' AND';
if($seldwordA != ''){
$seld .= $seldwordA.$oper_word;
}
if($seld_wordB != ''){
$seld .= $seld_wordB.$oper_word;
}
if($seld_wordC != ''){
$seld .= $seld_wordC.$oper_word;
}
if($seld_wordD != ''){
$seld .= $seld_wordD.$oper_word;
}
if($seld_wordE != ''){
$seld .= $seld_wordE.$oper_word;
}
if($seld_wordF != ''){
$seld .= $seld_wordF.$oper_word;
}
if($seld_wordG != ''){
$seld .= $seld_wordG.$oper_word;
}
if($seld_wordH != ''){
$wh = $whH;
$seld .= $seld_wordH.$oper_word;
}
if($seld_wordJ != ''){
$wh = $whJ;
$seld .= $seld_wordJ.$oper_word;
}
				$summ_word= strlen($oper_word);
				$seld = substr($seld,0,-$summ_word);

}
if($seld == ''){
$seld = '1=1';
}
//echo $seld;
?>