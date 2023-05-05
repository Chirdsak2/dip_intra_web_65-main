<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$fid=$_POST[fid];
$sql="SELECT * FROM ecard_list WHERE ec_id = '$fid'  ";
$query=$db->query($sql);
$R = $db->db_fetch_array($query);
$file_att=$R[ec_filename];
$filetype=$R[ec_filetype];
$fileID=$R[ec_id];

include('libmail.php');
$m = new Mail();

$Path_Ecard = "../ewt/$_SESSION[EWT_SUSER]/ecard/".$file_att;

$sendname=$_POST[sendname];
$sendemail=$_POST[sendemail];
$subject=$_POST[subject];
$body=$_POST[body];
$recemail=trim($_POST[recemail]);

$IPn = getenv("REMOTE_ADDR");

$arr_mail=explode(',',$recemail);
for($i=0;$i<sizeof($arr_mail);$i++){
		$targetMail=trim($arr_mail[$i]);
		if($targetMail<>''){
		
		$sql="INSERT INTO ecard_history(ech_ecardid,ech_from,ech_to,ech_subject,ech_message,ech_ip,ech_datetime) 
		VALUES('$fid','$sendemail','$targetMail','$subject','$body','$IPn','".date('YmdHis')."')   ";
		$query=$db->query($sql);
		
		$sql2="SELECT MAX(ech_id) AS  lastID FROM ecard_history ";
		$query2=$db->query($sql2);
		$R2 = $db->db_fetch_array($query2);
        $hid=$R2[lastID];

		//$body2=$body.'<iframe src="http://www.moe.go.th/moe2009/ewt/moe_web/ecardview.php?hid='.$hid.'&fmail='.$targetMail.'" width="100" height="100"></iframe>';
		$body2=$body.'<img src="http://www.moe.go.th/moe2009/ewt/moe_web/ecardview.php?hid='.$hid.'&fmail='.$targetMail.'" width="0" height="0">';
		//$body2.="<br>http://www.moe.go.th/moe2009/ewt/moe_web/ecardview.php?hid='.$hid.'&fmail='.$targetMail.'";
        
        $m = new Mail();
		$m->From($sendname."<".trim($sendemail).">");
		$m->Subject($subject);
		$m->Body($body2,"text/html");
		$m->Attach($Path_Ecard,$filetype);
		$m->To($targetMail);
		$m->Send();
		$db->write_log("send","ecard","$sendemail ส่ง $file_att ถึง  $targetMail");
		}
}

$db->db_close(); 
?>
<script language="javascript">alert('E-card sending complete.')</script>