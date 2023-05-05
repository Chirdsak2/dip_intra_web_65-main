<?php
function set_lang_use($c_id,$lang_name,$module)
{
	global $db;
	$tb = "lang_".$module;

		$s_lang_detail = $db->query("SELECT lang_detail FROM {$tb} WHERE c_id = '{$c_id}' AND lang_name = '{$lang_name}'");
		$a_data = $db->db_fetch_array($s_lang_detail);
		$a_rows = $db->db_num_rows($s_lang_detail);

		if($a_rows){
			return true;	
		}else{	
			return false;
		}
}
function set_lang_use_ewt($c_id,$lang_name,$module)
{
	global $db;
	global $EWT_DB_NAME,$EWT_DB_USER;
		$tb = "lang_".$module;
		$db->query("USE ".$EWT_DB_USER);
		$s_lang_detail = $db->query("SELECT lang_detail FROM {$tb} WHERE c_id = '{$c_id}' AND lang_name = '{$lang_name}'");
		$a_data = $db->db_fetch_array($s_lang_detail);
		$a_rows = $db->db_num_rows($s_lang_detail);

		if($a_rows){
			return true;	
		}else{	
			return false;
		}
}
function show_icon_setlang($c_id,$module)
{
	global $db;
	global $EWT_FOLDER_USER;
	$Globals_Dir = '../ewt/'.$EWT_FOLDER_USER;
	$Globals_Dir1 = 'language';
	$tb = "lang_".$module;
	$sql = $db->query("SELECT lang_name FROM {$tb} WHERE c_id = '{$c_id}' GROUP BY lang_name ");
	while($rec = $db->db_fetch_array($sql)){
		$sql_lang = "SELECT lang_config_name,lang_config_id,lang_config_suffix,lang_config_img FROM lang_config WHERE lang_config_id = '{$rec['lang_name']}' ";
		$query = $db->query($sql_lang);
		$rec_db = $db->db_fetch_array($query);
		if($rec_db[lang_config_img]!=''){ 
		$text .= "<img src=".$Globals_Dir."/".$Globals_Dir1."/".$rec_db['lang_config_img']." border=\"0\" width=\"22px\" height=\"18px\" alt=".$rec_db[lang_config_suffix].">&nbsp;|&nbsp;";
		}else{
		
		$text .= $rec_db['lang_config_suffix']."&nbsp;|&nbsp;";
		}
	}
	return substr($text,0,(strlen($text)-7));
}

function show_icon_setlang_ewt($c_id,$module)
{
	global $db;
	global $EWT_FOLDER_USER;
	global $EWT_DB_NAME,$EWT_DB_USER;
	$Globals_Dir = '../ewt/'.$EWT_FOLDER_USER;
	$Globals_Dir1 = 'language';
	$tb = "lang_".$module;
	$db->query("USE ".$EWT_DB_USER);
	$sql = $db->query("SELECT lang_name FROM {$tb} WHERE c_id = '{$c_id}' GROUP BY lang_name ");
	while($rec = $db->db_fetch_array($sql)){
		$db->query("USE ".$EWT_DB_NAME);
		$sql_lang = "SELECT lang_config_name,lang_config_id,lang_config_suffix,lang_config_img FROM lang_config WHERE lang_config_id = '{$rec['lang_name']}' ";
		$query = $db->query($sql_lang);
		$rec_db = $db->db_fetch_array($query);
		if($rec_db[lang_config_img]!=''){ 
		$text .= "<img src=".$Globals_Dir."/".$Globals_Dir1."/".$rec_db['lang_config_img']." border=\"0\" width=\"22px\" height=\"18px\" alt=".$rec_db[lang_config_suffix].">&nbsp;|&nbsp;";
		}else{
		
		$text .= $rec_db['lang_config_suffix']."&nbsp;|&nbsp;";
		}
	}
	$db->query("USE ".$EWT_DB_USER);
	
	return substr($text,0,(strlen($text)-7));
}
function set_lang($c_id,$lang_name,$lang_field,$lang_detail,$module)
{
	global $db;
	$tb = "lang_".$module;
//delete data old
	$delete = "delete from $tb  where c_id = '".$c_id."' and lang_name = '".$lang_name."' and lang_field = '".$lang_field."' ";
	$db->query($delete);
//insert data new
	$insert = "insert into $tb (c_id,lang_name,lang_field,lang_detail) values ('".$c_id."','".$lang_name."','".$lang_field."','".$lang_detail."')";
	$db->query($insert);
	if($module ==  'article_list'){
		//update data keyword to main article list
		$sql_art_list = "select * from lang_article_list where lang_field ='keyword'  and c_id = '".$c_id."'";
		$query = $db->query($sql_art_list);
			while($R = $db->db_fetch_array($query)){
				$keyword .= "[#".$R[lang_name]."]".$R[lang_detail]."[#".$R[lang_name]."]";
			}
		$sql_art_list2 = "select keyword from article_list where  n_id = '".$c_id."' ";
		$query2 = $db->query($sql_art_list2);
		$R2 = $db->db_fetch_array($query2);
		$key = explode('[#',$R2[keyword]);
		$keyword = $key[0].$keyword;
		//update data
		$update = "update article_list set keyword = '".stripslashes(htmlspecialchars($keyword,ENT_QUOTES))."' where  n_id = '".$c_id."' ";
		$db->query($update);
	}
}

