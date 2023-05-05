<?php
include("../EWT_ADMIN/comtop_pop.php");
$dest = "../ewt/" . $_SESSION["EWT_SMUSER"] . "/";
$a_data = array_merge($_POST, $_FILES);

$proc = $a_data['proc'];
//print_r($a_data);
//exit;
switch ($proc) {
	case "Add_Poll":

		if (is_array($a_data)) {

			$timeH = $a_data['poll_H'] * 3600;
			$timeM = $a_data['poll_M'] * 60;
			$timeSet = $timeH + $timeM;

			$s_data = array();

			$s_data['c_name']       =  $a_data['poll_title'];
			$s_data['c_use']        =  '';
			$s_data['c_detail']     =  $a_data['poll_detail'];
			$s_data['c_timestamp']  =  datetimetool::getnow();
			$s_data['c_uid']        =  $_SESSION['EWT_SMID'];
			$s_data['c_creater']    =  $_SESSION["EWT_SMUSER"];
			$s_data['c_lastupdate'] =  datetimetool::getnow();
			$s_data['c_ip']         =  getIP();
			$s_data['c_start']      =  datetimetool::format(str_replace('/', '-', $a_data['start_date']), 'Y-m-d');
			$s_data['c_stop']       =  datetimetool::format(str_replace('/', '-', $a_data['end_date']), 'Y-m-d');
			$s_data['c_approve']    =  $a_data['poll_show'];
			$s_data['c_timestart']  =  '';
			$s_data['c_timestop']   =  '';
			$s_data['c_view']       =  '0';
			$s_data['c_set_time']   =  $timeSet;
			$s_data['c_status']     =  $a_data['c_status'];

			insert('poll_cat', $s_data);
			$s_max = countmax('poll_cat', 'c_id');
			/*$a_user = org::getUserID();     
			$db->query("USE ".$EWT_DB_NAME); 	
			foreach((array)$a_user as $_item)  
			{  
				$s_title = 'แบบสำรวจโพล '.$a_data['poll_title'];
				sys::save_Noti('Y',$s_title,'poll',$_item['user_id'],'');    
				$sentto = $_item['user_email']; 		
				if(!empty($sentto))
				{ 
					$s_message 	= '<div>'.$a_data['poll_title'].'</div>';
					$s_message .= '<div>'.$a_data['poll_detail'].'</div>'; 
					$s_subject 	= 'แบบสำรวจโพล';
					$s_fromname = 'กรมบัญชีกลาง กระทรวงการคลัง '; 
					$s_sendfrom	= E_EMAIL; 
					$s_sendto 	= $sentto;    
					$mailsent 	= sendmail::sendmailSMTP($s_sendto,$s_sendfrom,$s_fromname,$s_subject,$s_message);
					if($mailsent)
					{
						$status = 'Y'; 
					}
					else
					{
						$status = 'N'; 
					}
					sys::save_LogSendMail($s_max,'poll','create-poll-cat',$s_sendto,$s_message,$s_fromname,$s_subject,$status,$_item['user_id']);
				} 	
			}*/
			sys::save_log('create', 'poll', 'เพิ่มแบบสำรวจ  ' . $a_data['poll_title']);
			echo json_encode($s_max);
			//echo json_encode($s_data);								   
			//print_r($a_data);	
			unset($a_data);
			unset($s_data);
			exit;
		} else {
			$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
			echo json_encode($a_error);
			unset($a_data);
			unset($s_data);
			exit;
		}
		exit;
		break;
}
