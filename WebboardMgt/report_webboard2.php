<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
function DiffToText_new($diff)
            {
          /*  if (floor($diff/31536000))
                        {
                        $x = floor($diff / 31536000);
                        echo " $x ปี ";
                        $diff = $diff - ($x * 31536000);
                        return DiffToText_new($diff);
                        }
            elseif (floor($diff/2678400))
                        {
                        $x = floor($diff / 2678400);
                        echo " $x เดือน ";
                        $diff = $diff - ($x * 2678400);
                        return DiffToText_new($diff);
                        }
            else*/if ($diff>=86400)
                        {
                        $x = floor($diff / 86400);
						//if($x  > 0){
                        echo " $x วัน";
                        $diff = $diff - ($x * 86400);
                        return DiffToText_new($diff);
						//}
                        }
            elseif ($diff>=3600)
                        {
                        $x = floor($diff / 3600);
                        echo " $x ชั่วโมง";
                        $diff = $diff - ($x * 3600);
                        return DiffToText_new($diff);
                        }

            elseif ($diff>=60)
                        {
                        $x = floor($diff / 60);
                        echo " $x นาที ";
                        $diff = $diff - ($x * 60);
                        return DiffToText_new($diff);
                        }
            else if ($diff)
						if($diff > 0){
                        echo " $diff วินาที ";
						}
            }

