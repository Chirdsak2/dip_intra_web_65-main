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
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">รายงานสถิติ</span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
 <form name="form1" method="post" action=""> <tr>
    <td><hr>
จากวันที่ 
        <input type="text" name="start_date" size="15" value="<?php print  $start_date; ?>">        <img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('start_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      ถึง 
        <input type="text" name="end_date" size="15" value="<?php print  $end_date;  ?>">
        <img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('end_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      
        <input type="submit" name="Submit" value="แสดงข้อมูล">
        <font size="4" face="Tahoma">        <input name="Flag" type="hidden" id="Flag" value="View">      </td>
  </tr> 
 </form>
</table>
<?php
if($Flag == "View"){

if($start_date == "" AND $end_date == ""){
$con = "";
$title = "";
}elseif($start_date != "" AND $end_date == ""){
$st = explode("/",$start_date);
$con = " AND (n_date = '".($st[2] )."-".$st[1]."-".$st[0]."') ";
$title = "วันที่ ".$start_date;
}elseif($start_date == "" AND $end_date != ""){
$st = explode("/",$end_date);
$con = " AND (n_date = '".($st[2] )."-".$st[1]."-".$st[0]."') ";
$title = "วันที่". $end_date;
}else{
$st = explode("/",$start_date);
$en = explode("/",$end_date);
$con = " AND (n_date BETWEEN '".($st[2] )."-".$st[1]."-".$st[0]."' AND '".($en[2] )."-".$en[1]."-".$en[0]."') ";
$title = "วันที่ ".$start_date ."ถึงวันที่". $end_date;
}
$db->write_log("view","View stat","ดูรายงานสถิติการเข้า Article");
$sql = mysql_query("SELECT  news_view.news_id, count(news_view.id_view) AS count_view, article_list.n_topic
													FROM article_list  INNER JOIN news_view ON (article_list.n_id = news_view.news_id)
													Where 1=1 $con
													GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc");
$sql_ct = mysql_query("SELECT count(news_view.id_view) AS count_view
													FROM article_list  INNER JOIN news_view ON (article_list.n_id = news_view.news_id)
													Where 1=1 $con
													GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc LIMIT 0,1");
$A = mysql_fetch_row($sql_ct);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td align="center"><table width="94%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
        <tr> 
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="ewttableuse" >
              <tr align="center" class="ewttablehead"> 
                <td width="55%">หัวข้อข่าว/บทความ</td>
                <td width="5%">จำนวน</td>
                <td width="40%">กราฟ</td>
              </tr>
              <?php
while($R = mysql_fetch_row($sql)){
?>
              <tr  > 
                <td align="left" bgcolor="#FFFFFF" ><?php echo $R[2]; ?></td>
                <td align="right" bgcolor="#FFFFFF">(<?php echo number_format($R[1],0); ?>)</td>
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
</table><br>

<?php } ?>
</body>
</html>
<?php
$db->db_close(); ?>
