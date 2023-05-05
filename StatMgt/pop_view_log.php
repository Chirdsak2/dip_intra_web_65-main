<?php
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

if($_GET["FlagE"] == "pdf"){
	exportPdf($_GET['orderby'], $_GET['adesc'], $_GET['start_date'], $_GET['end_date'], $_GET['module'], $_GET['flag']);
	$db->db_close();
	exit;
}

$arr_text["Article"] = "ข่าว/บทความ";
		  $arr_text["Banner"] = "การจัดการป้ายโฆษณา ";
		  $arr_text["Poll"] = "การจัดการแบบสำรวจ ";
		  $arr_text["servey"] = "Form Generator";
		  $arr_text["webboard"] = "webboard";
		  $arr_text["enews"] = "การจัดการจดหมายข่าว ";
		  $arr_text["faq"] = "FAQ";
		  $arr_text["gallary"] = "การจัดการห้องแสดงภาพ ";
		  $arr_text["lang_setting"] = "Language Setting ";
		  $arr_text["login"] = "Login";
		  $arr_text["logout"] = "Logout";
		  $arr_text["uploadfile"] = "My Download ";
		  $arr_text["rss "] = "การจัดการ RSS Reader";
		  $arr_text["Images"] = "My Gallery";
		  $arr_text["menu"] = "บริหารเมนู";
		   $arr_text["WebBlock"] = "WebBlock Management";
		   $arr_text["sitemap"] = "การจัดการผังเว็บไซต์";
		   $arr_text["ebook"] = "E-Book Management";
		   $arr_text["complain"] = "Complain Management";
		   $arr_text["guesbook"] = "การจัดการสมุดเยี่ยมชม";
		   $arr_text["calendar"] = "การจัดการปฏิทินกิจกรรม online";
		    $arr_text["member"] = "การจัดการสมาชิก";
			$arr_text["Vulgar"] = "การตั้งค่าคำไม่สุภาพ";
			
			if($_GET["orderby"]!=''){
				 $orderby=$_GET["orderby"];
				  if($_GET["adesc"]=='DESC'){  $adesc='ASC';  }else{  $adesc='DESC';  }
				  $orderby_now = 'ORDER BY  '.$orderby.'  '.$adesc.",log_date DESC,log_time DESC";
			}else{
				$orderby_now = "ORDER BY  log_date DESC,log_time DESC";
			}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script language="javascript1.2">
