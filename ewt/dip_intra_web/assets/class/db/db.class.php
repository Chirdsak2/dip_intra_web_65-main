<?php
class db
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
		$s_name 		= 	strtolower($s_name);
		self::$_type 	= 	strtoupper($s_type);

		if (version_compare(phpversion(), '5.6', '<')) {
			if (self::$_type == 'MYSQL') {

				try {
					$opt = array(
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
						PDO::ATTR_EMULATE_PREPARES => FALSE,
						PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
					);
					$dsn = $s_type . ':host=' . $s_connect . ';Database=' . $s_db . ';charset=' . $s_char;
					self::$_connect[$s_name] = new PDO($dsn, $s_user, $s_pass, $opt);
					self::$_use = $s_name;
					self::$_connect[$s_name]->exec('SET CHARACTER SET ' . $s_char);
					self::$_connect[$s_name]->exec('SET NAMES ' . $s_char);
				} catch (PDOException $exc) {
					self::$_connect[$s_name] = false;
					echo "There is some problem in connection: " . $exc->getMessage();
					self::$_error = true;

					$state = $exc->getMessage();
					if (!strstr($state, 'SQLSTATE['))
						$state = $exc->getCode();
					if (strstr($state, 'SQLSTATE[')) {
						preg_match('/SQLSTATE\[(\w+)\] \[(\w+)\] (.*)/', $state, $matches);
						self::$_code 	= ($matches[1] == 'HT000' ? $matches[2] : $matches[1]);
						self::$_message = $matches[3];
					}

					return false;
				}
			}
		} else {
			if (self::$_type == 'MYSQL') {
				try {
					$opt = array(
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
						PDO::ATTR_EMULATE_PREPARES => FALSE,
					);
					$dsn = $s_type . ':host=' . $s_connect . ';Database=' . $s_db . ';charset=' . $s_char;
					self::$_connect[$s_name] = new PDO($dsn, $s_user, $s_pass, $opt);
					self::$_use = $s_name;
					self::$_connect[$s_name]->exec('SET CHARACTER SET ' . $s_char);
					self::$_connect[$s_name]->exec('SET NAMES ' . $s_char);
				} catch (PDOException $exc) {
					self::$_connect[$s_name] = false;
					echo "There is some problem in connection: " . $exc->getMessage();
					self::$_error = true;

					$state = $exc->getMessage();
					if (!strstr($state, 'SQLSTATE['))
						$state = $exc->getCode();
					if (strstr($state, 'SQLSTATE[')) {
						preg_match('/SQLSTATE\[(\w+)\] \[(\w+)\] (.*)/', $state, $matches);
						self::$_code 	= ($matches[1] == 'HT000' ? $matches[2] : $matches[1]);
						self::$_message = $matches[3];
					}

					return false;
				}
			}
		}
	}

	# การติดต่อฐานข้อมูล
	public static function setUse($s_name)
	{
		$s_name = strtolower($s_name);
		if (is_object(self::$_connect[$s_name])) {
			self::$_use = $s_name;
		}
	} // function		
	# เรียกใช้ชื่อฐานข้อมูล
	public static function setDB($s_db)
	{
		$s_db = $s_db;
		if (is_object(self::$_connect[self::$_use])) {
			self::$_connect[self::$_use]->exec('USE ' . $s_db);
		}
	} // function			
	#Quoted string
	public static function setQuote($s_data)
	{
		if ($s_data) {
			if (is_object(self::$_connect[self::$_use])) {
				self::$_connect[self::$_use]->quote($s_data);
			}
		}
	} // function	
	#type bindParam		
	public static function bind($s_value)
	{
		switch (true) {
			case is_bool($s_value):
				$var_type = PDO::PARAM_BOOL;
				break;
			case is_int($s_value):
				$var_type = PDO::PARAM_INT;
				break;
			case is_null($s_value):
				$var_type = PDO::PARAM_NULL;
				break;
			default:
				$var_type = PDO::PARAM_STR;
		}
		return $var_type;
	} // function	
	#bindParam
	public static function pdoBindArray(&$_query, &$_paArray)
	{
		foreach ($_paArray as $key => &$val) {
			@$_query->bindParam(':' . $key, $val, self::bind($val));
		} // foreach 
	} // function	
	#execute statement
	public static function execute($s_sql, $s_param = false)
	{
		try {
			if (is_object(self::$_connect[self::$_use])) {
				$_query = self::$_connect[self::$_use]->prepare($s_sql);
				if ($s_param) {
					self::pdoBindArray($_query, $s_param);
				}
				$_query->execute();
				return true;
			}
		} catch (PDOException $exc) {
			self::checkError($s_sql, self::$_connect[self::$_use]->errorInfo());
			return false;
		}
	} // function	

	public static function getColumn($s_sql)
	{
		try {
			if (is_object(self::$_connect[self::$_use])) {
				$_query = self::$_connect[self::$_use]->prepare($s_sql);
				$_query->execute();
				$a_data = $_query->fetchAll(PDO::FETCH_COLUMN);
				return $a_data;
			}
		} catch (PDOException $exc) {
			self::checkError($s_sql, self::$_connect[self::$_use]->errorInfo());
			return false;
		}
	}

	# ยกเลิกการติดต่อกับฐานข้อมูล
	public static function closeDB()
	{
		if (is_object(self::$_connect[self::$_use])) {
			self::$_connect[self::$_use] = null;
		}
	} // function

	public static function getFetch($s_sql, $s_param = false, $s_mode = false)
	{
		try {
			if (is_object(self::$_connect[self::$_use])) {
				$_query = self::$_connect[self::$_use]->prepare($s_sql);
				if ($s_param) {
					self::pdoBindArray($_query, $s_param);
				}
				//$_query->setFetchMode($s_mode);
				$_query->execute();
				$a_data = $_query->fetch();
				return $a_data;
			}
			return false;
		} catch (PDOException $exc) {
			self::checkError($s_sql, self::$_connect[self::$_use]->errorInfo());
			return false;
		}
	} // function

	public static function getRowCount($s_sql)
	{
		try {
			if (is_object(self::$_connect[self::$_use])) {
				$_query = self::$_connect[self::$_use]->prepare($s_sql);
				$_query->execute();
				$a_rows = $_query->rowCount();
				return $a_rows;
			}
			return false;
		} catch (PDOException $exc) {
			self::checkError($s_sql, self::$_connect[self::$_use]->errorInfo());
			return false;
		}
	} // function	

	public static function getFetchAll($s_sql, $s_param = false, $s_mode = false)
	{
		try {
			if (is_object(self::$_connect[self::$_use]) && $s_sql) {
				$_query = self::$_connect[self::$_use]->prepare($s_sql);
				if ($s_param) {
					self::pdoBindArray($_query, $s_param);
				}
				//$_query->setFetchMode($s_mode);					
				$_query->execute();
				$a_data = $_query->fetchAll();
				return $a_data;
			}
			return false;
		} catch (PDOException $exc) {
			self::checkError($s_sql, self::$_connect[self::$_use]->errorInfo());
			return false;
		}
	} // function
	#function update ข้อมูลลงฐานข้อมูล
	public static function update($s_table, $s_data = array(), $s_where = array())
	{
		$a_source = array();
		$a_value  = array();
		$a_where  = array();
		$a_param  = array();
		$a_keys   = array();
		if ($s_data) {
			foreach ((array)$s_data as $_key => $_item) {
				$a_source[] = $_key . "=:" . $_key;
			}
			foreach ((array)$s_where as $_key => $_item) {
				$a_where[] = $_key . "=:" . $_key;
			}
			$a_param = $s_data + $s_where;
			$_sql = 'UPDATE ' . $s_table . ' SET ' . implode(', ', $a_source) . ' WHERE ' . implode(' AND ', $a_where);
			if (is_object(self::$_connect[self::$_use]) && $_sql) {
				$_query = self::$_connect[self::$_use]->prepare($_sql);
				//if($s_param)
				//{
				//self::pdoBindArray($_query,$s_param);  	
				//}	 
				$_query->execute();
				return true;
			} else {
				return false;
			}
		}
	} // function		
	#function delete ข้อมูลออกจากฐานข้อมูล
	public static function del($s_table, $s_where = array())
	{
		$a_where = array();
		foreach ((array)$s_where as $_key => $_item) {
			$a_where[] = $_key . "='" . $_item . "'";
		}

		$_sql = "DELETE FROM {$s_table} WHERE " . implode(" AND ", $a_where);
		if (is_object(self::$_connect[self::$_use]) && $_sql) {
			$_query = self::$_connect[self::$_use]->prepare($_sql);
			//if($s_param)
			//{
			//self::pdoBindArray($_query,$s_param);  	
			//}	 
			$_query->execute();
			return true;
		} else {
			return false;
		}
	} // function
	#function insert ข้อมูลลงฐานข้อมูล
	public static function insert($s_table, $s_data = array())
	{
		try {
			$a_source = array();
			$a_value  = array();
			$a_param  = array();
			$a_keys   = array();
			if ($s_data) {
				foreach ((array)$s_data as $_key => $_item) {
					array_push($a_source, $_key);
					array_push($a_value, "'" . $_item . "'");
					array_push($a_keys, ":" . $_key);
				}
				$_sql = 'INSERT INTO ' . $s_table . ' (' . implode(',', $a_source) . ') VALUES (' . implode(',', $a_value) . ')';
				try {
					if (is_object(self::$_connect[self::$_use]) && $_sql) {
						$query = self::$_connect[self::$_use]->prepare($_sql);
						return $query->execute();
					}
					return true;
				} catch (PDOException $exc) {
					self::checkError($_sql, self::$_connect[self::$_use]->errorInfo());
					return false;
				}
			}
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}

	public static function db_insert($tbName, $data, $pkSelectMax = "", $outID = "")
	{
		$fieldArray = array();
		$valueArray = array();



		foreach ($data as $_key => $_val) {
			if ($_key != "") {
				array_push($fieldArray, $_key);
				array_push($valueArray, "'" . $_val . "'");
			}
		}

		$setSQL = "insert into " . $tbName . " (" . implode(', ', $fieldArray) . ") values (" . implode(', ', $valueArray) . ")";

		self::execute($setSQL, $data);

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
		if ($s_error) {
			self::$_code    = '';
			self::$_message = '';
			$_message = '[Date:' . date('Y-m-d H:i:s') . '] [IP:' . $_SERVER['REMOTE_ADDR'] . ']' . PHP_EOL;
			$_message .= '[Query:' . $s_sql . ']' . PHP_EOL;
			$_message .= '[Error Code:' . self::$_code . ']' . PHP_EOL;
			$_message .= '[Error Massage:' . self::$_message . ']' . PHP_EOL;
			$_message .= '====================================' . PHP_EOL;
			//echo $_message;
			$_file = path . 'log/error/' . date('Y') . '/' . date('Ymd') . '.log';
			$_dir = trim(dirname($_file), '/');
			//sysFile::forceDirectory($_dir);
			mkdir($_dir, 0777);
			$f_resource = fopen($_file, 'a+');
			fwrite($f_resource, $_message);
			fclose($f_resource);
		}
	}
	public static function getColumnCount($s_sql)
	{
		try {
			if (is_object(self::$_connect[self::$_use])) {
				$_query = self::$_connect[self::$_use]->prepare($s_sql);
				$_query->execute();
				$a_rows = $_query->columnCount();
				return $a_rows;
			}
			return false;
		} catch (PDOException $exc) {
			self::checkError($s_sql, self::$_connect[self::$_use]->errorInfo());
			return false;
		}
	}
	public static function getColumnMeta($s_sql)
	{
		try {
			if (is_object(self::$_connect[self::$_use])) {
				$_query = self::$_connect[self::$_use]->prepare($s_sql);
				$_query->execute();
				$a_rows = $_query->columnCount();

				for ($_counter = 0; $_counter < $a_rows; $_counter++) {
					$_meta 		=	$_query->getColumnMeta($_counter);
					if (!empty($_meta['name'])) {
						$_column[]	= 	$_meta['name'];
					}
				}

				return $_column;
			}
			return false;
		} catch (PDOException $exc) {
			self::checkError($s_sql, self::$_connect[self::$_use]->errorInfo());
			return false;
		}

		//$db = $connection->get_connection();
		$select = 'SELECT * FROM contacts';
		$total_column = db::getRowCount($select);

		for ($counter = 0; $counter < $total_column; $counter++) {
			$meta = self::getColumnMeta($counter);
			$column[] = $meta['name'];
		}
	} // function

}
