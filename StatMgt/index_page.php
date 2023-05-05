<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title>Stat</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript"  type="text/javascript" src="lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="lib_carendar/calendar-th.js"></script>
<link href="lib_carendar/style_calendar.css" rel="stylesheet" type="text/css">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="3">
 <form name="form1" method="post" action=""> <tr>
    <td><img src="../images/column-chart.gif" width="24" height="24" border="0" align="left"> 
      <strong><font size="4" face="Tahoma">สถิติการเข้าเว็บรายหน้า <font size="2">จากวันที่ 
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
$title = "";
}elseif($start_date != "" AND $end_date == ""){
$st = explode("/",$start_date);
$con = " AND (sv_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$title = "วันที่ ".$start_date;
}elseif($start_date == "" AND $end_date != ""){
$st = explode("/",$end_date);
$con = " AND (sv_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$title = "วันที่". $end_date;
}else{
$st = explode("/",$start_date);
$en = explode("/",$end_date);
$con = " AND (sv_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
$title = "วันที่ ".$start_date ."ถึงวันที่". $end_date;
}
$db->write_log("view","View stat","ดูรายงานสถิติการเข้าเว็ปรายหน้า".$title  );
$sql = mysql_query("SELECT sv_menu , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_menu != '' ".$con." GROUP BY sv_menu ORDER BY ct DESC");
$sql_ct = mysql_query("SELECT count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND sv_menu != '' ".$con." GROUP BY sv_menu ORDER BY ct DESC LIMIT 0,1");
$A = mysql_fetch_row($sql_ct);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td align="right">&nbsp;</td>
  </tr>
  <tr> 
    <td width="47%" align="center"><table width="95%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="ewttableuse">
        <tr> 
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" class="ewttableuse">
              <tr align="center" bgcolor="#999999" class="ewttablehead"> 
                <td width="20%"><strong><font size="2" face="Tahoma">ชื่อเว็บเพจ</font></strong></td>
                <td width="10%"><strong><font size="2" face="Tahoma">จำนวน</font></strong></td>
                <td width="70%"><font size="2" face="Tahoma"><strong>กราฟ</strong></font></td>
              </tr>
              <?php
while($R = mysql_fetch_row($sql)){
?>
              <tr  > 
                <td align="left" bgcolor="#FFFFFF" ><a href="index.php?page=<?php echo $R[0]?>"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $R[0]; ?></font></a></td>
                <td align="right" bgcolor="#FFFFFF"><font size="1" face="MS Sans Serif, Tahoma, sans-serif">(<?php echo number_format($R[1],0); ?>)</font></td>
                <td bgcolor="#FFFFFF"> <?php 
		  if($A[0] > 0){
		  $width = number_format((($R[1]*100)/$A[0]),0);
		  }else{
		  $width = 0;
		  }
		   ?>
                  <table width="<?php echo $width; ?>%" height="12" border="0" cellpadding="0" cellspacing="1" bgcolor="#333333">
                    <tr width="<?php echo $width; ?>%" height="12" > 
                      <td width="<?php echo $width; ?>%" height="12" background="../images/wb_bg.gif"></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php } ?>
</body>
</html>
<?php
$db->db_close(); ?>
