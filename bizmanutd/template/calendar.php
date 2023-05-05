<?php
	session_start();
	header ("Content-Type:text/html;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	
	//==========================================================
	if($BID){ $BID = checkNumeric($BID); }
	if($_GET["BID"]){ $_GET["BID"] = checkNumeric($_GET["BID"]); }
	if($_POST["BID"]){ $_POST["BID"] = checkNumeric($_POST["BID"]); }
	if($_REQUEST["BID"]){ $_REQUEST["BID"] = checkNumeric($_REQUEST["BID"]); }
	
	if($sh){ $sh = checkPttVar($sh); }
	if($_GET["sh"]){ $_GET["sh"]=checkPttVar($_GET["sh"]); }
	if($_POST["sh"]){ $_POST["sh"]=checkPttVar($_POST["sh"]); }
	
	if($namefolder){
		$namefolder=checkPttVar($namefolder);
	}
	if($_GET["namefolder"]){
		$_GET["namefolder"]=checkPttVar($_GET["namefolder"]);
	}
	if($_POST["namefolder"]){
		$_POST["namefolder"]=checkPttVar($_POST["namefolder"]);	
	}
    //===========================================================
	
	$mainwidth  = 0;
	$path_cal = "";
	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$lang_sh1 = explode('_',$sh);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
	if($rec[block_themes]!= '0'){
	//echo $filename = temp_type1;
	$namefolder = "themes".($rec[block_themes]);
	//@include("themesdesign/configthemes.php");
	@include("themesdesign/".$namefolder."/".$namefolder.".php");
	 //if($themes_type == 'F'){
	if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
 		$buffer = "";
 		$fd = @fopen ($Current_Dir1.$themes_file, "r");
		 while (!@feof ($fd)) {
			$buffer .= @fgets($fd, 4096);
	 	}
 		@fclose ($fd);
		$design = explode('<?php#htmlshow#?>',$buffer);
	 }
	 $head_test = "ปฏิทินกิจกรรม";
	 //body
	$content_background_color = $body_color;
	$content_font_color = $body_font_color; 
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
	
	//head
	$head_background_color = $head_color; 
	$head_background_color2 = $Current_Dir1.$head_img;
	$head_height = $head_height;
	$head_font_color = $head_font_color; 
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
	}else{
	$head_test = "<img src=\"mainpic/calendar/head_calendar.jpg\" />";
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
	$head_background_color2 = '';
	$head_height = '';
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
	$bg_width = '100%'; 
	$table_height = '100%'; 

	$head_link_color = "#666666"; 
	$font_family = "Tahoma"; 
	}
	$dayname = array ($text_Gencalendar_san,$text_Gencalendar_mon,$text_Gencalendar_thu,$text_Gencalendar_wed,$text_Gencalendar_tre,$text_Gencalendar_fri,$text_Gencalendar_sat );

	$monthname =  array($text_Gencalendar_m1, $text_Gencalendar_m2, $text_Gencalendar_m3,$text_Gencalendar_m4, $text_Gencalendar_m5, $text_Gencalendar_m6, $text_Gencalendar_m7,$text_Gencalendar_m8, $text_Gencalendar_m9,$text_Gencalendar_m10, $text_Gencalendar_m11, $text_Gencalendar_m12); 

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
	$y_y= 0;
	if($lang_sh == ''){
	$y_y= '543';
	}
	$table_caption_prev = $monthname[$previous_month-1] . " " . ($year+$y_y); 
	$table_caption = $monthname[date("n",$date_string)-1] . " " . ($year+$y_y); 
	$table_caption_foll = $monthname[$next_month-1] . " " . ($year+$y_y);
	//echo $bg_width; 
