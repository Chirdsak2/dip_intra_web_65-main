<?php
class user
{ 
  
	public static function chkConfirmPass($s_pass,$s_repass)
	{   
		if($s_pass && $s_repass)
		{
			if(trim($s_pass) == trim($s_repass))
			{
			return true;
				}else{
				return false;	
				}					
		}else{
			return false;	
		}		
	}	
	
	public static function chkIDCard($s_idcard)
	{   
		if($s_idcard)
		{
			global $db;			
			$_sql = $db->query("SELECT *
						        FROM `gen_user`
		                        WHERE `gen_user`.`emp_id` = '{$s_idcard}' ");	
			$a_rows  = $db->db_num_rows($_sql);
			if($a_rows > 0){
			$a_data = $db->db_fetch_array($_sql);
		
			return false;	  
			}else{
				return true;
			}	  			
		}		
	}	
	
	public static function chkEmailPerson($s_email)
	{   
		if($s_email)
		{
			global $db;			
			$_sql = $db->query("SELECT *
						  FROM `gen_user`
		                  WHERE `gen_user`.`email_person` = '{$s_email}' ");	
			$a_rows  = $db->db_num_rows($_sql);
			if($a_rows > 0){
			$a_data = $db->db_fetch_array($_sql);
		
			return false;	  
			}else{
				return true;
			}	  			
		}		
	}
	
	public static function chkPassword($s_pass)
	{   
		if($s_pass)
		{		
			return false;
	
		}		
	}
	
	public static function chkUsername($s_uname)
	{   	
		if($s_uname)
		{
			global $db;			
			$_sql = $db->query("SELECT *
						        FROM `gen_user`
		                        WHERE `gen_user`.`gen_user` = '{$s_uname}' ");	
			$a_rows  = $db->db_num_rows($_sql);
			if($a_rows > 0){
			$a_data = $db->db_fetch_array($_sql);
		
			return false;	  
			}else{
				return true;
			}	  				    	
		}			
	}

	public static function encryptPassword($s_password)
	{
		if($s_password)
		{
		$s_source = md5($s_password);
		$s_password = 'บิซโพเทนเชียล#'.$s_source ;
		$s_password = hash('SHA512', $s_password);
		return $s_password;
		}
	}

}
?>