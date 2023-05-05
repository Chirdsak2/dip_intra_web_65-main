<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("lib/libmail.php");

$id_comment=$_REQUEST['id_comment'];
$news_id=$_REQUEST['news_id'];
$status=$_REQUEST['status'];
	$qComment=$db->query('SELECT nc.comment, al.n_topic, nc.id_ans, al.n_owner FROM news_comment nc JOIN article_list al ON al.n_id=nc.news_id WHERE nc.news_id=\''.$news_id.'\' AND nc.id_comment=\''.$id_comment.'\'');
	$rComment=$db->db_fetch_array($qComment);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>แจ้งลบความคิดเห็น</title>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
	font-size: 14px;
	font-family: Tahoma;
}
.style2 {font-family: Tahoma}
-->
</style>
<link href="css/style_calendar.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style6 {font-size: 16px}
-->
</style>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="6">
  <tr align="left">
    <td><span class="style1">ท่านพบการแสดงความคิดเห็นที่ไม่เหมาะสมและต้องการแจ้งต่อผู้ดูแลระบบ</span><br />
      <br />
      <span class="mytext_normal">ทีมงานขอขอบคุณที่ท่านช่วยตรวจสอบความคิดเห็นต่างๆ   ร่วมกับทางทีมงาน
      <br />
      <br />
      ท่านเห็นว่าความคิดเห็นที่ 
      <?php echo $rComment['id_ans']; ?>
      ของข่าวนี้แสดงความคิดเห็นไม่ตรงตามกฎ กติกา   มารยาทที่ทางทีมงานกำหนดไว้
      <br />
      <br />
    กรุณายืนยันอีกครั้ง</span><br /></td>
  </tr>
  <tr>
    <td align="center">
	<form id="form1" name="form1" method="post" action="comment_alt_del.php?status=y">
		<?php
		if ($status=='y'){
		//find admin module 
		$mail_user = array();
		$sql_module ="SELECT * FROM email_config WHERE module='article'";
		$query_module = $db->query($sql_module); 
		$num_module = $db->db_num_rows($query_module);
		if($num_module>0) {
			while($rec_module = $db->db_fetch_array($query_module)){
				array_push($mail_user,$rec_module[email]);
			}
		} else if($rComment['n_owner']>0) {
			$db->query('USE '.$EWT_DB_USER);
			$query_module = $db->query('SELECT email_person FROM gen_user WHERE gen_user_id=\''.$rComment['n_owner'].'\'');
			while($rec_module = $db->db_fetch_array($query_module)){
				array_push($mail_user,$rec_module['email_person']);
			}
			$db->query('USE '.$EWT_DB_NAME);
		}
		$qOwnerMail = $db->query('SELECT site_email FROM site_info');
		$rOwnerMail = $db->db_fetch_array($qOwnerMail);
		if($rOwnerMail != '') {
			array_push($mail_user,$rOwnerMail['site_email']);
			//$To.=$rOwnerMail['site_email'].';';
		}
				$Subject="แจ้งลบความคิดเห็น";
				$message='แจ้งลบความคิดเห็นที่ '.$rComment['id_ans'].' :<br/>'.$rComment['comment'].' <br/><br/>หัวข้อข่าวที่ '.$news_id.' :<br/>'.$rComment['n_topic'];
				$From="support@prd.go.th ";
				
			  //$From .= "Content-Type: text/html; charset='UTF-8' "; 
				
				$m= new Mail;
				if($From!='') {
					$m->From($From);
				}
				foreach($mail_user as $key => $val) {
					$m->To($val);
				}
				$m->Subject($Subject);
				$m->Body( iconv('UTF-8','UTF-8',$message) );
				$m->Priority(4);
				if($To!='' && $From!='') {
					$m->Send();
				}
				//@mail($To,$Subject,$message,$From);				
				print "<script>alert('ระบบได้ทำการส่งอีเมล์เพื่อแจ้งให้ผู้ดูแลระบบทราบแล้ว');window.close();</script>";
				exit;
		}		
		?>
      <label>
      <input type="submit" name="Button" value="ยืนยัน" />
      </label>
      <label>
      <input type="button" name="Submit2" value="ยกเลิก" onclick="window.close();" />
      </label>
      <input type="hidden" name="news_id" value="<?php echo $news_id; ?>" />
      <input type="hidden" name="id_comment" value="<?php echo $id_comment; ?>" />
    </form></td>
  </tr>
</table>
</body>
</html>
