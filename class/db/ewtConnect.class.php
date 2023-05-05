<?php
class ewtConnect
{
  private static $_connect;
  private static $_use;
  
  public static function setConnect($s_name, $s_type, $s_connect, $s_user, $s_pass, $s_db, $s_char)
  {
	try
		{
    $s_name = strtolower($s_name);
	
	
    //self::$_connect[$s_name] = new daoConnectDatabase();
    //self::$_connect[$s_name]->setConnect($s_type, $s_connect, $s_user, $s_pass, $s_db);
    //$_chk = self::$_connect[$s_name]->connect();
    //self::$_use = $s_name;
	
	$opt = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => FALSE,
            );
            $dsn = $s_type .':host=' . $s_connect . ';dbname=' . $s_db . ';charset=' .$s_char;			
            self::$_connect[$s_name] = new PDO($dsn, $s_user, $s_pass, $opt);
			self::$_use = $s_name;	
			
		}		
		catch (PDOException $exc)
                 {
					 self::$_connect[$s_name] = false;
                     echo "There is some problem in connection: " . $exc->getMessage();
					 return false;
                 }
				 
		if (self::$_connect[$s_name]) {		 
			switch($s_type) {
				
			case 'oci':
			if(is_file(PATH.'db/'.$s_type.'.class.inc.php')){
				include_once(PATH.'db/'.$s_type.'.class.inc.php');
			}
				break;
			case 'mysql':
			if(is_file(PATH.'db/'.$s_type.'.class.inc.php')){
				include_once(PATH.'db/'.$s_type.'.class.inc.php');
			 }
				break;
			case 'mssql':
			if(is_file(PATH.'db/'.$s_type.'.class.inc.php')){
				include_once(PATH.'db/'.$s_type.'.class.inc.php');
			}
			case 'sqlite':
			if(is_file(PATH.'db/'.$s_type.'.class.inc.php')){
				include_once(PATH.'db/'.$s_type.'.class.inc.php');
			}
			
			}
		}
			
			//return self::$_connect[$s_name];	
	
  }
  
    public static function getArray($s_sql)
  {
    if(is_object(self::$_connect[self::$_use]))
    {
	 $_query = self::$_connect[self::$_use]->prepare($s_sql);	
	 $_query->execute();
	 $a_data = $_query->fetchAll(PDO::FETCH_ASSOC);

      //self::checkError($s_sql);
      return $a_data;
    }
    return false;
  }
	
   public static function showData($table){

	$_sql="SELECT * FROM $table";
	$a_data = self::getArray($_sql);
    return $a_data;
   }
  
}
?>