?>
	<table cellspacing="0" cellpadding="0" width="100%" border="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $bg_img;?>">
		<tbody>
			<tr>
				<td width="100%">
					<table border="<?php echo $table_border; ?>" cellpadding="<?php echo $table_cellpadding; ?>" cellspacing="<?php echo $table_cellspacing; ?>" style="height:<?php echo $table_height; ?>" width="<?php echo $table_width; ?>"> 
						<tr> 
							<td align="center" class="cal_head<?php echo $BID;?>"><a class="cal_head<?php echo $BID;?>" href="javascript:void(0);" onClick="change_calendar<?php echo $BID;?>('<?php echo $previous_date; ?>','<?php echo $BID;?>');" title="<?php echo $table_caption_prev; ?>">&laquo;</a></td> 
							<td align="center" class="cal_head<?php echo $BID;?>" colspan="5"><?php echo $table_caption; ?></td> 
							<td align="center" class="cal_head<?php echo $BID;?>"><a class="cal_head<?php echo $BID;?>" href="javascript:void(0);" onClick="change_calendar<?php echo $BID;?>('<?php echo $next_date; ?>','<?php echo $BID;?>');" title="<?php echo $table_caption_foll; ?>">&raquo;</a></td> 
						</tr> 
						<tr align=center> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[0]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[1]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[2]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[3]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[4]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[5]; ?></td> 
							<td class="cal_days<?php echo $BID;?>"><?php echo $dayname[6]; ?></td> 
						</tr>
						<tr>
							<?php 
								for( $i = 0 ; $i < $day_start; $i++ ) { ?><td class="cal_content<?php echo $BID;?>" >&nbsp;</td><?php } 
								$current_position = $day_start; //The current (column) position of the current day from the loop 
								$total_days_in_month = date("t",$date_string); //The total days in the month for the end of the loop 
								if($_SESSION["EWT_MID"]) {
									$where1 = " AND (((cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' OR cal_invite.person_id = '".$_SESSION["EWT_MID"]."' OR cal_invite.division_id = '".$_SESSION["EWT_ORG"]."')) OR (cal_event.event_private = '2'))";
									$where2 = " AND (cal_event.event_user_id = '".$_SESSION["EWT_MID"]."') ";
								} else {
									$where1 = " AND (cal_event.event_private = '2')";
								}
								for( $i = 1; $i <= $total_days_in_month ; $i++) { 
									$class = "cal_content".$BID; 
									$date = $year."-".sprintf("%02d", $month)."-".sprintf("%02d", $i);
									if( $i == date("j") && $month == date("n") && $year == date("Y") ) $class = "cal_today".$BID; 
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
											(cal_event.event_date_start <= '".$date."' and  cal_event.event_date_end >= '".$date."') and 
											((cal_show_event.event_show_start <= '".date('Y-m-d')."' OR cal_show_event.event_show_start = '0000-00-00') and  (cal_show_event.event_show_end >= '".date('Y-m-d')."' OR cal_show_event.event_show_end = '0000-00-00')) 
											 $where1 
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
										$class = "cal_info".$BID; 
										if( $i == date("j") && $month == date("n") && $year == date("Y") ) $class = "cal_today".$BID; 
										$a1 = '<a  href="javascript:void(0);" onClick="window.open(\'main_calendar.php?sh='.$sh.'&display_date='.$linkdate.'\',\'\',\'width=900 , height=650, scrollbars=1,resizable = 1\');" >';
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
									$html_show .= '&nbsp;'.$text_Gencalendar_textpsyear.(date('Y', mktime(0, 0, 0, $data_show[1], $data_show[2], $data_show[0]))+$y_y);
									?><td align="center" class="<?php echo $class; ?>">
									<?php if($chk_num_rows>0) { ?><span class="tips"   title="<?php echo $html_show; ?>|
								<table width='100%' border='0' cellspacing='0' cellpadding='2'>
									<?php
										$query = $db->query($sql);
										while($row_event = $db->db_fetch_array($query)) {
												$html = "";
												$start_time = explode(':', $row_event['event_time_start']);
												$end_time = explode(':', $row_event['event_time_end']);
												$end_ampm = $text_Gencalendar_textpm;
												$start_ampm = $text_Gencalendar_textpm;
												if(($row_event['event_date_start'] != $row_event['event_date_end']) && ($row_event['event_date_end'] != '0000-00-00') && ($row_event['event_all_day'] != '1')) {
													$html .= date('j', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4))).'&nbsp;';
													switch(substr($row_event['event_date_start'], 5, 2)) {
														case 1:  $html .=$text_Gencalendar_m1; break;
														case 2:  $html .=$text_Gencalendar_m2; break;
														case 3:  $html .=$text_Gencalendar_m3; break;
														case 4:  $html .= $text_Gencalendar_m4; break;
														case 5:  $html .= $text_Gencalendar_m5; break;
														case 6:  $html .= $text_Gencalendar_m6; break;
														case 7:  $html .= $text_Gencalendar_m7; break;
														case 8:  $html .=$text_Gencalendar_m8; break;
														case 9:  $html .=$text_Gencalendar_m9; break;
														case 10:  $html .=$text_Gencalendar_m10; break;
														case 11:  $html .=$text_Gencalendar_m11; break;
														case 12:  $html .= $text_Gencalendar_m12; break;
													}
													$html .= '&nbsp;';
													$html .= (date('Y', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))+$y_y);
													$html .= '&nbsp;';
													//$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."";
													if(sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm != '00:00'.$start_ampm){
													$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
													}
													$html .= "&nbsp;-&nbsp;";
													$html .= date('j', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4))).'&nbsp;';
													switch(substr($row_event['event_date_end'], 5, 2)) {
														case 1:  $html .=$text_Gencalendar_m1; break;
														case 2:  $html .=$text_Gencalendar_m2; break;
														case 3:  $html .=$text_Gencalendar_m3; break;
														case 4:  $html .= $text_Gencalendar_m4; break;
														case 5:  $html .= $text_Gencalendar_m5; break;
														case 6:  $html .= $text_Gencalendar_m6; break;
														case 7:  $html .= $text_Gencalendar_m7; break;
														case 8:  $html .=$text_Gencalendar_m8; break;
														case 9:  $html .=$text_Gencalendar_m9; break;
														case 10:  $html .=$text_Gencalendar_m10; break;
														case 11:  $html .=$text_Gencalendar_m11; break;
														case 12:  $html .= $text_Gencalendar_m12; break;
													}
													$html .= '&nbsp;';
													$html .= (date('Y', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)))+$y_y);
													$html .= '&nbsp;';
													//$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
													if(sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm != '00:00'.$end_ampm){
													$html .= '&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
													}
													if($html == ''){
													$html .= 'ไม่ระบุเวลา';
													}
												} else {
													if($row_event['event_time_start'] == '00:00:00' && $row_event['event_time_start'] == '00:00:00') {
														$html .= $text_Gencalendar_textallday ;
													} else {
														if(($row_event['event_all_day'] != '1')) {
															if(sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm != '00:00'.$start_ampm){
															$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
															}
															if(sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm != '00:00'.$end_ampm){
															$html .= ' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
															}
														} else {
															$html .= $text_Gencalendar_textallday ;
														}
													}
												}
									 		if($lang_shw != ''){
										 	$event_title = select_lang_detail($row_event['event_id'],$lang_shw,'event_title','cal_event');
											if($event_title != ''){$row_event['event_title']=$event_title;} 
											}
									?>
										<tr>
											<td valign='top' width='12' align='center'><img src='<?php echo $path_cal;?>mainpic/colorrange.gif' border='0' width='8' height='8' align='absmiddle' style='padding: 0; border-style:solid; border-color:#000000; background:<?php echo $row_event['cat_color'] ?>'></td>
											<td valign='top' width='350'><strong><?php echo nl2br($row_event['event_title']);?>&nbsp;(<?php echo $html;?>)</strong></td>
										</tr>
										<tr>
											<td valign='top' width='12' align='center'></td>
											<td valign='top' width='350'><strong><?php if($row_event['event_registor']=='1' && $set_calendar_registor=='Y'){ echo "[<img src='".$path_cal."mainpic/icon_news.gif'   align='absmiddle' >รับสมัครเข้าร่วมสัมมนา]";}?></strong></td>
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
							<td class="cal_content<?php echo $BID;?>"></td>
							<?php } ?>
						</tr>
						<tr>
							<td class="cal_days<?php echo $BID;?>"  colspan="7" align="center"><span style="cursor:hand"  onmouseover="this.style.color='#FF0000';" onMouseOut="this.style.color='#333333';" onClick="window.open('calendar_month.php?sh=<?php echo $sh;?>','','width=900 , height=650, scrollbars=1,resizable = 1');"><?php echo $text_Gencalendar_textview;?></span></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr><td></td></tr>
		</tbody>
	</table>

<?php $db->db_close(); ?>
