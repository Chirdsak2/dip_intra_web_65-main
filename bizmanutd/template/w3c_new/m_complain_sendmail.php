<?php
$path = "../";
	session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");

$Table = "Select * From m_complain_info Where Complain_lead_ID = '$select' ";
$result = mysql_query($Table);
$total=mysql_num_rows($result);
$row = $db->db_fetch_array($result);
$Emailaddress =  $row["Complain_lead_email"];






// check  Vulgar

if ($Com_In != "" ){
$Inner = "1";
}else{
	$Inner = "0";
}


mysql_query("INSERT INTO m_complain (id,topic,name,personalid,email,tel,job,address,detail,date,time,ip,flag) VALUES ('' , '$topic' , '$name' , '$personalid' ,'$email','$tel','$job','$address', '$detail' , NOW( ) , NOW( )  ,'$REMOTE_ADDR','$select' )");

	$tb = "ร้องเรียน : $topic";

//mail("$Emailaddress","$Ccom_title","ข้อความ \n$Ccom_details  \n Email: $com_email ",  "From: $Ccom_name", "Email: $com_email");

$to = $Emailaddress;
$subject = $tb;
$message = "$detail \r\n \r\n <br><br> แจ้งโดย :  $name \r\n<br>เบอร์โทรศัพท์  : $tel  \r\n<br> Email  : $email  \r\n<br>ที่อย ู่ : $address ";
$headers = "From: ระบบรับเรื่อง $email\r\n" .
       'X-Mailer: PHP/' . phpversion() . "\r\n" .
       "MIME-Version: 1.0\r\n" .
       "Content-Type: text/html; charset=UTF-8\r\n" .
       "Content-Transfer-Encoding: 8bit\r\n\r\n";

// Send
@mail($to, $subject, $message, $headers); 

?>
<script>
alert("   ระบบได้ทำการส่งข้อมูลของท่านเรียบร้อยแล้ว       ");
window.location.href = "main.php?filename=<?php echo $filename;?>";
</script>
<?php @$db->db_close(); ?>