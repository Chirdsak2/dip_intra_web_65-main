<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$mode = $_GET[mode];
$start_date = $_GET[start_date];
$end_date = $_GET[end_date];
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
function convert_date($date,$a,$plus){
global $monthname;
$d = explode("-",$date);
if($a == "/"){
$nd = number_format($d[2],0)."/".$d[1]."/".($d[0] + $plus);
}else{
$nd = number_format($d[2],0)." ".$monthname[number_format($d[1],0)]." ".($d[0] + $plus);
}
return $nd;
}
if($start_date == "" AND $end_date == ""){
$con = " AND (sv_date = '".date("Y-m-d")."') ";
$title = "วันที่ ".convert_date(date("Y-m-d")," ",543);
$sw["y"] = date("Y");
$sw["m"] = date("m");
$sw["d"] = date("d");
$searchs = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$searche = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
}elseif($start_date != "" AND $end_date == ""){
$st = explode("/",$start_date);
$con = " AND (sv_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$title = "วันที่ ".convert_date($st[2]."-".$st[1]."-".$st[0]," ",0);
$sw["y"] = ($st[2] -543);
$sw["m"] = $st[1];
$sw["d"] = $st[0];
$searchs = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$searche = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
}elseif($start_date == "" AND $end_date != ""){
$st = explode("/",$end_date);
$con = " AND (sv_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$title = "วันที่ ".convert_date($st[2]."-".$st[1]."-".$st[0]," ",0);
$sw["y"] = ($st[2] -543);
$sw["m"] = $st[1];
$sw["d"] = $st[0];
$searchs = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$searche = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
}else{
$st = explode("/",$start_date);
$en = explode("/",$end_date);
$con = " AND (sv_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
$title = "จากวันที่ ".convert_date($st[2]."-".$st[1]."-".$st[0]," ",0)." ถึงวันที่ ". convert_date($en[2]."-".$en[1]."-".$en[0]," ",0);
$sw["y"] = ($st[2] -543);
$sw["m"] = $st[1];
$sw["d"] = $st[0];
$searchs = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$searche = JulianToJD($en[1],$en[0],($en[2] -543));
}

$calweek = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$calweek2 = $calweek + 2;
$days = $calweek2%7;
$stweek = ($calweek - $days);
$enweek = $stweek+6;
$stw = explode("/",JDToJulian($stweek));
$enw = explode("/",JDToJulian($enweek));
$startweek = $stw[1]."/".$stw[0]."/".($stw[2]+543);
$endweek = $enw[1]."/".$enw[0]."/".($enw[2]+543);
$startmonth = "01/".$sw["m"]."/".($sw["y"]+543);
$date_string = mktime(0,0,0,$sw["m"],1,$sw["y"]);
$eday1 = date("t",$date_string);
$endmonth = $eday1."/".$sw["m"]."/".($sw["y"]+543);
$startyear = "01/01/".($sw["y"]+543);
$endyear = "31/12/".($sw["y"]+543);
$monthx2 = $sw["m"]."-".$sw["y"];
?>
<html>
<head>
<title>สถิติการเข้าเว็บไซต์ </title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript"  type="text/javascript" src="lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="lib_carendar/calendar-th.js"></script>
<link href="lib_carendar/style_calendar.css" rel="stylesheet" type="text/css">
<link href="lib_carendar/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >

<table width="96%" border="0" align="center" cellpadding="5" cellspacing="0">
  <form name="form1" method="gett" action="">
    <tr> 
      <td valign="top"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="mainpic/document_view.gif" width="24" height="24" align="absmiddle"> 
      <span class="ewtfunction">สถิติการเข้าเว็บไซต์  <?php echo $title; ?></span> </td>
  </tr>
