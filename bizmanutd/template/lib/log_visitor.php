<?php
	function write_log_visitor($module,$module_d,$detail)
		{
		global $db,$PHPSESSID;
			$date = date("Y-m-d");
			$time = date("H:i:s");
			$date_t = date("d/m/Y H:i:s");
				if($_SERVER["REMOTE_ADDR"]) 
					{
						$IPn = $_SERVER["REMOTE_ADDR"];
					}	 
			else 
					{
						$IPn = $_SERVER["REMOTE_HOST"];
					}
			$insert = "INSERT INTO log_visitor (log_date , log_time , log_mid , log_user , log_date_text , log_ip , log_module , log_module_detail , log_detail ) VALUES ('$date', '$time', '".$_SESSION["EWT_MID"]."', '".$_SESSION["EWT_NAME"]."', '$date_t', '$IPn', '$module', '".$PHPSESSID."', '$detail')";	
			return $db->query($insert);
		}


?>
