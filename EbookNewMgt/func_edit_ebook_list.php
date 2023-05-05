<?php
include("../EWT_ADMIN/comtop_pop.php");
include("lib.inc.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$dest = "../ewt/".$EWT_FOLDER_USER."/ebook";
$date = new DateTime();

switch($proc)  
{
	case "Edit_Ebook":

	$ebookCode   = ready($a_data['ebook_code']);
	$s_sql 		= 	$db->query("SELECT * FROM ebook_info WHERE ebook_code = '{$ebook_code}'");
	$a_group 	= 	$db->db_fetch_array($s_sql);	
	$a_rows  	= 	$db->db_num_rows($s_sql);  	
	
	if($a_rows) 
	{ 
		$name = stripslashes(htmlspecialchars($a_data['e_book_name'],ENT_QUOTES));
		$desc = stripslashes(htmlspecialchars($a_data['e_book_desc'],ENT_QUOTES));
		
		$s_data['ebook_name'] 	= 	$name;
		$s_data['ebook_desc'] 	= 	$desc; 
		$s_data['ebook_w'] 		= 	$a_data['e_book_size_width'];
		$s_data['ebook_h'] 		= 	$a_data['e_book_size_height'];
		$s_data['update_date'] 	= 	$date->format('Y-m-d');
		$s_data['ebook_by'] 	= 	$a_data['e_book_by'];
		$s_data['show_status'] 	= 	$a_data['e_book_status'];
		$s_data['g_ebook_id'] 	= 	$a_data['e_book_cate'];

		
		sys::save_log('update','Ebook',$txt_ebook_list_edit.' '.$name); 
		//$db->write_log("update","Ebook",$txt_ebook_list_edit.' '.$name);  
		
		update('ebook_info',$s_data,array('ebook_code'=>$ebookCode));   
		

		$content = getContent_Index($name);
		wirteFile($dest.'/'.$ebookCode.'/index.html',$content);
			
			//อัพโหลดหน้าปก
            if ($_FILES['pageFile']['tmp_name'] != '') 
			{
                $typeFile = getType_File($_FILES['pageFile']['name']);
                $sizeFile = (${'pageFile_size'} / 1024); // 1024 is 1 kbyte
                $fileUpload = 'cover.'.$typeFile;
				
                $wh = " WHERE ebook_code LIKE '{$ebookCode}' ";
				
                $rec = $db->db_fetch_array($db->query("SELECT * FROM ebook_info {$wh} "));
				
                unlink($dest.'/'.$ebookCode.'/pages/'.$rec['ebook_cover']);
				
                copy($_FILES['pageFile']['tmp_name'], $dest.'/'.$ebookCode.'/pages/'.$fileUpload); // Copy page
				
                $db->query("UPDATE ebook_info SET ebook_cover = '".$fileUpload."' WHERE ebook_code LIKE '".$ebookCode."' ");
                
			}
			$dest .= '/' . $ebookCode . '/';	

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
			
	}
	
	unset($a_data);
	unset($s_data);
	
	exit;	
break;

	case "DelItem":
	
	$m_id     	= 	ready($a_data['m_id']);	
	$mp_pid 	= 	ready($a_data['mp_pid']);	 
	
	$s_sql 		= 	$db->query("SELECT mp_name FROM menu_properties WHERE m_id = '{$m_id}' AND  mp_pid = '{$mp_pid}' ");
	$a_menu 	= 	$db->db_fetch_array($s_sql);	
	$a_rows  	= 	$db->db_num_rows($s_sql);  	
	if($a_rows) 
	{ 
		$db->write_log("delete","menu","ลบเมนูย่อย".$a_menu['m_name']); 
	
		$db->query("DELETE FROM menu_properties WHERE m_id = '{$m_id}' AND  mp_pid = '{$mp_pid}' "); 	
	}	
	unset($a_data);
	unset($s_data);	 		

	exit;	
break;
	
} 
?>