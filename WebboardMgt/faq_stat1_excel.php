<?php
if($_GET["FlagE"] == "excel"){
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition:  filename=fag_excel.xls");
header( 'Content-Description: Download Data' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );



}
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language.php");
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
</head>
<body leftmargin="0" topmargin="0" class="normal_font">
<?php
if($_GET[flag]=='search'){
	$start_date = $_REQUEST["start_date"];
	$end_date = $_REQUEST["end_date"];
	if($start_date == "" AND $end_date == ""){
	$con = "";
	$date_name = "";
	}elseif($start_date != "" AND $end_date == ""){
	$st = explode("/",$start_date);
	$con = " AND (faq_stat_dateate = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	$date_name = "วันที่".$start_date;
	}elseif($start_date == "" AND $end_date != ""){
	$st = explode("/",$end_date);
	$con = " AND (faq_stat_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	$date_name = "วันที่".$end_date;
	}else{
	$st = explode("/",$start_date);
	$en = explode("/",$end_date);
	$con = " AND (faq_stat_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
	$date_name = "วันที่".$start_date."ถึง วันที่".$end_date;
	}
$sql_group = $db->query("select * from f_subcat where f_sub_id ='".$_REQUEST[fid]."'");
$RG = $db->db_fetch_array($sql_group);
?>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#ffffff" >
  <tr>
    <td align="center" colspan="2" class="ewtfunction">รายงานอันดับความนิยมหมวด  : <?php echo $RG[f_subcate ];?></td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="ewtfunction"><?php echo $date_name;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="95%" border="1" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000" class="ewttableuse">
  <tr  class="ewttablehead">
    <td align="center">คำถาม</td>
    <td width="20%" align="center">จำนวนผู้เข้าชม</td>
  </tr>
  <?php
  $sql="SELECT faq.fa_id, faq.fa_name,COUNT(faq_stat.faq_stat_id) AS countstat FROM faq LEFT JOIN faq_stat ON faq.fa_id = faq_stat.fa_id   $con WHERE f_sub_id = '".$_REQUEST[fid]."'  GROUP BY faq.fa_id, faq.fa_name ORDER BY countstat DESC";
$Execsql = $db->query($sql);
 $row = mysql_num_rows($Execsql); 
 while($R = $db->db_fetch_array($Execsql)){

  ?>
    <tr bgcolor="#FFFFFF">
    <td><?php echo $R[fa_name];?></td>
    <td align="center"><?php echo $R["countstat"];?></td>
  </tr>
<?php } ?>
</table>
<?php
}
?>
</body>
</html>
<?php @$db->db_close(); ?>