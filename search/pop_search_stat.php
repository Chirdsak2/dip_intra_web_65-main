<?php
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
if($limit == ''){
$limit  = 10;
$list_limit = "limit 0,".$limit;
$lablereting = '('.$limit."อันดับ)";
}else if($limit == 'total'){
$limit  = '';
$list_limit = '';
$lablereting = '';
}else{
$list_limit = "limit 0,".$limit;
$lablereting =  '('.$limit."อันดับ)";
}
if($_POST[start_date] != '' && $_POST[end_date]!=''){
$st = stripslashes(htmlspecialchars(trim($_POST[start_date]),ENT_QUOTES));
$st = explode("/",$st );
$st = ($st[2] - 543 )."-".$st[1]."-".$st[0];
$ed = stripslashes(htmlspecialchars(trim($_POST[end_date]),ENT_QUOTES));
$ed = explode("/",$ed);
$ed = ($ed[2] - 543 )."-".$ed[1]."-".$ed[0];
$wh1 .= "  (search_date  between '".$st."' AND '".$ed."'  ) AND";
}
if($_POST[start_date] == '' && $_POST[end_date]!=''){
$ed = stripslashes(htmlspecialchars(trim($_POST[end_date]),ENT_QUOTES));
$ed = explode("/",$ed);
$ed = ($ed[2] - 543 )."-".$ed[1]."-".$ed[0];
$wh1 .= "  (search_date  between '".$ed."' AND '".$ed."'  ) AND";
}
if($_POST[start_date] != '' && $_POST[end_date]==''){
$st = stripslashes(htmlspecialchars(trim($_POST[start_date]),ENT_QUOTES));
$st = explode("/",$st );
$st = ($st[2] - 543 )."-".$st[1]."-".$st[0];
$wh1 .= "  (search_date  between '".$st."' AND '".$st."'  ) AND";
}
$wh = substr($wh1,0,-3);
if($wh != ''){
$wh = "where " .$wh;
}
$db->write_log("view","search_stat","เข้าหน้า search stat");
$month =date('Y-m').'-%';
$query=$db->query("select count(search_word) as sum_search ,search_word from search_stat  $wh  group by search_word  order by  sum_search desc $list_limit") ;
//echo "select count(search_word) as sum_search ,search_word from search_stat  $wh  group by search_word  order by  sum_search desc $list_limit";
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
<script type="text/ecmascript">
function popSearchStat(){
	window.open('pop_search_stat.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&limit=<?php echo  $_REQUEST['limit'];?>', 'popSearchStat', 'scrollbars=1,resizable=1');
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">คำค้นที่มีการค้นหามากที่สุด<?php echo $lablereting;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>
    </td>
  </tr>
</table>
<table  width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <form name="form1" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="63%" height="18" align="center">คำค้น</td>
      <!--<td width="17%" align="center">ค้นหาล่าสุดเมื่อวันที่/เวลา</td>-->
      <td width="20%" align="center">ดูรายละเอียด</td>
    </tr>
	<?php
	while ($rec=$db->db_fetch_array($query)){
	//date letor
	//$sql_day = "select search_date from search_stat where search_word = '".$rec['search_word']."' order by search_date DESC";
	//$query_day = $db->query($sql_day);
	//$rec_day = $db->db_fetch_array($query_day);
	//$day = $rec_day[search_date];
	 //$day = explode('-',$day);
	// $day = $day[2].'/'.$day[1].'/'.($day[0]+543);
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <?php echo "<li>".$rec['search_word']."      (".$rec['sum_search'].")</li>"; ?></td>
      <!--<td height="25" align="center"><?php//php echo $day;?></td>-->
      <td align="center" ><a href="##" onClick="window.open('search_stat_viewdetail.php?search_word=<?php echo $rec[search_word]; ?>', 'search_stat_viewdetail', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');"><img src="../images/bar_view.gif" width="20" height="20" border="0"></a></td>
    </tr>
<?php
	}
	if($_GET['FlagE'] != 'excel'){
?>
    <tr bgcolor="#FFFFFF"> 
      <td height="40" colspan="2" align="center">
      <a href="javascript:void(0);" onClick="window.print();"><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> พิมพ์หน้านี้</span></a> | <a href="pop_search_stat.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&limit=<?php echo  $_REQUEST["limit"];?>&flag=search&FlagE=excel" ><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> ส่งออกข้อมูล</span></a>
</center><br></td>
    </tr>
<?php
	}
?>
  </form>
</table>
</body>
</html>
