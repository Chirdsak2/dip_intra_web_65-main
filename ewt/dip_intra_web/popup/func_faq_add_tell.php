<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
 
 
$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='Faq_Add_Tell'){
	
if($a_data['chkpic'] == $a_data['capt']){ 	
	
		    $s_faq = "SELECT * FROM faq WHERE faq_use = 'Y' AND fa_id = '{$a_data['fa_id']}' ";
            $q_faq = $db->query($s_faq);
            $a_faq = $db->db_fetch_array($q_faq);
			
$to = trim($a_data['email-recipient']);

$subject = "=?UTF-8?B?".base64_encode("Tell a friend")."?=";		
$message = '
		<html>
		<head>
		<title>'.$subject.'</title>
		</head>
		<body>
		
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">A : '.$a_faq['fa_name'].'</td></tr>
			<tr><td bgcolor = "#EEEEEE">Q : '.$a_faq['fa_ans'].' </td></tr>
		</table><br><br>
		<table bgcolor = "#FFFFFF" border = "0" width = "100%">
			<tr>
			<td  width="10%">คุณ : </td>
			<td  width="90%">'.$a_data['name-sender'].'</td>
			
			</tr>
			<tr>
			<td >ความคิดเห็น : </td>
			<td >'.$a_data['detail-sender'].'</td>
			</tr>

		</table><br><br>
		
		</body>
		</html>';

$from ="<info@otcc.or.th>";
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "To: ".$to." \r\n";
$headers .= "From: OTCC Webmaster".$from."  \r\n";
// Send
@mail($to, $subject, $message, $headers);
	
	
	
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
	}
}

?>