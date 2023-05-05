<?php
include("../EWT_ADMIN/comtop_pop.php");
include("lib.inc.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$dest = "../ewt/".$EWT_FOLDER_USER."/ebook";
$date = new DateTime();

switch($proc)  
{
	case "DelEbook":
	
	$ebookCode  = ready($a_data['ebook_code']);	 
	$c_id   	= ready($a_data['c_id']);	 
	
	$s_sql 		= 	$db->query("SELECT * FROM ebook_info WHERE ebook_code = '{$ebookCode}' ");
	$a_info 	= 	$db->db_fetch_array($s_sql);	
	$a_rows  	= 	$db->db_num_rows($s_sql);  	
	if($a_rows) 
	{ 
		$wh = " WHERE ebook_code = '{$ebookCode}'  ";
		$db->query ("DELETE FROM ebook_info {$wh}"); //Delete tb ebook
		$db->query ("DELETE FROM ebook_page {$wh}"); //Delete tb page
		//$sql = $db->db_fetch_array($db->query("select * from ebook_info {$wh} "));
		$db->write_log("delete","Ebook","ลบ E-book ชื่อ".$a_info['ebook_name']); 
		
		remove_dir($dest.'/'.$ebookCode);
	}	 
	unset($a_data);
	unset($s_data);	 		

	exit;	
break;
	
	case "DelPage":
	//print_r($a_data); 
	//exit;
	$ebookCode  = ready($a_data['ebook_code']);	 
	$c_id   	= ready($a_data['c_id']);	
	$ref    	= stripslashes(htmlspecialchars($a_data['ref'],ENT_QUOTES));
	$arr_page 	= explode(",",$ref);
	$dest = $dest."/".$ebookCode."/";
		
		foreach($arr_page as $key => $val)
		{
			$wh = "WHERE ebook_code LIKE '{$ebookCode}' AND ebook_page IN ('{$arr_page[$key]}') ";
			$a_rec = $db->db_fetch_array($db->query("SELECT * FROM ebook_page {$wh} "));
			$db->write_log("delete","Ebook","ลบ E-book หน้า".$a_rec['ebook_page']);
			//$db->write_log("delete","Ebook","ลบ E-book หน้า ".$ref);
			$db->query ("DELETE FROM ebook_page {$wh}");
			
			if($a_rec['ebook_page_file'])
			{
				unlink($dest.'pages/'.$a_rec['ebook_page_file']);
				unlink($dest.'pages/t'.$a_rec['ebook_page_file']); 
				//del pdf
				unlink($dest.'pdf/'.$a_rec['ebook_page'].'.'.$a_rec['ebook_page_type']); 
			}
		}
		
		//Write XML File
		//$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
		//wirteFile ($dest.'/'.$ebookCode.'/xml/Pages.xml',$content);
		
		//แก้ไข config ebook
		error_reporting(~E_NOTICE & ~E_DEPRECATED);
		ini_set('display_errors', 1);
		@copy('ebook/new_master/javascript/config.js',$dest.'javascript/config.js');
		
		$num_pages = $db->db_num_rows($db->query("select * from ebook_page where ebook_code like '{$ebookCode}' "));
		
		//read the entire string
		$str=file_get_contents($dest.'javascript/config.js');
		
		//replace something in the file string - this is a VERY simple example
		$str=str_replace("bookConfig.totalPageCount=0;", "bookConfig.totalPageCount={$num_pages};",$str);
		
		//write the entire string
		file_put_contents($dest.'/javascript/config.js', $str);
	
		print_r('ebook_code='.$ebookCode.'&c_id='.$c_id);	 

	unset($a_data);
	unset($s_data);	 		

	exit;	
break;
} 
?>