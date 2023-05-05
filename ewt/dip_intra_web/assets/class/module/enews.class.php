<?php
class enews
{
	public static function genNMember($s_email) 
	{
		$_sql 	= "SELECT * FROM n_member WHERE  m_email = '{$s_email}' ";	    	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	}
	public static function genNGroup($s_gid)   
	{
		$wh	= "";
		if($s_gid) 
		{
			$wh .= "AND g2 = '{$s_gid}'"; 	
		}
		$_sql 	= "SELECT * FROM n_group LEFT JOIN article_group ON n_group.g_name = article_group.c_id  WHERE n_group.g_name != '' AND article_group.c_name != '' {$wh} ";	    	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 
		if($a_data)
		{
			return $a_data;
		}
	}
	
	public static function genNGroupMember($s_gid)    
	{
		$wh	= "";
		if($s_gid) 
		{
			$wh .= " m_id = '{$s_gid}'"; 	
		}
		$_sql 	= "SELECT * FROM n_group_member WHERE  m_id = '{$s_gid}' ";	     	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 
		if($a_data)
		{
			return $a_data;
		}
	}

	public static function genArticleDetail($s_nid) 
	{
		
		//$date_now =  date('Y-m-d');
		//$wh	= "AND ((banner_show_start = '' AND banner_show_end = '')";
		//$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";
		$_sql 	= "SELECT * FROM article_detail WHERE  n_id = '{$s_nid}' ORDER BY at_type_row ASC  ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	}

	public static function genArticleCate($s_cid) 
	{
		
		//$date_now =  date('Y-m-d');
		//$wh	= "AND ((banner_show_start = '' AND banner_show_end = '')";
		//$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";
		$_sql 	= "SELECT * FROM article_group  WHERE  c_id = '{$s_cid}' ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	}
	public static function genArticleAttach($s_nid) 
	{
		
		$_sql 	= "SELECT * FROM article_attach WHERE  n_id = '{$s_nid}' ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	} 
	public static function genArticleMore($s_cid)   
	{
		$wh	= "";
		if($s_cid)
		{
			$wh .= "AND c_id = '{$s_cid}'";	
		}
				
		$_sql 	= "SELECT * FROM  article_list WHERE  n_approve = 'Y' {$wh} ORDER BY n_id DESC  ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	}
	public static function genArticleMoreLimit($s_cid,$s_page,$s_limit)    
	{
		$wh	= "";
		if($s_cid)
		{
			$wh .= "AND c_id = '{$s_cid}'"; 	
		}
		$perpage = $s_limit; 
		if (isset($s_page)) { 
		$page = $s_page;
		} else {
		$page = 1;
		}
		$start = ($page - 1) * $perpage;
	
		$_sql 	= "SELECT * FROM  article_list WHERE  n_approve = 'Y' {$wh} ORDER BY n_id DESC LIMIT {$start},{$perpage} ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	} 
	public static function genArticleSearch($s_search)      
	{
		$wh	= "";
		
		if($s_search)
		{
			$wh .= "AND n_topic LIKE '%".trim($s_search)."%' ";   	 
		}
		 
		$_sql 	= "SELECT * FROM  article_list WHERE  n_approve = 'Y' {$wh} ORDER BY n_id DESC  ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	}
	public static function genArticleSearchLimit($s_search,$s_page,$s_limit)      
	{
		$wh	= "";
		
		if($s_search)
		{
			$wh .= "AND n_topic LIKE '%".trim($s_search)."%' ";    	 
		}
		$perpage = $s_limit; 
		if (isset($s_page)) { 
		$page = $s_page;
		} else {
		$page = 1;
		}
		$start = ($page - 1) * $perpage; 
		$_sql 	= "SELECT * FROM  article_list WHERE  n_approve = 'Y' {$wh} ORDER BY n_id DESC LIMIT {$start},{$perpage} ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	} 
	public static function genArticleTag($s_nid)         
	{
		$wh	= "";
		if($s_nid)
		{
			$wh .= "AND n_id = '{$s_nid}'"; 	
		}
		
		$_sql 	= "SELECT * FROM  article_tag WHERE  1=1 {$wh}  ORDER BY tag_id DESC";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	  
		if($a_data)
		{
			return $a_data;
		}
	}
	public static function genArticleTagSearch($s_search)      
	{
		$wh	= "";
		
		if($s_search)
		{
			$wh .= "AND tag_id = '".trim($s_search)."' ";   	 
		}
		 
		$_sql 	= "SELECT * FROM  article_list INNER JOIN article_tag ON article_list.n_id =  article_tag.n_id WHERE  n_approve = 'Y' {$wh} ORDER BY article_list.n_id DESC  ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	}
	public static function genArticleTagSearchLimit($s_search,$s_page,$s_limit)      
	{
		$wh	= "";
		
		if($s_search)
		{
			$wh .= "AND tag_id = '".trim($s_search)."' ";   	 
		}
		$perpage = $s_limit; 
		if (isset($s_page)) { 
		$page = $s_page;
		} else {
		$page = 1;
		}
		$start = ($page - 1) * $perpage;  
		$_sql 	= "SELECT * FROM  article_list INNER JOIN article_tag ON article_list.n_id =  article_tag.n_id WHERE  n_approve = 'Y' {$wh} ORDER BY article_list.n_id  DESC LIMIT {$start},{$perpage} ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	} 
	public static function genHashtag($s_tid,$s_limit)       
	{
		$wh	= "";
		if($s_tid)
		{
			$wh .= "AND tag_id = '{$s_tid}'"; 	
		}
		$perpage = $s_limit; 
		if (isset($s_page)) { 
		$page = $s_page;
		} else {
		$page = 1;
		}
		$start = ($page - 1) * $perpage; 
		$_sql 	= "SELECT * FROM  tag WHERE  tag_status = 'Y' {$wh}  ORDER BY tag_count DESC LIMIT {$start},{$perpage} ";	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC); 	 
		if($a_data)
		{
			return $a_data;
		}
	}
	
}
?>
   