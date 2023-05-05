<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
?>
<html>
<head>
<title>Stat</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar-th.js"></script>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
 <form name="form1" method="post" action=""> <tr>
      <td><img src="../images/column-chart.gif" width="24" height="24" border="0" align="left"> 
        <strong><font size="4" face="Tahoma">สถิติการเข้าGallery <font size="2">จากวันที่ 
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
      <td width="25%" align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("สถิติการเข้า Gallery");?>&module=gallery&url=<?php echo urlencode("gallery_stat.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;</td>
 </tr> </form>
  <tr height="4">
    <td height="4" colspan="2" bgcolor="#000066"></td>
  </tr>
</table>
<?php
if($Flag == "View"){
$db->write_log("view","gallery","ดูรายงานสถิติการเข้าGallery");
if($start_date == "" AND $end_date == ""){
$con = "";
}elseif($start_date != "" AND $end_date == ""){
$st = explode("/",$start_date);
$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
}elseif($start_date == "" AND $end_date != ""){
$st = explode("/",$end_date);
$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
}else{
$st = explode("/",$start_date);
$en = explode("/",$end_date);
$con = " AND (date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
}
//$sql = mysql_query("SELECT sv_menu , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_menu != '' ".$con." GROUP BY sv_menu ORDER BY ct DESC");
//$sql_ct = mysql_query("SELECT count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND sv_menu != '' ".$con." GROUP BY sv_menu ORDER BY ct DESC LIMIT 0,1");
$sql = mysql_query("select img_path_s,count(gallery_log.img_id) as ct,img_name from gallery_log,gallery_image where gallery_image.img_id = gallery_log.img_id  ".$con."group by gallery_log.img_id");
$sql_ct = mysql_query("select count(gallery_log.img_id) as ct from gallery_log,gallery_image where gallery_image.img_id = gallery_log.img_id  ".$con."group by gallery_log.img_id LIMIT 0,1");
$A = mysql_fetch_row($sql_ct);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="1" >
  <tr> 
    <td align="right">&nbsp;</td>
  </tr>
  <tr> 
    <td width="47%" align="center"><table width="95%" border="0" cellpadding="0" cellspacing="1" class="ewttableuse">
        <tr> 
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" class="ewttableuse">
              <tr align="center"  class="ewttablehead"> 
                <td width="20%"><strong><font size="2" face="Tahoma">รูปภาพ</font></strong></td>
                <td width="6%"><strong><font size="2" face="Tahoma">จำนวนครั้งที่ถูกเรียกดู</font></strong></td>
                <td width="74%"><font size="2" face="Tahoma"><strong>กราฟ</strong></font></td>
              </tr>
              <?php
while($R = mysql_fetch_row($sql)){
?>
              <tr  > 
                <td align="left" bgcolor="#FFFFFF" >
				<table  border="0" cellpadding="1" cellspacing="1" bgcolor="#999999" width="70" height="70" class="ewttableuse">
				  <tr>
					<td bgcolor="#FFFFFF" align="center"><img src="phpThumb.php?src=<?php echo $Globals_Dir.$R[0]?>&h=70&w=70" hspace="0" vspace="0" align="middle" >
</td>
				  </tr>
				</table><?php echo $R[2]; ?></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo number_format($R[1],0); ?></td>
                <td align="left" bgcolor="#FFFFFF"> <?php 
		  if($A[0] > 0){
		  $width = number_format((($R[1]*5)/$A[0]),0);
		  }else{
		  $width = 0;
		  }
		   ?>
                  <table width="<?php echo $width; ?>%" height="12" border="0" cellpadding="0" cellspacing="1" bgcolor="#333333">
                    <tr width="<?php echo $width; ?>%" height="12" > 
                      <td width="<?php echo $width; ?>%" height="12" bgcolor="orange"></td>
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
