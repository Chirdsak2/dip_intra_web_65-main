<?php
DEFINE('mailer','../phpmailer/');
include("assets/config.inc.php");
include("assets/class/sendmail.class.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../phpmailer/phpmailer.class.php");  

$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);
$s_data = array();

if($a_data['proc']=='Complain_Add'){

if($a_data['chkpic'] == $a_data['capt']){ 

$Complain_lead_ID = ready($a_data['complain_category']);

$s_sql  = $db->query("SELECT * FROM m_complain_info WHERE Complain_lead_ID = '{$Complain_lead_ID}' ");
$a_rows = $db->db_num_rows($s_sql);
$a_info = $db->db_fetch_array($s_sql);

$topic        =   $a_info['Complain_lead_name'];
$mailadmin    =   $a_info['Complain_lead_email'];
$from         =   $a_data['complain_email'];


$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('file')); 
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = "/^\.(".ValidfileType('file')."){1}$/i"; 
$dir_base = "../file_attach/"; 

$isFile = is_uploaded_file($_FILES['complain_attack']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['complain_attack']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "file_attach_complain_".date("YmdHis").$type_file;
	 
    if ($_FILES['complain_attack']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {	
		  $isMove = move_uploaded_file($_FILES['complain_attack']['tmp_name'],$dir_base.$newfile);
		  } 
	$fileattach = $newfile;
      }else{
		  $fileattach = "";		  	  
	  }

	  
$s_data['topic']        = ready($a_data['complain_title']);
$s_data['name']         = ready($a_data['complain_name']);
$s_data['personalid']   = ready($a_data['complain_idcard']);
$s_data['email']        = ready($a_data['complain_email']);
$s_data['tel']          = ready($a_data['complain_tel']);	
$s_data['detail']       = ready($a_data['complain_detail']);
$s_data['flag']         = ready($a_data['complain_category']);
$s_data['date']         = $date->format('Y-m-d');
$s_data['time']         = $date->format('H:i:s');
$s_data['c_read']       = 'S';
$s_data['ip']           = getIP();
$s_data['attach_img']   = $fileattach;
$s_data['job']          = ready($a_data['complain_job']);
$s_data['address']      = ready($a_data['complain_address']);
$s_data['place']        = ready($a_data['complain_place']);
$s_data['physical']     = ready($a_data['complain_physical']);
$s_data['witness']      = ready($a_data['complain_witness']);  
$s_data['date_incident']= ''; 
$s_data['person']		= ready($a_data['complain_person']);  
$s_data['subject']		= ready($a_data['complain_subject']);   
$s_data['optional1']	= ready($a_data['optional1']);  
$s_data['optional2']	= ready($a_data['optional2']);   

insert('m_complain',$s_data);

if(!empty($a_data['complain_email'])){
$sentto1 = $a_data['complain_email'];
$subject1 = "=?UTF-8?B?".base64_encode("".$topic."")."?=";
$message1 = '
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>'.$subject1.'</title>
		</head>
		<body>
		<table bgcolor="#FFFFFF" border="0" width="100%">
		<tr><td width="30%" bgcolor="#FFFFFF">สำนักงานพัฒนาเทคโนโลยีอวกาศและภูมิสารสนเทศ (องค์การมหาชน) ได้รับข้อมูลที่ท่านแจ้งเรียบร้อยแล้ว</td></tr>
		</table><br><br>
		</body>
		</html>';
$from1 ="<info@otcc.or.th>";
$headers1  = "MIME-Version: 1.0\r\n";
$headers1 .= "Content-type: text/html; charset=UTF-8\r\n";
$headers1 .= "To: ".$sentto1." \r\n";
$headers1 .= "From:  OTCC Webmaster".$from1."  \r\n";
//@mail($sentto1, $subject1, $message1, $headers1);

	$s_message1 	= '<div>สำนักงานพัฒนาเทคโนโลยีอวกาศและภูมิสารสนเทศ (องค์การมหาชน) ได้รับข้อมูลที่ท่านแจ้งเรียบร้อยแล้ว </div>';
	$s_subject1 	= 'แจ้งเรื่องร้องเรียน';
	$s_fromname1 	= 'สำนักงานพัฒนาเทคโนโลยีอวกาศและภูมิสารสนเทศ (องค์การมหาชน)  ';
	$s_sendfrom1	= E_EMAIL; 
	$s_sendto1		= $a_data['complain_email'];  	
	$result1 = sendmail::sendmailSMTP($s_sendto1,$s_sendfrom1,$s_fromname1,$s_subject1,$s_message1);

}		
 	
	
if(!empty($mailadmin)){
$sentto = $mailadmin;
$subject = "=?UTF-8?B?".base64_encode("".$topic."")."?=";
$message = '
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>'.$subject.'</title>
		</head>
		<body>
		<table bgcolor="#FFFFFF" border="0" width="100%">
		<tr><td width="30%" bgcolor="#FFFFFF">หัวข้อ</td><td>: '.$a_data['complain_title'].'</td></tr>
		<tr><td width="30%" bgcolor="#FFFFFF">ชื่อผู้ติดต่อ</td><td>: '.$a_data['complain_name'].'</td></tr>
		<tr><td width="30%" bgcolor="#FFFFFF">รายละเอียด</td><td>: '.$a_data['complain_detail'].'</td></tr>
		<tr><td width="30%" bgcolor="#FFFFFF">อีเมล์</td><td>: '.$a_data['complain_email'].'</td></tr>
		<tr><td width="30%" bgcolor="#FFFFFF">เบอร์โทรศัพท์</td><td>: '.$a_data['complain_tel'].'</td></tr>
		</table><br><br>
		</body>
		</html>';
$from ="<info@otcc.or.th>";
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "To: ".$sentto." \r\n";
$headers .= "From: OTCC Webmaster".$from."  \r\n";
//@mail($sentto, $subject, $message, $headers);

	$s_message = '
				<div>'.$topic.'</div>
				<div>หัวข้อเรื่องร้องเรียน  : '.$a_data['complain_title'].'</div>
				<div>จาก คุณ : '.$a_data['complain_name'].'</div>
				<div>รายละเอียด:  '.$a_data['complain_detail'].'</div>';
			
	$s_subject 	= 'แจ้งเรื่องร้องเรียน';
	$s_fromname = 'สำนักงานพัฒนาเทคโนโลยีอวกาศและภูมิสารสนเทศ (องค์การมหาชน)  ';
	$s_sendfrom	= E_EMAIL; 
	$s_sendto	= $mailadmin; 
	
	$result = sendmail::sendmailSMTP($s_sendto,$s_sendfrom,$s_fromname,$s_subject,$s_message);
}	
	
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
}	
}
?>