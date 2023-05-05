<?php
class noti
{
	public static function getNoti($s_user=false,$s_page,$s_limit)    
	{		
		$wh	= "";
		if($s_user)  
		{
			$wh .= "AND noti_user = '".$s_user."' ";   	 
		}
		$perpage = $s_limit;  
		if (isset($s_page)) {  
		$page = $s_page;
		} else {
		$page = 1;
		}
		$start = ($page - 1) * $perpage;
		$_sql 	= "	SELECT 
					* 
					FROM stat_noti 
					WHERE  noti_status = 'Y'  {$wh}  ORDER BY noti_id DESC LIMIT {$start},{$perpage}"; 	  	
		$a_row	= db::getRowCount($_sql);
		$a_data = db::getFetchAll($_sql,PDO::FETCH_ASSOC);	 
		if($a_data)
		{
			return $a_data; 
		}
	}
}
?>