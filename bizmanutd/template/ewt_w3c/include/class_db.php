<?php
/** 
*------------------------
* Require configuration value for connect to data base
* Copyright (c)2003 Jira Hi
*------------------------
*/
class db2 {

    var $conn_id;
    var $result;
    var $record;
    var $db = array();
    var $port;
    var $query_count=0;
	var $sql;
	var $SID='';
	var $typeConn;

    function db2() {
        global $DB,$SID;
        $this->db = $DB;
        if(ereg(":",$this->db['host'])) {
            list($host,$port) = explode(":",$this->db['host']);
            $this->port = $port;
        } else {
            $this->port = 3306;
        }
		$this->SID = $SID;
		$this->typeConn = $this->db['dbms']; //'mysql'
    }

    function connect() {
        
		if ($this->typeConn=='mysql')
		      $this->conn_id = mysql_connect($this->db['host'].":".$this->port,$this->db['user'],$this->db['pass']);
		else if ($this->typeConn=='mssql')
             $this->conn_id = mssql_connect($this->db['host'],$this->db['user'],$this->db['pass']); 
 
        if ($this->conn_id == 0) {
            $this->sql_error("Connection Error");
        }
      
	if ($this->typeConn=='mysql') { 
	 	if (!mysql_select_db($this->db['dbName'], $this->conn_id)) {
            $this->sql_error("Database Error");
        }
	}else if ($this->typeConn=='mssql') {
		if (!mssql_select_db($this->db['dbName'], $this->conn_id)) {
            $this->sql_error("Database Error");
        }
	}	
		//echo "conn_id : ".$this->conn_id."<br>";
        return $this->conn_id;
    }

    function query($query_string) {
		if ($this->typeConn=='mysql') 
            $this->result = mysql_query($query_string,$this->conn_id);
		else if ($this->typeConn=='mssql') 
           $this->result = mssql_query($query_string,$this->conn_id);

		$this->sql = $query_string;
        $this->query_count++;
        if (!$this->result) {
            $this->sql_error("Query Error");
        }
        return $this->result;
    }

    function fetch_array($query_id) {
        if ($this->typeConn=='mysql') 
		    $this->record = mysql_fetch_array($query_id); // ,MYSQL_ASSOC
		else  if ($this->typeConn=='mssql') 
            $this->record = mssql_fetch_array($query_id);

        return $this->record;
    }
    function num_rows($query_id) {
         if ($this->typeConn=='mysql') 
		         return ($query_id) ? mysql_num_rows($query_id) : 0;
		 else  if ($this->typeConn=='mssql') 
                return ($query_id) ? mssql_num_rows($query_id) : 0;
    }

    function num_fields($query_id) {
		 if ($this->typeConn=='mysql') 
                 return ($query_id) ? mysql_num_fields($query_id) : 0;
		 else   if ($this->typeConn=='mssql') 
                  return ($query_id) ? mssql_num_fields($query_id) : 0;
    }
	 function fetch_field($query_id, $col) {
		 if ($this->typeConn=='mysql') 
                 return ($query_id) ? mysql_fetch_field($query_id, $col) : 0;
		 else   if ($this->typeConn=='mssql') 
                 return ($query_id) ? mssql_fetch_field($query_id, $col) : 0;
    }
	 function get_field_name($query_id, $col) {
		 if ($this->typeConn=='mysql') 
                 return ($query_id) ? mysql_field_name($query_id, $col) : 0;
		 else   if ($this->typeConn=='mssql') 
                  return ($query_id) ? mssql_field_name($query_id, $col) : 0;
    }
	 function get_field_format($query_id, $col) {
		 if ($this->typeConn=='mysql') 
                 return ($query_id) ? mysql_field_type($query_id, $col) : 0;
		 else   if ($this->typeConn=='mssql') 
                  return ($query_id) ? mssql_field_type($query_id, $col) : 0;
    }
	function data_seek($EXEC, $target_row, $DBTYPE="") {
				if(empty($DBTYPE)) 
				 $DBTYPE=$this->typeConn;
				 
				 if($DBTYPE=='mysql') {
					$result = mysql_data_seek($EXEC, $target_row); // return true / false				
				 } else if($DBTYPE=='mssql') {
					$result = mssql_data_seek($EXEC, $target_row);
				 } 
				return $result; 				
	}	
    function free_result($query_id) {
         if ($this->typeConn=='mysql') 
		     return mysql_free_result($query_id);
		 else  if ($this->typeConn=='mssql') 
			 return mssql_free_result($query_id);

    }

   /* function affected_rows() {
        return mysql_affected_rows($this->conn_id);
    }*/