function set_lang_ewt($c_id,$lang_name,$lang_field,$lang_detail,$module)
{
	global $db;
	global $EWT_DB_NAME,$EWT_DB_USER;
	$tb = "lang_".$module;
	
//delete data old
	$db->query("USE ".$EWT_DB_USER);
	$delete = "delete from {$tb}  where c_id = '".$c_id."' and lang_name = '".$lang_name."' and lang_field = '".$lang_field."' ";
	$db->query($delete);
//insert data new
	$insert = "insert into {$tb} (c_id,lang_name,lang_field,lang_detail) values ('".$c_id."','".$lang_name."','".$lang_field."','".$lang_detail."')";
	$db->query($insert);
}

function select_lang_detail($c_id,$lang_name,$lang_field,$module)
{
	global $db;
	$tb = "lang_".$module;
	$sql = $db->query("SELECT lang_detail FROM {$tb} WHERE c_id = '{$c_id}' AND lang_name = '{$lang_name}' AND lang_field = '{$lang_field}' ");
	$rec = $db->db_fetch_array($sql);
	return stripslashes(htmlspecialchars($rec['lang_detail'],ENT_QUOTES));
}

function select_lang_detail_withslash($c_id,$lang_name,$lang_field,$module)
{
	global $db;
	$tb = "lang_".$module;
	$sql = $db->query("SELECT lang_detail FROM {$tb} WHERE c_id = '{$c_id}' AND lang_name = '{$lang_name}' AND lang_field = '{$lang_field}' ");
	$rec = $db->db_fetch_array($sql);
	return htmlspecialchars($rec['lang_detail'],ENT_QUOTES);
}

function select_lang_detail_ewt($c_id,$lang_name,$lang_field,$module)
{
	global $db;
	global $EWT_DB_NAME,$EWT_DB_USER;
	$tb = "lang_".$module;
	$db->query("USE ".$EWT_DB_USER);
	$sql = $db->query("SELECT lang_detail FROM {$tb} WHERE c_id = '{$c_id}' AND lang_name = '{$lang_name}' AND lang_field = '{$lang_field}' ");
	$rec = $db->db_fetch_array($sql);
	return stripslashes(htmlspecialchars($rec['lang_detail'],ENT_QUOTES));
}
	
