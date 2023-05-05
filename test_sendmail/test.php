
<html>
<title>Test Sendmail</title>
<body>
<style type="text/css">
td, input {
	font-family: Tahoma, Verdana;
	font-size: 12px;
}
</style>
<h3>PHP Mailer Unit Test</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<table border="1" cellpadding="5" cellspacing="1" bordercolor="#C9D0D6">
	<tr height="30">
		<td colspan="2">Mechanical Engineer</td>
	</tr>
	<tr height="30">
		<td width="150">Send Method</td>
		<td width="400">
			<input type="radio" name="send_mailer" value="mail" <?php echo ($_REQUEST["send_mailer"]=='mail'?' checked':''); ?>/>PHP Mail Function
			<input type="radio" name="send_mailer" value="smtp" <?php echo ($_REQUEST["send_mailer"]=='smtp'?' checked':''); ?>/>SMTP
		</td>
	</tr>
	<tr height="30">
		<td width="150">Send From</td>
		<td width="400"><input type="text" size="50" name="send_from" value="<?php echo $_REQUEST["send_from"]; ?>"/></td>
	</tr>
	<tr height="30">
		<td width="150">Send To</td>
		<td width="400"><input type="text" size="50" name="send_to" value="<?php echo $_REQUEST["send_to"]; ?>"/></td>
	</tr>
	<tr height="30">
		<td width="150">SMTP Hostname</td>
		<td width="400"><input type="text" size="50" name="smtp_hostname" value="<?php echo $_REQUEST["smtp_hostname"]; ?>"/></td>
	</tr>
	<tr height="30">
		<td width="150">SMTP Port</td>
		<td width="400"><input type="text" size="50" name="smtp_port" value="<?php echo ($_REQUEST["smtp_port"]?$_REQUEST["smtp_port"]:'25'); ?>"/></td>
	</tr>
	<tr height="30">
		<td width="150">SMTP Authentication</td>
		<td width="400">
			<input type="radio" name="smtp_auth" value="1" <?php echo ($_REQUEST["smtp_auth"]=='1'?' checked':''); ?>/>Yes
			<input type="radio" name="smtp_auth" value="0" <?php echo ($_REQUEST["smtp_auth"]=='0'?' checked':''); ?>/>No
		</td>
	</tr>
	<tr height="30">
		<td width="150">SMTP Username</td>
		<td width="400"><input type="text" size="50" name="smtp_username" value="<?php echo $_REQUEST["smtp_username"]; ?>"/></td>
	</tr>
	<tr height="30">
		<td width="150">SMTP Password</td>
		<td width="400"><input type="password" size="50" name="smtp_password" value="<?php echo $_REQUEST["smtp_password"]; ?>"/></td>
	</tr>
	</table>
	<br />
	<input type="submit" value="Run Test"/>

</form>
</body>
</html>
<?php
/*******************
  PHP Mail Unit Test
********************/

//error_reporting(E_PARSE|E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR|E_USER_ERROR);
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$INCLUDE_DIR = "./";
	//require("phpunit.php");
	require($INCLUDE_DIR . "phpmailer.class.php");

	$mail = new PHPMailer();
	$mail->Subject = 'Test Sendmail ('.date('H:i:s').')';
	$mail->From = $_POST["send_from"];
	$mail->FromName = 'PHP Mailer';
	$mail->Mailer = $_POST["send_mailer"];
	$mail->Host = $_POST["smtp_hostname"];
	$mail->Port = $_POST["smtp_port"];
	$mail->SMTPAuth = $_POST["smtp_auth"];
	$mail->SMTPDebug = true;
	$mail->Username = $_POST["smtp_username"];
	$mail->Password = $_POST["smtp_password"];
	$mail->SMTPSecure = 'tls';

	// Plain text body (for mail clients that cannot read HTML)
	$text_body = "\n\n";
	$text_body .= "Hello World \n\n";
	$text_body .= "PHP Mail Unit Test \n\n";
	$text_body .= "PHP Mail Unit Test \n\n";
	$text_body .= "PHP Mail Unit Test \n\n";
	$text_body .= "ภาษาไทย \n\n";

	$mail->Body = $text_body;

	$mail->AddAddress($_REQUEST["send_to"]);

	echo '<pre>';
	if(!$mail->Send()) {
		echo "There has been a mail error sending<br>";
		echo $mail->ErrorInfo;
	} else {
		echo "Mail has been sending<br>";
	}
	echo '</pre>';

}

?>
