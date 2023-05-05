<?php

class org
{ 

	public static function getCountUser($s_type)
	{   
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
  	
	
	if($s_type == '1'){
    $_sql = $db->query("SELECT COUNT(gen_user_id) AS num 
					   FROM gen_user 
					   LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
					   WHERE `emp_type`.`emp_type_status` = '2'  ");		  	
	$a_count = $db->db_fetch_array($_sql);
	}
	else if($s_type == '2'){
	$_sql = $db->query("SELECT COUNT(gen_user_id) AS num 
					   FROM gen_user 
					   LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
					   WHERE `emp_type`.`emp_type_status` = '2' AND `gen_user`.`status` = '1' ");		  	
	$a_count = $db->db_fetch_array($_sql);
	}
	else if($s_type == '3'){
	$_sql = $db->query("SELECT COUNT(gen_user_id) AS num 
					   FROM gen_user 
					   LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
					   WHERE `emp_type`.`emp_type_status` = '2' AND `gen_user`.`status` = '2'");		  	
	$a_count = $db->db_fetch_array($_sql);	
	}
	
	
    return $a_count['num'];	
	}
  
	public static function getCountOrg($s_type)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
		
	if($s_type == '1'){
	  $_sql = $db->query("SELECT COUNT(org_id) AS num 
					   FROM `org_name` 					   
					   WHERE `org_name`.`parent_org_id` LIKE '0001_%' ");		  	
	  $a_count = $db->db_fetch_array($_sql);
	  
	}else if($s_type == '2'){
	 $_sql = $db->query("SELECT COUNT(org_id) AS num 
					   FROM `org_name` 					   
					   WHERE `org_name`.`parent_org_id` LIKE '0001_%' AND `org_name`.`org_status` = '' OR `org_name`.`org_status` = 'Y' ");		  	
	  $a_count = $db->db_fetch_array($_sql);
	  
	}else if($s_type == '3'){
	 $_sql = $db->query("SELECT COUNT(org_id) AS num 
					   FROM `org_name` 					   
					   WHERE `org_name`.`parent_org_id` LIKE '0001_%' AND  `org_name`.`org_status` = 'N' ");		  	
	  $a_count = $db->db_fetch_array($_sql);
	}
	
	  return  $a_count['num'];	
	}
  
	public static function getCountPosition($s_type)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
	
	if($s_type == '1'){	
	$_sql = $db->query("SELECT COUNT(pos_id) AS num 
					    FROM `position_name` 					   
					    ");		  	
	  $a_count = $db->db_fetch_array($_sql);
	  
	}else if($s_type == '2'){
	 $_sql = $db->query("SELECT COUNT(pos_id) AS num 
					     FROM `position_name`
					     WHERE `position_name`.`pos_status` = 'Y' OR `position_name`.`pos_status` = ''
					     ");		  	
	  $a_count = $db->db_fetch_array($_sql);
	  
	}else if($s_type == '3'){
	 $_sql = $db->query("SELECT COUNT(pos_id) AS num 
					     FROM `position_name`
					     WHERE `position_name`.`pos_status` = 'N' 
					     ");		  			  	
	  $a_count = $db->db_fetch_array($_sql);
	  
	}  
	  return  $a_count['num'];	
	}
  
	public static function getTitle($s_title)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
	  $db->query("USE ".$EWT_DB_USER);	
	  $_sql = $db->query("SELECT title_thai 
					   FROM title 					   
					   WHERE `title`.`title_id` = '{$s_title}' ");		  	
	  $a_data = $db->db_fetch_array($_sql);
	  
	  return $a_data['title_thai'];	
	}
  
	public static function getOrgGroup($u_id)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
	$db->query("USE ".$EWT_DB_USER);	
	$_sql = $db->query("SELECT org_id 
					   FROM gen_user 					   
					   WHERE `gen_user`.`gen_user_id` = '{$u_id}' ");		  	
	  $a_data = $db->db_fetch_array($_sql);
	  
	  return $a_data['org_id'];	
	}
  
	public static function getOrg($s_org)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
	$db->query("USE ".$EWT_DB_USER);	
	$_sql = $db->query("SELECT name_org
						  FROM org_name 					   
					      WHERE `org_name`.`org_id` = '{$s_org}' ");		  	
	$a_data = $db->db_fetch_array($_sql);
	  
	return $a_data['name_org'];	
	}
  
	public static function getGenUser($u_id)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
	$db->query("USE ".$EWT_DB_USER);	
	$_sql = $db->query("SELECT *
						  FROM `gen_user`
						  LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		                  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		                  LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		                  WHERE `gen_user`.`gen_user_id` = '{$u_id}' ");	
		$a_rows  = $db->db_num_rows($_sql);
		if($a_rows > 0){
		$a_data = $db->db_fetch_array($_sql);
	  
	  return self::getTitle($a_data['title_thai']).' '.$a_data['name_thai'].' '.$a_data['surname_thai'];
	  
		}	  
	}
	
	public static function getUser($u_id)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;

	$_sql = $db->query("SELECT gen_user.*
						  FROM `gen_user`
						  LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		                  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		                  LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		                  WHERE `gen_user`.`gen_user_id` = '{$u_id}' ");	
	$a_rows = $db->db_num_rows($_sql);
		if($a_rows > 0){
			$a_data	= $db->db_fetch_array($_sql);
			return $a_data;
		}	  
	}

	public static function getUserldep($gen_user)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;

	$_sql = $db->query("SELECT *
						  FROM `gen_user`
						  LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		                  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		                  LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		                  WHERE `gen_user`.`gen_user` = '{$gen_user}' ");	
	$a_rows = $db->db_num_rows($_sql);
	if($a_rows > 0){
	  
	return $a_data	= $db->db_fetch_array($_sql);
	  
		}	  
	}
	
	public static function getGenUserImg($u_id)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;

	$_sql = $db->query("SELECT *
						  FROM `gen_user`
						  LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		                  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		                  LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		                  WHERE `gen_user`.`gen_user_id` = '{$u_id}' ");	
		$a_rows  = $db->db_num_rows($_sql);
		if($a_rows > 0){
		$a_data = $db->db_fetch_array($_sql);
		$path_image = $a_data['path_image'];
		$uploaddir = "../ewt/pic_upload/";
		if($path_image != ''){
			$path_image1 = $uploaddir.$path_image;
		if(file_exists($path_image1)){
			$a_image = $path_image1;
			}else{
				$a_image = "../EWT_ADMIN/images/user001.png";
			}
		}else{
		$a_image = "../EWT_ADMIN/images/user001.png";
		}
		
		return $a_image;
	  
		}	  
	}
  
	public static function genUserTop($s_org,$s_uid)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
	$db->query("USE ".$EWT_DB_USER);	
	  
	$s_sql_omc = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$s_org}' AND  omc_uid = '{$s_uid}' AND omc_leval = '0'   ");
	$a_data_omc= $db->db_fetch_array($s_sql_omc);
	  
	$_sql = $db->query("SELECT *
						  FROM `gen_user`
						  LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		                  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		                  LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		                  WHERE `gen_user`.`gen_user_id` = '{$a_data_omc['omc_name']}' ");	
	$a_rows  = $db->db_num_rows($_sql);
	if($a_rows > 0){
		$a_data = $db->db_fetch_array($_sql);
	    $_image = '<img src="'.org::getGenUserImg($a_data['gen_user_id']).'" alt="" class="img-circle img-rounded " style="width:24px;height:24px;" />'; 
		return $_image.' '.self::getTitle($a_data['title_thai']).''.$a_data['name_thai'].' '.$a_data['surname_thai'];	  
		}	  
	}


	public static function genUserTop5($s_limit)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
	
    $s_data = array();
	$_sql = $db->query("SELECT `gen_user_id`
						FROM `gen_user`
						LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		                LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		                LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		                WHERE `emp_type`.`emp_type_status` = '2' 
						ORDER BY `gen_user`.`gen_user_id` DESC ,`gen_user`.`create_date` DESC LIMIT 0,{$s_limit}
						");	
	$a_rows  = $db->db_num_rows($_sql);
	if($a_rows > 0){
		while($a_data = $db->db_fetch_array($_sql)){
		  array_push($s_data,$a_data['gen_user_id']);
		}		
	}
	return $s_data;
	}
	
	public static function genOrgGroupTop5($s_limit)
	{
	global $db,$EWT_DB_USER,$EWT_DB_NAME;
	
    $s_data = array();
	$_sql = $db->query("SELECT `org_id`
						FROM `org_name`	
						WHERE parent_org_id LIKE '0001_%'
						ORDER BY `org_name`.`org_id` DESC ,`org_name`.`org_createdate` DESC LIMIT 0,{$s_limit}
						");	
	$a_rows  = $db->db_num_rows($_sql);
	if($a_rows > 0){
		while($a_data = $db->db_fetch_array($_sql)){
		 if($a_data['org_id']){
		  array_push($s_data,$a_data['org_id']);
		 }
		}		
	}
	return $s_data;
	}
 
	public static function chkStatusUser($s_status)
	{
	if($s_status){
		if($s_status == '1'){
			$s_type = '  <i class="far fa-check-circle text-success"></i> ใช้งาน';
		}else if($s_status == '2'){
			$s_type = '	  <i class="far fa-times-circle text-danger"></i> ไม่ใช้งาน';
		}else{
			$s_type = '';
		}		
		 return $s_type;	
		}  
	}
  
	public static function chkStatusOrg($s_status)
	{
	  if($s_status == ''){
			$s_status = 'Y';
		}
	if($s_status){	
		if($s_status == 'Y'){
			$s_type = '  <i class="far fa-check-circle text-success"></i> ใช้งาน';
		}else if($s_status == 'N'){
			$s_type = '	  <i class="far fa-times-circle text-danger"></i> ไม่ใช้งาน';
		}else{
			$s_type = '';
		}		
		 return $s_type;	
		}  
	}
	public static function getCountModule()
	{   
		global $db,$EWT_DB_USER,$EWT_DB_NAME; 
		$db->query("USE ".$EWT_DB_USER);  
		$_sql = $db->query("SELECT m_id 
							FROM web_module_ewt 							
							WHERE `web_module_ewt`.`m_status` = 'Y' AND  `web_module_ewt`.`m_admin` = 'N' "); 		  	
		$a_count = $db->db_fetch_array($_sql);
		$a_rows  = $db->db_num_rows($_sql);
		return $a_rows;	
	}
  
	//เรียกข้อมูลกรุ๊ป
    public static function getArticleOrg($c_id)
    {
		global $db;
        $wh = "";

        if ($c_id) {
            $wh .= " AND c_id = '$c_id' ";
        }

        $_sql = $db->query("SELECT * FROM article_group WHERE 1=1 {$wh} LIMIT 1");
		$a_data = $db->db_fetch_array($_sql, MYSQLI_ASSOC);
        $a_row = $db->db_num_rows($_sql);

        if($a_data && $c_id != 0){
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }
}