function show_icon_lang($c_id,$module)
{
	global $db;
	global $EWT_FOLDER_USER;
	$Globals_Dir = '../ewt/'.$EWT_FOLDER_USER;
	$Globals_Dir1 = 'language';
	$tb = "lang_".$module;
	$sql = $db->query("SELECT lang_name FROM {$tb} WHERE c_id = '{$c_id}' GROUP BY lang_name ");
	while($rec = $db->db_fetch_array($sql)){
		$sql_lang = "SELECT lang_config_name,lang_config_id,lang_config_suffix,lang_config_img FROM lang_config WHERE lang_config_id = '{$rec['lang_name']}' ";
		$query = $db->query($sql_lang);
		$rec_db = $db->db_fetch_array($query);
		if($rec_db['lang_config_img']!=''){	
		//$text .= "<a title=\"".$rec_db['lang_config_name']."\"  onClick=\"txt_data1('".$c_id."','".$rec_db['lang_config_id']."','".$rec_db['lang_config_suffix']."')\">";
		//$text .= "<button type=\"button\" class=\"btn btn-default btn-sm\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\" >";
        //$text .= "<img  src=\"".$Globals_Dir."/".$Globals_Dir1."/".$rec_db['lang_config_img']."\" border=\"0\" width=\"22px\" height=\"18px\" alt=\"".$rec_db['lang_config_suffix']."\>";
		//$text .= "</button>";
		//$text .= "</a>";
	
		$text .= "<a data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\" onClick=\"txt_data1('".$c_id."','".$rec_db['lang_config_id']."','".$rec_db['lang_config_suffix']."')\"><img src=\"".$Globals_Dir."/".$Globals_Dir1."/".$rec_db['lang_config_img']."\" _style=\"border: 2px solid #d5d9e0;border-radius: 6px;\" class=\"pointer img-thumbnail\" border=\"0\" width=\"30px\" height=\"18px\" alt=\"".$rec_db['lang_config_suffix']."\"></a>";
		}else{		
		$text .= "<a data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\" onClick=\"txt_data1('".$c_id."','".$rec_db['lang_config_id']."','".$rec_db['lang_config_suffix']."')\">".$rec_db['lang_config_suffix']."</a>&nbsp;|&nbsp;";
		}
	}
	//return substr($text,0,(strlen($text)-7));
	return $text;
}

function show_icon_lang_ewt($c_id,$module){
	global $db;
	global $EWT_FOLDER_USER;
	global $EWT_DB_NAME,$EWT_DB_USER;
	$Globals_Dir = '../ewt/'.$EWT_FOLDER_USER;
	$Globals_Dir1 = 'language';
	$tb = "lang_".$module;
	$db->query("USE ".$EWT_DB_USER);
	$sql = $db->query("SELECT lang_name FROM {$tb} WHERE c_id = '{$c_id}' GROUP BY lang_name ");
	while($rec = $db->db_fetch_array($sql)){
		$db->query("USE ".$EWT_DB_NAME);
		$sql_lang = "SELECT lang_config_name,lang_config_id,lang_config_suffix,lang_config_img FROM lang_config WHERE lang_config_id = '{$rec['lang_name']}' ";
		$query = $db->query($sql_lang);
		$rec_db = $db->db_fetch_array($query);
		if($rec_db['lang_config_img']!=''){	
		//$text .= "<a title=\"".$rec_db['lang_config_name']."\"  onClick=\"txt_data1('".$c_id."','".$rec_db['lang_config_id']."','".$rec_db['lang_config_suffix']."')\">";
		//$text .= "<button type=\"button\" class=\"btn btn-default btn-sm\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\" >";
        //$text .= "<img  src=\"".$Globals_Dir."/".$Globals_Dir1."/".$rec_db['lang_config_img']."\" border=\"0\" width=\"22px\" height=\"18px\" alt=\"".$rec_db['lang_config_suffix']."\>";
		//$text .= "</button>";
		//$text .= "</a>";
	
		$text .= "<a data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\" onClick=\"txt_data1('".$c_id."','".$rec_db['lang_config_id']."','".$rec_db['lang_config_suffix']."')\"><img src=\"".$Globals_Dir."/".$Globals_Dir1."/".$rec_db['lang_config_img']."\" _style=\"border: 2px solid #d5d9e0;border-radius: 6px;\" class=\"pointer img-thumbnail\" border=\"0\" width=\"30px\" height=\"18px\" alt=\"".$rec_db['lang_config_suffix']."\"></a>";
		}else{		
		$text .= "<a data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\" onClick=\"txt_data1('".$c_id."','".$rec_db['lang_config_id']."','".$rec_db['lang_config_suffix']."')\">".$rec_db['lang_config_suffix']."</a>&nbsp;|&nbsp;";
		}
	}
	//return substr($text,0,(strlen($text)-7));
	return $text;
}


