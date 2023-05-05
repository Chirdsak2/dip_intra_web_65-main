<?php
class PHPDB
{

	var $System_Server_Type;
	var $System_HostName, $System_UserName, $System_Password, $System_DBName, $System_Charset;
	var $System_Connect, $System_Query, $System_RecordCount, $System_Result;

	function __construct($ServerType, $Host, $User, $Password, $DB)
	{
		$this->System_Server_Type = $ServerType;
		$this->System_HostName = $Host;
		$this->System_UserName = $User;
		$this->System_Password = $Password;
		$this->System_DBName = $DB;
		$this->System_Charset = "utf8";
	}

	function CONNECT_SERVER()
	{
		switch ($this->System_Server_Type) {
			case 'MSSQL':
				$this->System_Connect = mssql_connect($this->System_HostName, $this->System_UserName, $this->System_Password);
				break;
			case 'MYSQL':
				$this->System_Connect = mysql_connect($this->System_HostName, $this->System_UserName, $this->System_Password) or die(mysql_error());
				break;
			case 'MYSQLi':
				$this->System_Connect = mysqli_connect($this->System_HostName, $this->System_UserName, $this->System_Password, $this->System_DBName) or die(mysqli_error());
				break;
			case 'SYBASE':
				break;
			case 'INTERBASE':
				break;
			case 'ORACLE':
				break;
			case 'INFORMIX':
				break;
			case 'DBASE':
				break;
		}
		$this->query("SET NAMES '" . $this->System_Charset . "' ");
		$this->SELECT_DBNAME();
		return $this->System_Connect;
	}

	function SELECT_DBNAME()
	{
		switch ($this->System_Server_Type) {
			case 'MSSQL':
				MSSQL_SELECT_DB($this->System_DBName);
				break;
			case 'MYSQL':
				mysql_select_db($this->System_DBName) or die(mysql_error());
				break;
			case 'MYSQLi':
				mysqli_select_db($this->System_Connect, $this->System_DBName) or die(mysqli_error());
				break;
			case 'SYBASE':
				break;
			case 'INTERBASE':
				break;
			case 'ORACLE':
				break;
			case 'INFORMIX':
				break;
			case 'DBASE':
				break;
		}
	}

	function query($SQL)
	{
		switch ($this->System_Server_Type) {
			case 'MSSQL':
				$this->System_Query = MSSQL_QUERY($SQL, $this->System_Connect);
				break;
			case 'MYSQL':
				$this->System_Query = mysql_query($SQL, $this->System_Connect) or die(mysql_error());
				break;
			case 'MYSQLi':
				$this->System_Query = mysqli_query($this->System_Connect, $SQL);
				break;
			case 'SYBASE':
				break;
			case 'INTERBASE':
				break;
			case 'ORACLE':
				break;
			case 'INFORMIX':
				break;
			case 'DBASE':
				break;
		}
		return $this->System_Query;
	}
	function query_db($SQL, $database)
	{
		switch ($this->System_Server_Type) {
			case 'MSSQL':
				$this->System_Query = MSSQL_QUERY($SQL, $this->System_Connect);
				break;
			case 'MYSQL':
				$this->System_Query = mysql_db_query($database, $SQL, $this->System_Connect) or die(mysql_error());
				break;
			case 'MYSQLi':
				//$this->System_Query = mysqli_query($this->System_Connect,$SQL) or die(mysqli_error()); 
				$this->System_Query = mysqli_select_db($this->System_Connect, $database) or die(mysqli_error());
				$this->System_Query = mysqli_query($this->System_Connect, $SQL) or die(mysqli_error());
				break;
			case 'SYBASE':
				break;
			case 'INTERBASE':
				break;
			case 'ORACLE':
				break;
			case 'INFORMIX':
				break;
			case 'DBASE':
				break;
		}
		return $this->System_Query;
	}

	function db_num_rows($Result)
	{
		switch ($this->System_Server_Type) {
			case 'MSSQL':
				$this->System_RecordCount = mssql_num_rows($Result);
				break;
			case 'MYSQL':
				$this->System_RecordCount = mysql_num_rows($Result);
				break;
			case 'MYSQLi':
				$this->System_RecordCount = mysqli_num_rows($Result);
				break;
			case 'SYBASE':
				break;
			case 'INTERBASE':
				break;
			case	'ORACLE':
				break;
			case	'INFORMIX':
				break;
			case	'DBASE':
				break;
		}
		return $this->System_RecordCount;
	}

