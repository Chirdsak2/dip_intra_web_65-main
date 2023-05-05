<?php
class user
{
	public static function chkLogin()
	{
		if (time() - $_SESSION["EWT_TIMEOUT"] > 18000) {
			header("Location: logout.php");
		} else if (!empty($_SESSION['EWT_MID'])) {
			return true;
			// } else if (!empty($_COOKIE['member_login'])) {
			// 	$member_login =	$_COOKIE['member_login'];
			// 	db::setDB(E_DB_USER);
			// 	$s_sql  = "SELECT * FROM gen_user WHERE gen_user = '{$member_login}' AND status = '1' ";
			// 	$a_data = db::getFetch($s_sql);
			// 	if ($a_data) {
			// 		$_SESSION['EWT_MID'] = $a_data['gen_user_id'];
			// 		return true;
			// 	} else {
			// 		self::getVisitorLogReject('30');
			// 		$_SESSION['EWT_MID'] = '';
			// 		setcookie("member_login", "");
			// 		return false;
			// 	}
		} else {
			db::setDB(E_DB_USER);
			self::getVisitorLogReject('30');
			$_SESSION['EWT_MID'] = '';
			setcookie("member_login", "");
			return false;
		}
	}

	public static function chkUser($s_where)
	{
		if ($s_where) {
			$a_where = array();
			foreach ((array)$s_where as $_key => $_item) {
				$a_where[] = $_key . "='" . $_item . "'";
			}

			$_sql 	= 'SELECT * FROM ' . E_DB_USER . '.gen_user WHERE  ' . implode(' AND ', $a_where) . '';
			$a_row	= db::getRowCount($_sql);
			$a_data = db::getFetchAll($_sql);
			if ($a_data) {
				return $a_data;
			}
		}
	}

