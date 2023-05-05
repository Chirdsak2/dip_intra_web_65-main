<?php
class survey
{
	public static function getSurveyListLimit($s_search = false, $s_page = false, $s_limit = false)
	{
		$wh	= "";
		if ($s_search) {
			$wh .= "AND (s_title LIKE '%" . trim($s_search) . "%' OR s_detail LIKE '%" . trim($s_search) . "%' )";
		}

		$date_now = datetimetool::getnow();
		$wh .= "AND ('{$date_now}' BETWEEN s_start AND s_end)";

		if ($s_page) {
			$perpage = $s_limit;
			if (isset($s_page)) {
				$page = $s_page;
			} else {
				$page = 1;
			}
			$start = ($page - 1) * $perpage;

			$lim = "LIMIT {$start},{$perpage}";
		}

		$_sql 	= "SELECT * FROM " . E_DB_NAME . ".p_survey WHERE s_approve = 'Y' {$wh} ORDER BY s_id DESC {$lim} ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql, PDO::FETCH_ASSOC);

		$_sql 	= "SELECT s_id FROM " . E_DB_NAME . ".p_survey WHERE s_approve = 'Y' {$wh}";
		$a_row_all	= db::getRowCount($_sql);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row,
				"countAll" => $a_row_all
			);
		}
	}

	public static function getSurvey($s_id = null)
	{
		$wh = "";

		if ($s_id) {
			$wh .= " AND s_id = {$s_id}";
		}

		$_sql = "SELECT * FROM " . E_DB_NAME . ".p_survey WHERE 1=1 {$wh}";
		$a_row  = db::getRowCount($_sql);
		$a_data = db::getFetch($_sql, PDO::FETCH_ASSOC);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function getCat($s_id = null)
	{
		$wh = "";

		if ($s_id) {
			$wh .= " AND s_id = {$s_id}";
		}

		$_sql = "SELECT DISTINCT(c_id),c_d,c_name,c_title,c_gp,option1,option2 
		FROM " . E_DB_NAME . ".p_cate WHERE 1=1 {$wh} ORDER BY c_d ASC";

		$a_row  = db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql, PDO::FETCH_ASSOC);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"row" => $a_row
			);
		}
	}

	public static function getSurveyQuestion($s_id = null)
	{
		$wh = "";

		if ($s_id) {
			$wh .= " AND s_id = {$s_id}";
		}

		$_sql = "SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,
		p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 
		FROM " . E_DB_NAME . ".p_cate," . E_DB_NAME . ".p_question 
		WHERE p_cate.s_id = '{$s_id}' AND p_cate.c_id = p_question.c_id
		ORDER BY p_cate.c_d ASC";

		$a_row  = db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql, PDO::FETCH_ASSOC);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"row" => $a_row
			);
		}
	}

	public static function getQuestion($c_id)
	{

		$wh = "";

		if ($c_id) {
			$wh .= " AND c_id = {$c_id}";
		}

		$_sql = "SELECT * FROM " . E_DB_NAME . ".p_question WHERE 1=1 {$wh} ORDER BY q_pos ASC";
		$a_row  = db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql, PDO::FETCH_ASSOC);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"row" => $a_row
			);
		}
	}

	public static function getQuestion3($c_id)
	{

		$wh = "";

		if ($c_id) {
			$wh .= " AND p_question.c_id = '{$c_id}'";
		}

		$_sql = "SELECT DISTINCT(p_ans.a_name) FROM " . E_DB_NAME . ".p_ans," . E_DB_NAME . ".p_question WHERE 1=1 {$wh} AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3";
		$a_row  = db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql, PDO::FETCH_ASSOC);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"row" => $a_row
			);
		}
	}
}
