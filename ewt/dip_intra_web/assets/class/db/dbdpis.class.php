<?php
class dbdpis
{
	private static $_connect;
	private static $_use;
	private static $_error;
	private static $_code;
	private static $_message;
	private static $_type;
	private static $_autoIncrement;


	public static function ConnectDB($s_name, $s_type, $s_connect, $s_user, $s_pass, $s_db, $s_char)
	{

		try {
			self::$_use = $s_name;
			self::$_connect[$s_name] = new PDO("sqlsrv:server=$s_connect;Database=$s_db", $s_user, $s_pass);
			self::$_connect[$s_name]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$_connect[$s_name]->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
		} catch (PDOException $e) {
			die(print_r($e->getMessage()));
		}
	}

	public static function execute($s_sql)
	{
		$_result = self::$_connect[self::$_use]->prepare($s_sql);
		$_result->execute();
		return $_result;
	}

	public static function closeDB()
	{
		if (isset(self::$_connect[self::$_use])) {
			self::$_connect[self::$_use] = null;;
		}
	}

	public static function getFetchAll($s_sql)
	{
		if (self::$_connect[self::$_use]) {
			$_data  = array();
			$_query = self::execute($s_sql);
			if ($_query) {
				while ($a_data = $_query->fetch(PDO::FETCH_ASSOC)) {
					$_data[] = $a_data;
				}
				return $_data;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function getFetch($s_sql)
	{
		if (self::$_connect[self::$_use]) {
			$_query = self::execute($s_sql);
			if ($_query) {
				$a_data = $_query->fetch(PDO::FETCH_ASSOC);
				return $a_data;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public static function Fetch($_query)
	{
		if (self::$_connect[self::$_use]) {
			if ($_query) {
				$a_data = $_query->fetch(PDO::FETCH_ASSOC);
				return $a_data;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function getRowCount($s_sql)
	{
		try {
			if (is_object(self::$_connect[self::$_use])) {
				$_query = self::$_connect[self::$_use]->prepare($s_sql);
				$_query->execute();
				$a_data = $_query->rowCount();
				return $a_data;
			}
			return false;
		} catch (PDOException $exc) {
			self::checkError($s_sql, self::$_connect[self::$_use]->errorInfo());
			return false;
		}
	}
	public static function db_insert($tbName, $data, $pkSelectMax = "", $outID = "")
	{
		$fieldArray = array();
		$valueArray = array();

		if (self::$_autoIncrement == "N") {
			if ($pkSelectMax != "") {
				if (trim($data[$pkSelectMax]) != '') {
					$last_id = $data[$pkSelectMax];
				} else {
					$get_last_id = self::get_max($tbName, $pkSelectMax);
					$last_id = $get_last_id + 1;
					$data[$pkSelectMax] = $last_id;
				}
			}
		}

		foreach ($data as $_key => $_val) {
			if ($_key != "") {
				array_push($fieldArray, $_key);
				array_push($valueArray, "'" . $_val . "'");
			}
		}

		$setSQL = "insert into " . $tbName . " (" . implode(', ', $fieldArray) . ") values (" . implode(', ', $valueArray) . ")";

		self::execute($setSQL);

		if ($outID != "") {
			switch (self::$_type) {
				case 'MSSQL':
					$last_id = self::get_max($tbName, $outID);
					break;
				case 'MYSQL':
					//$last_id = mysqli_insert_id(self::$_systemConnect);
					$last_id = self::get_max($tbName, $outID);
					break;
				case 'ORACLE':
					$last_id = self::get_max($tbName, $outID);
					break;
			}
		}

		if (self::$_autoIncrement == "N" || $outID != "") {
			return $last_id;
		} else {
			return null;
		}
	}
	public static function db_update($tbName, $data, $cond)
	{
		if (count($data) > 0) {
			$updateData = self::setArray2String($data);
			$condition = self::setArray2String($cond, " and ");

			$setSQL = "update " . $tbName . " set " . $updateData . " where 1=1 and " . $condition;
			if (self::execute($setSQL) == true) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public static function get_max($table, $fieldGetMax, $cond = array())
	{
		if (count($cond) > 0) {
			$condition = self::setArray2String($cond, " and ");
			$where = " where " . $condition;
		} else {
			$where = "";
		}

		$sql = "select max(" . $fieldGetMax . ") as MX from " . $table . $where;
		$rec = self::getFetch($sql);
		return $rec['MX'] > 0 ? $rec['MX'] : '0';
	}

	private static function setArray2String($dataArray, $operator = ", ")
	{
		$data = array();

		foreach ($dataArray as $_key => $_val) {
			if ($_key != "") {
				$data[] = $_key . " = '" . $_val . "'";
			}
		}

		return implode($operator, $data);
	}

	private static function checkError($s_sql, $s_error)
	{
		//  if($s_error)
		//{
		self::$_code    = '';
		self::$_message = '';
		$_message = '[Date:' . date('Y-m-d H:i:s') . '] [IP:' . $_SERVER['REMOTE_ADDR'] . ']' . PHP_EOL;
		$_message .= '[Query:' . $s_sql . ']' . PHP_EOL;
		$_message .= '[Error Code:' . self::$_code . ']' . PHP_EOL;
		$_message .= '[Error Massage:' . self::$_message . ']' . PHP_EOL;
		$_message .= '====================================' . PHP_EOL;
		//echo $_message;
		$_file = 'log/error/' . date('Y') . '/' . date('Ymd') . '.log';
		$_dir = trim(dirname($_file), '/');
		//sysFile::forceDirectory($_dir);
		mkdir($_dir, 0777);
		$f_resource = fopen($_file, 'a+');
		fwrite($f_resource, $_message);
		fclose($f_resource);
		//}
	}

	public static function getMonth($num)
	{
		$n = intval($num);
		$month = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
		return $month[$n];
	}

	public static function db2date_show($value)
	{
		if ($value == "" || $value == "0000-00-00") {
			$new_date = "";
		} else {
			$ex_datetime = explode(' ', $value);
			$old_date = explode("-", $ex_datetime[0]);
			$new_date = $old_date[2] . " ";
			$new_date .= self::getMonth(number_format($old_date[1])) . " ";
			$new_date .= ($old_date[0] + 543);
		}

		return $new_date;
	}

	public static function FetchAll($sql,$id=''){
		$q = self::execute($sql);
		$arr = array();
		if($id){
			while($r = self::Fetch($q)){
				$arr[$r[$id]] = $r;
			}
		}else{
			while($r = self::Fetch($q)){
				$arr[] = $r;
			}
		}
		return $arr;
	}
}
