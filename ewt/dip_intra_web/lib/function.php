<?php
Class PHPDB{

		var $System_Server_Type;
		var $System_HostName,$System_UserName,$System_Password,$System_DBName;
		var $System_Connect,$System_Query,$System_RecordCount,$System_Result;
		var $access = 0;
		function __construct($ServerType,$Host,$User,$Password,$DB)
		{
			$this->System_Server_Type=$ServerType;
			$this->System_HostName=$Host;
			$this->System_UserName=$User;
			$this->System_Password=$Password;
			$this->System_DBName=$DB;
			$this->System_Charset="utf8";
		}

		function PHPDB($ServerType,$Host,$User,$Password,$DB) {
			self::__construct();
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
				case 'MYSQLi':	
					$this->System_Connect = mysqli_connect($this->System_HostName,$this->System_UserName,$this->System_Password,$this->System_DBName) or die(mysqli_error()); 
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
				case 'MYSQLi':	
					mysqli_select_db($this->System_Connect,$this->System_DBName) or die(mysqli_error()); 
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
				case 'MYSQLi':	
					$this->System_Query = mysqli_query($this->System_Connect,$SQL) or die(mysqli_error()); 
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
				case 'MYSQLi':	
					$this->System_RecordCount = mysqli_num_rows($Result); 
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
				case 'MYSQLi':	
						$this->System_Result = mysqli_fetch_array($Result); 
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
				case 'MYSQLi':
					//$this->System_Result = mysql_result($Result,$Index,$Fieldname);	
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
				case 'MYSQLi':	
					$this->System_Result = mysqli_fetch_row($Result); 
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

			if(filter_number($_SESSION["EWT_SMID"])==""){
				$this_ewt_smid = "0";
			}
			else{
				$this_ewt_smid = ready($_SESSION["EWT_SMID"]);
			}

			$insert = "INSERT INTO log_user (log_date , log_time , log_mid , log_user , log_date_text , log_ip , log_module , log_module_detail , log_detail ) VALUES ('$date', '$time', '".$this_ewt_smid."', '".$_SESSION["EWT_SMUSER"]."', '$date_t', '$IPn', '$module', '$module_d', '".stripslashes(htmlspecialchars($detail,ENT_QUOTES))."')";
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

function insert($s_table,$s_data){
	global $db;		
	
	$a_source = array();
    $a_value = array();
	
	if($s_data)
    {
      foreach((array)$s_data as $_key=>$_item)
      {
        array_push($a_source, $_key);
        array_push($a_value, "'".$_item."'");
      }
      $_query = 'INSERT INTO '.$s_table.' ('.implode(', ', $a_source).') VALUES ('.implode(', ', $a_value).')';
    }	
	if($db->query($_query)) { 
	return true; 
	} else { 
		die("SQL Error: <br>".$sql."<br>".$db->error); 
		return false; 
		}
}

function update($s_table,$s_data,$s_where){	
	global $db;	
		
    $a_value = array();
	$a_where = array();
	
	if($s_data)
    {
      foreach((array)$s_data as $_key=>$_item)
		{
			$a_value[] = $_key."='".$_item."'";
		}
      foreach((array)$s_where as $_key=>$_item)
		{
			$a_where[] = $_key."='".$_item."'";
		}
		
	if($a_value){	
	  $_query = 'UPDATE '.$s_table.' SET '.implode(', ', $a_value).' WHERE '.implode(' AND ', $a_where);
		}
    }
	if($db->query($_query)) { 
	return true; 
	} else { 
		die("SQL Error: <br>".$sql."<br>".$db->error); 
		return false; 
		}	
}

function del($s_table,$s_where){	
	global $db;	
	
	$_query = "DELETE FROM {$s_table} WHERE {$s_where}";	
	if($db->query($_query)) { 
	return true; 
	} else { 
		die("SQL Error: <br>".$sql."<br>".$db->error); 
		return false; 
		}	
}

function countmax($s_table,$s_column){	
	global $db;	
	
	$_query = "SELECT MAX({$s_column}) AS max FROM {$s_table}";
	
	if($result = $db->query($_query)) {
    $_data = $db->db_fetch_array($result);	
	return $_data['max']; 	
	} else { 
		die("SQL Error: <br>".$sql."<br>".$db->error); 
		return false; 
		}	
}

function countmax_wh($s_table,$s_column,$s_wh){	
	global $db;	
	
	$_query = "SELECT MAX({$s_column}) AS max FROM {$s_table} WHERE {$s_wh}";
	
	if($result = $db->query($_query)) {
    $_data = $db->db_fetch_array($result);	
	return $_data['max']; 	
	} else { 
		die("SQL Error: <br>".$sql."<br>".$db->error); 
		return false; 
		}	
}

function listfield($table){
	global $db;		
	
	$sql="SELECT * FROM $table LIMIT 1 ";
	$row_title="\$data=array(<br/>";
	$res = $db->query($sql) or die("SQL Error: <br>".$sql."<br>".$db->error);
	$i=1;
	while($data= $res->fetch_field()) {
		$var=$data->name;
		$row_title.="\"$var\"=>\"value$i\",<br/>";
		$i++;
	}	
	$row_title.=");<br/>";
	echo $row_title;
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
		
		$matches = array();
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
		$input=preg_replace_callback($search, $replace, $input,$matches);
		
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

//input_cl();

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
	$mont_en =  array ("January","February","March","April","May","June","July","August","September","October","November","December"); 
	$mont_en_short =  array ("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"); 
	$mont_th = array ("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	$mont_th_short = array ("ม.ค.","ก.พ.","มี.ค","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$numthai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
	$numarabic = array("1","2","3","4","5","6","7","8","9","0");


function chg_date_article($s_date){
	global $mont_th;	
	global $mont_en;
	
		$d = explode("-",$s_date);		
		$s_day = number_format($d[2]);	
		
		if(SYS_LANG == 'TH'){
		$s_month =$mont_th[(($d[1]*1)-1)];
		$s_year = $d[0];	
		$s_data = $s_day." ".$s_month." ".$s_year;
		}else{
		$s_month =$mont_en[(($d[1]*1)-1)];
		$s_year = ($d[0]-543);	
		$s_data = $s_month." ".$s_day.", ".$s_year;				
		}

		return $s_data;
}

function chg_date_cal($s_sdate,$s_edate){
	global $mont_th_short;	
	global $mont_en_short;
	global $mont_th;	
	global $mont_en;
	
		$sd = explode("-",$s_sdate);	
		$ed = explode("-",$s_edate);	
		$s_sday = number_format($sd[2]);	
		$s_eday = number_format($ed[2]);	
				
		if(SYS_LANG == 'TH'){   
		$s_smonth =$mont_th[(($sd[1]*1)-1)];
		$s_syear = ($sd[0]+543); 
		$s_emonth =$mont_th[(($ed[1]*1)-1)];
		$s_eyear = ($ed[0]+543); 
			if($sd[1] == $ed[1] AND $sd[0] == $ed[0] AND $sd[2] != $ed[2]){
				$s_data = $s_sday.' - '.$s_eday.' '.$s_smonth.' '.$s_syear;
			}else if($sd[1] == $ed[1] AND $sd[0] == $ed[0] AND $sd[2] == $ed[2]){
					$s_data = $s_sday.' '.$s_smonth.' '.$s_syear;
			}else if($sd[1] != $ed[1] AND $sd[0] == $ed[0] AND $sd[2] != $ed[2]){
					$s_data = $s_sday.' '.$s_smonth.' - '.$s_eday.' '.$s_emonth.' '.$s_syear;
			}else if($sd[0] != $ed[0]){
					$s_data = $s_sday.' '.$s_smonth.' '.$s_syear.' - '.$s_eday.' '.$s_emonth.' '.$e_syear;				
			}
		}else{
		$s_smonth  = $mont_en[(($sd[1]*1)-1)];
		$s_syear   = $sd[0];
		$s_emonth  = $mont_en[(($ed[1]*1)-1)];
		$s_eyear   = $ed[0]; 
			if($sd[1] == $ed[1] AND $sd[0] == $ed[0] AND $sd[2] != $ed[2]){
				$s_data = $s_sday.' - '.$s_eday.' '.$s_smonth.' '.$s_syear;
			}else if($sd[1] == $ed[1] AND $sd[0] == $ed[0] AND $sd[2] == $ed[2]){
					$s_data = $s_sday.' '.$s_smonth.' '.$s_syear;
			}else if($sd[1] != $ed[1] AND $sd[0] == $ed[0] AND $sd[2] != $ed[2]){
					$s_data = $s_sday.' '.$s_smonth.' - '.$s_eday.' '.$s_emonth.' '.$s_syear;
			}else if($sd[0] != $ed[0]){
					$s_data = $s_sday.' '.$s_smonth.' '.$s_syear.' - '.$s_eday.' '.$s_emonth.' '.$e_syear;				
			}
		
		//$s_data = $s_day." ".$s_month." ".$s_year;		
		}

		return $s_data;
}

function toThaiNumber($number){
	global $numthai,$numarabic;	
		$str = str_replace($numarabic, $numthai, $number);
	return $str;
}
	
function chg_date_short_th($date){
	global $mont_th_short;
		
		$d=explode("-",$date);
		$date=number_format($d[2]);
		$month=$mont_th_short[(($d[1]*1)-1)];
		$year=$d[0];
		//$year=($d[0]+543);
		return " ".$date." ".$month." ".$year;
}
function chg_date_short_th2($date,$temp){
	global $mont_th_short;
		
		$d=explode("-",$date);
		$date=number_format($d[2]);
		$month=$mont_th_short[(($d[1]*1)-1)];
		$year=$d[0];
		//$year=($d[0]+543);
		  
		if($temp == 'd')
		{
			$data =  $date;
		}
		else if($temp == 'm') 
		{
			$data = $month;	
		}
		else if($temp == 'my')
		{
			$data =  $month." ".$year; 
		}
		else if($temp == 'y')
		{
			$data =  $year;	
		}
		else
		{
			$data = $date." ".$month." ".$year;
		}
		
	return $data; 	
}

function chg_date_th($date){
	global $mont_th;
		
		$d=explode("-",$date);
		$date=number_format($d[2]);
		$month=$mont_th[(($d[1]*1)-1)];
		$year=$d[0];
		//$year=($d[0]+543);
		return " ".$date." ".$month." ".$year;
}
function convertEnCode64($text){
	$value =  base64_encode($text);
	return $value;
}

function convertDeCode64($text){
	$value =  base64_decode($text);
	return $value;
}

function convertdatetime($date){
	global $mont_th_short;
	
	$time = substr($date,10,9);
	$date = substr($date,0,10);
	if($date){
		$arr = explode("-",$date);
		$date = ($arr[2].' '.$mont_th_short[(($arr[1]*1)-1)].' '.($arr[0]+543));
		return " ".$date." ".$time;
	}
}

function utf8_strlen($str)
    {
      $c = mb_strlen($str);
      $l = 0;
      for ($i = 0; $i < $c; ++$i)
      {
         if ((ord($str[$i]) & 0xC0) != 0x80)
         {
            ++$l;
         }
      }
      return $l;
}
	
function truncateStr($str, $maxChars, $holder="....."){
    // ตรวจสอบความยาวของประโยค
		if (utf8_strlen($str) > $maxChars )
		{	
		return mb_substr(trim($str), 0,$maxChars, "UTF-8").$holder;
			}else{
			return $str ;
		}
}

##================================================================================================================##
//==========================================================================================================
## >> Escape and HTMLspecialchar
function esc($text){
	$text = str_replace("&#039;","'",$text);
	$text = str_replace("\\","\\\\",$text);
	$text = str_replace("'","\'",$text);
	return $text;
}

function ready($text){
	$text = htmlspecialchars_decode($text);
	$text = esc($text);
	$text = htmlspecialchars($text);
	$text = trim($text);
	return $text;
}

## >> Filter number
function filter_number($var){
	if(!preg_match('/^[0-9]*$/',$var)){
		$var = "";
	}
	return $var;
}


function is_valid_domain_name($domain_name)
{
    return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
}

function filter_email($var){
	
	$valid = 'Y';

	## an @ character must separate the local and domain parts
	if(substr_count($var,"@")==0){
		$valid = "N";
	}
	else{
		$mail_check  = explode("@",$var);
		$localpart   = "";
		$domain_name = $mail_check[count($mail_check)-1];

		for($i=0;$i<(count($mail_check)-1);$i++){
			$localpart .= $mail_check[$i]."@";
		}
		$localpart = rtrim($localpart,"@");

		## >> Check length
		if(count($localpart)>64||count($domain_name)>253||count($var)>254){
			$valid = "N";
		}

		##==========================================================================================================##
		## >> Check localpart
		##==========================================================================================================##

		/*
		===================================================================
		Using Y will NOT allow email with following characters
		===================================================================
		*/
		$invalid_hotmail      = "!#$%*/?^`{|}~";
		$use_hotmail_standard = "Y";
		
		## >> Valid Character (Does not include foreign language)
		if($use_hotmail_standard=="Y"){
			if(preg_match('/[!#$%*\/?^`{|}~]/',$localpart)){
				$valid = "N";
			}
		}
		/*
		===================================================================
		Using N will NOT allow valid email with foreign character
		Example of valid email with foreign character
		- 用户@例子.广告
		- उपयोगकर्ता@उदाहरण.कॉम
		- юзер@екзампл.ком
		- θσερ@εχαμπλε.ψομ
		- Dörte@Sörensen.example.com
		===================================================================
		*/
		$allow_foreignemail = "N";
		
		if($allow_foreignemail=="N"){
			## >> Valid Character (Does not include foreign language)
			if(!preg_match('/^[a-zA-Z0-9!#$%&\'*+\-\/=?^_`{|}~. "(),:;<>@\[\]\\\\]*$/',$localpart)){
				$valid = "N";
			}
		}

		## >> Check dot
		if($localpart[0]=="."||$localpart[strlen($localpart)-1]=="."||preg_match('/\.\./',$localpart)==true){
			$valid = "N";
		}

		## >> Check quote
		$test_localpart = $localpart;
		$flag = "out_quote";
		$a_count = 0;

		for($i=0;$i<strlen($test_localpart);$i++){
			if($i==0){
				if($test_localpart[$i]=='"'){
					$flag = "in_quote";
				}
				else{
					if(preg_match('/["(),:;<>\[\]\\\\ ]/',$test_localpart[$i])){
						$valid = "N";
					}
					else if(preg_match('/[@]/',$test_localpart[$i])){
						$a_count++;
					}
				}
			}
			else if($i>0 && $i<(strlen($test_localpart)-1)){
				if($flag == "out_quote"){
					if($test_localpart[$i]=="." && $test_localpart[$i+1]=='"'){
						$flag = "in_quote";
						$i++;
					}
					else if(preg_match('/["(),:;<>\[\]\\\\ ]/',$test_localpart[$i])){
						$valid = "N";
					}
					else if(preg_match('/[@]/',$test_localpart[$i])){
						$a_count++;
					}
				}
				else if($flag == "in_quote"){
					if($test_localpart[$i]=='"' && $test_localpart[$i+1]=="."){
						$flag = "out_quote";
						$i++;
					}
					else if($test_localpart[$i]=="\\" && preg_match('/["\\\\ ]/',$test_localpart[$i+1])){
						$i++;
					}
					else if(preg_match('/["\\\\ ]/',$test_localpart[$i])){
						$valid = "N";
					}
				}
			}
			else if($i==(strlen($test_localpart)-1)){
				if($flag == "out_quote"){
					if(preg_match('/["(),:;<>\[\]\\\\ ]/',$test_localpart[$i])){
						$valid = "N";
					}
					else if(preg_match('/[@]/',$test_localpart[$i])){
						$a_count++;
					}
				}
				else if($flag == "in_quote"){
					if($test_localpart[$i]=='"'){
						$flag = "out_quote";
					}
				}
			}
		}

		if($a_count>1){
			$valid = "N";
		}
		if($flag=="in_quote"){
			$valid = "N";
		}
		##==========================================================================================================##
		## >> Check domain name
		##==========================================================================================================##
		/*
		Top-level Domains are valid hostname; This may increase in the future.$_COOKIE
		Check https://en.wikipedia.org/wiki/List_of_Internet_top-level_domains for up to date detail.
		*/
		$toplevel_domain = array("com","org","net","int","edu","gov","mil");

		if(in_array($domain_name,$toplevel_domain)){
		}
		else{
			if(is_valid_domain_name($domain_name)==false){
				$valid = "N";
			}
		}

	}

	if($valid=="N"){
		$var = "";
	}
	return $var;
	
}

## >> Filter date

function filter_date($string,$date){
	$error = 0;
	$date_str = explode($string,$date);
	
	if(count($date_str)!=3){
		$error++;
	}
	else{
		$year  = (int)$date_str[0];
		$month = (int)$date_str[1]; 
		$day   = (int)$date_str[2]; 

		## >> Year
		if(filter_number($year)=="" || $year<=0){
			$error++;
		}
		
		## >> Month
		if(filter_number($month)=="" || $month<=0 || $month>12){
			$error++;
		}
		
		## >> Day
		if(filter_number($day)==""){
			$error++;
		}
		else{
			if(in_array($month,array(1,3,5,7,8,10,12))){
				if($day<=0 || $day>31){
					$error++;
				}
			}
			else if(in_array($month,array(4,6,9,11))){
				if($day<=0 || $day>30){
					$error++;
				}
			}
			else if(in_array($month,array(2))){
				## >> check Leap Year
				if($year%400==0){
					if($day<=0 || $day>29){$error++;}
				}
				else if($year%100==0){
					if($day<=0 || $day>28){$error++;}
				}
				else if($year%4==0){
					if($day<=0 || $day>29){$error++;}
				}
				else{
					if($day<=0 || $day>28){$error++;}
				}
			}
		}
	}

	if($error>0){unset($date);}
	else{
		while(strlen($year)<4){
			$year  = "0".$year;
		}
		while(strlen($month)<2){
			$month = "0".$month;
		}
		while(strlen($day)<2){
			$day   = "0".$day;
		}

		## >> Reconstruct date
		$date = $year.$string.$month.$string.$day;
	}

	return $date;
}

## htmlspecialchars all $_GET,$_POST,$_REQUEST variables

function check_variable($check){
	foreach ($check as $key => $check_member) {
		if(is_array($check_member)){
			$check[htmlspecialchars($key)] = check_variable($check_member);
		}
		else{
			$check[htmlspecialchars($key)] = htmlspecialchars($check_member);
		}
	}
	return $check;
}

$check_var = $_GET;
$_GET      = check_variable($check_var);
$check_var = $_POST;
$_POST     = check_variable($check_var);
$check_var = $_REQUEST;
$_REQUEST  = check_variable($check_var);

## >> TIS/UTF conversion

function convert($text){
	$text = iconv('TIS-620','UTF-8',$text);
	return $text;
}

function reconvert($text){
	$text = iconv('UTF-8','TIS-620',$text);
	return $text;
}

function url_name($text){
	$text=str_replace(' ','_',$text);
	$text=substr(htmlspecialchars($text),0,300);
	return $text;
}

function create_menu($mp_id){
	global $db;
	$menu_array = array();
	$baselength = 9;
	
	$menu_data  = $db->query("SELECT * FROM menu_properties WHERE m_id='$mp_id' AND mp_show='Y' ORDER BY mp_pos ASC");
	
	while($menu_info = $db->db_fetch_array($menu_data)){

		if($menu_info["Gtarget"]=="_blank"){
			$menu_info["rel"] = "noopener noreferrer";
		}

		if($menu_info["Oubgpic"]!="" && $menu_info["Oubgpic"]!="fa iconpicker-component"){
			$menu_info["icon"] = $menu_info["Oubgpic"];
		}

		$menu_info["style"] = "";
		
		## align
		if($menu_info["Oufont"]!=""){
			$menu_info["style"].=" text-align:".$menu_info["Oufont"].";";
		}

		if($menu_info["Oubold"]!=""){
			$menu_info["style"].=" font-weight:".$menu_info["Oubold"].";";
		}

		if($menu_info["Ouitalic"]!=""){
			$menu_info["style"].=" font-style:".$menu_info["Ouitalic"].";";
		}
		
		## underline
		if($menu_info["Oubordercolor"]!=""){
			$menu_info["style"].=" text-decoration:".$menu_info["Oubordercolor"].";";
		}

		$menu_info["style"] = trim($menu_info["style"]);

		if($menu_info['mp_sub']==0){
			if(!is_array($menu_array["main"])){
				$menu_array["main"] = array();
			}
			array_push($menu_array["main"],$menu_info);
		}
		else{
			if(!is_array($menu_array["sub"][$menu_info['mp_sub']])){
				$menu_array["sub"][$menu_info['mp_sub']] = array();
			}
			array_push($menu_array["sub"][$menu_info['mp_sub']],$menu_info);
		}
	}
	
	return $menu_array;
}

$EWT_SEO_URL = array();
##============================================================================================##
function create_seourl($url,$language){
	
	global $EWT_SEO_URL;
	global $db;
	
	$seo_url = "";

	## >> Is anchor
	if($url[0]=="#"){
		//$url = create_anchorlink($url);
	}
	else{
		## >> Must be in-site url
		
		if(count($EWT_SEO_URL)==0){
			$seo_data  = $db->query("SELECT * FROM page_seourl");
			while($seo_info = $db->db_fetch_array($seo_data)){
				array_push($EWT_SEO_URL,$seo_info);
			}
		}

		foreach($EWT_SEO_URL AS $check){
			$pos = (string)(strpos($url,$check["filename"]));
			
			if($pos=="0"){
				$seo_url = $language."/".$check["seo_url"];
				
				## >> $_GET parameter
				$collect_get = array();
				$gpos = (string)strpos($url,"?");
				
				if($gpos!=""){
					$get_line = substr($url,strpos($url,"?")+1,strlen($url));
					$get_line = explode("&",$get_line);

					foreach($get_line AS $get){

						if((string)strpos($get,"c_id=")=="0"){
							$collect_get["c_id"] = str_replace("c_id=","",$get);
						}

						if((string)strpos($get,"n_id=")=="0"){
							$collect_get["n_id"] = str_replace("n_id=","",$get);
						}

						if((string)strpos($get,"tag_name=")=="0"){
							$collect_get["tag_name"] = str_replace("tag_name=","",$get);
						}

						if((string)strpos($get,"page=")=="0" && $check["pagination"]=="Y"){
							$collect_get["page"] = str_replace("page=","",$get);
						}
						
						if((string)strpos($get,"g_ebook_id=")=="0"){
							$collect_get["g_ebook_id"] = str_replace("g_ebook_id=","",$get);
						}

						if((string)strpos($get,"url_title=")=="0"){
							$collect_get["url_title"] = str_replace("url_title=","",$get);
						}

					}

					if($collect_get["c_id"]!=""){
						$seo_url .= "/".$collect_get["c_id"];
					}
					else if($collect_get["n_id"]!=""){
						$seo_url .= "/".$collect_get["n_id"];
					}

					if($collect_get["url_title"]!=""){
						$seo_url .= "/".$collect_get["url_title"];
					}

					if($collect_get["tag_name"]!=""){
						$seo_url .= "/".$collect_get["tag_name"];
					}

					if($collect_get["g_ebook_id"]!=""){
						$seo_url .= "/".$collect_get["g_ebook_id"];
					}

					if($collect_get["page"]!=""){
						$seo_url .= "/page/".$collect_get["page"];
					}
					else if($check["pagination"]=="Y"){
						$seo_url .= "/page/1";
					}

					$url .= "&lang=".$language;
				}
				else{
					if($check["pagination"]=="Y"){
						$seo_url .= "/page/1";
					}


					$url .= "?lang=".$language;
				}
				

			}
		}
	}

	## >> Special condition


	## >> Doesn't fit any condition
	if($seo_url==""){
		$seo_url = $url;
	}

	//return $seo_url;
	return $url;
}
##============================================================================================##
function return_data($flag,$data_array){
	$return[] = array( 
        'flag'  => $flag,
        'data_array'    => $data_array
    );
    echo json_encode($return); 
    exit(); 
}

function find_sub_group_test($c_id){
    global $db,$article_subnew_array;
    $qg=$db->query("SELECT * FROM article_group WHERE c_parent='$c_id'");
    while($ar_sub=$db->db_fetch_array($qg)){
        array_push($article_subnew_array,$ar_sub['c_id']);
        find_sub_group_test($ar_sub['c_id']);
    }
	return $article_subnew_array;
}

function find_breadcrumb($c_parent){
	global $db,$article_breadcrumb_array;
    $qg=$db->query("SELECT c_id,c_parent,c_name FROM article_group WHERE c_id='$c_parent'");
    while($ar_sub=$db->db_fetch_array($qg)){
        array_push($article_breadcrumb_array,array("c_id"=>$ar_sub['c_id'],"c_name"=>$ar_sub['c_name']));
		if($ar_sub['c_parent']>0){
			find_breadcrumb($ar_sub['c_parent']);
		}
	}
	
	return $article_breadcrumb_array;
}

function article_group_name($c_id){
	global $db;
	$q_name=$db->query("SELECT c_name FROM article_group WHERE c_id='$c_id'");
	$ar_group=$db->db_fetch_array($q_name);
	
	return $ar_group['c_name'];
}

function lang_article_group_name($c_id){
	global $db;
	global $lang_id;
	$q_name=$db->query("SELECT lang_detail FROM lang_article_group 
	                    WHERE c_id = '$c_id' AND lang_name = '$lang_id' AND lang_field = 'c_name'");
	$ar_group=$db->db_fetch_array($q_name);
	
	return $ar_group['lang_detail'];
}

function lang_article_list($n_id){
	global $db;
	global $lang_id;
	
	$lang_article_array = array();
	$lang_article_data  = $db->query("SELECT * FROM lang_article_list WHERE c_id = '$n_id' AND lang_name = '$lang_id'");
	while($lang_article = $db->db_fetch_array($lang_article_data)){
		
		$addes_pos = (string)strpos($lang_article["lang_field"],"ad_des");
		if($addes_pos=="0"){
			$lang_article_array[$lang_article["c_id"]]["ad_des"] = $lang_article["lang_detail"];
		}
		else{
			$lang_article_array[$lang_article["c_id"]][$lang_article["lang_field"]] = $lang_article["lang_detail"];
		}
	}

	return $lang_article_array;
}


function get_article_list($get_article){
	global $db;
	global $lang_config_status;
	global $lang_id;

	$article_list = array();
	$current_date = date("Y-m-d H:i:s");
	/*$current_date = explode("-",$current_date);
	$current_date = ((int)$current_date[0]+543)."-".$current_date[1]."-".$current_date[2];*/

	//date subgroup
	## >> Total
	$c_id = ready($get_article["c_id"]);
	
	if($get_article["show_subnews"]=="Y"){
		$group_line = "'".implode("','",$get_article["subgroup"])."'";
	}
	else{
		$group_line = "'".$c_id."'";
	}

	if($get_article["pinned_only"]=="Y"){
		$pinned_line = " AND pinned = 'Y' ";
	}
	
	$article_data = $db->query("SELECT COUNT(n_id) AS total FROM article_list
	                            WHERE c_id IN ($group_line) AND n_approve = 'Y' 
								  AND    ((n_date_start = '' AND n_date_end = '') OR 
								          (n_date_start <= '$current_date' AND n_date_end = '') OR 
										  (n_date_start = '' AND n_date_end >= '$current_date') OR 
										  (n_date_start <= '$current_date' AND n_date_end >= '$current_date'))
										  $pinned_line");
	$article_info = $db->db_fetch_array($article_data);
	$article_list["total_result"] = $article_info["total"];
	$article_list["total_page"]   = ceil($article_info["total"]/$get_article["perpage"]);

	
	$article_list["statement"] 	  = "SELECT COUNT(n_id) AS b FROM article_list
	                                 WHERE c_id IN ($group_line) AND n_approve = 'Y' 
								     AND    ((n_date_start = '' AND n_date_end = '') OR 
								          (n_date_start <= '$current_date' AND n_date_end = '') OR 
										  (n_date_start = '' AND n_date_end >= '$current_date') OR 
										  (n_date_start <= '$current_date' AND n_date_end >= '$current_date'))
										  $pinned_line";	

	## >> List
	$perpage = $get_article["perpage"];
	$start   = (($get_article["page"]-1)*$get_article["perpage"]);

	$article_data = $db->query("SELECT   * FROM article_list 
	                            WHERE    c_id IN ($group_line) AND n_approve = 'Y' 
								  AND    ((n_date_start = '' AND n_date_end = '') OR 
								          (n_date_start <= '$current_date' AND n_date_end = '') OR 
										  (n_date_start = '' AND n_date_end >= '$current_date') OR 
										  (n_date_start <= '$current_date' AND n_date_end >= '$current_date'))
										  $pinned_line
								ORDER BY pinned DESC, n_date DESC,n_id DESC 
								LIMIT    $start,$perpage");
								
	$article_list["list"]   = array();
	while($article_info = $db->db_fetch_array($article_data)){
        
        if($lang_config_status != "T"){
            $lang_article_array = lang_article_list($article_info["n_id"]);
            
            if(trim($lang_article_array[$article_info["n_id"]]["n_topic"])!=""){
                $article_info["n_topic"] = $lang_article_array[$article_info["n_id"]]["n_topic"];
            }
		
			//convert n_date
			$convert_date = explode("-",$article_info["n_date"]);
			$article_info["n_date"] = ($convert_date[0]-543)."-".$convert_date[1]."-".$convert_date[2];
		}
		else{
			//convert n_date
		}

		
		if($article_info["target"]=="_blank"){
			$article_info["rel"] = "noopener noreferrer";
		}

		
		array_push($article_list["list"],$article_info);
	}

	return $article_list;
}

function get_banner_list($get_banner){
	global $db;

	$banner_gid = ready($get_banner["banner_gid"]);
	$current_date = date("Y-m-d H:i:s");
	$banner_list["list"] = array();
	
	$banner_data = $db->query("SELECT   * 
	                           FROM     banner 
	                           WHERE    banner_gid = '$banner_gid'  
								  AND    ((banner_show_start = '' AND banner_show_end = '') OR 
								          (banner_show_start <= '$current_date' AND banner_show_end = '') OR 
										  (banner_show_start = '' AND banner_show_end >= '$current_date') OR 
										  (banner_show_start <= '$current_date' AND banner_show_end >= '$current_date'))
							   ORDER BY banner_position ASC, banner_id ASC");
				   
	while($banner_info = $db->db_fetch_array($banner_data)){
		
		if($banner_info["banner_traget"]=="_blank"){
			$banner_info["rel"] = "noopener noreferrer";
		}

		array_push($banner_list["list"],$banner_info);
	}

	return $banner_list;
}

function date_formatslash($date){
	global $lang_config_status;
	global $lang_id;
	$date = explode("-",$date);

	/*if($lang_config_status!="T"){
		$date[0] = $date[0]-543;
	}*/
	$date = (int)$date[2]."/".(int)$date[1]."/".(int)$date[0];
	return $date;
}

##===============================================================================================================##

## >> CSRF
function getCSRF() {
	global $db;
	$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_';
	$randStringLen = 30;

	$randString = "";
	for ($i = 0; $i < $randStringLen; $i++) {
		$randString .= $charset[mt_rand(0, strlen($charset) - 1)];
	}
	
	$csrf_token = $randString;
	return $csrf_token;
}

function setCSRF($form_name){
	if(!isset($_SESSION[$form_name])){
		$_SESSION[$form_name] = getCSRF();
	}
}

##=========================================================================================================
## >> Gen CSRF Token
function makerandomletter($len) {
	global $db;
	$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$randStringLen = $len;

	$randString = "";
	for ($i = 0; $i < $randStringLen; $i++) {
		$randString .= $charset[mt_rand(0, strlen($charset) - 1)];
	}
	
	$csrf_token = $randString;
	return $csrf_token;
}


function create_anchorlink($anchor_name){
	global $file_page;
	global $language;

	$file_path = ready(str_replace("/ewtadmin86_gistda/ewt/gistda_web/","",$_SERVER["REQUEST_URI"]));

	echo $file_path.$anchor_name;
}

function resourcepath(){
	global $EWT_WEB_SHORTPATH;
	global $EWT_WEB_FULLPATH;

	$check_pos = (string)strpos($_SERVER["REQUEST_URI"],$EWT_WEB_FULLPATH);

	if($check_pos=="0"){
		return $EWT_WEB_FULLPATH;
	}
	else{
		return $EWT_WEB_SHORTPATH;
	}
}

function construct_searchlevel($groupsearch_array,$c_parent,$level){
	global $db;
	global $groupsearch_choice;

	if(count($groupsearch_array[$c_parent])>0){
		foreach($groupsearch_array[$c_parent] AS $group){

			$spacing = "";
			if($level>1){
				for($i=0;$i<$level-1;$i++){
					$spacing .= "&nbsp;&nbsp;";
				}
			}

			array_push($groupsearch_choice,array("option_text"=>$spacing."- ".$group["c_name"],"option_value"=>$group["c_id"]));
			construct_searchlevel($groupsearch_array,$group["c_id"],$level+1);
		}
	}

	return $groupsearch_choice;
}	
?>