<?php
	function list_event_month($date) {
		global $db;
		global $LOGID;
		
		$first_date = substr($date, 8, 2);
		$first_month = substr($date, 5, 2);
		$first_year = substr($date, 0, 4);
		if($_SESSION["EWT_MID"]) 
		$aaaa = " OR cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' 
						  OR cal_invite.person_id = '".$_SESSION["EWT_MID"]."' 
						  OR cal_invite.division_id = '".$_SESSION["EWT_ORG"]."'   ";

		$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='3'>";
		//$sql_event  = "select *,cal_show_event.event_date_start,cal_show_event.event_date_end from cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id where (cal_show_event.event_date_start <= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date+0+$i, $first_year))."' and  cal_show_event.event_date_end >= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date+0+$i, $first_year))."') and cal_event.event_user_id = '".$_SESSION["EWT_MID"]."'  order by cal_show_event.event_date_start,event_all_day,event_time_start";
		$sql_event  = "select *,cal_event.event_id,cal_show_event.event_date_start,cal_show_event.event_date_end from cal_event  inner join cal_category on cal_event.cat_id = cal_category.cat_id  inner join cal_show_event on cal_event.event_id = cal_show_event.event_id  left join cal_invite on cal_event.event_id = cal_invite.event_id
		where (cal_show_event.event_date_start <= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date+0+$i, $first_year))."' and  cal_show_event.event_date_end >= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date+0+$i, $first_year))."') 
		and ( cal_event.event_private = '2' $aaaa ) group by cal_event.event_id order by cal_show_event.event_date_start,event_all_day,event_time_start,event_title";
		$result_event = $db->query($sql_event);
		if($db->db_num_rows($result_event) > 0) {
			while($row_event = $db->db_fetch_array($result_event)) {
				
				  	/*if($row_event[event_user_id] != $_SESSION["EWT_MID"]){
						$chk_num_rows = false;
					}*/
					if($row_event[event_user_id] != $_SESSION["EWT_MID"] 
						AND $row_event[person_id] != $_SESSION["EWT_MID"]){ 
						$chk_num_rows = false;
					}else{
					   $chk_num_rows = true;
					}

					if((($row_event[event_show_end] >= date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date+0+$i, $first_year))) || !isset($row_event[event_show_end]) || $row_event[event_show_end] == "0000-00-00") ){
						if( ( $row_event[event_show_start] <= date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date+0+$i, $first_year))  ||  !isset($row_event[event_show_start]) || $row_event[event_show_start] == "0000-00-00" ) ){
								$chk_num_rows = true;
								$chk_num_rows2++;
						}
					}

				if($chk_num_rows ){
				$sql_cate  = "select * from cal_color where color_id = '".$row_event['color_id']."'";
				$result_cate = $db->query($sql_cate);
				$row_cate = $db->db_fetch_array($result_cate);
				$html .= '<tr><td width="5" rowspan="2" bgcolor="'.$row_event['cat_color'].'"> </td><td class="back_small">';
				$start_time = explode(':', $row_event['event_time_start']);
				/*if($start_time[0] > 12) {
					$start_hour = $start_time[0] -12;
					$start_ampm = 'pm';
				} else {
					$start_hour = $start_time[0];
					$start_ampm = 'am';
				}*/
				$end_time = explode(':', $row_event['event_time_end']);
				/*if($end_time[0] > 12) {
					$end_hour = $end_time[0] -12;
					$end_ampm = 'pm';
				} else {
					$end_hour = $end_time[0];
					$end_ampm = 'am';
				}*/
				$start_ampm = $end_ampm = ' น.';
				if(($row_event['event_date_start'] != $row_event['event_date_end']) && ($row_event['event_date_end'] != '0000-00-00') && ($row_event['event_all_day'] != '1') && false) {
						$html .= date('M j', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."&nbsp;";
						//if($row_event['event_time_type'] == 'N') {
							$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
						//}
						$html .= "&nbsp;-&nbsp;";
						$html .= date('M j', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
						//if($row_event['event_time_type'] == 'N') {
							$html .= '&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
						//}
				} else {
					//if(($row_event['event_time_start'] != $row_event['event_time_end']) && ($row_event['event_all_day'] != '1')) {
					if(($row_event['event_all_day'] != '1')) {
						$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.' -<br>'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
					} else {
						$html .= "All Day Event";
					}
				}
				$html .= '</td>';
				$html .= '</tr>';
				$html .= '<tr>';
				$html .= '<td class="back_small"><a href="javascript:void(0);" onClick="window.open(\'calendar_event_view.php?event_id='.$row_event['event_id'].'&ref=yes\',\'\',\'width=800 , height=580, scrollbars=1,resizable = 1\');"><span style="color:#0000FF"  onMouseOver="this.style.color=\'#FF0000\'" onMouseOut = "this.style.color=\'#0000FF\'" >'.nl2br($row_event['event_title']).'</span></a></td>';
				$html .= '</tr>';
				}
			}
		}//end while
		$html .= '</table>';
		
		return $html;
	}
	
	function list_event_week($date) {
		global $db;
		global $LOGID;
		
		$first_date = substr($date, 8, 2);
		$first_month = substr($date, 5, 2);
		$first_year = substr($date, 0, 4);
		if($_SESSION["EWT_MID"]) 
		   $aaaa = " OR cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' 
						  OR cal_invite.person_id = '".$_SESSION["EWT_MID"]."' 
						  OR cal_invite.division_id = '".$_SESSION["EWT_ORG"]."'   ";

		$html .= '<table width="100%" border="0" cellspacing="0" cellpadding="3">';
		/*$sql_event  = "select * from cal_event where (event_date_start <= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date, $first_year))."' and  event_date_end >= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date, $first_year))."') and event_creatorid = '$LOGID'";*/
		//$sql_event  = "select *,cal_show_event.event_date_start,cal_show_event.event_date_end from cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id  where (cal_show_event.event_date_start <= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date, $first_year))."' and  cal_show_event.event_date_end >= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date, $first_year))."') and cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' order by cal_show_event.event_date_start,event_all_day,event_time_start";
		$sql_event  = "select *,cal_event.event_id,cal_show_event.event_date_start,cal_show_event.event_date_end from cal_event  inner join cal_category on cal_event.cat_id = cal_category.cat_id  inner join cal_show_event on cal_event.event_id = cal_show_event.event_id left join cal_invite on cal_event.event_id = cal_invite.event_id  where (cal_show_event.event_date_start <= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date, $first_year))."' and  cal_show_event.event_date_end >= '".date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date, $first_year))."') 
		and (cal_event.event_private = '2' $aaaa) group by cal_event.event_id order by cal_show_event.event_date_start,event_all_day,event_time_start,event_title";
		$result_event = $db->query($sql_event);
		if($db->db_num_rows($result_event) > 0) {
			while($row_event = $db->db_fetch_array($result_event)) {
			
				/*if($row_event[event_user_id] != $_SESSION["EWT_MID"]){
						$chk_num_rows = false;
					}*/
					if($row_event[event_user_id] != $_SESSION["EWT_MID"] 
						AND $row_event[person_id] != $_SESSION["EWT_MID"]){ 
						$chk_num_rows = false;
					}else{
					   $chk_num_rows = true;
					}

					if((($row_event[event_show_end] >= date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date, $first_year))) || !isset($row_event[event_show_end]) || $row_event[event_show_end] == "0000-00-00") ){
						if( ( $row_event[event_show_start] <= date('Y-m-d', mktime(0, 0, 0, $first_month, $first_date, $first_year))  ||  !isset($row_event[event_show_start]) || $row_event[event_show_start] == "0000-00-00" ) ){
								$chk_num_rows = true;
								$chk_num_rows2++;
						}
					}

				if($chk_num_rows ){
				
				$sql_cate  = "select * from cal_color where color_id = '".$row_event['color_id']."'";
				$result_cate = $db->query($sql_cate);
				$row_cate = $db->db_fetch_array($result_cate);
				$html .= '<tr>';
				$html .= '<td width="16" bgcolor="'.$row_event['cat_color'].'"> </td>';
				$html .= '<td width="110">';
				$start_time = explode(':', $row_event['event_time_start']);
				/*if($start_time[0] > 12) {
					$start_hour = $start_time[0] -12;
					$start_ampm = 'pm';
				} else {
					$start_hour = $start_time[0];
					$start_ampm = 'am';
				}*/
				$end_time = explode(':', $row_event['event_time_end']);
				/*if($end_time[0] > 12) {
					$end_hour = $end_time[0] -12;
					$end_ampm = 'pm';
				} else {
					$end_hour = $end_time[0];
					$end_ampm = 'am';
				}*/
				$start_ampm = $end_ampm = " น.";
				if(($row_event['event_date_start'] != $row_event['event_date_end']) && ($row_event['event_date_end'] != '0000-00-00') && ($row_event['event_all_day'] != '1')) {
						$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."&nbsp;";
						//if($row_event['event_time_type'] == 'N') {
							//$html .= sprintf('%02d', $start_hour).':'.sprintf('%02d', $start_time[1]).$start_ampm;
							$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
						//}
						$html .= "&nbsp;-<br>";
						$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
						//if($row_event['event_time_type'] == 'N') {
							//$html .= '&nbsp;'.sprintf('%02d', $end_hour).':'.sprintf('%02d', $end_time[1]).$end_ampm;
							$html .= '&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
						//}
				} else {
					//if(($row_event['event_time_start'] != $row_event['event_time_end']) && ($row_event['event_all_day'] != '1')) {
					if(($row_event['event_all_day'] != '1')) {
						//$html .= sprintf('%02d', $start_hour).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_hour).':'.sprintf('%02d', $end_time[1]).$end_ampm;
						$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.'- '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
					} else {
						$html .= "All Day Event";
					}
				}
				$html .= '</td>';
				$html .= '<td><a href="javascript:void(0);" onClick="window.open(\'calendar_event_view.php?event_id='.$row_event['event_id'].'\',\'\',\'width=800 , height=580,scrollbars=1,resizable = 1\');"><span style="color:#0000FF"  onMouseOver="this.style.color=\'#FF0000\'" onMouseOut = "this.style.color=\'#0000FF\'" >'.nl2br($row_event['event_title']).'</span></a></td>';
				$html .= '</tr>';
				}
			}
		}//end while
		$html .= '</table>';
		
		return $html;
	}
	function list_event_year($month,$year){
		global $db;
		global $LOGID;
		global $path_cal;
		$html.= '<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" align="center">';
        $html.= '    <tr>';
        $html.= '      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">';
        $html.= '          <tr>';
        $html.= '            <td height="6" width="7"><img src="'.$path_cal.'mainpic/head_left.gif" width="7" height="6"></td>';
        $html.= '            <td bgcolor="#5599CC"></td>';
        $html.= '            <td height="6" width="7"><img src="'.$path_cal.'mainpic/head_right.gif" width="7" height="6"></td>';
        $html.= '          </tr>';
        $html.= '          <tr>';
        $html.= '            <td height="30" width="7" bgcolor="#5599CC"></td>';
        $html.= '            <td valign="middle" bgcolor="#5599CC" height="30"><div align="center"><span class="head_calendar">'.date(' M , Y', mktime(0, 0, 0, $month, "01", $year));
        $html.= '            </span></div></td>';
        $html.= '            <td height="30" width="7" bgcolor="#5599CC"></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td>';
	if($_SESSION["EWT_MID"]) 
		$aaaa = " OR cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' 
						  OR cal_invite.person_id = '".$_SESSION["EWT_MID"]."' 
						  OR cal_invite.division_id = '".$_SESSION["EWT_ORG"]."'   ";

																$date1 = "$year-$month-01";
																$enddateinmonth = date('t', mktime(0, 0, 0, $month, 1, $year));
																$date2 = "$year-$month-$enddateinmonth";
																//$sql_event  = "select *,cal_show_event.event_date_start,cal_show_event.event_date_end from cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id  where (cal_show_event.event_date_start between '".$date1."' AND '".$date2."') and cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' order by cal_show_event.event_date_start,event_all_day,event_time_start";
																$sql_event  = "select *,cal_event.event_id,cal_show_event.event_date_start,cal_show_event.event_date_end from cal_event  inner join cal_category on cal_event.cat_id = cal_category.cat_id  inner join cal_show_event on cal_event.event_id = cal_show_event.event_id  left join cal_invite on cal_event.event_id = cal_invite.event_id  where (cal_show_event.event_date_start between '".$date1."' AND '".$date2."') 
																and (cal_event.event_private = '2' $aaaa ) group by cal_event.event_id order by cal_show_event.event_date_start,event_all_day,event_time_start,event_title";
																$result_event = $db->query($sql_event);
																//print $db->db_num_rows($result_event);
																$num_row_event  = $db->db_num_rows($result_event);
																if($num_row_event > 0) {
																	while($row_event = $db->db_fetch_array($result_event)) {
																	
																	/*if($row_event[event_user_id] != $_SESSION["EWT_MID"]){
																		$chk_num_rows = false;
																	}*/
																	if($row_event[event_user_id] != $_SESSION["EWT_MID"] 
																		AND $row_event[person_id] != $_SESSION["EWT_MID"]){ 
																		$chk_num_rows = false;
																	}else{
																	   $chk_num_rows = true;
																	}
																	if((($row_event[event_show_end] >= $date2) || !isset($row_event[event_show_end]) || $row_event[event_show_end] == "0000-00-00") ){
																		if( ( $row_event[event_show_start] <= $date1  ||  !isset($row_event[event_show_start]) || $row_event[event_show_start] == "0000-00-00" ) ){
																				$chk_num_rows = true;
																				$chk_num_rows2++;
																		}
																	}
												
																if($chk_num_rows ){
																		$sql_cate  = "select * from cal_color where color_id = '".$row_event['color_id']."'";
																		$result_cate = $db->query($sql_cate);
																		$row_cate = $db->db_fetch_array($result_cate);
															
         $html.= '<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#006699">
                    <tr>
                      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                          <tr>';
          $html.= '                  <td width="10" rowspan="2" bgcolor="'.$row_event['cat_color'].'">&nbsp;</td>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td height="10" valign="top"><span>';
                                    
				//$html = "";
				$start_time = explode(':', $row_event['event_time_start']);
				/*if($start_time[0] > 12) {
					$start_hour = $start_time[0] -12;
					$start_ampm = 'pm';
				} else {
					$start_hour = $start_time[0];
					$start_ampm = 'am';
				}*/
				$end_time = explode(':', $row_event['event_time_end']);
				/*if($end_time[0] > 12) {
					$end_hour = $end_time[0] -12;
					$end_ampm = 'pm';
				} else {
					$end_hour = $end_time[0];
					$end_ampm = 'am';
				}*/
				$end_ampm = "น.";
				$start_ampm = "น.";
				if(($row_event['event_date_start'] != $row_event['event_date_end']) && ($row_event['event_date_end'] != '0000-00-00') && ($row_event['event_all_day'] != '1')) {
						$html .= "วันที่ ".date('j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."";
						//if($row_event['event_time_type'] == 'N') {
							//
							//$html .= sprintf('%02d', $start_hour).':'.sprintf('%02d', $start_time[1]).$start_ampm;
							$html .= "เวลา&nbsp;".sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
						//}
						$html .= "&nbsp;-&nbsp;";
						$html .= "วันที่ ".date('j ', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
						//if($row_event['event_time_type'] == 'N') {
							//$html .= '&nbsp;'.sprintf('%02d', $end_hour).':'.sprintf('%02d', $end_time[1]).$end_ampm;
							$html .= 'เวลา&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
						//}
				} else {
					//if(($row_event['event_time_start'] != $row_event['event_time_end']) && ($row_event['event_all_day'] != '1')) {
					if(($row_event['event_all_day'] != '1')) {
						$html .= "วันที่ ".date('j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."";
						//$html .= sprintf('%02d', $start_hour).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_hour).':'.sprintf('%02d', $end_time[1]).$end_ampm;
						$html .= "&nbsp;เวลา&nbsp;".sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
					} else {
						$html .= "วันที่ ".date('j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."";
						if(($row_event['event_date_start'] != $row_event['event_date_end'])) 
						$html .= " - วันที่ ".date('j ', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
						$html .= " All Day Event";
					}
				}
			$html.= 	'</span></td>';
                                  
							   		$sql_category = "select cat_name from cal_category where cat_id = '$row_event[cat_id]' ";
									$query_cat = $db->query($sql_category);
									$cat_name = $db->db_fetch_array($query_cat);
							  
            $html.= '     </tr>
                                <tr>
                                  <td height="10" valign="top"><a href="javascript:void(0);" onClick="window.open(\'calendar_event_view.php?event_id='.$row_event['event_id'].'&ref=yes\',\'\',\'width=800 , height=580, scrollbars=1,resizable = 1\');"><span style="color:#0000FF"  onMouseOver="this.style.color=\'#FF0000\'" onMouseOut = "this.style.color=\'#0000FF\'" >'.nl2br($row_event['event_title']).'</span></a></td>
                                  </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>';
                	}
				}//end while
			}
			if($chk_num_rows2==0 && $num_row_event==0){
				$html.='<tr>
						  <td height="35" valign="middle" align = "center"> 
						  <table height="100%" width="100%" cellpadding="3" cellspacing="1" bgcolor="#999999"><tr>
						  <td height="20" valign="middle" style="color:#FF0000" align = "center"  bgcolor="#FFFFFF"> ไม่มีกิจกรรม </td>
						  </tr></table> 
						  </td>
						  </tr>
						  ';
			}
															
             $html.= ' </td>
            </tr>
          </table>';
		  return $html;
	}
?>
