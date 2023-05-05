<?php
class visitor
{
	public static function getVisitorOnline()
	{
		$intUserID = 0;
		$strSessionID = session_id();

		if (isset($_SESSION['EWT_MID'])) {
			//$intUserID = $_SESSION['EWT_MID'];
			$s_online = "INSERT INTO " . E_DB_NAME . ".stat_online (so_session_id,so_user_id,so_onlinelasttime,so_op) 
			VALUES ('{$strSessionID}','{$_SESSION['EWT_MID']}',NOW(),'D') ON DUPLICATE KEY UPDATE so_user_id = '{$_SESSION['EWT_MID']}',so_onlinelasttime = NOW()";
			$q_online	= db::execute($s_online);
		}

		//*** Reject User not online
		$intRejectTime  =	10; // Minute
		$s_delonline 	= 	"DELETE FROM " . E_DB_NAME . ".stat_online WHERE DATE_ADD(so_onlinelasttime, INTERVAL {$intRejectTime} MINUTE) <= NOW() ";
		$q_delonline	= 	db::execute($s_delonline);

		//$_s_count = "SELECT COUNT(so_session_id) AS online FROM stat_online WHERE so_user_id = '0'  group by so_session_id ";
		$_sql = "SELECT so_session_id, so_user_id FROM " . E_DB_NAME . ".stat_online GROUP BY so_user_id ";
		$a_row	= db::getRowCount($_sql);
		$a_data	  = db::getFetchAll($_sql);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => sprintf('%06s', $a_row),
			);
			//return sprintf('%06s',$a_data);  
		}
	}

	public static function getVisitorChat()
	{
		// $wh	= "";
		// if($so_user_id){
		// 	$wh .= " AND so_user_id IN ({$so_user_id})";
		// }

		$_sql 	= "SELECT so_user_id FROM " . E_DB_NAME . ".stat_online GROUP BY so_user_id";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		$c_online = array();
		foreach ($a_data as $value) {
			array_push($c_online, $value["so_user_id"]);
		}

		if ($a_data) {
			return array(
				"data" => array_unique($c_online),
				"count" => $a_row,
			);
		}
	}

	public static function getVisitor()
	{
		$wh	= "";

		$_sql 	= "SELECT sv_id FROM " . E_DB_NAME . ".stat_visitor WHERE sv_visitor = 'Y' {$wh} ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return sprintf('%06s', $a_row);
		}
	}
}
