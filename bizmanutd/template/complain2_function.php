<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/libmail.php');

$sql = "select * from m_complain where id = '".$_GET[mcom_id]."'";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);

$Table = "Select * From m_complain_info Where Complain_lead_ID = '".$R[flag]."' ";
$result = $db->query($Table);
$total=$db->db_num_rows($result);
$row = $db->db_fetch_array($result);
$Emailaddress =  $row["Complain_lead_email"];
$topic =  $row["Complain_lead_name"];
//ดึงภาพแสดงเป็น binary
$fp = fopen ("http://www.thumbizy.com/thumblib.img/".$_GET[ata], 'rb');
$ata = '';
while($html = @fgets($fp, 2024)){
$ata .= $html;
}
fclose($fp);


$thumbnails_folder = 'upload_complain/';
$cached_filename1 = $R[attach_img];
$cached_filename = $thumbnails_folder.$cached_filename1;
//บันทึกภาพลงserver
if (!$fp = fopen($cached_filename, 'a')) {
         print "Cannot open file ($cached_filename)";
         exit;
    }

    // Write $somecontent to our opened file.
		if (!fwrite($fp, $ata)) {
			print "Cannot write to file ($cached_filename)";
			exit;
		}
fclose($fp);

$tb = "ร้องเรียน : $topic";
$message = "Url :  ".$R[url]." \r\n<br>";
$message .= "".$R[detail]." \r\n \r\n <br><br> แจ้งโดย :  ".$R[name]." \r\n<br> Email  : ".$R[email]."";
// Send
//@mail($to, $subject, $message, $headers); 
$from_name = "From: ระบบรับเรื่องแจ้งเว็บไซต์ไม่เหมาะสม";
$from_email = $R[email];
$subject = $tb;
$m = new Mail();
$m->From($from_name."<".trim($from_email).">");
$m->Subject($subject);
$m->Body($message,"text/html");
$m->Attach($cached_filename,"image/jpeg");
$m->To(trim($Emailaddress));
$m->Send();


?>
<script language="javascript1.2">
alert('   ระบบได้ทำการส่งข้อมูลของท่านเรียบร้อยแล้ว       ');
window.location.href = "main.php?filename=<?php echo $_GET[filename];?>";
</script>
<?php @$db->db_close(); ?>