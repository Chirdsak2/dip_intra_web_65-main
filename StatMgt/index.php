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
$db->write_log("view","View stat","ดูรายงานสถิติการเข้าเว็ปรายวัน กราฟแท่ง วันที่ ".$thisday."/".$thismonth."/".($thisyear+543) ."    หน้า" .$page);
}else{
$db->write_log("view","View stat","ดูรายงานสถิติการเข้าเว็ปรายวัน กราฟแท่ง วันที่ ".$thisday."/".$thismonth."/".($thisyear+543) ."    ทุกหน้า");
}
?>
<html>
<head>
<title>Stat</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >

<form action="" method="get">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td><img src="../images/document_view.gif" width="24" height="24" border="0" align="left"> 
      <strong><font size="4" face="Tahoma">สถิติการเข้าเว็บของวันที่ <?php echo number_format($thisday,0); ?> 
      <?php echo $monthname[number_format($thismonth,0)]; ?> <?php echo ($thisyear + 543); ?></font></strong>
	  <select name="page">
	     <option  value="">	ทุกหน้า  </option>
		 <?php 
		 $sql_page = mysql_query("SELECT distinct sv_menu FROM stat_visitor  where sv_menu <> '' order by sv_menu");
		 while($dat=mysql_fetch_array($sql_page)){
		 ?><option  value="<?php echo $dat['sv_menu'];?>" <?php if($dat['sv_menu']==$page){echo  " selected";}?>><?php echo $dat['sv_menu'];?></option><?php
		 }
		 ?>
		 </select>
		 <input  type="submit" value="แสดง">
		 <?php 
		 if($page){
		   $where=" and sv_menu = '$page' " ;
		 }
		 ?>
		 
	  </td>
  </tr>
  <tr height="4">
    <td height="4" bgcolor="#000066"></td>
  </tr>
</table>

