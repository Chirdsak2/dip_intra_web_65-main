<?php
class calendar
{
	public static function getCalendarListLimit($s_search = false, $s_page, $s_limit)
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

		$_sql 	= "	SELECT * FROM " . E_DB_NAME . ".cal_event 
					LEFT JOIN " . E_DB_NAME . ".cal_category ON (cal_event.cat_id = cal_category.cat_id)
					WHERE  event_webname = '" . E_FOLDER_USER . "'  {$wh}  ORDER BY event_id DESC LIMIT {$start},{$perpage} ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	public static function getCalendar($s_cid)
	{
		$wh	= "";
		$s_limit = "";
		if ($s_cid) {
			$wh .= "AND event_id = '{$s_cid}'";
		}
		$perpage = $s_limit;
		if (isset($s_page)) {
			$page = $s_page;
		} else {
			$page = 1;
		}

		$start = ($page - 1) * $perpage;
		$_sql 	= "SELECT * FROM " . E_DB_NAME . ".cal_event WHERE event_webname = '" . E_FOLDER_USER . "'  {$wh}  ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function getCalendarInvite($s_cid)
	{
		$wh	= "";
		if ($s_cid) {
			$wh .= "AND event_id = '{$s_cid}'";
		}

		$_sql 	= "SELECT * FROM " . E_DB_NAME . ".cal_invite WHERE 1=1 {$wh}";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function getPollAswer($s_cid)
	{
		$wh	= "";
		$s_limit = "";
		if ($s_cid) {
			$wh .= "AND c_id = '{$s_cid}'";
		}

		$perpage = $s_limit;
		if (isset($s_page)) {
			$page = $s_page;
		} else {
			$page = 1;
		}

		$start = ($page - 1) * $perpage;

		$_sql 	= "SELECT * FROM " . E_DB_NAME . ".poll_ans WHERE  1=1 {$wh} ORDER BY a_position ASC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลผู้บริหาร อ้างอิงตามชื่อ และนามสกุล
	public static function getManager($cat_id = null, $m_name = null, $m_surname = null)
	{

		$wh = "";

		if ($cat_id) {
			$wh .= " AND cat_id = {$cat_id}";
		}

		if ($m_name) {
			$wh .= " AND m_name LIKE '%" . $m_name . "%'";
		}

		if ($m_surname) {
			$wh .= " OR m_surname LIKE '%" . $m_surname . "%'";
		}

		$_sql = "SELECT * FROM " . E_DB_NAME . ".cal_manager WHERE 1=1 $wh";
		$a_row = db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function getManagerLimit($start, $per_page)
	{
		$_sql = "SELECT cal_manager.m_name, cal_manager.m_surname, cal_manager.m_images, 
		cal_manager.m_pos, cal_category.cat_id, cal_category.cat_color FROM " . E_DB_NAME . ".cal_manager 
		INNER JOIN " . E_DB_NAME . ".cal_category ON (cal_manager.m_id = cal_category.cat_manager)
		WHERE cal_manager.m_status = 'Y'
		ORDER BY CASE WHEN cal_manager.m_pos LIKE '%อธิบดีกรมประชาสัมพันธ์%' THEN 0 ELSE 1 END, cal_manager.m_id ASC
		LIMIT $start, $per_page";

		$a_row = db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลผู้บริหาร Join วาระงาน อ้างอิงจากชื่อ และนามสกุล
	public static function getManagerCalendar($m_name = null, $m_surname = null)
	{
		$wh = "";

		if ($m_name) {
			$wh .= " AND m_name LIKE '%" . $m_name . "%' ";
		}

		if ($m_surname) {
			$wh .= " OR m_surname LIKE '%" . $m_surname . "%' ";
		}

		$_sql = "SELECT cal_manager.m_name, cal_manager.m_surname, cal_manager.m_images, 
		cal_manager.m_pos, cal_category.cat_id, cal_category.cat_color 
		FROM " . E_DB_NAME . ".cal_manager 
		INNER JOIN " . E_DB_NAME . ".cal_category ON (cal_manager.m_id = cal_category.cat_manager)
		WHERE cal_manager.m_status = 'Y' {$wh} 
		ORDER BY CASE WHEN cal_manager.m_pos LIKE '%อธิบดีกรมประชาสัมพันธ์%' THEN 0 ELSE 1 END, 
		cal_manager.m_id ASC";

		$a_row = db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลกิจกรรม Join วาระงาน อ้างอิงตามชื่อ และนามสกุล
	public static function getEventCalendar($m_name = null, $m_surname = null)
	{
		$wh = "";

		if ($m_name) {
			$wh .= " AND cal_manager.m_name LIKE '%" . $m_name . "%' ";
		}

		if ($m_surname) {
			$wh .= " AND cal_manager.m_surname LIKE '%" . $m_surname . "%' ";
		}

		$date_now =  date('Y-m-d');
		$_sql = "SELECT cat_id, event_time_start, event_time_end, event_title, event_location 
		FROM " . E_DB_NAME . ".cal_event 
		WHERE 1=1 {$wh} AND ((event_date_start = '' AND event_date_end = '')
		OR ('{$date_now}' between event_date_start AND event_date_end)) 
		ORDER BY event_date_start DESC, event_time_start ASC";

		$a_row = db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			foreach ($a_data as $key => $value) {
				$event[$value["cat_id"]][] = array(
					"event_time_start" => date('H:i', strtotime($value['event_time_start'])),
					"event_time_end" => date('H:i', strtotime($value['event_time_end'])),
					"event_title" => $value["event_title"],
					"event_location" => $value["event_location"],
				);
			}
			return $event;
		}
	}

	//เรียกข้อมูลปฎิทินผู้บริหารทั้งหมด
	public static function getCalendarList($cat_id, $mount = null, $year = null)
	{
		$wh = "";
		if ($mount) {
			$wh .= " AND MONTH(event_date_start) = '" . $mount . "'";
			//$wh .= " AND MONTH(event_date_end) = '" . $mount . "'"; 
		}

		if ($year) {
			$wh .= " AND YEAR(event_date_start) = '" . $year . "'";
			//$wh .= " AND YEAR(event_date_end) = '" . $year . "'"; 
		}

		$_sql = "SELECT * FROM " . E_DB_NAME . ".cal_event WHERE cat_id = $cat_id {$wh}";
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			$timestamp = time();
			$today = date('Y-m-d', time());
			$day_count = date('t', $timestamp);
			$ym = date('Y-m');
			$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
			$weeks = array();
			$week = '';

			$week .= str_repeat('<li></li>', $str);

			for ($day = 1; $day <= $day_count; $day++) {
				$date = $ym . '-' . ($day <= 9 ? '0' . $day : $day);
				if ($today == $date) {
					$week .= '<li class="list-item list-item-today">';
				} else {
					$week .= '<li class="list-item">';
				}

				$week .= '<div class="' . (isDayOff($date) == "true" ? "dateweekend" : "date") . '">' . $day . '</div>';
				$week .= '<div class="event">';
				foreach ($a_data as $k => $value) {
					$date_start = $value["event_date_start"];
					$date_end = $value["event_date_end"];
					if (($date_start <= $date) && ($date_end >= $date)) {
						$week .= '<div class="' . ($k > 0 ? "border-t-calendar" : null) . ' ' . ($today == $date ? "pb-2" : null) . '" style="' . ($today == $date && $k > 0 ? "border-top: 1px solid #000; padding-top: 10px" : null) . '">';
						$week .= '<a href="calendar_view.php?event_id=' . $value["event_id"] . '" class="txt-' . ($today == $date ? "dark" : "white") . '">';
						$week .= $value["event_title"];
						$week .= '</a>';
						$week .= '</div>';
					}
				}
				$week .= '</div>';
				$week .= '</li>';

				if ($str % 7 == 6 || $day == $day_count) {

					if ($day == $day_count) {
						$week .= str_repeat('<li></li>', 6 - ($str % 7));
					}

					$weeks[] = $week;
					$week = '';
				}
			}

			return $weeks;
		}
	}

	//เรียกข้อมูลกิจกรรม อ้างอิงตามไอดีผู้บริหาร, ไอดีกิจกรรม
	public static function getCalendarView($event_id = null)
	{
		$wh = "";

		if ($event_id) {
			$wh .= " AND event_id = '$event_id' ";
		}

		$_sql =  "SELECT * FROM " . E_DB_NAME . ".cal_event WHERE 1=1 {$wh}";
		$a_data = db::getFetch($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลชื่อบุคคลผู้รับผิดชอบแสดงที่รายละเอียดผู้จัดงาน
	public static function getUser($event_id)
	{
		$_sql = "SELECT person_id,phone,department FROM " . E_DB_NAME . ".cal_invite WHERE event_id = '" . $event_id . "' ";
		$a_data = db::getFetch($_sql);

		$_sql_sub = "SELECT * FROM " . E_DB_USER . ".gen_user WHERE gen_user_id = '" . $a_data["person_id"] . "' ";
		$a_data_sub = db::getFetch($_sql_sub);

		if ($a_data) {
			return array(
				"fullname" => $a_data_sub["name_thai"] . ' ' . $a_data_sub['surname_thai'],
				"phone" => $a_data["phone"],
				"department" => $a_data["department"]
			);
		}
	}

	//นับข้อมูลเข้าร่วมกิจกรรมของผู้สมัคร
	public static function getRegisterEvent($cal_event_id)
	{
		$_sql =  "SELECT * FROM " . E_DB_NAME . ".cal_registor_event WHERE cal_event_id = '$cal_event_id'";
		$a_data = db::getFetchAll($_sql);
		$a_row = db::getRowCount($_sql);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row
			);
		}
	}

	//เรียกข้อมูล => ประเภทกิจกรรม
	public static function getTypeCalendar($cat_type = null)
	{
		$wh = "";

		if ($cat_type) {
			$wh .= " AND cat_type = '$cat_type' ";
		}

		$_sql =  "SELECT DISTINCT cat_id, cat_name FROM " . E_DB_NAME . ".cal_category WHERE 1=1 {$wh} ORDER BY cat_id DESC";
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลรายละเอียดทั้งหมด => ประเภทกิจกรรม
	public static function getMoreCalendar($start, $per_page)
	{
		$wh = "";
		$date_now =  date('Y-m-d');

		$_sql =  "SELECT * FROM " . E_DB_NAME . ".cal_category 
		INNER JOIN " . E_DB_NAME . ".cal_event ON (cal_category.cat_id = cal_event.cat_id)
		WHERE cal_category.cat_type = 1 AND ((cal_event.event_date_start = '' AND cal_event.event_date_end = '')
        OR (cal_event.event_date_start != '' AND cal_event.event_date_end = '')
        OR ('{$date_now}' between cal_event.event_date_start AND cal_event.event_date_end)) 
		{$wh} ORDER BY cal_event.event_date_start DESC 
		LIMIT {$start},{$per_page}";
		$a_data = db::getFetchAll($_sql);
		$a_row = db::getRowCount($_sql);

		$_sql_count = "SELECT cal_category.cat_id FROM " . E_DB_NAME . ".cal_category 
		INNER JOIN " . E_DB_NAME . ".cal_event ON (cal_category.cat_id = cal_event.cat_id)
		WHERE cal_category.cat_type = 1 AND ((cal_event.event_date_start = '' AND cal_event.event_date_end = '')
        OR (cal_event.event_date_start != '' AND cal_event.event_date_end = '')
        OR ('{$date_now}' between cal_event.event_date_start AND cal_event.event_date_end)) {$wh}";
		$a_row_all = db::getRowCount($_sql_count);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row,
				"countAll" => $a_row_all
			);
		}
	}

	public static function getMoreCalendarLimit($start, $per_page, $event_date_start = null, $event_date_end = null, $s_search = null)
	{
		$wh = "";

		if ($event_date_start) {
			$date_start = convDateAd($event_date_start);
			$wh .= " AND cal_event.event_date_start >= '$date_start'";
		}

		if ($event_date_end) {
			$date_end = convDateAd($event_date_end);
			$wh .= " AND cal_event.event_date_end <= '$date_end'";
		}

		if ($s_search) {
			$wh .= " AND cal_event.event_title LIKE '%" . trim($s_search) . "%' ";
		}

		$_sql =  "SELECT * FROM " . E_DB_NAME . ".cal_category 
		INNER JOIN " . E_DB_NAME . ".cal_event ON (cal_category.cat_id = cal_event.cat_id)
		WHERE cal_category.cat_type = 1 {$wh} 
		ORDER BY cal_event.event_date_start DESC 
		LIMIT {$start},{$per_page}";

		$a_data = db::getFetchAll($_sql);
		$a_row = db::getRowCount($_sql);

		$_sql_count = "SELECT cal_category.cat_id FROM " . E_DB_NAME . ".cal_category 
		INNER JOIN " . E_DB_NAME . ".cal_event ON (cal_category.cat_id = cal_event.cat_id)
		WHERE cal_category.cat_type = 1 {$wh}";

		$a_row_all = db::getRowCount($_sql_count);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row,
				"countAll" => $a_row_all
			);
		}
	}

	//นับจำนวนข้อมูลทั้งหมด => ประเภทกิจกรรม
	public static function getCountMoreCalendar($cat_id = null, $event_date_start = null, $event_date_end = null, $s_search = null)
	{
		$wh = "";

		if ($cat_id) {
			$wh .= " AND cat_id = '$cat_id' ";
		}

		if ($event_date_start) {
			$wh .= " AND event_date_start = '$event_date_start' ";
		}

		if ($event_date_end) {
			$wh .= " AND event_date_end = '$event_date_end' ";
		}

		if ($s_search) {
			$wh .= " AND event_title LIKE '%" . trim($s_search) . "%' ";
		}

		$_sql = "SELECT * FROM " . E_DB_NAME . ".cal_category 
		INNER JOIN cal_event ON (cal_category.cat_id = cal_event.cat_id)
		WHERE cal_category.cat_type = 1 {$wh} ORDER BY cal_category.cat_id ";

		return db::getRowCount($_sql);
	}
}
