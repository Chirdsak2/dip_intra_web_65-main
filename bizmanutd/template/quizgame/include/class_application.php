<?php
class application {
  		
	  var $db;
	  var $disp;
	  var $th_today;
	  var $app_session = array();
	  function application() {
          global $CLASS, $_SESSION;

         $this->db     = $CLASS['db'];
		 $this->disp  = $CLASS['disp'];

		 $this->app_session =  $_SESSION;
	  }	  	 
	 function count_user_chat($room_name="") {
	 		$sql = "SELECT count(log_id) AS userCount  FROM  log_chat_room WHERE room_num = '".$room_name."' ";
			//echo "$sql<br>";
			$exec = $this->db->query($sql);	
			$rec = $this->db->fetch_array($exec);
			return $rec[userCount]*1;			
	 }
} // End Class
?>