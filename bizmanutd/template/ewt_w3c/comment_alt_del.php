<?
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
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
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style6 {font-size: 16px}
-->
</style>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
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
      <?=$id_ans?> 
      ของข่าวนี้แสดงความคิดเห็นไม่ตรงตามกฎ กติกา   มารยาทที่ทางทีมงานกำหนดไว้
      <br />
      <br />
    กรุณายืนยันอีกครั้ง</span><br /></td>
  </tr>
  <tr>
    <td align="center">
	<form id="form1" name="form1" method="post" action="comment_alt_del.php?status=y">
		<?
		if ($status=='y'){
		//find admin module 
		$mail_user = array();
		$sql_module ="select * from email_config where module ='article'";
		$query_module = $db->query($sql_module); 
		while($rec_module = $db->db_fetch_array($query_module)){
		array_push($mail_user,$rec_module[email]);
		}
				$To=implode(";", $mail_user);
				$Subject="แจ้งลบความคิดเห็น";
				$Massage="แจ้งลบความคิดเห็นที่ ".$id_ans." หัวข้อข่าวที่ ".$news_id;
				$From="dmr@dmr.go.th ";
				
			    $From .= "Content-Type: text/html; charset='UTF-8' "; 
				@mail($To,$Subject,$Massage,$From);				
				print "<script>alert('ระบบได้ทำการส่งอีเมล์เพื่อแจ้งให้ผู้ดูแลระบบทราบแล้ว');window.close();</script>";			
		}		
		?>
      <label>
      <input type="submit" name="Button" value="ยืนยัน" />
      </label>
      <label>
      <input type="button" name="Submit2" value="ยกเลิก" onclick="window.close();" />
      </label>
    </form></td>
  </tr>
</table>
</body>
</html>
