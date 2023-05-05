<?php
/** 
*------------------------
* Require configuration value for connect to data base
* Copyright (c)2003 
*------------------------
*/
class db {

    var $conn_id;
    var $result;
    var $record;
    var $db = array();
    var $port;
    var $query_count=0;
	var $sql;
	var $SID='';
	var $typeConn;
	var $connExt;
	var $openExt; 
	var $cursorExt; 

    function db() {
        global $DB,$SID;
        $this->db = $DB;
        if(ereg(":",$this->db['host'])) {
            list($host,$port) = explode(":",$this->db['host']);
            $this->port = $port;
        } else {
            $this->port = 3306;
        }
		$this->SID = $SID;
		$this->typeConn = 'mysql';
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
		/* เธเธฒเธเธเธฃเธฑเนเธเธเนเธ•เนเธญเธเนเธเนเธเธฐ เธญเธขเนเธฒเน€เธเธดเนเธเธฅเธ
			mysql_query("SET Character_set_results=utf8") or die("Query Character Error<br>");
			mysql_query("SET Character_set_client=utf8");
			mysql_query("SET Character_set_cennection=utf8");
			mysql_query("SET Collation_connection=utf8_general_ci");
			mysql_query("SET Character_database=utf8_general_ci");
			mysql_query("SET Character_server=utf8_general_ci");
			*/
	//		mysql_query("SET Character_set_results=utf8") or die("Query Character Error<br>");
			//mysql_query("SET Character_set_client=utf8");
		//	mysql_query("SET Character_set_cennection=utf8");
			/* 
			mysql_query("SET Collation_connection=utf8_general_ci");
			mysql_query("SET Character_database=utf8_general_ci");
			mysql_query("SET Character_server=utf8_general_ci");
			*/ 
	
			mysql_query("SET NAMES UTF8");
			mysql_query("SET Character_set_results=utf8") or die("Query Character Error<br>");
			mysql_query("SET Character_set_client=utf8");
			mysql_query("SET Character_set_cennection=utf8");
			/*mysql_query("SET Collation_connection=utf8_unicode_ci");
			mysql_query("SET Character_database=utf8_unicode_ci");
			mysql_query("SET Character_server=utf8_unicode_ci");			
			*/
			
	}else if ($this->typeConn=='mssql') {
		if (!mssql_select_db($this->db['dbName'], $this->conn_id)) {
            $this->sql_error("Database Error");
        }
	}
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
		    $this->record = $db->db_fetch_array($query_id); // ,MYSQL_ASSOC
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
       $valuelist .= "$key = $val, ";
       if (!empty($funcs)){
		   if(!empty($funcs[$key]))
               $valuelist .= "$key = $funcs[$key]($val), ";
	   }
    }
    $valuelist = ereg_replace(', $', '', $valuelist);
   
    $query = "UPDATE $tb_name SET $valuelist  $str_pk";
  
}
else // Add data mode
{
    $fieldlist = '';
    $valuelist = '';
    while(list($key, $val) = each($fields))
    {
        $fieldlist .= "$key, ";
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
     $java_str.="                     result = confirm(msg+\" \"+cfm_value+\" เนเธเนเธซเธฃเธทเธญเนเธกเน ?\");";
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

  function limit_sql($sql,$page_size,$page) {
     $num_row=$this->num_rows_f_sql ($sql);
		if ($page =="" || $page =="0" ) {
		     $page=1;
		}
	$goto = ($page-1)*$page_size;	// เธซเธฒเธซเธเนเธฒเธ—เธตเนเธเธฐเธเธฃเธฐเนเธ”เธ”เนเธ
    $sql_limit = $sql." limit $goto,$page_size";
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}

	function limit_sql_mssql($tbName,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// เธซเธฒเธซเธเนเธฒเธ—เธตเนเธเธฐเธเธฃเธฐเนเธ”เธ”เนเธ

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." order by ".$fieldOrderby.") order by ".$fieldOrderby;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}

	/*function limit_sql_mssql_cond($tbName,$cond,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// เธซเธฒเธซเธเนเธฒเธ—เธตเนเธเธฐเธเธฃเธฐเนเธ”เธ”เนเธ

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." where ".$cond." order by ".$fieldOrderby.") and ".$cond." order by ".$fieldOrderby;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}*/
	
	function limit_sql_mssql_cond($tbName,$cond,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// เธซเธฒเธซเธเนเธฒเธ—เธตเนเธเธฐเธเธฃเธฐเนเธ”เธ”เนเธ

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." where ".$cond." order by ".$fieldOrderby.") and ".$cond." order by ".$fieldOrderby;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}

	function limit_sql_mssql_cond_order($tbName,$cond,$typeOrder,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// เธซเธฒเธซเธเนเธฒเธ—เธตเนเธเธฐเธเธฃเธฐเนเธ”เธ”เนเธ

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." where ".$cond." order by ".$fieldOrderby." ".$typeOrder.") and ".$cond." order by ".$fieldOrderby." ".$typeOrder;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}
	
	function limit_sql_mssql_cond_order_join($tbName,$join,$cond,$typeOrder,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// เธซเธฒเธซเธเนเธฒเธ—เธตเนเธเธฐเธเธฃเธฐเนเธ”เธ”เนเธ

	$sql_limit = "select top ".$page_size." * from ".$tbName." ".$join." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." ".$join." where ".$cond." order by ".$typeOrder.") and ".$cond." order by ".$typeOrder;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}
	
		function connectExt($HOST, $USER, $PASSWORD, $DBNAME, $DBTYPE) {	
			  
			 if($DBTYPE=='MYSQL') {					
				 $this->connExt = @mysql_connect($HOST, $USER, $PASSWORD);
				 //echo "ext : ".$this->connExt."<br>";
			 } else if($DBTYPE=='MSSQL') {
			   // echo " $HOST, $USER, $PASSWORD ";
				$this->connExt = @mssql_connect($HOST, $USER, $PASSWORD);
			 } else if($DBTYPE=='ACCESS'){
							 
				 $DATASOURCE = $HOST;
				
				 echo "Driver={Microsoft Access Driver (*.mdb)}; DBQ=".$DATASOURCE."<br>";
				 //$this->connExt = new COM('ADODB.Connection') or exit('Cannot start ADO.');
				//$this->connExt->Open("Provider=Microsoft.Jet.OLEDB.4.0;Data Source=".$DATASOURCE.";User Id=Admin;"); 
				//$this->connExt->Open("Provider=Microsoft.Jet.OLEDB.4.0;Data Source=".$DATASOURCE.";Jet OLEDB:System Database=;","Admin", "");
				//$this->connExt->Open("DRIVER={Microsoft Access Driver (*.mdb)}; Dbq=".$DATASOURCE.";Exclusive=1;","Admin","test123");
				$this->connExt = odbc_connect("Driver={Microsoft Access Driver (*.mdb)}; DBQ=".$DATASOURCE,"Admin","");
				// or die("can't connect MS access");				
				 
			 } else if($DBTYPE=='ORACLE'){	
			  	 
			 	 if(!empty($DBNAME)) $addDBname = "@".$DBNAME;
				 else $addDBname = "";
				// $this->connExt = @ora_plogon($USER.$addDBname, $PASSWORD);
				
				//เธ—เธ”เธชเธญเธเธเธณเธชเธฑเนเธ Connect Oracle เนเธซเธกเน ==>  work เธกเธฒเธ
				$dpisdb_name = "(DESCRIPTION =
															(ADDRESS =
																 (PROTOCOL = TCP)
																 (HOST = $HOST)
																 (PORT = 1521)
															)
														   (CONNECT_DATA = (SERVICE_NAME = $DBNAME))
													  )";
				$this->connExt = OCILogon ($USER, $PASSWORD, $dpisdb_name);
				//echo " $USER, $PASSWORD, $dpisdb_name <br>";
				// เนเธเน ora_plogon ($USER, $PASSWORD, $dpisdb_name) เนเธกเนเนเธ”เน
				// เธเธเธเธฒเธฃเธ—เธ”เธชเธญเธ 
			 } else {
				$this->connExt = 0;
			 }	
			
			//if($this->connExt) {
				 $this->dbmsExt = $DBTYPE;
				 //echo " dbmsExt in class_db : ".$this->dbmsExt."<br>";
			//}
			 return $this->connExt;
		}

		function openDBExt($DBNAME, $DBTYPE) {
		
		 	//echo "db name in class : ".stripslashes($DBNAME).", $DBTYPE<br>";
				 if($DBTYPE=='MYSQL') {
				   
					 $this->openExt = @mysql_select_db($DBNAME,$this->connExt);
					// echo "db name : $DBNAME<br>";
				 } else if($DBTYPE=='MSSQL') {
					 $this->openExt = @mssql_select_db($DBNAME,$this->connExt);
				 } else if($DBTYPE=='ACCESS') {
				  	//$this->connExt->Open("Provider=Microsoft.Jet.OLEDB.4.0;Data Source=".$DBNAME); 
					//$DBNAME = "\\\\DEV14\\access\\access2.mdb";
					//echo $DBNAME."<BR>";					
					$this->openExt = 1;
				 } else if($DBTYPE=='ORACLE'){
				 	//$this->openExt=@ora_open($this->connExt);
					
					$this->openExt =1;
				 }	
				// echo $conn."<br>";
				 return $this->openExt;
		}
		
		function openCurExt($DBTYPE){						 			 
			 if($DBTYPE=='ORACLE'){	 	 
				//$this->cursorExt=ora_open($this->connExt);	เธ–เนเธฒเนเธเนเธงเธดเธเธต connect เนเธเธ OCI เธเนเนเธกเนเธ•เนเธญเธเน€เธเธดเธ” cursor เนเธ•เนเนเธเน $conn เนเธเธเธฒเธฃ query parse เธญเธขเนเธฒเธเน€เธ”เธตเธขเธง
				$this->cursorExt=1;
			 } else {
				$this->cursorExt = 0;
			 }	
			 return $this->cursorExt;
		}

		function queryExt($SQL, $DBTYPE, $CURSOR="") {
		
			if(empty($CURSOR)) $CURSOR=$this->cursorExt;
		  		
				 if($DBTYPE=='MYSQL') {
					 $EXEC = mysql_query($SQL,$this->connExt) or die(mysql_error());
				 } else if($DBTYPE=='MSSQL') {
					//echo "$SQL, ".$this->connExt."<br>";
					 $EXEC = mssql_query($SQL,$this->connExt) or die("can't query $SQL<BR>");
				 } else if($DBTYPE=='ACCESS'){
						echo $this->connExt."<br>";
					 $EXEC = odbc_exec($this->connExt,$SQL) or die("can't query $SQL<BR>");
					 //$RECORDSET = $this->connExt->Execute($SQL);
					 //$EXEC = $RECORDSET;
				 } else if($DBTYPE=='ORACLE'){	 	
				 	$EXEC = array(); 				
				 	//ora_parse($CURSOR, $SQL);
					//$EXEC["pass"] = ora_exec($CURSOR);
					//$EXEC["cur"] = $CURSOR;
					 $stmt = OCIParse($this->connExt, $SQL); 
					  $EXEC["pass"] = OCIExecute($stmt) or die("can't query $SQL<BR>");	
					  $EXEC["cur"] = $stmt;
				 } 
				 $this->sql=$SQL;
				 return $EXEC; 
		}
}//end class
?>
