<?php
class banner
{
	public static function genBanner($s_bid = false, $s_id = null)
	{
		$date_now =  date('Y-m-d');
		$wh	= "AND ((banner_show_start = '' AND banner_show_end = '')";
		$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";
		if ($s_bid) {
			$wh .= "AND banner_gid = '{$s_bid}'";
		}

		if ($s_id) {
			$wh	= " AND banner_id = {$s_id}";
		}

		$_sql 	= "SELECT * FROM ".E_DB_NAME.".banner WHERE 1=1 {$wh} 
		ORDER BY CASE WHEN banner_position > 0 THEN banner_position END ASC,
		CASE WHEN banner_position = 0 THEN banner_id END DESC";

		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function getBanner($s_bid)
	{
		//$intro = intro::getIntro(null, "popup")["data"];
		$date_now =  date('Y-m-d');

		$wh	= "AND ((banner_show_start = '' AND banner_show_end = '')";
		$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";

		$_sql = "SELECT * FROM ".E_DB_NAME.".banner WHERE banner_gid = '{$s_bid}' {$wh} 
		ORDER BY CASE WHEN banner_position > 0 THEN banner_position END ASC,
		CASE WHEN banner_position = 0 THEN banner_id END DESC";

		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row
			);
		}
	}

	public static function getBannerIntro($s_bid)
	{
		$intro = intro::getIntro(null, "popup")["data"];
		$date_now =  date('Y-m-d');

		if ($intro) {
			$wh	= "AND ((intro_list.intro_show_start = '' AND intro_list.intro_show_end = '')";
			$wh .= "OR ('{$date_now}' between intro_list.intro_show_start AND intro_list.intro_show_end))";

			$_sql = "SELECT intro_banner_list.banner_id, banner.* FROM ".E_DB_NAME.".intro_list 
			INNER JOIN ".E_DB_NAME.".intro_banner_list ON (intro_list.intro_id = intro_banner_list.intro_id)
			INNER JOIN ".E_DB_NAME.".banner ON (intro_banner_list.banner_id = banner.banner_id)
			WHERE intro_list.intro_use = 'Y' AND intro_banner_list.intro_id = '{$intro[0]['intro_id']}' {$wh} 
			ORDER BY CASE WHEN banner.banner_position > 0 THEN banner.banner_position END ASC,
			CASE WHEN banner.banner_position = 0 THEN banner.banner_id END DESC";
		} else {
			$wh	= "AND ((banner_show_start = '' AND banner_show_end = '')";
			$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";

			$_sql = "SELECT * FROM ".E_DB_NAME.".banner WHERE banner_gid = '{$s_bid}' {$wh} 
			ORDER BY CASE WHEN banner_position > 0 THEN banner_position END ASC,
			CASE WHEN banner_position = 0 THEN banner_id END DESC";
		}

		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row
			);
		}
	}

	public static function getBannerConfig()
	{
		$_sql = "SELECT * FROM ".E_DB_NAME.".banner_config WHERE banner_id = 1";
		$a_data = db::getFetch($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function getSlideFooter($s_bid)
	{
		$date_now =  date('Y-m-d');
		$wh	= "AND ((banner_show_start = '' AND banner_show_end = '')";
		$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";

		$_sql = "SELECT * FROM ".E_DB_NAME.".banner WHERE banner_gid = '{$s_bid}' {$wh} 
		ORDER BY CASE WHEN banner_position > 0 THEN banner_position END ASC,
		CASE WHEN banner_position = 0 THEN banner_id END DESC";

		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			$array_data = array_chunk($a_data, 6);
			$array_count = count($array_data);
			$array_list["data"] = $array_data;
			$array_list["count"] = $array_count;
			return $array_list;
		}
	}
}
