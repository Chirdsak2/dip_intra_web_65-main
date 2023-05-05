<?php
include("../EWT_ADMIN/comtop_pop.php");
include("lib.inc.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();

$date = new DateTime();

$dest = "../ewt/".$EWT_FOLDER_USER."/ebook";

switch($proc)  
{
	case "Add_Ebook":
		$name = stripslashes(htmlspecialchars($a_data['e_book_name'],ENT_QUOTES));
		$desc = stripslashes(htmlspecialchars($a_data['e_book_desc'],ENT_QUOTES));
		$s_data['ebook_code'] 	= 	'';
		$s_data['ebook_name'] 	= 	$name;
		$s_data['ebook_desc'] 	= 	$desc; 
		$s_data['ebook_w'] 		= 	$a_data['e_book_size_width'];
		$s_data['ebook_h'] 		= 	$a_data['e_book_size_height'];
		$s_data['create_date'] 	= 	$date->format('Y-m-d');
		$s_data['update_date'] 	= 	$date->format('Y-m-d');
		$s_data['ebook_by'] 	= 	$a_data['e_book_by'];
		$s_data['show_status'] 	= 	$a_data['e_book_status'];
		$s_data['g_ebook_id'] 	= 	$a_data['e_book_cate'];
		$s_data['ebook_cover'] 	= 	'';
	
		//$s_data['g_ebook_timestamp'] 	= $date->format('Y-m-d H:i:s');
		sys::save_log('create','Ebook',$txt_ebook_list_add.' '.$a_data['e_cate_name']); 
		//$db->write_log("create","Ebook","แก้ไขหมวด e-book".$a_group['g_ebook_name']); 
		insert('ebook_info',$s_data);  
		
			
			$rec_ebook = $db->db_fetch_array($db->query("SELECT MAX(ebook_id) AS ebookID  FROM ebook_info ")); 
			$ebookID = $rec_ebook['ebookID'];
			$ebookCode = 'B'.substr(($ebookID)+10000,1,4);
			$db->query("UPDATE ebook_info SET ebook_code = '".$ebookCode."' WHERE ebook_id = '".$ebookID."' ");
			
			//Create Dir & File
			//$src = 'ebook/master';
			$src = 'ebook/new_master';
			if(!file_exists($dest)) 
			{
				mkdir($dest, 0777);
			}
			$dest .="/".$ebookCode ;
			
            copy_dir($src,$dest);
			$content = getContent_Index($name);
			wirteFile($dest.'/index.html',$content);
			
            //อัพโหลดหน้าปก
			if($_FILES['pageFile']['tmp_name'] != '')  
			{
				$typeFile = getType_File($_FILES['pageFile']['name']);
				$sizeFile = (${'pageFile_size'} / 1024); // 1024 is 1 kbyte
				$fileUpload = 'cover.'.$typeFile;
				
				$wh = "WHERE ebook_code LIKE '".$ebookCode."' ";
				
				$rec = $db->db_fetch_array($db->query("SELECT * FROM ebook_info {$wh} "));
				
				//unlink($dest . '/' . $ebookCode . '/pages/' . $rec['ebook_cover']);
				
				copy($_FILES['pageFile']['tmp_name'], $dest.'/pages/'.$fileUpload); // Copy page
				
				$db->query("UPDATE ebook_info SET ebook_cover = '".$fileUpload."'  WHERE ebook_code LIKE '".$ebookCode."' ");
				//$db->write_log("update", "ebook", "แก้ไข E-book ชื่อ" . $name);
			}
		
		//$dest .= '/' . $ebookCode . '/';
		
		//แก้ไข config ebook
		copy('ebook/new_master/javascript/config.js',$dest.'/javascript/config.js');
		$num_pages 		= 	$db->db_num_rows($db->query("SELECT * from ebook_page WHERE ebook_code LIKE '".$ebookCode."' "));
		$detail_ebook 	= 	$db->db_fetch_array ($db->query("SELECT * from ebook_info WHERE ebook_code LIKE '".$ebookCode."' "));
		
		//read the entire string
		$str	=	file_get_contents($dest.'/javascript/config.js');
		
		//replace something in the file string - this is a VERY simple example
		$str	=	str_replace("bookConfig.totalPageCount=0;", "bookConfig.totalPageCount=".$num_pages.";",$str);
		$str	=	str_replace("bookConfig.largePageWidth=1800", "bookConfig.largePageWidth=".$detail_ebook['ebook_w'],$str);
		$str	=	str_replace("bookConfig.largePageHeight=2607", "bookConfig.largePageHeight=".$detail_ebook['ebook_h'],$str);
		
		//write the entire string
		file_put_contents($dest.'/javascript/config.js', $str); 
		//header ("Location:mgt_page.php?ebookCode=".$ebookCode."");
		 
	print_r('ebook_code='.$ebookCode.'&c_id='.$a_data['e_book_cate']);	
		
	unset($a_data);
	unset($s_data);
	
	exit;	
break;
	
} 
?>