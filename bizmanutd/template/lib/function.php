<?php
Class PHPDB{

		var $System_Server_Type;
		var $System_HostName,$System_UserName,$System_Password,$System_DBName;
		var $System_Connect,$System_Query,$System_RecordCount,$System_Result;
		var $access = 0;
		function PHPDB($ServerType,$Host,$User,$Password,$DB)
		{
			$this->System_Server_Type=$ServerType;
			$this->System_HostName=$Host;
			$this->System_UserName=$User;
			$this->System_Password=$Password;
			$this->System_DBName=$DB;
			$this->System_Charset="utf8";
		}

		function CONNECT_SERVER()
		{
			switch($this->System_Server_Type)
			{
				case 'MSSQL'			:	
					$this->System_Connect=mssql_connect($this->System_HostName,$this->System_UserName,$this->System_Password); 
				break;
				case 'MYSQL'			:	
					$this->System_Connect=mysql_connect($this->System_HostName,$this->System_UserName,$this->System_Password) or die(mysql_error()); 
				break;
				case 'SYBASE'		:	break;
				case 'INTERBASE'	:	break;
				case	'ORACLE'		:	break;
				case	'INFORMIX'	:	break;
				case	'DBASE'			:	break;
			}
			$this->query("SET NAMES '".$this->System_Charset."' ");
			$this->SELECT_DBNAME();
			return $this->System_Connect;
		}

		function SELECT_DBNAME()
		{
			switch($this->System_Server_Type)
			{
				case 'MSSQL'			:	
					MSSQL_SELECT_DB($this->System_DBName); 	
				break;
				case 'MYSQL'			:	
					mysql_select_db($this->System_DBName) or die(mysql_error()); 
				break;
				case 'SYBASE'		:	break;
				case 'INTERBASE'	:	break;
				case	'ORACLE'		:	break;
				case	'INFORMIX'	:	break;
				case	'DBASE'			:	break;
			}
		}

				function query($SQL)
		{
			switch($this->System_Server_Type)
			{
				case 'MSSQL'			:	
					$this->System_Query=MSSQL_QUERY($SQL,$this->System_Connect); 
				break;
				case 'MYSQL'			:	
					$this->System_Query=mysql_query($SQL,$this->System_Connect) or die($SQL."<br>".mysql_error()); 
				break;
				case 'SYBASE'		:	break;
				case 'INTERBASE'	:	break;
				case	'ORACLE'		:	break;
				case	'INFORMIX'	:	break;
				case	'DBASE'			:	break;
			}
			return $this->System_Query;
		}

				function db_num_rows($Result)
		{
			switch($this->System_Server_Type)
			{
				case 'MSSQL'			:	
					$this->System_RecordCount=mssql_num_rows($Result); 
				break;
				case 'MYSQL'			:	
					$this->System_RecordCount=mysql_num_rows($Result); 
				break;
				case 'SYBASE'		:	break;
				case 'INTERBASE'	:	break;
				case	'ORACLE'		:	break;
				case	'INFORMIX'	:	break;
				case	'DBASE'			:	break;
			}
			return $this->System_RecordCount;
		}

		function db_fetch_array($Result)
		{
			switch($this->System_Server_Type)
			{
				case 'MSSQL' : 
						$this->System_Result=MSSQL_FETCH_ARRAY($Result); 
				break;
				case 'MYSQL'			:	
						$this->System_Result=MYSQL_FETCH_ARRAY($Result);
						//$this->System_Result=$db->db_fetch_array($Result); // aui changed 20091228
				break;
				case 'SYBASE'		:	break;
				case 'INTERBASE'	:	break;
				case	'ORACLE'		:	break;
				case	'INFORMIX'	:	break;
				case	'DBASE'			:	break;
			}
			return $this->System_Result;
		}

				function db_fetch_field($Result,$Index,$Fieldname)
		{
			switch($this->System_Server_Type)
			{
				case 'MSSQL' :
					$this->System_Result=mssql_result($Result,$Index,$Fieldname);	
				break;
				case 'MYSQL'	:
					$this->System_Result=mysql_result($Result,$Index,$Fieldname);	
				break;
				case 'SYBASE'		:	break;
				case 'INTERBASE'	:	break;
				case	'ORACLE'		:	break;
				case	'INFORMIX'	:	break;
				case	'DBASE'			:	break;
			}
			return $this->System_Result;
		}

				function db_fetch_row($Result)
		{
			switch($this->System_Server_Type)
			{
				case 'MSSQL'			: 
					$this->System_Result=mssql_fetch_row($Result); 
				break;
				case 'MYSQL'			:	
					$this->System_Result=mysql_fetch_row($Result); 
				break;
				case 'SYBASE'		:	break;
				case 'INTERBASE'	:	break;
				case	'ORACLE'		:	break;
				case	'INFORMIX'	:	break;
				case	'DBASE'			:	break;
			}
			return $this->System_Result;
		}
			function write_log($module,$module_d,$detail)
		{
			$date = date("Y-m-d");
			$time = date("H:i:s");
			$date_t = date("d/m/Y H:i:s");
				if($_SERVER["REMOTE_ADDR"]) 
					{
						$IPn = $_SERVER["REMOTE_ADDR"];
					}	 
			else 
					{
						$IPn = $_SERVER["REMOTE_HOST"];
					}
			$insert = "INSERT INTO log_user (log_date , log_time , log_mid , log_user , log_date_text , log_ip , log_module , log_module_detail , log_detail ) VALUES ('$date', '$time', '".$_SESSION["EWT_SMID"]."', '".$_SESSION["EWT_SMUSER"]."', '$date_t', '$IPn', '$module', '$module_d', '".stripslashes(htmlspecialchars($detail,ENT_QUOTES))."')";
			return $this->query($insert);
		}
function genaccesskey(){
$accesskey_one = array('aa','bb','cc','dd','ff','gg','hh','jj','kk','ll','mm','nn','oo','pp','qq','rr','ss','vv','ww','xx','yy','zz');
$accesskey_two = array('1','2','3','4','5','6','7','8','9','0');
	if($this->access == ''){
		$this->access = '0';
	}
	$this->access++;
	return $this->access;
	
}
		function db_close()
		{
			switch($this->System_Server_Type)
			{
				case 'MSSQL'			: 
						MSSQL_CLOSE($this->System_Connect); 
				break;
				case 'MYSQL'			:	
						mysql_close($this->System_Connect); 
				break;
				case 'SYBASE'		:	break;
				case 'INTERBASE'	:	break;
				case	'ORACLE'		:	break;
				case	'INFORMIX'	:	break;
				case	'DBASE'			:	break;
			}
		}
}
function select_lang_detail($c_id,$lang_name,$lang_field,$module){
global $db;
$tb = "lang_".$module;
//echo "select lang_config_id from lang_config where lang_config_suffix = '$lang_name' and lang_config_status ='O'";
$sql_lang_comfig = $db->db_fetch_array($db->query("select lang_config_id from lang_config where lang_config_suffix = '$lang_name' and lang_config_status ='O'"));
$lang_config_id = $sql_lang_comfig[lang_config_id];
//echo "select lang_detail from $tb where c_id = '".$c_id."' and lang_name = '".$lang_config_id."' and lang_field = '".$lang_field."'";
$sql = $db->query("select lang_detail from $tb where c_id = '".$c_id."' and lang_name = '".$lang_config_id."' and lang_field = '".$lang_field."'");
$rec = $db->db_fetch_array($sql);
return stripslashes(htmlspecialchars($rec[lang_detail],ENT_QUOTES));
}
function select_lang_detail_ewt($c_id,$lang_name,$lang_field,$module){
global $db;
global $EWT_DB_NAME;
global $EWT_DB_USER;
$tb = "lang_".$module;
$db->query("USE ".$EWT_DB_NAME);
$sql_lang_comfig = $db->db_fetch_array($db->query("select lang_config_id from lang_config where lang_config_suffix = '$lang_name' "));
$lang_config_id = $sql_lang_comfig[lang_config_id];
$db->query("USE ".$EWT_DB_USER);
$sql = $db->query("select lang_detail from $tb where c_id = '".$c_id."' and lang_name = '".$lang_config_id."' and lang_field = '".$lang_field."'");
$rec = $db->db_fetch_array($sql);
return stripslashes(htmlspecialchars($rec[lang_detail],ENT_QUOTES));
}
//
//function input_cl() {
//	// Anti SQL Injection and XSS By PM
//	function input_xss($input) {
//		$plain = array("\r","\n","\t","(",")" );
//		$esc   = array(""  ," "  ," " ," "," " );
//		return strip_tags(str_replace($plain, $esc, $input));
//	}
//	
//	$input_arr_post = array();
//	//grabs the $_POST variables and adds slashes
//	foreach ($_POST as $key => $input_arr_post) {
//		$_POST[$key] = input_xss(addslashes($input_arr_post));
//	}
//
//	$input_arr_get = array();
//	//grabs the $_GET variables and adds slashes
//	foreach ($_GET as $key => $input_arr_get) {
//		$_GET[$key] = input_xss(addslashes($input_arr_get));
//	}
//}
//input_cl();

