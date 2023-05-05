<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

include ("lib.inc.php");
//Initial var
//$proc = $_POST['proc'];
$today = date ('Y-m-d');
$dest = "../ewt/".$_SESSION["EWT_SUSER"]."/ebook";
$recEbook = $db->db_fetch_array ($db->query("select * from ebook_info where ebook_code like '$ebookCode' 
	")); 


if ($proc=='delEbook') {
	$wh = " where ebook_code like '$ebookCode'  ";
	$db->query ("DELETE FROM ebook_info $wh"); //Delete tb ebook
	$db->query ("DELETE FROM ebook_page $wh"); //Delete tb page
	
	remove_dir($dest.'/'.$ebookCode);
	header ("Location:book_mgt.php");
	exit;
}

if ($proc=='delPage') {
	 $wh = " where ebook_code like '$ebookCode' and ebook_page='$ref' ";
	 $rec = $db->db_fetch_array($db->query("select * from ebook_page $wh "));
	$db->query ("DELETE FROM ebook_page $wh");
	 unlink($dest.'/'.$ebookCode.'/pages/'.$rec['ebook_page_file']);

	 //Write XML File
	$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
	wirteFile ($dest.'/'.$ebookCode.'/xml/Pages.xml',$content);

	 header ("Location:mgt_page.php?ebookCode=$ebookCode");
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
	        $db->query("INSERT INTO ebook_info (ebook_name,ebook_code,ebook_desc,ebook_w,ebook_h,create_date,update_date,ebook_by,show_status) VALUES ('$name','$ebookCode','$desc','$w','$h','$today','$today','$by','$status')");

	        $ebookID = mysql_insert_id();
            $ebookCode = 'B'.substr (($ebookID)+10001,1,4);
			$db->query("UPDATE ebook_info SET ebook_code='$ebookCode' where ebook_id='$ebookID' ");
			//Create Dir & File
			$src = 'ebook/master';	
			if (!file_exists($dest)) {
				 mkdir($dest, 0777);
			}
			$dest .="/".$ebookCode ;
           copy_dir($src,$dest);
			$content = getContent_Index ($name);
			wirteFile ($dest.'/index.html',$content);
		
	 }else { //Edit
	       $content = getContent_Index ($name);
			wirteFile ($dest.'/'.$ebookCode.'/index.html',$content); 
			//Write XML File
	         $content = getContent_Page ($w,$h,$ebookCode);
	         wirteFile ($dest.'/'.$ebookCode.'/xml/Pages.xml',$content);
			//Edit db
	        $db->query("UPDATE ebook_info SET ebook_name='$name',ebook_desc='$desc',ebook_w='$w',ebook_h='$h',update_date='$today',ebook_by='$by',show_status='$status' WHERE ebook_code like '$ebookCode' ");
			
			
	 }	

	 header ("Location:book_mgt.php");
} 
if ($proc=='sendPage') {
	  //Get last page
     $recPage = $db->db_fetch_array ($db->query("select ebook_page from ebook_page where ebook_code like '$ebookCode' order by ebook_page desc")); 
     $lastPage = $recPage['ebook_page'];
	 $refPage = $lastPage+1;

     $typeFile = getType_File ($fname);
	 $fileUpload = $refPage.'.'.$typeFile;
	 $dest .='/'.$ebookCode.'/';
	  copy($src,$dest.'pages/'.$fileUpload );

      $db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('$ebookCode','$refPage','$typeFile','$today','$fileUpload') ");

	 //Write XML File
	$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
	wirteFile ($dest.'xml/Pages.xml',$content);
   
    print "<script> alert ('เพิ่มหน้า E-Book เรียบร้อยแล้ว');self.location.href='../FileMgt/gallery_index.php?flag=gallery&myfolder=".$myfolder."';</script>";
   exit;
}

if ($proc=='savePage') {
	//Initial var
   // $pageFile = $_POST['pageFile'];
   // $typeFile  = $_POST['typeFile'];
	$ebookCode= $_POST['ebookCode'];
	$dest .='/'.$ebookCode.'/'; 
	$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '1' ")); 
	$maxSize = $recValue['ebook_value'];
	$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '2' ")); 
	$maxPDFSize = $recValue['ebook_value'];


    // Many file
	$i =0;
    while ($i < $amtFile) {
     $refPage = $lastPage+$i;
	
 if (${'pageFile'.$refPage}!='' && ${'pageFile'.$refPage}!='none') {
   $typeFile = getType_File (${'pageFile'.$refPage.'_name'});
   $sizeFile = (${'pageFile'.$refPage.'_size'}/1024); // 1024 is 1 kbyte
   $fileUpload = $refPage.'.'.$typeFile;
   //Check size file
   if (($sizeFile > $maxSize && $typeFile !='pdf') || (($sizeFile/1000) > $maxPDFSize && $typeFile =='pdf')) {
	      print "<script> alert ('ขนาดไฟล์หน้าที่ ".$refPage." เกินค่าที่กำหนด  กรุณาระบุใหม่');self.location.href='mgt_page.php?amtFile".$amtFile."&ebookCode=".$ebookCode."';</script>";
          exit;
   }

   if ($typeFile=='pdf') { //Pdf File
	      $path_parts = pathinfo($_SERVER["SCRIPT_FILENAME"]);
           $currentDir = $path_parts['dirname'].'/';
		   $tmpPdf = 'tmp.pdf';
          copy (${'pageFile'.$refPage},$currentDir.$tmpPdf ); // Copy File
		/*  $command = $currentDir.'pdftoimage -r YKEJEHZHHBCDQMYM';
		  exec ($command);*/
     
		$command = $currentDir.'pdftoimage -i "'.$currentDir.$tmpPdf.'" -o "'.$currentDir.'output_pdf" -q '.$quality.' -z '.$zoom;
          exec ($command);  //Gen page to floder

	   $dh = opendir($currentDir.'output_pdf/'); //Add All Page
		while ($item = readdir($dh))
		 {
		    if ($item != "." && $item != ".." && $item != "Thumbs.db") {
			    $typeFile = getType_File ($item);
				$fileUpload = $refPage.'.jpeg';
				copy ('output_pdf/'.$item,$dest.'pages/'.$fileUpload); // Copy page
				$db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('$ebookCode','$refPage','$typeFile','$today','$fileUpload') ");
				$refPage++;
				unlink ('output_pdf/'.$item);
			}
		}
       closedir($dh);
	   unlink($tmpPdf);
        //Write XML File
	   $content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
	   wirteFile ($dest.'xml/Pages.xml',$content);

   }else{
	  copy (${'pageFile'.$refPage},$dest.'pages/'.$fileUpload); // Copy page
    if ($mode=='add') {
	 $db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('$ebookCode','$refPage','$typeFile','$today','$fileUpload') ");
	}else if ($mode=='edit') {
     $db->query ("UPDATE ebook_page SET ebook_page_date='$today',ebook_page_type='$typeFile',ebook_page_file='$fileUpload' where ebook_code like '$ebookCode' and ebook_page='$refPage' ");
	  }
     } // chk PDF
   } //chk file
     //Write XML File
	$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
	wirteFile ($dest.'xml/Pages.xml',$content);
     $i++;
	} // while
/*
   //Write XML File
	$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
	wirteFile ($dest.'xml/Pages.xml',$content);
	*/

	header ("Location:mgt_page.php?ebookCode=$ebookCode");
}
if ($proc=='saveValue'){
	$ebook_value1=$_POST['ebook_value1'];
	$ebook_value2=$_POST['ebook_value2'];
	$db->query ("UPDATE ebook_value SET ebook_value='$ebook_value1' WHERE ebook_value_id='1' ");
	$db->query ("UPDATE ebook_value SET ebook_value='$ebook_value2' WHERE ebook_value_id='2' ");
	 
	 header ("Location:mgt_value.php");
}

if ($proc=='savepreset'){
	$name_preset=$_POST['name_preset'];
	$w=$_POST['w'];
	$h=$_POST['h'];
	 $db->query ("INSERT INTO ebook_preset (ebook_preset_id,ebook_preset_name,ebook_preset_w,ebook_preset_h)  VALUES('','$name_preset','$w','$h')");
	 
	 	header ("Location:mgt_preset.php");
}
if ($proc=='delpreset'){
	$preset_id=$_GET['preset_id'];
	 $db->query ("DELETE FROM ebook_preset WHERE ebook_preset_id='$preset_id' ");	 
	 	header ("Location:mgt_preset.php");
}
if ($proc=='editpreset'){
	$preset_id=$_POST['preset_id'];
	$name_preset=$_POST['name_preset'];
	$w=$_POST['w'];
	$h=$_POST['h'];
	 $db->query ("UPDATE ebook_preset  set ebook_preset_name='$name_preset',ebook_preset_w='$w',ebook_preset_h='$h' WHERE ebook_preset_id='$preset_id' ");	 
	 	header ("Location:mgt_preset.php");
}


$db->db_close(); 
?>
