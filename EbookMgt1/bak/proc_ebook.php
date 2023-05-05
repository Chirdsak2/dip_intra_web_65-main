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
	 $wh = " where ebook_code like '$ebookCode' and ebook_page='$ref' ";
	 $rec = $db->db_fetch_array($db->query("select * from ebook_page $wh "));
	$db->write_log("delete","ebook","ลบ E-book หน้า".$rec[ebook_page]);
	$db->query ("DELETE FROM ebook_page $wh");
	 unlink($dest.'/'.$ebookCode.'/pages/'.$rec['ebook_page_file']);

	 //Write XML File
	$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
	wirteFile ($dest.'/'.$ebookCode.'/xml/Pages.xml',$content);

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
	        $db->query("UPDATE ebook_info SET ebook_name='$name',ebook_desc='$desc',ebook_w='$w',ebook_h='$h',update_date='$today',ebook_by='$by',show_status='$status',g_ebook_id='".$_POST[groupebook]."'  WHERE ebook_code like '$ebookCode' ");
			$db->write_log("update","ebook","แก้ไข E-book ชื่อ".$name);
			
	 }	

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
	 $fileUpload = $refPage.'.'.$typeFile;
	 $dest .='/'.$ebookCode.'/';
	  copy($src,$dest.'pages/'.$fileUpload );

      $db->query ("INSERT INTO ebook_page (ebook_code,ebook_page,ebook_page_type,ebook_page_date,ebook_page_file) VALUES ('$ebookCode','$refPage','$typeFile','$today','$fileUpload') ");

	 //Write XML File
	$content = getContent_Page ($recEbook['ebook_w'],$recEbook['ebook_h'],$ebookCode);
	wirteFile ($dest.'xml/Pages.xml',$content);
	$db->write_log("create","ebook","เพิ่มหน้า E-book หน้าที่ ".$refPage);
    print "<script> alert ('เพิ่มหน้า E-Book เรียบร้อยแล้ว');self.location.href='../FileMgt/gallery_index.php?flag=gallery&myfolder=".$myfolder."';</script>";
   exit;
}

if ($proc=='savePage') {
	//Initial var
	$ebookCode= $_POST['ebookCode'];
	$amtFile=$_POST['amtFile'];
	$dest .='/'.$ebookCode.'/'; 
	$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '1' ")); 
	$maxSize = $recValue['ebook_value'];
	$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '2' ")); 
	$maxPDFSize = $recValue['ebook_value'];


    // Many file
	$i =0;
    while ($i < $amtFile) {
     $refPage = $lastPage+$i;
 if ($_FILES['pageFile'.$refPage]!='' && $_FILES['pageFile'.$refPage]!='none') {
   $typeFile = getType_File ($_FILES['pageFile'.$refPage]['name']);
   $sizeFile = (${'pageFile'.$refPage.'_size'}/1024); // 1024 is 1 kbyte
   $fileUpload = $refPage.'.'.$typeFile;
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
          copy ($_FILES['pageFile'.$refPage]['tmp_name'],$currentDir.$tmpPdf ); // Copy File
          $command = $currentDir.'pdftoimage -i "'.$currentDir.$tmpPdf.'" -o "'.$currentDir.'output_pdf" -q '.$quality.' -z '.$zoom;
		  exec ($command);  //Gen page to floder

	   $dh = opendir($currentDir.'output_pdf/'); //Add All Page
		while ($item = readdir($dh))
		 {
		    if ($item != "." && $item != ".." && $item != "Thumbs.db") {
			    $typeFile = getType_File ($item);
				$fileUpload = $refPage.'.jpg';
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
	  copy ($_FILES['pageFile'.$refPage]['tmp_name'],$dest.'pages/'.$fileUpload); // Copy page
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
?>