<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$dest = "../ewt/".$_SESSION["EWT_SUSER"]."/"; 
DEFINE('mailer',$dest.'phpmailer/'); 
include($dest."popup/assets/class/sendmail.class.php");
include($dest."phpmailer/phpmailer.class.php");   

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Comment'){
	
$s_data = array();

$s_data['c_read']  = 'M';
$s_data['reply']   = $a_data['complain_comment'];


/*$s_data['com_form_title']  = $a_data['com_form_title'];
$s_data['com_form_createdate']  = $date->format('Y-m-d H:i:s');
$s_data['com_form_update']  = $date->format('Y-m-d H:i:s');
$s_data['com_form_status']  = 'Y';*/

//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

//insert('m_complain_form',$s_data);
	
//$_max = countmax('m_complain_form','com_form_id');	

update('m_complain',$s_data,array('id'=>$a_data['com_id']));

$_sql = $db->query("SELECT *					
					FROM m_complain
					WHERE id = '{$a_data['com_id']}' ");			  
$a_rows = $db->db_num_rows($_sql);		
$a_data_m = $db->db_fetch_array($_sql);

$s_sql  = $db->query("SELECT * FROM m_complain_info WHERE Complain_lead_ID = '{$a_data_m['flag']}' ");
$a_rows = $db->db_num_rows($s_sql);
$a_info = $db->db_fetch_array($s_sql);

$topic        =   $a_info['Complain_lead_name'];
$mailadmin    =   $a_info['Complain_lead_email'];

if(!empty($a_data_m['email'])){
$sentto1 = $a_data_m['email'];
$subject1 = "=?UTF-8?B?".base64_encode("".$topic."")."?=";
$message1 = '
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>'.$subject1.'</title>
		</head>
		<body>
		<table bgcolor="#FFFFFF" border="0" width="100%">
		<tr>
		<td width="10%" bgcolor="#FFFFFF">หัวข้อ : </td>
		<td width="90%">  '.$a_data_m['topic'].'</td></tr>
		<tr>
		<td width="10%" bgcolor="#FFFFFF">ตอบกลับ : </td>
		<td width="90%">  '.$a_data['complain_comment'].'</td></tr>

		</table><br><br>
		</body>
		</html>';
$from1 ="<info@otcc.or.th>";
$headers1  = "MIME-Version: 1.0\r\n";
$headers1 .= "Content-type: text/html; charset=UTF-8\r\n";
$headers1 .= "To: ".$sentto1." \r\n";
$headers1 .= "From: OTCC Webmaster".$from1."  \r\n";
//@mail($sentto1, $subject1, $message1, $headers1);

	$s_message = '
				<div>'.$topic.'</div>
				<div>หัวข้อเรื่องร้องเรียน  : '.$a_data_m['topic'].'</div>
				<div>จาก คุณ : '.$a_data_m['name'].'</div> 
				<div>รายละเอียด:  '.$a_data_m['detail'].'</div>
				<div></div>
				<div>ตอบกลับ:  '.$a_data['complain_comment'].'</div>'; 
				
	$s_subject 	= 'ตอบกลับเรื่องร้องเรียน';
	$s_fromname = 'สำนักงานพัฒนาเทคโนโลยีอวกาศและภูมิสารสนเทศ (องค์การมหาชน)  ';
	$s_sendfrom	= E_EMAIL; 
	$s_sendto	= $a_data_m['email']; 
	
	$result = sendmail::sendmailSMTP($s_sendto,$s_sendfrom,$s_fromname,$s_subject,$s_message);
}
						   
print_r($result);	

unset($a_data);
unset($s_data);

exit;
	} 
?>