</form>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
        <tr bgcolor="#FFFFFF"><td align="center" valign="top">
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF"><tr bgcolor="#FFFFFF">
		<?php
			$graph_name = array();
			$graph_data = array();
			$graph_link = array();
		 for($y=2007;$y<=date("Y");$y++){ 
		$sql_year = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date LIKE '".$y."-%' $where  ");
		$ccount = mysql_fetch_row($sql_year);
		$link = "index.php?thisday=".$thisday."&thismonth=".$thismonth."&thisyear=".$y;
				array_push($graph_name,($y+543));
				array_push($graph_data,$ccount[0]);
				array_push($graph_link,$link);
		?>
          <td  align="center" <?php if($y==$thisyear){  $basediv = $ccount[0]; ?>bgcolor="#FF9966"<?php } ?>><a href="index.php?thisday=<?php echo $thisday; ?>&thismonth=<?php echo $thismonth; ?>&thisyear=<?php echo $y; ?>"><font size="2" face="Tahoma"><b><?php echo ($y+543); ?></b></font></a><font size="2" face="Tahoma"><br>
            (<?php echo number_format($ccount[0],0); ?>)</font></td>
		  <?php } ?>
        </tr>
      </table>
	  	  <?php
				$graph_height  = "400";
  				$graph_width  = "800";
				$graph_group = "Y";
				include("../ewt_graph_include.php");
	  ?>
	  </td>
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
    <td align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF"><tr bgcolor="#FFFFFF">
        <?php
			$graph_name = array();
			$graph_data = array();
			$graph_link = array();
		 for($i=1;$i<13;$i++){ 
		$sql_month = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date LIKE '".$thisyear."-".sprintf("%02d",$i)."-%' $where ");
		$ccount = mysql_fetch_row($sql_month);
		$link = "index.php?thisday=".$thisday."&thismonth=".sprintf("%02d",$i)."&thisyear=".$thisyear."&page=".$page;
				array_push($graph_name,$monthname[$i]);
				array_push($graph_data,$ccount[0]);
				array_push($graph_link,$link);
		?>
         
          <td width="8%" align="center" <?php if($i==number_format($thismonth,0)){ $divmonth =$ccount[0];  ?>bgcolor="#FF9966"<?php } ?>><a href="index.php?thisday=<?php echo $thisday; ?>&thismonth=<?php echo sprintf("%02d",$i); ?>&thisyear=<?php echo $thisyear; ?>&page=<?php echo $page; ?>"><font size="2" face="Tahoma"><b><?php echo $monthname[$i]; ?></b></font></a><br>
(<?php echo number_format($ccount[0],0); ?>)</td>
        
        <?php } ?></tr>
      </table>
	  <?php
				$graph_height  = "400";
  				$graph_width  = "800";
				include("../ewt_graph_include.php");
	  ?>
	  </td>
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
    <td align="center"> <table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
        <tr> 
          <td align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
              <tr> 
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
			$graph_name = array();
			$graph_data = array();
			$graph_link = array();
		 for($d=1;$d<=$endmonth;$d++){ 
		 $todate = $thisyear."-".$thismonth."-".sprintf("%02d",$d);
		 $sql_date = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date = '$todate' $where  ");
		$ccount = mysql_fetch_row($sql_date);
		$link = "index.php?thisday=".sprintf("%02d",$d)."&thismonth=".$thismonth."&thisyear=".$thisyear."&page=".$page;
				array_push($graph_name,$d);
				array_push($graph_data,$ccount[0]);
		 		array_push($graph_link,$link);
		 ?>
                <td align="center"  <?php if($d==number_format($thisday,0)){  $divday =$ccount[0]; ?>bgcolor="#FF9966"<?php } ?>><a href="index.php?thisday=<?php echo sprintf("%02d",$d); ?>&thismonth=<?php echo $thismonth; ?>&thisyear=<?php echo $thisyear; ?>&page=<?php echo $page; ?>"><strong><font size="2" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $d; ?></font></strong></a><br> 
                  <font size="1" face="MS Sans Serif, Tahoma, sans-serif">(<?php echo number_format($ccount[0],0); ?>)</font></td>
                <?php  } ?>
              </tr>
            </table>
            <?php 				
		  		$graph_height  = "400";
  				$graph_width  = "800";
				include("../ewt_graph_include.php"); ?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td><img src="../images/c_chart.gif" width="24" height="24" align="absmiddle"><font size="2" face="Tahoma"><strong>สถิติช่วงเวลาของวันที่ 
      <?php echo number_format($thisday,0); ?> <?php echo $monthname[number_format($thismonth,0)]; ?> 
      <?php echo ($thisyear + 543); ?> </strong></font></td>
  </tr>
  <tr> 
    <td align="center"><table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
        <tr> 
          <td align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
              <tr bgcolor="#FFFFFF"><?php 
			  $link = "";
			  			$graph_name = array();
						$graph_data = array();
			  for($m=0;$m<24;$m++){ 
		$mstart = sprintf("%02d",$m).":00";
		$mend = sprintf("%02d",$m).":59";
		$sql_time = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date = '".$thisyear."-".$thismonth."-".$thisday."'  AND (sv_time BETWEEN '".$mstart.":00"."' AND '".$mend.":59"."')");
		$ccount = mysql_fetch_row($sql_time);
				array_push($graph_name,$mstart."-".$mend);
				array_push($graph_data,$ccount[0]);
		?>
               
                <td align="center" bgcolor="#E7E7E7"><div><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><?php echo $mstart; ?>-<?php echo $mend; ?></font></div><font size="1" face="MS Sans Serif, Tahoma, sans-serif">(<?php echo number_format($ccount[0],0); ?>)</font></td>
              
              <?php } ?></tr>
            </table>            <?php 				
		  		$graph_height  = "400";
  				$graph_width  = "800";
				$graph_rotate = "1";
				include("../ewt_graph_include.php"); ?></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