	public static function getUser($start, $per_page, $s_name = null, $emp_type_id = null, $org_id = null)
	{
		$start = conText(trim($start));
		$per_page = conText(trim($per_page));
		$s_name = conText(trim($s_name));
		$emp_type_id = conText(trim($emp_type_id));
		$org_id = conText(trim($org_id));

		$wh = "";

		if ($s_name) {
			$name_explode = explode(" ", $s_name);
			$name_thai = $name_explode[0];
			$surname_thai = $name_explode[1];

			if (empty($surname_thai)) {
				$wh .= " AND (name_thai LIKE '%{$s_name}%'";
				$wh .= "OR surname_thai LIKE '%{$s_name}%')";
			} else {
				$wh .= " AND (name_thai LIKE '%{$name_thai}%'";
				$wh .= "OR surname_thai LIKE '%{$surname_thai}%')";
			}
		}

		if($emp_type_id){
			$wh .= " AND emp_type_id = {$emp_type_id}";
		}

		if ($org_id) {
			$wh .= " AND org_id = {$org_id}";
		}

		$_sql 	= "SELECT * FROM " . E_DB_USER . ".gen_user WHERE status = 1 {$wh} ORDER BY gen_user_id DESC LIMIT {$start},{$per_page}";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		$_sql_all 	= "SELECT gen_user_id FROM " . E_DB_USER . ".gen_user WHERE status = 1 {$wh}";
		$a_row_all	= db::getRowCount($_sql_all);

		if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
                "countAll" => $a_row_all,
				"sql" => $_sql
            );
        }
	}

	public static function getContact($start, $per_page, $s_name = null, $emp_type_id = null, $org_id = null)
	{
		$start = conText(trim($start));
		$per_page = conText(trim($per_page));
		$s_name = conText(trim($s_name));
		$emp_type_id = conText(trim($emp_type_id));
		$org_id = conText(trim($org_id));

		$wh = "";

		if ($s_name) {
			$name_explode = explode(" ", $s_name);
			$name_thai = $name_explode[0];
			$surname_thai = $name_explode[1];

			if (empty($surname_thai)) {
				$wh .= " AND (a.name_thai LIKE '%{$s_name}%'";
				$wh .= "OR a.surname_thai LIKE '%{$s_name}%')";
			} else {
				$wh .= " AND (a.name_thai LIKE '%{$name_thai}%'";
				$wh .= "OR a.surname_thai LIKE '%{$surname_thai}%')";
			}
		}

		if($emp_type_id){
			$wh .= " AND a.emp_type_id = {$emp_type_id}";
		}

		if ($org_id) {
			$wh .= " AND a.org_id = {$org_id}";
		}

		$_sql 	= "SELECT a.*, b.pos_name, c.name_org FROM " . E_DB_USER . ".gen_user a 
		INNER JOIN position_name b ON (a.posittion = b.pos_id)  
		LEFT JOIN org_name c ON (a.org_id = c.org_id)
		WHERE a.status = 1 AND  b.pos_level BETWEEN 1 AND 7 {$wh} 
		ORDER BY b.pos_level ASC LIMIT {$start},{$per_page}";
		
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		$_sql_all 	= "SELECT a.gen_user_id FROM " . E_DB_USER . ".gen_user a 
		INNER JOIN position_name b ON (a.posittion = b.pos_id)  
		LEFT JOIN org_name c ON (a.org_id = c.org_id)
		WHERE a.status = 1 AND  b.pos_level BETWEEN 1 AND 7 {$wh}";
		$a_row_all	= db::getRowCount($_sql_all);

		if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
                "countAll" => $a_row_all
            );
        }
	}

	public static function orgName($org_id = null)
	{
		$wh = "";

		if ($org_id) {
			$wh .= " AND org_id = {$org_id}";
		}

		$_sql 	= "SELECT * FROM " . E_DB_USER . ".org_name WHERE org_status = 'Y' {$wh}";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function empType($emp_type_id = null, $emp_type_name = null, $emp_type_status = null)
	{
		$wh = "";

		if ($emp_type_id) {
			$wh .= "AND emp_type_id = {$emp_type_id}";
		}

		if ($emp_type_name) {
			$wh .= "AND emp_type_name = {$emp_type_name}";
		}

		if ($emp_type_status) {
			$wh .= "AND emp_type_status = {$emp_type_status}";
		}

		$_sql 	= "SELECT * FROM " . E_DB_USER . ".emp_type WHERE 1=1 {$wh}";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function posName($pos_id = null, $pos_name = null,$pos_level= null)
	{
		$wh = "";

		if ($pos_id) {
			$wh .= "AND pos_id = '{$pos_id}'";
		}

		if ($pos_name) {
			$wh .= "AND emp_type_name LIKE'%{$pos_name}%'";
		}

		if($pos_level){
			$wh .= "AND pos_level BETWEEN 1 AND 7";
		}
		
		$_sql 	= "SELECT * FROM " . E_DB_USER . ".position_name WHERE pos_status = 'Y' {$wh} ORDER BY pos_level ASC";

		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function getVisitorLog($s_student, $s_session)
	{
		$s_max  = " SELECT MAX(vo_id) AS max_vo_id FROM visitor_online ";
		$a_data_max  = db::getFetch($s_max);
		$vo_id = $a_data_max['max_vo_id'] + 1;

		$s_online = "INSERT INTO visitor_online (vo_id,	vo_session_id, vo_user_id, vo_onlinelasttime, vo_op) 
		VALUES ('{$vo_id}','{$s_session}','{$s_student}','" . date('Y-m-d H:i:s') . "','D')";
		db::execute($s_online);
		//return $s_online;
	}

	public static function getVisitorLogReject($s_intRejectTime)
	{
		$s_vonline = "DELETE FROM visitor_online WHERE DATEADD(SECOND,{$s_intRejectTime},vo_onlinelasttime) <= GETDATE() ";
		db::execute($s_vonline);
	}

	public static function getVisitorLogLogout($s_student, $s_session)
	{
		$s_vonline = "DELETE FROM visitor_online WHERE vo_user_id = '{$s_student}' AND vo_session_id = '{$s_session}'";
		db::execute($s_vonline);
	}

	public static function getUserID()
	{
		if (isset($_SESSION['EWT_MID'])) {
			return $_SESSION['EWT_MID'];
		}
	}

	public static function chkConfirmPass($s_pass, $s_repass)
	{
		if ($s_pass && $s_repass) {
			if (trim($s_pass) == trim($s_repass)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function encryptPassword($s_password)
	{
		if ($s_password) {
			$s_source = md5($s_password);
			$s_password = 'บิซโพเทนเชียล#' . $s_source;
			$s_password = hash('SHA512', $s_password);
			return $s_password;
		}
	}

	public static function genCode($s_str)
	{
		if ($s_str) {
			if (self::chkLogin()) {
				$s_source  = SUBSTR(hash('sha512', session_id()), 0, 15);
				return $s_str . '-' . $s_source;
			}
		}
	}

	public static function getCodeCsrf($s_str)
	{
		unset($_SESSION[$_SESSION['token'] . $s_str]);
		unset($_SESSION['token']);

		if ($s_str) {
			$s_code = getPass('10');
			$s_salt = getSalt('10');
			$s_source  = SUBSTR(hash('sha512', $s_code), 0, 30) . '-' . SUBSTR(hash('sha512', $s_salt), 0, 30);
			if (!isset($_SESSION[$s_source . $s_str])) {
				$_SESSION[$s_source . $s_str] = '1';
				$_SESSION['token'] = $s_source;
			}

			return $s_source . $s_str;
		}
	}

	public static function getToken()
	{
		unset($_SESSION['token']);

		if (!isset($_SESSION[$_SESSION['token']])) {
			return $_SESSION['token'];
		}
	}
}