//======================================== ADD 01032016 ==================================================
function input_cl() {
	// Anti SQL Injection and XSS By PM
	function input_xss($input){
		
		$plain = array("sleep");
		$esc   = array("");
		$input = str_replace($plain, $esc, $input);
		
		$search = array (	"'<script[^>]*?>.*?</script>'si",  // Strip out javascript
									
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

		$replace = array (	"",
									
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
		$input=preg_replace($search, $replace, $input);
		
		return stripslashes(htmlspecialchars(trim($input),ENT_QUOTES));
	}//function

	$input_arr_post = array();
	//grabs the $_POST variables and adds slashes
	foreach ($_POST as $key => $input_arr_post) {
		if(!is_array($input_arr_post)){
			$_POST[$key] = input_xss($input_arr_post);
		}//if
	}//foreach
	
	$input_arr_get = array();
	//grabs the $_GET variables and adds slashes
	foreach ($_GET as $key => $input_arr_get) {
		if(!is_array($input_arr_get)){
			$_GET[$key] = input_xss($input_arr_get);
		}//if
	}//freach
	
	$input_arr_request = array();
	//grabs the $_REQUEST variables and adds slashes
	foreach ($_REQUEST as $key => $input_arr_request) {
		if(!is_array($input_arr_request)){
			$_REQUEST[$key] = input_xss($input_arr_request);
		}//if
	}//freach
}//function

input_cl();

foreach($_POST as $key=>$value){  
	$$key=$value;
}//foreach

foreach($_GET as $key=>$value){  
	$$key=$value;
}//foreach


	function checkPttVar($globvar) {
		$pattern = '/^[a-zA-Z0-9_\.]*$/';
		if($globvar && !preg_match($pattern, $globvar)) {
			$globvar_new = preg_replace("/[^a-zA-Z0-9_\.]/", "", $globvar);
			return $globvar_new;
		}else{
			return $globvar;
		}
	}
	
	function checkNumeric($value){
		$pattern = '/^[0-9]*$/';
		if($value && !preg_match($pattern ,$value)){
			$value_new = preg_replace("/[^0-9]/", "", (string)$value);
			return $value_new;
		}else{
			return $value;
		}
	}
	
	function checkDates($dates){
		$pattern = '/^[0-9\/\-\:]*$/';
		if ($dates && !preg_match($pattern ,$dates)){
			$dates_new = preg_replace("/[^0-9\/\-\:]/", "", $dates);
			return $dates_new;
		}else{
			return $dates;
		}
	}
	
	function checkPttVarThai($globvar) {
		$pattern =  '/^[a-zA-Z0-9ก-๙เแ[:blank:]]*$/';
		if($globvar && !preg_match($pattern ,$globvar)) {
			$globvar_thai_new = preg_replace("/[^a-zA-Z0-9ก-๙เแ[:blank:]]/", "", $globvar);
			return $globvar_thai_new;
		}else{
			return $globvar;
		}
	}
	
	function checkPath($globvar){
		$pattern = '/^[a-zA-Z0-9_\/\:\.\?\=\#\&]*$/';
		if($value && !preg_match($pattern, $globvar)) {
			$globvar_thai_new = preg_replace("/[^a-zA-Z0-9_\/\:\.\?\=\#\&]/", "", $globvar);
			return $globvar_thai_new;
		}else{
			return $globvar;
		}
	}
	
	function checkMails($mails){
		$pattern = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/";
		if ($mails && !preg_match($pattern,$mails)){
			return "";
		}else{
			return $mails;
		}
	}
	
	function checkPttSearch($globvar) {			
		$pattern =  '/^[a-zA-Z0-9ก-๙เแ[:blank:]_\.\-\(\)\[\]\,]*$/';
		if($globvar && !preg_match($pattern ,$globvar)) {
			$globvar_new = preg_replace("/[^a-zA-Z0-9ก-๙เแ[:blank:]_\.\-\(\)\[\]\,]/", "", $globvar);
			return $globvar_new;
		}else{
			return $globvar;
		}
	}
//==========================================================================================================
?>
