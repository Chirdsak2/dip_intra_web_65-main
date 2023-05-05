<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

include ("lib.inc.php");
//Initial var
$proc = $_REQUEST['proc'];
 $ebookCode = $_REQUEST["ebookCode"];

$today = date ('Y-m-d');
$dest = "../ewt/".$EWT_FOLDER_USER."/ebook";
$recEbook = $db->db_fetch_array ($db->query("select * from ebook_info where ebook_code like '$ebookCode' ")); 


if ($proc=='delEbook') {
	$wh = " where g_ebook_id like '$ebookCode'  ";
	$sql = $db->db_fetch_array($db->query("select * from ebook_group $wh"));
	$db->query ("DELETE FROM ebook_group $wh"); //Delete tb ebook
	$db->write_log("delete","ebook","ลบ กลุ่ม E-book ชื่อ".$sql[g_ebook_name]);
	//remove_dir($dest.'/'.$ebookCode);
	//header ("Location:bookg_mgt.php");
	?>
						<script language="JavaScript">
						location.href='bookg_mgt.php';
						</script>
	<?php
	exit;
}


if ($proc=='saveEbook') {	
//Initial var
$name = stripslashes(htmlspecialchars($_POST["name"],ENT_QUOTES));
//$desc = stripslashes(htmlspecialchars($_POST["desc"],ENT_QUOTES));
$by = stripslashes(htmlspecialchars($_POST["by"],ENT_QUOTES));
$w = $_POST['w'];
$h = $_POST['h'];
$status = $_POST['status'];
	 if (empty($ebookCode))  { // Add
	        	//Add db
	        $db->query("INSERT INTO ebook_group (g_ebook_name,g_ebook_status) VALUES ('$name','$status')");
			$db->write_log("create","ebook","สร้างกลุ่ม E-book ชื่อ".$name);
	 }else { //Edit
			//Edit db
	        $db->query("UPDATE ebook_group SET g_ebook_name='$name',g_ebook_status='$status'  WHERE g_ebook_id like '$ebookCode' ");
			$db->write_log("update","ebook","แก้ไขกลุ่ม E-book ชื่อ".$name);
	 }	
	 //header ("Location:book_mgt_list.php?ebookCode=".$ebookCode."");
	// header ("Location:bookg_mgt.php?ebookCode=".$ebookCode."");
	?>
						<script language="JavaScript">
						location.href='bookg_mgt.php?ebookCode=<?php echo $ebookCode;?>';
						</script>
	<?php
} 


$db->db_close(); 
?>