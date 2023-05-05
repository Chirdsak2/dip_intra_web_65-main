<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	//===========================================================================================
	if($sh){ $sh = checkPttVar($sh); }
	if($_GET["sh"]){ $_GET["sh"]=checkPttVar($_GET["sh"]); }
	if($_POST["sh"]){ $_POST["sh"]=checkPttVar($_POST["sh"]); }
	
	if($orderby){ $orderby=checkPttVar($orderby); }
	if($_GET["orderby"]){ $_GET["orderby"]=checkPttVar($_GET["orderby"]); }
	if($_POST["orderby"]){ $_POST["orderby"]=checkPttVar($_POST["orderby"]); }
	
	if($BID){ $BID = checkNumeric($BID); }
	if($_GET["BID"]){ $_GET["BID"] = checkNumeric($_GET["BID"]); }
	if($_POST["BID"]){ $_POST["BID"] = checkNumeric($_POST["BID"]); }
	if($_REQUEST["BID"]){ $_REQUEST["BID"] = checkNumeric($_REQUEST["BID"]); }
	
	if($txtsearch){ $txtsearch= checkPttSearch($txtsearch); }
	if($_GET['txtsearch']){ $_GET['txtsearch']= checkPttSearch($_GET['txtsearch']); }
	if($_POST['txtsearch']){ $_POST['txtsearch']= checkPttSearch($_POST['txtsearch']); }
	if($_REQUEST['txtsearch']){ $_REQUEST['txtsearch']= checkPttSearch($_REQUEST['txtsearch']); }

	if($display_date){ $display_date = checkDates($display_date); }
	if($_GET["display_date"]){ $_GET["display_date"] = checkDates($_GET["display_date"]); }
	if($_POST["display_date"]){ $_POST["display_date"] = checkDates($_POST["display_date"]); }	
	//============================================================================================
	include ('calendar_function.php');
	
	// Calendra Config Categories
	 $a=array();
	$query_calg = $db->query("SELECT * FROM cal_config WHERE BID='$BID' ");
	if($db->db_num_rows($query_calg)>0){
		   $data = $db->db_fetch_array($query_calg);
		   if($data[cal_group]!=""){
			  $a=explode(',',$data[cal_group]);
			  $wh_cat=" AND (cal_event.cat_id= '$a[0]' ";
			  for($k=1;$k<sizeof($a);$k++){ 
				  $wh_cat.=" OR cal_event.cat_id= '$a[$k]' ";
			  }
			   $wh_cat.=" )";
		   }
	}
	
	$path_cal = "";
	$lang_sh1 = explode('_',$sh);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
	if($_GET['display_date']) { $display_date = $_GET['display_date']; }

	if(!isset($display_date)) {
		$display_date = date('Y-m-d');
		$cur_date = date('d');
		$cur_month = date('m');
		$cur_year = date('Y');
	} else {
		$cur_date = substr($display_date, 8, 2);
		$cur_month = substr($display_date, 5, 2);
		$cur_year = substr($display_date, 0, 4);
	}
	$next_date = date('Y-m-d', mktime(0, 0, 0, $cur_month, $cur_date+1, $cur_year));
	$prev_date = date('Y-m-d', mktime(0, 0, 0, $cur_month, $cur_date-1, $cur_year));
	$next_month = date('Y-m-d', mktime(0, 0, 0, $cur_month+1, 1, $cur_year));
	$prev_month = date('Y-m-d', mktime(0, 0, 0, $cur_month-1, 1, $cur_year));

	$firstdateinmonth = date('w', mktime(0, 0, 0, $cur_month, 1, $cur_year));
	if($firstdateinmonth > 0) {
		$firstdateincalendar = date('Y-m-d', mktime(0, 0, 0, $cur_month, 1-($firstdateinmonth-1), $cur_year));
	} else {
		$firstdateincalendar = date('Y-m-d', mktime(0, 0, 0, $cur_month, 1-6, $cur_year));
	}
	$first_date = substr($firstdateincalendar, 8, 2);
	$first_month = substr($firstdateincalendar, 5, 2);
	$first_year = substr($firstdateincalendar, 0, 4);

	$lastdateinmonth = date('w', mktime(0, 0, 0, $cur_month+1, 0, $cur_year));
	if($lastdateinmonth > 0) {
		$lastdateincalendar = date('Y-m-d', mktime(0, 0, 0, $cur_month+1, 0+(7-$lastdateinmonth), $cur_year));
	} else {
		$lastdateincalendar = date('Y-m-d', mktime(0, 0, 0, $cur_month+1, 0, $cur_year));
	}
	$last_date = substr($lastdateincalendar, 8, 2);
	$last_month = substr($lastdateincalendar, 5, 2);
	$last_year = substr($lastdateincalendar, 0, 4);

	if(!isset($_GET[year])) { $cur_year = date('Y'); }else{ $cur_year = $_GET[year]; }

	$page = $_POST[page];
	if(!$limit) $limit = 5;
	if($page == '' || $page < 1) $page =1;
	$page1 = $page-1;
	if($page1 == '' || $page1 < 0) $page1 = 0;
	if(!$orderby){ $orderby = "event_id"; } else { $orderby = $orderby; }
	if($deasc == 'DESC') { $deasc = 'ASC'; } else { $deasc = 'DESC'; }
	if($_SESSION["EWT_MID"]) {
		$where1 = " AND (((cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' OR cal_invite.person_id = '".$_SESSION["EWT_MID"]."' OR cal_invite.division_id = '".$_SESSION["EWT_ORG"]."')) OR (cal_event.event_private = '2'))";
		$where2 = " AND (cal_event.event_user_id = '".$_SESSION["EWT_MID"]."') ";
	} else {
		$where1 = " AND (cal_event.event_private = '2')";
	}
	$sql_group_event  ="
		select 
			cal_event.event_date_start, cal_event.event_date_end 
		from 
			cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id 
			inner join cal_category on cal_category.cat_id = cal_event.cat_id 
			left join cal_invite on cal_event.event_id = cal_invite.event_id 
		where ";
			//(cal_event.event_date_start <= '".date('Y-m-d', mktime(0, 0, 0, 12, 31, $cur_year))."' and  cal_event.event_date_end >= '".date('Y-m-d', mktime(0, 0, 0, 1, 1, $cur_year))."') and 
		$sql_group_event  .="(cal_event.event_date_start <= '".date('Y-m-d', mktime(0, 0, 0, 12, 31, $cur_year))."' and  cal_event.event_date_end >= '".date('Y-m-d', mktime(0, 0, 0, 1, 1, $cur_year))."') ";
		if($_REQUEST['txtsearch']!='') {
			$sql_group_event.='AND (cal_event.event_title LIKE \'%'.$_REQUEST['txtsearch'].'%\' OR cal_event.event_detail LIKE \'%'.$_REQUEST['txtsearch'].'%\') ';
		}
		$sql_group_event.="group by cal_show_event.event_date_start, cal_show_event.event_date_end  
		order by cal_event.event_date_start desc, cal_event.event_date_end desc";
	//echo $sql_group_event;
	$result_group_event = $db->query($sql_group_event);
	$array_group_date = array();
	while($row_group_event = $db->db_fetch_array($result_group_event)) {
		array_push($array_group_date, array($row_group_event[event_date_start], $row_group_event[event_date_end]));
	}
	$y_y= 0;
	if($lang_sh == ''){
	$y_y= '543';
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/interface.css" rel="stylesheet" type="text/css">
<link href="css/normal.css" rel="stylesheet" type="text/css">
<link href="css/jquery.cluetip.css" rel="stylesheet" type="text/css">
<?php
include("ewt_script.php");	
?>
<script language="javascript">
	function order_field(deasc,orderby){
		document.frm1.deasc.value=deasc;
		document.frm1.orderby.value=orderby;
		document.frm1.submit();
	}

	$(document).ready(
		function() {
			$('span[@title]').cluetip({
				splitTitle: '|', 
				width: '500px',
				arrows: true, 
				dropShadow: false, 
				cluetipClass: 'jtip'}
			);
			//$('a.text_head').cluetip({cluetipClass: 'jtip', arrows: true, dropShadow: true, hoverIntent: false});
		}
	);
</script>
</head>
<body leftmargin="0" topmargin="0">
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="frm1" action="" method="post">
	<input type="hidden" name="deasc" value="<?php echo $deasc?>">
	<input type="hidden" name="orderby" value="<?php echo $orderby?>">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="margin-left:0px; margin-right:5px;" nowrap="nowrap">
						<span class="text_head"><?php echo  $head_test ;?></span>
						<hr width="100%" size="1"  align="left"  color="#D8D2BD">
						<span class="text_normal">
							<?php if($_SESSION["EWT_MID"] && $_SESSION["EWT_ORG"] != 0) { ?><a href="javascript:void(0);" class="text_eng" onClick="window.open('calendar_addevent.php?sh=<?php echo $sh;?>&BID=<?php echo $BID;?>','','width=800 , height=580, location=0');"><img src="<?php echo $path_cal;?>mainpic/calendar/add_calendar.jpg" style="cursor:hand" align="absmiddle" border="0" width="16" height="16">&nbsp;<?php echo $text_Gencalendar_textaddactivity;?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php } ?>
							<a href="main_calendar.php?display_date=<?php echo $display_date;?>&sh=<?php echo $sh;?>&BID=<?php echo $BID;?>" class="text_eng"><img src="<?php echo $path_cal;?>mainpic/calendar/icon_calendar.jpg" style="cursor:hand" align="absmiddle" border="0" width="16" height="16">&nbsp;<?php echo $text_Gencalendar_textday;?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
							<a href="calendar_week.php?display_date=<?php echo $display_date;?>&sh=<?php echo $sh;?>&BID=<?php echo $BID;?>" class="text_eng"><img src="<?php echo $path_cal;?>mainpic/calendar/icon_calendar.jpg" style="cursor:hand" align="absmiddle" border="0" width="16" height="16">&nbsp;<?php echo $text_Gencalendar_textweek;?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
							<a href="calendar_month.php?display_date=<?php echo $display_date;?>&sh=<?php echo $sh;?>&BID=<?php echo $BID;?>" class="text_eng"><img src="<?php echo $path_cal;?>mainpic/calendar/icon_calendar.jpg" style="cursor:hand" align="absmiddle" border="0" width="16" height="16">&nbsp;<?php echo $text_Gencalendar_textmonth;?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
							<a href="calendar_year.php?display_date=<?php echo $display_date;?>&sh=<?php echo $sh;?>&BID=<?php echo $BID;?>" class="text_eng"><img src="<?php echo $path_cal;?>mainpic/calendar/icon_calendar.jpg" style="cursor:hand" align="absmiddle" border="0" width="16" height="16">&nbsp;<?php echo $text_Gencalendar_textyear;?></a><!--&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; -->
						</span><br/>
                        <p class="text_normal" style="text-align:right;"><input type="text" name="txtsearch" id="txtsearch" value="<?php echo $_REQUEST['txtsearch']; ?>" />&nbsp;<input type="button" onClick="window.location.href='calendar_year.php?display_date=<?php echo $display_date;?>&sh=<?php echo $sh;?>&BID=<?php echo $BID;?>&txtsearch='+document.getElementById('txtsearch').value;" value="ค้นหา" /></p>
						<hr width="100%" size="1"  align="left"  color="#D8D2BD">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CECECE">
				<tr>
					<td bgcolor="#E7E7E7">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="right"><a href="calendar_year.php?year=<?php echo ($cur_year-1);?>&sh=<?php echo $sh;?>"><img src="<?php echo $path_cal;?>mainpic/calendar/navi_left.gif" style="cursor:hand" align="absmiddle" border="0"></a></td>
								<td align="center" width="500">
									<span class="text_head">
										<?php echo  $head_test ;?>
										<?php//php echo $text_Gencalendar_textofday;?>
										<?php echo $text_Gencalendar_textpsyear;?>&nbsp;<?php echo $cur_year+$y_y; ?></span>								</td>
								<td align="left"><a href="calendar_year.php?year=<?php echo ($cur_year+1);?>&sh=<?php echo $sh;?>"><img src="<?php echo $path_cal;?>mainpic/calendar/navi_right.gif" style="cursor:hand" align="absmiddle" border="0"></a></td>
							</tr>
						</table>
					</td>
				</tr>
				<?php
					$date = $display_date;
					if(count($array_group_date) > 0) {
						for($i = 0; $i< count($array_group_date); $i++) {
					$sql_event  ="
						select 
							cal_event.*, cal_show_event.event_date_start, cal_show_event.event_date_end, cal_category.cat_name, 
							cal_category.cat_color, cal_show_event.event_show_end, cal_show_event.event_show_start, cal_show_event.main_event_id_repeat, cal_event.main_event_id_repeat  
						from 
							cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id 
							inner join cal_category on cal_category.cat_id = cal_event.cat_id 
							left join cal_invite on cal_event.event_id = cal_invite.event_id 
						where 
							(cal_event.event_date_start = '".$array_group_date[$i][0]."' and cal_event.event_date_end = '".$array_group_date[$i][1]."') and 
							((cal_show_event.event_show_start <= '".date('Y-m-d')."' OR cal_show_event.event_show_start = '0000-00-00' ) and  (cal_show_event.event_show_end >= '".date('Y-m-d')."' OR cal_show_event.event_show_end = '0000-00-00'  )) 
							$where1  $wh_cat
						group by event_id 
						order by cal_event.event_time_start desc, cal_event.event_time_end desc, cal_event.event_title";
					$result_event= $db->query($sql_event);
					if($db->db_num_rows($result_event) > 0) {
				?>
				<tr height="25" bgcolor="#DDDDDD">
					<td>
					<?php
						if($array_group_date[$i][0] == $array_group_date[$i][1]) {
							$data_show = explode("-", $array_group_date[$i][0]);
					?>&nbsp;<?php echo date('j', mktime(0, 0, 0, $data_show[1], $data_show[2], $data_show[0]))?>&nbsp;<?php 
							switch($data_show[1]) {
								case 1:  echo $text_Gencalendar_m1; break;
								case 2:  echo $text_Gencalendar_m2; break;
								case 3:  echo $text_Gencalendar_m3; break;
								case 4:  echo $text_Gencalendar_m4;break;
								case 5:  echo $text_Gencalendar_m5; break;
								case 6:  echo $text_Gencalendar_m6; break;
								case 7:  echo $text_Gencalendar_m7; break;
								case 8:  echo $text_Gencalendar_m8; break;
								case 9:  echo $text_Gencalendar_m9; break;
								case 10:  echo $text_Gencalendar_m10; break;
								case 11:  echo $text_Gencalendar_m11; break;
								case 12:  echo $text_Gencalendar_m12; break;
							}
					?>&nbsp;<span class="text_head"><?php echo $text_Gencalendar_textpsyear;?></span>&nbsp;<?php echo (date('Y', mktime(0, 0, 0, $data_show[1], $data_show[2], $data_show[0]))+$y_y);?><?php
						} else {
							$data_show1 = explode("-", $array_group_date[$i][0]);
							$data_show2 = explode("-", $array_group_date[$i][1]);
					?>&nbsp;<?php echo date('j', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0]))?>&nbsp;<?php 
							switch($data_show1[1]) {
									case 1:  echo $text_Gencalendar_m1; break;
								case 2:  echo $text_Gencalendar_m2; break;
								case 3:  echo $text_Gencalendar_m3; break;
								case 4:  echo $text_Gencalendar_m4;break;
								case 5:  echo $text_Gencalendar_m5; break;
								case 6:  echo $text_Gencalendar_m6; break;
								case 7:  echo $text_Gencalendar_m7; break;
								case 8:  echo $text_Gencalendar_m8; break;
								case 9:  echo $text_Gencalendar_m9; break;
								case 10:  echo $text_Gencalendar_m10; break;
								case 11:  echo $text_Gencalendar_m11; break;
								case 12:  echo $text_Gencalendar_m12; break;
							}
							?>&nbsp;<span class="text_head"><?php echo $text_Gencalendar_textpsyear;?></span>&nbsp;<?php echo (date('Y', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0]))+$y_y);?>&nbsp;-&nbsp;&nbsp;<?php echo date('j', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0]))?>&nbsp;<?php 
							switch($data_show2[1]) {
								case 1:  echo $text_Gencalendar_m1; break;
								case 2:  echo $text_Gencalendar_m2; break;
								case 3:  echo $text_Gencalendar_m3; break;
								case 4:  echo $text_Gencalendar_m4;break;
								case 5:  echo $text_Gencalendar_m5; break;
								case 6:  echo $text_Gencalendar_m6; break;
								case 7:  echo $text_Gencalendar_m7; break;
								case 8:  echo $text_Gencalendar_m8; break;
								case 9:  echo $text_Gencalendar_m9; break;
								case 10:  echo $text_Gencalendar_m10; break;
								case 11:  echo $text_Gencalendar_m11; break;
								case 12:  echo $text_Gencalendar_m12; break;
							}
							?>&nbsp;<span class="text_head"><?php echo $text_Gencalendar_textpsyear;?></span>&nbsp;<?php echo (date('Y', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0]))+$y_y);?>
					<?php
						}
					?>					</td>
				</tr>
				<?php
					while($row_event = $db->db_fetch_array($result_event)) {
						$html = "";
						$start_time = explode(':', $row_event['event_time_start']);
						$end_time = explode(':', $row_event['event_time_end']);
						$end_ampm = $text_Gencalendar_textpm;
						$start_ampm = $text_Gencalendar_textpm;
						if(($row_event['event_date_start'] != $row_event['event_date_end']) && ($row_event['event_date_end'] != '0000-00-00') && ($row_event['event_all_day'] != '1')) {
							//$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."";
							if(sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm != '00:00'.$start_ampm){
							$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
							}
							
							//$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
							if(sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm != '00:00'.$end_ampm){
							$html .= "&nbsp;-&nbsp;";
							$html .= '&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
							}
							if($html == ''){
													$html .= 'ไม่ระบุเวลา';
													}
						} else {
							if($row_event['event_time_start'] == '00:00:00' && $row_event['event_time_start'] == '00:00:00') {
								$html .=$text_Gencalendar_textallday ;
							} else {
								if(($row_event['event_all_day'] != '1')) {
									if(sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm != '00:00'.$start_ampm){
									$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
									}
									if(sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm != '00:00'.$end_ampm){
									$html .= ' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
									}
									
								} else {
									$html .=$text_Gencalendar_textallday ;
								}
							}
						}
						$sql_select_viewer = "select * from cal_event where event_id = '".$row_event['event_id']."'";
						$result_viewer = $db->query($sql_select_viewer);
						$row_viewer = $db->db_fetch_array($result_viewer);
						$current_viewer = $row_viewer[color_id];
						$sql_update_viewer = "update cal_event set color_id = '".($current_viewer+1)."' where event_id = '".$row_event['event_id']."'";
						$result_viewer = $db->query($sql_update_viewer);
	
						$sql_invite  = "select * from cal_invite where event_id = '".$row_event['event_id']."' ";
						$query_invite = $db->query($sql_invite);
						$name_staff = '';
						$name_division = '';
						while($rs_invite = $db->db_fetch_array($query_invite)){
							if($rs_invite[person_id]){$id_staff.=$rs_invite[person_id].",";}
							if($rs_invite[division_id]){$id_division.=$rs_invite[division_id].",";}
							$db->query("USE ".$EWT_DB_USER);
							//กรณีเป็นคน
							$sql_staff = "select title.title_thai,name_thai,surname_thai from gen_user inner join title on gen_user.title_thai = title.title_id where gen_user_id = '$rs_invite[person_id]' ";
							$query_staff = $db->query($sql_staff);
							$fetch_staff = $db->db_fetch_array($query_staff);
							if($fetch_staff[name_thai]){ 
								if($lang_shw != ''){
								$title_thai =select_lang_detail_ewt($fetch_staff[title_id],$lang_shw,"title_thai","title");
								$name_thai=select_lang_detail_ewt($rs_invite[person_id],$lang_shw,"name_thai","gen_user");
								$surname_thai=select_lang_detail_ewt($rs_invite[person_id],$lang_shw,"surname_thai","gen_user");
								if($title_thai != ''){$fetch_staff[title_thai] =$title_thai;}
								if($name_thai != ''){$fetch_staff[name_thai] =$name_thai;}
								if($surname_thai != ''){$fetch_staff[surname_thai] =$surname_thai;}
								}
								$name_staff.=$fetch_staff[title_thai]." ".$fetch_staff[name_thai]." ".$fetch_staff[surname_thai].",";}
						
							//กรณีเป็นหน่วยงาน
							$sql_division = "select * from org_name where org_id = '$rs_invite[division_id]' ";
							$query_division = $db->query($sql_division);
							$fetch_division = $db->db_fetch_array($query_division);
							if($fetch_division[name_org]){ 
								if($lang_shw != ''){
								$org_name =select_lang_detail_ewt($rs_invite[division_id],$lang_shw,"name_org","org_name");
								if($org_name != ''){$fetch_division[name_org] =$org_name;}
								}
								$name_division.=$fetch_division[name_org].",";}
							
							$db->query("USE ".$EWT_DB_NAME);
							//$name_staff.="name".$rs_invite[person_id].",";
						}
						$name_staff = substr($name_staff, 0, -1);
						$name_division = substr($name_division, 0, -1);
						include("lib/connect_uncheck.php");
						$sql_user = "select * from gen_user where gen_user_id='".$row_event['event_user_id']."'";
						$query_user = mysql_query($sql_user);
						$row_user = mysql_fetch_array($query_user);
						$sql_title = "select * from title where title_id='".$row_user['title_thai']."'";
						$query_title = mysql_query($sql_title);
						$row_title = mysql_fetch_array($query_title);
						$sql_org = "select * from org_name where org_id='".$row_user['org_id']."'";
						$query_org = mysql_query($sql_org);
						$row_org = mysql_fetch_array($query_org);
						include("lib/user_config.php");
						include("lib/connect.php");
						if($row_event['event_show_start'] == '0000-00-00' && $row_event['event_show_end'] == '0000-00-00') {
							$html_show = $text_Gencalendar_textallday ;
						} else {
							$html_show = '';
							$data_show1 = explode("-", $row_event['event_show_start']);
							$data_show2 = explode("-", $row_event['event_show_end']);
							if($row_event['event_show_start'] == '0000-00-00') {
							} else {
								$html_show .= date('j', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0])).'&nbsp;';
								switch($data_show1[1]) {
									case 1:  $html_show .= $text_Gencalendar_m1; break;
										case 2:  $html_show .= $text_Gencalendar_m2; break;
										case 3:  $html_show .= $text_Gencalendar_m3; break;
										case 4:  $html_show .=$text_Gencalendar_m4; break;
										case 5:  $html_show .= $text_Gencalendar_m5; break;
										case 6:  $html_show .= $text_Gencalendar_m6; break;
										case 7:  $html_show .= $text_Gencalendar_m7; break;
										case 8:  $html_show .=$text_Gencalendar_m8; break;
										case 9:  $html_show .= $text_Gencalendar_m9; break;
										case 10:  $html_show .= $text_Gencalendar_m10; break;
										case 11:  $html_show .= $text_Gencalendar_m11; break;
										case 12:  $html_show .= $text_Gencalendar_m12; break;
								}
								$html_show .= (date('Y', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0]))+$y_y);
								if($row_event['event_show_end'] == '0000-00-00') {
								} else {
									$html_show .= '&nbsp;-&nbsp;';
								}
							}
							if($row_event['event_show_end'] == '0000-00-00') {
							} else {
								$html_show .= date('j', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0])).'&nbsp;';
								switch($data_show2[1]) {
									case 1:  $html_show .= $text_Gencalendar_m1; break;
										case 2:  $html_show .= $text_Gencalendar_m2; break;
										case 3:  $html_show .= $text_Gencalendar_m3; break;
										case 4:  $html_show .=$text_Gencalendar_m4; break;
										case 5:  $html_show .= $text_Gencalendar_m5; break;
										case 6:  $html_show .= $text_Gencalendar_m6; break;
										case 7:  $html_show .= $text_Gencalendar_m7; break;
										case 8:  $html_show .=$text_Gencalendar_m8; break;
										case 9:  $html_show .= $text_Gencalendar_m9; break;
										case 10:  $html_show .= $text_Gencalendar_m10; break;
										case 11:  $html_show .= $text_Gencalendar_m11; break;
										case 12:  $html_show .= $text_Gencalendar_m12; break;
								}
								$html_show .= (date('Y', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0]))+$y_y);
							}
						}
						 if($lang_shw != ''){
						  $catname = select_lang_detail($row_event['cat_id'],$lang_shw,'cat_name','cal_category');
						 $event_title = select_lang_detail($row_event['event_id'],$lang_shw,'event_title','cal_event');
						 $event_detail = select_lang_detail($row_event['event_id'],$lang_shw,'event_detail','cal_event');
						  	if($catname != ''){$row_event['cat_name']=$catname;} 
						  	if($event_title != ''){$row_event['event_title']=$event_title;} 
						    if($event_detail != ''){$row_event['event_detail']=$event_detail;} 
						  }
				?>
				<tr bgcolor="#FFFFFF" height="25">
					<td>
						<img src="<?php echo $path_cal;?>mainpic/colorrange.gif" border="0" width="8" height="8" align="absmiddle" style="padding: 0; border-style:solid; border-color:#000000; background:<?php echo $row_event['cat_color'] ?>">
						<span class="text_head" title="<?php echo nl2br($row_event['event_title']);?>|<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td valign='top' width='150'><strong><?php echo $text_Gencalendar_textcatactivity;?>&nbsp;:</strong></td><td valign='top'><?php echo nl2br($row_event['cat_name']);?></td></tr><tr><td valign='top'><strong><?php echo $text_Gencalendar_texttime;?>&nbsp;:</strong></td><td valign='top'><?php echo $html;?></td></tr><tr><td valign='top'><strong><?php echo $text_Gencalendar_textdetailactivity;?>&nbsp;:</strong></td><td valign='top'><?php  echo htmlspecialchars($row_event['event_detail']);?></td></tr><tr><td valign='top'><strong><?php echo $text_Gencalendar_textaccessory;?>&nbsp;:</strong></td><td valign='top'><?php  echo $name_staff; ?></td></tr><tr><td valign='top'><strong><?php echo $text_Gencalendar_textbccessory;?>&nbsp;:</strong></td><td valign='top'><?php  echo $name_division;?></td></tr><tr><td valign='top'><strong><?php echo $text_Gencalendar_texttdayshow;?>&nbsp;:</strong></td><td valign='top'><?php echo $html_show ?></td></tr></table>"> 
						<!--<a class="text_head" href="calendar_detail.php?event_id=<?php echo nl2br($row_event['event_id']);?>" rel="calendar_detail.php?event_id=<?php echo nl2br($row_event['event_id']);?>" title="<?php echo nl2br($row_event['event_title']);?>"><span class="text_head"> --><?php echo nl2br($row_event['event_title']);?></span><!--</a> -->&nbsp;(<?php echo $html;?>)&nbsp;
						<?php if($row_event[event_link]) { ?><img src="mainpic/document_view.gif" align="absmiddle" alt="ดู" onClick="window.open('calendar_view_link.php?flag=link&img_name=<?php echo $row_event[event_link]?>','calendar_view_link','width=500 , height=400,scrollbars=1,resizable = 1'); " style="cursor:hand"><?php } ?>
					<?php if($_SESSION["EWT_MID"] == $row_event['event_user_id']) {
						if($row_event['main_event_id_repeat'] == 0) { ?>
                      <a href="calendar_editevent.php?event_id=<?php echo $row_event['event_id'];?>&ref=yes&sh=<?php echo $sh;?>"><img src="<?php echo $path_cal?>mainpic/calendar_edit.gif" alt="Edit Event" width="16" height="16" border="0" align="absmiddle">&nbsp; <?php echo $text_general_edit;?> </a>&nbsp; <a href="javascript:if(confirm('คุณต้องการจะลบ Event นี้')) {
																					window.location.href = 'calendar_process.php?event_id=<?php echo $row_event['event_id'];?>&Flag=Del&ref=yes&sh=<?php echo $sh;?>';
																					}"><img src="<?php echo $path_cal?>mainpic/calendar_delete.gif" alt="Delete Event" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $text_general_del;?></a>
                      <?php
																					} 	?>
						<?php	if($row_event['event_registor'] == 1 && $set_calendar_registor=='Y' && $row_event['event_registor_type'] == '') { ?>	
						<a href="registor_view.php?event_id=<?php echo $row_event['event_id'];?>"><img src="../theme/main_theme/g_view.gif" alt="รายชื่อผู้สมัคร" border="0"></a>
						<?php } ?>
						<?php	if($row_event['event_registor'] == 1 && $set_calendar_registor=='Y' && $row_event['event_registor_type'] == '1' && $_SESSION["EWT_MID"] != '') { ?>	
						<a href="registor_view_personal.php?event_id=<?php echo $row_event['event_id'];?>" target="registor_form"><img src="../theme/main_theme/g_view.gif" alt="รายชื่อผู้สมัคร" border="0"></a>
						<?php } ?>
						<?php
					 }//End $_SESSION
																					?>
								<?php	if($row_event['event_registor'] == 1 && $set_calendar_registor=='Y' && $row_event['event_registor_type'] == '') { ?>			
							<a href="#RG" onClick="window.open('calendar_registor.php?event_id=<?php echo $row_event['event_id'];?>','registor','width=800 , height=750, scrollbars=1,resizable = 0');">[<img src="<?php echo $path_cal;?>mainpic/icon_news.gif" border="0"   align="absmiddle"><?php echo $text_Gencalendar_registor3;?>]</a>
					<?php } ?>
					<?php	if($row_event['event_registor'] == 1 && $set_calendar_registor=='Y' && $row_event['event_registor_type'] == '1' && $_SESSION["EWT_MID"] != '') { ?>	
						<a href="registor_view_personal.php?event_id=<?php echo $row_event['event_id'];?>" target="registor_form">[<img src="<?php echo $path_cal;?>mainpic/icon_news.gif" border="0"   align="absmiddle"><?php echo $text_Gencalendar_registor3;?>]</a>
						<?php } ?>
						<?php	if($row_event['event_registor'] == 1 && $set_calendar_registor=='Y' && $row_event['event_registor_type'] == '1' && $_SESSION["EWT_MID"] == '') { ?>	
						[<img src="<?php echo $path_cal;?>mainpic/icon_news.gif" border="0"   align="absmiddle">กรุณา login เพื่อสมัครเข้าร่วมการสัมมนา]
						<?php } ?>		</td>
				</tr>
				<?php
						}
					}
				}
			}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr><td style="margin-left:0px; margin-right:5px;" nowrap="nowrap"><hr width="100%" size="1"  align="left"  color="#D8D2BD"></td></tr>
			</table>
		</td>
	</tr>
	<?php if($num_rows_2>0 && $chk_num_rows2>0) { ?>
	<tr>
		<td  colspan="6" align="right">
			<table width="100%" border="0" align="left" cellpadding="3" cellspacing="1">
				<tr>
					<td height="30" scope="col" ><div align="left"><?php echo $text_general_numpage;?>
					  <input type="text" name="limit"  size="5" value="<?php echo $limit?>">
					  <input name="button" type="button" onClick="document.frm1.submit();" value="<?php echo $text_general_changepage;?>">
					</div></td>
					<td height="30" scope="col"><div align="right"><?php echo $text_general_page;?>
					  <select name="page" onChange="document.frm1.submit();">
					    <?php
						for($i=1;$i<=$page_all;$i++){
						if($i == $page) $selected = "selected";
						else $selected = "";
						print "<option value=\"$i\" $selected>$i</option>";
						}
						?>
				      </select>
					  /
					  <?php echo $page_all?>
					  <?php echo $text_general_page;?>&nbsp;</div></td>
				</tr>
			</table>
		</td>
	</tr>
	<?php } ?>
</form>
</table>
 <iframe name="registor_form" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
</body>
</html>
<?php $db->db_close(); ?>
