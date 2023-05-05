<?php 
class sys
{  
	public static function getPage()
	{
			
		$result = basename($_SERVER['SCRIPT_FILENAME']); 
		
		return $result;
	}
	
	public static function getModuleImage($s_code)
	{			
		if($s_code) 
		{
			global $db,$EWT_DB_USER,$EWT_DB_NAME;	
			$db->query("USE ".$EWT_DB_USER);  
			$_sql = $db->query("SELECT 
								*
						        FROM `web_module_ewt`
		                        WHERE `web_module_ewt`.`m_code` = '{$s_code}' ");	
			$a_rows  = $db->db_num_rows($_sql);
			
			if($a_rows > 0)
			{
				$a_data = $db->db_fetch_array($_sql);
		
				return $a_data['m_image'];	  
			}
			else
			{
				return true;
			}	  				    	
		}		
		
		return $result;
		
	}
	
	public static function save_log($s_module,$s_module_detail,$s_detail)
	{ 	
		
		$s_data = array();
		
		$s_data['log_date']    			=	datetimetool::getnow('Y-m-d');
		$s_data['log_time']   			=	datetimetool::getnow('H:i:s');
		$s_data['log_mid']   			=	$_SESSION['EWT_SMID'];
		$s_data['log_user']  			=	$_SESSION['EWT_SMUSER'];
		$s_data['log_date_text']		=	datetimetool::getnow('d/m/Y H:i:s');
		$s_data['log_ip']      			=	get_client_ip();
		$s_data['log_module']   		=	$s_module;
		$s_data['log_module_detail']	= 	$s_module_detail;
		$s_data['log_detail']   		= 	stripslashes(htmlspecialchars($s_detail,ENT_QUOTES));

		$result = insert('log_user',$s_data);
		
		return $result;	
	}
	
	public static function save_LogSendMail($s_id,$s_module,$s_proc,$s_email,$s_detail,$s_header,$s_subject,$s_status,$s_user)
	{  
		$s_data = array();
		$s_data['id'] 				= 	$s_id;
		$s_data['log_module'] 		= 	$s_module; 
		$s_data['log_proc'] 		= 	$s_proc;
		$s_data['log_email'] 		= 	$s_email; 
		$s_data['log_detail'] 		= 	$s_detail; 
		$s_data['log_header'] 		= 	$s_header; 
		$s_data['log_subject'] 		= 	$s_subject;
		$s_data['log_status'] 		= 	$s_status;
		$s_data['log_create_date'] 	= 	datetimetool::getnow('Y-m-d');
		$s_data['log_create_time'] 	= 	datetimetool::getnow('H:i:s');
		$s_data['log_timestamp'] 	= 	datetimetool::getnow();
		$s_data['log_user'] 		=	$s_user; 
		
		$result = insert('log_sendmail',$s_data); 
		
		return $result;	
		
		unset($s_data); 
	}	 
	  
	public static function save_Noti($s_status,$s_title,$s_module,$s_user,$s_link)  
	{  
		$s_data = array();
		$s_data['noti_module'] 		= $s_module;
		$s_data['noti_title']		= $s_title; 
		$s_data['noti_link']		= $s_link;
		$s_data['noti_user'] 		= $s_user;	
		$s_data['noti_timestamp'] 	= datetimetool::getnow();
		$s_data['noti_status']		= $s_status;
		$s_data['noti_date']		= datetimetool::getnow('Y-m-d');
		$s_data['noti_time']		= datetimetool::getnow('H:i:s');
		
		$result = insert('stat_noti',$s_data);    
		
		return $result;	
		
		unset($s_data); 
	}	
	
}
?>