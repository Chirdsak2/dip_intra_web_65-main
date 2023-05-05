<?php
include("authority.php");
?>
<?php 
$db->query("USE ".$EWT_DB_USER);
$sql = $db->query("select url from user_info where EWT_User = '".$EWT_FOLDER_USER."'");
$R=$db->db_fetch_array($sql);
$url = $R[url];
$db->query("USE ".$EWT_DB_NAME);
include('libmail.php');

////////////////////////////// body /////////////////////////////

$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";


if($stype == "text/html"){
$Sel2 = "select * from n_temp where t_id = '$seltemp'";
$Ex2 = $db->query($Sel2);
$R = mysql_fetch_array($Ex2);
$fp2 = @fopen($Path_true."/".$R[t_name].".html", "r");
if(!$fp2){ die("Cannot open template"); }
while($html2 = @fgets($fp2, 1024)){
	if(!eregi("href=\"http://",$html2)){
	$body .= str_replace('href="','href="'.$url,$html2);
	}else{
	$body .= $html2;
	}
}
@fclose($fp2);
}elseif($stype == "text/plain"){
$body = eregi_replace ( chr(13) , "<br>" , $bodytext );
}
///////////////////////////////////////////////////////////////////
$db->query("INSERT INTO n_history (h_subject,h_from_n,h_from_e,h_body,h_attach,h_date,h_time,h_user) VALUES ('".addslashes($subject)."','".addslashes($from_name)."','".addslashes($from_email)."','".addslashes($body)."','',NOW( ),NOW( ),'0')");
$hid = mysql_insert_id();
///////////////////////////////////////////////////////////////////
for($y=0;$y<$allg;$y++){
	$tog = "tog".$y;
	$tog = $$tog;
	if($tog != ""){
$plus .= " or n_group_member.g_id = '$tog'";
	}
}

$Sel = "select distinct(n_member.m_email) from n_member,n_group_member where n_member.m_id = n_group_member.m_id and n_member.m_active = 'Y' and ( n_group_member.g_id = '0'";
$Sel .= $plus;
$Sel .= " )";

$Ex = $db->query($Sel);
while($RR = mysql_fetch_array($Ex)){

	$m = new Mail();

	

		$m->From($from_name."<".trim($from_email).">");

		$m->Subject($subject);



		$m->Body($body,"text/html");
		

//////////////////////////////// attach ///////////////////////////

for($i=0;$i<$alla;$i++){
	$att = "att".$i;
	$att = $$att;
		$att_name = "att_name".$i;
	$att_name = $$att_name;
		$att_type = "att_type".$i;
	$att_type = $$att_type;
	if($att != ""){
$m->Attach($Path_true."/".$att_name,$att_type);
	}
}
///////////////////////////// To /////////////////////////////////

$detail .= ", ".$RR[m_email];

$m->To(trim($RR[m_email]));

$m->Send();
$db->query("INSERT INTO n_send (h_id,s_date,s_time,s_email) VALUES ('$hid',NOW( ),NOW( ),'$RR[m_email]')");
}
////////////////////////////// Custom Email ////////////////////////////////

if($sendtoother == "Yes"){
$cusmail = eregi_replace ( ";" , "," , $cusmail );
$Exp = explode(",",$cusmail);
$x = 0;
while($Exp[$x]){

	$mx = new Mail();

	

		$mx->From($from_name."<".trim($from_email).">");

		$mx->Subject($subject);



		$mx->Body($body,"text/html");
		

//////////////////////////////// attach ///////////////////////////

for($i=0;$i<$alla;$i++){
	$att = "att".$i;
	$att = $$att;
		$att_name = "att_name".$i;
	$att_name = $$att_name;
		$att_type = "att_type".$i;
	$att_type = $$att_type;
	if($att != ""){
$mx->Attach($Path_true."/".$att_name,$att_type);
	}
}
///////////////////////////// To /////////////////////////////////

$detail .= ", ".trim($Exp[$x]);

$mx->To(trim($Exp[$x]));

$suc = $mx->Send();
$db->query("INSERT INTO n_send (h_id,s_date,s_time,s_email) VALUES ('$hid',NOW( ),NOW( ),'$Exp[$x]')");
$x++;
}
}

///////////////////////////// Send to me //////////////////////////////////

if($sendtosend == "Yes"){

	$mo = new Mail();

	

		$mo->From($from_name."<".trim($from_email).">");

		$mo->To(trim($from_email));

		$mo->Subject("Info : \"".$subject."\"");


$body1 = "<font face='MS Sans Serif' size=2><b>Send E-NewsLetter to</b> ".$from_name.$detail."<br><b>Message:</b></font><hr>".$body;
		$mo->Body($body1,"text/html");
		

//////////////////////////////// attach ///////////////////////////

for($i=0;$i<$alla;$i++){
	$att = "att".$i;
	$att = $$att;
		$att_name = "att_name".$i;
	$att_name = $$att_name;
		$att_type = "att_type".$i;
	$att_type = $$att_type;
	if($att != ""){
$mo->Attach($Path_true."/".$att_name,$att_type);
	}
}
$mo->Send();
$db->query("INSERT INTO n_send (h_id,s_date,s_time,s_email) VALUES ('$hid',NOW( ),NOW( ),'$from_email')");
$db->write_log("sendmail","enews","ส่ง E-mail จดหมายข่าว เรื่อง  ".$subject);
}
/////////////////////////////////////////////////////////////////
?>
<script language = "javascript">

	window.location.href="mail_send.php?msg=Y" ;

</script>