function show_icon_lang_ewtO($c_id,$module){
global $db;
global $EWT_FOLDER_USER;
global $EWT_DB_NAME,$EWT_DB_USER;
$Globals_Dir = '../ewt/'.$EWT_FOLDER_USER;
$Globals_Dir1 = 'language';
$tb = "lang_".$module;
	$sql = $db->query("SELECT lang_name FROM {$tb} WHERE c_id = '{$c_id}' GROUP BY lang_name ");
	while($rec = $db->db_fetch_array($sql)){
		$db->query("USE ".$EWT_DB_NAME);
		$sql_lang = "SELECT lang_config_name,lang_config_id,lang_config_suffix,lang_config_img FROM lang_config WHERE lang_config_id = '{$rec['lang_name']}' ";
		$query = $db->query($sql_lang);
		$rec_db = $db->db_fetch_array($query);
		$db->query("USE ".$EWT_DB_USER);
		if($rec_db[lang_config_img]!=''){ 
		$text .= "<a href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\" onClick=\"txt_data1('".$c_id."','".$rec_db[lang_config_id]."','".$rec_db[lang_config_suffix]."')\"><img src=".$Globals_Dir."/".$Globals_Dir1."/".$rec_db[lang_config_img]." border=\"0\" width=\"22px\" height=\"18px\" alt=".$rec_db[lang_config_suffix]."></a>&nbsp;|&nbsp;";
		}else{
		
		$text .= "<a href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\" onClick=\"txt_data1('".$c_id."','".$rec_db[lang_config_id]."','".$rec_db[lang_config_suffix]."')\">".$rec_db[lang_config_suffix]."</a>&nbsp;|&nbsp;";
		}
	}
	//return substr($text,0,(strlen($text)-7));
	return $text;
}

function show_icon_lang2($c_id,$module)
{
	global $db;
	global $EWT_FOLDER_USER;
	$Globals_Dir = '../ewt/'.$EWT_FOLDER_USER;
	$Globals_Dir1 = 'language';
	$tb = "lang_".$module;
	$sql = $db->query("SELECT lang_name FROM {$tb} WHERE c_id = '{$c_id}' GROUP BY lang_name ");
	while($rec = $db->db_fetch_array($sql)){
		$sql_lang = "SELECT lang_config_name,lang_config_id,lang_config_suffix,lang_config_img FROM lang_config WHERE lang_config_id = '{$rec['lang_name']}' ";
		$query = $db->query($sql_lang);
		$rec_db = $db->db_fetch_array($query);
		if($rec_db[lang_config_img]!=''){ 
		$text .= "<a href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\"  onClick=\"txt_data2('{$c_id}','".$rec_db[lang_config_id]."','".$rec_db[lang_config_suffix]."')\"><img src=".$Globals_Dir."/".$Globals_Dir1."/".$rec_db[lang_config_img]." border=\"0\" width=\"22px\" height=\"18px\" alt=".$rec_db[lang_config_suffix]."></a>&nbsp;|&nbsp;";
		}else{
		$text .= "<a href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$rec_db['lang_config_name']}\"  onClick=\"txt_data2('{$c_id}','".$rec_db[lang_config_id]."','".$rec_db[lang_config_suffix]."')\">".$rec_db[lang_config_suffix]."</a>&nbsp;|&nbsp;";
		}
	}	
	return substr($text,0,(strlen($text)-7));
}
function lang_detail($c_id,$lang_name,$lang_field,$module)
{
	global $db;
	$tb = "lang_".$module;
	
//echo "select lang_detail from $tb where c_id = '".$c_id."' and lang_name = '".$lang_name."' and lang_field = '".$lang_field."'";
	$sql = $db->query("select lang_detail from {$tb} where c_id = '".$c_id."' and lang_name = '".$lang_name."' and lang_field = '".$lang_field."'");
	if($db->db_num_rows($sql)>0){
	$rec = $db->db_fetch_array($sql);
		if($lang_field == 'n_date' && $rec["lang_detail"] != ''){ 
		$date = explode("-",$rec["lang_detail"]); 
		$rec['lang_detail'] = date ("d M Y",mktime(0,0,0,$date[1],$date[2],$date[0]));
		}
		return $rec['lang_detail'];
	}
}

?>