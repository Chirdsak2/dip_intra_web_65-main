<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	@include("language/language".$lang_sh.".php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/interface.css" rel="stylesheet" type="text/css">
<link href="css/normal.css" rel="stylesheet" type="text/css">
<link href="css/jquery.cluetip.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<form id="form1" name="form1" method="post" action="">
<?php
	$sql_dis="select * from cal_event where  event_id='".$event_id."' ";
	$query_dis = mysql_query($sql_dis);
	$fetch_dis = mysql_fetch_array($query_dis);
	$html = "";
	if($fetch_dis['event_date_start'] != $fetch_dis['event_date_end']) {
		$start_date = explode('-', $fetch_dis['event_date_start']);
		$end_date = explode('-', $fetch_dis['event_date_end']);
		$html .= date('j', mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0])).'&nbsp;';
		switch($start_date[1]) {
			case 1:  $html .= "มกราคม"; break;
			case 2:  $html .= "กุมภาพันธ์"; break;
			case 3:  $html .= "มีนาคม"; break;
			case 4:  $html .= "เมษายน"; break;
			case 5:  $html .= "พฤษภาคม"; break;
			case 6:  $html .= "มิถุนายน"; break;
			case 7:  $html .= "กรกฏาคม"; break;
			case 8:  $html .= "สิงหาคม"; break;
			case 9:  $html .= "กันยายน"; break;
			case 10:  $html .= "ตุลาคม"; break;
			case 11:  $html .= "พฤศจิกายน"; break;
			case 12:  $html .= "ธันวาคม"; break;
		}
		$html .= '&nbsp;'.(date('Y', mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]))+543);
		//$html .= date('M j ', mktime(0, 0, 0, substr($fetch_dis['event_date_start'], 5, 2), substr($fetch_dis['event_date_start'], 8, 2), substr($fetch_dis['event_date_start'], 0, 4)))."";
		$html .= "&nbsp;-&nbsp;";
		$html .= date('j', mktime(0, 0, 0, $end_date[1], $end_date[2], $end_date[0])).'&nbsp;';
		switch($end_date[1]) {
			case 1:  $html .= "มกราคม"; break;
			case 2:  $html .= "กุมภาพันธ์"; break;
			case 3:  $html .= "มีนาคม"; break;
			case 4:  $html .= "เมษายน"; break;
			case 5:  $html .= "พฤษภาคม"; break;
			case 6:  $html .= "มิถุนายน"; break;
			case 7:  $html .= "กรกฏาคม"; break;
			case 8:  $html .= "สิงหาคม"; break;
			case 9:  $html .= "กันยายน"; break;
			case 10:  $html .= "ตุลาคม"; break;
			case 11:  $html .= "พฤศจิกายน"; break;
			case 12:  $html .= "ธันวาคม"; break;
		}
		$html .= '&nbsp;'.(date('Y', mktime(0, 0, 0, $end_date[1], $end_date[2], $end_date[0]))+543);
	} else {
		$start_date = explode('-', $fetch_dis['event_date_start']);
		$end_date = explode('-', $fetch_dis['event_date_end']);
		$html .= date('j', mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0])).'&nbsp;';
		switch($start_date[1]) {
			case 1:  $html .= "มกราคม"; break;
			case 2:  $html .= "กุมภาพันธ์"; break;
			case 3:  $html .= "มีนาคม"; break;
			case 4:  $html .= "เมษายน"; break;
			case 5:  $html .= "พฤษภาคม"; break;
			case 6:  $html .= "มิถุนายน"; break;
			case 7:  $html .= "กรกฏาคม"; break;
			case 8:  $html .= "สิงหาคม"; break;
			case 9:  $html .= "กันยายน"; break;
			case 10:  $html .= "ตุลาคม"; break;
			case 11:  $html .= "พฤศจิกายน"; break;
			case 12:  $html .= "ธันวาคม"; break;
		}
		$html .= '&nbsp;'.(date('Y', mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]))+543);
	}
	$html .= '<br>';
	$start_time = explode(':', $fetch_dis['event_time_start']);
	$end_time = explode(':', $fetch_dis['event_time_end']);
	$end_ampm = " น.";
	$start_ampm = " น.";
	if(($fetch_dis['event_date_start'] != $fetch_dis['event_date_end']) && ($fetch_dis['event_date_end'] != '0000-00-00') && ($fetch_dis['event_all_day'] != '1')) {
		//$html .= date('M j ', mktime(0, 0, 0, substr($fetch_dis['event_date_end'], 5, 2), substr($fetch_dis['event_date_end'], 8, 2), substr($fetch_dis['event_date_end'], 0, 4)));
		$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
		$html .= '&nbsp;-&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
	} else {
		if($fetch_dis['event_time_start'] == '00:00:00' && $fetch_dis['event_time_start'] == '00:00:00') {
			$html .= "ไม่ระบุเวลา";
		} else {
			if(($fetch_dis['event_all_day'] != '1')) {
				$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
			} else {
				$html .= "ตลอดวัน";
			}
		}
	}
	$name_staff = "";
	$name_division = "";
	$sql_invite2  = "select * from cal_invite where event_id = '".$fetch_dis[event_id]."' ";
	$query_invite2 = $db->query($sql_invite2);
	while($rs_invite2 = $db->db_fetch_array($query_invite2)){
		$db->query("USE ".$EWT_DB_USER);
		$sql_staff = "select title.title_thai,name_thai,surname_thai from gen_user inner join title on gen_user.title_thai = title.title_id where gen_user_id = '$rs_invite2[person_id]' ";
		$query_staff = $db->query($sql_staff);
		$fetch_staff = $db->db_fetch_array($query_staff);
		if($fetch_staff[name_thai]){ $name_staff .= $fetch_staff[title_thai]." ".$fetch_staff[name_thai]." ".$fetch_staff[surname_thai].","; }

		//กรณีเป็นหน่วยงาน
		$sql_division = "select * from org_name where org_id = '$rs_invite2[division_id]' ";
		$query_division = $db->query($sql_division);
		$fetch_division = $db->db_fetch_array($query_division);
		if($fetch_division[name_org]){ $name_division .= $fetch_division[name_org].",";}
		$db->query("USE ".$EWT_DB_NAME);
	}
	$name_staff = substr($name_staff,0,-1);
	if(trim($name_staff) == ''){ $name_staff =' -'; }
	
		$event_show_start = explode('-', $fetch_dis['event_show_start']);
		$event_show_end = explode('-', $fetch_dis['event_show_end']);
		$html_show .= date('j', mktime(0, 0, 0, $event_show_start[1], $event_show_start[2], $event_show_start[0])).'&nbsp;';
		$html_show_end .= date('j', mktime(0, 0, 0, $event_show_end[1], $event_show_end[2], $event_show_end[0])).'&nbsp;';
		
		switch($event_show_start[1]) {
			case 1:  $html_show .= "มกราคม"; break;
			case 2:  $html_show .= "กุมภาพันธ์"; break;
			case 3:  $html_show .= "มีนาคม"; break;
			case 4:  $html_show .= "เมษายน"; break;
			case 5:  $html_show .= "พฤษภาคม"; break;
			case 6:  $html_show .= "มิถุนายน"; break;
			case 7:  $html_show .= "กรกฏาคม"; break;
			case 8:  $html_show .= "สิงหาคม"; break;
			case 9:  $html_show .= "กันยายน"; break;
			case 10:  $html_show .= "ตุลาคม"; break;
			case 11:  $html_show .= "พฤศจิกายน"; break;
			case 12:  $html_show .= "ธันวาคม"; break;
		}
		switch($event_show_end[1]) {
			case 1:  $html_show_end .= "มกราคม"; break;
			case 2:  $html_show_end .= "กุมภาพันธ์"; break;
			case 3:  $html_show_end .= "มีนาคม"; break;
			case 4:  $html_show_end .= "เมษายน"; break;
			case 5:  $html_show_end .= "พฤษภาคม"; break;
			case 6:  $html_show_end .= "มิถุนายน"; break;
			case 7:  $html_show_end .= "กรกฏาคม"; break;
			case 8:  $html_show_end .= "สิงหาคม"; break;
			case 9:  $html_show_end .= "กันยายน"; break;
			case 10:  $html_show_end .= "ตุลาคม"; break;
			case 11:  $html_show_end .= "พฤศจิกายน"; break;
			case 12:  $html_show_end .= "ธันวาคม"; break;
		}
		$html_show .= '&nbsp;'.(date('Y', mktime(0, 0, 0, $event_show_start[1], $event_show_start[2], $event_show_start[0]))+543);
		$html_show_end .= '&nbsp;'.(date('Y', mktime(0, 0, 0, $event_show_end[1], $event_show_end[2], $event_show_end[0]))+543);
	
	?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="right"></td>
    <td height="5"></td>
    <td></td>
  </tr>
  <tr>
    <td align="right"><img src="mainpic/border_24.jpg" width="12" height="32" /></td>
    <td height="30" background="mainpic/border_25.jpg"><img src="<?php echo $path_cal;?>mainpic/icon_news.gif" border="0"   align="absmiddle">รายละเอียดกิจกรรม</td>
    <td><img src="mainpic/border_28.jpg" width="12" height="32" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td width="30%" align="right" valign="top" nowrap>หัวข้อกิจกรรม : </td>
        <td width="70%" valign="top"><?php print $fetch_dis['event_title'];?></td>
      </tr>
      <tr>
        <td align="right" valign="top" nowrap>เวลา : </td>
        <td valign="top"><?php print $html;?> </td>
      </tr>
      <tr>
        <td align="right" valign="top" nowrap>รายละอียด : </td>
        <td valign="top"><?php print $fetch_dis['event_detail'];?></td>
      </tr>
      <tr>
        <td align="right" valign="top" nowrap>ผู้ที่เกี่ยวข้อง  : </td>
        <td valign="top"><?php $name_staff = ereg_replace(',',"<br>",$name_staff); echo $name_staff;?></td>
      </tr>
      <tr>
        <td align="right" valign="top" nowrap>วันเริ่มต้น - วันสิ้นสุดการแสดง  : </td>
        <td valign="top"><?php print $html_show;?> - <?php print $html_show_end;?> </td>
      </tr>
      <tr>
        <td align="right" valign="top" nowrap><?php if($fetch_dis[event_registor] == '1'){ ?>สมัครเข้าร่วมกิจกรรม<?php } ?></td>
        <td valign="top">
		<?php	if($fetch_dis[event_registor] == 1 && $fetch_dis[event_registor_type] == '') { ?><a href="#RG" onClick="window.open('calendar_registor.php?event_id=<?php echo $_GET['event_id'];?>','registor','width=800 , height=750, scrollbars=1,resizable = 0');"><img src="mainpic/icon_news.gif" alt="สมัครเข้าร่วมสัมมนา" width="21" height="21" border="0" align="absmiddle"></a><?php } ?>
		<?php	if($fetch_dis['event_registor'] == 1 && $fetch_dis['event_registor_type'] == '1' && $_SESSION["EWT_MID"] != '') { ?>			
							<a href="registor_view_personal.php?event_id=<?php echo $fetch_dis['event_id'];?>" target="registor_form">[<img src="<?php echo $path_cal;?>mainpic/icon_news.gif" border="0"   align="absmiddle"><?php echo $text_Gencalendar_registor3;?>]</a>
					<?php } ?>		
					<?php	if($fetch_dis['event_registor'] == 1  && $fetch_dis['event_registor_type'] == '1' && $_SESSION["EWT_MID"] == '') { ?>	
						[<img src="<?php echo $path_cal;?>mainpic/icon_news.gif" border="0"   align="absmiddle">กรุณา login เพื่อสมัครเข้าร่วมการสัมมนา]
						<?php } ?>			</td>
      </tr>

    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td height="44" align="center" valign="bottom"><input type="button" name="Button" value="ปิดหน้าต่างนี้"  onClick="window.close();"></td>
    <td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="44" align="center" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="bottom"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="bottom"><?php echo $txt_website_of_name1;?></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
 <iframe name="registor_form" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
</body>
</html>
