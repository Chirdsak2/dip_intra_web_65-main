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
$st = explode("/",$_POST[start_date]);
$st = ($st[2] )."-".$st[1]."-".$st[0];
$ed = explode("/",$_POST[end_date]);
$ed = ($ed[2] )."-".$ed[1]."-".$ed[0];
$wh1 .= "  (date_open  between '".$st."' AND '".$ed."'  ) AND";
}
if($_POST[start_date] == '' && $_POST[end_date]!=''){
$ed = explode("/",$_POST[end_date]);
$ed = ($ed[2] )."-".$ed[1]."-".$ed[0];
$wh1 .= "  (date_open  between '".$ed."' AND '".$ed."'  ) AND";
}
if($_POST[start_date] != '' && $_POST[end_date]==''){
$st = explode("/",$_POST[start_date]);
$st = ($st[2] )."-".$st[1]."-".$st[0];
$wh1 .= "  (date_open  between '".$st."' AND '".$st."'  ) AND";
}
$wh = substr($wh1,0,-3);
if($wh != ''){
$wh = "AND " .$wh;
}
$db->write_log("view","search_stat","เข้าหน้า search stat");
$month =date('Y-m').'-%';
$query=$db->query("select count(filename) as sum_open ,filename from search_open  where   filename <> '' $wh group by filename  order by  sum_open desc  $list_limit") ;
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">เพจที่มีการค้นหามากที่สุด<?php echo $lablereting;?></span> </td>
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
           <td width="27%" align="right" bgcolor="#FFFFFF">วันที่ค้นหาเพจ : </td>
           <td width="73%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" value="<?php echo $_POST[start_date];?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>  
             ถึง 
             <input name="end_date" type="text" size="15"  value="<?php echo $_POST[end_date];?>">
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
      <br>
</td>
    </form>
  </tr>
</table>
<table  width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <form name="form1" method="post" action="article_function.php">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="63%" height="18" align="center">เพจ</td>
      <td width="17%" align="center">ค้นหาล่าสุดเมื่อวันที่</td>
      <td width="20%" align="center">ดูรายละเอียด</td>
    </tr>
	<?php
	while ($rec=$db->db_fetch_array($query)){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<li><a href='../ewt/".$_SESSION["EWT_SUSER"]."/main.php?filename=$rec[filename]' target='_blank'>".$rec['filename']."</a>     (".$rec['sum_open'].")</li>"; ?></td>
      <td height="25">&nbsp;</td>
      <td align="center" ><img src="../images/bar_view.gif" width="20" height="20" border="0"></td>
    </tr>
	<?php } ?>
  </form>
</table>
</body>
</html>
