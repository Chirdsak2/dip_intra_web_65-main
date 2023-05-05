<?php
include("../EWT_ADMIN/comtop_pop.php");
$date = new DateTime();
	
$proc = stripslashes(htmlspecialchars($_POST['proc'],ENT_QUOTES));
if($proc=='import_csv'){

	$MAXIMUM_FILESIZE = EwtMaxfile('file');
	$rEFileTypes = "/^\.(csv){1}$/i"; 
	$dir_base = "import_enews/";
	$isFile = is_uploaded_file($_FILES['enews_file']['tmp_name']); 
	if($isFile){  
		$safe_filename = preg_replace( 
						 array("/\s+/", "/[^-\.\w]+/"), 
						 array("_", ""), 
						 trim($_FILES['enews_file']['name']));
						 
		$type_file =  strrchr($safe_filename, '.');				 
		$newfile = 'import_enwes_'.date("YmdHis").$type_file;
		 
		if ($_FILES['enews_file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))){	
			$isMove = move_uploaded_file ($_FILES['enews_file']['tmp_name'],$dir_base.$newfile);
		} 
		//$fileattach = $newfile;
      }else{
		//$fileattach = "";		  	  
	  }
$filename = $dir_base.'/'.$newfile;
if(file_exists($filename)){
	
	$file = fopen($filename, "r");
	$i=1;
	while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	{
		if($getData[0] != '' AND $i > 1){
			$sql_email_exits = $db->query("SELECT m_id FROM n_member WHERE m_email='".$getData[0]."'");
			$a_data_email = $db->db_fetch_array($sql_email_exits);
			if($a_data_email["m_id"] == ''){ //ยังไม่มี email นี้อยู่
				$db->query("insert into n_member (m_email,m_active,m_date) values ('".$getData[0]."','Y','".$date->format('Y-m-d H:i:s')."')");
			}
		}
		$i++;
	 }
	 fclose($file);	
}
} 


?>