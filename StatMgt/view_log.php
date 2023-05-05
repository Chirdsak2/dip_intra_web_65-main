<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

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
function popViewLog(){
     window.open('pop_view_log.php?orderby=<?php echo $_REQUEST["orderby"];?>&event_start_hour=<?php echo $_REQUEST['event_start_hour']; ?>&event_start_min=<?php echo $_REQUEST['event_start_min']; ?>&event_end_hour=<?php echo $_REQUEST['event_end_hour']; ?>&event_end_min=<?php echo $_REQUEST['event_end_min']; ?>&adesc=<?php echo $_REQUEST["adesc"];?>&start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&module=<?php echo  $_REQUEST["module"];?>&flag=search', 'popViewLog', 'scrollbars=1,resizable=1');
}
function orderby(field,adesc){
     location.href='view_log.php?orderby='+field+'&adesc='+adesc+'&start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&module=<?php echo  $_REQUEST["module"];?>&flag=search';
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
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ติดตามการเข้าใช้ระบบ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form2" method="post" action="view_log.php"  onSubmit="return CHK(this)" >
      <td> <table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
         <tr>
           <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ค้นหา            </td>
          </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">วันที่ :<span class="style1">*</span> </td>
           <td width="73%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" id="start_date" value="<?php echo $_REQUEST[start_date];?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a> เวลา 
             <select name="event_start_hour" id="event_start_hour">
			<option value=""></option>
<?php
	for($i=0;$i<=23;$i++) { 
		if($_POST[event_start_hour] == $i) $selected_time = " selected";
		else $selected_time = "";
?>
				<option value="<?php echo $i;?>" <?php echo $selected_time?>><?php echo sprintf('%02d', $i);?></option>
<?php
	}
?>
			</select>&nbsp;:&nbsp;<select name="event_start_min" id="event_start_min">
               <option value=""></option>
               <?php for($i=0;$i<=59;$i++) { 
					if($_POST[event_start_min] == $i) $selected_time = " selected";
						else $selected_time = "";?>
               <option value="<?php echo $i;?>" <?php echo $selected_time?>>
                 <?php echo sprintf('%02d', $i);?>
                </option>
               <?php } ?>
            </select></td>
         </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF"> ถึงวันที่ : <span class="style1">*</span></td>
           <td bgcolor="#FFFFFF">	 <input name="end_date" type="text" size="15" id="end_date" value="<?php echo $_REQUEST[end_date];?>">
             <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a> เวลา <select name="event_end_hour" id="event_end_hour">
			<option value=""></option>
<?php
	for($i=0;$i<=23;$i++) { 
		if($_POST[event_end_hour] == $i) $selected_time = " selected";
		else if($_POST['event_end_hour'] == '' && $i == 23) $selected_time = " selected";
		else $selected_time = "";
?>
		<option value="<?php echo $i;?>" <?php echo $selected_time?>><?php echo sprintf('%02d', $i);?></option>
<?php
	}
?>
			</select>&nbsp;:&nbsp;
			<select name="event_end_min" id="event_end_min">
				<option value=""></option>
<?php
	for($i=0;$i<=59;$i++) {
		if($_POST[event_end_min] == $i) $selected_time = " selected";
		else if($_POST[event_end_min] == '' && $i == 59) $selected_time = " selected";
		else $selected_time = '';
?><option value="<?php echo $i;?>" <?php echo $selected_time?>><?php echo sprintf('%02d', $i);?></option>
<?php
	}
?>
			</select></td>
         </tr>
         <tr>
           <td align="right" bgcolor="#FFFFFF">แสดงตาม module : </td>
           <td bgcolor="#FFFFFF"><select name="module"  >
          <option value="">---ทั้งหมด---</option>
          <option value="Article" <?php if($_REQUEST[module]=='Article'){ echo 'selected';}?>>ข่าว/บทความ</option>
		  <option value="Banner" <?php if($_REQUEST[module]=='Banner'){ echo 'selected';}?>>การจัดการป้ายโฆษณา </option>
		  <option value="Poll" <?php if($_REQUEST[module]=='Poll'){ echo 'selected';}?>>การจัดการแบบสำรวจ </option>
		  <option value="servey" <?php if($_REQUEST[module]=='servey'){ echo 'selected';}?>>Form Generator</option>
		  <option value="webboard" <?php if($_REQUEST[module]=='webboard'){ echo 'selected';}?>>webboard</option>
		  <option value="enews" <?php if($_REQUEST[module]=='enews'){ echo 'selected';}?>>การจัดการจดหมายข่าว </option>
		  <option value="faq" <?php if($_REQUEST[module]=='faq'){ echo 'selected';}?>>faq</option>
		  <option value="gallary" <?php if($_REQUEST[module]=='gallary'){ echo 'selected';}?>>การจัดการห้องแสดงภาพ </option>
		  <option value="lang_setting" <?php if($_REQUEST[module]=='lang_setting'){ echo 'selected';}?>>Language Setting </option>
		  <option value="login" <?php if($_REQUEST[module]=='login'){ echo 'selected';}?>>Login</option>
		  <option value="logout" <?php if($_REQUEST[module]=='logout'){ echo 'selected';}?>>Logout </option>
		  <option value="uploadfile" <?php if($_REQUEST[module]=='uploadfile'){ echo 'selected';}?>>My Download  </option>
		  <option value="rss " <?php if($_REQUEST[module]=='rss '){ echo 'selected';}?>>การจัดการ RSS Reader </option>
		  <option value="Images" <?php if($_REQUEST[module]=='Images'){ echo 'selected';}?>>My Gallery </option>
		  <option value="menu" <?php if($_REQUEST[module]=='menu'){ echo 'selected';}?>>บริหารเมนู </option>
		   <option value="WebBlock" <?php if($_REQUEST[module]=='WebBlock'){ echo 'selected';}?>>WebBlock Management  </option>
		   <option value="sitemap" <?php if($_REQUEST[module]=='sitemap'){ echo 'selected';}?>>การจัดการผังเว็บไซต์ </option>
		   <option value="ebook" <?php if($_REQUEST[module]=='ebook'){ echo 'selected';}?>>E-Book Management </option>
		   <option value="complain" <?php if($_REQUEST[module]=='complain'){ echo 'selected';}?>>Complain Management </option>
		   <option value="guesbook" <?php if($_REQUEST[module]=='guesbook'){ echo 'selected';}?>>การจัดการสมุดเยี่ยมชม </option>
		   <option value="calendar" <?php if($_REQUEST[module]=='calendar'){ echo 'selected';}?>>การจัดการปฏิทินกิจกรรม online </option>
		    <option value="member" <?php if($_REQUEST[module]=='member'){ echo 'selected';}?>>การจัดการสมาชิก </option>
			<option value="Vulgar" <?php if($_REQUEST[module]=='Vulgar'){ echo 'selected';}?>>การตั้งค่าคำไม่สุภาพ  </option>
		   </select></td>
         </tr>
         <tr>
           <td align="right" bgcolor="#FFFFFF">เลือกผู้ใช้งาน : </td>
           <td bgcolor="#FFFFFF"><input name="name" type="text" id="name" size="40" value="<?php echo $_REQUEST['name']; ?>">
           <a href="#" onClick="popo=window.open('site_s_professor.php','popug','width=800,height=600,scrollbars=1,resizable=1');popo.focus();"><img src="../images/user_pos.gif" alt="เพิ่มผุ้เชี่ยวชาญจากสมาชิกในระบบ" width="20" height="20" border="0"> 
        <input type="hidden" name="hdd_uid" id="hdd_uid" value="">
        </a></td>
         </tr>
         <tr>
           <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="ค้นหา">
            <input type="hidden" name="flag" value="search"></td>
          </tr>
       </table>
      <br></td>
    </form>
  </tr>
</table> 
<?php if($_REQUEST[flag]=='search'){ 
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
		$db->write_log("view","View log","ดูรายงานการติดตามการเข้าใช้ระบบ วันที่ ".$_REQUEST[start_date]);
		$graph_name = array();
		$graph_data = array();
		
		 $sqlg = $db->query("SELECT  log_module_detail,COUNT(log_module_detail) AS cd  FROM log_user $wh GROUP BY log_module_detail ORDER BY cd desc");
	while($G = mysql_fetch_row($sqlg)){
		if($arr_text[$G[0]] != ""){
				array_push($graph_name,$arr_text[$G[0]]);
				array_push($graph_data,$G[1]);
		}
	}
?>
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
<a href="javascript:void(0);" onClick="popViewLog('<?php echo $_REQUEST['orderby']; ?>', '<?php echo $_REQUEST['adesc']; ?>');"><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> พิมพ์หน้านี้</span></a> | <a href="pop_view_log.php?orderby=<?php echo $_REQUEST["orderby"];?>&adesc=<?php echo $_REQUEST["adesc"];?>&start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&module=<?php echo  $_REQUEST["module"];?>&flag=search&FlagE=excel" ><img src="../images/excel.gif" width="20" height="20" border="0" align="absmiddle" title="Excel"> <span class="ewtfunction"> ส่งออกข้อมูลแบบ Excel</span></a> | <a href="pop_view_log.php?orderby=<?php echo $_REQUEST["orderby"];?>&adesc=<?php echo $_REQUEST["adesc"];?>&start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&event_start_hour=<?php echo $_REQUEST["event_start_hour"];?>&event_end_hour=<?php echo $_REQUEST["event_end_hour"];?>&event_start_min=<?php echo $_REQUEST["event_start_min"];?>&event_end_min=<?php echo $_REQUEST["event_end_min"];?>

&module=<?php echo  $_REQUEST["module"];?>&flag=search&FlagE=pdf" target="_blank"><img src="../theme/main_theme/Adobe_PDF_Icon.png" width="20" height="20" border="0" align="absmiddle" title="PDF"> <span class="ewtfunction"> ส่งออกข้อมูลแบบ PDF</span></a>
</center><br>

<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="10%" height="18" align="center">วันที่</td>
      <td width="10%" align="center">เวลา</td>
      <td width="10%" align="center">IP</td>
      <td width="10%" align="center"><a href="javascript:orderby('log_user','<?php echo $adesc;?>')">ผู้ใช้</a><?php if($adesc == 'ASC'){?><img src="../images/bar_down.gif" align="absmiddle"><?php }else  if($adesc == 'DESC'){ ?><img src="../images/bar_up.gif" align="absmiddle"><?php } ?></td>
      <td width="60%" align="center">รายละเอียด</td>
    </tr>
	<?php
	
 $sql = $db->query("SELECT * FROM log_user $wh $orderby_now ");
	while($R = $db->db_fetch_array($sql)){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" align="center">
<?php
		$exLogDate = explode("-",$R['log_date'] );
		$fLogDate = $exLogDate[2]."-".$exLogDate[1]."-".(($exLogDate[0]<2500)?$exLogDate[0]+543:$exLogDate[0]);
		echo $fLogDate;?></td>
      <td align="center" ><?php echo $R[log_time];?></td>
      <td  align="center" ><?php echo $R[log_ip];?></td>
      <td align="center" ><a href="##" onClick="window.open('view_profile.php?gen_user=<?php echo $R[log_user]; ?>', 'select_org', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');"><?php echo $R[log_user];?></a></td>
      <td ><?php echo $R[log_detail];?></td>
    </tr>
	<?php } ?>
</table>
<center><br>
<a href="javascript:void(0);" onClick="popViewLog('<?php echo $_REQUEST['orderby']; ?>', '<?php echo $_REQUEST['adesc']; ?>');"><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> พิมพ์หน้านี้</span></a> | <a href="pop_view_log.php?orderby=<?php echo $_REQUEST["orderby"];?>&adesc=<?php echo $_REQUEST["adesc"];?>&start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>&module=<?php echo  $_REQUEST["module"];?>&flag=search&FlagE=excel" ><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle"> <span class="ewtfunction"> ส่งออกข้อมูล</span></a>
</center>

<?php } ?>
</body>
</html>
<?php
$db->db_close(); ?>