function orderby(field,adesc){
     location.href='pop_view_log.php?orderby='+field+'&adesc='+adesc+'&start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&module=<?php echo  $_REQUEST["module"];?>&flag=search';
}
function CHK(t){
	if(t.start_date.value == ''){
	alert('กรุณาเลือกวันที่ ที่ต้องการ!!!!!!');
	return false;
	}
	if(t.end_date.value == ''){
	alert('กรุณาเลือกวันที่ ที่ต้องการ!!!!!!');
	return false;
	}
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<?php
$thisyear = date("Y")+543;
?>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><?php if($_GET["FlagE"] != "excel"){ ?><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle">  <?php } ?>
      <span class="ewtfunction">ติดตามการเข้าใช้ระบบ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>
    </td>
  </tr>
</table>
<?php
		if($_REQUEST[flag]=='search'){ 
			if($_REQUEST[event_start_hour] != ''){$stime1 = $_REQUEST[event_start_hour];}
			if($_REQUEST[event_start_min] != ''){$stime2 = $_REQUEST[event_start_min];}
			if($_REQUEST[event_end_hour] != ''){$etime1 = $_REQUEST[event_end_hour];}
			if($_REQUEST[event_end_min] != ''){$etime2 = $_REQUEST[event_end_min];}
			if($stime1 != '' && $stime2 != ''){		$st_time = $stime1.':'.$stime2.':00';	}
			if($stime1 != '' && $stime2 == ''){		$st_time = $stime1.':00:00';	}
			if($stime1 == '' && $stime2 != ''){		$st_time = '00:'.$stime2.':00';	}
			if($etime1 != '' && $etime2 != ''){		$et_time = $etime1.':'.$etime2.':00';	}
			if($etime1 != '' && $etime2 == ''){		$et_time = $etime1.':00:00';	}
			if($etime1 == '' && $etime2 != ''){		$et_time = '00:'.$etime2.':00';	}
		if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != '' ){
			$st = stripslashes(htmlspecialchars(trim($_REQUEST[start_date]),ENT_QUOTES));
			$st = explode("/",$st );
			$st = ($st[2] - 543 )."-".$st[1]."-".$st[0];
			//$st = $st[0]."/".$st[1]."/".($st[2] - 543 );
			if($st_time != ''){ $st  .= ' '.$st_time; }
			$et = stripslashes(htmlspecialchars(trim($_REQUEST[end_date]),ENT_QUOTES));
			$et = explode("/",$et );
			$et = ($et[2] - 543 )."-".$et[1]."-".$et[0];
			//$et = $et[0]."/".$et[1]."/".($et[2] - 543 );
			if($et_time != ''){ $et  .= ' '.$et_time;}
			//$wh1 .= "  (log_date_text  between '".$st."' AND '".$et."'  ) AND";
			$wh1 .= "  (CONCAT(log_date, ' ', log_time)  BETWEEN '".$st."' AND '".$et."'  ) AND";
		}
		if($_REQUEST[module] != ''){
			$wh1 .= "  (log_module_detail  = '".$_REQUEST[module]."' ) AND";
		}
		if($_REQUEST['hdd_uid'] != ''){
			$wh1 .= "  (log_mid  = '".$_REQUEST['hdd_uid']."' ) AND";
		}
		$wh = substr($wh1,0,-3);
		if($wh != ''){
		$wh = "where " .$wh;
		}
		//$db->write_log("view","View log","ดูรายงานการติดตามการเข้าใช้ระบบ วันที่ ".$_REQUEST[start_date]);
?>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="12%" height="18" align="center">วันที่</td>
      <td width="10%" align="center">เวลา</td>
      <td width="10%" align="center">IP</td>
      <td width="10%" align="center"><a href="javascript:orderby('log_user','<?php echo $adesc;?>')">ผู้ใช้</a><?php if($adesc == 'ASC'){?><img src="../images/bar_down.gif" align="absmiddle"><?php }else  if($adesc == 'DESC'){ ?><img src="../images/bar_up.gif" align="absmiddle"><?php } ?></td>
      <td width="58%" align="center">รายละเอียด</td>
    </tr>
	<?php
	
 $sql = $db->query("SELECT * FROM log_user $wh $orderby_now ");
	while($R = $db->db_fetch_array($sql)){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" align="center"><?php echo $R[log_date];?></td>
      <td align="center" ><?php echo $R[log_time];?></td>
      <td  align="center" ><?php echo $R[log_ip];?></td>
      <td align="center" ><a href="##" onClick="window.open('view_profile.php?gen_user=<?php echo $R[log_user]; ?>', 'select_org', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');"><?php echo $R[log_user];?></a></td>
      <td ><?php echo $R[log_detail];?></td>
    </tr>
	<?php } ?>
	<?php if($_GET["FlagE"] != "excel"){ ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="40" colspan="5" align="center"><a href="javascript:void(0);" onClick="window.print();"><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> พิมพ์หน้านี้</span></a></td>
    </tr>
	<?php } ?>
</table>
<?php } ?>
</body>
</html>
<?php
function exportPdf($orderby, $adesc, $start_date, $end_date, $module, $flag) {
	global $db;
	include("../libraries/fpdf.php");

	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
									 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
									 "'([\r\n])[\s]+'",                 // Strip out white space
									 "'&(quot|#34);'i",                 // Replace html entities
									 "'&(amp|#38);'i",
									 "'&(lt|#60);'i",
									 "'&(gt|#62);'i",
									 "'&(nbsp|#160);'i",
									 "'&(iexcl|#161);'i",
									 "'&(cent|#162);'i",
									 "'&(pound|#163);'i",
									 "'&(copy|#169);'i",
									 "'&#(\d+);'e");                    // evaluate as php
	
	$replace = array ("",
										"",
										"\\1",
										"\"",
										"&",
										"<",
										">",
										" ",
										chr(161),
										chr(162),
										chr(163),
										chr(169),
										"chr(\\1)");
	
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsab','','angsab.php');
	
	if($orderby!=''){
		$orderby=$orderby;
		if($adesc=='DESC'){  $adesc='ASC';  }else{  $adesc='DESC';  }
		$orderby_now = 'ORDER BY  '.$orderby.'  '.$adesc.",log_date DESC,log_time DESC";
	}else{
		$orderby_now = "ORDER BY  log_date DESC,log_time DESC";
	}
	if($flag=='search'){ 
		if($_REQUEST[event_start_hour] != ''){$stime1 = $_REQUEST[event_start_hour];}
		if($_REQUEST[event_start_min] != ''){$stime2 = $_REQUEST[event_start_min];}
		if($_REQUEST[event_end_hour] != ''){$etime1 = $_REQUEST[event_end_hour];}
		if($_REQUEST[event_end_min] != ''){$etime2 = $_REQUEST[event_end_min];}
		if($stime1 != '' && $stime2 != ''){		$st_time = $stime1.':'.$stime2.':00';	}
		if($stime1 != '' && $stime2 == ''){		$st_time = $stime1.':00:00';	}
		if($stime1 == '' && $stime2 != ''){		$st_time = '00:'.$stime2.':00';	}
		if($etime1 != '' && $etime2 != ''){		$et_time = $etime1.':'.$etime2.':00';	}
		if($etime1 != '' && $etime2 == ''){		$et_time = $etime1.':00:00';	}
		if($etime1 == '' && $etime2 != ''){		$et_time = '00:'.$etime2.':00';	}
		if($start_date != '' && $end_date != '' ){
			$st = stripslashes(htmlspecialchars(trim($start_date),ENT_QUOTES));
			$st = explode("/",$st );
			$st = ($st[2] - 543 )."-".$st[1]."-".$st[0];
			//$st = $st[0]."/".$st[1]."/".($st[2] - 543 );
			if($st_time != ''){ $st  .= ' '.$st_time; }
			$et = stripslashes(htmlspecialchars(trim($end_date),ENT_QUOTES));
			$et = explode("/",$et );
			$et = ($et[2] - 543 )."-".$et[1]."-".$et[0];
			//$et = $et[0]."/".$et[1]."/".($et[2] - 543 );
			if($et_time != ''){ $et  .= ' '.$et_time;}
			//$wh1 .= "  (log_date_text  between '".$st."' AND '".$et."'  ) AND";
			$wh1 .= "  (CONCAT(log_date, ' ', log_time)  BETWEEN '".$st."' AND '".$et."'  ) AND";
		}
		if($module != ''){
			$wh1 .= "  (log_module_detail  = '".$module."' ) AND";
		}
		$wh = substr($wh1,0,-3);
		if($wh != ''){
			$wh = "where " .$wh;
		}	
		$height=5;
		$pdf->x=15;
		$pdf->SetFont('angsab', '',18);
		$pdf->Cell('180',$height,'ติดตามการเข้าใช้ระบบ','',1,'C',0);
		
		$data_sub = preg_replace($search, $replace, "test \r\n test2 test3");
		
		$pdf->Cell('180',$height,'','',1,'L',0);
		
		$pdf->SetFont('angsab', '',11);
		$pdf->Cell('15',$height,'วันที่','LTB',0,'C',0);
		$pdf->Cell('15',$height,'เวลา','LTB',0,'C',0);
		$pdf->Cell('20',$height,'IP','LTB',0,'C',0);
		$pdf->Cell('15',$height,'ผู้ใช้','LTB',0,'C',0); 
		$pdf->Cell('120',$height,'รายละเอียด','LTRB',1,'C',0);
		
		//$pdf->Cell('180',$height,"SELECT * FROM log_user $wh $orderby_now",'LTRB',0,'C',0);
		$sql = $db->query("SELECT * FROM log_user $wh $orderby_now ");
		while($R = $db->db_fetch_array($sql)){
			/*$lineNum=ceil(strlen($R['log_detail'])/50);
			$moreHeight=1;
			for($i=1; $i<$lineNum; $i++) {
				$moreHeight++;
			}*/
			$exLogDate = explode("-",$R['log_date'] );
			$fLogDate = $exLogDate[2]."-".$exLogDate[1]."-".(($exLogDate[0]<2500)?$exLogDate[0]+543:$exLogDate[0]);
			$pdf->Cell('15',$height,$fLogDate,'LTB',0,'C',0);
			$pdf->Cell('15',$height,$R['log_time'],'LTB',0,'C',0);
			$pdf->Cell('20',$height,$R['log_ip'],'LTB',0,'C',0);
			$pdf->Cell('15',$height,$R['log_user'],'LTB',0,'C',0); 
			$pdf->MultiCell('120',$height,substr(wordwrap(preg_replace($search, $replace, $R['log_detail'])),0,100),'LTRB',1,'L',0);
		}
		
		$pdf->Output();
	}
}	// end function
$db->db_close();
?>