    function close_db() {
    if ($this->typeConn=='mysql') {
		if($this->conn_id) {
            return mysql_close($this->conn_id);
        } else {
            return false;
        }
	}else  if ($this->typeConn=='mssql') {
		 if($this->conn_id) {
            return mssql_close($this->conn_id);
        } else {
            return false;
        }
	}
 }
   function table_exist($table_name, $db_name="") {
		if(!$db_name) $db_name = $this->db['dbName'];

		$table_exist = 0;
		$show = " SHOW TABLES FROM ".$db_name; // $DB["dbName"] ปกติจะเป็น dsdw_love
		$exec_show =$this->query($show);
		while($rst_show=$this->fetch_array($exec_show)) {
				if($table_name==$rst_show[0]) {
					$table_exist = 1;
					return $table_exist;
				}
		}
		return $table_exist;
   }
	function field_exist($table_name, $field_name) {
			$exec_fields = $this->query("show columns from `$table_name` ");
															
			$pass_alter = $field_exist = 0;												
																										
			while($rst_fields=$this->fetch_array($exec_fields)) {
					//echo strtolower($field_name)."==".strtolower($rst_fields["Field"])."<br>";
					if(strtolower($field_name)==strtolower($rst_fields["Field"])) {												
							$field_exist = 1;														
					}																												
				
			}
			return $field_exist;
	}
	function add_field($table_name, $field_name, $data_type) {

			$exec_fields = $this->query("show columns from `$table_name` ");
															
			$pass_alter = $field_exist = 0;												
																										
			while($rst_fields=$this->fetch_array($exec_fields)) {
					//echo strtolower($field_name)."==".strtolower($rst_fields["Field"])."<br>";
					if(strtolower($field_name)==strtolower($rst_fields["Field"])) {												
							$field_exist = 1;														
					}																												
				
			}
			//echo "<hr>";
			//echo $field_name.", $field_exist<br>";	

			if($field_exist==0) { // if field not exist
					$ALTER = " ALTER TABLE `$table_name` ADD `$field_name` $data_type "; 													
					$pass_alter = $this->query($ALTER); // เพิ่ม field ต่อท้าย										
			}

			return $pass_alter;
	}
    function sql_error($message) {
        if ($this->typeConn=='mysql') { 
        $description = mysql_error();
        $number = mysql_errno();
		}else if ($this->typeConn=='mssql') {
			 //$description = msql_error();
            // $number = sql_errno(); 
		}
        $error ="MySQL Error : $message\n";
		$error ="Sql is :".$this->sql."\n";
        $error.="Error Number: $number $description\n";
        $error.="Date        : ".date("D, F j, Y H:i:s")."\n";
        $error.="IP          : ".getenv("REMOTE_ADDR")."\n";
        $error.="Browser     : ".getenv("HTTP_USER_AGENT")."\n";
        $error.="Referer     : ".getenv("HTTP_REFERER")."\n";
        $error.="PHP Version : ".PHP_VERSION."\n";
        $error.="OS          : ".PHP_OS."\n";
        $error.="Server      : ".getenv("SERVER_SOFTWARE")."\n";
        $error.="Server Name : ".getenv("SERVER_NAME")."\n";
        $error.="Script Name : ".getenv("SCRIPT_NAME")."\n";
        echo "<b><font size=4 face=Arial>$message</font></b><hr>";
        echo "<pre>$error</pre>";
        exit();
    }

function update_data ($tb_name,$fields,$funcs,$str_pk) {
reset($fields);
if (!empty($funcs))
	 reset ($funcs);

if($str_pk!="") // Update data maode
{
    $str_pk = stripslashes($str_pk);
    $valuelist = '';
    while(list($key, $val) = each($fields))
    {
        switch (strtolower($val)) 
        {
	        case 'null':
		        break;
	        case '$set$':
		        $f = "field_$key";
		        $val = "'".($$f?implode(',',$$f):'')."'";
		        break;
	        default:
                $val = "'$val'";
		        break;
	    }
       $valuelist .= "`$key` = $val, ";
       if (!empty($funcs)){
		   if(!empty($funcs[$key]))
               $valuelist .= "$key = $funcs[$key]($val), ";
	   }
    }
    $valuelist = ereg_replace(', $', '', $valuelist);
   
    $query = "UPDATE $tb_name SET $valuelist  $str_pk";
  //echo '<br>'.$query;
}
else // Add data mode
{
    $fieldlist = '';
    $valuelist = '';
    while(list($key, $val) = each($fields))
    {
        $fieldlist .= "`$key`, ";
        switch (strtolower($val)) 
        {
	        case 'null':
		        break;
	        case '$set$':
		        $f = "field_$key";
		        $val = "'".($$f?implode(',',$$f):'')."'";
		        break;
	        default:
                $val = "'$val'";
		        break;
	        }
        if(empty($funcs[$key]))
            $valuelist .= "$val, ";
        else
            $valuelist .= "$funcs[$key]($val), ";
    }
    $fieldlist = ereg_replace(', $', '', $fieldlist);
    $valuelist = ereg_replace(', $', '', $valuelist);
    $query = "INSERT INTO $tb_name($fieldlist) VALUES ($valuelist)";
}
  //print $query;
  //exit;
   $this->query($query);
}

    function add_data ($tb_name,$fields,$funcs) 
	{
          $this->update_data($tb_name,$fields,$funcs,"");
    }
	function del_data ($tb_name,$str_pk)
	{
		 if (empty($str_pk)) {
			  print "Wraning \$str_pk is not empty in method del_data.... (you want to delete all please select function empty_tb )";
         }else{
			  $this->query("DELETE FROM ".$tb_name." ".$str_pk);
		 }
	}