?>
<html>
<head>
<title>Stat</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar-th.js"></script>
<link href="../StatMgt/lib_carendar/style_calendar.css" rel="stylesheet" type="text/css">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="3">
 <form name="form1" method="post" action=""> <tr>
      <td><strong><font size="4" face="Tahoma">รายงานการใช้งาน webboard<font size="2">จากวันที่ 
        <input type="text" name="start_date" size="15" value="<?php print  $start_date; ?>">
      <img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('start_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      ถึง</font> 
      <input type="text" name="end_date" size="15" value="<?php print  $end_date;  ?>">
      <img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('end_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      </font></strong>
      
        <input type="submit" name="Submit" value="แสดงข้อมูล">
        <strong><font size="4" face="Tahoma">
        <input name="Flag" type="hidden" id="Flag" value="View">
      </strong></td>
  </tr> </form>
  <tr height="4">
    <td height="4" bgcolor="#000066"></td>
  </tr>
</table>
<?php
if($Flag == "View"){
if($start_date == "" AND $end_date == ""){
$con = "";
$con_a = "";
$date_name = "";
}elseif($start_date != "" AND $end_date == ""){
$st = explode("/",$start_date);
$date_start = mktime(0, 0, 0, $st[1], $st[0], ($st[2] -543));   
$date_end = mktime(23, 59, 59, $st[1], $st[0], ($st[2] -543));   
$con = " AND (topic_time = '".$date_start."') ";
$con_a = " AND (post_time BETWEEN '".$date_start."' AND '".$date_end."') ";
$date_name = "วันที่".$start_date;
}elseif($start_date == "" AND $end_date != ""){
$st = explode("/",$end_date);
$date_start = mktime(0, 0, 0, $st[1], $st[0], ($st[2] -543));   
$date_end = mktime(23, 59, 59, $st[1], $st[0], ($st[2] -543));   
$con = " AND (topic_time = '".$date_start."') ";
$con_a = " AND (post_time BETWEEN '".$date_start."' AND '".$date_end."') ";
$date_name = "วันที่".$end_date;
}else{
$st = explode("/",$start_date);
$en = explode("/",$end_date);
$date_start = mktime(0, 0, 0, $st[1], $st[0], ($st[2] -543));
$date_end = mktime(23, 59, 59, $en[1], $en[0], ($en[2] -543));
$con = " AND (topic_time BETWEEN '".$date_start."' AND '".$date_end."') ";
$con_a = " AND (post_time BETWEEN '".$date_start."' AND '".$date_end."') ";
$date_name = "วันที่".$start_date."ถึง วันที่".$start_date;
}
$sql = mysql_query("select* from  topics where 1=1  ".$con." ");
$sql_ct = mysql_query("select * from  posts,posts_text where 1=1 and posts.post_id = posts_text.post_id   ".$con." LIMIT 0,1");
//$A = mysql_fetch_row($sql_ct);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td align="right"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td colspan="5" align="center" class="MemberHead">รายชื่อกลุ่มเป้าหมายในการให้บริการ</td>
        </tr>
      <tr>
        <td colspan="5" align="center" class="MemberHead"><?php echo $date_name;?> </td>
        </tr>
      <tr>
        <td colspan="5"><span class="cellcal">การให้บริการด้าน</span> การให้บริการข้อมูลอิเล็กทรอนิกส์ผ่านทางระบบอินเตอร์เน็ต </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td width="47%" align="center"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
      <tr>
        <td class="title"><span class="style1">ลำดับที่</span></td>
        <td class="title"><span class="style1">ข้อมูลที่ขอ</span></td>
        <td class="title"><span class="style1">ชื่อผู้ขอข้อมูล</span></td>
        <td class="title"><span class="style1">e-mail address </span></td>
        <td class="title"><span class="style1">เลขที่</span></td>
        <td class="title"><span class="style1">วัน/เดือน/ปีที่ติดต่อ</span></td>
        <td class="title"><span class="style1">เวลาติดต่อ</span></td>
        <td class="title"><span class="style1">วัน/เดือน/ปี ที่ตอบกลับ </span></td>
        <td class="title"><span class="style1">เวลาตอบกลับ</span></td>
        <td class="title"><span class="style1">หน่วยงาน</span></td>
        <td class="title"><span class="style1">ระยะเวลาการให้บริการ(นาที)</span></td>
        <td class="title"><span class="style1">หมายเหตุ</span></td>
      </tr>
	  <?php
	  $i=1;
	  while($R=$db->db_fetch_array($sql)){
	  	 //$date = explode("-",$R[t_date]);
	 	// $time = explode(":",$R[t_time]);
	 	 //$d2 = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
      $d2 =$R[topic_time];

		$sql_an = "select * from posts,posts_text where 1=1 and posts.post_id = posts_text.post_id and topic_id = '".$R[topic_id]."' and posts.post_id != '".$R[topic_first_post_id]."' order by posts.post_id ASC";
		$query_an = $db->query($sql_an);
		$rec = $db->db_fetch_array($query_an);
		//$date_an = explode("-",$rec[a_date]);
		//$time_an = explode(":",$rec[a_time]);
		//$d1 = mktime($time_an[0], $time_an[1], $time_an[2], $date_an[1], $date_an[2], $date_an[0]);
		$d1 = $rec[post_time];
		$diff = $d1-$d2;
			if($R[topic_poster] == '-1'){
			$sqluser_post = "select * from topics,posts where topic_first_post_id=post_id and topics.topic_id = '".$R[topic_id]."'";
			}else{
			$sqluser_post = "select * from topics,users where user_id=topic_poster and topics.topic_id = '".$R[topic_id]."'";
			}
		
			
			$query_post = $db->query($sqluser_post);
			$rec_post = $db->db_fetch_array($query_post);
			if($rec_post[topic_poster] == '-1'){
			$name = $rec_post[post_username];
			$email ='-';
			
			}else{
			$name = $rec_post[username];
			$email =$rec_post[user_email];
			
			}



	  ?>
      <tr>
        <td bgcolor="#FFFFFF"><?php echo $i; ?></td>
        <td bgcolor="#FFFFFF"><?php echo $R[topic_title]; ?></td>
        <td bgcolor="#FFFFFF"><?php echo $name; ?></td>
        <td bgcolor="#FFFFFF"><?php echo $email; ?></td>
        <td bgcolor="#FFFFFF"><?php echo $R[topic_id]; ?></td>
        <td bgcolor="#FFFFFF"><?php echo gmdate("d/m/Y", $R[topic_time]); ?></td>
        <td bgcolor="#FFFFFF"><?php echo gmdate("H:i:s A", $R[topic_time]); ?></td>
        <td bgcolor="#FFFFFF"><?php if(!empty($rec[post_time])){echo gmdate("d/m/Y", $rec[post_time]);} ?></td>
        <td bgcolor="#FFFFFF"><?php if(!empty($rec[post_time])){echo gmdate("H:i:s A", $rec[post_time]); }?></td>
        <td align="center" bgcolor="#FFFFFF">ประชาชน</td>
        <td bgcolor="#FFFFFF"><?php echo DiffToText_new($diff);?></td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
	  <?php $i++; } ?>
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php } ?>
</body>
</html>
<?php
$db->db_close(); ?>
