<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	$path_cal = "";
	$content_background_color = "#EBECE2"; 
	$content_font_color = "#333333"; 
	$content_font_size = 11; 
	$content_font_style = "normal"; 
	$content_font_weight = "normal"; 

	$today_background_color = "#FFDB4F"; 
	$today_font_color = "#8B4513"; 
	$today_font_size = 11; 
	$today_font_style = "normal"; 
	$today_font_weight = "normal"; 

	$info_background_color = "#FB9D15"; 
	//$info_background_color = "#F4F4F4"; 
	$info_font_color = "#3467FF"; 
	$info_font_size = 11; 
	$info_font_style = "normal"; 
	$info_font_weight = "bold"; 

	$head_background_color = "#EBECE2"; 
	$head_font_color = "#8B4513"; 
	$head_font_size = 11; 
	$head_font_style = "normal"; 
	$head_font_weight = "normal"; 

	$days_head_background_color = "#EBECE2"; 
	$days_head_font_color = "#CD7305"; 
	$days_head_font_size = 11; 
	$days_head_font_style = "normal"; 
	$days_head_font_weight = "normal"; 

	$table_border = 0; 
	$table_cellspacing = 1; 
	$table_cellpadding = 1; 
	$table_width = '100%'; 
	$table_height = '100%'; 

	$head_link_color = "#666666"; 
	$font_family = "Tahoma"; 
	$dayname = array ("อา.","จ.","อ.","พ.","พฤ.","ศ.","ส.");

	$monthname =  array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"); 

	if( isset( $_GET['date'] ) ) list($month,$year) = explode("-",$_GET['date']); 
	else { 
		$month = date("m"); 
		$year = date("Y"); 
	} 

	$date_string = mktime(0,0,0,$month,1,$year); //The date string we need for some info... saves space ^_^ 

	$day_start = date("w",$date_string); //The number of the 1st day of the week 

	//print $_SERVER['QUERY_STRING'];
	/*$QUERY_STRING = ereg_replace("&date=".$month."-".$year,"",$_SERVER['QUERY_STRING']); */

	if( $month < 12 ) { 
		$next_month = $month+1; 
		$next_date = $next_month."-".$year; 
	} else { 
		$next_year = $year+1; 
		$next_date = "1-".$next_year; 
		$next_month = 1; 
	} 

	if( $month > 1 ) { 
		$previous_month = $month-1; 
		$next_month = $month+1; 
		$previous_date = $previous_month."-".$year; 
	} else { 
		$previous_year = $year-1; 
		$previous_date = "12-".$previous_year; 
		$previous_month = 12; 
	} 

	$table_caption_prev = $monthname[$previous_month-1] . " " . ($year+543); 
	$table_caption = $monthname[date("n",$date_string)-1] . " " . ($year+543); 
	$table_caption_foll = $monthname[$next_month-1] . " " . ($year+543); 
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/jquery.cluetip.css" rel="stylesheet" type="text/css">
<style type="text/css"> 
	A { COLOR: #0066FF; TEXT-DECORATION: none }
	A:hover { TEXT-DECORATION: underline }
	A.underlined { TEXT-DECORATION: underline }
	A.underlined:visited { TEXT-DECORATION: underline }
	a.cal_head { color: <?php echo $head_link_color; ?>; } 
	a.cal_head:hover { text-decoration: none; } 
	.cal_head { 
		background-color: <?php echo $head_background_color; ?>; 
		color: <?php echo $head_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $head_font_size; ?>; 
		font-weight: <?php echo $head_font_weight; ?>; 
		font-style: <?php echo $head_font_style; ?>; 
	} 
	.cal_days { 
		background-color: <?php echo $days_head_background_color; ?>; 
		color: <?php echo $days_head_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $days_head_font_size; ?>; 
		font-weight: <?php echo $days_head_font_weight; ?>; 
		font-style: <?php echo $days_head_font_style; ?>; 
	} 
	.cal_content { 
		background-color: <?php echo $content_background_color; ?>; 
		color: <?php echo $content_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $content_font_size; ?>; 
		font-weight: <?php echo $content_font_weight; ?>; 
		font-style: <?php echo $content_font_style; ?>; 
	} 
	.cal_today { 
		background-color: <?php echo $today_background_color; ?>; 
		color: <?php echo $today_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $today_font_size; ?>; 
		font-weight: <?php echo $today_font_weight; ?>; 
		font-style: <?php echo $today_font_style; ?>; 
	} 
	.cal_info { 
		background-color: <?php echo $info_background_color; ?>; 
		color: <?php echo $info_font_color; ?>; 
		font-family: <?php echo $font_family; ?>; 
		font-size: <?php echo $info_font_size; ?>; 
		font-weight: <?php echo $info_font_weight; ?>; 
		font-style: <?php echo $info_font_style; ?>; 
	} 
</style> 
<script src="js/excute.js"></script>
<script src="js/jquery/jquery-1.2.2.min.js" type="text/javascript"></script>
<script src="js/jquery/jquery.dimensions.js" type="text/javascript"></script>
<script src="js/jquery/jquery.hoverIntent.js" type="text/javascript"></script>
<script src="js/jquery/jquery.cluetip.js" type="text/javascript"></script>
<script language="javascript">
$(document).ready(
	function() {
		$('span[@title]').cluetip({
			splitTitle: '|', 
			width: '370px',
			arrows: true, 
			dropShadow: false, 
			cluetipClass: 'jtip'}
		);
	}
);
</script>
</head>
<body leftmargin="0" topmargin="0" bgcolor="#F7F7F7">
	<table cellspacing="0" cellpadding="0" width="200" border="0">
		<tbody>
			<tr><td height="20" align="center" bgcolor="#864420"><img src="mainpic/calendar/head_calendar.jpg" /></td></tr>
			<tr>
				<td width="100%">
					<table border="<?php echo $table_border; ?>" cellpadding="<?php echo $table_cellpadding; ?>" cellspacing="<?php echo $table_cellspacing; ?>" style="height:<?php echo $table_height; ?>" width="<?php echo $table_width; ?>"> 
						<tr> 
							<td align="center" class="cal_head"><a class="cal_head" href="<?php echo $_SERVER['PHP_SELF']; ?>?date=<?php echo $previous_date; ?>" title="<?php echo $table_caption_prev; ?>">&laquo;</a></td> 
							<td align="center" class="cal_head" colspan="5"><?php echo $table_caption; ?></td> 
							<td align="center" class="cal_head"><a class="cal_head" href="<?php echo $_SERVER['PHP_SELF']; ?>?date=<?php echo $next_date; ?>" title="<?php echo $table_caption_foll; ?>">&raquo;</a></td> 
						</tr> 
						<tr align=center> 
							<td class="cal_days"><?php echo $dayname[0]; ?></td> 
							<td class="cal_days"><?php echo $dayname[1]; ?></td> 
							<td class="cal_days"><?php echo $dayname[2]; ?></td> 
							<td class="cal_days"><?php echo $dayname[3]; ?></td> 
							<td class="cal_days"><?php echo $dayname[4]; ?></td> 
							<td class="cal_days"><?php echo $dayname[5]; ?></td> 
							<td class="cal_days"><?php echo $dayname[6]; ?></td> 
						</tr>
						<tr>
							<?php 
								for( $i = 0 ; $i < $day_start; $i++ ) { ?><td class="cal_content">&nbsp;</td><?php } 
								$current_position = $day_start; //The current (column) position of the current day from the loop 
								$total_days_in_month = date("t",$date_string); //The total days in the month for the end of the loop 
								if($_SESSION["EWT_MID"]) {
									$where1 = " OR cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' OR cal_invite.person_id = '".$_SESSION["EWT_MID"]."' ";
									$where2 = " OR cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' ";
								}
								for( $i = 1; $i <= $total_days_in_month ; $i++) { 
									$class = "cal_content"; 
									$date = $year."-".$month."-".$i;
									if( $i == date("j") && $month == date("n") && $year == date("Y") ) $class = "cal_today"; 
									/*
									$sql = "select *,cal_show_event.event_show_end,cal_show_event.event_show_start from cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id left join cal_invite on cal_event.event_id = cal_invite.event_id 
									where (cal_show_event.event_date_start <= '".$date."' and  cal_show_event.event_date_end >= '".$date."')  
									and  ((cal_show_event.event_show_start <= '".$date."' OR cal_show_event.event_show_start = '0000-00-00' $bbbb ) and  (cal_show_event.event_show_end >= '".$date."' OR cal_show_event.event_show_end = '0000-00-00' $bbbb ))  
									and (cal_event.event_private = '2' $aaaa ) 
									";
									*/
									$sql = "
										select 
											cal_event.*, cal_show_event.event_date_start, cal_show_event.event_date_end, cal_category.cat_name, 
											cal_category.cat_color, cal_show_event.event_show_end, cal_show_event.event_show_start
										from 
											cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id 
											inner join cal_category on cal_category.cat_id = cal_event.cat_id 
											left join cal_invite on cal_event.event_id = cal_invite.event_id 
										where 
											(cal_show_event.event_date_start <= '".$date."' and  cal_show_event.event_date_end >= '".$date."') and 
											((cal_show_event.event_show_start <= '".$date."' OR cal_show_event.event_show_start = '0000-00-00' $where2 ) and  (cal_show_event.event_show_end >= '".$date."' OR cal_show_event.event_show_end = '0000-00-00' $where2 )) and 
											(cal_event.event_private = '2' $where1 ) 
										group by cal_event.event_id  
										order by cal_show_event.event_date_start, cal_show_event.event_date_end";
									$query = $db->query($sql);
									$num_rows = $db->db_num_rows($query);
									$chk_num_rows = 0;
									for($chk_i=0;$chk_i<$num_rows;$chk_i++) {
										$row_event_show = $db->db_fetch_array($query);
										if((($row_event_show[event_show_end] >= $date) || !isset($row_event_show[event_show_end]) || $row_event_show[event_show_end] == "0000-00-00") ){
											if( ( $row_event_show[event_show_start] <= $date  ||  !isset($row_event_show[event_show_start]) || $row_event_show[event_show_start] == "0000-00-00" ) ){
												$chk_num_rows++;
											}
										}
									}
									if($chk_num_rows>0) {
										$linkdate = sprintf("%04d",$year).'-'.sprintf("%02d",$month).'-'.sprintf("%02d",$i);
										$class = "cal_info"; 
										if( $i == date("j") && $month == date("n") && $year == date("Y") ) $class = "cal_today"; 
										$a1 = '<a  href="javascript:void(0);" onClick="window.open(\'main_calendar.php?display_date='.$linkdate.'\',\'\',\'width=900 , height=650, scrollbars=1,resizable = 1\');">';
										$a2 = '</a>';
									}else{
										$a1='';
										$a2='';
									}
									$current_position++; 
									$data_show = explode("-", $date);
									$html_show = '';
									$html_show .= date('j', mktime(0, 0, 0, $data_show[1], $data_show[2], $data_show[0])).'&nbsp;';
									switch($data_show[1]) {
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
									$html_show .= '&nbsp;พ.ศ.'.(date('Y', mktime(0, 0, 0, $data_show[1], $data_show[2], $data_show[0]))+543);
									?><td align="center" class="<?php echo $class; ?>">
									<?php if($chk_num_rows>0) { ?><span title="<?php echo $html_show; ?>|
									<table width='100%' border='0' cellspacing='0' cellpadding='2'>
									<?php
										$query = $db->query($sql);
										while($row_event = $db->db_fetch_array($query)) {
												$html = "";
												$start_time = explode(':', $row_event['event_time_start']);
												$end_time = explode(':', $row_event['event_time_end']);
												$end_ampm = " น.";
												$start_ampm = " น.";
												if(($row_event['event_date_start'] != $row_event['event_date_end']) && ($row_event['event_date_end'] != '0000-00-00') && ($row_event['event_all_day'] != '1')) {
													$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."";
													$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
													$html .= "&nbsp;-&nbsp;";
													$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
													$html .= '&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
												} else {
													if($row_event['event_time_start'] == '00:00:00' && $row_event['event_time_start'] == '00:00:00') {
														$html .= "ไม่ระบุเวลา";
													} else {
														if(($row_event['event_all_day'] != '1')) {
															$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
														} else {
															$html .= "ตลอดวัน";
														}
													}
												}
									?>
										<tr>
											<td valign='top' width='12' align='center'><img src='<?php echo $path_cal;?>mainpic/colorrange.gif' border='0' width='8' height='8' align='absmiddle' style='padding: 0; border-style:solid; border-color:#000000; background:<?php echo $row_event['cat_color'] ?>'></td>
											<td valign='top' width='350'><strong><?php echo nl2br($row_event['event_title']);?>&nbsp;(<?php echo $html;?>)</strong></td>
										</tr>
									<?php
										}
									?>
									</table>"><?php } ?><?php echo $a1.$i.$a2; ?><?php if($chk_num_rows>0) { ?></span><?php } ?></td><?php  
									if( $current_position == 7 ){ 
										?></tr><tr><?php
										$current_position = 0; 
									} 
								} 
	
								$end_day = 7-$current_position; //There are 
	
								for( $i = 0 ; $i < $end_day ; $i++ )  {
							?>
							<td class="cal_content"></td>
							<?php } ?>
						</tr>
						<tr>
							<td class="cal_days"  colspan="7" align="center"><span style="cursor:hand"  onmouseover="this.style.color='#FF0000';" onMouseOut="this.style.color='#333333';" onClick="window.open('calendar_month.php','','width=900 , height=650, scrollbars=1,resizable = 1');">ดูปฏิทินทั้งหมด</span></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr><td></td></tr>
		</tbody>
	</table>
<!--<input type="button" name="Submit" value="back" onClick="location.href  = 'main_calendar.php';">-->
</body>
</html>
<?php $db->db_close(); ?>
