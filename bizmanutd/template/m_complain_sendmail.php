<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$Table = "Select * From m_complain_info Where Complain_lead_ID = '$_POST[select]' ";
$result = mysql_query($Table);
$total=mysql_num_rows($result);
$row = mysql_fetch_array($result);
$Emailaddress =  $row["Complain_lead_email"];






// check  Vulgar

if ($Com_In != "" ){
$Inner = "1";
}else{
	$Inner = "0";
}


mysql_query("INSERT INTO m_complain (id,topic,name,personalid,email,tel,job,address,detail,date,time,ip,flag) VALUES ('' , '$_POST[topic]' , '$_POST[name]' , '$_POST[personalid]' ,'$_POST[email]','$_POST[tel]','$_POST[job]','$_POST[address]', '$_POST[detail]' , NOW( ) , NOW( )  ,'$_SERVER[REMOTE_ADDR]','$_POST[select]' )");

	$tb = "ร้องเรียน : $_POST[topic]";

//mail("$Emailaddress","$Ccom_title","ข้อความ \n$Ccom_details  \n Email: $com_email ",  "From: $Ccom_name", "Email: $com_email");

$to = $Emailaddress;
$subject = $tb;
$message = "$_POST[detail] \r\n \r\n <br><br> แจ้งโดย :  $_POST[name] \r\n<br>เบอร์โทรศัพท์  : $_POST[tel]  \r\n<br> Email  : $_POST[email]  \r\n<br>ที่อย ู่ : $_POST[address] ";
$headers = "From: ระบบรับเรื่อง $_POST[email]\r\n" .
       'X-Mailer: PHP/' . phpversion() . "\r\n" .
       "MIME-Version: 1.0\r\n" .
       "Content-Type: text/html; charset=UTF-8\r\n" .
       "Content-Transfer-Encoding: 8bit\r\n\r\n";

// Send
@mail($to, $subject, $message, $headers); 

?>
<script>
alert("   ระบบได้ทำการส่งข้อมูลของท่านเรียบร้อยแล้ว       ");
window.location.href = "index.php";
</script>
<?php @$db->db_close(); ?>