	function db_fetch_array($Result)
	{
		switch ($this->System_Server_Type) {
			case 'MSSQL':
				$this->System_Result = MSSQL_FETCH_ARRAY($Result);
				break;
			case 'MYSQL':
				$this->System_Result = MYSQL_FETCH_ARRAY($Result);
				break;
			case 'MYSQLi':
				$this->System_Result = mysqli_fetch_array($Result);
				break;
			case 'SYBASE':
				break;
			case 'INTERBASE':
				break;
			case 'ORACLE':
				break;
			case 'INFORMIX':
				break;
			case 'DBASE':
				break;
		}
		return $this->System_Result;
	}

	function db_fetch_field($Result, $Index, $Fieldname)
	{
		switch ($this->System_Server_Type) {
			case 'MSSQL':
				$this->System_Result = mssql_result($Result, $Index, $Fieldname);
				break;
			case 'MYSQL':
				$this->System_Result = mysql_result($Result, $Index, $Fieldname);
				break;
			case 'MYSQLi':
				//$this->System_Result = mysql_result($Result,$Index,$Fieldname);	
				break;
			case 'SYBASE':
				break;
			case 'INTERBASE':
				break;
			case 'ORACLE':
				break;
			case 'INFORMIX':
				break;
			case 'DBASE':
				break;
		}
		return $this->System_Result;
	}

	function db_fetch_row($Result)
	{
		switch ($this->System_Server_Type) {
			case 'MSSQL':
				$this->System_Result = mssql_fetch_row($Result);
				break;
			case 'MYSQL':
				$this->System_Result = mysql_fetch_row($Result);
				break;
			case 'MYSQLi':
				$this->System_Result = mysqli_fetch_row($Result);
				break;
			case 'SYBASE':
				break;
			case 'INTERBASE':
				break;
			case 'ORACLE':
				break;
			case 'INFORMIX':
				break;
			case 'DBASE':
				break;
		}
		return $this->System_Result;
	}

	function db_close()
	{
		switch ($this->System_Server_Type) {
			case 'MSSQL':
				MSSQL_CLOSE($this->System_Connect);
				break;
			case 'MYSQL':
				mysql_close($this->System_Connect);
				break;
			case 'MYSQLi':
				mysqli_close($this->System_Connect);
				break;
			case 'SYBASE':
				break;
			case 'INTERBASE':
				break;
			case 'ORACLE':
				break;
			case 'INFORMIX':
				break;
			case 'DBASE':
				break;
		}
	}
	function write_log($module, $module_d, $detail)
	{
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$date_t = date("d/m/Y H:i:s");
		if ($_SERVER["REMOTE_ADDR"]) {
			$IPn = $_SERVER["REMOTE_ADDR"];
		} else {
			$IPn = $_SERVER["REMOTE_HOST"];
		}

		if (filter_number($_SESSION["EWT_SMID"]) == "") {
			$this_ewt_smid = "0";
		} else {
			$this_ewt_smid = ready($_SESSION["EWT_SMID"]);
		}

		$insert = "INSERT INTO log_user (log_date , 
											 log_time , 
											 log_mid , 
											 log_user , 
											 log_date_text , 
											 log_ip , 
											 log_module , 
											 log_module_detail , 
											 log_detail )
											 VALUES ('{$date}', 
													 '{$time}', 
													 '" . $this_ewt_smid . "', 
													 '" . $_SESSION["EWT_SMUSER"] . "', 
													 '{$date_t}', 
													 '" . get_client_ip() . "', 
													 '{$module}', 
													 '{$module_d}', 
													 '" . stripslashes(htmlspecialchars($detail, ENT_QUOTES)) . "')";
		return $this->query($insert);
	}

	function real_escape_string($s_data)
	{

		switch ($this->System_Server_Type) {
			case 'MSSQL':
				$a_data = '';
				break;
			case 'MYSQL':
				$a_data = mysql_escape_string($s_data);
				break;
			case 'MYSQLi':
				$a_data = mysqli_real_escape_string($this->System_Connect, $s_data);
				break;
		}

		return $a_data;
	}

	function check_permission($module, $access, $sid)
	{
		global $EWT_DB_USER;
		if ($_SESSION["EWT_SMTYPE"] == "Y") {
			return true;
		} else {

			$sqlchk = "SELECT COUNT(permission.p_id) as ccs FROM permission 
			WHERE ((p_type = 'U' AND pu_id = '" . $_SESSION["EWT_SMID"] . "') 
			OR (p_type = 'D' AND pu_id = '" . $_SESSION["EWT_SMDIV"] . "'))
			AND UID = '" . $_SESSION["EWT_SUID"] . "' 
			AND permission.s_type = '" . $module . "' ";

			if ($access != "") {
				$sqlchk .= " AND permission.s_permission = '" . $access . "' ";
			}

			if (($module == 'dlFo' or $module == 'imgFo')) {
				$sqlchk .= " AND permission.s_id = '0' ";
				$sqlchk .= " AND (permission.s_name = '" . $sid . "' or permission.s_name = '0')";
			} else if ($sid != "") {
				$sqlchk .= " AND permission.s_id = '" . $sid . "' ";
			}

			$querychk = $this->query_db($sqlchk, $EWT_DB_USER);
			$CH       = $this->db_fetch_array($querychk);

			$this->query("USE " . $_SESSION["EWT_SDB"]);

			return $CH['ccs'];
		}
	}
}

