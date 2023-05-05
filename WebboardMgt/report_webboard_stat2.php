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
            else*/if (floor($diff/86400))
                        {
                        $x = floor($diff / 86400);
						if($x  > 0){
                        echo " $x วัน";
                        $diff = $diff - ($x * 86400);
                        return DiffToText_new($diff);
						}
                        }
            elseif (floor($diff/3600))
                        {
                        $x = floor($diff / 3600);
                        echo " $x ชั่วโมง";
                        $diff = $diff - ($x * 3600);
                        return DiffToText_new($diff);
                        }

            elseif (floor($diff/60))
                        {
                        $x = floor($diff / 60);
                        echo " $x นาที ";
                        $diff = $diff - ($x * 60);
                        return DiffToText_new($diff);
                        }
            else if ($diff)
                        echo " $diff วินาที ";
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
.style1 {color: #FF0000}
.style2 {color: #FFFFFF}
-->
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="3">
 <form name="form1" method="post" action=""> <tr>
      <td><strong><font size="4" face="Tahoma">สถิติการเข้า webboard<font size="2">จากวันที่ 
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


?>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td align="right">&nbsp;</td>
  </tr>
  <tr> 
    <td width="47%" align="center"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
      <tr>
        <td class="title style2">&nbsp;</td>
        <td class="title style2">&nbsp;</td>
        <td align="center" class="title style2">จำนวนผู้อ่าน</td>
        <td align="center" class="title style2">จำนวนผู้ตอบ</td>
      </tr>
	  <?php 
	  $query = $db->query("select * from forums ");
	  while($rec = $db->db_fetch_array($query)){
	  ?>
      <tr>
        <td colspan="2" bgcolor="#F2F2F2" class="MemberHead"><img src="../images/arrow_r.gif" width="7" height="7"><?php echo $rec[forum_name]; ?></td>
        <td width="13%" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="13%" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
	  <?php 
	  $sql_q = mysql_query("select* from  topics where 1=1 and forum_id = '".$rec[forum_id]."'   ");
	  $num_q = $db->db_num_rows($sql_q);
	  while($rec_q = $db->db_fetch_array($sql_q)){
	 // echo "select count(*) as num from posts where 1=1 and topic_id = '".$rec_q[topic_id]."' and post_id != '".$rec_q[topic_first_post_id]."' ".$con_a." ";
	  $sql_a = $db->query("select count(*) as num from posts where 1=1 and topic_id = '".$rec_q[topic_id]."' and post_id != '".$rec_q[topic_first_post_id]."' ".$con_a." ");
	  $rec_a = $db->db_fetch_array($sql_a);
	  
	  ?>
      <tr>
        <td width="2%" bgcolor="#F2F2F2">&nbsp;</td>
        <td width="72%" bgcolor="#FFFFFF"><img src="../images/bar_min.gif" width="15" height="13"><?php echo $rec_q[topic_title];?></td>
        <td align="center" bgcolor="#FFFFFF"><?php echo $rec_q[topic_views]; ?></td>
        <td align="center" bgcolor="#FFFFFF"><?php echo $rec_a[num];?></td>
      </tr>
	  <?php 
	  	}
		if($num_q == 0){
		?>
		<tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td colspan="3" bgcolor="#FFFFFF"><span class="style1">---ไม่พบหัวข้อกระทู้----</span></td>
      </tr>
		<?php
		}
	  } ?>
      
    </table></td>
  </tr>
</table>
<?php } ?>
</body>
</html>
<?php
$db->db_close(); ?>
