<?php
class sitelayout
{
	//เรียกข้อมูล Template ที่ใช้งาน
	public static function getTemplate()
	{
		db::setDB(E_DB_NAME);
		$_sql = "SELECT * FROM site_management_template WHERE template_use = 'Y' ";
		$a_row = db::getRowCount($_sql);
		$a_data = db::getFetch($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลประเภท SiteLayoute ที่ต้องการเรียกใช้งาน
	public static function getSiteLayout($table, $module = null)
	{
		$template_id = self::getTemplate()["template_id"];
		switch ($table) {
			case 'site_management':
				$query = self::getSiteManagement($template_id, 1);
				break;
			case 'site_management_section':
				$query = self::getSiteSection($template_id, 1, $module);
				break;
			case 'site_position':
				$query = self::getSitePosition($template_id, 1);
				break;
		}

		return $query;
	}

	//เรียกข้อมูลการจัดการ Footer
	public static function getSiteManagement($template_id, $lang_id = null)
	{
		$wh = '';
		if ($template_id) {
			$wh .= " AND template_id = $template_id";
		}

		if ($lang_id) {
			$wh .= " AND lang_id = $lang_id";
		}

		db::setDB(E_DB_NAME);
		$_sql = "SELECT * FROM site_management WHERE 1=1 {$wh}";
		$a_row = db::getRowCount($_sql);
		$a_data = db::getFetch($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลการจัดการ Module 
	public static function getSiteSection($template_id, $lang_id = null, $module_name = null)
	{
		$wh = '';
		if ($template_id) {
			$wh .= " AND template_id = '$template_id'";
		}

		if ($lang_id) {
			$wh .= " AND lang_id = '$lang_id'";
		}

		if ($module_name) {
			$wh .= " AND module_name = '$module_name'";
		}

		db::setDB(E_DB_NAME);
		$_sql = "SELECT * FROM site_management_section WHERE section_use = 'Y' {$wh}";
		$a_row = db::getRowCount($_sql);
		$a_data = db::getFetch($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลการจัดการ Module 
	public static function getSitePosition($template_id, $lang_id = null)
	{
		$wh = '';
		if ($template_id) {
			$wh .= " AND template_id = '$template_id'";
		}

		if ($lang_id) {
			$wh .= " AND lang_id = '$lang_id'";
		}

		db::setDB(E_DB_NAME);
		$_sql = "SELECT section_file, module_name, section_order FROM site_management_section WHERE section_use = 'Y' {$wh} ORDER BY section_order ASC";
		$a_row = db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function getMeta(){
		$sql = "SELECT site_info_title, site_info_keyword, site_info_description FROM  site_info";
		$a_data = db::getFetch($sql);

		if ($a_data) {
			return $a_data;
		}
	}
}