function insert($s_table, $s_data)
{
	global $db;

	$a_source = array();
	$a_value = array();

	if ($s_data) {
		foreach ((array)$s_data as $_key => $_item) {
			array_push($a_source, $_key);
			array_push($a_value, "'" . $_item . "'");
		}
		$_query = 'INSERT INTO ' . $s_table . ' (' . implode(', ', $a_source) . ') VALUES (' . implode(', ', $a_value) . ')';
	}
	if ($db->query($_query)) {
		return true;
	} else {
		die("SQL Error: <br>" . $_query . "<br>" . $db->error);
		return false;
	}
}

function update($s_table, $s_data, $s_where)
{
	global $db;

	$a_value = array();
	$a_where = array();

	if ($s_data) {
		foreach ((array)$s_data as $_key => $_item) {
			$a_value[] = $_key . "='" . $_item . "'";
		}
		foreach ((array)$s_where as $_key => $_item) {
			$a_where[] = $_key . "='" . $_item . "'";
		}

		if ($a_value) {
			$_query = 'UPDATE ' . $s_table . ' SET ' . implode(', ', $a_value) . ' WHERE ' . implode(' AND ', $a_where);
		}
	}

	if ($db->query($_query)) {
		return true;
	} else {
		die("SQL Error: <br>" . $_query . "<br>" . $db->error);
		return false;
	}
}

function del($s_table, $s_where)
{
	global $db;

	$_query = "DELETE FROM {$s_table} WHERE {$s_where}";
	if ($db->query($_query)) {
		return true;
	} else {
		die("SQL Error: <br>" . $_query . "<br>" . $db->error);
		return false;
	}
}

function countmax($s_table, $s_column)
{
	global $db;

	$_query = "SELECT MAX({$s_column}) AS max FROM {$s_table}";

	if ($result = $db->query($_query)) {
		$_data = $db->db_fetch_array($result);
		return $_data['max'];
	} else {
		die("SQL Error: <br>" . $_query . "<br>" . $db->error);
		return false;
	}
}

function countmax_wh($s_table, $s_column, $s_wh)
{
	global $db;

	$_query = "SELECT MAX({$s_column}) AS max FROM {$s_table} WHERE {$s_wh}";

	if ($result = $db->query($_query)) {
		$_data = $db->db_fetch_array($result);
		return $_data['max'];
	} else {
		die("SQL Error: <br>" . $_query . "<br>" . $db->error);
		return false;
	}
}

function listfield($table)
{
	global $db;

	$sql = "SELECT * FROM {$table} LIMIT 1 ";
	$row_title = "\$data=array(<br/>";
	$res = $db->query($sql) or die("SQL Error: <br>" . $sql . "<br>" . $db->error);
	$i = 1;
	while ($data = $res->fetch_field()) {
		$var = $data->name;
		$row_title .= "\"$var\"=>\"value$i\",<br/>";
		$i++;
	}
	$row_title .= ");<br/>";
	echo $row_title;
}


