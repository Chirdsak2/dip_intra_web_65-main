<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	
	include ("lib.inc.php");
	//Initial var
	$proc = $_REQUEST['proc'];
	$today = date ('Y-m-d');
	$dest = "../ewt/".$EWT_FOLDER_USER."/ebook";
	$recEbook = $db->db_fetch_array ($db->query("select * from ebook_info where ebook_code like '$ebookCode' "));
	
	if ($proc=='delEbook') {
		$wh = " where ebook_code like '$ebookCode'  ";
		$db->query ("DELETE FROM ebook_info $wh"); //Delete tb ebook
		$db->query ("DELETE FROM ebook_page $wh"); //Delete tb page
		$sql = $db->db_fetch_array($db->query("select * from ebook_info $wh"));
		$db->write_log("delete","ebook","ลบ E-book ชื่อ".$sql[ebook_name]);
		remove_dir($dest.'/'.$ebookCode);
		//header ("Location:book_mgt_list.php?ebookCode=".$ebookCodegroup."");
	?>
	<script language="JavaScript">
		location.href='book_mgt_list.php?ebookCode=<?php echo $ebookCodegroup;?>';
	</script>
	<?php
		exit;
	}
	
	if ($proc=='delPage') {
		$arr_page = explode(",",$ref);
		$dest = $dest."/".$ebookCode."/";
		
		foreach($arr_page as $key => $val){
			$wh = " where ebook_code like '$ebookCode' and ebook_page in ('$arr_page[$key]') ";
			$rec = $db->db_fetch_array($db->query("select * from ebook_page $wh "));
			$db->write_log("delete","ebook","ลบ E-book หน้า".$rec[ebook_page]);
			$db->write_log("delete","ebook","ลบ E-book หน้า ".$ref);
			$db->query ("DELETE FROM ebook_page $wh");
			if($rec['ebook_page_file']){
				unlink($dest.'pages/'.$rec['ebook_page_file']);
				//del pdf
				unlink($dest.'pdf/'.$rec['ebook_page'].'.'.$rec['ebook_page_type']);
			}
		}
		
		//Write XML File
		//$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
		//wirteFile ($dest.'/'.$ebookCode.'/xml/Pages.xml',$content);
		
		//แก้ไข config ebook
		error_reporting(~E_NOTICE & ~E_DEPRECATED);
		ini_set('display_errors', 1);
		copy ('ebook/new_master/javascript/config.js',$dest.'javascript/config.js');
		
		$num_pages = $db->db_num_rows($db->query("select * from ebook_page where ebook_code like '$ebookCode' "));
		//read the entire string
		$str=file_get_contents($dest.'javascript/config.js');
		//replace something in the file string - this is a VERY simple example
		$str=str_replace("bookConfig.totalPageCount=0;", "bookConfig.totalPageCount=$num_pages;",$str);
		//write the entire string
		file_put_contents($dest.'/javascript/config.js', $str);
		
		//header ("Location:mgt_page.php?ebookCode=$ebookCode");
	?>
	<script language="JavaScript">
		location.href='mgt_page.php?ebookCode=<?php echo $ebookCode;?>';
	</script>
	<?php
		exit;
	}
	
	if ($proc=='saveEbook') {
		//Initial var
		$name = stripslashes(htmlspecialchars($_POST["name"],ENT_QUOTES));
		$desc = stripslashes(htmlspecialchars($_POST["desc"],ENT_QUOTES));
		$by = stripslashes(htmlspecialchars($_POST["by"],ENT_QUOTES));
		$w = $_POST['w'];
		$h = $_POST['h'];
		$status = $_POST['status'];
		
		
		if (empty($ebookCode))  { // Add
			//Add db
	        $db->query("INSERT INTO ebook_info (ebook_name,ebook_code,ebook_desc,ebook_w,ebook_h,create_date,update_date,ebook_by,show_status,g_ebook_id) VALUES ('$name','$ebookCode','$desc','$w','$h','$today','$today','$by','$status','".$_POST[groupebook]."')");
			
			$db->write_log("create","ebook","สร้าง E-book ชื่อ".$name);
			$rec_ebook = $db->db_fetch_array ($db->query("select max(ebook_id) as ebookID  from ebook_info ")); 
			$ebookID = $rec_ebook[ebookID];
			$ebookCode = 'B'.substr (($ebookID)+10000,1,4);
			$db->query("UPDATE ebook_info SET ebook_code='".$ebookCode."' where ebook_id='$ebookID' ");
			//Create Dir & File
			//$src = 'ebook/master';
			$src = 'ebook/new_master';
			if (!file_exists($dest)) {
				mkdir($dest, 0777);
			}
			$dest .="/".$ebookCode ;
			
            copy_dir($src,$dest);
			$content = getContent_Index ($name);
			wirteFile ($dest.'/index.html',$content);
			
            //อัพโหลดหน้าปก
			if ($_FILES['pageFile']['tmp_name']!='') {
				$typeFile = getType_File($_FILES['pageFile']['name']);
				$sizeFile = (${'pageFile_size'} / 1024); // 1024 is 1 kbyte
				$fileUpload = 'cover.' . $typeFile;
				
				$wh = " where ebook_code like '$ebookCode'";
				$rec = $db->db_fetch_array($db->query("select * from ebook_info $wh "));
				
				//unlink($dest . '/' . $ebookCode . '/pages/' . $rec['ebook_cover']);
				copy($_FILES['pageFile']['tmp_name'], $dest . '/pages/' . $fileUpload); // Copy page
				$db->query("UPDATE ebook_info SET ebook_cover='$fileUpload'  WHERE ebook_code like '$ebookCode' ");
				//$db->write_log("update", "ebook", "แก้ไข E-book ชื่อ" . $name);
			}
		}else { //Edit
			//$content = getContent_Index ($name);
			//wirteFile ($dest.'/'.$ebookCode.'/index.html',$content); 
			//Write XML File
			//$content = getContent_Page ($w,$h,$ebookCode);
			//wirteFile ($dest.'/'.$ebookCode.'/xml/Pages.xml',$content);
			//Edit db
	        $db->query("UPDATE ebook_info SET ebook_name='$name',ebook_desc='$desc',ebook_w='$w',ebook_h='$h',update_date='$today',ebook_by='$by',show_status='$status',g_ebook_id='".$_POST[groupebook]."'  WHERE ebook_code like '$ebookCode' ");
			$db->write_log("update","ebook","แก้ไข E-book ชื่อ".$name);
			
			//$src = 'ebook/new_master';
			//copy_dir($src,$dest."/".$ebookCode);
			$content = getContent_Index ($name);
			wirteFile ($dest.'/'.$ebookCode.'/index.html',$content);
			
			//อัพโหลดหน้าปก
            if ($_FILES['pageFile']['tmp_name']!='') {
                $typeFile = getType_File($_FILES['pageFile']['name']);
                $sizeFile = (${'pageFile_size'} / 1024); // 1024 is 1 kbyte
                $fileUpload = 'cover.' . $typeFile;
				
                $wh = " where ebook_code like '$ebookCode'";
                $rec = $db->db_fetch_array($db->query("select * from ebook_info $wh "));
				
                unlink($dest . '/' . $ebookCode . '/pages/' . $rec['ebook_cover']);
                copy($_FILES['pageFile']['tmp_name'], $dest . '/' . $ebookCode . '/pages/' . $fileUpload); // Copy page
                $db->query("UPDATE ebook_info SET ebook_cover='$fileUpload'  WHERE ebook_code like '$ebookCode' ");
                $db->write_log("update", "ebook", "แก้ไข E-book ชื่อ" . $name);
			}
			$dest .= '/' . $ebookCode . '/';
		}
		//$dest .= '/' . $ebookCode . '/';
		//แก้ไข config ebook
		copy ('ebook/new_master/javascript/config.js',$dest.'/javascript/config.js');
		$num_pages = $db->db_num_rows($db->query("select * from ebook_page where ebook_code like '$ebookCode' "));
		$detail_ebook = $db->db_fetch_array ($db->query("select * from ebook_info where ebook_code like '$ebookCode' "));
		//read the entire string
		$str=file_get_contents($dest.'/javascript/config.js');
		//replace something in the file string - this is a VERY simple example
		$str=str_replace("bookConfig.totalPageCount=0;", "bookConfig.totalPageCount=$num_pages;",$str);
		$str=str_replace("bookConfig.largePageWidth=1800", "bookConfig.largePageWidth=".$detail_ebook['ebook_w'],$str);
		$str=str_replace("bookConfig.largePageHeight=2607", "bookConfig.largePageHeight=".$detail_ebook['ebook_h'],$str);
		
		//write the entire string
		file_put_contents($dest.'/javascript/config.js', $str);
		//header ("Location:mgt_page.php?ebookCode=".$ebookCode."");
		
	?>
	<script language="JavaScript">
		location.href='mgt_page.php?ebookCode=<?php echo $ebookCode;?>';
	</script>
	<?php
	} 
	if ($proc=='sendPage') {
		//Get last page
		$recPage = $db->db_fetch_array ($db->query("select ebook_page from ebook_page where ebook_code like '$ebookCode' order by ebook_page desc")); 
		$lastPage = $recPage['ebook_page'];
		$refPage = $lastPage+1;
		
		$typeFile = getType_File ($fname);
		//$fileUpload = $refPage.'.'.$typeFile;
		$fileUpload = $refPage.'.jpg';
		$dest .='/'.$ebookCode.'/';
		copy($src,$dest.'pages/'.$fileUpload );
		
		$db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('$ebookCode','$refPage','$typeFile','$today','$fileUpload') ");
		
		//Write XML File
		//$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
		//wirteFile ($dest.'xml/Pages.xml',$content);
		$db->write_log("create","ebook","เพิ่มหน้า E-book หน้าที่ ".$refPage);
		print "<script> alert ('เพิ่มหน้า E-Book เรียบร้อยแล้ว');self.location.href='../FileMgt/gallery_index.php?flag=gallery&myfolder=".$myfolder."';</script>";
		exit;
	}
	
	if ($proc=='savePage') {
		//Initial var
		$ebookCode = $_POST['ebookCode'];
		$amtFile = $_POST['amtFile'];
		$dest .= '/'.$ebookCode.'/'; 
		$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '1' ")); 
		$maxSize = $recValue['ebook_value'];
		$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '2' ")); 
		$maxPDFSize = $recValue['ebook_value'];
		if($_POST['modifyType']==2){
			$refPage = $_POST['insertPage'];
				if (!empty($refPage)) { //ADD
					$recPage = $db->db_fetch_array ($db->query("select * from ebook_page where ebook_code like '$ebookCode' and  ebook_page='$refPage' order by ebook_page desc"));
					if (!empty($recPage)) {
						print "<script>alert ('หน้า $refPage มีแล้วในระบบ');self.location.href='mgt_page.php?ebookCode=".$ebookCode."';</script>";
					}
				}
				$mode = 'add';
				if ($_FILES['pageFileInsert']!='' && $_FILES['pageFileInsert']!='none') {
					$typeFile = getType_File ($_FILES['pageFileInsert']['name']);
					$sizeFile = (${'pageFileInsert'}/1024); // 1024 is 1 kbyte
					//$fileUpload = $refPage.'.'.$typeFile;
					$fileUpload = $_POST['insertPage'].'.jpg';
					//Check size file
					if (($sizeFile > $maxSize && $typeFile !='pdf') || (($sizeFile/1000) > $maxPDFSize && $typeFile =='pdf')) {
						print "<script> alert ('ขนาดไฟล์หน้าที่ ".$refPage." เกินค่าที่กำหนด  กรุณาระบุใหม่');self.location.href='mgt_page.php?amtFile".$amtFile."&ebookCode=".$ebookCode."';</script>";
						exit;
					}
					copy ($_FILES['pageFileInsert']['tmp_name'],$dest.'pages/'.$fileUpload); // Copy page
						if ($mode=='add') {
							$db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('$ebookCode','$refPage','$typeFile','$today','$fileUpload') ");
						}else if ($mode=='edit') {
							$db->query ("UPDATE ebook_page SET ebook_page_date='$today',ebook_page_type='$typeFile',ebook_page_file='$fileUpload' where ebook_code like '$ebookCode' and ebook_page='$refPage' ");
						}
				} //chk file
		}else{
			// Many file
			$i =0;
			while ($i < $amtFile) {
				$refPage = $lastPage+$i;
				if ($_FILES['pageFile'.$refPage]!='' && $_FILES['pageFile'.$refPage]!='none') {
					$typeFile = getType_File ($_FILES['pageFile'.$refPage]['name']);
					$sizeFile = (${'pageFile'.$refPage.'_size'}/1024); // 1024 is 1 kbyte
					//$fileUpload = $refPage.'.'.$typeFile;
					$fileUpload = $refPage.'.jpg';
					//Check size file
					if (($sizeFile > $maxSize && $typeFile !='pdf') || (($sizeFile/1000) > $maxPDFSize && $typeFile =='pdf')) {
						print "<script> alert ('ขนาดไฟล์หน้าที่ ".$refPage." เกินค่าที่กำหนด  กรุณาระบุใหม่');self.location.href='mgt_page.php?amtFile".$amtFile."&ebookCode=".$ebookCode."';</script>";
						exit;
					}
					if ($typeFile=='pdf') { //Pdf File
						$path_parts = pathinfo($_SERVER["SCRIPT_FILENAME"]);
						// $currentDir = $path_parts['dirname'].'/';
						$currentDir = "";
						$tmpPdf = 'tmp.pdf';
						
						$add_dir = $currentDir.'output_pdf/'.$ebookCode."/";
						mkdir($add_dir);//add Dir
						
						copy ($_FILES['pageFile'.$refPage]['tmp_name'],$currentDir.$tmpPdf ); // Copy File
						$command = $currentDir.'pdftoimage -i "'.$currentDir.$tmpPdf.'" -o "'.$currentDir.'output_pdf/'.$ebookCode.'". -q '.$quality.' -z '.$zoom.' -x 300 -y 300';
						exec ($command);  //Gen page to floder
						
						$dh = opendir($add_dir); //Add All Page
						//$dh = opendir($currentDir.'output_pdf/'); //Add All Page
						while ($item = readdir($dh))
						{
							if ($item != "." && $item != ".." && $item != "Thumbs.db") {
								$typeFile = getType_File ($item);
								$fileUpload = $refPage.'.jpg';
								copy ($add_dir.$item,$dest.'pages/'.$fileUpload); // Copy page
								//copy ('output_pdf/'.$item,$dest.'pages/'.$fileUpload); // Copy page
								$db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('$ebookCode','$refPage','$typeFile','$today','$fileUpload') ");
								$refPage++;
								unlink ($add_dir.$item);
								//unlink ('output_pdf/'.$item);
								
								//resize filedownload
								$filep = $dest.'pages/'.$fileUpload;
								$file_new = $dest.'pdf/'.$fileUpload;
								resizeimage($filep,$file_new,1000,'','');
							}
						}
						closedir($dh);
						remove_dir($add_dir);
						unlink($tmpPdf);
						//Write XML File
						//$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
						//wirteFile ($dest.'xml/Pages.xml',$content);
						
					}else{
						copy ($_FILES['pageFile'.$refPage]['tmp_name'],$dest.'pages/'.$fileUpload); // Copy page
						
						//resize filedownload
						$filep = $dest.'pages/'.$fileUpload;
						$file_new = $dest.'pdf/'.$refPage.'.'.$typeFile;
						resizeimage($filep,$file_new,1000,'',$typeFile);
						
						if ($mode=='add') {
							$db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('$ebookCode','$refPage','$typeFile','$today','$fileUpload') ");
							}else if ($mode=='edit') {
							$db->query ("UPDATE ebook_page SET ebook_page_date='$today',ebook_page_type='$typeFile',ebook_page_file='$fileUpload' where ebook_code like '$ebookCode' and ebook_page='$refPage' ");
						}
					} // chk PDF
				} //chk file
				//Write XML File
				//$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
				//wirteFile ($dest.'xml/Pages.xml',$content);
				$i++;
			} // while
		}
		//แก้ไข config ebook
		copy ('ebook/new_master/javascript/config.js',$dest.'javascript/config.js');
		$num_pages = $db->db_num_rows($db->query("select * from ebook_page where ebook_code like '$ebookCode' "));
		$detail_ebook = $db->db_fetch_array ($db->query("select * from ebook_info where ebook_code like '$ebookCode' "));
		//read the entire string
		$str=file_get_contents($dest.'javascript/config.js');
		//replace something in the file string - this is a VERY simple example
		$str=str_replace("bookConfig.totalPageCount=0;", "bookConfig.totalPageCount=$num_pages;",$str);
		$str=str_replace("bookConfig.largePageWidth=1800", "bookConfig.largePageWidth=".$detail_ebook['ebook_w'],$str);
		$str=str_replace("bookConfig.largePageHeight=2607", "bookConfig.largePageHeight=".$detail_ebook['ebook_h'],$str);
		
		//write the entire string
		file_put_contents($dest.'/javascript/config.js', $str);
		
		/*
			//Write XML File
			$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
			wirteFile ($dest.'xml/Pages.xml',$content);
		*/
		
		//header ("Location:mgt_page.php?ebookCode=$ebookCode");
	?>
	<script language="JavaScript">
		location.href='mgt_page.php?ebookCode=<?php echo $ebookCode;?>';
	</script>
	<?php
	}
	if ($_POST[proc]=='saveValue'){
		$ebook_value1=$_POST['ebook_value1'];
		$ebook_value2=$_POST['ebook_value2'];
		$sql = "select * from ebook_value where ebook_value_id = '1'";
		$query = $db->query($sql);
		if($db->db_num_rows($query) == 0){
			$db->query ("INSERT INTO ebook_value  (ebook_value,ebook_value_id) VALUES ('$ebook_value1','1')");
			$db->query ("INSERT INTO ebook_value  (ebook_value,ebook_value_id) VALUES ('$ebook_value2','2')");
		}else{
			$db->query ("UPDATE ebook_value SET ebook_value='$ebook_value1' WHERE ebook_value_id='1' ");
			$db->query ("UPDATE ebook_value SET ebook_value='$ebook_value2' WHERE ebook_value_id='2' ");
		}
		$db->write_log("update","ebook","กำหนดความจุไฟล์ Media = ".$ebook_value1." KB ,pdf =".$ebook_value2."KB");
		//header ("Location:mgt_value.php");
	?>
	<script language="JavaScript">
		alert("บันทึกเรียบร้อย");
		location.href='mgt_value.php';
	</script>
	<?php
	}
	
	if ($proc=='savepreset'){
		$name_preset=$_POST['name_preset'];
		$db->write_log("create","ebook","สร้าง  การจัดการขนาดไฟล์ E-book ชื่อ".$name_preset);
		$w=$_POST['w'];
		$h=$_POST['h'];
		$db->query ("INSERT INTO ebook_preset (ebook_preset_id,ebook_preset_name,ebook_preset_w,ebook_preset_h)  VALUES('','$name_preset','$w','$h')");
		
	 	//header ("Location:mgt_preset.php");
	?>
	<script language="JavaScript">
		location.href='mgt_preset.php';
	</script>
	<?php
	}
	if ($proc=='delpreset'){
		$preset_id=$_GET['preset_id'];
		$sql = $db->db_fetch_array($db->query("SELECT * from ebook_preset WHERE ebook_preset_id='$preset_id' "));
		$db->write_log("delete","ebook","ลบ  การจัดการขนาดไฟล์ E-book ชื่อ".$sql[ebook_preset_name]);
		$db->query ("DELETE FROM ebook_preset WHERE ebook_preset_id='$preset_id' ");	 
	 	//header ("Location:mgt_preset.php");
	?>
	<script language="JavaScript">
		location.href='mgt_preset.php';
	</script>
	<?php
	}
	if ($proc=='editpreset'){
		$preset_id=$_POST['preset_id'];
		$name_preset=$_POST['name_preset'];
		$db->write_log("update","ebook","แก้ไข  การจัดการขนาดไฟล์ E-book ชื่อ".$name_preset);
		$w=$_POST['w'];
		$h=$_POST['h'];
		$db->query ("UPDATE ebook_preset  set ebook_preset_name='$name_preset',ebook_preset_w='$w',ebook_preset_h='$h' WHERE ebook_preset_id='$preset_id' ");	 
	 	//header ("Location:mgt_preset.php");
	?>
	<script language="JavaScript">
		location.href='mgt_preset.php';
	</script>
	<?php
	}
	$db->db_close(); 
	
	
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