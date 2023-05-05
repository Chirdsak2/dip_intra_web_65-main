<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
if($thisday == ""){
$thisday = date("d");
}
if($thismonth == ""){
$thismonth = date("m");
}
if($thisyear == ""){
$thisyear = date("Y");
}
$basediv = 0;
if($page){
$db->write_log("view","View stat","ดูรายงานสถิติการเข้าเว็ปรายวัน กราฟเส้น วันที่ ".$thisday."/".$thismonth."/".($thisyear+543) ."    หน้า" .$page);
}else{
$db->write_log("view","View stat","ดูรายงานสถิติการเข้าเว็ปรายวัน กราฟเส้น วันที่ ".$thisday."/".$thismonth."/".($thisyear+543) ."    ทุกหน้า");
}
?>
<html>
<head>
<title>Stat</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td><img src="../images/document_view.gif" width="24" height="24" border="0" align="left"> 
      <strong><font size="4" face="Tahoma">สถิติการเข้าเว็บของวันที่ <?php echo number_format($thisday,0); ?> 
      <?php echo $monthname[number_format($thismonth,0)]; ?> <?php echo ($thisyear + 543); ?></font></strong></td>
  </tr>
  <tr height="4">
    <td height="4" bgcolor="#000066"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td align="right"><a href="index_pie.php?thisday=<?php echo $thisday;?>&thismonth=<?php echo $thismonth;?>&thisyear=<?php echo $thisyear;?>"><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle" border="0"><strong>แสดงสถิติกราฟวงกลม</strong></a>|<a href="index.php?thisday=<?php echo $thisday;?>&thismonth=<?php echo $thismonth;?>&thisyear=<?php echo $thisyear;?>"><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle" border="0"><strong>แสดงสถิติกราฟแท่ง</strong></a></td>
  </tr>
  <tr>
    <td><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle"><font size="2" face="Tahoma"><strong>สถิติรายปี</strong></font></td>
  </tr>
  <tr>
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
        <tr bgcolor="#FFFFFF">
		<?php for($y=2007;$y<=date("Y");$y++){ 
		$sql_year = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date LIKE '".$y."-%' ");
		$ccount = mysql_fetch_row($sql_year);
		?>
          <td  align="center" <?php if($y==$thisyear){  $basediv = $ccount[0]; ?>bgcolor="#FF9966"<?php } ?>><a href="index.php?thisday=<?php echo $thisday; ?>&thismonth=<?php echo $thismonth; ?>&thisyear=<?php echo $y; ?>"><font size="2" face="Tahoma"><b><?php echo ($y+543); ?></b></font></a><font size="2" face="Tahoma"><br>
            (<?php echo number_format($ccount[0],0); ?>)</font></td>
		  <?php } ?>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle"><font size="2" face="Tahoma"><strong>สถิติรายเดือนปี <?php echo ($thisyear + 543); ?>
      </strong></font></td>
  </tr>
  <tr>
    <td><table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#000000">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><img src="graph_line_stat.php?flag=month&thisyear=<?php echo $thisyear;?>&thismonth=<?php echo $thismonth; ?>" border="0">
      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
        <tr bgcolor="#FFFFFF"> 
          <?php for($i=1;$i<13;$i++){
		  $sql_month = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date LIKE '".$thisyear."-".sprintf("%02d",$i)."-%' ");
		$ccount = mysql_fetch_row($sql_month);
		  ?>
		   <td width="8%" align="center" <?php if($i==number_format($thismonth,0)){ $divmonth =$ccount[0];  ?>bgcolor="#FF9966"<?php } ?>><a href="index_pie.php?thisday=<?php echo $thisday; ?>&thismonth=<?php echo sprintf("%02d",$i); ?>&thisyear=<?php echo $thisyear; ?>"><font size="2" face="Tahoma"><b><?php echo $monthname[$i]; ?>(<?php echo number_format($ccount[0],0); ?>)</b></font></a></td>
           <?php } ?></tr>
       
      </table></td>
  </tr>
</table>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle"><font size="2" face="Tahoma"><strong>สถิติรายวันภายในเดือน 
      <?php echo $monthname[number_format($thismonth,0)]; ?> <?php echo ($thisyear + 543); ?></strong></font></td>
  </tr>
  <tr> 
    <td align="center"><table width="95%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><img src="graph_line_stat.php?flag=day&thisday=<?php echo $thisday;?>&thismonth=<?php echo $thismonth;?>&thisyear=<?php echo $thisyear;?>" border="0">
      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
        <?php
		if($thismonth == "01" OR $thismonth == "03" OR $thismonth == "05" OR $thismonth == "07" OR $thismonth == "08" OR $thismonth == "10" OR $thismonth == "12" ){
		$endmonth = "31";
		}
		if($thismonth == "04" OR $thismonth == "06" OR $thismonth == "09" OR $thismonth == "11" ){
		$endmonth = "30";
		}
		if($thismonth == "02"){
		if($thisyear % 4 == 0){
				$endmonth = "29";
		}else{
				$endmonth = "28";
		}
		}
		 ?>
        <tr > 
		<?php
		for($d=1;$d<=$endmonth;$d++){ 
		 $todate = $thisyear."-".$thismonth."-".sprintf("%02d",$d);
		 $sql_date = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date = '$todate'  ");
		$ccount = mysql_fetch_row($sql_date);
		?>
          <td <?php if($d==number_format($thisday,0)){  $divday =$ccount[0]; ?>bgcolor="#FF9966"<?php } ?> width="3%" align="center" ><a href="index_pie.php?thisday=<?php echo sprintf("%02d",$d); ?>&thismonth=<?php echo $thismonth; ?>&thisyear=<?php echo $thisyear; ?>"><strong><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $d; ?>(<?php echo number_format($ccount[0],0); ?>)</font></strong></a></td>
          <?php  } ?>
          </tr>
      </table></td></tr>
</table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle"><font size="2" face="Tahoma"><strong>สถิติช่วงเวลาของวันที่ <?php echo number_format($thisday,0); ?> <?php echo $monthname[number_format($thismonth,0)]; ?> <?php echo ($thisyear + 543); ?> </strong></font></td>
  </tr>
  <tr>
    <td align="center"><img src="graph_line_stat.php?flag=time&thisday=<?php echo $thisday;?>&thismonth=<?php echo $thismonth;?>&thisyear=<?php echo $thisyear;?>" border="0">
      <table width="95%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
          
          <tr bgcolor="#FFFFFF">
            <?php for($m=0;$m<24;$m++){ 
		$mstart = sprintf("%02d",$m).":00";
		$mend = sprintf("%02d",$m).":59";
		$sql_time = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date = '".$thisyear."-".$thismonth."-".$thisday."'  AND (sv_time BETWEEN '".$mstart.":00"."' AND '".$mend.":59"."')");
		$ccount = mysql_fetch_row($sql_time);
		?><td width="15%" align="center" bgcolor="#E7E7E7"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $mstart; ?>-<?php echo $mend; ?></font><font color="#FF0000" size="1" face="MS Sans Serif, Tahoma, sans-serif">(<?php echo number_format($ccount[0],0); ?>)</font></td>
          <?php } ?></tr>
         
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