function get_client_ip()
{
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if (isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
function get_client_ip_env()
{
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if (getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if (getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if (getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if (getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if (getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';

	return $ipaddress;
}
function getrealip()
{
	if (isset($_SERVER)) {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			if (strpos($ip, '', '')) {
				$exp_ip = explode('', '', $ip);
				$ip = $exp_ip[0];
			}
		} else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
	} else {
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
			if (strpos($ip, '', '')) {
				$exp_ip = explode('', '', $ip);
				$ip = $exp_ip[0];
			}
		} else if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} else {
			$ip = getenv('REMOTE_ADDR');
		}
	}
	return $ip;
}


function global_register()
{
	$num_args = func_num_args();
	if ($num_args > 0) {
		for ($i = 0; $i < $num_args; $i++) {
			$method = strtoupper(func_get_arg($i));
			if (($method != 'SESSION') && ($method != 'GET') && ($method != 'POST') && ($method != 'SERVER') && ($method != 'COOKIE') && ($method != 'ENV')) {
				die("The \"$method\" is invalid argument, The argument of global_register must be the following: GET, POST, SESSION, SERVER, COOKIE, or ENV");
			}
			$varname = "_{$method}";
			global ${$varname};
			foreach (${$varname} as $key => $val) {
				global ${$key};
				${$key} = $val;
			}
		}
	} else {
		die('You must specifya at least one arguments');
	}
}



global_register('GET', 'POST');

##=======================================================================================================================##
## >> Custom function
##=======================================================================================================================##


## >> Loop convert

function loopconvert_variable($check)
{
	foreach ($check as $key => $check_member) {
		if (is_array($check_member)) {
			$check[$key] = loopconvert_variable($check_member);
		} else {
			$check[$key] = convert($check_member);
		}
	}
	return $check;
}

## htmlspecialchars all $_GET,$_POST,$_REQUEST variables
/*
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
*/

## >> TIS/UTF conversion

function convert($text)
{
	$text = iconv('TIS-620', 'UTF-8', $text);
	return $text;
}

function reconvert($text)
{
	$text = iconv('UTF-8', 'TIS-620', $text);
	return $text;
}




## >> Escape and HTMLspecialchar
function esc($text)
{
	$text = str_replace("&#039;", "'", $text);
	$text = str_replace("\\", "\\\\", $text);
	$text = str_replace("'", "\'", $text);
	return $text;
}

function ready($text)
{
	$text = htmlspecialchars_decode($text);
	$text = esc($text);
	$text = htmlspecialchars($text);
	$text = trim($text);
	return $text;
}

## >> Filter number
function filter_number($var)
{
	if (!preg_match('/^[0-9]*$/', $var)) {
		$var = "";
	}
	return $var;
}


function is_valid_domain_name($domain_name)
{
	return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
		&& preg_match("/^.{1,253}$/", $domain_name) //overall length check
		&& preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)); //length of each label
}

function filter_email($var)
{

	$valid = 'Y';

	## an @ character must separate the local and domain parts
	if (substr_count($var, "@") == 0) {
		$valid = "N";
	} else {
		$mail_check  = explode("@", $var);
		$localpart   = "";
		$domain_name = $mail_check[count($mail_check) - 1];

		for ($i = 0; $i < (count($mail_check) - 1); $i++) {
			$localpart .= $mail_check[$i] . "@";
		}
		$localpart = rtrim($localpart, "@");

		## >> Check length
		if (count($localpart) > 64 || count($domain_name) > 253 || count($var) > 254) {
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
		if ($use_hotmail_standard == "Y") {
			if (preg_match('/[!#$%*\/?^`{|}~]/', $localpart)) {
				$valid = "N";
			}
		}
		/*
		===================================================================
		*/
		$allow_foreignemail = "N";

		if ($allow_foreignemail == "N") {
			## >> Valid Character (Does not include foreign language)
			if (!preg_match('/^[a-zA-Z0-9!#$%&\'*+\-\/=?^_`{|}~. "(),:;<>@\[\]\\\\]*$/', $localpart)) {
				$valid = "N";
			}
		}

		## >> Check dot
		if ($localpart[0] == "." || $localpart[strlen($localpart) - 1] == "." || preg_match('/\.\./', $localpart) == true) {
			$valid = "N";
		}

		## >> Check quote
		$test_localpart = $localpart;
		$flag = "out_quote";
		$a_count = 0;

		for ($i = 0; $i < strlen($test_localpart); $i++) {
			if ($i == 0) {
				if ($test_localpart[$i] == '"') {
					$flag = "in_quote";
				} else {
					if (preg_match('/["(),:;<>\[\]\\\\ ]/', $test_localpart[$i])) {
						$valid = "N";
					} else if (preg_match('/[@]/', $test_localpart[$i])) {
						$a_count++;
					}
				}
			} else if ($i > 0 && $i < (strlen($test_localpart) - 1)) {
				if ($flag == "out_quote") {
					if ($test_localpart[$i] == "." && $test_localpart[$i + 1] == '"') {
						$flag = "in_quote";
						$i++;
					} else if (preg_match('/["(),:;<>\[\]\\\\ ]/', $test_localpart[$i])) {
						$valid = "N";
					} else if (preg_match('/[@]/', $test_localpart[$i])) {
						$a_count++;
					}
				} else if ($flag == "in_quote") {
					if ($test_localpart[$i] == '"' && $test_localpart[$i + 1] == ".") {
						$flag = "out_quote";
						$i++;
					} else if ($test_localpart[$i] == "\\" && preg_match('/["\\\\ ]/', $test_localpart[$i + 1])) {
						$i++;
					} else if (preg_match('/["\\\\ ]/', $test_localpart[$i])) {
						$valid = "N";
					}
				}
			} else if ($i == (strlen($test_localpart) - 1)) {
				if ($flag == "out_quote") {
					if (preg_match('/["(),:;<>\[\]\\\\ ]/', $test_localpart[$i])) {
						$valid = "N";
					} else if (preg_match('/[@]/', $test_localpart[$i])) {
						$a_count++;
					}
				} else if ($flag == "in_quote") {
					if ($test_localpart[$i] == '"') {
						$flag = "out_quote";
					}
				}
			}
		}

		if ($a_count > 1) {
			$valid = "N";
		}
		if ($flag == "in_quote") {
			$valid = "N";
		}
		##==========================================================================================================##
		## >> Check domain name
		##==========================================================================================================##
		/*
		Top-level Domains are valid hostname; This may increase in the future.$_COOKIE
		Check https://en.wikipedia.org/wiki/List_of_Internet_top-level_domains for up to date detail.
		*/
		$toplevel_domain = array("com", "org", "net", "int", "edu", "gov", "mil");

		if (in_array($domain_name, $toplevel_domain)) {
		} else {
			if (is_valid_domain_name($domain_name) == false) {
				$valid = "N";
			}
		}
	}

	if ($valid == "N") {
		$var = "";
	}
	return $var;
}

## >> Filter date

function filter_date($string, $date)
{
	$error = 0;
	$date_str = explode($string, $date);

	if (count($date_str) != 3) {
		$error++;
	} else {
		$year  = (int)$date_str[0];
		$month = (int)$date_str[1];
		$day   = (int)$date_str[2];

		## >> Year
		if (filter_number($year) == "" || $year <= 0) {
			$error++;
		}

		## >> Month
		if (filter_number($month) == "" || $month <= 0 || $month > 12) {
			$error++;
		}

		## >> Day
		if (filter_number($day) == "") {
			$error++;
		} else {
			if (in_array($month, array(1, 3, 5, 7, 8, 10, 12))) {
				if ($day <= 0 || $day > 31) {
					$error++;
				}
			} else if (in_array($month, array(4, 6, 9, 11))) {
				if ($day <= 0 || $day > 30) {
					$error++;
				}
			} else if (in_array($month, array(2))) {
				## >> check Leap Year
				if ($year % 400 == 0) {
					if ($day <= 0 || $day > 29) {
						$error++;
					}
				} else if ($year % 100 == 0) {
					if ($day <= 0 || $day > 28) {
						$error++;
					}
				} else if ($year % 4 == 0) {
					if ($day <= 0 || $day > 29) {
						$error++;
					}
				} else {
					if ($day <= 0 || $day > 28) {
						$error++;
					}
				}
			}
		}
	}

	if ($error > 0) {
		unset($date);
	} else {
		while (strlen($year) < 4) {
			$year  = "0" . $year;
		}
		while (strlen($month) < 2) {
			$month = "0" . $month;
		}
		while (strlen($day) < 2) {
			$day   = "0" . $day;
		}

		## >> Reconstruct date
		$date = $year . $string . $month . $string . $day;
	}

	return $date;
}

## >> Gen CSRF Token
function makerandomletter($len)
{
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

function getCSRF()
{
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

function setCSRF($form_name)
{
	if (!isset($_SESSION[$form_name])) {
		$_SESSION[$form_name] = getCSRF();
	}
}

function gen_pic($subject)
{
	global $language_id;
?>

	<label for="addqcapcha" style="color:#2c1b71;">
		<b> กรอกรหัสตามภาพ </b> <span style="color:red;">*</span>
	</label><br>

	<div id="captcha-ajax3" style="width:100%;background:#e1fffe;border-top-left-radius:5px;border-top-right-radius:5px;" align="center">
		<div id="logpic_<?php echo $subject; ?>" style="min-height:60px;"><img src="../Login/ewt_picmain.php?subject=<?php echo $subject; ?>"></div>
	</div>

	<div id="captcha-ajax3" style="width:100%;background:#ffffff;border-bottom-left-radius:5px;border-bottom-right-radius:5px;margin-bottom:20px;">
		<a href="javascript:void(0);" onclick="Getmessage_<?php echo $subject; ?>('');return false;">

			<span class="btn btn-warning text-white" style="width:100%;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;">
				คลิกเพื่อเปลี่ยนรูป
				<i class="fas fa-sync-alt"></i>
			</span>
		</a>
	</div>

	<input required type="text" name="chkpic1_<?php echo $subject; ?>" id="chkpic1_<?php echo $subject; ?>" placeholder="กรอก captcha" class="form-control" autocomplete="off" style="width:100%; text-align: center; ">

	<div style="height:10px;"></div>
	<div class="alert_text" id="alert_captcha_status"></div>

	<input type="hidden" name="captcha_id" value="<?php echo $subject; ?>">

	<script>
		function Getmessage_<?php echo $subject; ?>() {
			current_local_time = new Date();
			document.getElementById('logpic_<?php echo $subject; ?>').innerHTML = '<img src="<?php echo HTTP_HOST; ?>Login/ewt_picmain.php?subject=<?php echo $subject; ?>" align="absmiddle">';
		}
	</script>
<?php
}


function return_data($flag, $data_array)
{
	$return[] = array(
		'flag'  => $flag,
		'data_array'    => $data_array
	);
	echo json_encode($return);
	exit();
}


## Page construct

function module_header()
{
}

## >> Get breadcrumb
function find_breadcrumb($c_parent)
{
	global $db, $article_breadcrumb_array;
	$qg = $db->query("SELECT c_id,c_parent,c_name FROM article_group WHERE c_id='$c_parent'");
	while ($ar_sub = $db->db_fetch_array($qg)) {
		array_push($article_breadcrumb_array["detail"], array("c_id" => $ar_sub['c_id'], "c_name" => $ar_sub['c_name']));
		array_push($article_breadcrumb_array["list"], $ar_sub['c_id']);
		if ($ar_sub['c_parent'] > 0) {
			find_breadcrumb($ar_sub['c_parent']);
		}
	}

	return $article_breadcrumb_array;
}

function find_sub_group($c_id)
{
	global $db, $article_subnew_array;
	$qg = $db->query("SELECT * FROM article_group WHERE c_parent='$c_id'");
	while ($ar_sub = $db->db_fetch_array($qg)) {
		array_push($article_subnew_array["detail"], array("c_id" => $ar_sub['c_id'], "c_name" => $ar_sub['c_name']));
		array_push($article_subnew_array["list"], $ar_sub['c_id']);
		find_sub_group($ar_sub['c_id']);
	}
	return $article_subnew_array;
}

?>