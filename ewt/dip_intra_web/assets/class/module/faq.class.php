<?php
class faq
{
	public static function genFaq($s_id, $s_sub)
	{
		$wh	= "";
		if ($s_sub >= 0) {
			$wh .= "AND f_parent = '{$s_sub}' ";
		}
		if ($s_id) {
			$wh .= "AND f_sub_id = '{$s_id}'";
		}

		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM f_subcat WHERE  1=1  {$wh} ORDER BY f_sub_id ASC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	public static function genFaqList($s_id, $s_search)
	{
		$wh	= "";
		if ($s_id) {
			$wh .= "AND f_sub_id = '{$s_id}'";
		}
		if ($s_search) {
			$wh .= "AND (FA_NAME LIKE '%" . trim($s_search) . "%' OR FA_ANS LIKE '%" . trim($s_search) . "%')";
		}

		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM faq WHERE  1=1  {$wh} ORDER BY fa_id ASC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	public static function genFaqListLimit($s_id, $s_search, $s_page, $s_limit)
	{
		$wh	= "";
		if ($s_id) {
			$wh .= "AND f_sub_id = '{$s_id}'";
		}
		if ($s_search) {
			$wh .= "AND (FA_NAME LIKE '%" . trim($s_search) . "%' OR FA_ANS LIKE '%" . trim($s_search) . "%' )";
		}
		$perpage = $s_limit;
		if (isset($s_page)) {
			$page = $s_page;
		} else {
			$page = 1;
		}
		$start = ($page - 1) * $perpage;

		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM faq WHERE  1=1  {$wh} ORDER BY fa_id DESC LIMIT {$start},{$perpage} ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลหมวดหมู่ อ้างอิงที่ Array Id ตรงกัน
	public static function getCategory()
	{
		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM faq_category WHERE faq_cate_status = 'Y' ORDER BY faq_cate_order ASC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			foreach ($a_data as $val) {
				$data[$val["faq_cate_id"]][] = array(
					"faq_cate_id" => $val["faq_cate_id"],
					"faq_cate_title" => $val["faq_cate_title"]
				);
			}

			return $data;
		}
	}

	//เรียกข้อมูลหมวดหมู่ และ หมวดหมู่ย่อย
	public static function getCategoryArray($faq_cate_id = null)
	{
		$wh	= "";

		$s_faq_cate_id = array();
		array_push($s_faq_cate_id, $faq_cate_id);

		if ($faq_cate_id) {
			$wh .= " AND faq_cate_parent = '$faq_cate_id'";
		}

		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM faq_category WHERE faq_cate_status = 'Y' {$wh} ORDER BY faq_cate_order ASC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			foreach ($a_data as $value) {
				array_push($s_faq_cate_id, self::getCategoryArray($value['faq_cate_id']));
			}
		}

		return implode(",", array_unique($s_faq_cate_id));
	}

	//เรียกหัวข้อหมวดหมู่คำถาม
	public static function getFaqTitleCategory($faq_cate_id = null)
	{
		$wh	= "";

		if ($faq_cate_id) {
			$wh .= " AND faq_cate_id = {$faq_cate_id} ";
		}

		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM faq_category WHERE faq_cate_status = 'Y' {$wh} ORDER BY faq_cate_order ASC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลหมวดหมู่คำถาม
	public static function getFaqCategory($faq_cate_id = null)
	{
		$wh	= "";

		if ($faq_cate_id) {
			$faq_sub = self::getCategoryArray($faq_cate_id);
			$wh .= " AND faq_cate_id in($faq_sub) ";
		}

		db::setDB(E_DB_NAME);
		$_sql 	= "SELECT * FROM faq_category WHERE faq_cate_status = 'Y' {$wh} ORDER BY faq_cate_order ASC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	//เรียกข้อมูลหมวดย่อยคำถาม
	public static function getSubFaqCategory($faq_cate_id = null)
	{
		$wh	= "";

		if ($faq_cate_id) {
			$wh .= " AND faq_cate_parent = '$faq_cate_id'";
		}

		db::setDB(E_DB_NAME);
		$_sql = "SELECT * FROM faq_category WHERE faq_cate_status = 'Y' {$wh} ORDER BY faq_cate_order ASC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			foreach ($a_data as $val) {
				$data[$val["faq_cate_parent"]][] = array(
					"faq_cate_id" => $val["faq_cate_id"],
					"faq_cate_title" => $val["faq_cate_title"]
				);
			}

			return $data;
		}
	}

	//เรียกข้อมูลคำถามทั้งหมด
	public static function getFaq($start, $per_page, $faq_cate_id = null, $fa_id = null, $s_search = null, $faq_type = null)
	{
		$wh	= "";

		if ($faq_cate_id) {
			$wh .= " AND faq_category.faq_cate_id = '$faq_cate_id'";
		}

		if ($fa_id) {
			$wh .= " AND faq.fa_id = '$fa_id'";
		}

		if ($s_search) {
			$wh .= " AND faq.fa_name LIKE '%" . trim($s_search) . "%' ";
			$wh .= " OR faq.fa_ans LIKE '%" . trim($s_search) . "%' ";
		}

		if ($faq_type) {
			switch ($faq_type) {
				case 1:
					$orderby = "CASE WHEN faq.faq_top = 'Y' THEN 0 ELSE 1 END, faq.fa_count DESC";
					break;
				case 2:
					$orderby = "CASE WHEN faq.faq_top = 'Y' THEN 0 ELSE 1 END, faq.faq_date DESC";
					break;
			}
		}else{
			$orderby = "CASE WHEN faq.faq_top = 'Y' THEN 0 ELSE 1 END,
			faq.fa_order ASC";
		}

		db::setDB(E_DB_NAME);
		$_sql = "SELECT faq.fa_id, faq.faq_top, faq.fa_name, faq.fa_ans, 
		faq.fa_count, faq.fa_user_ask FROM faq_category 
		INNER JOIN faq ON (faq_category.faq_cate_id = faq.f_sub_id)
		WHERE faq_category.faq_cate_status = 'Y' AND faq.faq_use = 'Y' {$wh} 
		ORDER BY {$orderby} LIMIT {$start},{$per_page}";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		$_sql_all = "SELECT faq.fa_id FROM faq_category 
		INNER JOIN faq ON (faq_category.faq_cate_id = faq.f_sub_id)
		WHERE faq_category.faq_cate_status = 'Y' 
		AND faq_use = 'Y' {$wh}";
		$a_row_all = db::getRowCount($_sql_all);

		if ($a_data) {
			return array(
				"data" => $a_data,
				"count" => $a_row,
				"countAll" => $a_row_all
			);
		}
	}

	//นับจำนวนคำถามทั้งหมด
	public static function getCountFaq($faq_cate_id = null, $fa_id = null, $s_search = null)
	{
		$wh = "";

		if ($faq_cate_id) {
			$wh .= "AND faq_category.faq_cate_id = '$faq_cate_id'";
		}

		if ($fa_id) {
			$wh .= "AND faq.fa_id = '$fa_id'";
		}

		if ($s_search) {
			$wh .= " AND faq.fa_name LIKE '%" . trim($s_search) . "%' ";
		}

		db::setDB(E_DB_NAME);
		$_sql = "SELECT faq.fa_id FROM faq_category 
		INNER JOIN faq ON (faq_category.faq_cate_id = faq.f_sub_id)
		WHERE faq_category.faq_cate_status = 'Y' 
		AND faq_use = 'Y' {$wh}";

		return db::getRowCount($_sql);
	}
}
