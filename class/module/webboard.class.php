<?php
class webboard{
	
	 public static function getDelnoti($s_type=false) 
    {
        global $db;
		$_wh = "";
		if($s_type)
		{
			$_wh .= "AND request_type = '{$s_type}'";
		}	
        $_sql = $db->query("SELECT * FROM w_question_sts_request WHERE 1=1 {$_wh} ORDER BY request_createdate DESC"); 

        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_data[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }
	public static function getCate($s_cid=false)  
    {
        global $db;
		$_wh = "";
		if($s_cid)
		{
			$_wh .= "AND c_use = '{$s_cid}'";
		}				
        $_sql = $db->query("SELECT * FROM w_cate WHERE 1=1 {$_wh} "); 

        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC))
		{
            $a_data[] = $row;
        }
        $a_row = $db->db_num_rows($_sql);
        if($a_data) 
		{
           return  $a_row;
        }
    }	
	public static function getQuestion($s_sid=false)
    {
        global $db;
		$_wh = "";
		if($s_sid || $s_sid == '0' )
		{
			$_wh .= "AND s_id = '{$s_sid}'";
		}				
        $_sql = $db->query("SELECT * FROM w_question WHERE 1=1 {$_wh} ");   

        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC))
		{
            $a_data[] = $row;
        }
        $a_row = $db->db_num_rows($_sql); 
        if($a_data) 
		{
           return  $a_row;
        }
    }
	public static function getAnswer($s_cid=false)
    {
        global $db;
		$_wh = "";
		if($s_cid)
		{
			$_wh .= "AND c_id = '{$s_cid}'";
		}				
        $_sql = $db->query("SELECT * FROM w_answer WHERE 1=1 {$_wh} "); 

        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC))
		{
            $a_data[] = $row;
        }
        $a_row = $db->db_num_rows($_sql);
        if($a_data) 
		{
           return  $a_row;
        }
    }		
}
?>