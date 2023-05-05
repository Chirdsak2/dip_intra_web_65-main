<?php
class point
{
	public static function getRewardLimit($s_search = false, $s_page, $s_limit)
	{
		$wh	= "";
		if ($s_search) {
			//$wh .= "AND (FA_NAME LIKE '%".trim($s_search)."%' OR FA_ANS LIKE '%".trim($s_search)."%' )";   	 
		}
		$perpage = $s_limit;
		if (isset($s_page)) {
			$page = $s_page;
		} else {
			$page = 1;
		}
		$start = ($page - 1) * $perpage;
		$_sql 	= "	SELECT * 
					FROM point_reward 
					WHERE  reward_status = 'Y'  {$wh}  ORDER BY reward_id DESC LIMIT {$start},{$perpage} ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}
	public static function getReward($s_rid = false)
	{
		$wh	= "";
		if ($s_rid) {
			$wh .= "AND reward_id = '{$s_rid}' ";
		}

		$_sql 	= "	SELECT * 
					FROM point_reward 
					WHERE  reward_status = 'Y'  {$wh}  ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}
	public static function getPointProc($s_uid = false, $s_proc = false, $s_cate = false)
	{
		$wh	= "";
		if ($s_uid) {
			$wh .= "AND u_id = '{$s_uid}' ";
		}
		if ($s_proc) {
			$wh .= "AND m_proc = '{$s_proc}' ";
		}
		if ($s_cate) {
			$wh .= "AND m_cate = '{$s_cate}' ";
		}
		$_sql 	= "	SELECT * 
					FROM point_user 
					WHERE  1=1  {$wh}  ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetch($_sql);
		if ($a_data) {
			return $a_data['p_amount'];
		}
	}
	public static function getPointTotal($s_uid = false)
	{
		$wh	= "";
		if ($s_uid) {
			$wh .= "AND point_uid = '{$s_uid}' ";
		}

		$_sql 	= "	SELECT * 
					FROM point 
					WHERE  point_status = 'Y'  {$wh}  ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetch($_sql);
		if ($a_data) {
			return $a_data['point_total'];
		}
	}

	public static function getMission($s_module = false)
	{
		$wh	= "";
		if ($s_module) {
			$wh .= "AND mission_id = '{$s_module}' ";
		}
		if ($s_proc) {
			$wh .= "AND mission_proc = '{$s_proc}' ";
		}
		$_sql 	= "	SELECT * 
					FROM point_mission 
					WHERE  mission_status = 'Y'  {$wh}  ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	public static function logPoint($s_module, $s_mid, $s_fid, $s_user, $s_proc)
	{
		$a_dataMission = self::getMission($s_mid);
		if ($a_dataMission) {
			foreach ($a_dataMission as $_item) {
				if ($s_proc == 'plus') {
					$s_data = array();

					$s_data['log_module']  		=	$s_module;
					$s_data['log_fid']  		=	$s_fid;
					$s_data['log_mid']    		= 	$s_mid;
					$s_data['log_point']    	=	$_item['mission_point'];
					$s_data['log_status']   	=  	'Y';
					$s_data['log_create_date']  =   datetimetool::getnow();
					$s_data['log_create_time']  =	datetimetool::getnow();
					$s_data['log_timestamp']   	=   datetimetool::getnow();
					$s_data['log_user']   		=  	$s_user;
					$s_data['log_proc']   		=  	$s_proc;

					$s_exec 		= 	db::insert("log_point", $s_data);

					## เก็บลงตารางคะแนน แยกแต่ละ misstion
					$_update_user 	= 	"UPDATE point_user SET p_amount = p_amount+{$_item['mission_point']},p_update = '" . datetimetool::getnow() . "'  WHERE m_proc = '{$_item['mission_proc']}' AND m_cate = '{$_item['mission_cate']}' AND u_id = '{$s_user}' ";
					$s_exec_user 	= 	db::getRowCount($_update_user);

					## เก็บลงตารางคะแนน รวม
					$_update_point 	= 	"UPDATE point SET point_total = point_total+{$_item['mission_point']},point_update = '" . datetimetool::getnow() . "'  WHERE point_uid = '{$s_user}' ";
					$s_exec_point 	= 	db::getRowCount($_update_point);
				} else if ($s_proc == 'minus') {
					$s_data = array();

					$s_data['log_module']  		=	$s_module;
					$s_data['log_fid']  		=	$s_fid;
					$s_data['log_mid']    		= 	$s_mid;
					$s_data['log_point']    	=	$_item['mission_point'];
					$s_data['log_status']   	=  	'Y';
					$s_data['log_create_date']  =   datetimetool::getnow();
					$s_data['log_create_time']  =	datetimetool::getnow();
					$s_data['log_timestamp']   	=   datetimetool::getnow();
					$s_data['log_user']   		=  	$s_user;
					$s_data['log_proc']   		=  	$s_proc;

					$s_exec 		= 	db::insert("log_point", $s_data);

					## เก็บลงตารางคะแนน แยกแต่ละ misstion
					$_update_user 	= 	"UPDATE point_user SET p_amount = p_amount-{$_item['mission_point']},p_update = '" . datetimetool::getnow() . "'  WHERE m_proc = '{$_item['mission_proc']}' AND m_cate = '{$_item['mission_cate']}' AND u_id = '{$s_user}' ";
					$s_exec_user 	= 	db::getRowCount($_update_user);

					## เก็บลงตารางคะแนน รวม	 			
					$_update_point 	= 	"UPDATE point SET point_total = point_total-{$_item['mission_point']},point_update = '" . datetimetool::getnow() . "'  WHERE point_uid = '{$s_user}' ";
					$s_exec_point 	= 	db::getRowCount($_update_point);
				}
			}
		}
	}

	public static function chkMissionProc($s_proc = false, $s_cate = false)
	{
		$wh	= "";
		if ($s_proc) {
			$wh .= "AND mission_proc = '{$s_proc}' ";
		}
		if ($s_cate) {
			$wh .= "AND mission_cate = '{$s_cate}' ";
		}

		$_sql 	= "	SELECT * 
					FROM point_mission 
					WHERE  mission_status = 'Y'  {$wh}  ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}
}
