<?php
session_start();
session_start();
if($_GET["FlagE"] == "excel"){
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=form_excel.xls");
	header( 'Content-Description: Download Data' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );
}
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


$db->write_log("view","search_stat","เข้าหน้า search stat");
$month =date('Y-m').'-%';
$query=$db->query("select search_date ,search_time,search_ip,search_module from search_stat  where search_word = '".$_GET[search_word]."'    order by  search_date desc ") ;
//echo "select search_date ,search_time,search_ip,search_module  from search_stat  where search_word = '".$_GET[search_word]."' group by search_word  order by  search_date desc ";
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">รายละเอียดการค้นหาคำค้น = <?php echo $_GET[search_word];?></span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form2" method="post" action="search_stat.php"  >
      <td><br>
</td>
    </form>
  </tr>
</table>
<table  width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <form name="form1" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="25%" height="18" align="center">IP</td>
      <!--<td width="17%" align="center">ค้นหาล่าสุดเมื่อวันที่/เวลา</td>-->
      <td width="25%" align="center">วันที่</td>
      <td width="25%" align="center">เวลา</td>
      <?php if($_GET[flaglist]!='faq'){?><td width="25%" align="center">กลุ่ม</td><?php } ?>
    </tr>
	<?php
	while ($rec=$db->db_fetch_array($query)){
	$day = $rec[search_date];
	 $day = explode('-',$day);
	 $day = $day[2].'/'.$day[1].'/'.($day[0]+543);
	 
	 if($rec[search_module] == '1'){
	 $name_module = 'เนื้อหา';
	 }else if($rec[search_module] == '2'){
	 $name_module = 'ข่าว/บทความ';
	 }else if($rec[search_module] == '3'){
	 $name_module = 'รูปภาพ';
	 }else if($rec[search_module] == '4'){
	 $name_module = 'Webboard';
	 }else if($rec[search_module] == '5'){
	 $name_module = 'FAQ';
	 }else{
	 $name_module = '-';
	 }
	 if($rec[search_time] != '00:00:00'){
	 $time_se  = $rec[search_time];
	 }else{
	 $time_se  = '';
	 }
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" align="center"><?php echo $rec[search_ip];?></td>
      <!--<td height="25" align="center"><?php//php echo $day;?></td>-->
      <td align="center" ><?php echo $day;?></td>
      <td align="center" ><?php echo $time_se;?></td>
     <?php if($_GET[flaglist]!='faq'){?> <td align="center" ><?php echo $name_module;?></td><?php } ?>
    </tr>
<?php
	}
	if($_GET['FlagE'] != 'excel'){
?>
    <tr bgcolor="#FFFFFF"> 
      <td height="40" colspan="4" align="center">
      <a href="javascript:void(0);" onClick="window.print();"><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> พิมพ์หน้านี้</span></a> | <a href="search_stat_viewdetail.php?search_word=<?php echo $_REQUEST["search_word"];?>&flag=search&FlagE=excel" ><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> ส่งออกข้อมูล</span></a>
</center><br></td>
    </tr>
<?php
	}
?>
  </form>
</table>
</body>
</html>