	function empty_tb ($tb_name) //Empty Table (all data lose)
	{
          $this->query("DELETE FROM ".$tb_name);
	}
	 function set_cfm_action () { //Java script source

     $java_str= "<script language=\"javascript1.2\">";
     $java_str.="        function cfm_action(value_send,goto_page,cfm_value,msg) {";
     $java_str.="                     result = confirm(msg+\" \"+cfm_value+\" ใช่หรือไม่ ?\");";
	 $java_str.="		             if (result == true) {";
	 $java_str.="			                 self.location.href = goto_page+\"?\"+value_send;";
	 $java_str.="		             }";
	 $java_str.="	     } ";  
     $java_str.="  </script>";
     print ($java_str);
     }

	  function set_cfm_action_en () { //Java script source

     $java_str= "<script language=\"javascript1.2\">";
     $java_str.="        function cfm_action(value_send,goto_page,cfm_value,msg) {";
     $java_str.="                     result = confirm(msg+\" \"+cfm_value+\" \");";
	 $java_str.="		             if (result == true) {";
	 $java_str.="			                 self.location.href = goto_page+\"?\"+value_send;";
	 $java_str.="		             }";
	 $java_str.="	     } ";  
     $java_str.="  </script>";
     print ($java_str);
     }


	 function find_max ($tb_name,$field_id) {
       $result = $this->fetch_array ($this->query("select MAX($field_id) from $tb_name"));
       $max_field = "MAX($field_id)";
	   if (empty($result[$max_field]))
              return "0";
	   else
             return $result[$max_field];
   }
    
	function find_max_cond ($tb_name,$field_id,$field_cond,$value_cond) {
       $result = $this->fetch_array ($this->query("select MAX($field_id) from $tb_name where $field_cond like '$value_cond' "));
       $max_field = "MAX($field_id)";
	   if (empty($result[$max_field]))
              return "0";
	   else
             return $result[$max_field];
   }

   function find_max_cond2 ($tb_name,$field_id,$str_cond) {
       $result = $this->fetch_array ($this->query("select MAX($field_id) from $tb_name $str_cond "));
       $max_field = "MAX($field_id)";
	   if (empty($result[$max_field]))
              return "0";
	   else
             return $result[$max_field];
   }

   function get_field_type ($field_name,$tb_name)
  {
           $num_fields = $this->num_fields($this->query("select * from $tb_name"));
		   for ($i =0;$i< $num_fields;$i++) 
	      {
			   if ($field_name == mysql_field_name($this->result,$i))
		           return mysql_field_type($this->result,$i);
	      }
   }

   function get_field_type_f_sql ($field_name,$sql)
  {
           $num_fields = $this->num_fields($this->query($sql));
		   for ($i =0;$i< $num_fields;$i++) 
	      {
			   if ($field_name == mysql_field_name($this->result,$i))
		           return mysql_field_type($this->result,$i);
	      }
   }
  function get_data_rec ($sql_str)
	{
	    return $this->fetch_array($this->query ($sql_str));
	}

	function get_data_field ($sql_str,$field_name)
	{
	    $rec = $this->fetch_array($this->query ($sql_str));
		return $rec[$field_name];
	}

  function num_rows_f_sql ($sql) {
	  return $this->num_rows($this->query($sql));
  }

  /*function limit_sql($sql,$page_size,$page) {
     $num_row=$this->num_rows_f_sql ($sql);
		if ($page =="" || $page =="0" ) {
		     $page=1;
		}
	$goto = ($page-1)*$page_size;	// หาหน้าที่จะกระโดดไป
    $sql_limit = $sql." limit $goto,$page_size";
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}*/

	function limit_sql_mssql($tbName,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// หาหน้าที่จะกระโดดไป

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." order by ".$fieldOrderby.") order by ".$fieldOrderby;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}

	/*function limit_sql_mssql_cond($tbName,$cond,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// หาหน้าที่จะกระโดดไป

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." where ".$cond." order by ".$fieldOrderby.") and ".$cond." order by ".$fieldOrderby;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}*/
	
	function limit_sql_mssql_cond($tbName,$cond,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// หาหน้าที่จะกระโดดไป

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." where ".$cond." order by ".$fieldOrderby.") and ".$cond." order by ".$fieldOrderby;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}

	function limit_sql_mssql_cond_order($tbName,$cond,$typeOrder,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// หาหน้าที่จะกระโดดไป

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." where ".$cond." order by ".$fieldOrderby." ".$typeOrder.") and ".$cond." order by ".$fieldOrderby." ".$typeOrder;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}
	
	function limit_sql_mssql_cond_order_join($tbName,$join,$cond,$typeOrder,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// หาหน้าที่จะกระโดดไป

	$sql_limit = "select top ".$page_size." * from ".$tbName." ".$join." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." ".$join." where ".$cond." order by ".$typeOrder.") and ".$cond." order by ".$typeOrder;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}
	
}//end class

?>
