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
if(empty($start_date) && $Flag ==''){
$start_date = date("d/m/").(date("Y")+543);
}
if(empty($end_date) && $Flag ==''){
$end_date = date("d/m/").(date("Y")+543);
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

/* .style1 {color: #FF0000} */

</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">สถิติการเข้าเว็บบอร์ดจำนวนผู้อ่าน </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("สถิติการเข้าเว็บบอร์ดจำนวนผู้อ่าน");?>&module=webboard&url=<?php echo urlencode("report_webboard_stat_counter.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="report_webboard_stat_excel_counter.php?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&FlagE=excel&Flag=View" target="_blank">Export to Excel</a><hr>
    </td>
  </tr>
</table>
<?php

$db->write_log("view","webboard","ดูรายงานสถิติการเข้า webboard");
$sql = mysql_query("select* from  w_question where 1=1  ".$con." ");
$sql_ct = mysql_query("select * from  w_question where 1=1  ".$con." LIMIT 0,1");
$A = mysql_fetch_row($sql_ct);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td align="right">&nbsp;</td>
  </tr>
  <tr> 
    <td width="47%" align="center"><table width="94%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000" class="ewttableuse">
      <tr>
        <td colspan="2" class="ewttablehead">รายการ</td>
        <td width="13%" align="center" class="ewttablehead">จำนวนผู้อ่าน</td>
      </tr>
	  <?php 
	  $query = $db->query("select * from w_cate where c_use = 'Y'");
	  while($rec = $db->db_fetch_array($query)){
	  ?>
      <tr>
        <td colspan="4" bgcolor="#F2F2F2" class="MemberHead"><img src="../images/arrow_r.gif" width="7" height="7"><?php echo $rec[c_name]; ?></td>
        </tr>
	  <?php 
	  $sql_q = mysql_query("select* from  w_question where 1=1 and c_id = '".$rec[c_id]."'  ");
	  $num_q = $db->db_num_rows($sql_q);
	  while($rec_q = $db->db_fetch_array($sql_q)){
	  ?>
      <tr>
        <td width="2%" bgcolor="#F2F2F2">&nbsp;</td>
        <td width="72%" bgcolor="#FFFFFF"><img src="../images/bar_min.gif" width="15" height="13"><?php echo $rec_q[t_name];?></td>
        <td align="center" bgcolor="#FFFFFF"><?php echo $rec_q[t_count]; ?></td>
        
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
		}  }  
	 ?>
  
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
