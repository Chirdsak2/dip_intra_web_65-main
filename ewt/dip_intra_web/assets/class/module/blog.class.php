<?php
class blog
{
	public static function getBlog($s_uid)
	{
		$wh	= "";
		if ($s_uid) {
			$wh .= "AND blog_user = '{$s_uid}'";
		}
		$_sql 	= "	SELECT * FROM " . E_DB_USER . ".blog_list WHERE blog_status = 'Y' AND blog_approve = 'Y' {$wh}";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	public static function getBlogTop($s_limit, $s_uid = null)
	{
		$wh	= "";
		if ($s_uid) {
			$wh .= "gen_user_id = '{$s_uid}'";
		}
		
		$_sql = "SELECT * FROM " . E_DB_USER . ".blog_detail
				INNER JOIN " . E_DB_USER . ".blog_list ON blog_list.blog_user = blog_detail.blog_id
				INNER JOIN " . E_DB_USER . ".gen_user ON gen_user.gen_user_id = blog_detail.blog_id
				WHERE status = '1' 
				ORDER BY vote_rate DESC LIMIT 0,{$s_limit}";

		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	public static function getBlogNews($s_limit, $s_uid = null)
	{
		$wh	= "";
		if ($s_uid) {
			$wh .= "gen_user_id = '{$s_uid}'";
		}

		$_sql = "SELECT * FROM " . E_DB_USER . ".blog_list
				INNER JOIN " . E_DB_USER . ".gen_user ON gen_user.gen_user_id = blog_list.blog_user
				WHERE blog_status = 'Y' AND blog_approve = 'Y' 
				ORDER BY blog_id DESC LIMIT 0,{$s_limit}";

		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);

		if ($a_data) {
			return $a_data;
		}
	}

	public static function chkBlog($s_uid)
	{
		$wh	= "";
		if ($s_uid) {
			$wh .= "AND blog_user = '{$s_uid}'";
		}

		$_sql 	= "	SELECT * FROM " . E_DB_USER . ".blog_listWHERE blog_status = 'Y' AND blog_approve = 'Y' {$wh} ";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return true;
		} else {
			return false;
		}
	}

	public static function getBlogPost($s_uid = false)
	{
		$wh	= "";
		if ($s_uid) {
			$wh .= "AND blog_id = '{$s_uid}'";
		}
		$_sql 	= "	SELECT * FROM " . E_DB_USER . ".blog_detailWHERE 1=1 {$wh} ORDER BY blog_detail_id DESC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	public static function getBlogComment($s_id = false)
	{
		$wh	= "";
		if ($s_id) {
			$wh .= "AND blog_detail_id = '{$s_id}'";
		}
		$_sql 	= "	SELECT * FROM " . E_DB_USER . ".blog_comment WHERE 1=1 {$wh} ORDER BY blog_comment_id DESC";
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql);
		if ($a_data) {
			return $a_data;
		}
	}

	public static function CheckLike($s_id = false)
	{
		if ($s_id) {
			$strSessionID = session_id();
			$_sql = "SELECT * FROM " . E_DB_USER . ".blog_post_like WHERE post_id = '{$s_id}' AND  user = '" . user::getUserID() . "' ";
			$a_data = db::getFetchAll($_sql);
			$a_row	= db::getRowCount($_sql);
			return $a_row;
		}
	}

	public static function getBlogImg($s_uid)
	{
		if ($s_uid) {
			$a_data = self::getBlog($s_uid);
			if ($a_data) {
				foreach ((array)$a_data as $_item) {
					if ($_item['blog_picture']) {
						$a_image = 'userpic/blog/' . $_item['blog_picture'];
					} else {
						$a_image = org::getUserImg($s_uid);
					}
				}
			}
		}
		return $a_image;
	}
}
