<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

 if($_SERVER["REMOTE_ADDR"]) 
	{
		$IPn = $_SERVER["REMOTE_ADDR"];
	}	 
else 
	{
		$IPn = $_SERVER["REMOTE_HOST"];
	}
if($_POST[pict] == $_SESSION["gen_pic_complain"]){
$Table = "Select * From m_complain_info Where Complain_lead_ID = '".$_POST[type_name]."' ";
$result = $db->query($Table);
$total=$db->db_num_rows($result);
$row = $db->db_fetch_array($result);
$Emailaddress =  $row["Complain_lead_email"];
$topic =  $row["Complain_lead_name"];
//upfile
if($_POST[url_name] != ''){
$thumbnails_folder = 'upload_complain/';
$cached_filename1 = $_SESSION["gen_pic_complain"].date('Ymdhis').".jpg";
$cached_filename = $thumbnails_folder.$cached_filename1;
}


// Get website image and save it on the server.
//@exec('IECapt.exe ' . escapeshellarg($_POST[url_name]) . ' ' . escapeshellarg($cached_filename));	
$fp = fopen ("http://www.thumbizy.com/go_2.php?url=".$_POST[url_name]."&format=JPEG&cache=NO&interface=YES&size=360&full=YES&effect=NO", 'r');
$ata = '';
while($html = @fgets($fp, 2024)){
$ata .= $html;
}
fclose($fp);





	if($ata != ''){
		$db->query("INSERT INTO m_complain (id,topic,name,email,tel,detail,date,time,ip,flag,url,attach_img) 
								VALUES ('' , '$topic' , '".$_POST[name]."' ,'".$_POST[email]."','".$_POST[tel]."', '".$_POST[detail]."' , NOW( ) , NOW( )  ,'$IPn','".$_POST[type_name]."','".$_POST[url_name]."','$cached_filename1' )");
			$sql = "select  max(id) as maxid from m_complain order by id DESC ";
			$query = $db->query($sql);
			$u = $db->db_fetch_array($query);
			$mcom_id = $u[maxid];
			?>
			<script language="javascript1.2">
		window.location.href = "complain2_function.php?filename=<?php echo $_POST[filename];?>&ata=<?php echo $ata;?>&mcom_id=<?php echo $mcom_id;?>";
		</script>
		<?php
	}else{
		?>
		<script language="javascript1.2">
		alert('กรุณาระบุ Url เว็บไซต์ที่ท่านต้องการ');
		window.location.href = "main.php?filename=<?php echo $_POST[filename];?>";
		</script>
<?php
	}

}else{
?>
<script language="javascript1.2">
alert('   ท่านกรอกอักษรภาพไม่ถูกต้อง!!       ');
window.location.href = "main.php?filename=<?php echo $_POST[filename];?>";
</script>
<?php
}
?>
<?php @$db->db_close(); ?>