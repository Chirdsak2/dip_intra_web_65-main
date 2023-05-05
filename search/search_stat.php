<?php
session_start();
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
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form2" method="post" action="search_stat.php"  >
      <td> <table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
         <tr>
           <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ค้นหา</td>
          </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">วันที่ทำการค้นหา : </td>
           <td width="73%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" id="start_date" value="<?php echo $_POST[start_date];?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>  
             ถึง 
             <input name="end_date" type="text" size="15" id="end_date" value="<?php echo $_POST[end_date];?>">
             <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a> </td>
         </tr>
         <tr>
           <td align="right" bgcolor="#FFFFFF">แสดง : </td>
           <td bgcolor="#FFFFFF"><select name="limit"  >
          <option value="10" <?php if($_POST[limit]=='10'){ echo 'selected';}?>>10</option>
          <option value="20" <?php if($_POST[limit]=='20'){ echo 'selected';}?>>20</option>
          <option value="30" <?php if($_POST[limit]=='30'){ echo 'selected';}?>>30</option>
		  <option value="40" <?php if($_POST[limit]=='40'){ echo 'selected';}?>>40</option>
		  <option value="50" <?php if($_POST[limit]=='50'){ echo 'selected';}?>>50</option>
          <option value="total" <?php if($_POST[limit]=='total'){ echo 'selected';}?>>ทั้งหมด</option>
        </select>
       อันดับ </td>
         </tr>
         <tr>
           <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="ค้นหา"></td>
          </tr>
       </table>
</td>
    </form>
  </tr>
</table>
<br/>
<table  width="80%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
	<tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td  align="center" bgcolor="#FFFFFF"><?php
	  				$graph_height  = "500";
  				$graph_width  = "850";
				$graph_group = "Y";
				$graph_rotate = "";
				//include("../ewt_graph_include.php");
	  ?></td>
    </tr>
</table>
<center><br>
<a href="javascript:void(0);" onClick="popSearchStat();"><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> พิมพ์หน้านี้</span></a> | <a href="pop_search_stat.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&limit=<?php echo  $_REQUEST["limit"];?>&flag=search&FlagE=excel" ><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> ส่งออกข้อมูล</span></a>
</center><br>
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
	<?php } ?>
  </form>
</table>
<center><br>
<a href="javascript:void(0);" onClick="popSearchStat();"><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> พิมพ์หน้านี้</span></a> | <a href="pop_search_stat.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&limit=<?php echo  $_REQUEST["limit"];?>&flag=search&FlagE=excel" ><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> ส่งออกข้อมูล</span></a>
</center><br>
</body>
</html>
