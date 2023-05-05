<?php
class intro
{
	public static function getIntro($intro_id = null, $intro_type = null)
	{
		$date_now =  date('Y-m-d');
		$wh	= "AND ((intro_show_start = '' AND intro_show_end = '')";
		$wh .= "OR ('{$date_now}' between intro_show_start AND intro_show_end))";

		if ($intro_id) {
			$wh	.= " AND intro_id = {$intro_id}";
		}

		if ($intro_type) {
			$wh .= "AND intro_type = '{$intro_type}'";
		}

		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM intro_list WHERE intro_use = 'Y' {$wh} ORDER BY intro_id DESC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row
			);
		}
	}

	public static function getIntroBanner($intro_id = null, $banner_id = null)
	{
		$wh = "";
		if ($intro_id) {
			$wh	.= " AND intro_id = {$intro_id}";
		}

		if ($banner_id) {
			$wh	.= " AND banner_id = {$banner_id}";
		}

		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM intro_banner_list WHERE 1=1 {$wh}";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row
			);
		}
	}

	public static function getIntroButton($intro_id = null)
	{
		$wh = "";
		if ($intro_id) {
			$wh	.= " AND intro_id = {$intro_id}";
		}

		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM intro_button_list WHERE 1=1 {$wh}";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row
			);
		}
	}
}