</table><hr>
        จากวันที่ 
        <input type="text" name="start_date" size="15" value="<?php print  $start_date; ?>"> 
        <img src="mainpic/calendar_edit.gif" alt="..เปิดปฎิทิน." width="24" height="24" border="0" align="absmiddle" onClick="return showCalendar('start_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
        ถึง</font> <input type="text" name="end_date" size="15" value="<?php print  $end_date;  ?>"> 
        <img src="mainpic/calendar_edit.gif" alt="..เปิดปฎิทิน." width="24" height="24" border="0" align="absmiddle" onClick="return showCalendar('end_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
        <input type="submit" name="Submit" value="แสดงข้อมูล"> <hr>
        จำนวนผู้เข้าชมเว็บไซต์ <a href="site_index.php">รายวัน</a> | <a href="site_index.php?mode=w&start_date=<?php echo $startweek; ?>&end_date=<?php echo $endweek; ?>">รายสัปดาห์</a>
        | <a href="site_index.php?mode=m&start_date=<?php echo $startmonth; ?>&end_date=<?php echo $endmonth; ?>" >รายเดือน</a> | 
        <a href="site_index.php?mode=y&start_date=<?php echo $startyear; ?>&end_date=<?php echo $endyear; ?>">รายปี</a><!--  | <a href="site_export.php?mode=<?php $mode;?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" target="_blank">ส่งออก Excel</a>--></td>
    </tr>
  </form>
