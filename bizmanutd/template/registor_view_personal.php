<?php
session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

if($_GET[event_id] != '' && $_SESSION["EWT_MID"] != ''){
$date_c = date('Y-m-d');
$event = $db->query("select * from cal_registor_absent where gen_user_id ='".$_SESSION["EWT_MID"]."' and ('".$date_c."' between cal_registor_absent_start and cal_registor_absent_end) and event_id ='".$_GET[event_id]."' and cal_registor_absent_status ='1'");
if($db->db_num_rows($event)>0){
?>
	<script language="JavaScript">
		alert("ท่านไม่สามารถเข้าร่วมกิจกรรมได้ เนื่องจากถูกระงับสิทธิ์การเข้าร่วมกิจกรรมค่ะ!!");
		</script>
	<?php
	exit;
}
$sql = $db->query("select * from cal_registor_personal where event_id='".$_GET[event_id]."' and gen_user_id = '".$_SESSION["EWT_MID"]."'");
	if($db->db_num_rows($sql)>0){
	?>
	<script language="JavaScript">
		alert("กิจกรรมนี้ท่านได้ส่งคำขอแล้ว กรุณาตรวจสอบที่ Email ของท่านเพื่อยืนยันการสมัคร!!");
		</script>
	<?php
	exit;
	}else{//insert
	$sql_regis = "insert into  cal_registor_personal (event_id,gen_user_id,cal_status,date_registor) values ('".$_GET[event_id]."','".$_SESSION["EWT_MID"]."','1','".date('Y-m-d H:i:s')."')";
	$db->query($sql_regis);
	//config web site
	$sql_config = $db->query("select * from site_info");
	$R = $db->db_fetch_array($sql_config);
	$namesite = $R[site_info_title];
	//name smina
	$sql_event = $db->query("select event_title from cal_event where event_id='".$_GET[event_id]."'");
	$R_event = $db->db_fetch_array($sql_event);
	$event_name = $R_event[event_title];
	//name registor
	$db->query("USE ".$EWT_DB_USER);
	$sql_u = $db->query("select name_thai,email_person from gen_user where gen_user_id = '".$_SESSION["EWT_MID"]."'");
	$R_u= $db->db_fetch_array($sql_u);
	$name = $R_u[name_thai];
	$mail = $R_u[email_person];
	$sql_url = $db->query("select url from user_info where EWT_User = '".$EWT_FOLDER_USER."'");
	$R_url= $db->db_fetch_array($sql_url);
	$url = $R_url[url];
	$db->query("USE ".$EWT_DB_NAME);
	//send mail
	$message = "<table width=\"500\" border=\"0\" cellpadding=\"1\" cellspacing=\"2\" bgcolor=\"#CCCCCC\">
				  <tr>
					<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#CCCCCC\">
					  <tr>
						<td bgcolor=\"#FFFFFF\">เรียนคุณ".$name."</td>
					  </tr>
					  <tr>
						<td bgcolor=\"#FFFFFF\">ท่านได้สมัครเข้าร่วมสัมนาเรื่อง".$event_name."กับ".$namesite."</td>
					  </tr>
					  <tr>
						<td bgcolor=\"#FFFFFF\">กรุณาคลิกข้อความข้างล่างนี้เพื่อยืนยันการสมัครเข้าร่วมสัมนา</td>
					  </tr>
					  <tr>
						<td bgcolor=\"#FFFFFF\"><a href=\"".$url."registor_view_personal.php?flag=confirm&id=".base64_encode($_GET[event_id]."##".$_SESSION["EWT_MID"])."\" target=\"_blank\"><strong>ยืนยันการสัมคร</strong></a></td>
					  </tr>
					  <tr>
						<td bgcolor=\"#FFFFFF\">".$namesite."<br />
						  ขอขอบคุณที่ท่านให้ความสนใจ</td>
					  </tr>
					</table></td>
				  </tr>
				</table>";
	/* subject */
		$subject = 'ยืนยันการสมัครเข้าร่วมสัมมนา['.$namesite.']';
		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";

		/* additional headers */
		$headers .= "From: ยืนยันการสมัครเข้าร่วมสัมมนา[".$namesite."] \r\n";
		$mail_to = $mail;
		@mail($mail_to, $subject, $message, $headers);
		?>
		<script language="JavaScript">
		alert("ระบบจะส่งคำขอไปที่ Email ของท่านเพื่อให้ท่านยืนยันการสมัครเข้าร่วมสัมมนา!!");
		</script>
		<?php
		
	}
}
if($_GET[flag]=='confirm' & $_GET[id]!=''){
$id = base64_decode($_GET[id]);
$eid = explode('##',$id);
$event_id = $eid[0];
$uid = $eid[1];
$date = date('Y-m-d H:i:s');
$db->query("update cal_registor_personal set cal_status='2',date_confirm='".$date."' where event_id='".$event_id."' and gen_user_id='".$uid."'");
		?>
		<script language="JavaScript">
		alert("ท่านได้ยืนยันการสมัครเรียบร้อยแล้ว กรุณารอการพิจารณาจากเจ้าหน้าที่อีกครั้ง!!");
		window.close();
		</script>
		<?php
}
if($_GET[flag]=='cancle' & $_GET[id]!=''){
$id = base64_decode($_GET[id]);
$eid = explode('##',$id);
$event_id = $eid[0];
$uid = $eid[1];
$date = date('Y-m-d H:i:s');
$db->query("update cal_registor_personal set cal_status='3' where event_id='".$event_id."' and gen_user_id='".$uid."'");
?>
		<script language="JavaScript">
		alert("ท่านได้ยืนยันยกเลิกการสัมมนาเรียบร้อยแล้ว ขอขอบคุณที่ท่านให้ความสนใจ!!");
		window.close();
		</script>
		<?php
}
$db->db_close(); 
?>
