<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include ('calendar_function.php');
	
	$sql_detail = "select * from cal_event, cal_category where event_id = '".$_GET['event_id']."' and cal_category.cat_id = cal_event.cat_id";
	$result_detail= $db->query($sql_detail);
	$row_detail = $db->db_fetch_array($result_detail);
	$html = "";
	$start_time = explode(':', $row_detail['event_time_start']);
	$end_time = explode(':', $row_detail['event_time_end']);
	$end_ampm = " เธ.";
	$start_ampm = " เธ.";
	if(($row_detail['event_date_start'] != $row_detail['event_date_end']) && ($row_detail['event_date_end'] != '0000-00-00') && ($row_detail['event_all_day'] != '1')) {
		$html .= date('M j ', mktime(0, 0, 0, substr($row_detail['event_date_start'], 5, 2), substr($row_detail['event_date_start'], 8, 2), substr($row_detail['event_date_start'], 0, 4)))."";
		$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
		$html .= "&nbsp;-&nbsp;";
		$html .= date('M j ', mktime(0, 0, 0, substr($row_detail['event_date_end'], 5, 2), substr($row_detail['event_date_end'], 8, 2), substr($row_detail['event_date_end'], 0, 4)));
		$html .= '&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
	} else {
		if($row_detail['event_time_start'] == '00:00:00' && $row_detail['event_time_start'] == '00:00:00') {
			$html .= "เนเธกเนเธฃเธฐเธเธธเน€เธงเธฅเธฒ";
		} else {
			if(($row_detail['event_all_day'] != '1')) {
				$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
			} else {
				$html .= "เธ•เธฅเธญเธ”เธงเธฑเธ";
			}
		}
	}
	include("lib/connect_uncheck.php");
	$sql_user = "select * from gen_user where gen_user_id='".$row_detail['event_user_id']."'";
	$query_user = mysql_query($sql_user);
	$row_user = mysql_fetch_array($query_user);
	$sql_org = "select * from org_name where org_id='".$row_user['org_id']."'";
	$query_org = mysql_query($sql_org);
	$row_org = mysql_fetch_array($query_org);
	include("lib/user_config.php");
	include("lib/connect.php");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>เธเธฃเธฐเน€เธ เธ—</td>
        <td><?php echo nl2br(utf8_encode($row_detail['cat_name']));?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo $html; ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>