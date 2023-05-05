<?php
class sendmail 
{ 	
	public static function sendmailSMTP($s_sendto,$s_sendfrom,$s_fromname,$s_subject,$s_message) 
	{	 
		$mail = new PHPMailer();
		$mail->dirPlugin("phpmailer/");
		$mail->CharSet = "utf-8"; 
		$mail->IsHTML(true);
		$mail->IsSMTP(); 
		$mail->Mailer = SEND_METHOD; 
		$mail->SMTPAuth = true; 
		$mail->SMTPDebug = false;
   	    $mail->SMTPSecure = 'tls';		
        $mail->Host = SMTP_HOST; 		 
		$mail->Port = SMTP_PORT; 
		$mail->Username = SMTP_USERNAME;
		$mail->Password = SMTP_PASSWORD;  		
		$mail->From = $s_sendfrom;
        $mail->FromName = $s_fromname;          
        $mail->Subject = $s_subject;
		$mail->Body     = $s_message; 
		$mail->WordWrap = 100;   
        $mail->AddAddress($s_sendto);
        // print_r($mail);
		// $mail->Send();
		if( @!$mail->Send()) {
			//echo 'ยังไม่สามารถส่งเมลล์ได้ในขณะนี้ <pre>' . $mail->ErrorInfo."</pre>"; 
			return false;			
		}	
		return true;
	}
}
?>