</table>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
  <?php
  $sql1 = $db->query("SELECT count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con."");
	$R1 = mysql_fetch_row($sql1);
  ?>
    <td width="5%" height="30"><span class="ewtfunction">จำนวนผู้เข้าชมเว็บไซต์ <?php echo number_format($R1[0],0); ?> ราย</span></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
					$sql2 = $db->query("SELECT count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_new = 'Y' ".$con." ");
	$R2 = mysql_fetch_row($sql2);
				array_push($graph_name,"New Visitor");
				array_push($graph_data,$R2[0]);
				array_push($graph_name,"Old Visitor");
				array_push($graph_data,($R1[0] - $R2[0]));
				$graph_height  = "350";
  				$graph_width  = "380";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>
	</td>
  </tr>
</table></td>
    <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">จำนวนผู้เข้าชมเว็บไซต์แยกตามเวลา</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
						$graph_name = array();
						$graph_data = array();
			  for($m=0;$m<24;$m++){ 
		$mstart = sprintf("%02d",$m).":00";
		$mend = sprintf("%02d",$m).":59";
		$sql_time = $db->query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_url = 'page'  AND  sv_visitor = 'Y'  ".$con."  AND (sv_time BETWEEN '".$mstart.":00"."' AND '".$mend.":59"."')");
		$ccount = mysql_fetch_row($sql_time);
				array_push($graph_name,$mstart."-".$mend);
				array_push($graph_data,$ccount[0]);
				}
				$graph_height  = "350";
  				$graph_width  = "380";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>
	</td>
  </tr>
</table></td>
  </tr>
</table>
<?php
if($_GET["mode"] == "w"){
?>
<table width="96%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30">ผู้เยี่ยมชมรายสัปดาห์</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
	$dayname = array('วันอาทิตย์','วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์');
						$graph_name = array();
						$graph_data = array();
						$calweek = JulianToJD($st[1],$st[0],($st[2] -543));
			  for($m=0;$m<7;$m++){ 
		$stw = explode("/",JDToJulian($calweek));
		$dateofweek = $stw[2]."-".$stw[0]."-".$stw[1];
		$calweek++;
		$sql_time = $db->query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y'  AND sv_date = '".$dateofweek."' ");
		$ccount = mysql_fetch_row($sql_time);
				array_push($graph_name,$dayname[$m]);
				array_push($graph_data,$ccount[0]);
				}
				$graph_height  = "400";
  				$graph_width  = "750";
				$graph_group = "Y";
				$graph_rotate = "";
				include("ewt_graph_includes.php");
	
	?>
	</td>
  </tr>
</table>
<?php
}
?>
<?php
if($_GET["mode"] == "m"){
?>
<table width="96%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30">ผู้เยี่ยมชมรายเดือน</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
						$graph_name = array();
						$graph_data = array();
			 for($d=1;$d<=$eday1;$d++){ 
		$todate = $sw["y"]."-".sprintf("%02d",$sw["m"])."-".sprintf("%02d",$d);
		$sql_time = $db->query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y'  AND sv_date = '".$todate."' ");
		$ccount = $db->db_fetch_row($sql_time);
				array_push($graph_name,sprintf("%02d",$d)."/".sprintf("%02d",$sw["m"])."/".($sw["y"]+543));
				array_push($graph_data,$ccount[0]);
				}
				$graph_height  = "400";
  				$graph_width  = "750";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>
	</td>
  </tr>
</table>
<?php
}
?>
<?php
if($_GET["mode"] == "y"){
?>
<table width="96%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30">ผู้เยี่ยมชมรายปี</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
						$graph_name = array();
						$graph_data = array();
			 for($i=1;$i<13;$i++){ 
		$todate = $sw["y"]."-".sprintf("%02d",$i);
		$sql_time = $db->query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y'  AND sv_date LIKE '".$todate."-%' ");
		$ccount = mysql_fetch_row($sql_time);
				array_push($graph_name,$monthname[$i]);
				array_push($graph_data,$ccount[0]);
				}
				$graph_height  = "400";
  				$graph_width  = "750";
				$graph_group = "Y";
				$graph_rotate = "";
				include("ewt_graph_includes.php");
	
	?>
	</td>
  </tr>
</table>
<?php
}
?>
<table width="96%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30">แบ่งตามหน้าที่เข้าชม</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_menu , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_menu != '' ".$con." GROUP BY sv_menu ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "480";
  				$graph_width  = "780";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>
	</td>
  </tr>
</table>

<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="2"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td height="30">ประเทศ</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_country , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_country != '' AND sv_country != '-' AND sv_longitude != '0' AND sv_latitude != '0' ".$con." GROUP BY sv_country ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "750";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="33%"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
                <td width="5%" height="30">ระบบปฏิบัติการ</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_os , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." GROUP BY sv_os ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "260";
  				$graph_width  = "260";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>
          </td>
        </tr>
      </table></td>
    <td width="33%"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
                <td width="5%" height="30">ความละเอียดหน้าจอ</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_resolution , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." GROUP BY sv_resolution ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "260";
  				$graph_width  = "260";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>
          </td>
        </tr>
      </table></td>
    <td width="33%"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">Browser</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_browser , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." GROUP BY sv_browser ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "260";
  				$graph_width  = "260";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
    </td>
  </tr>
  <tr> 
    <td width="50%" valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">ISP</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td> <DIV style="HEIGHT: 300;OVERFLOW-Y: scroll;WIDTH: 100%;">
            <?php
	$sql = $db->query("SELECT sv_isp , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_isp != '' AND sv_isp != '-' ".$con." GROUP BY sv_isp ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
	echo "<li>".$R[0]." (".number_format($R[1],0).")</li>";
	}
	
	?>
         </DIV> </td>
        </tr>
      </table></td>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">Domain</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td> <DIV style="HEIGHT: 300;OVERFLOW-Y: scroll;WIDTH: 100%;">
            <?php
	$sql = $db->query("SELECT sv_domain , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_domain != ''   AND sv_domain != '-' ".$con." GROUP BY sv_domain ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
		echo "<li>".$R[0]." (".number_format($R[1],0).")</li>";
	}
	?>
          </DIV></td>
        </tr>
      </table></td>
  </tr>
  
  
  
  
  
  <tr> 
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">UIP ภายในประเทศ</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td> <DIV style="HEIGHT: 300;OVERFLOW-Y: scroll;WIDTH: 100%;">
            <?php
	$sql = $db->query("SELECT sv_ip , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y'   AND (sv_country = 'THAILAND' OR sv_country = '-' ) ".$con." GROUP BY sv_ip ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
echo "<li>".$R[0]." (".number_format($R[1],0).")</li>";
	}
	?>
          </DIV></td>
        </tr>
      </table></td>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">UIP ต่างประเทศ</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td > <DIV style="HEIGHT: 300;OVERFLOW-Y: scroll;WIDTH: 100%;">
            <?php
	$sql = $db->query("SELECT sv_ip , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y'   AND sv_country != 'THAILAND'   AND sv_country != '-'  ".$con." GROUP BY sv_ip ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				echo "<li>".$R[0]." (".number_format($R[1],0).")</li>";
	}
	?>
          </DIV></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%" valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="31">ภาษา</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_language , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_language != '' ".$con." GROUP BY sv_language ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "350";
  				$graph_width  = "380";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>
          </td>
        </tr>
      </table></td>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">Search engine</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	$sql = $db->query("SELECT sv_search , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND sv_search != '' ".$con." GROUP BY sv_search ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "350";
  				$graph_width  = "380";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("ewt_graph_includes.php");
	
	?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
