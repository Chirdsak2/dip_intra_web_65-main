<?php

class banner
{
	public static function getBannerGroup($s_bid = null)
	{
		global $db;
		$date_now =  date('Y-m-d');

		$wh = "";
		if ($s_bid) {
			$wh	.= " AND banner_gid = {$s_bid}";
		}

		$_sql = $db->query("SELECT * FROM banner_group WHERE 1=1 {$wh} ORDER BY banner_gid DESC");
		$a_row = $db->db_num_rows($_sql);

		while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
			$a_data[] = $row;
		}

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row
			);
		}
	}

	public static function getBanner($s_bid = null, $s_id = null)
	{
		global $db;
		$date_now =  date('Y-m-d');

		$wh = "";
		if ($s_bid) {
			$wh	.= " AND banner_gid = {$s_bid}";
		}

		if ($s_id) {
			$wh	.= " AND banner_id = {$s_id}";
		}

		$_sql = $db->query("SELECT * FROM banner WHERE 1=1 {$wh} 
		AND ((banner_show_start = '' AND banner_show_end = '') 
		OR ('{$date_now}' between banner_show_start AND banner_show_end))
		ORDER BY banner_position ASC");
		$a_row = $db->db_num_rows($_sql);

		while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
			$a_data[] = $row;
		}

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row
			);
		}
	}
}
