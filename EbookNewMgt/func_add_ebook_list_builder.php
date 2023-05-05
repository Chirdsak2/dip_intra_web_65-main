<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
include("../EWT_ADMIN/comtop_pop.php");
include("lib.inc.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
  
$a_array = array( 
    'status' => false, 
    'message' => 'Form submission failed, please try again.' 
); 
 
$date = new DateTime();
//print_r($_POST); 
$dest = "../ewt/".$EWT_FOLDER_USER."/ebook";

switch($proc)  
{
	case "savePage": 
	
	//exit;
	
		$ebookCode = stripslashes(htmlspecialchars($a_data['ebookCode'],ENT_QUOTES));
		$amtFile = stripslashes(htmlspecialchars($a_data['amtFile'],ENT_QUOTES));
		$c_id = stripslashes(htmlspecialchars($a_data['c_id'],ENT_QUOTES));
		$lastPage = stripslashes(htmlspecialchars($a_data['lastPage'],ENT_QUOTES));
		$zoom = stripslashes(htmlspecialchars($a_data['zoom'],ENT_QUOTES));
		$quality = stripslashes(htmlspecialchars($a_data['quality'],ENT_QUOTES));
		 	
		$dest .= '/'.$ebookCode.'/'; 
		$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '1' ")); 
		$maxSize = $recValue['ebook_value'];
		$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '2' ")); 
		$maxPDFSize = $recValue['ebook_value'];

		// Many file
		$i = 0;
		//while ($i < $amtFile) 
		//{
				$refPage = $lastPage;
				
				if($_FILES['file_pdf']['name'] !='' && $_FILES['file_pdf']['size'] > 0)   
				{
					$typeFile = getType_File($_FILES['file_pdf']['name']);
					$sizeFile = (${'file_pdf_size'}/1024); // 1024 is 1 kbyte
					//$fileUpload = $refPage.'.'.$typeFile;
					$fileUpload = $refPage.'.jpg';
					//Check size file
					if(($sizeFile > $maxSize && $typeFile !='pdf') || (($sizeFile/1000) > $maxPDFSize && $typeFile =='pdf')) 
					{
						//print "<script> alert ('ขนาดไฟล์หน้าที่ ".$refPage." เกินค่าที่กำหนด  กรุณาระบุใหม่');self.location.href='mgt_page.php?amtFile".$amtFile."&ebookCode=".$ebookCode."';</script>";
						exit;
					}
					 
					if($typeFile == 'pdf') 
					{ //Pdf File
						$path_parts = pathinfo($_SERVER["SCRIPT_FILENAME"]);
						// $currentDir = $path_parts['dirname'].'/';
						$currentDir = "";
						$tmpPdf = 'tmp.pdf';
						
						$add_dir = $currentDir.'output_pdf/'.$ebookCode."/";
						mkdir($add_dir);//add Dir
						
						copy($_FILES['file_pdf']['tmp_name'],$currentDir.$tmpPdf ); // Copy File
						$command = $currentDir.'pdftoimage -i "'.$currentDir.$tmpPdf.'" -o "'.$currentDir.'output_pdf/'.$ebookCode.'". -q '.$quality.' -z '.$zoom.' -x 1000 -y 1000';
						exec($command);  //Gen page to floder
						
						$dh = opendir($add_dir); //Add All Page
						//$dh = opendir($currentDir.'output_pdf/'); //Add All Page
						while($item = readdir($dh))
						{
							if($item != "." && $item != ".." && $item != "Thumbs.db") 
							{
								$typeFile = getType_File($item);
								$fileUpload = $refPage.'.jpg';
								copy($add_dir.$item,$dest.'pages/'.$fileUpload); // Copy page
								//copy ('output_pdf/'.$item,$dest.'pages/'.$fileUpload); // Copy page
								$db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('{$ebookCode}','{$refPage}','{$typeFile}','".$date->format('Y-m-d')."','{$fileUpload}') ");
								$refPage++;
								unlink ($add_dir.$item);
								//unlink ('output_pdf/'.$item);
								
								//resize filedownload
								$filep = $dest.'pages/'.$fileUpload;
								$file_new = $dest.'pdf/'.$fileUpload;
								$file_newt = $dest.'pages/t'.$fileUpload;
								resizeimage($filep,$file_new,1000,'','');
								resizeimage($filep,$file_newt,300,'',''); 
							}
						}
						closedir($dh);
						remove_dir($add_dir);
						unlink($tmpPdf);
						//Write XML File
						//$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
						//wirteFile ($dest.'xml/Pages.xml',$content);
						
					}
					else  
					{
						/*$c_num = count($_FILES['file_pic']['tmp_name']);
						for($n = 0;$n < $c_num; $n++)
						{  
							copy($_FILES['file_pic'][$n]['tmp_name'],$dest.'pages/'.$fileUpload); // Copy page						
							//resize filedownload
							$filep = $dest.'pages/'.$fileUpload;
							$file_new = $dest.'pdf/'.$refPage.'.'.$typeFile;
							resizeimage($filep,$file_new,1000,'',$typeFile);
						
							if($mode=='add') 
							{
								$db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('{$ebookCode}','{$refPage}','{$typeFile}','".$date->format('Y-m-d')."','{$fileUpload}') ");
							}
							else if($mode=='edit') 
							{
							$db->query ("UPDATE ebook_page SET ebook_page_date = '".$date->format('Y-m-d')."',ebook_page_type='{$typeFile}',ebook_page_file='{$fileUpload}' where ebook_code like '$ebookCode' and ebook_page='{$refPage}' ");
							}
						}*/
					} // chk PDF
				} //chk file
				else  
				{
						/*$countfiles = count($_FILES['file_pic']['name']);
						//$c_num = count($_FILES['file_pic']['tmp_name']);
						//print_r($_FILES); 
						//exit; 
						 for($i=0;$i<$countfiles;$i++)
						 {
							 
							$filename = $_FILES['file_pic']['name'][$i];
 
							$fileUpload = ($refPage+$i).'.jpg'; 
							$num = ($refPage+$i);
							
							$typeFile = getType_File($_FILES['file_pic']['name'][$i]);  
							
							move_uploaded_file($_FILES['file_pic']['tmp_name'][$i],$dest.'pages/'.$fileUpload); // Copy page	  
							
							//resize filedownload
							$filep = $dest.'pages/'.$fileUpload; 
							$file_new = $dest.'pdf/'.$num.'.'.$typeFile;
							resizeimage($filep,$file_new,1000,'',$typeFile);
							
							
							
							if($mode=='add')  
							{
								$db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('{$ebookCode}','{$num}','{$typeFile}','".$date->format('Y-m-d')."','".$fileUpload."') ");
							}
							else if($mode=='edit') 
							{
							//$db->query ("UPDATE ebook_page SET ebook_page_date = '".$date->format('Y-m-d')."',ebook_page_type='{$typeFile}',ebook_page_file='".$fileUpload."' where ebook_code like '{$ebookCode}' and ebook_page='{$num}' ");
							}
						}*/
					$filesArr = $_FILES['file_pic'];  	 
					$fileNames = array_filter($filesArr['name']); 
					if(!empty($fileNames))
					{
						foreach($filesArr['name'] as $key=>$val)
						{
							$isFile = is_uploaded_file($filesArr['tmp_name'][$key]);  
							if($isFile) 
							{
							// File upload path  
							//$fileName = basename($filesArr['name'][$key]);  
							//$targetFilePath = $uploadDir . $fileName;                
							//$newname = date('YmdHis',time()).mt_rand().'.jpg';  							
							//move_uploaded_file($filesArr['tmp_name'][$key],$dest.'pages/'.$fileName);   
							
							 $safe_filename = preg_replace(  
							array("/\s+/", "/[^-\.\w]+/"), 
							array("_", ""), 
							trim($filesArr['name'][$key]));
					 
							$type_file =  strrchr($safe_filename, '.');	
							
							$fileUpload = ($refPage+$key).$type_file; 
							$num = ($refPage+$key); 
							
							$typeFile = getType_File($filesArr['name'][$key]);  
							
							move_uploaded_file($filesArr['tmp_name'][$key],$dest.'pages/'.$fileUpload); // Copy page	  
							
							//resize filedownload
							$filep = $dest.'pages/'.$fileUpload; 
							$file_new = $dest.'pdf/'.$fileUpload;
							$file_newt = $dest.'pages/t'.$fileUpload;
							resizeimage($filep,$file_new,1000,'','');
							resizeimage($filep,$file_newt,300,'','');  
							
							
							
							if($mode=='add')  
							{
								$db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('{$ebookCode}','{$num}','{$typeFile}','".$date->format('Y-m-d')."','".$fileUpload."') ");
							}
							else if($mode=='edit') 
							{
								$db->query ("UPDATE ebook_page SET ebook_page_date = '".$date->format('Y-m-d')."',ebook_page_type='{$typeFile}',ebook_page_file='".$fileUpload."' where ebook_code like '{$ebookCode}' and ebook_page='{$num}' ");
							}	
							
							}
						}
					}						
						
				} // chk PDF	 		
				//Write XML File
				//$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
				//wirteFile ($dest.'xml/Pages.xml',$content);
				
				//$i++;
			//} // while 
		
		
		//แก้ไข config ebook
		copy ('ebook/new_master/javascript/config.js',$dest.'javascript/config.js');
		$num_pages = $db->db_num_rows($db->query("select * from ebook_page where ebook_code like '{$ebookCode}' "));
		$detail_ebook = $db->db_fetch_array ($db->query("select * from ebook_info where ebook_code like '{$ebookCode}' "));
		
		//read the entire string
		$str	=	file_get_contents($dest.'javascript/config.js');
		
		//replace something in the file string - this is a VERY simple example
		$str	=	str_replace("bookConfig.totalPageCount=0;", "bookConfig.totalPageCount=$num_pages;",$str);
		$str	=	str_replace("bookConfig.largePageWidth=1800", "bookConfig.largePageWidth=".$detail_ebook['ebook_w'],$str);
		$str	=	str_replace("bookConfig.largePageHeight=2607", "bookConfig.largePageHeight=".$detail_ebook['ebook_h'],$str);
		
		//write the entire string
		file_put_contents($dest.'/javascript/config.js', $str); 
		
	//if($a_data['show_image'] == 2)
	//{		
		print_r('ebook_code='.$ebookCode.'&c_id='.$c_id); 
		exit;
	//}
	//else
	//{
?>		
		

<?php
		
			
	unset($a_data);
	unset($s_data);
	
	$a_array['status'] 	= true;
	$a_array['alert']   = true;
	$a_array['message'] = "บันทึกข้อมูลเรียบร้อย";
	$a_array['url'] = 'setting.php';
	
	exit;	
break;
	
} 
function reArrayFiles($file)
{
    $file_ary = array();
    $file_count = count($file['name']);
    $file_key = array_keys($file);
   
    for($i=0;$i<$file_count;$i++)
    {
        foreach($file_key as $val)
        {
            $file_ary[$i][$val] = $file[$val][$i];
        }
    }
    return $file_ary;
}
function resizeimage($images,$namefile,$width,$height,$type){
		if($type!=""){
			$fileName = ".".$type;
		}else{
			$exp = explode('.' , $images);
			$fileName = ".".$exp[count($exp)-1];
		}
		
		$new_images = $namefile;
		
		$size = GetimageSize($images);
		if($height==""){
			$height = round($width*$size[1]/$size[0]);
		}
		
		if($fileName=='.jpg' or $fileName=='.jpeg'){
			$images_orig = ImageCreateFromJPEG($images);	
		}else if($fileName=='.png'){
			$images_orig = ImageCreateFromPNG($images);	
		}else if($fileName=='.gif'){
			$images_orig = ImageCreateFromGIF($images);	
		}

		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		
		if($fileName=='.jpg' or $fileName=='.jpeg'){
			ImageJPEG($images_fin,$new_images);
		}else if($fileName=='.png'){
			ImagePNG($images_fin,$new_images);
		}else if($fileName=='.gif'){
			ImageGIF($images_fin,$new_images);
		}
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);
		
		//return $new_images.$fileName;
	}
?>